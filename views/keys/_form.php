<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model cinghie\dictionary\models\Keys */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(); ?>

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


        <div class="row">

            <div class="col-md-4">

                <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

            </div>

            <?php foreach(Yii::$app->controller->module->languages as $langTag): ?>

                <div class="col-md-4">

                    <?php
                        $lang = substr($langTag,0,2);
                        $valueName = 'value_'.$lang;
                    ?>

                    <div class="form-group field-keys-key">
                        <label class="control-label" for="keys-key">
                            <?= Yii::t('traits','Translation') ?> <?= $langTag ?>
                        </label>
                        <?= $model->getTranslationInput($valueName,$lang) ?>
                    </div>

                </div>

            <?php endforeach ?>

        </div>

    </div>

<?php ActiveForm::end() ?>
