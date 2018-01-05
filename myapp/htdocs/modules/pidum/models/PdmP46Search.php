<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmP46;
use yii\web\Session;

/**
 * PdmP46Search represents the model behind the search form about `app\modules\pidum\models\PdmP46`.
 */
class PdmP46Search extends PdmP46
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_akta', 'no_reg_tahanan', 'kepada', 'di_kepada', 'dikeluarkan', 'tgl_dikeluarkan', 'alasan', 'pengadilan_tinggi', 'tgl_pengajuan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'nama_ttd', 'pangkat_ttd', 'jabatan_ttd', 'nip_ttd'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['biaya_perkara'], 'number'],
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
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');

        $query = PdmP46::find();

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
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'tgl_pengajuan' => $this->tgl_pengajuan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
            'biaya_perkara' => $this->biaya_perkara,
            'no_register_perkara' => $no_register_perkara,
            'no_akta' =>$no_akta,
            'no_reg_tahanan'=> $no_reg_tahanan,

        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_akta', $this->no_akta])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'alasan', $this->alasan])
            ->andFilterWhere(['like', 'pengadilan_tinggi', $this->pengadilan_tinggi])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'nama_ttd', $this->nama_ttd])
            ->andFilterWhere(['like', 'pangkat_ttd', $this->pangkat_ttd])
            ->andFilterWhere(['like', 'jabatan_ttd', $this->jabatan_ttd])
            ->andFilterWhere(['like', 'nip_ttd', $this->nip_ttd]);

        return $dataProvider;
    }
}
