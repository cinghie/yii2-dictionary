<?php

/* @var $this yii\web\View */
/* @var $model cinghie\dictionary\models\Keys */

$this->title = Yii::t('dictionary', 'Create Keys');
$this->params['breadcrumbs'][] = ['label' => Yii::t('dictionary', 'Keys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="keys-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
