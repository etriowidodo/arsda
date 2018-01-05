<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmBerkasTahap1;
use yii\db\Query;
use yii\web\Session;
/**
 * PdmBerkasTahap1Search represents the model behind the search form about `app\modules\pidum\models\PdmBerkasTahap1`.
 */
class PdmBerkasTahap1Search extends PdmBerkasTahap1
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_berkas', 'id_perkara', 'no_berkas', 'tgl_berkas'], 'safe'],
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
        $query = PdmBerkasTahap1::find();

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
            'tgl_berkas' => $this->tgl_berkas,
        ]);

        $query->andFilterWhere(['like', 'id_berkas', $this->id_berkas])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_berkas', $this->no_berkas]);

        return $dataProvider;
    }
	public function search2($params)
    {

        $query = new \yii\db\Query;
		$session = new Session();
		$id_perkara = $session->get('id_perkara');

		$query->select (['no_pengantar','tgl_pengantar','pdm_pengantar_tahap1.tgl_terima'])
				->from('pidum.pdm_pengantar_tahap1,pidum.pdm_berkas_tahap1')
				//->join('INNER JOIN', 'pidum.pdm_berkas_tahap1', 'pidum.pdm_berkas_tahap1.id_berkas=pidum.pdm_pengantar_tahap1.id_berkas')
				->where("pidum.pdm_berkas_tahap1.id_perkara = '".$id_perkara."' AND pidum.pdm_berkas_tahap1.id_berkas=pidum.pdm_pengantar_tahap1.id_berkas")
				->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        return $dataProvider;

}
public function search3($params)
    {

        $query = new \yii\db\Query;
		$session = new Session();
		$id_perkara = $session->get('id_perkara');

		$query->select (['no_berkas','tgl_berkas','id_berkas'])
				->from('pidum.pdm_berkas_tahap1')
				->where("pidum.pdm_berkas_tahap1.id_perkara = '".$id_perkara."'")
				->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        return $dataProvider;

}
}
