<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-dictionary
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-dictionary
 * @version 0.3.0
 */

namespace cinghie\dictionary;

use Yii;
use cinghie\dictionary\models\Import;
use cinghie\dictionary\models\Keys;
use cinghie\dictionary\models\Plist;
use cinghie\dictionary\models\Values;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\db\ActiveRecord;

/**
 * Bootstrap class
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @var array
     */
    private $_modelMap = [
        'Import' => Import::class,
        'Keys' => Keys::class,
        'Plist' => Plist::class,
        'Values' => Values::class,
    ];

	/**
	 * @param Application $app
	 */
    public function bootstrap($app)
    {
        /**
         * @var Module $module
         * @var ActiveRecord $modelName
         */
        if ($app->hasModule('dictionary') && ($module = $app->getModule('dictionary')) instanceof Module)
        {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);

            foreach ($this->_modelMap as $name => $definition)
            {
                $class = "cinghie\\dictionary\\models\\" . $name;

                Yii::$container->set($class, $definition);
                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;

                if (in_array($name,['Import','Keys','Plist','Values']))
                {
                    Yii::$container->set($name . 'Query', function () use ($modelName) {
                        return $modelName::find();
                    });
                }
            }
        }
    }
}
