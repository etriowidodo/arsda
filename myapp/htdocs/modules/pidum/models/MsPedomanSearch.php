<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\MsPedoman;

/**
 * MsPedomanSearch represents the model behind the search form about `app\modules\pidum\models\MsPedoman`.
 */
class MsPedomanSearch extends MsPedoman
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_pasal'], 'safe'],
            [['kategori', 'ancaman_hari', 'ancaman_bulan', 'ancaman_tahun'], 'integer'],
            [['denda'], 'number'],
            [['ancaman','tuntutan_pidana'], 'string'],
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
        $query = MsPedoman::find();

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
            'kategori' => $this->kategori,
            'ancaman_hari' => $this->ancaman_hari,
            'ancaman_bulan' => $this->ancaman_bulan,
            'ancaman_tahun' => $this->ancaman_tahun,
            'denda' => $this->denda,
            'ancaman' => $this->ancaman,
            'tuntutan_pidana' => $this->tuntutan_pidana,
        ]);

        $query->andFilterWhere(['like', 'upper(id)', strtoupper($this->id)])
            ->andFilterWhere(['like', 'upper(id_pasal)', strtoupper($this->id_pasal)]);

        return $dataProvider;
    }
}
