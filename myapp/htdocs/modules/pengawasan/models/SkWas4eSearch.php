<?php

namespace app\modules\pengawasan\models;

// use Yii;
// use yii\base\Model;
// use yii\data\ActiveDataProvider;
// use app\modules\pengawasan\models\SkWas4e;
// use yii\db\Query;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use app\modules\pengawasan\models\BaWas3Inspeksi;
use app\modules\pengawasan\components\FungsiComponent;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * SkWas4eSearch represents the model behind the search form about `app\modules\pengawasan\models\SkWas4e`.
 */
class SkWas4eSearch extends SkWas4e
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_lapdu', 'tgl_sk_was_4e', 'tgl_diterima_sk_was_4e', 'created_time', 'updated_time','id_tingkat','id_kejati', 'id_kejari', 'id_cabjari',
              'no_register','no_sk_was_4e', 'golongan_pegawai_terlapor','pasal', 'nama_pegawai_terlapor', 'jabatan_pegawai_terlapor', 'nama_penandatangan',
              'waktu_kejadian', 'pangkat_pegawai_terlapor', 'pangkat_penandatangan','id_terlapor','nip_pegawai_terlapor', 'nip_penandatangan',
              'satker_pegawai_terlapor', 'unit_kerja_terlapor', 'jabatan_penandatangan','di_tempat','golongan_penandatangan','upload_file','created_ip', 'updated_ip'  ], 'safe'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_sk_was_4e', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'created_by', 'updated_by'], 'integer'],
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
        $query = SkWas4e::find(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                                       'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                                       'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                                       'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                       'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

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
            'tgl_sk_was_4e' => $this->tgl_sk_was_4e,
           // 'ttd_sk_was_4e' => $this->ttd_sk_was_4e,
           // 'ttd_id_jabatan' => $this->ttd_id_jabatan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_sk_was_4e', $this->id_sk_was_4e])
            ->andFilterWhere(['like', 'no_sk_was_4e', $this->no_sk_was_4e]);
           // ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
           // ->andFilterWhere(['like', 'id_register', $this->id_register])
            // ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            // ->andFilterWhere(['like', 'tingkat_kd', $this->tingkat_kd])
            // ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
            // ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            // ->andFilterWhere(['like', 'flag', $this->flag])
            // ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            // ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

    public function searchIndex($params)
     {
         $query="select b.bentuk_pelanggaran as keterangan,a.*,c.*,d.id_sk_was_4e,d.no_sk_was_4e,
                d.nip_pegawai_terlapor as nip_trlp,e.* 
                from was.ba_was_8 a
                left join was.l_was_2_terlapor b on a.id_tingkat=b.id_tingkat 
                and a.id_kejati=b.id_kejati 
                and a.id_kejari=b.id_kejari 
                and a.id_cabjari=b.id_cabjari 
                and a.no_register=b.no_register 
                and a.nip_terlapor=b.nip_terlapor 
                inner join was.ms_sk c on a.sk=c.kode_sk
                left join was.sk_was_4e d
                on b.nip_terlapor=d.nip_pegawai_terlapor
                left join was.was10_inspeksi e on a.id_tingkat=e.id_tingkat and a.id_kejati=e.id_kejati 
                and a.id_kejari=e.id_kejari and a.id_cabjari=e.id_cabjari and a.no_register=e.no_register 
                and b.nip_terlapor=e.nip_pegawai_terlapor and e.trx_akhir=1 
                where b.no_register='".$_SESSION['was_register']."' and b.id_tingkat='".$_SESSION['kode_tk']."' 
                and b.id_kejati='".$_SESSION['kode_kejati']."' and b.id_kejari='".$_SESSION['kode_kejari']."' 
                and b.id_cabjari='".$_SESSION['kode_cabjari']."'and b.id_wilayah='".$_SESSION['was_id_wilayah']."' 
                and b.id_level1='".$_SESSION['was_id_level1']."' and b.id_level2='".$_SESSION['was_id_level2']."' 
                and b.id_level3='".$_SESSION['was_id_level3']."' and b.id_level4='".$_SESSION['was_id_level4']."' 
                and a.terima_tolak='1' and c.kode_sk='SK-WAS4-E' 
                union 
                select b.bentuk_pelanggaran as keterangan,a.*,c.*,d.id_sk_was_4e,d.no_sk_was_4e,
                d.nip_pegawai_terlapor as nip_trlp,e.* 
                from was.ba_was_9 a
                left join was.l_was_2_terlapor b on a.id_tingkat=b.id_tingkat 
                and a.id_kejati=b.id_kejati 
                and a.id_kejari=b.id_kejari 
                and a.id_cabjari=b.id_cabjari 
                and a.no_register=b.no_register 
                and a.nip_terlapor=b.nip_terlapor 
                inner join was.ms_sk c on a.sk=c.kode_sk
                left join was.sk_was_4e d
                on b.nip_terlapor=d.nip_pegawai_terlapor
                left join was.was10_inspeksi e on a.id_tingkat=e.id_tingkat and a.id_kejati=e.id_kejati 
                and a.id_kejari=e.id_kejari and a.id_cabjari=e.id_cabjari and a.no_register=e.no_register 
                and b.nip_terlapor=e.nip_pegawai_terlapor and e.trx_akhir=1 
                where b.no_register='".$_SESSION['was_register']."' and b.id_tingkat='".$_SESSION['kode_tk']."' 
                and b.id_kejati='".$_SESSION['kode_kejati']."' and b.id_kejari='".$_SESSION['kode_kejari']."' 
                and b.id_cabjari='".$_SESSION['kode_cabjari']."'and b.id_wilayah='".$_SESSION['was_id_wilayah']."' 
                and b.id_level1='".$_SESSION['was_id_level1']."' and b.id_level2='".$_SESSION['was_id_level2']."' 
                and b.id_level3='".$_SESSION['was_id_level3']."' and b.id_level4='".$_SESSION['was_id_level4']."' 
                and a.terima_tolak='1' and c.kode_sk='SK-WAS4-E'";
        // print_r($query);
        // exit();
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          // $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
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

    public function searchDataSkWas4e($id_register){
        $query = new Query;
         $query ->select('a.peg_nama, a.jabatan, a.peg_nip, a.peg_nrp, c.no_sk_was_4e,c.id_sk_was_4e,c.id_register')
                ->from('was.v_terlapor a')
                 ->innerjoin('was.sk_was_4e c','a.id_terlapor=c.id_terlapor')
                 ->where(['c.id_register' =>$id_register])
                 ->andWhere(['not in', 'c.flag', [3]])
                 ->all();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;    
    }

     public function searchPenandatangan($params)
    {
        $query="select*from was.v_penandatangan where id_surat='Skwas2a' and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) ='".($keyWord)."'";
          $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%'";
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
