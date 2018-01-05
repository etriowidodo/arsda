<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\VwTersangka;
use app\modules\pidum\models\PdmBa7;
use app\modules\pidum\models\pdmba7Search;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmRp9;
use app\modules\pidum\models\PdmRt3;
use app\modules\pidum\models\VwTerdakwa;
use app\models\KpPegawai;
use app\modules\pidum\models\MsTersangkaSearch;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use app\modules\pidum\models\PdmT7;
use app\modules\pidum\models\PdmT7Search;
use app\modules\pidum\models\PdmSysMenu;


/**
 * PdmBA10Controller implements the CRUD actions for PdmBA10 model.
 */
class PdmBa7Controller extends Controller {

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
     * Lists all PdmBA10 models.
     * @return mixed
     */
    public function actionIndex() 
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA7]);
        // echo 'hallo';exit;
        
        $searchModel = new pdmba7Search();
        $id_perkara             = Yii::$app->session->get('id_perkara');
        $no_register_perkara    = Yii::$app->session->get('no_register_perkara');
        $dataProvider = $searchModel->search($no_register_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
                    'sysMenu' => $sysMenu,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmBA10 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmBA10 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA7 ]); 
        $model = new PdmBa7();
        $id_perkara             = Yii::$app->session->get('id_perkara');
        $no_register_perkara    = Yii::$app->session->get('no_register_perkara');

        $modelT7 = new PdmT7();


 

        if ($model->load(Yii::$app->request->post())) {
            // echo '<pre>';
            // print_r($_POST);exit;
            $session = new Session();
            $model->created_by          = $session->get("nik_user"); 
            $model->updated_by          = $session->get("nik_user"); 
            $model->id_kejati           = $session->get("kode_kejati"); 
            $model->id_kejari           = $session->get("kode_kejari"); 
            $model->id_cabjari          = $session->get("kode_cabjari");
            $model->no_surat_t7         = $_POST['PdmBa7']['no_surat_t7'];
            $model->nama_tersangka_ba4  = $_POST['PdmBa7']['nama_tersangka_ba4'];
            $model->upload_file         = $_POST['PdmBa7']['upload_file'];
            $model->no_register_perkara = $no_register_perkara;

            $model->save();

            //set auto increment on PdmRt3
            // Yii::$app->globalfunc->autoIncrementRt3($model);

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
                'modelT7' => $modelT7,
                'sysMenu' => $sysMenu,
                'modelTerdakwa' => $modelTerdakwa
            ]);
        }
    }

    /**
     * Updates an existing PdmBA10 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
  

    public function actionUpdate($tgl_ba7,$no_reg) 
            {
        
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA7]);
        $session = new Session();
        
        $model = PdmBa7::findOne(['tgl_ba7'=>$tgl_ba7,'no_register_perkara'=>$no_reg]);
        $modelT7 = PdmT7::findOne(['no_register_perkara' => $model->no_register_perkara,'no_surat_t7'=>$model->no_surat_t7]);
		
	if ($modelT7 == null) {
            $modelT7 = new PdmT7();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->created_by          = $session->get("nik_user"); 
            $model->updated_by          = $session->get("nik_user"); 
            $model->id_kejati           = $session->get("kode_kejati"); 
            $model->id_kejari           = $session->get("kode_kejari"); 
            $model->id_cabjari          = $session->get("kode_cabjari");
            $model->no_surat_t7         = $_POST['PdmBa7']['no_surat_t7'];
            $model->nama_tersangka_ba4  = $_POST['PdmBa7']['nama_tersangka_ba4'];
            $model->upload_file         = $_POST['PdmBa7']['upload_file'];
            $model->no_register_perkara = $no_reg;

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
            return $this->redirect(['update','tgl_ba7'=>$model->tgl_ba7,'no_reg'=>$model->no_register_perkara]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'id' => $id,
                        'modelT7' => $modelT7,
                        'sysMenu' => $sysMenu,
                        'modelTerdakwa' => $modelTerdakwa
            ]);
        }
    }

    /**
     * Deletes an existing PdmBA10 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        // echo 'h';exit;
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];

            if($id_tahap=='all'){
                    $id_tahapx=PdmBa7::find()->select("no_register_perkara,tgl_ba7,no_surat_t7")->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_register_perkara']."#".$value['tgl_ba7']."#".$value['no_surat_t7'];
                    }
                    $id_tahap=$arr;
                    // echo '<pre>';
                    // print_r($id_tahap);exit;
            }else{
                $id_tahap = $_POST['hapusIndex'];
                 // print_r($id_tahap);exit;
            }

        //echo '<pre>';print_r($id_tahap);exit;
        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    $split = explode("#",$delete);
                    PdmBa7::deleteAll(['no_register_perkara' => $split[0],'tgl_ba7'=>$split[1],'no_surat_t7'=>$split[2]]);
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

    public function actionDataTersangka(){

        $id_tersangka = $_POST['id_tersangka'];
        if (empty($id_tersangka)) {
            $arr = array("status"=>0);
            echo json_encode($arr);
            exit();
        }else{
            $id_perkara = Yii::$app->session->get('id_perkara');
            $queryT7 = new Query();
            $modelT7 = $queryT7->select('a.lama, a.tgl_mulai, a.tgl_selesai, b.nama as jenis_penahanan, c.nama as tahanan')
                ->from('pidum.pdm_t7 a')
                ->innerJoin('pidum.pdm_ms_tindakan_status b on (a.tindakan_status=b.id)')
                ->innerJoin('pidum.ms_loktahanan c on (a.id_ms_loktahanan=c.id_loktahanan)')
                ->where(['a.id_perkara' => $id_perkara, 'a.id_tersangka' => $id_tersangka])->andWhere(['<>', 'a.flag', '3'])->one();
				
            if (empty($modelT7)) {
                $arr = array("status"=>0);
                echo json_encode($arr);
                exit();
            }else{
                echo json_encode($modelT7);
                exit();
            }
        }
    }

   public function actionCetak($no_register_perkara,$tgl_ba7) {

        $sqlBa7 = "Select * from pidum.pdm_ba7 where no_register_perkara ='".$no_register_perkara."' AND tgl_ba7 = '".$tgl_ba7."'";

        $modelBa7 = PdmBa7::findBySql($sqlBa7)->asArray()->one();

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
                        where a.no_register_perkara = '".$no_register_perkara."' AND a.no_surat_t7 = '".$modelBa7["no_surat_t7"]."'";
        $modelt7 = PdmT7::findBySql($sqlT7)->asArray()->one();

        $sqlUu = "select * from pidum.pdm_uu_pasal_tahap2 where no_register_perkara = '".$no_register_perkara."'";
        $modelUU = PdmT7::findBySql($sqlUu)->asArray()->All();

        $uu = "";
        if(count($modelUU)>0)
        {
           foreach($modelUU AS $key=>$val)
            {
                $uu .= $val['undang']." ".$val['pasal'].", ";
            }  
        }

        //echo '<pre>';print_r($uu);exit;
       
        // echo '<pre>';
        //  print_r($uu);
        // print_r($modelBa7);
        //  print_r($modelt7);
        // exit;
        
        return $this->render('cetak', ['model'=>$modelt7,'modelba7'=>$modelBa7,'varUU'=>$uu]);
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
     * Finds the PdmBA10 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBA10 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmBA10::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        }
    }

}
