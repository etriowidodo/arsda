<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was3;
use app\modules\pengawasan\models\Was3Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\TembusanWas3;
use yii\db\Query;
use Odf;
use Nasution\Terbilang;


/**
 * Was3Controller implements the CRUD actions for Was3 model.
 */
class Was3Controller extends Controller
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
     * Lists all Was3 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Was3Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Was3 model.
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
     * Creates a new Was3 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
    {
         $session = Yii::$app->session;
        if (isset($session['was_register']) && !empty($session['was_register'])) {
           
           $findWas = Was3::find()->where("id_register = :id and flag<>'3'",[":id"=>$session['was_register']])->asArray()->one();
           
             if(isset($findWas) && count($findWas > 0)){
                
                  return $this->redirect(['update', 'id' => $findWas['id_was_3']]); 
             }else{
        $model = new Was3();
        $modelTembusan = new TembusanWas3();
       
        if ($model->load(Yii::$app->request->post()) ) {
             $pejabat =  $_POST['id_jabatan'];
           
                $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
           // $files = \yii\web\UploadedFile::getInstanceByName($model,'upload_file');
           // store the source file name
           
            $model->upload_file = $files->name;
            if($model->save()){
                for($i=0;$i<count($pejabat);$i++){
                    $saveTembusan = new TembusanWas3;
                    $saveTembusan->id_was_3 = $model->id_was_3;
                    $saveTembusan->id_pejabat_tembusan = $pejabat[$i];
                    $saveTembusan->save();
                }
            
               
                 if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'was_3/'.$files->name;
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
            return $this->redirect(['update', 'id' => $model->id_was_3]);
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
     * Updates an existing Was3 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $modelTembusan = TembusanWas3::find()->where("id_was_3 = :id",[":id"=>$model['id_was_3']])->asArray()->all();
        
         $oldFileName = $model->upload_file;
        $oldFile = (isset($model->upload_file) ? Yii::$app->params['uploadPath'] .'was_3/'. $model->upload_file : null);
         if ($model->load(Yii::$app->request->post()) ) {
           
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
                       $deleteTembusan = TembusanWas3::find()->where('id_pejabat_tembusan = :id and id_was_3 = :id_was',[":id"=>$delete_tembusan[$j],":id_was"=>$model->id_was_3])->one();
                        $deleteTembusan->delete();
                   }
                }
                 $pejabat =  $_POST['id_jabatan'];
               
                for($i=0;$i<count($pejabat);$i++){
                    echo "tesmbusan 1";
                    $saveTembusan = new TembusanWas3;
                    $saveTembusan->id_was_3 = $model->id_was_3;
                    $saveTembusan->id_pejabat_tembusan = $pejabat[$i];
                    $saveTembusan->save();
               
                   
                }
               
             if ($files != false && !empty($oldFileName)) { // delete old and overwrite
                    unlink($oldFile);
                    $path = \Yii::$app->params['uploadPath'].'was_3/'.$files->name;
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
 ]);   $transaction->commit();
            return $this->redirect(['update', 'id' => $model->id_was_3]);
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
              return $this->redirect(['update', 'id' => $model->id_was_3]);
            }
           } catch(Exception $e) {

                    $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTembusan' => $modelTembusan,
            ]);
        }
    }
    
    /**
     * Deletes an existing Was3 model.
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
        $updateData->flag = '3';
        $updateData->save();
      //  print_r(\kartik\form\ActiveForm::validate($updateData));exit();
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
         $id_was_3 = $_GET['id_was_3'];
         $odf = new Odf(Yii::$app->params['reportPengawasan']."was_3.odt");
          

        $sql1 = new Query;
        $sql1->select('c.inst_nama as satker_was_3,c.inst_lokinst
,h.jabatan as kpd_was_3
,i.jabatan as dari
,b.no_was_3
,b.tgl_was_3
,jml_lampiran
,a.tgl_dugaan
,a.perihal
,a.ringkasan
,c.inst_nama as satker_dugaan_pelanggaran
,COALESCE(g."peg_nip_baru",g."peg_nip") as peg_nip
,g.peg_nama
,g.jabatan');
        $sql1->from("was.dugaan_pelanggaran a");
        $sql1->join("inner join", "was.was_3 b", "(a.id_register=b.id_register)");
        $sql1->join("inner join","kepegawaian.kp_inst_satker c","(b.inst_satkerkd = c.inst_satkerkd)");
        $sql1->join("inner join", "kepegawaian.kp_inst_satker d","(a.inst_satkerkd = d.inst_satkerkd)");
        $sql1->join("inner join", "was.v_riwayat_jabatan g","(cast(b.ttd_id_jabatan as numeric) = g.id)");
	$sql1->join("inner join", "was.v_pejabat_pimpinan h","(b.kpd_was_3=h.id_jabatan_pejabat)");
	$sql1->join("inner join","was.v_pejabat_pimpinan i","(b.ttd_was_3=i.id_jabatan_pejabat)");
        $sql1->where("a.id_register = :idRegister and b.id_was_3 = :idWas" ,[":idRegister"=>$id_register,":idWas"=>$id_was_3]);
        $command = $sql1->createCommand();
        $data = $command->queryOne(); 
        
        $sql2 = new Query;
        $sql2->select('*');
        $sql2->from("was.v_terlapor");
        $sql2->where("id_register = :idRegister",[":idRegister"=>$id_register]);
        $command2 = $sql2->createCommand();
        $data2 = $command2->queryAll(); 
        
       
        $sql3 = new Query;
        $sql3->select('*');
        $sql3->from("was.v_pelapor");
        $sql3->where("id_register = :idRegister",[":idRegister"=>$id_register]);
        $command3 = $sql3->createCommand();
        $data3 = $command3->queryAll(); 
        
        $sql4 = new Query;
        $sql4->select('b.jabatan');
        $sql4->from("was.tembusan_was_3 a");
        $sql4->join("inner join", "was.v_pejabat_tembusan b", "(a.id_pejabat_tembusan=b.id_pejabat_tembusan)");
        $sql4->where("a.id_was_3 = :idWas",[":idWas"=>$id_was_3]);
        $command4 = $sql4->createCommand();
        $data4 = $command4->queryAll(); 
        $terbilang = new Terbilang();
        $odf->setVars('kejaksaan', $data['satker_was_3']);
        $odf->setVars('nomor',  $data['no_was_3']);
        $odf->setVars('lampiran',  $data['jml_lampiran'] .'('.$terbilang->convert(trim($data['jml_lampiran'])).')');
     //  $odf->setVars('lampiran',  $data['jml_lampiran'] );
        $odf->setVars('tempat',  $data['inst_lokinst']);
        $odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_3']));
        $odf->setVars('tempat',  $data['inst_lokinst']);
        $odf->setVars('kepada_was3',  $data['kpd_was_3']);
        $odf->setVars('ringkasan',  $data['ringkasan']);
        $odf->setVars('tanggalDugaan',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_dugaan']));
        $odf->setVars('tembusan1',  (!empty($data4[0]['jabatan'])?$data4[0]['jabatan'] : ""));
         $odf->setVars('dugaanData', (!empty($data2[0]['peg_nama'])? $data2[0]['peg_nama'] : "").', '.(!empty($data2[0]['peg_nip'])? $data2[0]['peg_nip'] : "").', '.(!empty($data2[0]['jabatan'])?$data2[0]['jabatan'] : "") . (count($data2) > 1? " ,dkk" : ""));
         $odf->setVars('perihal',  $data['perihal']);
         $odf->setVars('jabatan',  $data['jabatan']);
         $odf->setVars('pelapor',  (!empty($data3[0]['nama'])?$data3[0]['nama'] : "").', '.(!empty($data3[0]['alamat'])?$data3[0]['alamat'] : ""));
         $odf->setVars('satkerDugaan',  $data['satker_dugaan_pelanggaran']);
     /*   $odf->setVars('kepada',  $data['kpd_was_2']);
        $odf->setVars('dari',  $data['dari']);
        $odf->setVars('tanggalWas2',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_2']));
        
        $odf->setVars('dugaanNama',  (!empty($data2[0]['peg_nama'])? $data2[0]['peg_nama'] : ""));
        $odf->setVars('dugaanNip',  (!empty($data2[0]['peg_nip'])? $data2[0]['peg_nip'] : ""));
        $odf->setVars('dugaanJabatan', (!empty($data2[0]['jabatan'])?$data2[0]['jabatan'] : "") . (count($data2) > 1? " ,dkk" : ""));
        $odf->setVars('dugaanNrp',  (!empty($data2[0]['peg_nrp'])? $data2[0]['peg_nrp'] : ""));
        $odf->setVars('pelaporNama',  (!empty($data3[0]['nama'])?$data3[0]['nama'] : ""));
        $odf->setVars('perihal',  $data['perihal']);
        $odf->setVars('ringkasan',  $data['ringkasan']);
        $odf->setVars('kepadaSatker',  $data['satker_dugaan_pelanggaran']);
        $odf->setVars('tanggalDugaan',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_dugaan']));
        // $terbilang = new Terbilang();
        //  $ini = $was_16a->jml_lampiran." (".$terbilang->convert($was_16a->jml_lampiran).")";
        //  $odf->setVars('jml_lampiran', $ini);
        $odf->setVars('berkas',  $data['jml_lampiran'] .'('.$terbilang->convert($data['jml_lampiran']).')');
        $odf->setVars('tembusan1',  (!empty($data4[0]['jabatan'])?$data4[0]['jabatan'] : ""));*/
        $dft_tembusan = $odf->setSegment('tembusan');
        $i = 1;
        foreach($data4 as $dataTembusan){
          $dft_tembusan->tembusanJabatan($i.". ".$dataTembusan['jabatan']);
           $dft_tembusan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_tembusan);
     
     

        $odf->exportAsAttachedFile("was3".$id_was_2.".odt");
        Yii::$app->end();
    }

    /**
     * Finds the Was3 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was3 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was3::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
