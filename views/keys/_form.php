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

    <div class="row">

        <div class="col-md-4">

	        <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
