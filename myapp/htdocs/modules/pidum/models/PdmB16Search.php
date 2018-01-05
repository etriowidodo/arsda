<?php

namespace app\modules\pidum\models;

use app\components\GlobalConstMenuComponent;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmB16;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * PdmB16Search represents the model behind the search form about `app\modules\pidum\models\PdmB16`.
 */
class PdmB16Search extends PdmB16
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b16', 'id_perkara', 'no_surat', 'sifat', 'lampiran', 'kepada', 'di_kepada', 'dikeluarkan', 'tgl_dikeluarkan', 'id_tersangka', 'pelaksanaan_lelang', 'tgl_lelang', 'bank', 'ba_penitipan', 'tgl_ba', 'no_persetujuan', 'tgl_persetujuan', 'kantor_lelang', 'no_risalan', 'id_penandatangan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['total'], 'number'],
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
        $query = PdmB16::find();

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
            'tgl_lelang' => $this->tgl_lelang,
            'total' => $this->total,
            'tgl_ba' => $this->tgl_ba,
            'tgl_persetujuan' => $this->tgl_persetujuan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_b16', $this->id_b16])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'pelaksanaan_lelang', $this->pelaksanaan_lelang])
            ->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'ba_penitipan', $this->ba_penitipan])
            ->andFilterWhere(['like', 'no_persetujuan', $this->no_persetujuan])
            ->andFilterWhere(['like', 'kantor_lelang', $this->kantor_lelang])
            ->andFilterWhere(['like', 'no_risalan', $this->no_risalan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
	
	 public function searchIndex($params)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM pidum.pdm_b16 a ' .
                'INNER JOIN pidum.ms_tersangka b ON a.id_tersangka = b.id_tersangka ' .
                'WHERE a.id_perkara=:id_perkara AND a.flag<>:flag ',
            'params' => [':id_perkara' => $params,':flag' => '3'],
        ]);

        return $dataProvider;
    }
}
