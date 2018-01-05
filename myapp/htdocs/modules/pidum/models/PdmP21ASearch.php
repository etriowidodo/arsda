<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Session;
/**
 * PdmP21ASearch represents the model behind the search form about `app\modules\pidum\models\PdmP21A`.
 */
class PdmP21ASearch extends PdmP21a
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p21a', 'no_surat', 'sifat', 'lampiran', 'tgl_dikeluarkan', 'dikeluarkan', 'kepada', 'di_kepada', 'id_penandatangan'], 'safe'],
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
        $query = PdmP21A::find();
        $query->where = "pdm_p21a.flag != '3'";
        $query->where = "pdm_p21a.id_perkara = '$id_perkara'";

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		$query->andWhere(['!=', 'flag', '3']);

        $query->andFilterWhere(['tgl_dikeluarkan' => $this->tgl_dikeluarkan]);

        $query->andFilterWhere(['like', 'id_p21a', $this->id_p21a])
            ->andFilterWhere(['like', 'id_p21', $this->id_p21])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan]);

        return $dataProvider;
    }
	
	public function search2($params)
    {

        $query = new \yii\db\Query;
		$session = new Session();
		$id_perkara = $session->get('id_perkara');

		$query->select (['pidum.pdm_pengantar_tahap1.no_pengantar','pidum.pdm_p21a.id_p21a','pidum.pdm_p21a.tgl_dikeluarkan','pidum.pdm_p21.no_surat','pidum.pdm_berkas_tahap1.no_berkas','pidum.pdm_berkas_tahap1.tgl_berkas','pidum.pdm_p21.tgl_dikeluarkan','pidum.pdm_pengantar_tahap1.id_berkas','pidum.pdm_pengantar_tahap1.id_pengantar',"string_agg(pidum.ms_tersangka_berkas.nama,', ') as nama"])
				->from('pidum.pdm_berkas_tahap1')
				->join('INNER JOIN', 'pidum.pdm_pengantar_tahap1', 'pidum.pdm_pengantar_tahap1.id_berkas = pidum.pdm_berkas_tahap1.id_berkas')
				->join('INNER JOIN', 'pidum.ms_tersangka_berkas', 'pidum.ms_tersangka_berkas.id_berkas=pidum.pdm_pengantar_tahap1.id_berkas')
				->join('INNER JOIN', 'pidum.pdm_p24', 'pidum.pdm_p24.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
				->join('INNER JOIN', 'pidum.pdm_p21', 'pidum.pdm_p21.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
				->join('LEFT JOIN', 'pidum.pdm_p21a', 'pidum.pdm_p21a.id_pengantar=pidum.pdm_p21.id_pengantar')
				->where("pidum.pdm_berkas_tahap1.id_perkara = '".$id_perkara."' AND pidum.pdm_p24.id_hasil='1' GROUP BY pidum.pdm_pengantar_tahap1.id_pengantar,pidum.pdm_berkas_tahap1.no_berkas,pidum.pdm_berkas_tahap1.tgl_berkas,pidum.pdm_p21.id_p21,pidum.pdm_p21a.id_p21a")
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
	public function searchTersangka($id_berkas){
        $query = new \yii\db\Query;	
				$query->select ("id_tersangka,pidum.ms_tersangka_berkas.nama as namaTersangka,tgl_lahir,umur,ms_jkl.nama")
								->from ("pidum.ms_tersangka_berkas,ms_jkl")
								->where ("pidum.ms_tersangka_berkas.id_berkas ='".$id_berkas."' AND pidum.ms_tersangka_berkas.id_jkl=ms_jkl.id_jkl")
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

    public function searchTersangka_new($id_berkas){
        $no_pengantar = Yii::$app->session->get('no_pengantar');
        $query = new \yii\db\Query; 
                $query->select ("id_tersangka,pidum.ms_tersangka_berkas.nama as namaTersangka,tgl_lahir,umur,ms_jkl.nama")
                                ->from ("pidum.ms_tersangka_berkas,ms_jkl")
                                ->where ("pidum.ms_tersangka_berkas.id_berkas ='".$id_berkas."' AND pidum.ms_tersangka_berkas.no_pengantar = '".$no_pengantar."' AND pidum.ms_tersangka_berkas.id_jkl=ms_jkl.id_jkl")
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
}
