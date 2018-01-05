<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP25;

/**
 * PdmP25Search represents the model behind the search form about `app\modules\pidum\models\PdmP25`.
 */
class PdmP25Search extends PdmP25
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p25', 'id_berkas', 'no_surat', 'dikeluarkan', 'tgl_surat', 'id_penandatangan'], 'safe'],
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
    public function search($id_perkara,$params)
    {
        $query = PdmP25::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['=', 'id_perkara', \Yii::$app->session->get('id_perkara')]);
        $query->andWhere(['!=','flag','3']);

        $query->andFilterWhere([
            'tgl_surat' => $this->tgl_surat,
        ]);

        $query->andFilterWhere(['like', 'id_p25', $this->id_p25])
            ->andFilterWhere(['like', 'id_berkas', $this->id_berkas])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan]);

        return $dataProvider;
    }
}
