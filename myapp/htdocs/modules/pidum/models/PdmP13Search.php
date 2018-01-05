<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmP13;

/**
 * Pdmp13Search represents the model behind the search form about `app\modules\pidum\models\Pdmp13`.
 */
class PdmP13Search extends PdmP13
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p13', 'sifat', 'lampiran', 'kepada', 'di_kepada', 'no_sp', 'tgl_sp', 'id_tersangka', 'dikeluarkan', 'tgl_dikeluarkan', 'ket_saksi', 'ket_ahli', 'ket_surat', 'petunjuk', 'ket_tersangka', 'hukum', 'yuridis', 'kesimpulan', 'saran', 'id_penandatangan', 'upload_file', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
    public function search($no_register,$params)
    {
        $query = PdmP13::find();

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
            'tgl_sp' => $this->tgl_sp,
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_surat_p13', $this->no_surat_p13])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'no_sp', $this->no_sp])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'ket_saksi', $this->ket_saksi])
            ->andFilterWhere(['like', 'ket_ahli', $this->ket_ahli])
            ->andFilterWhere(['like', 'ket_surat', $this->ket_surat])
            ->andFilterWhere(['like', 'petunjuk', $this->petunjuk])
            ->andFilterWhere(['like', 'ket_tersangka', $this->ket_tersangka])
            ->andFilterWhere(['like', 'hukum', $this->hukum])
            ->andFilterWhere(['like', 'yuridis', $this->yuridis])
            ->andFilterWhere(['like', 'kesimpulan', $this->kesimpulan])
            ->andFilterWhere(['like', 'saran', $this->saran])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}