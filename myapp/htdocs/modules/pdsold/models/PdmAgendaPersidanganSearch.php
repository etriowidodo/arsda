<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmAgendaPersidangan;

/**
 * PdmAgendaPersidanganSearch represents the model behind the search form about `app\modules\pidum\models\PdmAgendaPersidangan`.
 */
class PdmAgendaPersidanganSearch extends PdmAgendaPersidangan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_agenda', 'majelis_hakim', 'penasehat_hukum', 'uraian_sidang','panitera' , 'pengunjung', 'kesimpulan', 'pendapat', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time','tgl_acara_sidang' , 'updated_ip', 'updated_time','acara_sidang_ke'], 'safe'],
            [['sidang_ke', 'created_by', 'updated_by','acara_sidang','no_agenda'], 'integer'],
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
    public function search($no_register, $params)
    {
        $query = PdmAgendaPersidangan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['=', 'no_register_perkara', $no_register]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'sidang_ke' => $this->sidang_ke,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_agenda', $this->no_agenda])
            ->andFilterWhere(['like', 'majelis_hakim', $this->majelis_hakim])
            ->andFilterWhere(['like', 'penasehat_hukum', $this->penasehat_hukum])
            ->andFilterWhere(['like', 'uraian_sidang', $this->uraian_sidang])
            ->andFilterWhere(['like', 'acara_sidang_ke', $this->acara_sidang_ke])
            ->andFilterWhere(['like', 'pengunjung', $this->pengunjung])
            ->andFilterWhere(['like', 'kesimpulan', $this->kesimpulan])
            ->andFilterWhere(['like', 'pendapat', $this->pendapat])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
