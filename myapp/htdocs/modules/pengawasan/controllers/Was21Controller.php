<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was21;
use app\modules\pengawasan\models\Was21Search;
use app\modules\pengawasan\models\Was21Detail;
use app\modules\pengawasan\models\TembusanWas21;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use Nasution\Terbilang;
use yii\db\Query;
use Odf;

/**
 * Was21Controller implements the CRUD actions for Was21 model.
 */
class Was21Controller extends Controller
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
     * Lists all Was21 models.
     * @return mixed
     */
    public function actionIndex()
    {
          $model = new Was21();

      //  $modelTembusan = new TembusanWas19a();

        return $this->render('index', [
            'model' => $model,
          //  'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Was21 model.
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
     * Creates a new Was21 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Was21();
        $modelAlasan = new Was21Detail();
        $modelTanggapan = new Was21Detail();
        $modelKesimpulan = new Was21Detail();


    
        if($_POST['Was21']){
           
        if ($model->load(Yii::$app->request->post())){
             $connection = \Yii::$app->db;
             $transaction = $connection->beginTransaction();
           try {
           
            $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
            $model->perihal = $_POST['Was21']['perihal'];
            $model->flag ='1';
            $model->upload_file = $files->name;
         
            if($model->save()) {
                
               $pejabat =  $_POST['id_jabatan'];
                for($i=0;$i<count($pejabat);$i++){
                    $saveTembusan = new TembusanWas21();
                    $saveTembusan->id_was_21 = $model->id_was_21;
                    $saveTembusan->id_pejabat_tembusan = $pejabat[$i];
                    $saveTembusan->save();
                }
                $alasan =$_POST['alasan'];
                 
                for($i=0;$i<count($alasan);$i++){
                    $saveAlasan = new Was21Detail();
                    $saveAlasan->id_was_21 = $model->id_was_21;
                    $saveAlasan->keberatan_tanggapan = 1;
                    $saveAlasan->isi = $alasan[$i];
                    $saveAlasan->save();
                }
              
                 $tanggapan =$_POST['tanggapan'];
                 
                for($i=0;$i<count($tanggapan);$i++){
                    $saveAlasan = new Was21Detail();
                    $saveAlasan->id_was_21 = $model->id_was_21;
                    $saveAlasan->keberatan_tanggapan = 2;
                    $saveAlasan->isi = $tanggapan[$i];
                    $saveAlasan->save();
                }
                
                $kesimpulan =$_POST['kesimpulan'];
                 
                for($i=0;$i<count($kesimpulan);$i++){
                    $saveAlasan = new Was21Detail();
                    $saveAlasan->id_was_21 = $model->id_was_21;
                    $saveAlasan->keberatan_tanggapan = 3;
                    $saveAlasan->isi = $kesimpulan[$i];
                    $saveAlasan->save();
                }
              
              
                   if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'was_21/'.$files->name;
                    $files->saveAs($path);
                } 
                
                  $transaction->commit();
                  
              
         
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
       
      
            return $this->redirect('index');
        
        } else{
        
        }
           
       } catch(Exception $e) {

                    $transaction->rollback();
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
           return $this->redirect('index');   

            }
        }         
        }   
    
        else { 
            
             $view_pemberitahuan = $this->renderAjax('_form', [
             'model' => $model,
            
                 'modelAlasan' => $modelAlasan,
                'modelTanggapan'=>$modelTanggapan,
        ]);   
    }
    echo  \yii\helpers\Json::encode(['key'=>$key,'view_pemberitahuan'=>$view_pemberitahuan]);
     \Yii::$app->end();
          
    }

    /**
     * Updates an existing Was21 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        
       $model = new Was21();
	if($_POST['Was21']){  
            $model = $this->findModel($_POST['Was21']['id_was_21']);
          if ($model->load(Yii::$app->request->post())){  
             
             $connection = \Yii::$app->db;
             $transaction = $connection->beginTransaction();
           try {
           
                $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
           
            $model->perihal = $_POST['Was21']['perihal'];
            $model->upload_file = $files->name;
         
            if($model->save()) {
                $delete_tembusan = $_POST['delete_tembusan'];
                $delete_tembusan = explode("#",$delete_tembusan);
                $pejabat =  $_POST['id_jabatan'];
                 if(count($delete_tembusan) > 1){
                   for($j=1;$j<count($delete_tembusan);$j++){
                       $deleteTembusan = TembusanWas21::find()->where('id_pejabat_tembusan = :id and id_was_21 = :id_was',[":id"=>$delete_tembusan[$j],":id_was"=>$model->id_was_21])->one();
                        $deleteTembusan->delete();
                   }
                }
                for($i=0;$i<count($pejabat);$i++){
                    $saveTembusan = new TembusanWas21();
                    $saveTembusan->id_was_21 = $model->id_was_21;
                    $saveTembusan->id_pejabat_tembusan = $pejabat[$i];
                    $saveTembusan->save();
                }
                $alasan =$_POST['alasan'];
                $deleteDetail = Was21Detail::deleteAll('id_was_21 = :id_was', [':id_was' => $model->id_was_21]);

                for($i=0;$i<count($alasan);$i++){
                    $saveAlasan = new Was21Detail();
                    $saveAlasan->id_was_21 = $model->id_was_21;
                    $saveAlasan->keberatan_tanggapan = 1;
                    $saveAlasan->isi = $alasan[$i];
                    $saveAlasan->save();
                }
              
                 $tanggapan =$_POST['tanggapan'];
                 
                for($i=0;$i<count($tanggapan);$i++){
                    $saveAlasan = new Was21Detail();
                    $saveAlasan->id_was_21 = $model->id_was_21;
                    $saveAlasan->keberatan_tanggapan = 2;
                    $saveAlasan->isi = $tanggapan[$i];
                    $saveAlasan->save();
                }
              
                  $kesimpulan =$_POST['kesimpulan'];
                 
                for($i=0;$i<count($kesimpulan);$i++){
                    $saveAlasan = new Was21Detail();
                    $saveAlasan->id_was_21 = $model->id_was_21;
                    $saveAlasan->keberatan_tanggapan = 3;
                    $saveAlasan->isi = $kesimpulan[$i];
                    $saveAlasan->save();
                }
              
                   if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'was_21/'.$files->name;
                    $files->saveAs($path);
                } 
                
                 $transaction->commit();
                  
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
       
      
            return $this->redirect('index');
        
        } else{
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
            return $this->redirect('index');  

        }
           
       } catch(Exception $e) {

                   $transaction->rollback();
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
             

         return $this->redirect('index');
            }
        } else{
           
        }
        }else{
        
        $key = $_POST['id_was_21'];
        $model = $this->findModel($key);
       
        
        $modelTembusan = TembusanWas21::find()->where('id_was_21=:id_was',[':id_was'=>$key])->all();
        $modelAlasan = Was21Detail::find()->where('id_was_21=:id_was and keberatan_tanggapan = 1',[':id_was'=>$key])->all();
        $modelTanggapan = Was21Detail::find()->where('id_was_21=:id_was and keberatan_tanggapan = 2',[':id_was'=>$key])->all();
         $modelKesimpulan = Was21Detail::find()->where('id_was_21=:id_was and keberatan_tanggapan = 3',[':id_was'=>$key])->all();
        $view_pemberitahuan = $this->renderAjax('_form', [
            'model' => $model,
            'modelTembusan' => $modelTembusan,
            'modelAlasan' => $modelAlasan,
            'modelTanggapan'=>$modelTanggapan,
             'modelKesimpulan'=>$modelKesimpulan,
           
        ]);
      //   header('Content-Type: application/json; charset=utf-8');
    echo  \yii\helpers\Json::encode(['key'=>$key,'view_pemberitahuan'=>$view_pemberitahuan]);
     \Yii::$app->end();
        //return CJSON::encode(['key'=>$key,'view_pemberitahuan'=>$view_pemberitahuan]);
      //  return json_encode($key);
        }   
    }

    /**
     * Deletes an existing Was21 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {      $selection = $_POST['selection'];
        $transaction = Yii::$app->db->beginTransaction();
        try {
           

           for($i=0;$i<count($selection);$i++){
               $update = Was21::updateAll(['flag' => '3'], 'id_was_21 = :id', [':id'=>$selection[$i]]);
           }
             //     Tun::updateAll(['flag' => '3'], 'id_tun=:id', [':id' => $id_tun[$i]]);
              //  }
           

            $transaction->commit();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect('index');
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

            return $this->redirect('index');
        }
    }
    
    
    public function actionCetak(){
        
         $id_register = $_GET['id_register'];
         $id_was_21 = $_GET['id_was_21'];
         $odf = new Odf(Yii::$app->params['reportPengawasan']."was_21.odt");
          

       // $sql1 = new Query;
    
      /*  $sql1->select("a.no_was_21,b.inst_nama AS kejaksaan,b.inst_lokinst AS di,a.id_register,a.tgl_was_21,c.nm_lookup_item AS sifat,
a.jml_lampiran,a.satuan_lampiran,a.perihal,
d.jabatan AS kepada, g.jabatan AS dari,
 e.peg_nama AS nama_terlapor, e.peg_nip AS nip_terlapor, 
    e.peg_nrp AS nrp_terlapor, e.jabatan AS jabatan_terlapor, 
case when a.pendapat = 1 then 'SETUJU' 
ELSE 'TIDAK SETUJU' END as pendapat
,m.bentuk_hukuman as saran_hukuman,case when a.pendapat = 1 then 'SETUJU' 
ELSE 'TIDAK SETUJU' END as kputusan_ja,a.ttd_peg_nik, f.peg_nip AS ttd_nip, f.peg_nama AS ttd_nama, f.jabatan AS ttd_jabatan");
        $sql1->from("was.was_21 a");
        $sql1->join("inner join", "kepegawaian.kp_inst_satker b", "a.inst_satkerkd::text = b.inst_satkerkd::text");
        $sql1->join("inner join","was.lookup_item c","a.sifat_surat = c.kd_lookup_item::integer AND c.kd_lookup_group = '01'::bpchar AND c.kd_lookup_item = '3'::bpchar");
        $sql1->join("inner join", "was.v_pejabat_pimpinan d","a.kpd_was_21= d.id_jabatan_pejabat");
         
        $sql1->join("inner join", "was.v_terlapor e","a.id_terlapor::text = e.id_terlapor::text");

	$sql1->join("inner join", "was.v_pejabat_pimpinan g","a.ttd_was_21 = g.id_jabatan_pejabat");
	$sql1->join("inner join","was.v_riwayat_jabatan f","a.ttd_id_jabatan::text = f.id::text");
        $sql1->join("inner join","was.sp_r_tingkatphd m","a.tingkat_kd::text = m.tingkat_kd::text");
        $sql1->where("a.id_register = :idRegister and b.id_was_21 = :idWas" ,[":idRegister"=>$id_register,":idWas"=>$id_was_21]);*/
        
        $sql1 = "select a.no_was_21,b.inst_nama AS kejaksaan,b.inst_lokinst AS di,a.id_register,a.tgl_was_21,c.nm_lookup_item AS sifat,
a.jml_lampiran,a.satuan_lampiran,a.perihal,
d.jabatan AS kepada, g.jabatan AS dari,
 e.peg_nama AS nama_terlapor, e.peg_nip AS nip_terlapor, 
    e.peg_nrp AS nrp_terlapor, e.jabatan AS jabatan_terlapor, 
    h.uraian,
case when a.pendapat = 1 then 'SETUJU' 
ELSE 'TIDAK SETUJU' END as pendapat
,m.bentuk_hukuman as saran_hukuman,case when a.pendapat = 1 then 'SETUJU' 
ELSE 'TIDAK SETUJU' END as kputusan_ja,a.ttd_peg_nik, f.peg_nip AS ttd_nip, f.peg_nama AS ttd_nama, f.jabatan AS ttd_jabatan  from was.was_21 a
JOIN kepegawaian.kp_inst_satker b ON a.inst_satkerkd::text = b.inst_satkerkd::text
   JOIN was.lookup_item c ON a.sifat_surat = c.kd_lookup_item::integer AND c.kd_lookup_group = '01'::bpchar AND c.kd_lookup_item = '3'::bpchar
   JOIN was.v_pejabat_pimpinan d ON a.kpd_was_21= d.id_jabatan_pejabat
   JOIN was.v_terlapor e ON a.id_terlapor::text = e.id_terlapor::text
   JOIN was.v_pejabat_pimpinan g ON a.ttd_was_21 = g.id_jabatan_pejabat
   JOIN was.v_riwayat_jabatan f ON a.ttd_id_jabatan::text = f.id::text
   JOIN was.sp_r_tingkatphd m ON a.tingkat_kd::text = m.tingkat_kd::text
   JOIN was.v_dugaan_pelanggaran h on a.id_register = h.id_register
   where  a.id_was_21='".$id_was_21."' and a.id_register = '".$id_register."'";
        $data = Was21::findBySql($sql1)->asArray()->one();
       // $data = $command->queryOne(); 
        
        $sqlAlasan = new Query;
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
        
       
       
        
        $sqlTembusan = new Query;
        $sqlTembusan->select('b.jabatan');
        $sqlTembusan->from("was.tembusan_was_21 a");
        $sqlTembusan->join("inner join", "was.v_pejabat_tembusan b", "(a.id_pejabat_tembusan=b.id_pejabat_tembusan)");
        $sqlTembusan->where("a.id_was_21 = :idWas",[":idWas"=>$id_was_21]);
        $commandTembusan = $sqlTembusan->createCommand();
        $dataTembusan = $commandTembusan->queryAll(); 
       
        $odf->setVars('kejaksaan', $data['kejaksaan']);
        $odf->setVars('kepada',  $data['kepada']);
        $odf->setVars('dari',  $data['dari']);
        $odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_21']));
        $odf->setVars('nomor',  $data['no_was_21']);
        $odf->setVars('sifat',  $data['sifat']);
        $odf->setVars('nipTerlapor', $data['nip_terlapor']);
        $odf->setVars('namaTerlapor',  $data['nama_terlapor']);
        $odf->setVars('jabatanTerlapor',  $data['jabatan_terlapor']);
        $odf->setVars('uraianPermasalahan',  $data['uraian']);
        $odf->setVars('keputusanJA',  $data['kputusan_ja']);
        
       
         $terbilang = new Terbilang();
        //  $ini = $was_16a->jml_lampiran." (".$terbilang->convert($was_16a->jml_lampiran).")";
        //  $odf->setVars('jml_lampiran', $ini);
        $odf->setVars('berkas',  $data['jml_lampiran'] .'('.(!empty($data['jml_lampiran'])?$terbilang->convert(trim($data['jml_lampiran'])):'').')');
        
        $dft_keberatan = $odf->setSegment('keberatan');
        $i = 1;
        foreach($dataAlasan as $dataAlasan2){
          $dft_keberatan->isiKeberatan($i.". ".$dataAlasan2['isi']);
          $dft_keberatan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_keberatan);
        
        $dft_tanggapan = $odf->setSegment('tanggapan');
        $i = 1;
        foreach($dataTanggapan as $dataTanggapan2){
          $dft_tanggapan->isiTanggapan($i.". ".$dataTanggapan2['isi']);
          $dft_tanggapan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_tanggapan);
        
         $dft_kesimpulan = $odf->setSegment('kesimpulan');
        $i = 1;
        foreach($dataKesimpulan as $dataKesimpulan2){
          $dft_kesimpulan->isiKesimpulan($i.". ".$dataKesimpulan2['isi']);
          $dft_kesimpulan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_kesimpulan);
        
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
        $odf->exportAsAttachedFile("WAS21- ".$dugaan['terlapor'].".odt");
        Yii::$app->end();
    }

    /**
     * Finds the Was21 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was21 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was21::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
