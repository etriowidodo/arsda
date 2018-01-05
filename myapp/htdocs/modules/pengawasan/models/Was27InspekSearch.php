<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was27Inspek;
use yii\db\Query;

/**
 * Was27InspekSearch represents the model behind the search form about `app\modules\pengawasan\models\Was27Inspek`.
 */
class Was27InspekSearch extends Was27Inspek
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_27_inspek', 'id_register', 'inst_satkerkd', 'no_was_27_inspek', 'tgl', 'data_data', 'upload_file_data', 'analisa', 'kesimpulan', 'pendapat', 'ttd_peg_nik', 'ttd_id_jabatan', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'rncn_henti_riksa_1_was_27_ins', 'rncn_henti_riksa_2_was_27_ins', 'pendapat_1_was_27_ins', 'persetujuan', 'ttd_was_27_inspek', 'flag', 'created_by', 'updated_by'], 'integer'],
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
        $query = Was27Inspek::find();

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
            'tgl' => $this->tgl,
            'sifat_surat' => $this->sifat_surat,
            'jml_lampiran' => $this->jml_lampiran,
            'satuan_lampiran' => $this->satuan_lampiran,
            'rncn_henti_riksa_1_was_27_ins' => $this->rncn_henti_riksa_1_was_27_ins,
            'rncn_henti_riksa_2_was_27_ins' => $this->rncn_henti_riksa_2_was_27_ins,
            'pendapat_1_was_27_ins' => $this->pendapat_1_was_27_ins,
            'persetujuan' => $this->persetujuan,
            'ttd_was_27_inspek' => $this->ttd_was_27_inspek,
            'flag' => $this->flag,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_was_27_inspek', $this->id_was_27_inspek])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'no_was_27_inspek', $this->no_was_27_inspek])
            ->andFilterWhere(['like', 'data_data', $this->data_data])
            ->andFilterWhere(['like', 'upload_file_data', $this->upload_file_data])
            ->andFilterWhere(['like', 'analisa', $this->analisa])
            ->andFilterWhere(['like', 'kesimpulan', $this->kesimpulan])
            ->andFilterWhere(['like', 'pendapat', $this->pendapat])
            ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
            ->andFilterWhere(['like', 'ttd_id_jabatan', $this->ttd_id_jabatan])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
    
      public function searchTerlaporWas27Inspek1($idRegister)
    {
         $query = new Query;
 

        $query->select('a.peg_nama, b.id_terlapor, d.saran,d.rncn_henti_riksa_was_27_ins')
                ->from('was.v_riwayat_jabatan a')
                ->innerJoin('was.terlapor b on (a.id=b.id_h_jabatan)')
                ->leftJoin('was.was_27_inspek c on(b.id_register = c.id_register)')
                ->leftJoin('was.was_27_inspek_detail d on (c.id_was_27_inspek = d.id_was_27_inspek and d.id_terlapor = b.id_terlapor)')
                ->where("b.id_register = :idRegister and (rncn_henti_riksa_was_27_ins ='1' or rncn_henti_riksa_was_27_ins is null )")
                ->addParams([':idRegister' => $idRegister])
                ->orderBy(' b.id_terlapor');
               // ->all();
      $command = $query->createCommand();
      $rows = $command->queryAll();
        return $rows ;
    }
     public function searchTerlaporWas27Inspek2($idRegister)
    {
         $query = new Query;
 

        $query->select('a.peg_nama, b.id_terlapor, d.saran,d.rncn_henti_riksa_was_27_ins')
                ->from('was.v_riwayat_jabatan a')
                ->innerJoin('was.terlapor b on (a.id=b.id_h_jabatan)')
                ->leftJoin('was.was_27_inspek c on(b.id_register = c.id_register)')
                ->leftJoin('was.was_27_inspek_detail d on (c.id_was_27_inspek = d.id_was_27_inspek and d.id_terlapor = b.id_terlapor)')
                ->where("b.id_register = :idRegister and (rncn_henti_riksa_was_27_ins ='2' or rncn_henti_riksa_was_27_ins is null )")
                ->addParams([':idRegister' => $idRegister])
                ->orderBy(' b.id_terlapor');
               // ->all();
      $command = $query->createCommand();
      $rows = $command->queryAll();
        return $rows ;
    }
}
