<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was16d;
use app\modules\pengawasan\models\Was16dSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\TembusanWas16d;
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\Was15Rencana;/*mengambil tembusan dari master*/
use app\models\KpInstSatkerSearch;
use app\models\KpInstSatker;
use app\models\KpPegawai;
use app\components\GlobalFuncComponent;
use app\modules\pengawasan\components\FungsiComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use yii\base\Model;
use app\modules\pengawasan\models\VWas16d;
use app\modules\pengawasan\models\VTembusanWas16d;
use app\modules\pengawasan\models\TembusanWas2;
use app\modules\pengawasan\models\Was15;
use app\components\ConstSysMenuComponent;
use Odf;
use Nasution\Terbilang;

/**
 * Was16dController implements the CRUD actions for Was16d model.
 */
class Was16dController extends Controller {

  public function behaviors() {
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
   * Lists all Was16d models.
   * @return mixed
   */
  public function actionIndex() {
    $searchModel = new Was16dSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
    ]); 
  //echo "ini Halaman Index";
  }

  /**
   * Displays a single Was16d model.
   * @param string $id
   * @return mixed
   */
  public function actionView($id) {
    return $this->render('view', [
                'model' => $this->findModel($id),
    ]);
  }

  public function actionViewpdf($id){
        $file_upload=$this->findModel($id);

          $filepath = '../modules/pengawasan/upload_file/was_16d/'.$file_upload['upload_file'];
        $extention=explode(".", $file_upload['upload_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['upload_file'] . '"');
              header('Content-Transfer-Encoding: binary');
              header('Content-Length: ' . filesize($filepath));
              header('Accept-Ranges: bytes');

              // Render the file
              readfile($filepath);
          }
          else
          {
             // PDF doesn't exist so throw an error or something
          }
      }
      
    }

  /**
   * Creates a new Was16d model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {
    $model = new Was16d();
    $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_16d','condition2'=>'master'])->orderBy('id_tembusan desc')->all();
    $modelWas15 = Was15Rencana::findOne(["id_was15_rencana"=>$_POST['was16d-was15']]);

    $connection = \Yii::$app->db;

    if ($model->load(Yii::$app->request->post())) {
        // print_r( $_POST['Was16d']['nama_pegawai_terlapor']);
        // print_r( $_POST['Was16d-nama_pegawai_terlapor']);
        // print_r($model->nama_pegawai_terlapor);
        // print_r($model);
        // exit();
        $model->id_sp_was2  = $modelWas15->id_sp_was2;
        $model->id_ba_was2  = $modelWas15->id_ba_was2;
        $model->id_l_was2   = $modelWas15->id_l_was2;
        $model->id_was15    = $modelWas15->id_was15;
        $model->id_terlapor = $modelWas15->id_terlapor_l_was2;
        $model->no_register = $_SESSION['was_register'];
        $model->id_tingkat  = $_SESSION['kode_tk'];
        $model->id_kejati   = $_SESSION['kode_kejati'];
        $model->id_kejari   = $_SESSION['kode_kejari'];
        $model->id_cabjari  = $_SESSION['kode_cabjari'];
        $model->created_by=\Yii::$app->user->identity->id;
        $model->created_ip=$_SERVER['REMOTE_ADDR'];
        $model->created_time=date('Y-m-d H:i:s');

      $transaction = $connection->beginTransaction();
      try {

        if ($model->save()) {

          $pejabat = $_POST['pejabat'];
         // TembusanWas2::deleteAll(['from_table'=>'Was-16d','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_16d),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
              for($z=0;$z<count($pejabat);$z++){
                  $saveTembusan = new TembusanWas2;
                  $saveTembusan->from_table = 'Was-16d';
                  $saveTembusan->pk_in_table = strrev($model->id_was_16d);
                  $saveTembusan->tembusan = $_POST['pejabat'][$z];
                  $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                  $saveTembusan->created_time = date('Y-m-d H:i:s');
                  $saveTembusan->created_by = \Yii::$app->user->identity->id;
                  // $saveTembusan->inst_satkerkd = $_SESSION['inst_satkerkd'];s
                  $saveTembusan->no_register = $_SESSION['was_register'];
                  $saveTembusan->id_tingkat = $_SESSION['kode_tk'];
                  $saveTembusan->id_kejati = $_SESSION['kode_kejati'];
                  $saveTembusan->id_kejari = $_SESSION['kode_kejari'];
                  $saveTembusan->id_cabjari = $_SESSION['kode_cabjari'];
                  $saveTembusan->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                  $saveTembusan->id_wilayah=$_SESSION['was_id_wilayah'];
                  $saveTembusan->id_level1=$_SESSION['was_id_level1'];
                  $saveTembusan->id_level2=$_SESSION['was_id_level2'];
                  $saveTembusan->id_level3=$_SESSION['was_id_level3'];
                  $saveTembusan->id_level4=$_SESSION['was_id_level4'];
                  $saveTembusan->save();
              }
        }
        $transaction->commit();
//          $error = \yii\widgets\ActiveForm::validate($model);
//          print_r($error);
//          exit();
        $model->validate();
        $model->save();
        Yii::$app->getSession()->setFlash('success', [
            'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
            'duration' => 5000, //Integer //3000 default. time for growl to fade out.
            'icon' => 'glyphicon glyphicon-ok-sign', //String
            'message' => 'Data Berhasil Disimpan', // String
            'title' => 'Save', //String
            'positonY' => 'top', //String // defaults to top, allows top or bottom
            'positonX' => 'center', //String // defaults to right, allows right, center, left
            'showProgressbar' => true,
        ]);
      } catch (Exception $e) {
         Yii::$app->getSession()->setFlash('danger', [
            'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
            'duration' => 5000, //Integer //3000 default. time for growl to fade out.
            'icon' => 'glyphicon glyphicon-ok-sign', //String
            'message' => 'Data Gagal Disimpan', // String
            'title' => 'Save', //String
            'positonY' => 'top', //String // defaults to top, allows top or bottom
            'positonX' => 'center', //String // defaults to right, allows right, center, left
            'showProgressbar' => true,
        ]);
        $transaction->roolback();
      }
      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
                  'model' => $model,
                  'modelTembusanMaster' => $modelTembusanMaster,
                  'modelwas16d' => $modelwas16d,

                  
      ]);
    }
  }

  public function actionUpdate($id)
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        $model = $this->findModel($id);
        $fungsi=new FungsiComponent();
        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_was_16d,'from_table'=>'Was-16d','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $kp=KpPegawai::findOne(['peg_nip_baru'=>$model->nip_pegawai_terlapor]);

         $is_inspektur_irmud_riksa=$fungsi->gabung_where();
         $OldFile=$model->upload_file;

        if ($model->load(Yii::$app->request->post())){

              $errors       = array();
              $file_name    = $_FILES['upload_file']['name'];
              $file_size    = $_FILES['upload_file']['size'];
              $file_tmp     = $_FILES['upload_file']['tmp_name'];
              $file_type    = $_FILES['upload_file']['type'];
              $ext = pathinfo($file_name, PATHINFO_EXTENSION);
              $tmp = explode('.', $_FILES['upload_file']['name']);
              $file_exists  = end($tmp);
              $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $model->upload_file=($file_name==''?$OldFile:$rename_file);
                $model->updated_ip = $_SERVER['REMOTE_ADDR'];
                $model->updated_time = date('Y-m-d H:i:s');
                $model->updated_by = \Yii::$app->user->identity->id;
            if($model->save()){
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_16d/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'was_16d/'.$OldFile);
                  }
                    
                    $pejabat = $_POST['pejabat'];
                    TembusanWas2::deleteAll(['from_table'=>'Was-16d','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_16d),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                        for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Was-16d';
                            $saveTembusan->pk_in_table = strrev($model->id_was_16d);
                            $saveTembusan->tembusan = $_POST['pejabat'][$z];
                            $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                            $saveTembusan->created_time = date('Y-m-d H:i:s');
                            $saveTembusan->created_by = \Yii::$app->user->identity->id;
                            // $saveTembusan->inst_satkerkd = $_SESSION['inst_satkerkd'];s
                            $saveTembusan->no_register = $_SESSION['was_register'];
                            $saveTembusan->id_tingkat = $_SESSION['kode_tk'];
                            $saveTembusan->id_kejati = $_SESSION['kode_kejati'];
                            $saveTembusan->id_kejari = $_SESSION['kode_kejari'];
                            $saveTembusan->id_cabjari = $_SESSION['kode_cabjari'];
                            $saveTembusan->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                            $saveTembusan->id_wilayah=$_SESSION['was_id_wilayah'];
                            $saveTembusan->id_level1=$_SESSION['was_id_level1'];
                            $saveTembusan->id_level2=$_SESSION['was_id_level2'];
                            $saveTembusan->id_level3=$_SESSION['was_id_level3'];
                            $saveTembusan->id_level4=$_SESSION['was_id_level4'];
                            $saveTembusan->save();
                        }
                      //1 jabatan (TU) // 0 jabatan (JAKSA)  
                  // if($kp['pns_jnsjbtfungsi'] == '1'){
                  //   $arr = array(ConstSysMenuComponent::Bawas7, ConstSysMenuComponent::Bawas9);
                  // }else if($kp['pns_jnsjbtfungsi'] == '0'){
                  //   $arr = array(ConstSysMenuComponent::Bawas7, ConstSysMenuComponent::Bawas8);
                  // }      
                    $arr = array(ConstSysMenuComponent::Bawas7);
                    for ($i=0; $i < 1 ; $i++) { 
                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-17
                      $modelTrxPemrosesan=new WasTrxPemrosesan();
                      $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                      $modelTrxPemrosesan->id_sys_menu=$arr[$i];
                      $modelTrxPemrosesan->id_user_login=$_SESSION['username'];
                      $modelTrxPemrosesan->durasi=date('Y-m-d H:i:s');
                      $modelTrxPemrosesan->created_by=\Yii::$app->user->identity->id;
                      $modelTrxPemrosesan->created_ip=$_SERVER['REMOTE_ADDR'];
                      $modelTrxPemrosesan->created_time=date('Y-m-d H:i:s');
                      $modelTrxPemrosesan->updated_ip=$_SERVER['REMOTE_ADDR'];
                      $modelTrxPemrosesan->updated_by=\Yii::$app->user->identity->id;
                      $modelTrxPemrosesan->updated_time=date('Y-m-d H:i:s');
                      $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                      $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                      $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                      $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                      $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                      $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                      $modelTrxPemrosesan->save();
                      // }
                    }

            }
            move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_16d/'.$rename_file);
            $transaction->commit();

            $model->validate();
            $model->save();
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Disimpan', // String
                'title' => 'Save', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            } catch (Exception $e) {
                $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTembusan' => $modelTembusan,
                'modelwas16d'   => $modelwas16d,
            ]);
        }
    }

    public function actionCetak($id){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $model=$this->findModel($id);
        
        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_was_16d,'from_table'=>'Was-16d',
                            'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                            'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                            'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                            'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                            'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

         // $modelwas15=Was15::findOne(['id_was15'=>$model->id_was15,'no_register'=>$_SESSION['was_register'],
         //                    'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
         //                    'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
         //                    'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
         //                    'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
         //                    'id_level4'=>$_SESSION['was_id_level4']]);

        $connection = \Yii::$app->db;
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select * FROM  was.ms_sk where kode_sk='".$model['sk']."'";
        $modelSk = $connection->createCommand($query)->queryOne();
        $tanggal=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was_16d']);
      //  $tanggalWas15=\Yii::$app->globalfunc->ViewIndonesianFormat($modelwas15['tgl_was15']);
        // print_r($tanggalWas15);
         // print_r($tanggalWas15);
         // print_r($modelwas15);
        // exit();

         return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'model'=>$model,
                                'tanggal'=>$tanggal,
                                'modelTembusan'=>$modelTembusan,
                                'modelSk'=>$modelSk,
                                ]);
      
    }


  public function actionCetak_odt($id) {
    $odf = new Odf(Yii::$app->params['report-path'] . "modules/pengawasan/template/was_16d.odt");

    $was_16d = VWas16d::find()->where("id_was_16d='" . $id . "'")->one();

    $tembusan = VTembusanWas16d::find()->where("id_was_16d='" . $id . "'")->all();

    $odf->setVars('no_was_16d', $was_16d->no_was_16d);
    $odf->setVars('dari', $was_16d->dari);
    $odf->setVars('kepada', $was_16d->kpd_was_16d);
    $odf->setVars('ttd_dari', $was_16d->dari);
    $odf->setVars('perihal', $was_16d->perihal);
    $odf->setVars('tgl_was_16d', GlobalFuncComponent::tglToWord($was_16d->tgl_was_16d));
    $odf->setVars('kejaksaan', $was_16d->kejaksaan);
    $odf->setVars('sifat_surat', $was_16d->sifat);

    //jumlah lampiran
    if ($was_16d->jml_lampiran != '') {
      $terbilang = new Terbilang();
      $ini = $was_16d->jml_lampiran . " (" . $terbilang->convert($was_16d->jml_lampiran) . ")";
      $odf->setVars('jml_lampiran', $ini);
    } else {
      $odf->setVars('jml_lampiran', "-");
    }

    $odf->setVars('nama_terlapor', ""); //nama di hidden, karena muncul 2x
    $odf->setVars('nip_terlapor', $was_16d->nip);
    $odf->setVars('jabatan_terlapor', $was_16d->jabatan);
    $odf->setVars('ttd_jabatan', $was_16d->ttd_jabatan);
    $odf->setVars('ttd_peg_nama', $was_16d->ttd_peg_nama);
    $odf->setVars('ttd_peg_nip', $was_16d->ttd_peg_nip);

    $odf->setVars('surat', "SP-WAS-2");
    $odf->setVars('nomor_surat', $was_16d->no_surat_dinas);
    $odf->setVars('tanggal', GlobalFuncComponent::tglToWord($was_16d->tanggal_surat_dinas));
    $odf->setVars('pelanggaran_disiplin', $was_16d->dugaan_pelanggaran);
    $isi_hukuman_disiplin = $was_16d->keterangan . ' ' . $was_16d->aturan_hukum;
    $odf->setVars('isi_hukuman_disiplin', $isi_hukuman_disiplin);

    #tembusan
    $dft_tembusan = $odf->setSegment('tembusan');
    $i = 1;
    foreach ($tembusan as $element) {
      $dft_tembusan->urutan_tembusan($i);
      $dft_tembusan->jabatan_tembusan($element['jabatan']);
      $dft_tembusan->merge();
      $i++;
    }

    $odf->mergeSegment($dft_tembusan);

    $dugaan = \app\modules\pengawasan\models\DugaanPelanggaran::findBySql("select a.id_register,a.no_register,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor from was.dugaan_pelanggaran a
inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
inner join (
select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
    inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
    inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
        inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
            count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
        on (a.id_register=f.id_register) where a.id_register = :idRegister", [":idRegister" => $was_16d->id_register])->asArray()->one();
    $odf->exportAsAttachedFile("WAS16d - " . $dugaan['terlapor'] . ".odt");
  }

  

  public function actionUpdate2($id) {
    $model = Was16d::findOne(array("id_was_16d" => $id, "flag" => '1'));
    $model2 = Was16d::findOne(array("id_was_16d" => $id, "flag" => '1'));
    $model->id_was_16d = $id;
    $model->no_was_16d = "ND-".$_POST["no_was_16d"];
//      $model->id_register = $_POST[];
    $model->inst_satkerkd = $_POST["inst_satkerkd"];
    $model->kpd_was_16d = $_POST["Was16d"]["kpd_was_16d"];
//      $model->id_terlapor = $_POST["Was16d"]["id_terlapor"];
    $model->tgl_was_16d = $_POST["Was16d"]["tgl_was_16d"];
    $model->sifat_surat = $_POST["Was16d"]["sifat_surat"];
    $model->jml_lampiran = $_POST["Was16d"]["jml_lampiran"];
//      $model->satuan_lampiran = $_POST[];
    $model->perihal = $_POST["Was16d"]["perihal"];
    $model->ttd_was_16d = $_POST["Was16d"]["ttd_was_16d"];
    $model->ttd_peg_nik = $_POST["Was16d"]["ttd_peg_nik"];
    $model->ttd_id_jabatan = $_POST["Was16d"]["ttd_id_jabatan"];

    $model->updated_ip = Yii::$app->getRequest()->getUserIP();
      
    $file = \yii\web\UploadedFile::getInstance($model, 'upload_file');
    if (empty($file)) {
      $model->upload_file = $model2->upload_file;
    } else {
      $model->upload_file = $file->name;
    }
    $tembusan = $_POST['id_jabatan'];
    
    $connection = \Yii::$app->db;
    $transaction = $connection->beginTransaction();
    try {
      if ($model->save()) {
        if ($files != false) {
          $path = \Yii::$app->params['uploadPath'] . 'was_16d/' . $files->name;
          $files->saveAs($path);
        }

        //hapus tembusan lalu disimpan lagi 
        TembusanWas16d::deleteAll('id_was_16d=:del', [':del' => $model->id_was_16d]);
        for ($i = 0; $i < count($tembusan); $i++) {
          $saveTembusan = new TembusanWas16d();
          $saveTembusan->id_was_16d = $model->id_was_16d;
          $saveTembusan->id_pejabat_tembusan = $tembusan[$i];
          $saveTembusan->save();
        }

        Yii::$app->getSession()->setFlash('success', [
            'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
            'duration' => 5000, //Integer //3000 default. time for growl to fade out.
            'icon' => 'glyphicon glyphicon-ok-sign', //String
            'message' => 'Data Berhasil Disimpan', // String
            'title' => 'Save', //String
            'positonY' => 'top', //String // defaults to top, allows top or bottom
            'positonX' => 'center', //String // defaults to right, allows right, center, left
            'showProgressbar' => true,
        ]);
      }
      $transaction->commit();

      return $this->redirect(['create']);
    } catch (Exception $e) {
      $transaction->rollback();
    }
  }

   public function actionDelete() {
     $id_was_16d = $_POST['id'];
     $jumlah = $_POST['jml'];
     
   //  echo $id_bawas3;
        for ($i=0; $i <$jumlah ; $i++) { 
            $pecah=explode(',', $id_was_16d);
           // echo $pecah[$i];
          //  $this->findModel($pecah[$i])->delete();
            Was16d::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                               'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                               'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                               'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                               'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                               'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_16d'=>$pecah[$i]]);
        
             // $arr = array(ConstSysMenuComponent::Was17, ConstSysMenuComponent::Was18);
             //        for ($i=0; $i < 2 ; $i++) { 
             //          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-17
             //        }

         }

      Yii::$app->getSession()->setFlash('success', [
          'type' => 'success',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'Data Berhasil Dihapus',
          'title' => 'Hapus Data',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    
      return $this->redirect(['index']);
  }

  public function actionHapus() {
    $id_was_16d = $_GET['id'];
    if (Was16d::updateAll(["flag" => '3'], "id_was_16d ='" . $id_was_16d . "'")) {
      TembusanWas16d::updateAll(["flag" => '3'], "id_was_16d ='" . $id_was_16d . "'");
      Yii::$app->getSession()->setFlash('success', [
          'type' => 'success',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'Data Berhasil Dihapus',
          'title' => 'Hapus Data',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    } else {
      Yii::$app->getSession()->setFlash('success', [
          'type' => 'danger',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'Data Gagal Dihapus',
          'title' => 'Error',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    }
    return $this->redirect(['create']);
  }
  /**
   * Deletes an existing Was16d model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param string $id
   * @return mixed
   */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

  /**
   * Finds the Was16d model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param string $id
   * @return Was16d the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel2($id) {
    if (($model = Was16d::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

   protected function findModel($id)
    {
        if (($model = Was16d::findOne(['id_was_16d'=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
