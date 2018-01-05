<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBa18;

/**
 * PdmBa18Search represents the model behind the search form about `app\modules\pidum\models\PdmBa18`.
 */
class PdmBa18Search extends PdmBa18
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_eksekusi', 'no_sp', 'tgl_sp', 'no_reg_tahanan', 'tindakan', 'id_penandatangan', 'upload_file', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'tgl_pembuatan', 'lokasi', 'saksi', 'nama_ttd', 'pangkat_ttd', 'jabatan_ttd', 'no_visum', 'tgl_visum'], 'safe'],
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
    public function search($params)
    {
        $query = PdmBa18::find();

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
            'tgl_sp' => $this->tgl_sp,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
            'tgl_pembuatan' => $this->tgl_pembuatan,
            'tgl_visum' => $this->tgl_visum,
        ]);

        $query->andFilterWhere(['like', 'no_eksekusi', $this->no_eksekusi])
            ->andFilterWhere(['like', 'no_sp', $this->no_sp])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'tindakan', $this->tindakan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'saksi', $this->saksi])
            ->andFilterWhere(['like', 'nama_ttd', $this->nama_ttd])
            ->andFilterWhere(['like', 'pangkat_ttd', $this->pangkat_ttd])
            ->andFilterWhere(['like', 'jabatan_ttd', $this->jabatan_ttd])
            ->andFilterWhere(['like', 'no_visum', $this->no_visum]);

        return $dataProvider;
    }
}
