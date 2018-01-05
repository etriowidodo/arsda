<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBa4;
use yii\db\Query;
use yii\web\Session;

/**
 * PdmBA4Search represents the model behind the search form about `app\modules\pidum\models\PdmBA4`.
 */
class PdmBa4Search extends PdmBa4
{
    
    public $peg_nik;
    public $peg_nip;
    public $peg_nip_baru;
    public $peg_nama;
    public $jabat_tmt;
    public $jabatan;
    public $inst_satkerkd;
    public $inst_nama;
    public $pangkat;
    public $nama;
    public $agama;
    public $pendidikan;
    public $alamat;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba4', 'id_peneliti', 'no_reg_tahanan', 'no_reg_perkara', 'alasan', 'id_penandatangan', 'upload_file', 'tmpt_lahir', 'tgl_lahir', 'alamat', 'no_identitas', 'no_hp', 'pekerjaan', 'suku', 'nama', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['no_urut_tersangka', 'warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan', 'created_by', 'updated_by'], 'integer'],
            [['umur'], 'number'],
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

    public function search($no_register_perkara,$params)
    {
         $query = new Query;
        // $session = new Session();

        $query->select('*')
                    ->from('pidum.pdm_ba4_tersangka')                                     
                    ->where("no_register_perkara = '".$no_register_perkara."'")
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
        $query->select('*')
                ->from('pidum.pdm_ba4_tersangka')
                ->where("no_register_perkara='".$no_register_perkara."'");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'jabat_tmt' => $this->jabat_tmt,
        // ]);

        // $query->andFilterWhere(['like', 'peg_instakhir', $this->peg_instakhir])
        //         ->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
        //         ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
        //         ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
        //         ->andFilterWhere(['like', 'upper(peg_nama)', strtoupper($this->peg_nama)])
        //         ->andFilterWhere(['like', 'upper(jabatan)', strtoupper($this->jabatan)])
        //         ->andFilterWhere(['like', 'upper(pangkat)', strtoupper($this->pangkat)]);
//var_dump($query);exit;
//echo $query['string'];exit;
        return $dataProvider;
    }
}
