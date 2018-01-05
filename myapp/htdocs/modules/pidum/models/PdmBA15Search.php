<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBa15;

/**
 * PdmBa15Search represents the model behind the search form about `app\modules\pidum\models\PdmBa15`.
 */
class PdmBa15Search extends PdmBa15
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba15', 'no_sp', 'tgl_sp', 'no_p16a', 'penetapan', 'no_penetapan', 'tgl_penetapan', 'tgl_diterima', 'no_surat_t7', 'tgl_ba4', 'memerintahkan', 'nip_jaksa', 'nama_jaksa', 'jabatan_jaksa', 'tgl_awal_cara', 'tgl_akhir_cara', 'jenis_cara1', 'jenis_cara2', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'no_reg_tahanan', 'pangkat_jaksa'], 'safe'],
            [['id_tersangka', 'id_isipenetapan', 'created_by', 'updated_by'], 'integer'],
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
    public function search($no_register_perkara,$params)
    {
        $query = PdmBa15::find();

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
            'no_register_perkara' => $no_register_perkara,
            'tgl_ba15' => $this->tgl_ba15,
            'tgl_sp' => $this->tgl_sp,
            'tgl_penetapan' => $this->tgl_penetapan,
            'tgl_diterima' => $this->tgl_diterima,
            'tgl_ba4' => $this->tgl_ba4,
            'id_tersangka' => $this->id_tersangka,
            'id_isipenetapan' => $this->id_isipenetapan,
            'tgl_awal_cara' => $this->tgl_awal_cara,
            'tgl_akhir_cara' => $this->tgl_akhir_cara,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_sp', $this->no_sp])
            ->andFilterWhere(['like', 'no_p16a', $this->no_p16a])
            ->andFilterWhere(['like', 'penetapan', $this->penetapan])
            ->andFilterWhere(['like', 'no_penetapan', $this->no_penetapan])
            ->andFilterWhere(['like', 'no_surat_t7', $this->no_surat_t7])
            ->andFilterWhere(['like', 'memerintahkan', $this->memerintahkan])
            ->andFilterWhere(['like', 'nip_jaksa', $this->nip_jaksa])
            ->andFilterWhere(['like', 'nama_jaksa', $this->nama_jaksa])
            ->andFilterWhere(['like', 'jabatan_jaksa', $this->jabatan_jaksa])
            ->andFilterWhere(['like', 'jenis_cara1', $this->jenis_cara1])
            ->andFilterWhere(['like', 'jenis_cara2', $this->jenis_cara2])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'pangkat_jaksa', $this->pangkat_jaksa]);

        return $dataProvider;
    }
}
