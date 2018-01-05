<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\LWas2;
use yii\db\Query;

/**
 * LWas2Search represents the model behind the search form about `app\modules\pengawasan\models\LWas2`.
 */
class LWas2Search extends LWas2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_l_was_2', 'id_register', 'inst_satkerkd', 'tgl', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['flag', 'created_by', 'updated_by'], 'integer'],
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
        $query = LWas2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl' => $this->tgl,
            'flag' => $this->flag,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_l_was_2', $this->id_l_was_2])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
    
    
     public function searchBaWas3($id_register,$id_terlapor)
    {
        $query = new Query;
        $query->select(" b.id_ba_was_3_keterangan, a.sebagai ,a.id_peran , b.isi ")
                ->from('was.ba_was_3 a')
                ->join('inner join','was.ba_was_3_keterangan b','(a.id_ba_was_3=b.id_ba_was_3)')
                ->where("a.sebagai = '3' and a.id_register = :id and a.id_peran = :idPeran",[":id"=>$id_register,":idPeran"=>$id_terlapor]);
        

       $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        

      
        return $dataProvider;
    }
    
   
}
