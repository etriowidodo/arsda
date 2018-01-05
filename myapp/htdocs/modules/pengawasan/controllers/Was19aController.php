<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was19a;
use app\modules\pengawasan\models\Was19aSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\TembusanWas19a;
use yii\helpers\Json;
use Nasution\Terbilang;
use yii\db\Query;
use Odf;

/**
 * Was19aController implements the CRUD actions for Was19a model.
 */
class Was19aController extends Controller
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
     * Lists all Was19a models.
     * @return mixed
     */
    public function actionIndex()
    {
       $model = new Was19a();

      //  $modelTembusan = new TembusanWas19a();

        return $this->render('index', [
            'model' => $model,
          //  'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Was19a model.
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
     * Creates a new Was19a model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Was19a();

        $modelTembusan = new TembusanWas19a();
        if($_POST['Was19a']){
        if ($model->load(Yii::$app->request->post())){
             $connection = \Yii::$app->db;
             $transaction = $connection->beginTransaction();
           try {
           
                $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
           
           
            $model->upload_file = $files->name;
            if($model->save()) {
                $pejabat =  $_POST['id_jabatan'];
                for($i=0;$i<count($pejabat);$i++){
                    $saveTembusan = new TembusanWas19a();
                    $saveTembusan->id_was_19a = $model->id_was_19a;
                    $saveTembusan->id_pejabat_tembusan = $pejabat[$i];
                   
                    $saveTembusan->save();
                }
              
                   if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'was_19a/'.$files->name;
                    $files->saveAs($path);
                } 
               
                  $transaction->commit();
                  
              
          

     
      //  echo Json::encode(['response'=>'success']);
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
           //     $modelTembusan = TembusanWas9::find()->where("id_was_9 = :id",[":id"=>$model->id_was_9])->asArray()->all();
              return $this->redirect('index');
        } else{
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
           
       } catch(Exception $e) {

                    $transaction->rollback();
            }
        }         
        else { 
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
    }else{
       $view_pemberitahuan = $this->renderAjax('_form', [
           'model' => $model,
           'modelTembusan' => $modelTembusan,
        ]);   
    }
    echo  \yii\helpers\Json::encode(['key'=>$key,'view_pemberitahuan'=>$view_pemberitahuan]);
     \Yii::$app->end();
    }
    /**
     * Updates an existing Was19a model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
           $model = new Was19a();
	if($_POST['Was19a']){  
             $model = $this->findModel($_POST['Was19a']['id_was_19a']);
          if ($model->load(Yii::$app->request->post())){  
            
             $connection = \Yii::$app->db;
             $transaction = $connection->beginTransaction();
           try {
           
                $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
           
            
            $model->upload_file = $files->name;
         
        
            if($model->save()) {
                 $delete_tembusan = $_POST['delete_tembusan'];
                $delete_tembusan = explode("#",$delete_tembusan);
                $pejabat =  $_POST['id_jabatan'];
                 if(count($delete_tembusan) > 1){
                   for($j=1;$j<count($delete_tembusan);$j++){
                       $deleteTembusan = TembusanWas19a::find()->where('id_pejabat_tembusan = :id and id_was_19a = :id_was',[":id"=>$delete_tembusan[$j],":id_was"=>$model->id_was_19a])->one();
                        $deleteTembusan->delete();
                   }
                }
                for($i=0;$i<count($pejabat);$i++){
                    $saveTembusan = new TembusanWas19a();
                    $saveTembusan->id_was_19a = $model->id_was_19a;
                    $saveTembusan->id_pejabat_tembusan = $pejabat[$i];
                    $saveTembusan->save();
                }
                
                

                
              
                   if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'was_19a/'.$files->name;
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
        $key = $_POST['id_was_19a'];
       
        $model = $this->findModel($key);
       
        
        $modelTembusan = TembusanWas19a::find()->where('id_was_19a=:idWas',[':idWas'=>$key])->all();
      
	        
        $view_pemberitahuan = $this->renderAjax('_form', [
            'model' => $model,
            'modelTembusan' => $modelTembusan,
           
        ]);
      //   header('Content-Type: application/json; charset=utf-8');
    echo  \yii\helpers\Json::encode(['key'=>$key,'view_pemberitahuan'=>$view_pemberitahuan]);
     \Yii::$app->end();
        //return CJSON::encode(['key'=>$key,'view_pemberitahuan'=>$view_pemberitahuan]);
      //  return json_encode($key);
        }
    }

    /**
     * Deletes an existing Was19a model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
               //$this->findModel($id)->delete();
        $selection = $_POST['selection'];
        $transaction = Yii::$app->db->beginTransaction();
        try {
           

           for($i=0;$i<count($selection);$i++){
               $update = Was19a::updateAll(['flag' => '3'], 'id_was_19a = :id', [':id'=>$selection[$i]]);
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
         $id_was_19a = $_GET['id_was_19a'];
         $odf = new Odf(Yii::$app->params['reportPengawasan']."was_19a.odt");
          

      
        
        $sql1 = "select a.no_was_19a,b.inst_nama AS kejaksaan,b.inst_lokinst AS di,a.id_register,a.tgl_was_19a,c.nm_lookup_item AS sifat,
a.jml_lampiran,a.satuan_lampiran,
d.jabatan AS kepada, g.jabatan AS dari,
 e.peg_nama AS nama_terlapor, e.peg_nip AS nip_terlapor, 
    e.peg_nrp AS nrp_terlapor, e.jabatan AS jabatan_terlapor, 
    h.uraian,
a.ttd_peg_nik, f.peg_nip AS ttd_nip, f.peg_nama AS ttd_nama, f.jabatan AS ttd_jabatan  
from was.was_19a a
JOIN kepegawaian.kp_inst_satker b ON a.inst_satkerkd::text = b.inst_satkerkd::text
   JOIN was.lookup_item c ON a.sifat_surat = c.kd_lookup_item::integer AND c.kd_lookup_group = '01'::bpchar AND c.kd_lookup_item = '3'::bpchar
   JOIN was.v_pejabat_pimpinan d ON a.kpd_was_19a= d.id_jabatan_pejabat
   JOIN was.v_terlapor e ON a.id_terlapor::text = e.id_terlapor::text
   JOIN was.v_pejabat_pimpinan g ON a.ttd_was_19a = g.id_jabatan_pejabat
   JOIN was.v_riwayat_jabatan f ON a.ttd_id_jabatan::text = f.id::text
   JOIN was.v_dugaan_pelanggaran h on a.id_register = h.id_register
   where  a.id_was_19a='".$id_was_19a."' and a.id_register = '".$id_register."'";
        $data = Was19a::findBySql($sql1)->asArray()->one();
       // $data = $command->queryOne(); 
        
       
       
       
        
        $sqlTembusan = new Query;
        $sqlTembusan->select('b.jabatan');
        $sqlTembusan->from("was.tembusan_was_19a a");
        $sqlTembusan->join("inner join", "was.v_pejabat_tembusan b", "(a.id_pejabat_tembusan=b.id_pejabat_tembusan)");
        $sqlTembusan->where("a.id_was_19a = :idWas",[":idWas"=>$id_was_19a]);
        $commandTembusan = $sqlTembusan->createCommand();
        $dataTembusan = $commandTembusan->queryAll(); 
       
        $odf->setVars('kejaksaan', $data['kejaksaan']);
        $odf->setVars('kepada',  $data['kepada']);
       // $odf->setVars('dari',  $data['dari']);
        $odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_19a']));
        $odf->setVars('nomor',  $data['no_was_19a']);
        $odf->setVars('sifat',  $data['sifat']);
        $odf->setVars('nipTerlapor', $data['nip_terlapor']);
        $odf->setVars('namaTerlapor',  $data['nama_terlapor']);
        $odf->setVars('jabatanTerlapor',  $data['jabatan_terlapor']);
      //  $odf->setVars('uraianPermasalahan',  $data['uraian']);
       // $odf->setVars('keputusanJA',  $data['kputusan_ja']);
        
       
         $terbilang = new Terbilang();
        //  $ini = $was_16a->jml_lampiran." (".$terbilang->convert($was_16a->jml_lampiran).")";
        //  $odf->setVars('jml_lampiran', $ini);
        $odf->setVars('berkas',  $data['jml_lampiran'] .'('.(!empty($data['jml_lampiran'])?$terbilang->convert(trim($data['jml_lampiran'])):'').')');
        
      
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
        $odf->exportAsAttachedFile("WAS19A- ".$dugaan['terlapor'].".odt");
        Yii::$app->end();
    }

    
    /**
     * Finds the Was19a model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was19a the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was19a::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
