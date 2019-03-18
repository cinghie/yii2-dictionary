<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model cinghie\dictionary\models\Keys */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">

    <div class="col-md-6">



    </div>

    <div class="col-md-6">

		<?= $model->getExitButton() ?>

		<?= $model->getCancelButton() ?>

		<?= $model->getSaveButton() ?>

    </div>

</div>

<div class="keys-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('dictionary', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
