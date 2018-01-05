<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP21;
use app\modules\pdsold\models\MsTersangkaBerkas;
use yii\db\Query;
use yii\web\Session;
/**
 * PdmP21Search represents the model behind the search form about `app\modules\pidum\models\PdmP21`.
 */
class PdmP21Search extends PdmP21
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p21', 'no_surat', 'sifat', 'lampiran',  'tgl_dikeluarkan', 'dikeluarkan', 'kepada', 'di_kepada', 'id_penandatangan'], 'safe'],
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

   
	public function search2($params)
    {

        $query = new \yii\db\Query;
		$session = new Session();
		$id_perkara = $session->get('id_perkara');

		$query->select (['pidum.pdm_pengantar_tahap1.no_pengantar',"coalesce(pidum.pdm_p21.id_p21,'0') as id_p21",'pidum.pdm_pengantar_tahap1.tgl_pengantar','pidum.pdm_berkas_tahap1.no_berkas','pidum.pdm_berkas_tahap1.tgl_berkas','pidum.pdm_pengantar_tahap1.tgl_terima','pidum.pdm_pengantar_tahap1.id_berkas','pidum.pdm_pengantar_tahap1.id_pengantar',"string_agg(pidum.ms_tersangka_berkas.nama,', ') as nama"])
				->from('pidum.pdm_berkas_tahap1')
				->join('INNER JOIN', 'pidum.pdm_pengantar_tahap1', 'pidum.pdm_pengantar_tahap1.id_berkas = pidum.pdm_berkas_tahap1.id_berkas')
				->join('INNER JOIN', 'pidum.ms_tersangka_berkas', 'pidum.ms_tersangka_berkas.id_berkas=pidum.pdm_pengantar_tahap1.id_berkas')
				->join('INNER JOIN', 'pidum.pdm_p24', 'pidum.pdm_p24.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
				->join('LEFT JOIN', 'pidum.pdm_p21', 'pidum.pdm_p21.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
				->where("pidum.pdm_berkas_tahap1.id_perkara = '".$id_perkara."' AND pidum.pdm_p24.id_hasil='1' GROUP BY pidum.pdm_pengantar_tahap1.id_pengantar,pidum.pdm_berkas_tahap1.no_berkas,pidum.pdm_berkas_tahap1.tgl_berkas,pidum.pdm_p21.id_p21")
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

public function searchTersangka($params)
    {

        $query = new \yii\db\Query;	
				$query->select ("id_tersangka,pidum.ms_tersangka_berkas.nama as namaTersangka,tgl_lahir,umur,ms_jkl.nama")
								->from ("pidum.ms_tersangka_berkas,ms_jkl")
								->where ("pidum.ms_tersangka_berkas.id_berkas ='".$params."' AND pidum.ms_tersangka_berkas.id_jkl=ms_jkl.id_jkl")
								->orderBy('no_urut',sort_asc)
								->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

    

        if (!$this->validate()) {

            return $dataProvider;
        }
        return $dataProvider;

}

public function searchTersangka_new($params)
    {   
        $session = new session();
        $no_pengantar = Yii::$app->session->get('no_pengantar');
        //echo '<pre>';print_r($no_pengantar);exit;
        $query = new \yii\db\Query; 
                $query->select ("id_tersangka,pidum.ms_tersangka_berkas.nama as namaTersangka,tgl_lahir,umur,ms_jkl.nama")
                                ->from ("pidum.ms_tersangka_berkas,ms_jkl")
                                ->where ("pidum.ms_tersangka_berkas.id_berkas ='".$params."' AND pidum.ms_tersangka_berkas.no_pengantar = '".$no_pengantar."' AND pidum.ms_tersangka_berkas.id_jkl=ms_jkl.id_jkl")
                                ->orderBy('no_urut',sort_asc)
                                ->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

    

        if (!$this->validate()) {

            return $dataProvider;
        }
        return $dataProvider;

}
	
}
