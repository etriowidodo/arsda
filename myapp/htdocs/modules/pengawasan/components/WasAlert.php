<?php
namespace app\modules\pengawasan\components;
use kartik\widgets\Growl;
use kartik\widgets\Alert;
use yii\helpers\ArrayHelper;
use yii\base\Component;
 
class WasAlert {
/**
     * @param string $title
     * @param string $body
     */
    public static function setMsg($title = 'info', $body = 'info msg')
    {
        \Yii::$app->session->setFlash($title, $body);
    }
 
    /**
     * @param array $additional the array will pass into showMsg function
     */
    public static function showFlashes($additional = [])
    {
        self::showMsg('', '', array_merge($additional, ['useSessionFlash' => true]));
    }
 
    /**
     * @param string $title
     * @param string $body
     * @param array $additional parameters which you may want to change.
     */
     public static function showMsg($title = 'info', $body = 'info msg', $additional = [])
    {
 
        $additional = ArrayHelper::merge([
            'linkUrl' => null,
            'delay' => 2000,
            'showSeparator' => true,
            'from' => 'top',
            'align' => 'right',
            'alertType' => 'Growl',
            'useSessionFlash' => false,
            'mouse_over'=>'pause',
            'timer'=>5000,
 
        ], $additional);
 
        $typeIndex = 'info';
 
        $typeArray = [
            'success' => ['type' => ['Growl'=>Growl::TYPE_SUCCESS,'Alert'=>Alert::TYPE_SUCCESS],
                'icon' => 'glyphicon glyphicon-ok-sign'],
            'info' => ['type' => ['Growl'=>Growl::TYPE_INFO,'Alert'=>Alert::TYPE_INFO],
                'icon' => 'glyphicon glyphicon-info-sign'],
            'warning' => ['type' => ['Growl'=>Growl::TYPE_WARNING,'Alert'=>Alert::TYPE_WARNING],
                'icon' => 'glyphicon glyphicon-exclamation-sign'],
            'danger' => ['type' => ['Growl'=>Growl::TYPE_DANGER,'Alert'=>Alert::TYPE_DANGER],
                'icon' => 'glyphicon glyphicon-remove-sign'],
        ];
 
        $delay = $additional['delay'];
        if ($additional['useSessionFlash']) {
            $flashes = \yii::$app->session->getAllFlashes(true);
            if ($delay == 0  and $additional['alertType']=="Alert") $delay += 2000;
            //self::dump(($flashes));
        } else {
            $flashes = [$title => $body];
        }
 
        foreach ($flashes as $title => $body) {
            $typeIndex = 'info';
            if (!empty($title)) {
                if (stristr($title, "danger") or stristr($title, "error")) {
                    $typeIndex = 'danger';
                } elseif (stristr($title, "warning")) {
                    $typeIndex = 'warning';
                } elseif (stristr($title, "success")) {
                    $typeIndex = 'success';
                } elseif (stristr($title, "info")) {
                    $typeIndex = 'info';
                };
            }
            $msgArray = [
                'type' => $typeArray[$typeIndex]['type'][$additional['alertType']],
                'title' => $title,
                'icon' => $typeArray[$typeIndex]['icon'],
                'body' => $body,
                'linkUrl' => $additional['linkUrl'],
                'showSeparator' => $additional['showSeparator'],
                'delay' => $delay,
                'pluginOptions' => [
                    'timer'=>$additional['timer'],
                    'mouse_over'=>$additional['mouse_over'],
                    'placement' => [
                        'from' => $additional['from'],
                        'align' => $additional['align'],
                    ]
                ]
            ];
            $delay += 3000;
            switch ($additional['alertType']) {
                case 'Growl':
                    echo Growl::widget($msgArray);
                    break;
                default:
                    ArrayHelper::remove($msgArray,'linkUrl');
                    ArrayHelper::remove($msgArray,'pluginOptions');
                    echo Alert::widget($msgArray);
                    break;
            }
        }
 
    }
    
   
}