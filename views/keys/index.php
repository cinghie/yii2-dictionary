<?php

use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel cinghie\dictionary\models\KeysSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('dictionary', 'Dictionary');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="keys-index">

	<?php if(Yii::$app->getModule('dictionary')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
	<?php endif ?>

    <?= GridView::widget([
	    'dataProvider'=> $dataProvider,
	    'filterModel' => $searchModel,
	    'containerOptions' => [
		    'class' => 'dictionary-keys-pjax-container'
	    ],
	    'pjax' => true,
	    'pjaxSettings'=>[
		    'neverTimeout' => true,
	    ],
        'columns' => [
	        [
		        'class' => CheckboxColumn::class
	        ],
	        [
		        'attribute' => 'key',
		        'format' => 'html',
		        'hAlign' => 'center',
		        'value' => function ($model) {
			        $url = urldecode(Url::toRoute(['/dictionary/keys/update',
				        'id' => $model->id
			        ]));
			        return Html::a($model->key,$url);
		        }
	        ],
	        [
		        'attribute' => 'id',
		        'width' => '8%',
		        'hAlign' => 'center',
	        ]
        ],
	    'responsive' => true,
	    'responsiveWrap' => true,
	    'hover' => true,
	    'panel' => [
		    'heading' => '<h3 class="panel-title"><i class="fa fa-book"></i></h3>',
		    'type' => 'success',
	    ],
    ]) ?>

</div>
