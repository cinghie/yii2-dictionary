# Yii2 Dictionary
Yii2 Dictionary to create, manage, and delete Multilanguage Dictionary in a Yii2 site.

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

Configuration
-----------------

### Update yii2 dictionary database schema

Make sure that you have properly configured `db` application component.  
Run the following command:
```
$ php yii migrate/up --migrationPath=@vendor/cinghie/yii2-dictionary/migrations
```