<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\PdsDikSurat;


use app\modules\pidsus\models\PdsDikSuratSearch;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\PdsDikSuratKeterangan;
use app\modules\pidsus\models\PdsDikSuratJaksa;
use app\modules\pidsus\models\PdsDikSuratSaksi;
use app\modules\pidsus\models\PdsDikSaksi;

use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsDikJaksa;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Pidsus18Controller implements the CRUD actions for PdsDikSurat model.
 */
class Ba1Controller extends Controller
{
    public $idJenisSurat='ba1';
    public $perihalSurat='BA Pemeriksaan Saksi/Tersangka';
    public $title='BA 1 - BA Pemeriksaan Saksi/Tersangka';
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
     * Lists all PdsDikSurat models.
     * @return mixed
     */
    public function actionIndex()
    {

        if(isset($_SESSION['idPdsDik'])){
            $idPdsDik=$_SESSION['idPdsDik'];
        }
        else if (isset($_SESSION['idPdsLid'])){
            $modelPdsDik=PdsDik::find()->where(['id_pds_lid_parent'=>$_SESSION['idPdsLid']])->one();
            $idPdsDik=$modelPdsDik->id_pds_dik;
        }
        else{
            return $this->redirect(['../pidsus/default/index']);
        }

        $searchModel = new PdsDikSuratSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams,$this->idJenisSurat,$idPdsDik);

        //$dataProvider = $searchModel->search2(Yii::$app->request->queryParams, $this->idJenisSurat,$this->$idPdsDik);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titleMain'=>$this->title,
        ]);
    }



    /**
     * Creates a new PdsDikSurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $idSurat=$this->getIdSurat();
        return $this->redirect(['update','id'=>$idSurat]);
    }


    public function getIdSurat(){
        $model= new PdsDikSurat();
        $model->id_pds_dik=$_SESSION['idPdsDik'];
        $model->id_jenis_surat=$this->idJenisSurat;
        $model->perihal_lap=$this->perihalSurat;
        $model->create_by=(string)Yii::$app->user->identity->username;
        $model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
        $model->save();
        $aPertanyaan[0]='Apakah sekarang Saudara dalam keadaan sehat jasmani dan rohani serta bersediakah Saudara memberikan keterangan yang benar?';
        $aPertanyaan[1]='Mengertikah Saudara mengapa Saudara dimintai keterangan ini?';
        $aPertanyaan[2]='dst';
        $aPertanyaan[3]='Apakah masih ada keterangan lain yang ingin Saudara tambahkan dalam pemberian keterangan ini?';
        $aPertanyaan[4]='Apabila Saudara masih diperlukan lagi keterangannya, apakah saudara bersedia datang memberikan keterangan?';
        $aPertanyaan[5]='Apakah semua keterangan yang Saudara berikan seperti diatas tersebut benar dan diberikan tanpa ada tekanan atau paksaan dalam memberikan keterangan tersebut diatas?';
        
        for($n=0;$n< count($aPertanyaan);$n++){
        	$modelKeterangan= new PdsDikSuratKeterangan();
        	$modelKeterangan->id_pds_dik_surat=$model->id_pds_dik_surat;
        	$modelKeterangan->no_urut=$n+1;
        	$modelKeterangan->pertanyaan=$aPertanyaan[$n];
        	$modelKeterangan->create_by=(string)Yii::$app->user->identity->username;
        	$modelKeterangan->save();
        }
        
        $modelSaksi=new PdsDikSaksi();
        $modelSaksi->id_pds_dik=$_SESSION['idPdsDik'];
        $modelSaksi->create_by=(string)Yii::$app->user->identity->username;
        $modelSaksi->save();
        //print_r($modelSaksi->getErrors());
        $modelSaksi= PdsDikSaksi::findBySql("select * from pidsus.pds_dik_saksi where id_pds_dik='".$_SESSION['idPdsDik']."' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
        $modelSuratSaksi= new PdsDikSuratSaksi();
        $modelSuratSaksi->id_pds_dik_surat=$model->id_pds_dik_surat;
        $modelSuratSaksi->no_urut=1;
        $modelSuratSaksi->id_saksi=$modelSaksi->id_pds_dik_saksi;
        $modelSuratSaksi->create_by=(string)Yii::$app->user->identity->username;
        $modelSuratSaksi->save();
        //print_r($modelSuratSaksi->getErrors());
        //die();
        return $model->id_pds_dik_surat;
    }
    /**
     * Updates an existing PdsDikSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(isset($_SESSION['idPdsDik'])){
            $idPdsDik=$_SESSION['idPdsDik'];
        }
        else if (isset($_SESSION['idPdsLid'])){
            $modelPdsDik=PdsDik::find()->where(['id_pds_lid_parent'=>$_SESSION['idPdsLid']])->one();
            $idPdsDik=$modelPdsDik->id_pds_dik;
        }
        else{
            return $this->redirect(['../pidsus/default/index']);
        }
        $_SESSION['idPdsDikSurat']=$id;

        $model = $this->findModel($id);
        $modelSuratSaksi=PdsDikSuratSaksi::find()->where(['id_pds_dik_surat'=>$id])->one();
        $modelSaksi=PdsDikSaksi::findOne($modelSuratSaksi->id_saksi);
        //print_r($modelSuratSaksi) ;
        //print_r($modelSaksi) ;
        //die();
        $modelTembusan= PdsDikTembusan::findBySql('select * from pidsus.select_surat_tembusan_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
        $modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
        $modelKeterangan=PdsDikSuratKeterangan::find()->where(['id_pds_dik_surat'=>$id])->orderby('no_urut')->all();
         
        $modelSuratJaksa=PdsDikSuratJaksa::find()->where(['id_pds_dik_surat'=>$model->id_pds_dik_surat])->all();
        $modelJaksa=KpPegawai::findBySql("select * from pidsus.get_jaksa_p8dik('".$model->id_pds_dik_surat."')")->all();
        $modelJaksaAll=KpPegawai::findBySql("select * from pidsus.get_jaksa_all('".$model->id_pds_dik_surat."')")->all();
        if(isset($_SESSION['cetak'])){
            $_SESSION['cetak']=null;
            $link = "<script>window.open(\"../../pidsus/default/viewreportdik?id=$model->id_pds_dik_surat\")</script>";
            echo $link;
        }
        if ($model->load(Yii::$app->request->post()) ) {


            //  untuk jpu

            echo $_POST['nip_jpu'];
            if(isset($_POST['nip_jpu'])){

                $nip_jpu=$_POST['nip_jpu'];
            }
            else $nip_jpu=null;

            if(isset($_POST['hapus_jpu'])){
                $hapus_jpu=$_POST['hapus_jpu'];
            }
            else $hapus_jpu=null;

            if ($hapus_jpu!=null){
                for($i = 0; $i < count($hapus_jpu); $i++){
                    PdsDikSuratJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_dik_surat'=>$model->id_pds_dik_surat]);
                }
            }

            if ($nip_jpu!=null){
                for($i = 0; $i < count($nip_jpu); $i++){

                    $modelJaksaSurat= new PdsDikSuratJaksa();
                    echo $modelJaksaSurat->id_pds_dik_surat_jaksa;
                    $modelJaksaSurat->create_by=(string)Yii::$app->user->identity->username;
                    $modelJaksaSurat->id_pds_dik_surat=$model->id_pds_dik_surat;
                    $modelJaksaSurat->id_jaksa=$nip_jpu[$i];
                    $modelJaksaSurat->save();
                }
            }

            // untuk jpu end


            //  untuk jaksa Saksi
            if(isset($_POST['pertanyaan'])){
            	for($i = 0; $i < count($_POST['pertanyaan']); $i++){
            		$modelInsertKeterangan= new PdsLidSuratKeterangan();
            		$modelInsertKeterangan->create_by=(string)Yii::$app->user->identity->username;
            		$modelInsertKeterangan->id_pds_lid_surat=$model->id_pds_lid_surat;
            		$modelInsertKeterangan->no_urut=$_POST['no_urut'][$i];
            		$modelInsertKeterangan->pertanyaan=$_POST['pertanyaan'][$i];
            		$modelInsertKeterangan->jawaban=$_POST['jawaban'][$i];
            		$modelInsertKeterangan->save();
            	}
            }
            	
            
            if(isset($_POST['hapus_ket'])){
            	for($i = 0; $i < count($_POST['hapus_ket']); $i++){
            		PdsLidSuratKeterangan::deleteAll(['id_pds_lid_surat_keterangan' => $_POST['hapus_ket'][$i]]);
            	}
            }

            // untuk jsks end




            if(PdsDikTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsDiktembusan::validateMultiple($modelTembusan)){
                $noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
                    $row->update_by=Yii::$app->user->identity->username;
                    $row->update_date=date('Y-m-d H:i:s');
                    $row->save();
                }
            }
            if(isset($_POST['new_tembusan'])){
                for($i = 0; $i < count($_POST['new_tembusan']); $i++){
                    $modelNewTembusan= new PdsDiktembusan();
                    $modelNewTembusan->id_pds_dik_surat=$model->id_pds_dik_surat;
                    $modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
                    $modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
                    $modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
                    $modelNewTembusan->save();
                }
            }
            if(PdsDikSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
                foreach($modelSuratIsi as $row){
                    $row->update_by=Yii::$app->user->identity->username;
                    $row->update_date=date('Y-m-d H:i:s');
                    $row->save();
                }
            }
            if(isset($_POST['hapus_tembusan'])){
                for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
                    PdsDiktembusan::deleteAll(['id_pds_dik_tembusan' => $_POST['hapus_tembusan'][$i]]);
                }
            }

            $model->update_by=(string)Yii::$app->user->identity->username;
            $model->update_date=date('Y-m-d H:i:s');$model->flag='1';

            $model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
            $model->save();
            if ($_POST['btnSubmit']=='simpan'){
                //return $this->redirect(['../pidsus/default/viewlaporandik','id'=>$idPdsDik]);
                return $this->redirect(['../pidsus/ba2']);
            }
            else {
                $_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreportdik', 'id'=>$model->id_pds_dik_surat]);
            }



            //return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelSuratIsi' => $modelSuratIsi,
                'modelTembusan'	 =>$modelTembusan,
                'modelJaksa' =>$modelJaksa,
                'modelJaksaAll' =>$modelJaksaAll,
                'modelSuratJaksa'=>$modelSuratJaksa,
                'modelKeterangan'=>$modelKeterangan,
            	'modelSaksi'=>$modelSaksi,		
                'readOnly' => false,
                'titleMain'=>$this->title,
            ]);
        }
    }

    /**
     * Deletes an existing PdsDikSurat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }






    protected function findModel($id)
    {
        if (($model = PdsDikSurat::find()->where(['id_pds_dik_surat'=>$id, 'id_jenis_surat'=>$this->idJenisSurat])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
