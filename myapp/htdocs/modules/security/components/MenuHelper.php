<?php

namespace mdm\admin\components;

use Yii;
use yii\caching\TagDependency;
use mdm\admin\models\Menu;

/**
 * MenuHelper used to generate menu depend of user role.
 * Usage
 * 
 * ~~~
 * use mdm\admin\components\MenuHelper;
 * use yii\bootstrap\Nav;
 *
 * echo Nav::widget([
 *    'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id)
 * ]);
 * ~~~
 * 
 * To reformat returned, provide callback to method.
 * 
 * ~~~
 * $callback = function ($menu) {
 *    $data = eval($menu['data']);
 *    return [
 *        'label' => $menu['name'],
 *        'url' => [$menu['route']],
 *        'options' => $data,
 *        'items' => $menu['children']
 *        ]
 *    ]
 * }
 *
 * $items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);
 * ~~~
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class MenuHelper
{
    const CACHE_TAG = 'mdm.admin.menu';

    /**
     * Use to get assigned menu of user.
     * @param mixed $userId
     * @param integer $root
     * @param \Closure $callback use to reformat output.
     * callback should have format like
     * 
     * ~~~
     * function ($menu) {
     *    return [
     *        'label' => $menu['name'],
     *        'url' => [$menu['route']],
     *        'options' => $data,
     *        'items' => $menu['children']
     *        ]
     *    ]
     * }
     * ~~~
     * @param boolean  $refresh
     * @return array
     */
    public static function getAssignedMenu($userId, $root = null, $callback = null, $refresh = false ,$modules = null,$id = null)
    {
   //     public static function getAssignedMenu($userId, $root = null, $callback = null, $refresh = false)
   // {
        $config = Configs::instance();

        /* @var $manager \yii\rbac\BaseManager */
        $manager = Yii::$app->getAuthManager();
      //  $id = 0;
        if($modules != null){
         if(substr($modules,-1) == "2"){
           
              $menus = Menu::find()->where(" 
id = ( 
select parent from menu where module='".substr($modules,0,-1)."' and \"order\" = 1 and parent is not null)
or id  in (
 

select id from menu where module='".substr($modules,0,-1)."' and parent =  (select parent from menu where module='".substr($modules,0,-1)."' and \"order\" = 1 and parent is not null) 

)                  

")->asArray()->indexBy('id')->all();   
             
         }elseif(substr($modules,-1) == "3"){
             $menus = Menu::find()->where("module = 'PIDUM' and \"order\" = 1")->asArray()->indexBy('id')->all();
         }else if($modules == "PENGAWASAN"){
            $lastForm = \app\modules\pengawasan\models\DugaanPelanggaran::find()->where('id_register = :id',[":id"=>$id])->one();
            $lastMenu = \app\modules\pengawasan\models\NextStatus::find()->select('coalesce (max(status_akhir),"status_awal") as id_akhir')->where('status_awal = :idAwal', [":idAwal"=>$lastForm->status])->groupBy('status_awal')->asArray()->one();
            $lastOrder = Menu::find()->where('id = :id',[":id"=>$lastMenu['id_akhir']])->asArray()->one();
            
         /*   $menus = Menu::find()->select('id,name,par1ent,route,"order"')->where(" (\"order\" <= :order and module='".$modules."' and parent is not null) or id in  (
select distinct parent from menu where \"order\" <= :order and module='".$modules."' and parent is not null) ",[":order"=>$lastOrder['order']])->asArray()->indexBy('id')->all();*/
        /*   $menus = Menu::find()->select('*')->from(" (
 SELECT \"id\", \"name\", \"parent\", \"route\", \"order\" FROM public.\"menu\" WHERE (\"order\" <= ".$lastOrder['order']." and module='PENGAWASAN' and parent is not null) or id in (
select distinct parent from menu where \"order\" <=  ".$lastOrder['order']."  and module='PENGAWASAN' and parent is not null) 
union 
select \"id\", \"name\", \"parent\", coalesce(data,'') as \"route\", \"order\" from menu where id not in (
SELECT \"id\" FROM public.\"menu\" WHERE (\"order\" <=  ".$lastOrder['order']."  and module='PENGAWASAN' and parent is not null) or id in (
select distinct parent from menu where \"order\" <=  ".$lastOrder['order']."  and module='PENGAWASAN' and parent is not null) ) and module='PENGAWASAN')
a order")->u->asArray()->indexBy('id')->all();*/
           $menus = Menu::findBySql("SELECT id, name, \"parent\", \"route\", \"order\" FROM public.menu where (\"order\" <= :order and module=:modules and parent is not null) or id in (
select distinct parent from menu where \"order\" <= :order and module=:modules and parent is not null) 
union 
select id, name, \"parent\", '#' as route, \"order\" from public.menu where id not in (
SELECT id FROM public.menu WHERE (\"order\" <= :order and module=:modules and parent is not null) or id in (
select distinct parent from menu where \"order\" <= :order and module=:modules and parent is not null) ) and module=:modules", [":order"=>$lastOrder['order'],":modules"=>$modules])->asArray()->indexBy('id')->all();
         //   $menus = Menu::find()->where(['=', 'module', $modules])->asArray()->indexBy('id')->all();
      
         }
         else{
            $menus = Menu::find()->where(['=', 'module', $modules])->asArray()->indexBy('id')->all();
      
         }
        }else{
           $menus = Menu::find()->asArray()->indexBy('id')->all();
        }
        $key = [__METHOD__, $userId, $manager->defaultRoles];
        $cache = $config->cache;

        if ($refresh || $cache === null || ($assigned = $cache->get($key)) === false) {
            $routes = $filter1 = $filter2 = [];
            if ($userId !== null) {
                foreach ($manager->getPermissionsByUser($userId) as $name => $value) {
                    if ($name[0] === '/') {
                        if (substr($name, -2) === '/*') {
                            $name = substr($name, 0, -1);
                        }
                        $routes[] = $name;
                    }
                }
            }
            foreach ($manager->defaultRoles as $role) {
                foreach ($manager->getPermissionsByRole($role) as $name => $value) {
                    if ($name[0] === '/') {
                        if (substr($name, -2) === '/*') {
                            $name = substr($name, 0, -1);
                        }
                        $routes[] = $name;
                    }
                }
            }
            $routes = array_unique($routes);
            sort($routes);
            $prefix = '\\';
            foreach ($routes as $route) {
                if (strpos($route, $prefix) !== 0) {
                    if (substr($route, -1) === '/') {
                        $prefix = $route;
                        $filter1[] = $route . '%';
                    } else {
                        $filter2[] = $route;
                    }
                }
            }
            $assigned = [];
            $query = Menu::find()->select(['id'])->asArray();
            if (count($filter2)) {
                $assigned = $query->where(['route' => $filter2])->column();
            }
            if (count($filter1)) {
                $query->where('route like :filter');
                foreach ($filter1 as $filter) {
                    $assigned = array_merge($assigned, $query->params([':filter' => $filter])->column());
                }
            }
            $assigned = static::requiredParent($assigned, $menus);
            if ($cache !== null) {
                $cache->set($key, $assigned, $config->cacheDuration, new TagDependency([
                    'tags' => self::CACHE_TAG
                ]));
            }
        }

        $key = [__METHOD__, $assigned, $root];
        if ($refresh || $callback !== null || $cache === null || (($result = $cache->get($key)) === false)) {
            $result = static::normalizeMenu($assigned, $menus, $callback, $root);
            if ($cache !== null && $callback === null) {
                $cache->set($key, $result, $config->cacheDuration, new TagDependency([
                    'tags' => self::CACHE_TAG
                ]));
            }
        }

        return $result;
    }

    /**
     * Ensure all item menu has parent.
     * @param  array $assigned
     * @param  array $menus
     * @return array
     */
    private static function requiredParent($assigned, &$menus)
    {
        $l = count($assigned);
        for ($i = 0; $i < $l; $i++) {
            $id = $assigned[$i];
            $parent_id = $menus[$id]['parent'];
            if ($parent_id !== null && !in_array($parent_id, $assigned)) {
                $assigned[$l++] = $parent_id;
            }
        }

        return $assigned;
    }

    /**
     * Parse route
     * @param  string $route
     * @return mixed
     */
    public static function parseRoute($route)
    {
        if (!empty($route)) {
            $url = [];
            $r = explode('&', $route);
            $url[0] = $r[0];
            unset($r[0]);
            foreach ($r as $part) {
                $part = explode('=', $part);
                $url[$part[0]] = isset($part[1]) ? $part[1] : '';
            }

            return $url;
        }

        return '#';
    }

    /**
     * Normalize menu
     * @param  array $assigned
     * @param  array $menus
     * @param  Closure $callback
     * @param  integer $parent
     * @return array
     */
    private static function normalizeMenu(&$assigned, &$menus, $callback, $parent = null)
    {
        $result = [];
        $order = [];
        foreach ($assigned as $id) {
            $menu = $menus[$id];
            if ($menu['parent'] == $parent) {
                $menu['children'] = static::normalizeMenu($assigned, $menus, $callback, $id);
                if ($callback !== null) {
                    $item = call_user_func($callback, $menu);
                } else {
                    $item = [
                        'label' => $menu['name'],
                        'url' => static::parseRoute($menu['route']),
                    ];
                    if ($menu['children'] != []) {
                        $item['items'] = $menu['children'];
                    }
                }
                $result[] = $item;
                $order[] = $menu['order'];
            }
        }
        if ($result != []) {
            array_multisort($order, $result);
        }

        return $result;
    }

    /**
     * Use to invalidate cache.
     */
    public static function invalidate()
    {
        if (Configs::instance()->cache !== null) {
            TagDependency::invalidate(Configs::instance()->cache, self::CACHE_TAG);
        }
    }
}
