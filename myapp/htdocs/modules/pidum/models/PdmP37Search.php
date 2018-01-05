<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmP37;

/**
 * PdmP37Search represents the model behind the search form about `app\modules\pidum\models\PdmP37`.
 */
class PdmP37Search extends PdmP37
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p37', 'tmpt_lahir', 'tgl_lahir', 'alamat', 'no_identitas', 'no_hp', 'pekerjaan', 'suku', 'nama', 'nama_hadap', 'alamat_hadap', 'tgl_hadap', 'jam', 'keperluan', 'dikeluarkan', 'tgl_dikeluarkan', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'id_penandatangan', 'no_reg_tahanan', 'nip', 'jabatan', 'pangkat'], 'safe'],
            [['id_msstatusdata', 'warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan', 'created_by', 'updated_by','id_ms_sts_data'], 'integer'],
            [['umur'], 'number'],
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
        $query = PdmP37::find();

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
            'id_msstatusdata' => $this->id_msstatusdata,
            'tgl_lahir' => $this->tgl_lahir,
            'warganegara' => $this->warganegara,
            'id_jkl' => $this->id_jkl,
            'id_identitas' => $this->id_identitas,
            'id_agama' => $this->id_agama,
            'id_pendidikan' => $this->id_pendidikan,
            'umur' => $this->umur,
            'tgl_hadap' => $this->tgl_hadap,
            'jam' => $this->jam,
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
            'no_register_perkara' => $no_register_perkara,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_surat_p37', $this->no_surat_p37])
            ->andFilterWhere(['like', 'tmpt_lahir', $this->tmpt_lahir])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_identitas', $this->no_identitas])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
            ->andFilterWhere(['like', 'suku', $this->suku])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'nama_hadap', $this->nama_hadap])
            ->andFilterWhere(['like', 'alamat_hadap', $this->alamat_hadap])
            ->andFilterWhere(['like', 'keperluan', $this->keperluan])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'pangkat', $this->pangkat])
            ->andFilterWhere(['like', 'id_ms_sts_data', $this->id_ms_sts_data]);

        return $dataProvider;
    }
}
