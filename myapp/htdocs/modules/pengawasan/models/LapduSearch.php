<?php

// namespace app\models;
namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
// use app\models\Lapdu;
use app\modules\pengawasan\models\Lapdu;
// use app\modules\pengawasan\models\DugaanPelanggaranIndex;
use yii\data\SqlDataProvider;
use app\modules\pengawasan\models\Terlapor;
use app\modules\pengawasan\models\WasLapduindex;
use app\modules\pengawasan\models\WasInspekturindex;
use app\modules\pengawasan\models\WasIrmudindex;
use app\modules\pengawasan\models\MsIdentitas;
use yii\db\Query;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Command;


/**
 * LapduSearch represents the model behind the search form about `app\models\Lapdu`.
 */
class LapduSearch extends Lapdu
{   
    // public $cari;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register','tanggal_surat_diterima', 'nomor_surat_lapdu', 'perihal_lapdu', 'tanggal_surat_lapdu', 'ringkasan_lapdu', 'file_lapdu', 'id_media_pelaporan','kepada_lapdu'], 'safe'],
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
        $query=" select A.id_tingkat,A.id_kejati,A.id_kejari,A.id_cabjari, A.no_register,A.perihal_lapdu ,A.tgl_disposisi,
             (select string_agg(B.nama_pelapor,'#' order by B.no_urut) from was.pelapor B where B.no_register = A.no_register) as Pelapor ,
             (select string_agg((select E.nama_sumber_laporan from was.sumber_laporan E where E.id_sumber_laporan = C.id_sumber_laporan),'#' order by no_urut) from was.pelapor C where C.no_register = A.no_register) as id_sumber_laporan ,
             (select string_agg(D.nama_terlapor_awal,'#' order by D.no_urut) from was.terlapor_awal D where D.no_register = A.no_register ) as Terlapor  ,
             (select string_agg(F.satker_terlapor_awal,'#' order by no_urut) from was.terlapor_awal F where F.no_register = A.no_register) as Satker_Terlapor ,
             (select string_agg(COALESCE(G.status,'LAPDU'),'#' order by G.urut_terlapor,G.no_urut) from was.was_disposisi_irmud G where G.no_register = A.no_register) as Status,A.status as status_lapdu
             from was.lapdu A";
        $keyWord  = htmlspecialchars($_GET['LapduSearch']['cari'], ENT_QUOTES);
         if($_GET['LapduSearch']['cari']!=''){
          $query .=" where  no_register ='".$keyWord."'";
          $query .=" or  status ='".($keyWord)."'";
          // $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%'";
         }
          $query .=" order by created_time DESC";


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 8,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
        
    }

        public function searchinspektur($params)
    {
        $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
        // $query = new Query;
         $query = WasInspekturindex::findBySql("SELECT DISTINCT a.no_register,
( SELECT string_agg(terlapor_awal.id_terlapor_awal::text, '#'::text) AS string_agg
           FROM was.terlapor_awal
          WHERE terlapor_awal.no_register::text = a.no_register::text and  terlapor_awal.id_inspektur=".$var[0].") AS id_terlapor_awal,
( SELECT string_agg(terlapor_awal.nama_terlapor_awal::text, '#'::text) AS string_agg
           FROM was.terlapor_awal
          WHERE terlapor_awal.no_register::text = a.no_register::text and  terlapor_awal.id_inspektur=".$var[0].") AS nama_terlapor_awal,
( SELECT string_agg(terlapor_awal.id_inspektur::text, '#'::text) AS string_agg
           FROM was.terlapor_awal
          WHERE terlapor_awal.no_register::text = a.no_register::text and  terlapor_awal.id_inspektur=".$var[0].") AS id_inspektur,
( SELECT string_agg(terlapor_awal.satker_terlapor_awal::text, '#'::text) AS string_agg
           FROM was.terlapor_awal
          WHERE terlapor_awal.no_register::text = a.no_register::text and  terlapor_awal.id_inspektur=".$var[0].") AS satker_terlapor_awal,
( SELECT string_agg(sumber_laporan.sumber_laporan::text, '#'::text) AS string_agg
           FROM ( SELECT 
                        CASE
                            WHEN x.id_sumber_laporan::text = '11'::text THEN ('LSM '::text || x.sumber_lainnya::text)::character varying
                            WHEN x.id_sumber_laporan::text = '13'::text THEN ('Sumber lainnya '::text || x.sumber_lainnya::text)::character varying
                            ELSE y.akronim
                        END AS sumber_laporan
                   FROM was.pelapor x
              JOIN was.sumber_laporan y ON x.id_sumber_laporan::text = y.id_sumber_laporan::text
             WHERE x.no_register::text = a.no_register::text
             ORDER BY x.id_pelapor) sumber_laporan) AS sumber_laporan,
( SELECT string_agg(pelapor.nama_pelapor::text, '#'::text) AS string_agg
           FROM was.pelapor
          WHERE pelapor.no_register::text = a.no_register::text) AS nama_pelapor,
 ( SELECT coalesce(string_agg(h.status_pemeriksa1::text, '#'::text),'LAPDU') AS status
           FROM was.terlapor_awal g
      LEFT JOIN was.was_disposisi_irmud h ON g.id_terlapor_awal::text = h.id_terlapor_awal::text
     WHERE g.no_register::text = a.no_register::text AND h.pemeriksa_1 = true) AS satus1, 
    ( SELECT coalesce(string_agg(h.status_pemeriksa2::text, '#'::text),'LAPDU') AS status
           FROM was.terlapor_awal g
      LEFT JOIN was.was_disposisi_irmud h ON g.id_terlapor_awal::text = h.id_terlapor_awal::text
     WHERE g.no_register::text = a.no_register::text AND h.pemeriksa_2 = true) AS satus2,c.perihal_lapdu,c.created_time,a.level_was as status
             
   FROM was.terlapor_awal a
   LEFT JOIN was.was_disposisi_inspektur b ON a.id_terlapor_awal::text = b.id_terlapor_awal::text
   LEFT JOIN was.lapdu c ON a.no_register::text = c.no_register::text
   where b.id_inspektur=".$var[0]."
  GROUP BY a.no_register,a.id_inspektur,a.id_terlapor_awal,c.perihal_lapdu,c.created_time,a.level_was");


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere([
        //     'tanggal_surat_terima' => $this->tanggal_surat_terima,
        //     'tanggal_surat_lapdu' => $this->tanggal_surat_lapdu,
        // ]);

         $query->andFilterWhere(['like', 'upper(no_register)',strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(nama_terlapor_awal)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(perihal_lapdu)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(nama_pelapor)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(sumber_laporan)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(satker_terlapor_awal)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(satus1)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(satus2)', strtoupper($params['LapduSearch']['cari'])]);
            // ->andFilterWhere(['=', 'id_inspektur', $_SESSION['inspektur']]);
            // ->andFilterWhere(['like', 'id_media_pelaporan', $this->id_media_pelaporan])
            // ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd]);

           
        return $dataProvider;
    }

    public function searchirmud($params)
    {
        $query = WasIrmudindex::find()->orderBy('created_time desc');
        $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
        if($var[1]=='1'){
        $cek_irmud="irmud_pegasum_kepbang";
        }else if($var[1]=='2'){
        $cek_irmud="irmud_pidum_datun";
        }else if($var[1]=='3'){
        $cek_irmud="irmud_intel_pidsus";
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

        // $query->andFilterWhere([
        //     'tanggal_surat_terima' => $this->tanggal_surat_terima,
        //     'tanggal_surat_lapdu' => $this->tanggal_surat_lapdu,
        // ]);

        $query->andFilterWhere(['like', 'upper(no_register)',strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(nama_terlapor_awal)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(perihal_lapdu)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(nama_pelapor)', strtoupper($params['LapduSearch']['cari'])])
			->orFilterWhere(['like', 'upper(sumber_laporan)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(satker_terlapor_awal)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(satus1)', strtoupper($params['LapduSearch']['cari'])])
            ->orFilterWhere(['like', 'upper(satus2)', strtoupper($params['LapduSearch']['cari'])])
            ->andFilterWhere(['=', 'id_inspektur', $var[0]])
            ->andFilterWhere(['=', 'id_irmud', $var[1]]);
			// ->andFilterWhere(['=', $cek_irmud, "TRUE"]);
            // ->andFilterWhere(['=', 'b.id_inspektur', $var[0]]);
            // ->andFilterWhere(['like', 'id_media_pelaporan', $this->id_media_pelaporan])
            // ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd]);

        return $dataProvider;
    }

    public function searchBidang($params)
    {
        $query="select id_wilayah,id_level1,id_level2,\"UNITKERJA_AKRONIM\" as nama_kejagung_unit from kepegawaian.v_kp_unit_kerja where id_wilayah='1'  and id_level3='0' and id_level4='0' and id_level2<>'0'";
        $keyWord  = htmlspecialchars($_GET['Lapdu']['cmb_bidang'], ENT_QUOTES);
         if($_GET['Lapdu']['cmb_bidang']!=''){
          $query .=" and  id_level1 ='".$keyWord."'";
          // $query .=" or  upper(nip) ='".($keyWord)."'";
          // $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%'";
         }
          $query .=" order by id_level1,id_level2";


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 8,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }

    public function searchKejati($params)
    {
        $query="select a.*,b.inst_nama from was.wilayah_inspektur a inner JOIN kepegawaian.kp_inst_satker b on a.id_kejati=kode_kejati and kode_tk='1' where id_wilayah='1'";
        $keyWord  = htmlspecialchars($_GET['Lapdu']['cari_kejati'], ENT_QUOTES);
         if($_GET['Lapdu']['cari_kejati']!=''){
          $query .=" and  upper(inst_nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(nip) ='".($keyWord)."'";
          // $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%'";
         }
          $query .=" order by id_kejati";


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 8,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }

    public function searchKejari($params)
    {
        $query="select a.*,b.inst_nama,b.kode_kejari,(select d.inst_nama from was.wilayah_inspektur c inner JOIN kepegawaian.kp_inst_satker d on c.id_kejati=d.kode_kejati and d.kode_tk='1' where c.id_wilayah='1' and c.id_kejati=a.id_kejati) as nama_kejati from was.wilayah_inspektur a inner JOIN kepegawaian.kp_inst_satker b on a.id_kejati=b.kode_kejati and b.kode_tk='2' where b.kode_tk='2' and a.id_wilayah='1'";
        $keyWord  = htmlspecialchars($_GET['Lapdu']['cari_kejari'], ENT_QUOTES);
         if($_GET['Lapdu']['cari_kejari']!=''){
          $query .=" and  upper(inst_nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(nip) ='".($keyWord)."'";
          // $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%'";
         }
          $query .=" order by id_kejati";


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 8,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }

    public function searchCabjari($params)
    {
        $query="select a.*,b.inst_nama,b.kode_cabjari,b.kode_kejari,b.kode_kejati,
            (select d.inst_nama from was.wilayah_inspektur c inner JOIN kepegawaian.kp_inst_satker d on c.id_kejati=d.kode_kejati and d.kode_tk='2' where d.kode_tk='2' and c.id_wilayah='1' and d.kode_kejati=b.kode_kejati and d.kode_kejari=b.kode_kejari) as nama_kejari,
            (select f.inst_nama from was.wilayah_inspektur e inner JOIN kepegawaian.kp_inst_satker f on e.id_kejati=f.kode_kejati and f.kode_tk='1' where f.kode_tk='1' and e.id_wilayah='1' and f.kode_kejati=b.kode_kejati ) as nama_kejati
            from was.wilayah_inspektur a inner JOIN kepegawaian.kp_inst_satker b on a.id_kejati=b.kode_kejati and b.kode_tk='3' where b.kode_tk='3' and a.id_wilayah='1'";
        $keyWord  = htmlspecialchars($_GET['Lapdu']['cari_cabjari'], ENT_QUOTES);
         if($_GET['Lapdu']['cari_cabjari']!=''){
          $query .=" and  upper(inst_nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(nip) ='".($keyWord)."'";
          // $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%'";
         }
          $query .=" order by id_kejati";


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 8,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }
}
