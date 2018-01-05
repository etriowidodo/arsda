<?php
/**
 * Created by PhpStorm.
 * User: rio
 * Date: 09/09/15
 * Time: 11:42
 */

namespace app\components;


use app\models\Menu;

class MenuHelper
{
    public static function getMenu()
    {
        $result = static::getMenuRecrusive();
        return $result;
    }

    private static function getMenuRecrusive()
    {

        $items = Menu::find()
            ->asArray()
            ->all();

        $result = [];

        foreach ($items as $item) {
            $result[] = [
                'label' => $item['name'],
                'url' => ['#'],
                'items' => $item['id'],
                '<li class="divider"></li>',
            ];
        }
        return $result;
    }
}