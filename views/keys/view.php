<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model cinghie\dictionary\models\Keys */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('dictionary', 'Dictionary'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="keys-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'key',
        ],
    ]) ?>

</div>
