<?php

/* @var $this yii\web\View */
/* @var $model cinghie\dictionary\models\Keys */

$this->title = Yii::t('dictionary', 'Update Keys: {name}', [
    'name' => $model->id,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('dictionary', 'Keys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('dictionary', 'Update');

?>

<div class="keys-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
