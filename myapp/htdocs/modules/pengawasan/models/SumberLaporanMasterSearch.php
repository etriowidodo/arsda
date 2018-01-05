<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\SumberLaporanMaster;
use yii\db\Query;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * SumberLaporanSearch represents the model behind the search form about `app\models\SumberLaporan`.
 */
class SumberLaporanMasterSearch extends SumberLaporanMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_sumber_laporan', 'id_sumber_laporan', 'akronim'], 'safe'],
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
        $query = SumberLaporanMaster::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

         $query->andFilterWhere(['like', 'id_sumber_laporan', $this->id_sumber_laporan])
            ->andFilterWhere(['like', 'nama_sumber_laporan', $this->nama_sumber_laporan])
            ->andFilterWhere(['like', 'akronim', $this->akronim]);

        return $dataProvider;
    }
}
