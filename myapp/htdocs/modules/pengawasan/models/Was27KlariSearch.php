<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was27Klari;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * Was27KlariSearch represents the model behind the search form about `app\modules\pengawasan\models\Was27Klari`.
 */
class Was27KlariSearch extends Was27Klari
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jml_lampiran', 'persetujuan', 'no_register', 'tgl_lapdu', 'no_was_27_klari', 'tgl', 'upload_file_data', 'analisa', 'kesimpulan','nip_penandatangan', 'jabatan_penandatangan', 'created_ip', 'created_time', 'updated_ip', 'updated_time','permasalahan','data_data'], 'safe'],
            [['sifat_surat', 'created_by', 'updated_by'], 'integer'],
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
        $query = Was27Klari::find();

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
            // 'rncn_henti_riksa_1_was_27_kla' => $this->rncn_henti_riksa_1_was_27_kla,
            // 'rncn_henti_riksa_2_was_27_kla' => $this->rncn_henti_riksa_2_was_27_kla,
            // 'pendapat_1_was_27_kla' => $this->pendapat_1_was_27_kla,
            'persetujuan' => $this->persetujuan,
            // 'ttd_was_27_klari' => $this->ttd_was_27_klari,
            // 'flag' => $this->flag,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_was_27_klari', $this->id_was_27_klari])
            ->andFilterWhere(['like', 'no_register', $this->no_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'no_was_27_klari', $this->no_was_27_klari])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like', 'upload_file_data', $this->upload_file_data])
            ->andFilterWhere(['like', 'analisa', $this->analisa])
            ->andFilterWhere(['like', 'kesimpulan', $this->kesimpulan])
            ->andFilterWhere(['like', 'pendapat', $this->pendapat])
            ->andFilterWhere(['like', 'nip_penandatangan', $this->nip_penandatangan])
            ->andFilterWhere(['like', 'jabatan_penandatangan', $this->jabatan_penandatangan])
            // ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
    
     public function searchPenandatangan($params)
    {
        $query="select*from was.v_penandatangan where id_surat='was27klari' and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  (upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) ='".($keyWord)."'";
          $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%')";
         }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 10,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }
}
