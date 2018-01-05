<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmB14;

/**
 * PdmB14Search represents the model behind the search form about `app\modules\pidum\models\PdmB14`.
 */
class PdmB14Search extends PdmB14
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b14', 'id_perkara', 'no_sprint', 'id_penandatangan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
    public function search($id_perkara, $params)
    {
        $query = PdmB14::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       // $this->load($params);
          $query->andWhere(['!=', 'flag', '3']);
          $query->andwhere(['=', 'id_perkara', $id_perkara]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_b14', $this->id_b14])
            ->andFilterWhere(['like', 'id_perkara', $params])
            ->andFilterWhere(['like', 'no_sprint', $this->no_sprint])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
