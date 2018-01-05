<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\PdsDikSuratforT3;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratDetail;
use app\modules\pidsus\models\PdsDikSuratTersangka;
use app\modules\pidsus\models\PdsDikTersangka;
use app\modules\pidsus\models\PdsDikTersangkaSearch;
use app\modules\pidsus\models\PdsDikSuratSearch;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\PdsDikSuratJaksa;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsDikJaksa;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Pidsus18Controller implements the CRUD actions for PdsDikSurat model.
 */
class T3Controller extends Controller
{
    public $idJenisSurat='t3';
    public $perihalSurat='Permintaan Perpanjangan Penahanan';
    public $title='T3 - Permintaan Perpanjangan Penahanan';
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
			'idJenisSurat' => $this->idJenisSurat,
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
        $modelTembusan= PdsDikTembusan::findBySql('select * from pidsus.select_surat_tembusan_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
        $modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
        $countSuratDetailSuratReferensi= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'SuratReferensi\'')->queryScalar();


        $modelSuratDetail=PdsdikSuratDetail::findBySql('select * from pidsus.select_surat_detail_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')  order by no_urut,sub_no_urut')->all();

        $modelSuratJaksa=PdsDikSuratJaksa::find()->where(['id_pds_dik_surat'=>$model->id_pds_dik_surat])->all();
        $modelJaksa=KpPegawai::findBySql("select * from pidsus.get_jaksa_p8dik('".$model->id_pds_dik_surat."')")->all();


        if(isset($_SESSION['cetak'])){
            $_SESSION['cetak']=null;
            $link = "<script>window.open(\"../../pidsus/default/viewreportdik?id=$model->id_pds_dik_surat\")</script>";
            echo $link;
        }
        if ($model->load(Yii::$app->request->post()) ) {

            if(PdsDikSuratDetail::loadMultiple($modelSuratDetail, Yii::$app->request->post()) && PdsDikSuratDetail::validateMultiple($modelSuratDetail)){
                foreach($modelSuratDetail as $suratDetailRow){
                    $suratDetailRow->save();
                }
            }

            if(isset($_POST['modelDetailSuratReferensi'])){
                $modelDetailSuratReferensi= $_POST['modelDetailSuratReferensi'];
            }
            else $modelDetailSuratReferensi=null;

            if($modelDetailSuratReferensi!=null){
                for ($i = 0; $i < count($modelDetailSuratReferensi); $i++) {
                    $countSuratDetailSuratReferensi++;
                    $modelDetailNew= new PdsDikSuratDetail();
                    $modelDetailNew->id_pds_dik_surat=$model->id_pds_dik_surat;
                    $modelDetailNew->no_urut=1;
                    $modelDetailNew->sub_no_urut=$countSuratDetailSuratReferensi;
                    $modelDetailNew->tipe_surat_detail='SuratReferensi';
                    $modelDetailNew->isi_surat_detail=$modelDetailSuratReferensi[$i];
                    $modelDetailNew->save();

                }
            }

            if(isset($_POST['hapus_detail'])){
                for($i = 0; $i < count($_POST['hapus_detail']); $i++){
                    PdsdikSuratDetail::deleteAll(['id_pds_dik_surat_detail' => $_POST['hapus_detail'][$i]]);
                }
            }

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
                return $this->redirect(['../pidsus/t3']);
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
                'modelSuratJaksa'=>$modelSuratJaksa,
                'modelSuratDetail' => $modelSuratDetail,
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
        if (($model = PdsDikSuratforT3::find()->where(['id_pds_dik_surat'=>$id, 'id_jenis_surat'=>$this->idJenisSurat])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
