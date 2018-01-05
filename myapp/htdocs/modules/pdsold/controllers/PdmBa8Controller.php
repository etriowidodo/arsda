<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\models\KpInstSatker;
use app\models\KpPegawaiSearch;
use app\modules\pdsold\models\PdmBa8;
use app\modules\pdsold\models\MsLoktahanan;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\PdmBA8Search;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\VwTerdakwa;
use app\modules\pdsold\models\PdmRp9;
use app\modules\pdsold\models\PdmRt3;
use app\modules\pdsold\models\MsTersangkaSearch;
use app\modules\pdsold\models\PdmT7;
use app\modules\pdsold\models\PdmT7Search;
use app\modules\pdsold\models\PdmJaksaP16a;
use Odf;
use Yii;
use app\models\KpPegawai;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\web\UploadedFile;

/**
 * PdmBA11Controller implements the CRUD actions for PdmBA11 model.
 */
class PdmBa8Controller extends Controller {

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
     * Lists all PdmBA11 models.
     * @return mixed
     */
    public function actionIndex()
      {
         $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA8]);
         
        $searchModel = new PdmBA8Search();
        $id_perkara = Yii::$app->session->get('id_perkara');
        $dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
                    'sysMenu' => $sysMenu,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmBA11 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmBA11 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA8]);
        $session = new Session();

        $id                     = $session->get('id_perkara');
        $no_register_perkara    = $session->get('no_register_perkara');
         $model = new PdmBa8();


        if ($model->load(Yii::$app->request->post())) {
            // echo '<pre>';
            // print_r($_POST);exit;
            $model->created_by          = $session->get("nik_user"); 
            $model->updated_by          = $session->get("nik_user"); 
            $model->id_kejati           = $session->get("kode_kejati"); 
            $model->id_kejari           = $session->get("kode_kejari"); 
            $model->id_cabjari          = $session->get("kode_cabjari");
            $model->no_surat_t7         = $_POST['PdmBa8']['no_surat_t7'];
            $model->upload_file         = $_POST['PdmBa8']['upload_file'];
            $model->no_register_perkara = $no_register_perkara;
            $model->save();

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
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'id' => $id,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'searchSatker' => $searchSatker,
                        'dataSatker' => $dataSatker,
                        'modeljaksi' => $modeljaksi,
                        'kepalajaksal' => $kepalajaksal,
                        'sysMenu' => $sysMenu,
                        'modelRp9'=>$modelRp9,
                         'modelRt3'=>$modelRt3,
                                ]);
        }
   
    }
    

    /**
     * Updates an existing PdmBA11 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdatedata($id) {


        $session = new Session();
        $session->destroySession('id_penuntutan');
        $session->set('id_penuntutan', $id);
        return $this->redirect('update');
    }

    public function actionUpdate($no_register_perkara,$tgl_ba8) {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA8]);
        $session = new Session();

        $id                     = $session->get('id_perkara');
        $no_register_perkara    = $session->get('no_register_perkara');
        $model = PdmBa8::findOne(['no_register_perkara'=>$no_register_perkara,'tgl_ba8'=>$tgl_ba8]);
              
        

        if ($model->load(Yii::$app->request->post())) {

            $model->created_by          = $session->get("nik_user"); 
            $model->updated_by          = $session->get("nik_user"); 
            $model->id_kejati           = $session->get("kode_kejati"); 
            $model->id_kejari           = $session->get("kode_kejari"); 
            $model->id_cabjari          = $session->get("kode_cabjari");
            $model->no_surat_t7         = $_POST['PdmBa8']['no_surat_t7'];
            $model->upload_file         = $_POST['PdmBa8']['upload_file'];
            $model->no_register_perkara = $no_register_perkara;
             $model->save();
        
//notifikasi simpan
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
            return $this->redirect(['update', 'no_register_perkara' => $model->no_register_perkara,'tgl_ba8'=>$model->tgl_ba8]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'id' => $id,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'searchSatker' => $searchSatker,
                        'dataSatker' => $dataSatker,
                        'modeljaksi' => $modeljaksi,
                        'kepalajaksal' => $kepalajaksal,
                        'sysMenu' => $sysMenu,
                        'modelRp9'=>$modelRp9,
                        'modelRt3'=>$modelRt3,
                                ]);
        }
    }

    /**
     * Deletes an existing PdmBA11 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        // echo 'h';exit;
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];

            if($id_tahap=='all'){
                    $id_tahapx=PdmBa8::find()->select("no_register_perkara,tgl_ba7")->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_register_perkara']."_".$value['tgl_ba7'];
                    }
                    $id_tahap=$arr;
                    // echo '<pre>';
                    // print_r($id_tahap);exit;
            }else{
                $id_tahap = $_POST['hapusIndex'];
                 // print_r($id_tahap);exit;
            }


        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    $split = explode("_",$delete);
                    PdmBa8::deleteAll(['no_register_perkara' => $split[0],'tgl_ba8'=>$split[1]]);
                }catch (\yii\db\Exception $e) {
                  $count++;
                }
            }
            if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  $count.' Data Berkas Tidak Dapat Dihapus Karena Sudah Digunakan Di Persuratan Lainnya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }

            return $this->redirect(['index']);
    }
  
    public function actionReferTersangka() {
         $session = new Session();

        $no_register_perkara = $session->get('no_register_perkara');
        $searchModel = new MsTersangkaSearch();
        $dataProvider2 = $searchModel->searchTersangkaT7($no_register_perkara ,Yii::$app->request->queryParams);

        //var_dump ($dataProvider2);exit;
        //echo $dataProvider['id_tersangka'];exit;
        //$dataProvider->pagination->pageSize = 5;
        $dataProvider2->pagination->pageSize = 5;
        return $this->renderAjax('_tersangka', [
                    'searchModel'   => $searchModel,
                    'dataProvider2' => $dataProvider2,
        ]);
    }
    /**
     * Finds the PdmBA11 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBA11 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmBa11::findOne(['id_ba11' => $id])) !== null) {
            return $model;
      }
    }

    public function actionJpu() {
        $searchModel = new KpPegawaiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('_jpu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCetak($no_register_perkara,$tgl_ba8) {

        $sqlBa8 = "Select * from pidum.pdm_ba8 where no_register_perkara ='".$no_register_perkara."' AND tgl_ba8 = '".$tgl_ba8."'";

        $modelBa8 = PdmBa8::findBySql($sqlBa8)->asArray()->one();
        // echo '<pre>';
        // print_r($modelBa8);exit;

      $sqlT7 = "select a.*,d.no_berkas,d.tgl_berkas,b.kasus_posisi,c.no_reg_tahanan,e.nama as loktahanan,
                    f.jabatan as jabatan_jaksa, f.pangkat as pangkat_jaksa, f.nip As nip_jaksa ,c.*,
                        g.nama as warganegara,
                        h.nama as identitas,
                        i.nama as jkl,
                        j.nama as agama,
                        k.nama as pendidikan,
                        a.nama as nama_ttd_t7,
                        a.pangkat as pangkat_ttd_t7,
                        a.jabatan as jabatan_ttd_t7,
                        a.id_penandatangan as nip_ttd_t7,l.nama as ur_tindakan_status
                    from pidum.pdm_t7 a 
                    left join pidum.pdm_tahap_dua b on a.no_register_perkara = b.no_register_perkara
                    left join pidum.pdm_ba4_tersangka c on a.no_register_perkara = c.no_register_perkara 
                        AND a.tgl_ba4 = c.tgl_ba4 
                        AND a.no_urut_tersangka = c.no_urut_tersangka
                                left join public.ms_warganegara g on c.warganegara = g.id 
                                left join public.ms_identitas h on c.id_identitas = h.id_identitas 
                                left join public.ms_jkl i on c.id_jkl = i.id_jkl 
                                left join public.ms_agama j on c.id_agama = j.id_agama
                                left join public.ms_pendidikan k on c.id_pendidikan = k.id_pendidikan
                    left join pidum.pdm_berkas_tahap1 d on b.id_berkas = d.id_berkas                         
                    left join pidum.ms_loktahanan e on a.id_ms_loktahanan = e.id_loktahanan
                    left join pidum.pdm_jaksa_p16a f on a.no_register_perkara = f.no_register_perkara 
                        And a.no_surat_p16a = f.no_surat_p16a and a.no_jaksa_p16a = f.no_urut
                    left join pidum.pdm_ms_tindakan_status l on a.tindakan_status = l.id
                        where a.no_register_perkara = '".$no_register_perkara."' AND a.no_surat_t7 = '".$modelBa8["no_surat_t7"]."'";
        $modelt7 = PdmT7::findBySql($sqlT7)->asArray()->one();
        $no_p16a = Yii::$app->globalfunc->GetLastP16a()->no_surat_p16a;
        $sqlJaksa = " Select * from pidum.pdm_jaksa_p16a where no_register_perkara = '".$no_register_perkara."' AND no_surat_p16a = '".$no_p16a."' ";
        $modelJaksa = PdmJaksaP16a::findBySql($sqlJaksa)->asArray()->one();
        //  echo '<pre>';
        // print_r($modelJaksa);exit;
        $sqlUu = "select * from pidum.pdm_uu_pasal_tahap2 where no_register_perkara = '".$no_register_perkara."'";
        $modelUU = PdmT7::findBySql($sqlUu)->asArray()->All();
        //    echo '<pre>';
        // print_r($modelUU);exit;
        $uu = "";
        if(count($modelUU)>0)
        {
           foreach($modelUU AS $key=>$val)
            {
                $uu .= $val['undang']." ".$val['pasal'].", ";
            }  
        }
       
        // echo '<pre>';
        //  print_r($uu);
        // print_r($modelBa7);
        //  print_r($modelt7);
        // exit;
        
        return $this->render('cetak', ['model'=>$modelt7,'modelba8'=>$modelBa8,'varUU'=>$uu,'modelJaksa'=>$modelJaksa]);
    }

}
