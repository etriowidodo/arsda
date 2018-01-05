<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmNotaPendapat;

/**
 * PdmNotaPendapatSearch represents the model behind the search form about `app\modules\pidum\models\PdmNotaPendapat`.
 */
class PdmNotaPendapatSearch extends PdmNotaPendapat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'jenis_nota_pendapat', 'kepada', 'dari_nip_jaksa_p16a', 'dari_nama_jaksa_p16a', 'dari_jabatan_jaksa_p16a', 'dari_pangkat_jaksa_p16a', 'tgl_nota', 'perihal_nota', 'dasar_nota', 'pendapat_nota', 'saran_nota', 'petunjuk_nota', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['id_nota_pendapat', 'flag_saran', 'flag_pentunjuk', 'created_by', 'updated_by'], 'integer'],
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
        $query = PdmNotaPendapat::find();

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
            'id_nota_pendapat' => $this->id_nota_pendapat,
            'tgl_nota' => $this->tgl_nota,
            'flag_saran' => $this->flag_saran,
            'flag_pentunjuk' => $this->flag_pentunjuk,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'jenis_nota_pendapat', $this->jenis_nota_pendapat])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'dari_nip_jaksa_p16a', $this->dari_nip_jaksa_p16a])
            ->andFilterWhere(['like', 'dari_nama_jaksa_p16a', $this->dari_nama_jaksa_p16a])
            ->andFilterWhere(['like', 'dari_jabatan_jaksa_p16a', $this->dari_jabatan_jaksa_p16a])
            ->andFilterWhere(['like', 'dari_pangkat_jaksa_p16a', $this->dari_pangkat_jaksa_p16a])
            ->andFilterWhere(['like', 'perihal_nota', $this->perihal_nota])
            ->andFilterWhere(['like', 'dasar_nota', $this->dasar_nota])
            ->andFilterWhere(['like', 'pendapat_nota', $this->pendapat_nota])
            ->andFilterWhere(['like', 'saran_nota', $this->saran_nota])
            ->andFilterWhere(['like', 'petunjuk_nota', $this->petunjuk_nota])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

     public function showNotaPendapat()
    {
        $connection     = \Yii::$app->db;
        $no_register             = $session->get('no_register_perkara');
        $qry_jns                 = "select *  pidum.pdm_nota_pendapat where no_register_perkara ='".$no_register."'";
        $qry_jns_1               = $connection->createCommand($qry_jns);
        $modelnotaPendapat       = $qry_jns_1->queryAll();

        return $modelnotaPendapat;

    }
}
