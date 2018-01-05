<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\VDugaanPelanggaranIndex;
use yii\data\SqlDataProvider;

/**
 * DugaanPelanggaranSearch represents the model behind the search form about `app\models\DugaanPelanggaran`.
 */
class VDugaanPelanggaranIndexSearch extends VDugaanPelanggaranIndex
{
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['id_register', 'wilayah', 'inspektur', 'sumber_dugaan', 'sumber_pelapor', 'status', 'created_by', 'updated_by'], 'integer'],
            [['tgl_dugaan', 'terlapor', 'id_register', 'no_register', 'inst_nama', 'inst_satkerkd', 'status'], 'safe'],
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

        public function searchIndex($params)
    {
        $query = VDugaanPelanggaranIndex::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
			'pageSize' => 3,
		],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

         $query->andFilterWhere(['like', 'no_register', $this->no_register])
            ->andFilterWhere(['like', 'terlapor', $params['terlapor']]);
         if($this->tgl_dugaan <> ""){
           $query->andFilterWhere(['tgl_dugaan'=> date('Y-m-d',strtotime($this->tgl_dugaan))]);
         }
         
         if($this->inst_satkerkd <> '00'){
            $query->andFilterWhere(['inst_satkerkd'=> $this->inst_satkerkd]);
         }
        // print_r($query);
        return $dataProvider;
    }
    
  
}
                                   