<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was13Inspeksi;
use app\modules\pengawasan\models\Was13InspeksiSearch;
use app\modules\pengawasan\models\TembusanWas13;
use app\modules\pengawasan\models\Was9_Inspeksi;
use app\modules\pengawasan\models\Was10Inspeksi;
use app\modules\pengawasan\models\Was11Inspeksi;
use app\modules\pengawasan\models\Was12Inspeksi;
use app\modules\pengawasan\models\KpInstSatker;
use app\modules\pengawasan\models\DisposisiIrmud;
use app\modules\pengawasan\components\FungsiComponent;
use yii\widgets\Pjax;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Odf;
use app\models\KpInstSatkerSearch;
use app\components\GlobalFuncComponent;
use yii\grid\GridView;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class Was13InspeksiController extends Controller
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
     * Lists all InspekturModel models.
     * @return mixed
     */
    public function actionIndex()
    {

        // echo "string";
        // exit();
        $searchModel = new Was13InspeksiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // print_r($dataProvider);
        // exit();
        return $this->render('index', [
            //'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InspekturModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InspekturModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
public function actionCreate() {
      $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
      $fungsi=new FungsiComponent();
      $where=$fungsi->static_where_alias('a');
      $connection = \Yii::$app->db;
      $model = new Was13Inspeksi();
     
        $sqlwas9="select  distinct a.* ,b.nama_saksi_internal as nama_saksi, c.nama_pemeriksa,'' as ket from was.was9_inspeksi a 
              left join was.saksi_internal_inspeksi b on a.id_saksi_internal=b.id_saksi_internal 
              and a.jenis_saksi='Internal' 
              and a.no_register=b.no_register
              and a.id_saksi_internal=b.id_saksi_internal
              and a.id_tingkat=b.id_tingkat
              and a.id_kejati=b.id_kejati
              and a.id_kejari=b.id_kejari
              and a.id_cabjari=b.id_cabjari
              and a.id_wilayah=b.id_wilayah
              and a.id_level1=b.id_level1
              and a.id_level2=b.id_level2
              and a.id_level3=b.id_level3
              and a.id_level4=b.id_level4
              left join was.pemeriksa_sp_was2 c 
              on a.id_sp_was2=c.id_sp_was2 
              and a.id_pemeriksa=c.id_pemeriksa_sp_was2
              and a.no_register=c.no_register
              and a.id_tingkat=c.id_tingkat
              and a.id_kejati=c.id_kejati
              and a.id_kejari=c.id_kejari
              and a.id_cabjari=c.id_cabjari
              and a.id_wilayah=c.id_wilayah
              and a.id_level1=c.id_level1
              and a.id_level2=c.id_level2
              and a.id_level3=c.id_level3
              and a.id_level4=c.id_level4
              where a.id_tingkat::text = '".$_SESSION['kode_tk']."' AND a.id_kejati::text ='".$_SESSION['kode_kejati']."'  
                                    AND a.id_kejari::text ='".$_SESSION['kode_kejari']."' AND a.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
                                    AND a.no_register::text ='".$_SESSION['was_register']."' AND a.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                                    AND a.id_level1::text ='".$_SESSION['was_id_level1']."'  AND a.id_level2::text ='".$_SESSION['was_id_level2']."' 
                                    AND a.id_level3::text ='".$_SESSION['was_id_level3']."' AND a.id_level4::text ='".$_SESSION['was_id_level4']."'
                                    and a.trx_akhir=1  and a.jenis_saksi='Internal'
              union ALL 
              select distinct a.* ,b.nama_saksi_eksternal as nama_saksi, c.nama_pemeriksa,'' as ket from was.was9_inspeksi a 
              inner join was.saksi_eksternal_inspeksi b on a.id_saksi_eksternal=b.id_saksi_eksternal 
              and a.jenis_saksi='Eksternal' 
              and a.no_register=b.no_register
              and a.id_saksi_eksternal=b.id_saksi_eksternal
              and a.id_tingkat=b.id_tingkat
              and a.id_kejati=b.id_kejati
              and a.id_kejari=b.id_kejari
              and a.id_cabjari=b.id_cabjari
              and a.id_wilayah=b.id_wilayah
              and a.id_level1=b.id_level1
              and a.id_level2=b.id_level2
              and a.id_level3=b.id_level3
              and a.id_level4=b.id_level4
              inner join was.pemeriksa_sp_was2 c 
              on a.id_sp_was2=c.id_sp_was2
              and a.id_pemeriksa=c.id_pemeriksa_sp_was2
              and a.no_register=c.no_register
              and a.id_tingkat=c.id_tingkat
              and a.id_kejati=c.id_kejati
              and a.id_kejari=c.id_kejari
              and a.id_cabjari=c.id_cabjari
              and a.id_wilayah=c.id_wilayah
              and a.id_level1=c.id_level1
              and a.id_level2=c.id_level2
              and a.id_level3=c.id_level3
              and a.id_level4=c.id_level4
               where a.id_tingkat::text = '".$_SESSION['kode_tk']."' AND a.id_kejati::text ='".$_SESSION['kode_kejati']."'  
                                    AND a.id_kejari::text ='".$_SESSION['kode_kejari']."' AND a.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
                                    AND a.no_register::text ='".$_SESSION['was_register']."' AND a.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                                    AND a.id_level1::text ='".$_SESSION['was_id_level1']."'  AND a.id_level2::text ='".$_SESSION['was_id_level2']."' 
                                    AND a.id_level3::text ='".$_SESSION['was_id_level3']."' AND a.id_level4::text ='".$_SESSION['was_id_level4']."'
                                    and a.trx_akhir=1 and a.jenis_saksi='Eksternal'";
        // print_r($sqlwas9);
        // exit();
        $modelWas9=$connection->createCommand($sqlwas9)->queryAll();  


        
        $modelWas10=Was10Inspeksi::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                                    'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                                    'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                                    'id_level4'=>$_SESSION['was_id_level4']]);
         
         $sqlwas11="select a.*,
                (select string_agg(b.nama_saksi_eksternal,'#')
                 from was.was11_inspeksi_saksi_ext b 
                 where 
                 a.id_surat_was11=b.id_was_11 
                 and a.no_register=b.no_register 
                 and a.id_tingkat=b.id_tingkat 
                 and a.id_kejati=b.id_kejati 
                 and a.id_kejari=b.id_kejari 
                 and a.id_cabjari=b.id_cabjari 
                 and a.id_wilayah=b.id_wilayah 
                 and a.id_level1=b.id_level1 
                 and a.id_level2=b.id_level2 
                 and a.id_level3=b.id_level3 
                 and a.id_level4=b.id_level4) as nama_saksi 
 from was.was11_inspeksi a  where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.jns_saksi='Eksternal' $where
  union
                select a.*,
              (select string_agg(b.nama_saksi_internal,'#') 
              from was.was11_inspeksi_saksi_int b where 
              a.id_surat_was11=b.id_was_11 
              and a.no_register=b.no_register 
              and a.id_tingkat=b.id_tingkat 
              and a.id_kejati=b.id_kejati 
              and a.id_kejari=b.id_kejari 
              and a.id_cabjari=b.id_cabjari 
              and a.id_wilayah=b.id_wilayah 
              and a.id_level1=b.id_level1 
              and a.id_level2=b.id_level2 
              and a.id_level3=b.id_level3 
              and a.id_level4=b.id_level4) as nama_saksi 
 from was.was11_inspeksi a  where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.jns_saksi='Internal' $where";
 

  $modelWas11=$connection->createCommand($sqlwas11)->queryAll();

        $sql="select a.id_was_12,a.no_surat_was12, b.nama_pegawai_terlapor ,a.tanggal_was12,a.nama_penandatangan,a.kepada_was12,a.*
                                        from was.was12_inspeksi a
                                        inner join was.was12_inspeksi_terlapor b on a.id_was_12=b.id_was_12
                                        and a.no_register=b.no_register
                                        and a.id_tingkat=b.id_tingkat
                                        and a.id_kejati=b.id_kejati
                                        and a.id_kejari=b.id_kejari
                                        and a.id_cabjari=b.id_cabjari
                                        and a.id_wilayah=b.id_wilayah
                                        and a.id_level1=b.id_level1
                                        and a.id_level2=b.id_level2
                                        and a.id_level3=b.id_level3
                                        and a.id_level4=b.id_level4
                                        WHERE  a.id_tingkat::text = '".$_SESSION['kode_tk']."' AND a.id_kejati::text ='".$_SESSION['kode_kejati']."'  
                                        AND a.id_kejari::text ='".$_SESSION['kode_kejari']."' AND a.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
                                        AND a.no_register::text ='".$_SESSION['was_register']."' AND a.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                                        AND a.id_level1::text ='".$_SESSION['was_id_level1']."'  AND a.id_level2::text ='".$_SESSION['was_id_level2']."' 
                                        AND a.id_level3::text ='".$_SESSION['was_id_level3']."' AND a.id_level4::text ='".$_SESSION['was_id_level4']."'";
        $modelWas12=$connection->createCommand($sql)->queryAll();                          
      
        $query1 = "select * from was.was_disposisi_irmud where no_register='".$_SESSION['was_register']."'";
        $disposisi_irmud = $connection->createCommand($query1)->queryAll(); 
       
        if ($model->load(Yii::$app->request->post())) {
           $files = \yii\web\UploadedFile::getInstance($model,'was13_file');
             if ($files != false) {
                $model->was13_file=date('Y-m-d').$files->name;
                }
           // $model->nama_surat='1'; 
           //$model->inst_satkerkd='00'; 
           $model->no_register=$_SESSION['was_register']; 
           //$model->is_inspektur_irmud_riksa=$_SESSION['is_inspektur_irmud_riksa']; 
           $model->created_by=\Yii::$app->user->identity->id;
           $model->created_ip=$_SERVER['REMOTE_ADDR'];
           $model->created_time=date('Y-m-d H:i:s');
         //  $model->tanggal_dikirim=date('Y-m-d', strtotime($_POST['Was13inspeksi']['tanggal_dikirim']));
          // $model->id_sp_was2=$_POST['Was13inspeksi']['id_sp_was2']; 
            // print_r($model->tanggal_diterima);
            // exit();
          // $model->tanggal_diterima=date('Y-m-d', strtotime($_POST['Was13inspeksi']['tanggal_diterima']));
           $model->id_tingkat=$_SESSION['kode_tk']; 
           $model->id_kejati=$_SESSION['kode_kejati']; 
           $model->id_kejari=$_SESSION['kode_kejari']; 
           $model->id_cabjari=$_SESSION['kode_cabjari']; 
           $model->tanggal_dikirim=date("Y-m-d", strtotime($_POST['Was13Inspeksi']['tanggal_dikirim']));; 
           $model->tanggal_diterima=date("Y-m-d", strtotime($_POST['Was13Inspeksi']['tanggal_diterima']));; 
           

          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          
          //print_r($model);
          //exit();
          try {
            if ($model->save()) {
                
       
              if ($files != false) {
                $path = \Yii::$app->params['uploadPath'] . 'was_13_inspeksi/' . date('Y-m-d').$files->name;
                $files->saveAs($path);
              }

        
            }
            Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Was13 Berhasil Disimpan',
             'title' => 'Simpan Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
             ]);
            $transaction->commit();
            if($_POST['print']=='1'){
               //   unset($_POST['action']);
               // $this->redirect('lapdu/view?id=r001');
                $this->cetak($model->id_was13);

               }

            return $this->redirect(['index']);
          } catch (Exception $e) {
            $transaction->rollback();
          }
        } else {
          return $this->render('create', [
                      'model' => $model,
                      'modelWas9' => $modelWas9,
                      'modelWas10' => $modelWas10,
                      'modelWas11' => $modelWas11,
                      'modelWas12' => $modelWas12,
          ]);
        }

        // echo "string";
  }
  public function actionUpdate($id,$nm_surat) {
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $res = "";
    for ($i = 0; $i < 10; $i++) {
        $res .= $chars[mt_rand(0, strlen($chars)-1)];
    }

    $connection = \Yii::$app->db;
    $model=$this->findModel($id,$id_surat);
    $fungsi=new FungsiComponent();
    $where=$fungsi->static_where_alias('a');
    $sqlwas9="select a.id_surat_was9,a.id_sp_was2,a.nomor_surat_was9,b.nama_saksi_internal as nama_saksi,a.nama_pemeriksa,a.jenis_saksi,
              a.tanggal_was9,a.nama_penandatangan from was.was9_Inspeksi a inner join was.saksi_internal_Inspeksi b on a.id_saksi_internal=b.id_saksi_internal 
              and  a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati 
              and a.id_kejari=b.id_kejari and a.id_cabjari=b.id_cabjari and a.id_wilayah=b.id_wilayah and a.id_level1=b.id_level1 
              and a.id_level2=b.id_level2 and a.id_level3=b.id_level3 and a.id_level4=b.id_level4 
              where a.trx_akhir=1 and a.no_register='".$_SESSION['was_register']."' 
              and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' 
              and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where
              union
              select a.id_surat_was9,a.id_sp_was2,a.nomor_surat_was9,b.nama_saksi_eksternal as nama_saksi,a.nama_pemeriksa,a.jenis_saksi,
              a.tanggal_was9,a.nama_penandatangan from was.was9_Inspeksi a inner join was.saksi_eksternal_Inspeksi b on a.id_saksi_eksternal=b.id_saksi_eksternal 
              and  a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati 
              and a.id_kejari=b.id_kejari and a.id_cabjari=b.id_cabjari and a.id_wilayah=b.id_wilayah and a.id_level1=b.id_level1 
              and a.id_level2=b.id_level2 and a.id_level3=b.id_level3 and a.id_level4=b.id_level4  
              where a.trx_akhir=1 and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
              and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
              and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
  $modelWas9=$connection->createCommand($sqlwas9)->queryAll();  
  // print_r($sqlwas9);
  // exit();
  $modelWas10=Was10Inspeksi::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'trx_akhir'=>1]);
    
  $sqlwas11="select a.*,
                (select string_agg(b.nama_saksi_eksternal,'#')
                 from was.was11_inspeksi_saksi_ext b 
                 where 
                 a.id_surat_was11=b.id_was_11 
                 and a.no_register=b.no_register 
                 and a.id_tingkat=b.id_tingkat 
                 and a.id_kejati=b.id_kejati 
                 and a.id_kejari=b.id_kejari 
                 and a.id_cabjari=b.id_cabjari 
                 and a.id_wilayah=b.id_wilayah 
                 and a.id_level1=b.id_level1 
                 and a.id_level2=b.id_level2 
                 and a.id_level3=b.id_level3 
                 and a.id_level4=b.id_level4) as nama_saksi 
 from was.was11_inspeksi a  where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.jns_saksi='Eksternal' $where
  union
                select a.*,
              (select string_agg(b.nama_saksi_internal,'#') 
              from was.was11_inspeksi_saksi_int b where 
              a.id_surat_was11=b.id_was_11 
              and a.no_register=b.no_register 
              and a.id_tingkat=b.id_tingkat 
              and a.id_kejati=b.id_kejati 
              and a.id_kejari=b.id_kejari 
              and a.id_cabjari=b.id_cabjari 
              and a.id_wilayah=b.id_wilayah 
              and a.id_level1=b.id_level1 
              and a.id_level2=b.id_level2 
              and a.id_level3=b.id_level3 
              and a.id_level4=b.id_level4) as nama_saksi 
 from was.was11_inspeksi a  where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.jns_saksi='Internal' $where";
  $modelWas11=$modelWas12=$connection->createCommand($sqlwas11)->queryAll(); 
  
  $sqlWas12="select a.id_was_12,a.no_surat_was12,a.tanggal_was12,a.nama_penandatangan,a.kepada_was12,a.*,
             (select string_agg(nama_pegawai_terlapor,'#') as nama_pegawai_terlapor from was.was12_inspeksi_terlapor 
              where id_was_12=a.id_was_12) from was.was12_inspeksi a
              where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
              and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
              and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
  $modelWas12=$connection->createCommand($sqlWas12)->queryAll(); 
    
    $is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/         
    $OldFile=$model->was13_file;

      if ($model->load(Yii::$app->request->post())) {
          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
       
      try {
      
       $file_name    = $_FILES['was13_file']['name'];
       $file_size    = $_FILES['was13_file']['size'];
       $file_tmp     = $_FILES['was13_file']['tmp_name'];
       $file_type    = $_FILES['was13_file']['type'];
       $ext = pathinfo($file_name, PATHINFO_EXTENSION);
       $tmp = explode('.', $_FILES['was13_file']['name']);
       $file_exists = end($tmp);
       $rename_file = $is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].'_'.$res.'.'.$ext;
       
  
     
       $model->no_register=$_SESSION['was_register']; 
       $model->updated_ip=$_SERVER['REMOTE_ADDR'];
       $model->updated_by=\Yii::$app->user->identity->id;
       $model->updated_time=date('Y-m-d H:i:s');
       // print_r($model->tanggal_dikirim);
       // exit();
       $model->tanggal_dikirim=date('Y-m-d', strtotime($_POST['Was13Inspeksi']['tanggal_dikirim']));
       $model->tanggal_diterima=date('Y-m-d', strtotime($_POST['Was13Inspeksi']['tanggal_diterima']));
     /*  print_r($model->tanggal_diterima);
       exit();*/
       $model->was13_file = ($file_name==''?$OldFile:$rename_file);
       // print_r( $model->was13_file);
       // exit();
       if($model->save()) {
           
            if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_13_inspeksi/'.$OldFile)) {
                unlink(\Yii::$app->params['uploadPath'].'was_13_inspeksi/'.$OldFile);
            }
        }

        move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_13_inspeksi/'.$rename_file);   
        Yii::$app->getSession()->setFlash('success', [
         'type' => 'success',
         'duration' => 3000,
         'icon' => 'fa fa-users',
         'message' => 'Data Was13 Berhasil Disimpan',
         'title' => 'Simpan Data',
         'positonY' => 'top',
         'positonX' => 'center',
         'showProgressbar' => true,
         ]);
        $transaction->commit();
        return $this->redirect(['index']);
      } catch (Exception $e) {
        $transaction->rollback();
        if(YII_DEBUG){throw $e; exit;} else{return false;}
      } 
    
    } else {

     return $this->render('update', [
                  'model' => $model,
                  'modelWas9' => $modelWas9,
                  'modelWas10' => $modelWas10,
                  'modelWas11' => $modelWas11,
                  'modelWas12' => $modelWas12,
      ]);
   }

  }

    /**
     * Updates an existing InspekturModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate_old($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            // return $this->redirect(['view', 'id' => $model->id_inspektur]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InspekturModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete_old()
    {
        //Yii::$app->controller->enableCsrfValidation = false;
        //print_r($_POST);
        if($_POST['selection_all']==1){
            DipaMaster::deleteAll();
            return $this->redirect(['index']);
        } else {
            foreach ($_POST['selection'] as $key => $value) {
                $this->findModel($value)->delete();
            }
            return $this->redirect(['index']);
        }
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
    }

    public function actionDelete() {
        $id  = explode(',', $_POST['id']);
        $jml=$_POST['jml'];

     //   
       
        for ($z=0; $z <count($id) ; $z++) { 
            
            $kode=explode("#",$id[$z]);
            // // echo $jml;
            // echo $kode[0];
            // echo $kode[1];
            Was13Inspeksi::deleteAll(['id_was13'=>$kode[0],
                                      'id_tingkat'=>$_SESSION['kode_tk'],
                                      'id_kejati'=>$_SESSION['kode_kejati'],
                                      'id_kejari'=>$_SESSION['kode_kejari'],
                                      'id_cabjari'=>$_SESSION['kode_cabjari'],
                                      'no_register'=>$_SESSION['was_register'],
                                      'id_wilayah'=>$_SESSION['was_id_wilayah'],
                                      'id_level1'=>$_SESSION['was_id_level1'],
                                      'id_level2'=>$_SESSION['was_id_level2'],
                                      'id_level3'=>$_SESSION['was_id_level3'],
                                      'id_level4'=>$_SESSION['was_id_level4']
                                  ]);
    }
        Yii::$app->getSession()->setFlash('success', [
         'type' => 'success',
         'duration' => 3000,
         'icon' => 'fa fa-users',
         'message' => 'Data Was13 Berhasil Dihapus',
         'title' => 'Simpan Data',
         'positonY' => 'top',
         'positonX' => 'center',
         'showProgressbar' => true,
         ]);
         return $this->redirect(['index']);
             
  }

    /**
     * Finds the InspekturModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InspekturModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
   public function actionCetakwas($id){
    $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
    $model=$this->findModel($id);
    
    $fungsi=new FungsiComponent();
      $where=$fungsi->static_where_alias('a');
      $connection = \Yii::$app->db;

      $tgl_terima=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime(date('d-m-Y', strtotime($model['tanggal_diterima'])))));
      $tgl_surat =GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime(date('d-m-Y', strtotime($model['tanggal_surat'])))));
      $hari=GlobalFuncComponent::getNamaHari($model['tanggal_diterima']);
      
      // print_r($model);
      // print_r($model);
      // exit();
     return $this->render('cetak',[
                        'model'=>$model,
                        'data_satker'=>$data_satker,
                        'hari'=>$hari,
                        'tgl_surat'=>$tgl_surat,
                        'tgl_terima'=>$tgl_terima,
      ]);

    }

    public function actionGetpengirim(){
       
   $searchModelWas13 = new Was13InspeksiSearch();
   $dataProviderPengirim = $searchModelWas13->searchPengirim(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpengirim-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPengirim','enablePushState' => false]); 
   echo GridView::widget([
                                'dataProvider'=> $dataProviderPengirim,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    // ['label'=>'No Surat',
                                    //     'headerOptions'=>['style'=>'text-align:center;'],
                                    //     'attribute'=>'id_surat',
                                    // ],

                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip_nrp',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],

                                    ['label'=>'golongan/pangkat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'gol_pangkat',
                                    ],

                                    ['label'=>'Jabatan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan',
                                    ],


                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['nip_nrp'],'class'=>'selection_one_pengirim','json'=>$result];
                                            },
                                    ],
                                    
                                 ],   

                            ]);
          Pjax::end();
    }

    public function actionGetpenerima(){
       
   $searchModelWas13 = new Was13InspeksiSearch();
   $dataProviderPenerima = $searchModelWas13->searchPenerima(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpenerima-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenerima','enablePushState' => false]); 
   echo GridView::widget([
                                'dataProvider'=> $dataProviderPenerima,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    // ['label'=>'No Surat',
                                    //     'headerOptions'=>['style'=>'text-align:center;'],
                                    //     'attribute'=>'id_surat',
                                    // ],

                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip_nrp',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],

                                    ['label'=>'golongan/pangkat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'gol_pangkat',
                                    ],

                                    ['label'=>'Jabatan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan',
                                    ],


                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['nip'],'class'=>'selection_one_penerima','json'=>$result];
                                            },
                                    ],
                                    
                                 ],   

                            ]);
          Pjax::end();
    }

   protected function findModel($id) {
  // $kode =explode(".",$id);
  if (($model = Was13Inspeksi::findOne(['id_was13'=>$id,
                                        'id_tingkat'=>$_SESSION['kode_tk'],
                                        'id_kejati'=>$_SESSION['kode_kejati'],
                                        'id_kejari'=>$_SESSION['kode_kejari'],
                                        'id_cabjari'=>$_SESSION['kode_cabjari'],
                                        'no_register'=>$_SESSION['was_register'],
                                        'id_wilayah'=>$_SESSION['was_id_wilayah'],
                                        'id_level1'=>$_SESSION['was_id_level1'],
                                        'id_level2'=>$_SESSION['was_id_level2'],
                                        'id_level3'=>$_SESSION['was_id_level3'],
                                        'id_level4'=>$_SESSION['was_id_level4']
                  ])) !== null) {  // kalau cma satu-> findOne($id)
  //if (($model = Was13::findOne(['id_surat'=>$id])) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
