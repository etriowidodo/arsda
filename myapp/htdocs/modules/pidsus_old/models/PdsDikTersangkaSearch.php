<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\PdsDikTersangka;

/**
 * PdsDikTersangkaSearch represents the model behind the search form about `app\modules\pidsus\models\PdsDikTersangka`.
 */
class PdsDikTersangkaSearch extends PdsDikTersangka
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_dik_tersangka', 'id_pds_dik', 'nama_tersangka', 'tempat_lahir', 'tgl_lahir', 'kewarganegaraan', 'alamat', 'pekerjaan', 'create_by', 'create_date', 'update_by', 'update_date', 'nomor_id', 'suku', 'flag'], 'safe'],
            [['jenis_kelamin', 'agama', 'pendidikan', 'jenis_id'], 'integer'],
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
    public function search($params,$idPdsDik=null)
    {
        $query = PdsDikTersangka::find();
		if($idPdsDik!=null){
			$query->where(['id_pds_dik'=>$idPdsDik]);
		}
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
            'tgl_lahir' => $this->tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'pendidikan' => $this->pendidikan,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'jenis_id' => $this->jenis_id,
        ]);

        $query->andFilterWhere(['like', 'id_pds_dik_tersangka', $this->id_pds_dik_tersangka])
            ->andFilterWhere(['like', 'id_pds_dik', $this->id_pds_dik])
            ->andFilterWhere(['like', 'nama_tersangka', $this->nama_tersangka])
            ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
            ->andFilterWhere(['like', 'kewarganegaraan', $this->kewarganegaraan])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
            ->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'update_by', $this->update_by])
            ->andFilterWhere(['like', 'nomor_id', $this->nomor_id])
            ->andFilterWhere(['like', 'suku', $this->suku])
            ->andFilterWhere(['like', 'flag', $this->flag]);

        return $dataProvider;
    }
}
