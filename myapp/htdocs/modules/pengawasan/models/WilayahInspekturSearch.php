<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\WilayahInspektur;
use yii\data\SqlDataProvider;
use yii\db\Command;
use yii\db\Query;

/**
 * InspekturModelSearch represents the model behind the search form about `app\modules\pengawasan\models\InspekturModel`.
 */
class WilayahInspekturSearch extends WilayahInspektur
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['id_inspektur','id_kejati','id_wilayah'], 'required'],
            [['id_inspektur'], 'integer'],
            [['id_kejati','id_wilayah','cari'], 'string'],
            
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) 
    {
       /*  $query = "select a.*,b.nama_wilayah,c.nama_kejati,d.nama_inspektur from was.wilayah_inspektur a
                  inner join was.wilayah b on a.id_wilayah=b.id_wilayah
                  inner join was.kejati c on a.id_kejati=c.id_kejati
                  inner join was.inspektur d on a.id_inspektur=d.id_inspektur"; */
		$query ="select * from (
				select a.id_kejati,a.id_inspektur,a.id_wilayah, b.nama_wilayah,c.nama_kejagung_bidang as nama_kejati ,d.nama_inspektur from was.wilayah_inspektur a
				inner join was.wilayah b on a.id_wilayah=b.id_wilayah
				inner join was.kejagung_bidang c on a.id_kejati=c.id_kejagung_bidang
				inner join was.inspektur d on a.id_inspektur=d.id_inspektur where a.id_wilayah in ('0') 
				UNION 
				select a.*, b.nama_wilayah,c.nama_kejati as nama_kejati,d.nama_inspektur from was.wilayah_inspektur a
				inner join was.wilayah b on a.id_wilayah=b.id_wilayah
				inner join was.kejati c on a.id_kejati=c.id_kejati
				inner join was.inspektur d on a.id_inspektur=d.id_inspektur where a.id_wilayah in ('1')
				)z ";						
        $cari  = htmlspecialchars($_GET['WilayahInspekturSearch']['cari']); 
        if($_GET['WilayahInspekturSearch']['cari'] != ''){
         $query .="where upper(z.nama_wilayah) like '%".strtoupper($cari)."%' or upper(z.nama_kejati) like '%".strtoupper($cari)."%' 
				or upper(z.nama_inspektur) like '%".strtoupper($cari)."%'";
		}
		$query .="order by z.id_kejati";	
        $jml = yii::$app->db->createCommand(" select count(*) from (".$query.") a")->queryscalar();
        $dataProvider = new SqlDataProvider([
                'sql' => $query,
                'totalCount' => (int)$jml,
                'pagination' => [
                'pagesize'   => 10,
                ]
            ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    
}
