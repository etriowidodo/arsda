<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmPengantarTahap1;

/**
 * PdmPengantarTahap1Search represents the model behind the search form about `app\modules\pidum\models\PdmPengantarTahap1`.
 */
class PdmPengantarTahap1Search extends PdmPengantarTahap1
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pengantar', 'id_berkas', 'no_pengantar', 'tgl_pengantar', 'tgl_terima'], 'safe'],
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
        $query = PdmPengantarTahap1::find();

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
            'tgl_pengantar' => $this->tgl_pengantar,
            'tgl_terima' => $this->tgl_terima,
        ]);

        $query->andFilterWhere(['like', 'id_pengantar', $this->id_pengantar])
            ->andFilterWhere(['like', 'id_berkas', $this->id_berkas])
            ->andFilterWhere(['like', 'no_pengantar', $this->no_pengantar]);

        return $dataProvider;
    }
}
