<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBa2;

/**
 * PdmBa2Search represents the model behind the search form about `app\modules\pidum\models\PdmBa2`.
 */
class PdmBa2Search extends PdmBa2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba2', 'tgl_pembuatan', 'jam'], 'safe'],
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
    public function search($id_pekara,$params)
    {
        $query = PdmBa2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['=', 'id_perkara', $id_pekara]);
        $query->andWhere(['<>','flag',3]);
        
        $query->andFilterWhere([
            'tgl_pembuatan' => $this->tgl_pembuatan,
            'jam' => $this->jam,
        ]);

        $query->andFilterWhere(['like', 'id_ba2', $this->id_ba2])
             ->andFilterWhere(['like', 'id_perkara', $this->id_perkara]);
         //   ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan]);

        return $dataProvider;
    }
}
