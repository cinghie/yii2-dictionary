<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-dictionary
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-dictionary
 * @version 0.3.0
 */

namespace cinghie\dictionary\controllers;

use CFPropertyList\IOException;
use Throwable;
use Yii;
use cinghie\dictionary\models\Keys;
use cinghie\dictionary\models\KeysSearch;
use cinghie\dictionary\models\Import;
use cinghie\dictionary\models\Plist;
use cinghie\dictionary\models\Values;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * KeysController implements the CRUD actions for Keys model.
 */
class KeysController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
	        'access' => [
		        'class' => AccessControl::class,
		        'rules' => [
			        [
				        'allow' => true,
				        'actions' => ['index','create','update','view','import','download','delete'],
				        'roles' => $this->module->dictionaryRoles
			        ],
		        ]
	        ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Keys models
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KeysSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Keys model
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Keys model
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Keys();
        $post  = Yii::$app->request->post();

	    if ($model->load($post))
	    {
		    if ($model->save())
		    {
		    	foreach (Yii::$app->controller->module->languages as $langTag)
		    	{
				    $lang = substr($langTag,0,2);
				    $valueName = 'value_'.$lang;
				    $valueTranslation = $post[$valueName];

				    $translation = new Values();
				    $translation->key_id = $model->id;
				    $translation->value = $valueTranslation;
				    $translation->lang = $lang;
				    $translation->lang_tag = $langTag;
				    $translation->save();
			    }

			    // Set Success Message
			    Yii::$app->session->setFlash('success', Yii::t('dictionary', 'Key has been created!'));

		        return $this->redirect(['update', 'id' => $model->id]);
	        }

		    // Set Error Message
		    Yii::$app->session->setFlash('error', Yii::t('dictionary', 'Key could not be saved!'));

		    return $this->render('create', [
			    'model' => $model,
		    ]);
	    }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Keys model
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post  = Yii::$app->request->post();

        if ($model->load($post))
        {
        	if($model->save())
        	{
		        foreach (Yii::$app->controller->module->languages as $langTag)
		        {
			        $lang = substr($langTag,0,2);
			        $valueName = 'value_'.$lang;
			        $valueTranslation = $post[$valueName];

			        $translationID = $model->getTranslationField('id',$lang);
			        $translation = Values::findOne($translationID);

			        if($translation) {
				        $translation->key_id = $model->id;
				        $translation->value = $valueTranslation;
				        $translation->lang = $lang;
				        $translation->lang_tag = $langTag;
				        $translation->save();
			        } else {
				        $translation = new Values();
				        $translation->key_id = $model->id;
				        $translation->value = $valueTranslation;
				        $translation->lang = $lang;
				        $translation->lang_tag = $langTag;
				        $translation->save();
			        }
		        }

		        // Set Success Message
		        Yii::$app->session->setFlash('success', Yii::t('dictionary', 'Key has been updated!'));

		        return $this->render('update', [
			        'model' => $model,
		        ]);
	        }

	        // Set Error Message
	        Yii::$app->session->setFlash('error', Yii::t('dictionary', 'Key could not be saved!'));

	        return $this->render('update', [
		        'model' => $model,
	        ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

	/**
	 * Displays import view
	 *
	 * @return mixed
	 */
	public function actionImport()
	{
		$model = new Import();
		$post  = Yii::$app->request->post();

		Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;

		if($model->load($post))
		{
			$keys = UploadedFile::getInstance($model,'importKeys');

			if ($keys !== null)
			{
				$fileName = 'Keys_'.date('Y_m_d-H_i').'.'.$keys->extension;
				$filePath = Yii::getAlias(Yii::$app->controller->module->uploadFolderPath).$fileName;
				$upload   = $keys->saveAs($filePath);

				if($upload)
				{
					$model->importKeys($filePath);

					Yii::$app->session->setFlash('success', Yii::t('traits', 'File uploaded!'));

					return $this->render('import', [
						'model' => $model,
					]);
				}

			}
		}

		return $this->render('import', [
			'model' => $model,
		]);
	}

	/**
	 * Displays import view
	 *
	 * @return mixed
	 * @throws IOException
	 * @throws NotFoundHttpException
	 */
	public function actionDownload()
	{
		$keys    = new Keys();
		$plist   = new Plist();
		$zipFile = new \ZipArchive;

		$plist_path = Yii::getAlias(Yii::$app->controller->module->plistFolderPath);
		$zipName = $plist_path.'Plist.zip';

		if(file_exists($zipName)) {
			$zipFile->open($zipName, \ZipArchive::OVERWRITE);
		} else {
			$zipFile->open($zipName, \ZipArchive::CREATE);
		}

		foreach (Yii::$app->controller->module->languages as $langTag)
		{
			$lang  = substr($langTag,0,2);
			$array = $keys::find()
			    ->select('key, value as translation')
			    ->from('{{%dictionary_keys}}')
			    ->leftJoin('{{%dictionary_values}}','{{%dictionary_keys}}.id = {{%dictionary_values}}.key_id')
				->where('lang = "'.$lang.'"')
				->orderBy('key ASC')
				->asArray()
				->all();
			$filePath = $plist::createPlistFile($array,$lang,$plist_path);
			$newFileName = substr($filePath,strrpos($filePath,'/') + 1);
			$zipFile->addFile($filePath,$newFileName);
		}

		$zipFile->close();
		$this->downloadFile($zipName);

		Yii::$app->session->setFlash('success', Yii::t('dictionary', 'Plists file dowloaded!'));

		return $this->redirect(['index']);
	}

	/**
	 * Download File
	 *
	 * @param string $filePath
	 *
	 * @return \yii\console\Response|\yii\web\Response
	 * @throws NotFoundHttpException
	 */
	protected function downloadFile($filePath)
	{
		if (file_exists($filePath))
		{
			Yii::$app->response->sendFile($filePath)->send();
			//unlink($filePath);
		}

		throw new NotFoundHttpException("{$filePath} is not found!");
	}

	/**
	 * Deletes an existing Keys model
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

    /**
     * Finds the Keys model based on its primary key value
     * If the model is not found, a 404 HTTP exception will be thrown
     *
     * @param integer $id
     *
     * @return Keys the loaded model
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Keys::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('traits', 'The requested page does not exist.'));
    }
}
