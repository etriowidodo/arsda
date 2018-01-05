<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\MsTersangka;
use yii\db\Query;
use yii\web\Session;

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
            [['id_tersangka', 'id_perkara', 'tmpt_lahir', 'tgl_lahir', 'alamat', 'no_identitas', 'warganegara', 'pekerjaan', 'suku', 'nama', 'flag', 'agama', 'pendidikan'], 'safe'],
            [['no_hp'], 'number'],  [['umur'], 'number'],
            [['id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan'], 'integer'],
			    [['id_t5'], 'string', 'max' => 32],
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
            ->andFilterWhere(['like', 'nama', $this->nama])
	
            ->andFilterWhere(['like', 'flag', $this->flag]);

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

        $query->andWhere(['<>', 'flag', '3']);
        $query->orderBy('id_tersangka asc');

        $query->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'tmpt_lahir', $this->tmpt_lahir])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_identitas', $this->no_identitas])
            ->andFilterWhere(['like', 'warganegara', $this->warganegara])
            ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
			  
            ->andFilterWhere(['like', 'suku', $this->suku])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'flag', $this->flag]);

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       /* $query->andFilterWhere([
            'tgl_lahir' => $this->tgl_lahir,
            'no_hp' => $this->no_hp,
            'id_jkl' => $this->id_jkl,
            'id_identitas' => $this->id_identitas,
            'id_agama' => $this->id_agama,
            'id_pendidikan' => $this->id_pendidikan,
        ]);

        $query->andWhere(['<>', 'flag', '3']);
        $query->orderBy('id_tersangka asc');

        $query->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'tmpt_lahir', $this->tmpt_lahir])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_identitas', $this->no_identitas])
            ->andFilterWhere(['like', 'warganegara', $this->warganegara])
            ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
			  
            ->andFilterWhere(['like', 'suku', $this->suku])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'flag', $this->flag]);*/

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
