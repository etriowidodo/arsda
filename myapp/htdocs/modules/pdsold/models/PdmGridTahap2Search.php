<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmGridTahap2;
use yii\db\Query;

/**
 * PdmTahapDuaSearch represents the model behind the search form about `app\modules\pidum\models\PdmTahapDua`.
 */
class PdmGridTahap2Search extends PdmGridTahap2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tersangka', 'no_p16a', 'nama_jaksa', 'undang', 'pasal', 'status'], 'string'],
            [['tgl_surat'], 'safe'],
            [['no_register_perkara'], 'string', 'max' => 60],
            [['asal'], 'string', 'max' => 100],
            [['no_surat'], 'string', 'max' => 64]
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
        $query->select('*')
              ->from('pidum.vw_gridtahap2 a');
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
        $query->andFilterWhere(['like','upper(no_register_perkara)',strtoupper($this->no_register_perkara)])
            ->orFilterWhere(['like', 'upper(id_berkas)', strtoupper($this->no_register_perkara)])
            ->orFilterWhere(['like','upper(no_surat)', strtoupper($this->no_register_perkara)])
            ->orFilterWhere(['like','upper(no_p16a)', strtoupper($this->no_register_perkara)])
            ->orFilterWhere(['like','upper(tersangka)',strtoupper($this->no_register_perkara)]);

           
      if(count(explode('-',$this->no_register_perkara)) == 3){
            $query->orFilterWhere(['=', 'tgl_surat', $this->no_register_perkara ]);
          }
/*        $query->andFilterWhere([
            'tgl_pengiriman' => $this->tgl_pengiriman,
            'tgl_terima' => $this->tgl_terima,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);*/


        return $dataProvider;
    }
}
