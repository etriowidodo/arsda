<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\MsTersangka;
use yii\db\Query;
use yii\web\Session;
use yii\data\SqlDataProvider;

/**
 * MsTersangkaSearch represents the model behind the search form about `app\modules\pidum\models\MsTersangka`.
 */
class MsTersangkaSearch extends MsTersangka
{
    
    public $agama;
    public $pendidikan;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tersangka', 'id_perkara', 'tmpt_lahir', 'tgl_lahir', 'alamat', 'no_identitas', 'warganegara', 'pekerjaan', 'suku', 'nama', 'agama', 'pendidikan'], 'safe'],
            [['no_hp'], 'number'],  [['umur'], 'number'],
            [['id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan'], 'integer'],
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
	
        $query = MsTersangka::find();

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
            'tgl_lahir' => $this->tgl_lahir,
            'no_hp' => $this->no_hp,
            'id_jkl' => $this->id_jkl,
            'id_identitas' => $this->id_identitas,
            'id_agama' => $this->id_agama,
            'id_pendidikan' => $this->id_pendidikan,
        ]);

        $query->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'tmpt_lahir', $this->tmpt_lahir])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_identitas', $this->no_identitas])
            ->andFilterWhere(['like', 'warganegara', $this->warganegara])
            ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
            ->andFilterWhere(['like', 'suku', $this->suku])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
	
	
	public function searchTersangka($params)
    {
        $query = MsTersangka::find()                
                ->where(['id_perkara'=>$params]);

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
            'tgl_lahir' => $this->tgl_lahir,
            'no_hp' => $this->no_hp,
            'id_jkl' => $this->id_jkl,
            'id_identitas' => $this->id_identitas,
            'id_agama' => $this->id_agama,
            'id_pendidikan' => $this->id_pendidikan,
        ]);

       
        $query->orderBy('id_tersangka asc');

        $query->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'tmpt_lahir', $this->tmpt_lahir])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_identitas', $this->no_identitas])
            ->andFilterWhere(['like', 'warganegara', $this->warganegara])
            ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
			  
            ->andFilterWhere(['like', 'suku', $this->suku])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }


    public function searchTersangkaUnion($params)
    {
       $query = new Query;
        $session = new Session();
        $idPerkara=$session->get('id_perkara');
          
         $query = "select a.nama as nama_tersangka,a.id_tersangka,a.tmpt_lahir,a.tgl_lahir,
                   a.alamat,a.no_identitas,a.no_hp,a.warganegara,a.pekerjaan,a.suku,a.id_jkl,
                   a.id_identitas,a.id_agama,a.id_pendidikan,a.umur,a.no_urut,c.nama as nama
                    from pidum.ms_tersangka a Left Join public.ms_warganegara c on a.warganegara = c.id  where a.id_perkara = '".$idPerkara."'
                        UNION ALL
                    select a.nama as nama_tersangka,a.id_tersangka,a.tmpt_lahir,a.tgl_lahir,
                           a.alamat,a.no_identitas,a.no_hp,a.warganegara,a.pekerjaan,a.suku,a.id_jkl,
                           a.id_identitas,a.id_agama,a.id_pendidikan,a.umur,a.no_urut,c.nama as nama
                    from pidum.ms_tersangka_pt a Left Join public.ms_warganegara c on a.warganegara = c.id inner join pidum.pdm_perpanjangan_tahanan b on a.id_perpanjangan = b.id_perpanjangan where id_perkara = '".$idPerkara."'";

          $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


            $dataProvider = new SqlDataProvider([
              'sql' => $query,
              'totalCount' => (int)$jml,
              'sort' => [
                  'attributes' => [
                      'id_tersangka',
                      'nama',
                      'tmpt_lahir',
                      'tgl_lahir',
                      'alamat',
                      'no_identitas',
                      'no_hp',
                      'warganegara',
                      'pekerjaan',
                      'suku',
                      'id_jkl',
                      'id_identitas',
                      'id_agama',
                      'id_pendidikan',
                      'umur',
                      'no_urut'
                 ],
             ],
              'pagination' => [
                  'pageSize' => 10,
              ]
        ]);
        $models = $dataProvider->getModels();

        // $this->load($params);

        // if (!$this->validate()) {
        //     return $dataProvider;
        // }

        // $query->andFilterWhere([
        //     'id' => $this->id_tersangka,
           
        // ]);

        // $query->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
        //         ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
        //         ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->nama)]);
        return $dataProvider;
    }
    	
		public function searchTersangka2($params)
    {
          $query = new Query;
        $session = new Session();

        $id = $session->get('id_perkara');
        $query->select('tersangka.id_tersangka as id, tersangka.nama as nama,tsk.id_perkara')
                    ->from('pidum.ms_tersangka tersangka, pidum.pdm_tahanan_penyidik tsk')
                    ->where("tsk.id_tersangka = tersangka.id_tersangka and tsk.id_perkara = tersangka.id_perkara")
                    ->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
   
    public function searchTersangkaBerkas($id_berkas,$params)
    {
        $query = new Query;
        $session = new Session();
        $no_pengantar = PdmPengantarTahap1::find()->where(['id_berkas'=>$id_berkas])->orderBy('tgl_pengantar desc')->limit(1)->one()->no_pengantar;

        $query->select('a.*,b.nama as nama_warganegara')
                    ->from('pidum.ms_tersangka_berkas a')
                    ->join('left join','public.ms_warganegara b','a.warganegara = b.id')
                    ->where("a.id_berkas = '".$id_berkas."' and a.no_pengantar='".$no_pengantar."'")
                    ->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function searchTersangkaBa4New($no_register_perkara ,$params)
    {
        $query = new Query;
        $session = new Session();

        $query->select('a.tgl_ba4,a.no_urut_tersangka,a.nama,a.tmpt_lahir, a.no_sp_penyidik, tgl_sp_penyidik, (select count(b.*) from pidum.pdm_t7 b where a.no_register_perkara=b.no_register_perkara and a.no_urut_tersangka = b.no_urut_tersangka) as ada')
                    ->from('pidum.pdm_ba4_tersangka a')                    
                    ->where(" a.no_register_perkara = '".$no_register_perkara."'")
                    ->all();
        //echo '<pre>';print_r($query);exit;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function searchTersangkaBa4($no_register_perkara ,$params)
    {
        $query = new Query;
        $session = new Session();

        $query->select('a.tgl_ba4,a.no_urut_tersangka,a.nama,a.tmpt_lahir')
                    ->from('pidum.pdm_ba4_tersangka a')                    
                    ->where("a.no_register_perkara = '".$no_register_perkara."'")
                    ->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }


      public function searchTersangkaT7($no_register_perkara ,$params)
    {
        $query = new Query;
        $session = new Session();

        $query->select('a.*,b.tmpt_lahir,c.nama as ur_tindakan_status,d.nama as ur_lokasi_tahanan')
                    ->from('pidum.pdm_t7 a')   
                    ->join('left join','pidum.pdm_ba4_tersangka b','a.no_register_perkara = b.no_register_perkara AND a.tgl_ba4 = b.tgl_ba4 AND a.no_urut_tersangka = b.no_urut_tersangka')   
                    ->join('left join','pidum.pdm_ms_tindakan_status c','c.id = a.tindakan_status')    
                    ->join('left join','pidum.ms_loktahanan d','d.id_loktahanan = a.id_ms_loktahanan')                 
                    ->where("a.no_register_perkara = '".$no_register_perkara."'")
                    ->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }


   public function searchTerdakwa($params) {
        $query = new Query;
        $session = new Session();

        $id = $session->get('id_perkara');
        $query->select('tersangka.id_tersangka as id, tersangka.nama as nama, tersangka.alamat as alamat, agama.nama as agama, pendidikan.nama as pendidikan')
                    ->from('pidum.ms_tersangka tersangka, public.ms_agama agama, public.ms_pendidikan pendidikan')
                    ->where("agama.id_agama = tersangka.id_agama and pendidikan.id_pendidikan = tersangka.id_pendidikan and tersangka.id_perkara='" . $id . "'")
                    ->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        /*   $query->andFilterWhere([
          'id' => $this->id,

          ]); */


//        $query->andFilterWhere(['like', 'tersangka.nama', $this->nama])
//                ->andFilterWhere(['like', 'tersangka.alamat', $this->alamat])
//                ->andFilterWhere(['like', 'agama.nama', $this->agama])
//                ->andFilterWhere(['like', 'pendidikan.nama', $this->pendidikan]);

        return $dataProvider;
    }
}
