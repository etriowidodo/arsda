<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmTahapDua;
use yii\db\Query;

/**
 * PdmTahapDuaSearch represents the model behind the search form about `app\modules\pidum\models\PdmTahapDua`.
 */
class PdmTahapDuaSearch extends PdmTahapDua
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'id_berkas', 'no_pengiriman', 'tgl_pengiriman', 'tgl_terima', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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
       /* $query = PdmTahapDua::find();
        $query->where = "pdm_tahap_dua.flag != '3'";
        $query->where = "pdm_tahap_dua.id_perkara = '".$id_perkara."'";
       */ 
        $query = new Query();
        $query->select('a.no_pengiriman,a.tgl_pengiriman,a.tgl_terima,a.no_register_perkara,id_berkas')
              ->from('pidum.pdm_tahap_dua a');
              //->where('a.id_berkas=:id_berkas AND a.flag<>:flag',[':id_perkara'=>$id_perkara,':flag'=>'3']);
            
        // var_dump($query);exit();
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
            'tgl_pengiriman' => $this->tgl_pengiriman,
            'tgl_terima' => $this->tgl_terima,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            // ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_pengiriman', $this->no_pengiriman])
            //->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

    
}
