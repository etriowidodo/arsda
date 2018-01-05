<?php

namespace app\modules\datun\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\modules\datun\models\Menu as MenuModel;

/**
 * Menu represents the model behind the search form about [[\mdm\admin\models\Menu]].
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Menu extends MenuModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'order'], 'integer'],
            [['name', 'route', 'parent_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Searching menu
     * @param  array $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
		$query = MenuModel::find()
            ->from(MenuModel::tableName() . ' t')
            ->joinWith(['menuParent' => function ($q) {
            $q->from(MenuModel::tableName() . ' parent');
        }]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $sort = $dataProvider->getSort();
        $sort->attributes['menuParent.name'] = [
            'asc' => ['parent.name' => SORT_ASC],
            'desc' => ['parent.name' => SORT_DESC],
            'label' => 'parent',
        ];
        $sort->attributes['order'] = [
            'asc' => ['parent.order' => SORT_ASC, 't.order' => SORT_ASC],
            'desc' => ['parent.order' => SORT_DESC, 't.order' => SORT_DESC],
            'label' => 'order',
        ];
        $sort->defaultOrder = ['menuParent.name' => SORT_ASC];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            't.id' => $this->id,
            't.parent' => $this->parent,
        ]);

        $query->andFilterWhere(['like', 'lower(t.name)', strtolower($this->name)])
            ->andFilterWhere(['like', 't.route', $this->route])
            ->andFilterWhere(['like', 'lower(parent.name)', strtolower($this->parent_name)]);

        return $dataProvider;
    }

    public function searchCustom($get)
    {
		$module = htmlspecialchars($get['q1'], ENT_QUOTES);
		$sql = "
			WITH RECURSIVE menu_tree(id, name, parent, depth, path, route, urut, data, module, tipe_menu) AS (
				select tn.id, tn.name, tn.parent, 1::INT as depth, lpad(tn.order::TEXT,2,'0')||'.'||tn.id::TEXT as path, 
				tn.route, tn.order, tn.data, tn.module, tn.tipe_menu 
				from public.menu tn 
				where tn.module = '".$module."' and tn.parent is null
				UNION ALL
				select c.id, c.name, c.parent, p.depth + 1 AS depth, (p.path || '->' || lpad(c.order::TEXT,2,'0')||'.'||c.id::TEXT), 
				c.route, c.order, c.data, c.module, c.tipe_menu 
				FROM menu_tree p join public.menu c on c.parent = p.id
			)                                                                
			select a.*, case when b.jum is null then 'file' else 'folder' end as tipe from menu_tree a 
			left join (select count(*) as jum , parent from public.menu where module = '".$module."' group by parent) b on a.id = b.parent
			order by path";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => false,
        ]);

        return $dataProvider;
    }

    public function getMenu($post)
    {
		$module = htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql = "
			WITH RECURSIVE menu_tree(id, name, parent, depth, path, route, urut, data, module, tipe_menu, tree_menu) AS (
				select tn.id, tn.name, tn.parent, 1::INT as depth, lpad(tn.order::TEXT,2,'0')||'.'||tn.id::TEXT as path, 
				tn.route, tn.order, tn.data, tn.module, tn.tipe_menu, tn.id::TEXT as tree_menu 
				from public.menu tn 
				where tn.module = '".$module."' and tn.parent is null
				UNION ALL
				select c.id, c.name, c.parent, p.depth + 1 AS depth, (p.path || '->' || lpad(c.order::TEXT,2,'0')||'.'||c.id::TEXT), 
				c.route, c.order, c.data, c.module, c.tipe_menu, (p.tree_menu||'.'||c.id::TEXT) 
				FROM menu_tree p join public.menu c on c.parent = p.id
			)                                                                
			select a.*, case when b.jum is null then 'file' else 'folder' end as tipe from menu_tree a 
			left join (select count(*) as jum , parent from public.menu where module = '".$module."' group by parent) b on a.id = b.parent
			order by path";
		$kueri = $this->db->createCommand($sql)->queryAll();
        return $kueri;
    }
}
