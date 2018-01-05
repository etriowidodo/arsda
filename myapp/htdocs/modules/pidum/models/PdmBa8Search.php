<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBa8;
use yii\db\Query;

/**
 * PdmBA11Search represents the model behind the search form about `app\modules\pidum\models\PdmBA11`.
 */
class PdmBA8Search extends PdmBa8 {

    public $peg_nik;
    public $peg_nip;
    public $peg_nip_baru;
    public $peg_nama;
    public $jabat_tmt;
    public $jabatan;
    public $inst_satkerkd;
    public $inst_nama;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['no_register_perkara'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
     public function search($no_register_perkara, $params)
    {
       $query = new Query;
        // $session = new Session();

        $query->select('a.*,c.no_reg_tahanan as no_register_tahanan')
                    ->from('pidum.pdm_ba8 a')
                    ->join('left join','pidum.pdm_t7 b','a.no_register_perkara = b.no_register_perkara AND a.no_surat_t7 = b.no_surat_t7')
                    ->join('left join','pidum.pdm_ba4_tersangka c','b.no_register_perkara = c.no_register_perkara AND b.tgl_ba4 = c.tgl_ba4 AND b.no_urut_tersangka = c.no_urut_tersangka') 
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

    public function searchJPU($params) {
        $query = new Query;
        $instaakhir = \Yii::$app->globalfunc->getSatker()->inst_satkerkd;
        $query->select('*')
                ->from('pidum.vw_jaksa_penuntut')
                ->where("peg_instakhir='" . $instaakhir . "'");

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


        $query->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
                ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
                ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
                ->andFilterWhere(['like', 'peg_nama', $this->peg_nama])
                ->andFilterWhere(['like', 'jabat_tmt', $this->jabat_tmt])
                ->andFilterWhere(['like', 'jabatan', $this->jabatan]);


        return $dataProvider;
    }

    public function searchSatker($params) {
        $query = new Query;
        $instaakhir = \Yii::$app->globalfunc->getSatker()->inst_satkerkd;
        $query->select('inst_satkerkd , inst_nama')
                ->from('kepegawaian.kp_inst_satker')
                ->where("inst_satkerkd='" . $instaakhir . "'");

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


        $query->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
        ->andFilterWhere(['like', 'inst_nama', $this->inst_nama]);


        return $dataProvider;
    }

}
