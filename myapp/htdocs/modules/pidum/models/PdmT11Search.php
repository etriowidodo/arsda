<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmT11;

use yii\web\Session;

use yii\db\Query;


/**
 * pdmT11Search represents the model behind the search form about `app\modules\pidum\models\PdmT11`.
 */
class pdmT11Search extends PdmT11
{
  public $peg_nik;
  public $peg_nip;
  public $peg_nip_baru;
  public $peg_nama;
  public $jabat_tmt;
  public $jabatan;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_t11', 'tgl_sp_penahanan', 'no_sp_penahanan', 'dasar', 'peg_nip', 'tempat_periksa', 'id_tersangka', 'tempat_rs', 'tgl_pemeriksaan', 'dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan', 'created_ip', 'updated_ip', 'updated_time', 'created_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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
    public function search($no_register_perkara, $params)
    {
        $query = PdmT11::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['=', 'no_register_perkara', $no_register_perkara]);

        $query->andFilterWhere([
            'tgl_sp_penahanan' => $this->tgl_sp_penahanan,
            'tgl_pemeriksaan' => $this->tgl_pemeriksaan,
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
            'created_time' => $this->created_time,
        ]);
  
        $query->andFilterWhere(['like', 'no_surat_t11', $this->no_surat_t11])
            ->andFilterWhere(['like', 'no_sp_penahanan', $this->no_sp_penahanan])
            ->andFilterWhere(['like', 'dasar', $this->dasar])
            ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
            ->andFilterWhere(['like', 'tempat_periksa', $this->tempat_periksa])
            ->andFilterWhere(['like', 'tempat_rs', $this->tempat_rs])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
	
	public function searchJaksaPelaksana($params)
    {
        $query = new Query;
        $query->select('*')
                ->from('pidum.vw_jaksa_penuntut');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
              ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
              ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
              ->andFilterWhere(['like', 'peg_nama', $this->peg_nama])
              ->andFilterWhere(['like', 'jabat_tmt', $this->jabat_tmt])
              ->andFilterWhere(['like', 'jabatan', $this->jabatan]);
          

        return $dataProvider;
    }
}
