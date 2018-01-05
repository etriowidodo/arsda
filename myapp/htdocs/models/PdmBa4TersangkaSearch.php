<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PdmBa4Tersangka;

/**
 * PdmBa4TersangkaSearch represents the model behind the search form about `app\models\PdmBa4Tersangka`.
 */
class PdmBa4TersangkaSearch extends PdmBa4Tersangka
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba4', 'id_peneliti', 'no_reg_tahanan', 'no_reg_perkara', 'alasan', 'id_penandatangan', 'upload_file', 'tmpt_lahir', 'tgl_lahir', 'alamat', 'no_identitas', 'no_hp', 'pekerjaan', 'suku', 'nama', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'nama_ttd', 'pangkat_ttd', 'jabatan_ttd', 'updated_time', 'created_by', 'updated_by', 'foto'], 'safe'],
            [['no_urut_tersangka', 'warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan'], 'integer'],
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
    public function search($params)
    {
        $query = PdmBa4Tersangka::find();

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
            'tgl_ba4' => $this->tgl_ba4,
            'no_urut_tersangka' => $this->no_urut_tersangka,
            'tgl_lahir' => $this->tgl_lahir,
            'warganegara' => $this->warganegara,
            'id_jkl' => $this->id_jkl,
            'id_identitas' => $this->id_identitas,
            'id_agama' => $this->id_agama,
            'id_pendidikan' => $this->id_pendidikan,
            'umur' => $this->umur,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'id_peneliti', $this->id_peneliti])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'no_reg_perkara', $this->no_reg_perkara])
            ->andFilterWhere(['like', 'alasan', $this->alasan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'tmpt_lahir', $this->tmpt_lahir])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_identitas', $this->no_identitas])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
            ->andFilterWhere(['like', 'suku', $this->suku])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'nama_ttd', $this->nama_ttd])
            ->andFilterWhere(['like', 'pangkat_ttd', $this->pangkat_ttd])
            ->andFilterWhere(['like', 'jabatan_ttd', $this->jabatan_ttd])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'foto', $this->foto]);

        return $dataProvider;
    }
}
