<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;

$this->title = Yii::t('onyourown','Import');
$this->params['breadcrumbs'][] = ['label' => Yii::t('onyourown', 'POI'), 'url' => ['/onyourown/items/index']];
$this->params['breadcrumbs'][] = $this->title;

// Render Yii2-onyourown Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-dictionary/views/default/_menu.php');

?>

<div class="key-import">

	<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

		<div class="row">

			<div class="col-md-6">

				<div class="box box-primary">

					<div class="box-body">

						<?php
                            echo '<h3>'.Yii::t('dictionary','Import Keys').'</h3>';
                            echo '<div class="well well-small">';
                            echo $form->field($model, 'importKeys')->widget(FileInput::class, [
                                    'options' => [
                                        'accept' => 'text/csv'
                                    ],
                                    'pluginOptions' => [
                                        'showPreview' => false,
                                        'showCaption' => false,
                                        'elCaptionText' => '#customCaption'
                                    ]
                                ])->label(false);
                            echo '</div>';
						?>

					</div>

				</div>

			</div>

		</div>

	<?php ActiveForm::end(); ?>

</div>