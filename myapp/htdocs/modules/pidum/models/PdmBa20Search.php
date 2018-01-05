<?php

namespace app\modules\pidum\models;


use app\components\GlobalConstMenuComponent;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBa20;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * PdmBa20Search represents the model behind the search form about `app\modules\pidum\models\PdmBa20`.
 */
class PdmBa20Search extends PdmBa20
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba20', 'lokasi', 'id_tersangka', 'bar_buk', 'saksi', 'nama', 'pekerjaan', 'alamat', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'surat_perintah', 'no_surat_perintah', 'tgl_surat_perintah', 'no_putusan', 'tgl_putusan', 'no_surat_p16a'], 'safe'],
            [['created_by', 'updated_by', 'no_urut_jaksa_p16a'], 'integer'],
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
    public function search($no_register,$params)
    {
        $query = PdmBa20::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['=', 'no_register_perkara', $no_register]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_ba20' => $this->tgl_ba20,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'bar_buk', $this->bar_buk])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
	
	public function searchIndex($params)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM pidum.pdm_ba20 a ' .
                'INNER JOIN pidum.ms_tersangka b ON a.id_tersangka = b.id_tersangka ' .
                'WHERE a.id_perkara=:id_perkara AND a.flag<>:flag ',
            'params' => [':id_perkara' => $params,':flag' => '3'],
        ]);

        return $dataProvider;
    }
}
