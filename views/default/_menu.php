<?php

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
	'options' => [
		'class' => 'nav-tabs',
		'style' => 'margin-bottom: 15px',
	],
	'items' => [
		[
			'label'   => Yii::t('dictionary', 'Dictionary'),
			'url'     => ['/dictionary/keys/index'],
		],
		[
			'label'   => Yii::t('traits', 'Import'),
			'url'     => ['/dictionary/keys/import'],
		],
	],
]) ?>