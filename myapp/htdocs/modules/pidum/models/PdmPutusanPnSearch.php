<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmPutusanPn;

/**
 * PdmPutusanPnSearch represents the model behind the search form about `app\modules\pidum\models\PdmPutusanPn`.
 */
class PdmPutusanPnSearch extends PdmPutusanPn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat', 'sifat', 'lampiran', 'kepada', 'di_kepada', 'dikeluarkan', 'tgl_dikeluarkan', 'no_persidangan', 'tgl_persidangan', 'pasal_bukti', 'kasus_posisi', 'kerugian_negara', 'mati', 'luka', 'akibat_lain', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_log', 'updated_time', 'pengadilan', 'usul'], 'safe'],
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
    public function search($no_register, $params)
    {
        $query = PdmPutusanPn::find();

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
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'tgl_persidangan' => $this->tgl_persidangan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'no_persidangan', $this->no_persidangan])
            ->andFilterWhere(['like', 'pasal_bukti', $this->pasal_bukti])
            ->andFilterWhere(['like', 'kasus_posisi', $this->kasus_posisi])
            ->andFilterWhere(['like', 'kerugian_negara', $this->kerugian_negara])
            ->andFilterWhere(['like', 'mati', $this->mati])
            ->andFilterWhere(['like', 'luka', $this->luka])
            ->andFilterWhere(['like', 'akibat_lain', $this->akibat_lain])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'updated_log', $this->updated_log])
            ->andFilterWhere(['like', 'pengadilan', $this->pengadilan])
            ->andFilterWhere(['like', 'usul', $this->usul]);

        return $dataProvider;
    }

    public function searchUpayahukum($no_akta, $params)
    {
        $query = PdmPutusanPn::find();

        

        $this->load($params);
        $query->andWhere(['=', 'no_akta', $no_register])
                ->andWhere(['is not', 'status_yakum', NULL]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'tgl_persidangan' => $this->tgl_persidangan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'no_persidangan', $this->no_persidangan])
            ->andFilterWhere(['like', 'pasal_bukti', $this->pasal_bukti])
            ->andFilterWhere(['like', 'kasus_posisi', $this->kasus_posisi])
            ->andFilterWhere(['like', 'kerugian_negara', $this->kerugian_negara])
            ->andFilterWhere(['like', 'mati', $this->mati])
            ->andFilterWhere(['like', 'luka', $this->luka])
            ->andFilterWhere(['like', 'akibat_lain', $this->akibat_lain])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'updated_log', $this->updated_log])
            ->andFilterWhere(['like', 'pengadilan', $this->pengadilan])
            
            ->andFilterWhere(['like', 'usul', $this->usul]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //echo '<pre>';print_r($query);exit;

        return $dataProvider;
    }



}
