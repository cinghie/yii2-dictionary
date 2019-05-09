<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-dictionary
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-dictionary
 * @version 0.3.1
 */

namespace cinghie\dictionary\filters;

use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\web\NotFoundHttpException;

/**
 * FrontendFilter class
 */
class FrontendFilter extends ActionFilter
{
    /**
     * @var array
     */
    public $controllers = ['index','create','update','view','import','delete'];

    /**
     * @param Action $action
     *
     * @return bool
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->controller->action->id, $this->controllers, true)) {
            throw new NotFoundHttpException(Yii::t('traits','Page not found'));
        }

        return true;
    }
}
