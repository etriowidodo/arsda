<?php

namespace app\modules\pidum\models;

use app\modules\pidum\models\PdmB21;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

/**
 * PdmB21Search represents the model behind the search form about `app\modules\pidum\models\PdmB21`.
 */
class PdmB21Search extends PdmB21
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b21', 'id_perkara', 'no_surat', 'pertimbangan', 'untuk', 'dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
    public function search($params)
    {
        $query = PdmB21::find();
        $session = new Session();
        $id = $session->get('id_perkara');
        $query->where = "flag != '3' and id_perkara='$id'";

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
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_b21', $this->id_b21])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'pertimbangan', $this->pertimbangan])
            ->andFilterWhere(['like', 'untuk', $this->untuk])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
