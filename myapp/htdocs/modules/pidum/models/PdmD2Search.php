<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmD2;

/**
 * PdmD2Search represents the model behind the search form about `app\modules\pidum\models\PdmD2`.
 */
class PdmD2Search extends PdmD2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_eksekusi', 'no_reg_tahanan', 'tgl_setor', 'dikeluarkan', 'tgl_dikeluarkan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'id_penandatangan', 'nama_ttd', 'pangkat_ttd', 'jabatan_ttd', 'no_register_perkara'], 'safe'],
            [['is_lunas', 'created_by', 'updated_by'], 'integer'],
            [['nilai'], 'number'],
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
        $query = PdmD2::find();

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
            'tgl_setor' => $this->tgl_setor,
            'is_lunas' => $this->is_lunas,
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
            'nilai' => $this->nilai,
        ]);

        $query->andFilterWhere(['like', 'no_eksekusi', $this->no_eksekusi])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'nama_ttd', $this->nama_ttd])
            ->andFilterWhere(['like', 'pangkat_ttd', $this->pangkat_ttd])
            ->andFilterWhere(['like', 'jabatan_ttd', $this->jabatan_ttd])
            ->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara]);

        return $dataProvider;
    }
}
