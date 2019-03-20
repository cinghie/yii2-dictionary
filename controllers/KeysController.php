<?php

namespace cinghie\dictionary\controllers;

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
	    	var_dump($post); exit();
	    	
		    if ($model->save())
		    {
			    // Set Success Message
			    Yii::$app->session->setFlash('success', Yii::t('articles', 'Item has been created!'));

		        return $this->redirect(['view', 'id' => $model->id]);
	        }

		    // Set Error Message
		    Yii::$app->session->setFlash('error', Yii::t('dictionary', var_dump($model->errors)));
		    Yii::$app->session->setFlash('error', Yii::t('dictionary', 'Word could not be saved!'));

		    return $this->render('index');
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
        	if($model->save()) {
		        return $this->redirect(['view', 'id' => $model->id]);
	        }

	        return $this->render('index');
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
