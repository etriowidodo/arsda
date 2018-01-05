<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBaKonsultasi;

/**
 * PdmBaKonsultasiSearch represents the model behind the search form about `app\modules\pidum\models\PdmBaKonsultasi`.
 */
class PdmBaKonsultasiSearch extends PdmBaKonsultasi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perkara', 'tgl_pelaksanaan', 'nip_jaksa', 'nama_jaksa', 'jabatan_jaksa', 'nip_penyidik', 'nama_penyidik', 'jabatan_penyidik', 'konsultasi_formil', 'konsultasi_materil', 'kesimpulan', 'created_by', 'created_ip', 'created_time', 'updated_ip', 'updated_by', 'updated_time','file_upload'], 'safe'],
            [['id_ba_konsultasi'], 'integer'],
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
    public function search($params,$id_perkara)
    {
        $query = PdmBaKonsultasi::find();

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
            'id_perkara'=>$id_perkara,
            'id_ba_konsultasi' => $this->id_ba_konsultasi,
            'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'nip_jaksa', $this->nip_jaksa])
            ->andFilterWhere(['like', 'nama_jaksa', $this->nama_jaksa])
            ->andFilterWhere(['like', 'jabatan_jaksa', $this->jabatan_jaksa])
            ->andFilterWhere(['like', 'nip_penyidik', $this->nip_penyidik])
            ->andFilterWhere(['like', 'nama_penyidik', $this->nama_penyidik])
            ->andFilterWhere(['like', 'jabatan_penyidik', $this->jabatan_penyidik])
            ->andFilterWhere(['like', 'konsultasi_formil', $this->konsultasi_formil])
            ->andFilterWhere(['like', 'konsultasi_materil', $this->konsultasi_materil])
            ->andFilterWhere(['like', 'file_upload', $this->file_upload])
            ->andFilterWhere(['like', 'kesimpulan', $this->kesimpulan])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
