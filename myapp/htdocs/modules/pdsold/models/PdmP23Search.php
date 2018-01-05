<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP23;
use yii\web\Session;

/**
 * PdmP23Search represents the model behind the search form about `app\modules\pidum\models\PdmP23`.
 */
class PdmP23Search extends PdmP23
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p23', 'no_surat', 'sifat', 'lampiran', 'tgl_dikeluarkan', 'dikeluarkan', 'kepada', 'di_kepada', 'id_penandatangan'], 'safe'],
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

		$query->select (['pidum.pdm_pengantar_tahap1.no_pengantar','pidum.pdm_p22.id_p22','coalesce(id_p23,\'0\') as id_p23 ','pidum.pdm_p22.tgl_dikeluarkan','pidum.pdm_p22.no_surat','pidum.pdm_berkas_tahap1.no_berkas','pidum.pdm_berkas_tahap1.tgl_berkas','pidum.pdm_berkas_tahap1.id_berkas','pidum.pdm_p22.id_pengantar',"string_agg(pidum.ms_tersangka_berkas.nama,', ') as nama"])
				->from('pidum.pdm_berkas_tahap1')
				->join('INNER JOIN', 'pidum.pdm_pengantar_tahap1', 'pidum.pdm_pengantar_tahap1.id_berkas = pidum.pdm_berkas_tahap1.id_berkas')
				->join('INNER JOIN', 'pidum.ms_tersangka_berkas', 'pidum.ms_tersangka_berkas.id_berkas=pidum.pdm_pengantar_tahap1.id_berkas')
				->join('INNER JOIN', 'pidum.pdm_p19', 'pidum.pdm_p19.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
				->join('INNER JOIN', 'pidum.pdm_p22', 'pidum.pdm_p22.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
				->join('LEFT JOIN', 'pidum.pdm_p23', 'pidum.pdm_p23.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
				->where("pidum.pdm_berkas_tahap1.id_perkara = '".$id_perkara."' GROUP BY pidum.pdm_p22.id_pengantar,pidum.pdm_pengantar_tahap1.no_pengantar,pidum.pdm_berkas_tahap1.no_berkas,pidum.pdm_berkas_tahap1.tgl_berkas,pidum.pdm_p22.id_p22,pidum.pdm_p23.id_p23,pidum.pdm_berkas_tahap1.id_berkas")
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
