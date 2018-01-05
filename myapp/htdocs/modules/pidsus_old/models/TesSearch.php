<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\Tes;
use yii\data\SQLDataProvider;

/**
 * TesSearch represents the model behind the search form about `app\models\Tes`.
 */
class TesSearch extends Tes
{
    /**
     * @inheritdoc
     */


    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nama', 'tes'], 'safe'],
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
        /*$query = Tes::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
*/
        $query='select * from tesselectall();';

        $count = Yii::$app->db->createCommand('
    SELECT COUNT(*) FROM tesselectall();')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => '$query',
            //'params' => [':status' => 1],
            'totalCount' => $count,
            //  'sort' => [
            //       'attributes' => [
            //           'nama',
            //           'tes',
            //       ],
            //   ],
            //   'pagination' => [
            //       'pageSize' => 10,
            //   ],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
/*
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'tes', $this->tes]);
*/
        return $dataProvider;
    }
}
