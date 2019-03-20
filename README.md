# Yii2 Dictionary
Yii2 Dictionary to create, manage, and delete Multilanguage Dictionary in a Yii2 site.

You can create a dictionary with key/value: for each key is possible to associate a translation to each language set on config

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
	'languages' => [
		"it-IT" => "it-IT",
		"en-GB" => "en-GB",
		"es-ES"  => "es-ES",
		"fr-FR"  => "fr-FR",
		"de-DE"  => "de-DE",
		"ch-CN"  => "ch-CN",
		"pr-PR"  => "pr-PR",
		"ru-RU"  => "ru-RU",
	],
	'showTitles' => false
],
```

Set all language in Tag mode