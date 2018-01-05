<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\MsUUndang;

/**
 * MsUUndangSearch represents the model behind the search form about `app\modules\pidum\models\MsUUndang`.
 */
class MsUUndangSearch extends MsUUndang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uu', 'deskripsi', 'tentang', 'tanggal'], 'safe'],
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
        $query = MsUUndang::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       

        $query->andFilterWhere(['like', 'upper(uu)', strtoupper($this->uu)])
            ->andFilterWhere(['like', 'upper(deskripsi)', strtoupper($this->deskripsi)])
            ->andFilterWhere(['like', "to_char(tanggal,'dd-mm-yyyy')", strtoupper($this->tanggal)])
            ->andFilterWhere(['like', 'upper(tentang)', strtoupper($this->tentang)]);
		$dataProvider->pagination->pageSize = '10';
        return $dataProvider;
    }
}
