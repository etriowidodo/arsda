<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsTut;
use app\modules\pidsus\models\PdsTutTembusan;
use app\modules\pidsus\models\PdsTutSuratforP24;
use app\modules\pidsus\models\PdsTutSurat;
use app\modules\pidsus\models\PdsTutSuratIsi;
use app\modules\pidsus\models\PdsTutSuratDetail;
use app\modules\pidsus\models\PdsTutSuratJaksa;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsTutJaksa;
use app\modules\pidsus\models\Pidsus2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsTut model.
 */
class P24Controller extends Controller
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
     * Lists all PdsTut models.
     * @return mixed

    public function actionIndex()
    {
    $searchModel = new Pidsus2Search();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    ]);
    }
     */
    /**
     * Displays a single PdsTut model.
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
     * Creates a new PdsTut model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdsTut();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pds_tut]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdsTut model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionIndex()
    {

        $idPdsTut=$_SESSION['idPdsTut'];
        $modelTut = $this->findModelTut($idPdsTut);
        $model = $this->findModel($idPdsTut,$modelTut,'p24');

        //  $model = PdsTutSurat::findOne($id);

        $modelTembusan= PdsTutTembusan::findBySql('select * from pidsus.select_surat_tembusan_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
        $modelSuratIsi= PdsTutSuratIsi::findBySql('select * from pidsus.select_surat_isi_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\')')->all();
        $countSuratDetailPertimbangan= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Pertimbangan\'')->queryScalar();
        $countSuratDetailUntuk= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Untuk\'')->queryScalar();
        $modelSuratDetail=PdstutSuratDetail::findBySql('select * from pidsus.select_surat_detail_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\')  order by no_urut,sub_no_urut')->all();

        $modelSuratJaksa=PdsTutSuratJaksa::find()->where(['id_pds_tut_surat'=>$model->id_pds_tut_surat])->all();
       // $modelJaksa=KpPegawai::findBySql("select * from kepegawaian.kp_pegawai where peg_instakhir ='".$_SESSION['idSatkerUser']."'")->all();
        $modelJaksa=KpPegawai::findBySql('select * from kepegawaian.kp_pegawai where peg_nik in (select id_jaksa from pidsus.pds_tut_jaksa where id_pds_tut= \''.$_SESSION['idPdsTut'].'\')')->all();

        if(isset($_SESSION['cetak'])){
            $_SESSION['cetak']=null;
            $link = "<script>window.open(\"../pidsus/tut/viewreport?id=$model->id_pds_tut_surat\")</script>";
            echo $link;
        }

        if ($model->load(Yii::$app->request->post()) ) {
            echo '<script language="javascript">';
            echo "alert(".$model->id_pds_tut_surat.")";
            echo '</script>';;//$modelTut->id_pds_tut;
            if(PdsTutSuratDetail::loadMultiple($modelSuratDetail, Yii::$app->request->post()) && PdsTutSuratDetail::validateMultiple($modelSuratDetail)){
                foreach($modelSuratDetail as $suratDetailRow){
                    $suratDetailRow->save();
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

            if(PdsTutTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsTutTembusan::validateMultiple($modelTembusan)){
                $noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
                    $row->update_by=Yii::$app->user->identity->username;
                    $row->update_date=date('Y-m-d H:i:s');
                    $row->save();
                }
            }
            if(PdsTutSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
                foreach($modelSuratIsi as $row){
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
            if(isset($_POST['hapus_tembusan'])){
                for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
                    PdsTuttembusan::deleteAll(['id_pds_tut_tembusan' => $_POST['hapus_tembusan'][$i]]);
                }
            }
            $model->update_by=(string)Yii::$app->user->identity->username;
            $model->update_date=date('Y-m-d H:i:s');$model->flag='1';
            $model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
            $model->save();
            //echo $model->id_status;
            $modelTut = $this->findModelTut($idPdsTut);
            $modelTut->update_by=(string)Yii::$app->user->identity->username;
            $modelTut->update_ip=(string)$_SERVER['REMOTE_ADDR'];
            $modelTut->update_date=date('Y-m-d H:i:s');$modelTut->flag='1';
            $modelTut->id_status=$model->id_status;
            $modelTut->save();
            if ($_POST['btnSubmit']=='simpan'){
                return $this->redirect(['../pidsus/tut/viewlaporantut','id'=>$idPdsTut]);
            }
            else {
                $_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreporttut', 'id'=>$model->id_pds_tut_surat]);
            }

        } else {

            return $this->render('update', [
                'model' => $model,
                'modelTut' => $modelTut,
                'modelSuratDetail' => $modelSuratDetail,
                'modelSuratIsi' => $modelSuratIsi,
                'modelTembusan'	 =>$modelTembusan,
                'modelJaksa' =>$modelJaksa,
                'modelSuratJaksa'=>$modelSuratJaksa,

                'readOnly' => false,
            ]);
        }
    }

    /**
     * Deletes an existing PdsTut model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdsTut model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsTut the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$modelTut,$jenisSurat)
    {
        if (($model = PdsTutSuratforP24::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_tut=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
            $model= new PdsTutSurat();
            $model->id_pds_tut=$id;
            $model->id_jenis_surat=$jenisSurat;
            $model->id_status=$modelTut->id_status;
            $model->create_by=(string)Yii::$app->user->identity->username;
            $model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
            $model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
            $model->perihal_lap='Pemberitahuan dan permintaan persetujuan lelang benda sitaan / barang bukti yang lekas rusak / membahayakan / biaya tinggi';
            $model->save();
            return $this->findModel($id,$modelTut,$jenisSurat);
        }
    }
    protected function findModelTut($id)
    {
        if (($modelTut = PdsTut::findOne($id)) !== null) {
            return $modelTut;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelTembusan($id)
    {
        return $model = PdsTutTembusan::find()->where('id_pds_tut_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
}
