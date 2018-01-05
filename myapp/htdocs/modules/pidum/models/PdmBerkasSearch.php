<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBerkas;

/**
 * PdmBerkasSearch represents the model behind the search form about `app\modules\pidum\models\PdmBerkas`.
 */
class PdmBerkasSearch extends PdmBerkas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_berkas', 'id_perkara', 'tgl_terima'], 'safe'],
            [['id_statusberkas'], 'integer'],
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
    public function search($id_perkara,$params)
    {
        $query = PdmBerkas::find();

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
            'tgl_terima' => $this->tgl_terima,
            'id_statusberkas' => $this->id_statusberkas,
			'id_perkara' => $this->id_perkara,
        ]);

        $query->andFilterWhere(['like', 'id_berkas', $this->id_berkas])
		  ->andFilterWhere(['!=', 'flag', 3])
   
		            ->andFilterWhere(['=', 'id_perkara', $id_perkara]);
//var_dump($dataProvider);exit;
        return $dataProvider;
    }
	 public function searchTersangka($id_perkara,$params){
        $query = new \yii\db\Query;

		$query->select (['p24.id_ms_hasil_berkas','p24.pendapat as pendapat','berkas.tgl_pengiriman','berkas.id_berkas as id_berkas',"string_agg(tersangka.nama,' ') as nama","string_agg(berkas.no_pengiriman,' ') as no_pengiriman"])
		->from(["pidum.pdm_berkas berkas","pidum.pdm_tahanan_penyidik tsk","pidum.ms_tersangka tersangka"])
		->where("tsk.id_tersangka = tersangka.id_tersangka
AND berkas.id_perkara = '".$id_perkara."'
AND tsk.id_berkas = berkas.id_berkas
AND tsk.id_tersangka = tersangka.id_tersangka
AND tsk.id_perkara = berkas.id_perkara
AND berkas.FLAG != '3'
group by berkas.id_berkas")
->all();
     
 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
				
            return $dataProvider;
        }
 $query->distinct = true;
  
        return $dataProvider;
    }
	
	 public function searchTersangka2($id_perkara,$params){
       $query = new \yii\db\Query;

$query->select (['p24.id_ms_hasil_berkas','p24.pendapat as pendapat','berkas.id_berkas AS id_berkas','berkas.tgl_pengiriman AS tgl_pengiriman','p24.id_p24',"string_agg(berkas.no_pengiriman,' ') AS no_pengiriman","string_agg(tersangka.nama,' ') as nama"])
		->from('pidum.pdm_berkas berkas')
		->join('LEFT JOIN', 'pidum.pdm_p24 p24', 'berkas.id_berkas = p24.id_berkas AND berkas.id_perkara = p24.id_perkara')
		->join('LEFT JOIN', 'pidum.pdm_tahanan_penyidik tsk', 'tsk.id_perkara=berkas.id_perkara AND tsk.id_berkas=berkas.id_berkas')
		->join('LEFT JOIN', 'pidum.ms_tersangka tersangka', 'tersangka.id_tersangka=tsk.id_tersangka')			
		->where("berkas.id_perkara = '".$id_perkara."'
and berkas.flag !='3'
GROUP BY
berkas.id_berkas,p24.id_p24
order by
berkas.id_berkas asc")
->all();
      
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
				
            return $dataProvider;
        }
 $query->distinct = true;
      

        return $dataProvider;
    }
	
	 public function searchTersangka3($id_perkara,$params){
       $query = new \yii\db\Query;

$query->select (["to_char(berkas.tgl_terima,'dd-mm-yyyy') as tglterima",'berkas.id_berkas AS id_berkas',"to_char(berkas.tgl_pengiriman,'dd-mm-yyyy') AS tgl_pengiriman",'berkas.no_pengiriman AS no_pengiriman',"string_agg(tersangka.nama,', ') as nama"])
		->from('pidum.pdm_berkas berkas')
		->join('LEFT JOIN', 'pidum.pdm_tahanan_penyidik tsk', 'tsk.id_perkara=berkas.id_perkara AND tsk.id_berkas=berkas.id_berkas')
		->join('LEFT JOIN', 'pidum.ms_tersangka tersangka', 'tersangka.id_tersangka=tsk.id_tersangka')			
		->where("berkas.id_perkara = '".$id_perkara."'
and berkas.flag !='3'
GROUP BY
berkas.id_berkas
order by
berkas.id_berkas asc")
->all();

   
 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
				
            return $dataProvider;
        }
 $query->distinct = true;
        

        return $dataProvider;
    }
}
