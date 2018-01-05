<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmP48;

/**
 * PdmP48Search represents the model behind the search form about `app\modules\pidum\models\PdmP48`.
 */
class PdmP48Search extends PdmP48
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_putusan', 'no_surat', 'dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'tgl_putusan', 'no_reg_tahanan', 'nama_ttd', 'pangkat_ttd', 'jabatan_ttd', 'no_akta', 'id_perkara'], 'safe'],
            [['created_by', 'updated_by', 'is_denda'], 'integer'],
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
        $query = PdmP48::find();

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
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
            'tgl_putusan' => $this->tgl_putusan,
            'is_denda' => $this->is_denda,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_putusan', $this->no_putusan])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'nama_ttd', $this->nama_ttd])
            ->andFilterWhere(['like', 'pangkat_ttd', $this->pangkat_ttd])
            ->andFilterWhere(['like', 'jabatan_ttd', $this->jabatan_ttd])
            ->andFilterWhere(['like', 'no_akta', $this->no_akta])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara]);

        return $dataProvider;
    }
}
