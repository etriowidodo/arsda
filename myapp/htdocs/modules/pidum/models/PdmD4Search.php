<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmD4;

/**
 * PdmD4Search represents the model behind the search form about `app\modules\pidum\models\PdmD4`.
 */
class PdmD4Search extends PdmD4
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_eksekusi', 'no_reg_tahanan', 'no_surat', 'dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'nama_jaksa', 'nip_jaksa', 'pangkat_jaksa', 'jabatan_jaksa', 'nama_ttd', 'pangkat_ttd', 'jabatan_ttd'], 'safe'],
            [['id_msstatusdata', 'created_by', 'updated_by'], 'integer'],
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
        $query = PdmD4::find();

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
            'id_msstatusdata' => $this->id_msstatusdata,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
            'nilai' => $this->nilai,
        ]);

        $query->andFilterWhere(['like', 'no_eksekusi', $this->no_eksekusi])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'nama_jaksa', $this->nama_jaksa])
            ->andFilterWhere(['like', 'nip_jaksa', $this->nip_jaksa])
            ->andFilterWhere(['like', 'pangkat_jaksa', $this->pangkat_jaksa])
            ->andFilterWhere(['like', 'jabatan_jaksa', $this->jabatan_jaksa])
            ->andFilterWhere(['like', 'nama_ttd', $this->nama_ttd])
            ->andFilterWhere(['like', 'pangkat_ttd', $this->pangkat_ttd])
            ->andFilterWhere(['like', 'jabatan_ttd', $this->jabatan_ttd]);

        return $dataProvider;
    }
}
