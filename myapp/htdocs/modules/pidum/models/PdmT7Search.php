<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmT7;
use yii\db\Query;

/**
 * PdmT7Search represents the model behind the search form about `app\modules\pidum\models\PdmT7`.
 */
class PdmT7Search extends PdmT7
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_surat_t7', 'tgl_mulai', 'tgl_selesai','dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan', 'tindakan_status'], 'safe'],
            [['lama'], 'integer'],
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
    public function search($id, $params)
    {
        $query = new Query;
        // $session = new Session();

        $query->select('a.no_register_perkara,a.no_surat_t7 as no_surat_t7, a.tindakan_status, a.nama_tersangka_ba4 as nama_tersangka,a.nama_jaksa as nama_jaksa,a.json_jpu as json_jpu ')
                    ->from('pidum.pdm_t7 a ')   
                    ->join('left join','pidum.pdm_ba4_tersangka b','a.no_register_perkara = b.no_register_perkara and a.tgl_ba4 = b.tgl_ba4 and a.no_urut_tersangka = b.no_urut_tersangka' )  
                    ->join('left join','pidum.pdm_jaksa_p16a c','a.no_register_perkara = c.no_register_perkara and a.no_surat_p16a = c.no_surat_p16a and a.no_jaksa_p16a = c.no_urut')               
                    ->where("a.no_register_perkara = '".$id."'")
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
