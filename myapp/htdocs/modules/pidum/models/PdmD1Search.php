<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmD1;

/**
 * PdmD1Search represents the model behind the search form about `app\modules\pidum\models\PdmD1`.
 */
class PdmD1Search extends PdmD1
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_eksekusi', 'no_surat', 'sifat', 'lampiran', 'kepada', 'di_kepada', 'dikeluarkan', 'tgl_dikeluarkan', 'tgl_panggil', 'jam_panggil', 'menghadap', 'tgl_relas', 'jam_relas', 'id_penandatangan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'nama_ttd', 'pangkat_ttd', 'jabatan_ttd', 'no_reg_tahanan', 'nama_relas', 'pangkat_relas'], 'safe'],
            [['id_msstatusdata', 'created_by', 'updated_by'], 'integer'],
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
        $query = PdmD1::find();

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
            'tgl_panggil' => $this->tgl_panggil,
            'jam_panggil' => $this->jam_panggil,
            'tgl_relas' => $this->tgl_relas,
            'jam_relas' => $this->jam_relas,
            'id_msstatusdata' => $this->id_msstatusdata,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_eksekusi', $this->no_eksekusi])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'menghadap', $this->menghadap])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'nama_ttd', $this->nama_ttd])
            ->andFilterWhere(['like', 'pangkat_ttd', $this->pangkat_ttd])
            ->andFilterWhere(['like', 'jabatan_ttd', $this->jabatan_ttd])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'nama_relas', $this->nama_relas])
            ->andFilterWhere(['like', 'pangkat_relas', $this->pangkat_relas]);

        return $dataProvider;
    }
}
