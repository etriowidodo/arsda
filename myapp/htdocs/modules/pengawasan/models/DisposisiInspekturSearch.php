<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\DisposisiInspektur;

/**
 * DisposisiInspekturSearch represents the model behind the search form about `app\models\DisposisiInspektur`.
 */
class DisposisiInspekturSearch extends DisposisiInspektur
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register', 'id_terlapor_awal', 'tanggal_disposisi', 'isi_disposisi'], 'safe'],
            [['irmud_pegasum_kepbang', 'id_inspektur', 'irmud_pidum_datun', 'irmud_intel_pidsus'], 'integer'],
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
        $query = DisposisiInspektur::find();

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
            'irmud_pegasum_kepbang' => $this->irmud_pegasum_kepbang,
            'id_inspektur' => $this->id_inspektur,
            'tanggal_disposisi' => $this->tanggal_disposisi,
            'irmud_pidum_datun' => $this->irmud_pidum_datun,
            'irmud_intel_pidsus' => $this->irmud_intel_pidsus,
        ]);

        $query->andFilterWhere(['like', 'no_register', $this->no_register])
            ->andFilterWhere(['like', 'id_terlapor_awal', $this->id_terlapor_awal])
            ->andFilterWhere(['like', 'isi_disposisi', $this->isi_disposisi]);

        return $dataProvider;
    }
}
