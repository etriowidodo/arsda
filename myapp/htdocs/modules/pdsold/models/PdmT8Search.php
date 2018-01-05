<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmT8;

/**
 * pdmT8Search represents the model behind the search form about `app\modules\pidum\models\PdmT8`.
 */
class pdmT8Search extends PdmT8
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_t8','no_surat_t7', /*'undang', 'tahun', 'tentang', 'no_penyidik', 'tgl_penyidik', 'sp_penahanan', 'no_sp', 'tgl_sp',*/ 
                'tgl_permohonan', 'id_tersangka', 'no_surat_p16a',
                 'tgl_penahanan', 'tgl_penangguhan', 
                'tgl_mulai', 'jaminan', 'hari_lapor', 'kepala_rutan', 
                'dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['created_by', 'updated_by','no_urut_jaksa_p16a'], 'integer'],
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
        $query = PdmT8::find();
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['=', 'no_register_perkara', $no_register_perkara]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['=', 'no_register_perkara', $no_register_perkara]);
//        $query->andWhere(['!=', 'flag', '3']);
        
        $query->andFilterWhere([
            // 'tgl_penyidik' => $this->tgl_penyidik,
            // 'tgl_sp' => $this->tgl_sp,
            'tgl_permohonan' => $this->tgl_permohonan,
            'tgl_penahanan' => $this->tgl_penahanan,
            'tgl_penangguhan' => $this->tgl_penangguhan,
            'tgl_mulai' => $this->tgl_mulai,
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'no_surat_p16a' => $this->no_surat_p16a,
            'no_urut_jaksa_p16a' => $this->no_urut_jaksa_p16a,
            'updated_time' => $this->updated_time,
            'no_register_perkara' => $no_register_perkara,
        ]);

        $query->andFilterWhere(['like', 'no_surat_t8', $this->no_surat_t8])
            // ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
//            ->andFilterWhere(['like', 'no_surat_t8', $this->no_surat_t8])
            // ->andFilterWhere(['like', 'undang', $this->undang])
            // ->andFilterWhere(['like', 'tahun', $this->tahun])
            // ->andFilterWhere(['like', 'tentang', $this->tentang])
            // ->andFilterWhere(['like', 'no_penyidik', $this->no_penyidik])
            // ->andFilterWhere(['like', 'sp_penahanan', $this->sp_penahanan])
            // ->andFilterWhere(['like', 'no_sp', $this->no_sp])
            ->andFilterWhere(['like', 'id_ms_status_t8', $this->id_ms_status_t8])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'no_surat_t7', $this->no_surat_t7])
            ->andFilterWhere(['like', 'jaminan', $this->jaminan])
            ->andFilterWhere(['like', 'hari_lapor', $this->hari_lapor])
            ->andFilterWhere(['like', 'kepala_rutan', $this->kepala_rutan])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
//            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
