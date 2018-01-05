<?php

namespace app\modules\pidum\models;

use app\components\GlobalConstMenuComponent;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBa8;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * PdmBa8Search represents the model behind the search form about `app\modules\pidum\models\PdmBa8`.
 */
class PdmBa8Search extends PdmBa8
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba8', 'id_perkara', 'tgl_surat', 'id_tersangka', 'uraian', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
        $query = PdmBa8::find();

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
            'tgl_surat' => $this->tgl_surat,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_ba8', $this->id_ba8])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'uraian', $this->uraian])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
	
	 public function searchIndex($params)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM pidum.pdm_ba8 a ' .
                'INNER JOIN pidum.ms_tersangka b ON a.id_tersangka = b.id_tersangka ' .
                'WHERE a.id_perkara=:id_perkara AND a.flag<>:flag ',
            'params' => [':id_perkara' => $params,':flag' => '3'],
        ]);

        return $dataProvider;
    }
}
