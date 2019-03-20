<?php

namespace cinghie\dictionary\controllers;

use cinghie\dictionary\models\Values;
use Throwable;
use Yii;
use cinghie\dictionary\models\Keys;
use cinghie\dictionary\models\KeysSearch;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

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
				        'actions' => ['index','create','update','view','delete'],
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
     * Lists all Keys models.
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
     * Displays a single Keys model.
     * @param integer $id
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
     * Creates a new Keys model.
     * If creation is successful, the browser will be redirected to the 'view' page.
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
     * Updates an existing Keys model.
     * If update is successful, the browser will be redirected to the 'view' page.
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
	 * Deletes an existing Keys model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
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
     * Finds the Keys model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
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
