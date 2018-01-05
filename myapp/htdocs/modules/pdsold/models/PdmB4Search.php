<?php

namespace app\modules\pdsold\models;

use app\components\GlobalConstMenuComponent;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmB4;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * PdmB4Search represents the model behind the search form about `app\modules\pidum\models\PdmB4`.
 */
class PdmB4Search extends PdmB4
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b4', 'id_perkara', 'no_surat', 'kepentingan', 'sprint_kepala', 'no_sprint', 'tgl_sprint', 'penggeledahan', 'penyitaan', 'dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan', 'upload_file', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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

    public function searchJaksa($params)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM pidum.pdm_jaksa_saksi ' .
                     'WHERE id_perkara=:id_perkara AND code_table=:kode_tabel ',
            'params' => [':id_perkara' => $params,':kode_tabel'=>GlobalConstMenuComponent::P25],
        ]);

        return $dataProvider;
    }

    public function searchIndex($params)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM pidum.pdm_b4 a ' .
                //'INNER JOIN pidum.ms_tersangka b ON a.id_tersangka = b.id_tersangka ' .
                'WHERE a.id_perkara=:id_perkara AND a.flag<>:flag ' .
                'ORDER BY a.id_b4 DESC ',
            'params' => [':id_perkara' => $params,':flag' => '3'],
        ]);

        return $dataProvider;
    }

    public function search($params)
    {
        $query = PdmB4::find();

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
            'tgl_sprint' => $this->tgl_sprint,
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_b4', $this->id_b4])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'kepentingan', $this->kepentingan])
            ->andFilterWhere(['like', 'sprint_kepala', $this->sprint_kepala])
            ->andFilterWhere(['like', 'no_sprint', $this->no_sprint])
            ->andFilterWhere(['like', 'penggeledahan', $this->penggeledahan])
            ->andFilterWhere(['like', 'penyitaan', $this->penyitaan])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
