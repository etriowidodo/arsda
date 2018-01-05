<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP44;

/**
 * PdmP44Search represents the model behind the search form about `app\modules\pidum\models\PdmP44`.
 */
class PdmP44Search extends PdmP44
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
               [['id_p44'], 'required'],
            [['tgl_tuntutan', 'tgl_putusan', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_p44', 'id_perkara'], 'string', 'max' => 16],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['no_putusan'], 'string', 'max' => 128],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
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
	        $id_perkara = \Yii::$app->session->get('id_perkara');
        $query = PdmP44::find();
        $query->where = "pdm_p44.flag != '3'";
        $query->where = "pdm_p44.id_perkara = '$id_perkara'";
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		  $query->andWhere(['!=', 'flag', '3']);

        $query->andFilterWhere([
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'tgl_notel' => $this->tgl_notel,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
			'id_perkara' => $id,
        ]);

        $query->andFilterWhere(['like', 'id_p44', $this->id_p44])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'notel', $this->notel])
            ->andFilterWhere(['like', 'amar_tut', $this->amar_tut])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
