<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsTut;
use app\modules\pidsus\models\PdsTutTembusan;
use app\modules\pidsus\models\PdsTutSurat;
use app\modules\pidsus\models\PdsTutSuratforBA19;


use app\modules\pidsus\models\PdsTutSuratSearch;
use app\modules\pidsus\models\PdsTutSuratIsi;
use app\modules\pidsus\models\PdsTutSuratJaksa;
use app\modules\pidsus\models\PdsTutSuratJaksaSaksi;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsTutJaksa;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Pidsus18Controller implements the CRUD actions for PdsTutSurat model.
 */
class Ba19Controller extends Controller
{
    public $idJenisSurat='ba19';
    public $perihalSurat='Berita Acara Pelaksanaan Putusan Perampasan';
    public $title='BA-19 Berita Acara Pelaksanaan Putusan Perampasan';
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
     * Lists all PdsTutSurat models.
     * @return mixed
     */
    public function actionIndex()
    {

        if(isset($_SESSION['idPdsTut'])){
            $idPdsTut=$_SESSION['idPdsTut'];
        }
        else if (isset($_SESSION['idPdsDik'])){
           $modelPdsTut=PdsTut::find()->where(['id_pds_tut_parent'=>$_SESSION['idPdsTut']])->one();
            $idPdsTut=$modelPdsTut->id_pds_tut;
        }
        else{
            return $this->redirect(['../pidsus/default/index']);
        }

        $searchModel = new PdsTutSuratSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams,$this->idJenisSurat,$idPdsTut);

        //$dataProvider = $searchModel->search2(Yii::$app->request->queryParams, $this->idJenisSurat,$this->$idPdsTut);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'idJenisSurat' => $this->idJenisSurat,	
            'titleMain'=>$this->title,
        ]);
    }



    /**
     * Creates a new PdsTutSurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $idSurat=$this->getIdSurat();
        return $this->redirect(['update','id'=>$idSurat]);
    }


    public function getIdSurat(){
        $model= new PdsTutSurat();
        $model->id_pds_tut=$_SESSION['idPdsTut'];
        $model->id_jenis_surat=$this->idJenisSurat;
        $model->perihal_lap=$this->perihalSurat;
        $model->create_by=(string)Yii::$app->user->identity->username;
        $model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
        $model->save();


        return $model->id_pds_tut_surat;
    }
    /**
     * Updates an existing PdsTutSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(isset($_SESSION['idPdsTut'])){
            $idPdsTut=$_SESSION['idPdsTut'];
        }
        else if (isset($_SESSION['idPdsDik'])){
           $modelPdsTut=PdsTut::find()->where(['id_pds_dik_parent'=>$_SESSION['idPdsDik']])->one();
            $idPdsTut=$modelPdsTut->id_pds_tut;
        }
        else{
            return $this->redirect(['../pidsus/default/index']);
        }
        $_SESSION['idPdsTutSurat']=$id;

        $model = $this->findModel($id);
        $modelTembusan= PdsTutTembusan::findBySql('select * from pidsus.select_surat_tembusan_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
        $modelSuratIsi= PdsTutSuratIsi::findBySql('select * from pidsus.select_surat_isi_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\')')->all();

        $modelSuratJaksa=PdsTutSuratJaksa::find()->where(['id_pds_tut_surat'=>$model->id_pds_tut_surat])->all();
        $modelJaksa=KpPegawai::findBySql("select * from pidsus.get_jaksa_p16('".$model->id_pds_tut_surat."')")->all();
        $modelJaksaAll=KpPegawai::findBySql("select * from pidsus.get_jaksa_all('".$model->id_pds_tut_surat."')")->all();
        $modelSuratJaksaSaksi=PdsTutSuratJaksaSaksi::find()->where(['id_pds_tut_surat'=>$model->id_pds_tut_surat])->all();
        if(isset($_SESSION['cetak'])){
            $_SESSION['cetak']=null;
            $link = "<script>window.open(\"../../pidsus/tut/viewreporttut?id=$model->id_pds_tut_surat\")</script>";
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
                    PdsTutSuratJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_tut_surat'=>$model->id_pds_tut_surat]);
                }
            }

            if ($nip_jpu!=null){
                for($i = 0; $i < count($nip_jpu); $i++){

                    $modelJaksaSurat= new PdsTutSuratJaksa();
                    echo $modelJaksaSurat->id_pds_tut_surat_jaksa;
                    $modelJaksaSurat->create_by=(string)Yii::$app->user->identity->username;
                    $modelJaksaSurat->id_pds_tut_surat=$model->id_pds_tut_surat;
                    $modelJaksaSurat->id_jaksa=$nip_jpu[$i];
                    $modelJaksaSurat->save();
                }
            }

            // untuk jpu end


            //  untuk jaksa Saksi

            echo $_POST['nip_jsks'];
            if(isset($_POST['nip_jsks'])){

                $nip_jsks=$_POST['nip_jsks'];
            }
            else $nip_jsks=null;

            if(isset($_POST['hapus_jsks'])){
                $hapus_jsks=$_POST['hapus_jsks'];
            }
            else $hapus_jsks=null;

            if ($hapus_jsks!=null){
                for($i = 0; $i < count($hapus_jsks); $i++){
                    PdsTutSuratJaksaSaksi::deleteAll(['id_jaksa' => $hapus_jsks[$i], 'id_pds_tut_surat'=>$model->id_pds_tut_surat]);
                }
            }

            if ($nip_jsks!=null){
                for($i = 0; $i < count($nip_jsks); $i++){

                   $modelJaksaSuratSaksi= new PdsTutSuratJaksaSaksi();
                    echo $modelJaksaSuratSaksi->id_pds_tut_surat_jaksa_saksi;
                    $modelJaksaSuratSaksi->create_by=(string)Yii::$app->user->identity->username;
                    $modelJaksaSuratSaksi->id_pds_tut_surat=$model->id_pds_tut_surat;
                    $modelJaksaSuratSaksi->id_jaksa=$nip_jsks[$i];
                    $modelJaksaSuratSaksi->save();

                }
            }

            // untuk jsks end




            if(PdsTutTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsTuttembusan::validateMultiple($modelTembusan)){
                $noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
                    $row->update_by=Yii::$app->user->identity->username;
                    $row->update_date=date('Y-m-d H:i:s');
                    $row->save();
                }
            }
            if(isset($_POST['new_tembusan'])){
                for($i = 0; $i < count($_POST['new_tembusan']); $i++){
                    $modelNewTembusan= new PdsTuttembusan();
                    $modelNewTembusan->id_pds_tut_surat=$model->id_pds_tut_surat;
                    $modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
                    $modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
                    $modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
                    $modelNewTembusan->save();
                }
            }
            if(PdsTutSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
                foreach($modelSuratIsi as $row){
                    $row->update_by=Yii::$app->user->identity->username;
                    $row->update_date=date('Y-m-d H:i:s');
                    $row->save();
                }
            }
            if(isset($_POST['hapus_tembusan'])){
                for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
                    PdsTuttembusan::deleteAll(['id_pds_tut_tembusan' => $_POST['hapus_tembusan'][$i]]);
                }
            }

            $model->update_by=(string)Yii::$app->user->identity->username;
            $model->update_date=date('Y-m-d H:i:s');$model->flag='1';

            $model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
            $model->save();
            if ($_POST['btnSubmit']=='simpan'){
                //return $this->redirect(['../pidsus/tut/viewlaporantut','id'=>$idPdsTut]);
                return $this->redirect(['../pidsus/ba19']);
            }
            else {
                $_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/tut/viewreporttut', 'id'=>$model->id_pds_tut_surat]);
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
                'modelSuratJaksaSaksi'=>$modelSuratJaksaSaksi,
                'readOnly' => false,
                'titleMain'=>$this->title,
            ]);
        }
    }

    /**
     * Deletes an existing PdsTutSurat model.
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
        if (($model = PdsTutSuratforBA19::find()->where(['id_pds_tut_surat'=>$id, 'id_jenis_surat'=>$this->idJenisSurat])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
