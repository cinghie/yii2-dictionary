<?php

use kartik\grid\GridView;
use kartik\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel cinghie\dictionary\models\KeysSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('dictionary', 'Dictionary');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">

    <!-- action menu -->
    <div class="col-md-6">



    </div>

    <!-- action buttons -->
    <div class="col-md-6">

		<?= $searchModel->getCreateButton() ?>

    </div>

</div>

<div class="separator"></div>

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
        'columns' => $searchModel->getGridColumns(),
	    'responsive' => true,
	    'responsiveWrap' => true,
	    'hover' => true,
	    'panel' => [
		    'heading' => '<h3 class="panel-title"><i class="fa fa-book"></i></h3>',
		    'type' => 'success',
	    ],
    ]) ?>

</div>
