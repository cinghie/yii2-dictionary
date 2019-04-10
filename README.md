# Yii2 Dictionary

![Latest Stable Version](https://img.shields.io/packagist/v/cinghie/yii2-dictionary.svg)
![License](https://img.shields.io/packagist/l/cinghie/yii2-dictionary.svg)
![Latest Release Date](https://img.shields.io/github/release-date/cinghie/yii2-dictionary.svg)
![Latest Commit](https://img.shields.io/github/last-commit/cinghie/yii2-dictionary.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/cinghie/yii2-dictionary.svg)](https://packagist.org/packages/cinghie/yii2-dictionary)

Yii2 Dictionary to create, manage, and delete Multilanguage Dictionary in a Yii2 site.

Features
-----------------

 - Create a dictionary with key/value: for each key is possible to associate a translation to each language set on config
 - Import from CSV
 - Download as Plist

Installation
-----------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require cinghie/yii2-dictionary "*"
```

or add

```
"cinghie/yii2-dictionary": "*"
```

Create database schema
-----------------

Run the following command:

```
$ php yii migrate/up --migrationPath=@vendor/cinghie/yii2-dictionary/migrations
```

Configuration
-----------------

Set on your configuration:

```
// Yii2 Dictionary
'dictionary' => [
	'class' => 'cinghie\dictionary\Dictionary',
	'dictionaryRoles' => ['admin'];
	'languages' => [
		'it-IT' => 'it-IT',
		'en-GB' => 'en-GB',
		'es-ES' => 'es-ES',
		'fr-FR' => 'fr-FR',
		'de-DE' => 'de-DE',
		'ch-CN' => 'ch-CN',
		'pr-PR' => 'pr-PR',
		'ru-RU' => 'ru-RU',
	],
	'showPlistDownload' => true,
	'showTitles' => false,
	'plistFolderPath' => '@webroot/dictionary/plist/';
	'uploadFolderPath' => '@webroot/dictionary/csv/'
	'uploadMaxFileSize' => 5242880
],
```

Set all language in Tag mode
