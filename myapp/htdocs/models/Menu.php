<?php
namespace app\models;
 
use Yii;
 
class Menu extends \kartik\tree\models\Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }    
    
    /**
     * Override isDisabled method if you need as shown in the  
     * example below. You can override similarly other methods
     * like isActive, isMovable etc.
     */
    public function isDisabled()
    {
        if (Yii::$app->user->id !== 'admin') {
            return true;
        }
        return parent::isDisabled();
    }
}