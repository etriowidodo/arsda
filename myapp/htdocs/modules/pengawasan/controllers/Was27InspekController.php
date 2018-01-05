<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was27Inspek;
use app\modules\pengawasan\models\Was27InspekSearch;
use app\modules\pengawasan\models\TembusanWas27Inspek;
use app\modules\pengawasan\models\Was27InspekDetail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Nasution\Terbilang;
use yii\db\Query;
use Odf;

/**
 * Was27InspekController implements the CRUD actions for Was27Inspek model.
 */
class Was27InspekController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Was27Inspek models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Was27InspekSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Was27Inspek model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Was27Inspek model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  /**
     * Creates a new Was27Inspek model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       
         $session = Yii::$app->session;
        if (isset($session['was_register']) && !empty($session['was_register'])) {
           $findWas = Was27Inspek::find()->where("id_register = :id and flag<>'3'",[":id"=>$session['was_register']])->asArray()->one();
            // echo "testtt1".$findWas;exit();
             if(isset($findWas) && count($findWas > 0)){
                
                  return $this->redirect(['update', 'id' => $findWas['id_was_27_inspek']]); 
             }else{
        $model = new Was27Inspek();
        $modelTembusan = new TembusanWas27Inspek();
       
        if ($model->load(Yii::$app->request->post()) ) {
             $pejabat =  $_POST['id_jabatan'];
             $terlapor1 = $_POST['id_terlapor_1'];
             $terlapor2 = $_POST['id_terlapor_2'];
             
             $saran1 = $_POST['saran_1'];
             $saran2 = $_POST['saran_2'];
           
                $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
           // $files = \yii\web\UploadedFile::getInstanceByName($model,'upload_file');
           // store the source file name
           
            $model->upload_file = $files->name;
            if($model->save()){
                for($i=0;$i<count($pejabat);$i++){
                    $saveTembusan = new TembusanWas27Inspek;
                    $saveTembusan->id_was_27_inspek = $model->id_was_27_inspek;
                    $saveTembusan->id_pejabat_tembusan = $pejabat[$i];
                    $saveTembusan->save();
                }
                for($i=0;$i<count($terlapor1);$i++){
                    $saveDetail1 = new Was27InspekDetail;
                    $saveDetail1->id_was_27_inspek = $model->id_was_27_inspek;
                    $saveDetail1->rncn_henti_riksa_was_27_ins = '1';
                    $saveDetail1->saran = $saran1[$i];
                    $saveDetail1->id_terlapor = $terlapor1[$i];
                    $saveDetail1->save();
                  //  $test = \kartik\form\ActiveForm::validate($saveDetail1);
                  //  print_r($test);exit();
                }
               
                 for($i=0;$i<count($terlapor2);$i++){
                    $saveDetail2 = new Was27InspekDetail;
                    $saveDetail2->id_was_27_inspek = $model->id_was_27_inspek;
                    $saveDetail2->rncn_henti_riksa_was_27_ins = '2';
                    $saveDetail2->saran = $saran2[$i];
                    $saveDetail2->id_terlapor = $terlapor2[$i];
                    $saveDetail2->save();
                }
                 if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'was_27_inspek/'.$files->name;
                    $files->saveAs($path);
                }
               Yii::$app->getSession()->setFlash('success', [
      'type' => 'success',
     'duration' => 3000,
     'icon' => 'fa fa-users',
     'message' => 'Data Berhasil di Simpan',
     'title' => 'Simpan Data',
     'positonY' => 'top',
     'positonX' => 'center',
     'showProgressbar' => true,
 ]);
            return $this->redirect(['update', 'id' => $model->id_was_27_inspek]);
            }else{
              Yii::$app->getSession()->setFlash('success', [
     'type' => 'danger',
     'duration' => 3000,
     'icon' => 'fa fa-users',
     'message' => 'Data Gagal di Simpan',
     'title' => 'Error',
     'positonY' => 'top',
     'positonX' => 'center',
     'showProgressbar' => true,
 ]);
               return $this->render('create', [
                'model' => $model,
                   'modelTembusan' => $modelTembusan,
                
            ]);
        }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelTembusan' => $modelTembusan,
            ]);
        }
          }
        }else{
            $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/dugaan-pelanggaran/index"));
        }
    }

    /**
     * Updates an existing Was27Inspek model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
                
        
      $model = $this->findModel($id);

        
        $modelTembusan = TembusanWas27Inspek::find()->where("id_was_27_inspek = :id",[":id"=>$model->id_was_27_inspek])->asArray()->all();
        
     
        
         $oldFileName = $model->upload_file;
        $oldFile = (isset($model->upload_file) ? Yii::$app->params['uploadPath'] .'was_27_inspek/'. $model->upload_file : null);
        if($_POST['Was27Inspek']){
         if ($model->load(Yii::$app->request->post()) ) {
             $pejabat =  $_POST['id_jabatan'];
             $terlapor1 = $_POST['id_terlapor_1'];
             $terlapor2 = $_POST['id_terlapor_2'];
             
             $saran1 = $_POST['saran_1'];
             $saran2 = $_POST['saran_2'];
             $delete_tembusan = $_POST['delete_tembusan'];
             $delete_tembusan = explode("#",$delete_tembusan);
              $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
           
               
             if ($files == false) {
                
                $model->upload_file = $oldFileName;
                
            }else{
               
                $model->upload_file = $files->name;
            }
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
           try {
            if($model->save()){
                if(count($delete_tembusan) > 1){
                   for($j=1;$j<count($delete_tembusan);$j++){
                       $deleteTembusan = TembusanWas27Inspek::find()->where('id_pejabat_tembusan = :id and id_was_27_inspek = :id_was',[":id"=>$delete_tembusan[$j],":id_was"=>$model->id_was_27_inspek])->one();
                        $deleteTembusan->delete();
                   }
                }
                for($i=0;$i<count($pejabat);$i++){
                    $saveTembusan = new TembusanWas27Inspek;
                    $saveTembusan->id_was_27_inspek = $model->id_was_27_inspek;
                    $saveTembusan->id_pejabat_tembusan = $pejabat[$i];
                    $saveTembusan->save();
                }
                 
                  for($i=0;$i<count($terlapor1);$i++){
                    $saveDetail1 = Was27InspekDetail::find()->where("id_was_27_inspek = :idWas27Inspek and id_terlapor = :idTerlapor and rncn_henti_riksa_was_27_ins ='1'",[":idWas27Inspek"=>$model->id_was_27_inspek,":idTerlapor"=>$terlapor1[$i]])->one();
                 //   $saveDetail1->id_was_27_inspek = $model->id_was_27_inspek;
                   // $saveDetail1->rncn_henti_riksa_was_27_kla = '1';
                    $saveDetail1->saran = $saran1[$i];
                   // $saveDetail1->id_terlapor = $terlapor1[$i];
                    $saveDetail1->save();
                }
               
                 for($i=0;$i<count($terlapor2);$i++){
                    $saveDetail2 = Was27InspekDetail::find()->where("id_was_27_inspek = :idWas27Inspek and id_terlapor = :idTerlapor and rncn_henti_riksa_was_27_ins ='2'",[":idWas27Inspek"=>$model->id_was_27_inspek,":idTerlapor"=>$terlapor2[$i]])->one();
                   // $saveDetail2->id_was_27_inspek = $model->id_was_27_inspek;
                 //   $saveDetail2->rncn_henti_riksa_was_27_kla = '2';
                    $saveDetail2->saran = $saran2[$i];
                 //   $saveDetail2->id_terlapor = $terlapor2[$i];
                    $saveDetail2->save();
                }
             if ($files != false && !empty($oldFileName)) { // delete old and overwrite
                    unlink($oldFile);
                    $path = \Yii::$app->params['uploadPath'].'was_27_inspek/'.$files->name;
                    $files->saveAs($path);
                }
                
             Yii::$app->getSession()->setFlash('success', [
     'type' => 'success',
     'duration' => 3000,
     'icon' => 'fa fa-users',
     'message' => 'Data Berhasil di Simpan',
     'title' => 'Update Data',
     'positonY' => 'top',
     'positonX' => 'center',
      'showProgressbar' => true,
 ]);    $transaction->commit();
          return $this->render('update', [
                'model' => $model,
                'modelTembusan' => $modelTembusan,
            ]);
             }else{
                 $transaction->rollback();
                 Yii::$app->getSession()->setFlash('success', [
     'type' => 'danger',
     'duration' => 3000,
     'icon' => 'fa fa-users',
     'message' => 'Data Gagal di Update',
     'title' => 'Error',
     'positonY' => 'top',
     'positonX' => 'center',
     'showProgressbar' => true,
 ]);
              return $this->render('update', [
                'model' => $model,
                'modelTembusan' => $modelTembusan,
            ]);
            }
           } catch(Exception $e) {

                    $transaction->rollback();
            }
        } 
        }else {
            
             
            return $this->render('update', [
                'model' => $model,
                'modelTembusan' => $modelTembusan,
            ]);
        }
    }

    /**
     * Deletes an existing Was27Inspek model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = $_POST['id'];
         $transaction = Yii::$app->db->beginTransaction();
        try {
        $updateData = $this->findModel($id);
        $updateData->flag = 3;
        $updateData->save();
         $transaction->commit();
      
         Yii::$app->getSession()->setFlash('success', [
     'type' => 'success',
     'duration' => 3000,
     'icon' => 'fa fa-users',
     'message' => 'Data Berhasil di Hapus',
     'title' => 'Hapus Data',
     'positonY' => 'top',
     'positonX' => 'center',
     'showProgressbar' => true,
 ]);
        return $this->redirect('create');
          } catch(Exception $e) {
            $transaction->rollBack();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Gagal Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect('create');
        }
    }

    
    public function actionCetak(){
        
         $id_register = $_GET['id_register'];
         $id_was_27 = $_GET['id_was_27'];
         $odf = new Odf(Yii::$app->params['reportPengawasan']."was27_inspek.odt");
          

    
       
      $sql1 = "select a.no_was_27_inspek,b.inst_nama AS kejaksaan,b.inst_lokinst AS di,a.id_register,a.tgl,c.nm_lookup_item AS sifat,a.analisa,a.kesimpulan,h.no_register,h.tgl_register,
a.jml_lampiran,a.satuan_lampiran,a.perihal,j.no_sp_was_2,j.tgl_sp_was_2,
j.pejabat_sp_was_2,
    h.uraian,
    a.ttd_peg_nik, f.peg_nip AS ttd_nip, f.peg_nama AS ttd_nama, f.jabatan AS ttd_jabatan  
    from was.was_27_inspek a
JOIN kepegawaian.kp_inst_satker b ON a.inst_satkerkd::text = b.inst_satkerkd::text
   JOIN was.lookup_item c ON a.sifat_surat = c.kd_lookup_item::integer AND c.kd_lookup_group = '01'::bpchar    
   JOIN was.v_riwayat_jabatan f ON a.ttd_id_jabatan::text = f.id::text  
   JOIN was.v_dugaan_pelanggaran h on a.id_register = h.id_register
   LEFT JOIN was.v_sp_was_2 j on a.id_register = j.id_register
   where  a.id_was_27_inspek='".$id_was_27."' and a.id_register = '".$id_register."'";
        $data = Was27Inspek::findBySql($sql1)->asArray()->one();
        
        $sqlTerlapor = new Query;
        $sqlTerlapor->from("was.v_terlapor");
        $sqlTerlapor->where("id_register = :idRegister",[":idRegister"=>$id_register]);
        $commandTerlapor = $sqlTerlapor->createCommand();
        $dataTerlapor = $commandTerlapor->queryAll(); 
        
        $sqlPelapor = new Query;
        $sqlPelapor->from("was.v_pelapor");
        $sqlPelapor->where("id_register = :idRegister",[":idRegister"=>$id_register]);
        $commandPelapor = $sqlPelapor->createCommand();
        $dataPelapor = $commandPelapor->queryAll(); 
       // $data = $command->queryOne(); 
 
        $sqlYth = " SELECT
	a.ttd_sp_was_2,
	b.jabatan
FROM
	was.sp_was_2 a
INNER JOIN was.v_pejabat_pimpinan b ON (
	a.ttd_sp_was_2 = b.id_jabatan_pejabat
)
WHERE
	id_register = '".$id_register."'";
      
        $dataYth = \app\modules\pengawasan\models\SpWas2::findBySql($sqlYth)->asArray()->one();
           $sqlDari = " SELECT
	A .inst_satkerkd,
	initcap(b.inst_nama) AS inst_nama,
	initcap(b.inst_lokinst) AS lokasi,
	'Tim Pemeriksa ' || initcap(b.inst_nama) AS dari
FROM
	was.dugaan_pelanggaran A
INNER JOIN kepegawaian.kp_inst_satker b ON (
	A .inst_satkerkd = b.inst_satkerkd
)
WHERE
	LENGTH (A .inst_satkerkd) = 2
AND A .id_register = '".$id_register."'
AND b.is_active = '1'";
      
        $dataDari = \app\modules\pengawasan\models\SpWas2::findBySql($sqlDari)->asArray()->one();
        $datatglLWas2 = \app\modules\pengawasan\models\LWas2::find()->select('tgl')->where("id_register = :idRegister",[":idRegister"=>$id_register])->asArray()->one();
        
          $sqlData = "select DISTINCT a.id_register
		,a.id_ba_was_3
		,b.id_ba_was_3_keterangan
		,c.nm_lookup_item
                ,case 
			when a.sebagai = 1 then e.peg_nip||' - '||e.peg_nama||' - '||e.jabatan 
			when a.sebagai = 3 then d.peg_nip||' - '||d.peg_nama||' - '||d.jabatan 
			when a.sebagai = 2 then f.nama end as peran
		,case when b.tanya_jawab = 1 then 'Tanya'
				when b.tanya_jawab = 2 then 'Jawab' end as tanya_jawab
		
                ,b.isi
	from was.ba_was_3 a 
		left join was.ba_was_3_keterangan b on (a.id_ba_was_3 = b.id_ba_was_3)
		left join was.lookup_item c on (a.sebagai = c.kd_lookup_item::integer and c.kd_lookup_group = '02')
		left join was.v_terlapor d on(a.id_peran = d.id_terlapor and a.sebagai = 3)
		left join was.v_saksi_internal e on(a.id_peran = e.id_saksi_internal and a.sebagai = 1)
		left join was.v_saksi_eksternal f on(a.id_peran = f.id_saksi_eksternal and a.sebagai = 2)
		where a.id_register = '".$id_register."' and 
		tanya_jawab is not null
	order by 1,2,3
";
          
      
        $dataData = \app\modules\pengawasan\models\SpWas2::findBySql($sqlData)->asArray()->all();
       
        $sqlSaranPemeriksa = "select 
	d.nm_lookup_item
	,c.peg_nama
	,initcap(c.gol_pangkat) as gol_pangkat
	,c.peg_nip
	,c.peg_nrp
	,c.jabatan
	,b.saran

from was.was_27_inspek a inner join was.was_27_inspek_detail b on (a.id_was_27_inspek = b.id_was_27_inspek)
		inner join was.v_terlapor c on (b.id_terlapor = c.id_terlapor)
		left join was.lookup_item d on (a.rncn_henti_riksa_1_was_27_ins::character = d.kd_lookup_item and d.kd_lookup_group='13')
	where a.id_was_27_inspek = '".$id_was_27."' and b.rncn_henti_riksa_was_27_ins = '1'
";
         $dataSaranpemeriksa = Was27Inspek::findBySql($sqlSaranPemeriksa)->asArray()->all();
       
         $sqlsaranInspektur = "select 
	e.jabatan as jabatan_ins
	,c.peg_nama
	,initcap(c.gol_pangkat) as gol_pangkat
	,c.peg_nip
	,c.peg_nrp
	,c.jabatan
	,b.saran

from was.was_27_inspek a inner join was.was_27_inspek_detail b on (a.id_was_27_inspek = b.id_was_27_inspek)
		inner join was.v_terlapor c on (b.id_terlapor = c.id_terlapor)
 		left join was.v_pejabat_tembusan e on (a.rncn_henti_riksa_2_was_27_ins = e.id_pejabat_tembusan)
	where a.id_was_27_inspek = '".$id_was_27."' and b.rncn_henti_riksa_was_27_ins = '2'
";
         $dataSaranInspektur = Was27Inspek::findBySql($sqlsaranInspektur)->asArray()->all();
         
         $sqlPendapat = "select 
		initcap(b.jabatan)as jabatan
		,c.nm_lookup_item

from was.was_27_inspek a 
	left join was.v_pejabat_pimpinan b on (a.pendapat::integer = b.id_jabatan_pejabat)
	left join was.lookup_item c on (a.persetujuan::character = c.kd_lookup_item and c.kd_lookup_group = '12')
	where a.id_was_27_inspek = '".$id_was_27."' ";
         $dataPendapat = Was27Inspek::findBySql($sqlPendapat)->asArray()->one();
        /*$sqlAlasan = new Query;
        $sqlAlasan->select('*');
        $sqlAlasan->from("was.was_21_detail");
        $sqlAlasan->where("id_was_21=:id_was and keberatan_tanggapan = 1",[":id_was"=>$id_was_21]);
        $commandAlasan = $sqlAlasan->createCommand();
        $dataAlasan = $commandAlasan->queryAll(); 
        
        $sqlTanggapan = new Query;
        $sqlTanggapan->select('*');
        $sqlTanggapan->from("was.was_21_detail");
        $sqlTanggapan->where("id_was_21=:id_was and keberatan_tanggapan = 2",[":id_was"=>$id_was_21]);
        $commandTanggapan = $sqlTanggapan->createCommand();
        $dataTanggapan = $commandTanggapan->queryAll(); 
        
        $sqlKesimpulan = new Query;
        $sqlKesimpulan->select('*');
        $sqlKesimpulan->from("was.was_21_detail");
        $sqlKesimpulan->where("id_was_21=:id_was and keberatan_tanggapan = 3",[":id_was"=>$id_was_21]);
        $commandKesimpulan = $sqlKesimpulan->createCommand();
        $dataKesimpulan = $commandKesimpulan->queryAll(); 
        
       
       
     */   
       $sqlTembusan = new Query;
        $sqlTembusan->select('b.jabatan');
        $sqlTembusan->from("was.tembusan_was_27_inspek a");
        $sqlTembusan->join("inner join", "was.v_pejabat_tembusan b", "(a.id_pejabat_tembusan=b.id_pejabat_tembusan)");
        $sqlTembusan->where("a.id_was_27_inspek = :idWas",[":idWas"=>$id_was_27]);
        $commandTembusan = $sqlTembusan->createCommand();
        $dataTembusan = $commandTembusan->queryAll(); 
        
      
        $odf->setVars('kejaksaan', $data['kejaksaan']);
        $odf->setVars('sifatsurat2', strtoupper($data['sifat']));
        $odf->setVars('kepadaYth', $dataYth['jabatan']);
        $odf->setVars('dari', $dataDari['dari']);
        $odf->setVars('tanggalWas27',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl']));
        $odf->setVars('nomorWas27',  $data['no_was_27_inspek']);
        $odf->setVars('sifatsurat',  $data['sifat']);
        $odf->setVars('tglLWas2',   \Yii::$app->globalfunc->ViewIndonesianFormat($datatglLWas2['tgl']));
        
         $terbilang = new Terbilang();
        //  $ini = $was_16a->jml_lampiran." (".$terbilang->convert($was_16a->jml_lampiran).")";
        //  $odf->setVars('jml_lampiran', $ini);
        $odf->setVars('berkas',  $data['jml_lampiran'] .'('.(!empty($data['jml_lampiran'])?$terbilang->convert(trim($data['jml_lampiran'])):'').')');
       $odf->setVars('tglSpWas1', $data['tgl_sp_was_2']);
        $odf->setVars('noSpWas1',  $data['no_sp_was_2']);
         $odf->setVars('pejabatSpWas1',  $data['pejabat_sp_was_2']);
          $odf->setVars('analisa',  $data['analisa']);
        $odf->setVars('kesimpulan',  $data['kesimpulan']);
         $odf->setVars('uraianPermasalahan',  $data['uraian']);
        $odf->setVars('nomorRegister',  $data['no_register']);
        $odf->setVars('tglRegister',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_register']));
         $odf->setVars('pendapat',  "Pendapat ".$dataPendapat['jabatan']);
         $odf->setVars('isiPendapat', $dataPendapat['nm_lookup_item']);
          $odf->setVars('ttdJabatan',  $data['ttd_jabatan']);
         $odf->setVars('ttdNama', $data['ttd_nama']);
         $odf->setVars('ttdNip', $data['ttd_nip']);
     /*   $odf->setVars('analisa',  $data['analisa']);
        $odf->setVars('kesimpulan',  $data['kesimpulan']);
        $odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl']));
        $odf->setVars('nomor',  $data['no_was_21']);
        $odf->setVars('sifat_surat',  $data['sifat']);
        $odf->setVars('sifatsurat2', strtoupper($data['sifat']));
        $odf->setVars('ttdNama', $data['ttd_nama']);
        $odf->setVars('ttdNip',  $data['ttd_nip']);
        $odf->setVars('nomorRegister',  $data['no_register']);
        $odf->setVars('tglRegister',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_register']));
         $odf->setVars('uraianPermasalahan',  $data['uraian']);
     
       
        */
        
         
         
       
        
         $dft_terlapor = $odf->setSegment('terlapor');
        $i = 1;
        foreach($dataTerlapor as $dataTerlapor2){
          $dft_terlapor->noUrut($i);
          $dft_terlapor->namaTerlapor($dataTerlapor2['peg_nama']);
           $dft_terlapor->pangkatTerlapor($dataTerlapor2['gol_pangkat']);
          $dft_terlapor->nipTerlapor($dataTerlapor2['peg_nip']);
          $dft_terlapor->jabatanTerlapor($dataTerlapor2['jabatan']);
          $dft_terlapor->merge();
            $i++;
        }
        $odf->mergeSegment($dft_terlapor);
        
        $dft_pelapor = $odf->setSegment('pelapor');
        $i = 1;
        foreach($dataPelapor as $dataPelapor2){
         $dft_pelapor->noUrut($i);
          $dft_pelapor->namaPelapor($dataPelapor2['nama']);
          $dft_pelapor->alamatPelapor($dataPelapor2['alamat']);
          $dft_pelapor->merge();
            $i++;
        }
        $odf->mergeSegment($dft_pelapor);
        
        
        
         $dft_datawas27 = $odf->setSegment('datawas27');
        $i = 0;
        
        $dataTanya = "";
        $dataJawab = "";
        foreach($dataData as $dataData2){
         
         
        //  if($dataData2['tanya_jawab'] == 'Tanya'){
         // $dft_datawas27->tanyaDatawas27('nanya');
         // }
       //   else 
       if($dataData2['tanya_jawab'] == 'Tanya'){
               $dataTanya = $dataData2['isi'];
         }else{
              $dataJawab = $dataData2['isi']; 
         }
         if($i%2){
           
          $dft_datawas27->peranDatawas27($i."   ".$dataData2['peran']);
          $dft_datawas27->tanyaDatawas27($dataTanya);
          $dft_datawas27->jawabDatawas27($dataJawab);
          $dft_datawas27->merge();
         
         }
          $i++;  
        }
         
        
        $odf->mergeSegment($dft_datawas27);
        
        $dft_saranpemeriksa = $odf->setSegment('saranpemeriksa');
        $i = 'a';
        $timPemeriksa = "";
        foreach($dataSaranpemeriksa as $dataSaranpemeriksa2){
         $dft_saranpemeriksa->urutTim($i);
         $isi = "Terlapor ".$dataSaranpemeriksa2['peg_nama'].", pangkat (Gol) ".$dataSaranpemeriksa2['gol_pangkat'].", NIP/NRP. ".$dataSaranpemeriksa2['peg_nip'].", jabatan ".$dataSaranpemeriksa2['jabatan'].", ".$dataSaranpemeriksa2['saran'];
          $dft_saranpemeriksa->isiSaran($isi);
          $timPemeriksa = $dataSaranpemeriksa2['nm_lookup_item'];
        
          $dft_saranpemeriksa->merge();
            $i++;
        }
        $odf->mergeSegment($dft_saranpemeriksa);
        $odf->setVars('timPemeriksa',  $timPemeriksa);
        
        $dft_saraninspektur = $odf->setSegment('saraninspektur');
        $i = 'a';
        $timInspektur = "";
        foreach($dataSaranInspektur as $dataSaranInspektur2){
         $dft_saraninspektur->urutIns($i);
         $isi = "Terlapor ".$dataSaranInspektur2['peg_nama'].", pangkat (Gol) ".$dataSaranInspektur2['gol_pangkat'].", NIP/NRP. ".$dataSaranInspektur2['peg_nip'].", jabatan ".$dataSaranInspektur2['jabatan'].", ".$dataSaranInspektur2['saran'];
          $dft_saraninspektur->isiSaraninspektur($isi);
          $timInspektur = $dataSaranInspektur2['jabatan_ins'];
        
          $dft_saraninspektur->merge();
            $i++;
        }
        $odf->mergeSegment($dft_saraninspektur);
        $odf->setVars('timInspektur', ucwords($timInspektur));
        
        $dft_tembusan = $odf->setSegment('tembusan');
        $i = 1;
        foreach($dataTembusan as $dataTembusan2){
          $dft_tembusan->tembusanJabatan($i.". ".$dataTembusan2['jabatan']);
          $dft_tembusan->merge();
          $i++;
        }
        $odf->mergeSegment($dft_tembusan);
      /*  $odf->setVars('kesimpulan',  $data['kesimpulan']);
        $odf->setVars('hasilkesimpulan',  $data['hasil_kesimpulan']);
        $odf->setVars('saran',  $data['saran']);
        $odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_1']));
        $odf->setVars('tempat',  $data['inst_lokinst']);

        //terlapor
        $dft_terlapor = $odf->setSegment('terlapor');
        foreach($data2 as $dataTerlapor){
            $dft_terlapor->terlaporNama($dataTerlapor['peg_nama']);
            $dft_terlapor->terlaporNip($dataTerlapor['peg_nip']);
            $dft_terlapor->terlaporJabatan($dataTerlapor['jabatan']);
            $dft_terlapor->merge();
        }
        $odf->mergeSegment($dft_terlapor);
        //pelapor
         $dft_pelapor = $odf->setSegment('pelapor');
        foreach($data3 as $dataPelapor){
            $dft_pelapor->pelaporNama($dataPelapor['nama']);
            $dft_pelapor->pelaporAlamat($dataPelapor['alamat']);
           $dft_pelapor->merge();
        }
        $odf->mergeSegment($dft_pelapor);*/
     

       $dugaan = \app\modules\pengawasan\models\DugaanPelanggaran::findBySql("select a.id_register,a.no_register,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor from was.dugaan_pelanggaran a
inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
inner join (
select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
    inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
    inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
        inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
            count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
        on (a.id_register=f.id_register) where a.id_register = :idRegister", [":idRegister"=>$id_register])->asArray()->one();
       $odf->setVars('namaTerlaporawal', ucwords(strtolower($dugaan['terlapor'])));
        $odf->exportAsAttachedFile("WAS27Inspek- ".$dugaan['terlapor'].".odt");
        Yii::$app->end();
    }

    /**
     * Finds the Was27Inspek model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was27Inspek the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was27Inspek::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
