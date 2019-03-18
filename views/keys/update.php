<?php

/* @var $this yii\web\View */
/* @var $model cinghie\dictionary\models\Keys */

$this->title = Yii::t('dictionary', 'Update Keys').': '.$model->key;

$this->params['breadcrumbs'][] = ['label' => Yii::t('dictionary', 'Dictionary'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('traits', 'Update');

?>

<div class="keys-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
