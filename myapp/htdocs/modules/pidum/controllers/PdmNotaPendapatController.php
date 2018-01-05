<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmNotaPendapat;
use app\modules\pidum\models\PdmNotaPendapatSearch;
use app\modules\pidum\models\PdmJaksaP16a;
use app\modules\pidum\models\PdmJaksaP16aSearch;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\MsTersangkaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * PdmNotaPendapatController implements the CRUD actions for PdmNotaPendapat model.
 */
class PdmNotaPendapatController extends Controller
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
     * Lists all PdmNotaPendapat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $searchModel    = new PdmNotaPendapatSearch();
        $dataProvider   = $searchModel->search($no_register,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmNotaPendapat model.
     * @param string $no_register_perkara
     * @param string $jenis_nota_pendapat
     * @param integer $id_nota_pendapat
     * @return mixed
     */
    public function actionView($no_register_perkara, $jenis_nota_pendapat, $id_nota_pendapat)
    {
        return $this->render('view', [
            'model' => $this->findModel($no_register_perkara, $jenis_nota_pendapat, $id_nota_pendapat),
        ]);
    }

    /**
     * Creates a new PdmNotaPendapat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $connection     = \Yii::$app->db;
        $qry_jns        = "select left(name,4) as jenis from menu where module = 'PIDUM' and tipe_menu = 'FLOW' and name like 'T%' and parent = '3496' order by id";
        $qry_jns_1      = $connection->createCommand($qry_jns);
        $modeljns       = $qry_jns_1->queryAll();
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register]);
        $searchJPU      = new PdmJaksaP16aSearch();
        $dataJPU        = $searchJPU->search2($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $model          = new PdmNotaPendapat();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //echo '<pre>';print_r($_POST);exit;
                $qry_count      = "select max(id_nota_pendapat) + 1 as total from pidum.pdm_nota_pendapat where no_register_perkara = '$no_register' ";
                $qry_count1     = $connection->createCommand($qry_count);
                $no_1           = $qry_count1->queryOne();
                if ($no_1['total'] == ''){
                    $qry_count2     = "select count(*) + 1 as total from pidum.pdm_nota_pendapat where no_register_perkara = '$no_register'";
                    $qry_count3     = $connection->createCommand($qry_count2);
                    $no_2           = $qry_count3->queryOne();
                }else{
                    $qry_count      = "select max(id_nota_pendapat) + 1 as total from pidum.pdm_nota_pendapat where no_register_perkara = '$no_register' ";
                    $qry_count1     = $connection->createCommand($qry_count);
                    $no_2           = $qry_count1->queryOne();
                }
                $model->id_nota_pendapat        = $no_2['total'];
                $model->id_kejati               = $kode_kejati;
                $model->id_kejari               = $kode_kejari;
                $model->id_cabjari              = $kode_cabjari;
                $model->no_register_perkara     = $no_register;
                $model->dari_nip_jaksa_p16a     = $_POST['PdmJaksaSaksi']['nip'];
                $model->dari_nama_jaksa_p16a    = $_POST['PdmJaksaSaksi']['nama'];
                $model->dari_jabatan_jaksa_p16a = $_POST['PdmJaksaSaksi']['jabatan'];
                $model->dari_pangkat_jaksa_p16a = $_POST['PdmJaksaSaksi']['pangkat'];
                $model->updated_by              = $session->get("nik_user"); 
                $model->updated_ip              = $_SERVER['REMOTE_ADDR'];
                $model->created_ip              = $_SERVER['REMOTE_ADDR'];
                $model->created_by              = $session->get("nik_user");
                $model->file_upload             = $_POST['PdmNotaPendapat']['file_upload'];
//                echo '<pre>'; print_r($model);exit();
                if ($model->save()) {
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

                    $transaction->commit();
                    return $this->redirect('index');
                }else{
                    var_dump($model->getErrors());exit;
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
                    return $this->redirect('create',[
                        'model'         => $model,
                        'modeljns'      => $modeljns,
                        'modeljaksi'    => $modeljaksi,
                        'searchJPU'     => $searchJPU,
                        'dataJPU'       => $dataJPU,
                    ]);
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
//                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('create',[
                    'model'         => $model,
                    'modeljns'      => $modeljns,
                    'modeljaksi'    => $modeljaksi,
                    'searchJPU'     => $searchJPU,
                    'dataJPU'       => $dataJPU,
                ]);
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'modeljns'      => $modeljns,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
            ]);
        }
    }

    /**
     * Updates an existing PdmNotaPendapat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $no_register_perkara
     * @param string $jenis_nota_pendapat
     * @param integer $id_nota_pendapat
     * @return mixed
     */
    public function actionUpdate($id_nota)
    {
//        echo $id_nota;exit();
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $connection     = \Yii::$app->db;
        $qry_jns        = "select left(name,4) as jenis from menu where module = 'PIDUM' and tipe_menu = 'FLOW' and name like 'T%' and parent = '3496' order by id";
        $qry_jns_1      = $connection->createCommand($qry_jns);
        $modeljns       = $qry_jns_1->queryAll();
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register]);
        $searchJPU      = new PdmJaksaP16aSearch();
        $dataJPU        = $searchJPU->search2($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $model          = PdmNotaPendapat::findOne(['no_register_perkara'=>$no_register, 'id_nota_pendapat'=>$id_nota]);
//        print_r($model);exit();

        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->dari_nip_jaksa_p16a     = $_POST['PdmJaksaSaksi']['nip'];
                $model->dari_nama_jaksa_p16a    = $_POST['PdmJaksaSaksi']['nama'];
                $model->dari_jabatan_jaksa_p16a = $_POST['PdmJaksaSaksi']['jabatan'];
                $model->dari_pangkat_jaksa_p16a = $_POST['PdmJaksaSaksi']['pangkat'];
//                echo '<pre>'; print_r($model);exit();
                if ($model->save()) {
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
                    $transaction->commit();
                }

                return $this->redirect('index');
                
                }catch (Exception $exc) {
                    echo $exc->getTraceAsString();
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
                        return $this->redirect('update',[
                            'model'         => $model,
                            'modeljns'      => $modeljns,
                            'modeljaksi'    => $modeljaksi,
                            'searchJPU'     => $searchJPU,
                            'dataJPU'       => $dataJPU,
                        ]);
                }

            
        } else {
            return $this->render('update', [
                'model'         => $model,
                'modeljns'      => $modeljns,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
            ]);
        }
    }

    /**
     * Deletes an existing PdmNotaPendapat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $no_register_perkara
     * @param string $jenis_nota_pendapat
     * @param integer $id_nota_pendapat
     * @return mixed
     */
    public function actionDelete(){
        //echo "string";

        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        //echo '<pre>';print_r($id_tahap);exit;

            if($id_tahap=='all'){
                    $id_tahapx=PdmNotaPendapat::find()->select("no_register_perkara,id_nota_pendapat")->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_register_perkara']."#".$value['id_nota_pendapat'];
                    }
                    $id_tahap=$arr;
                    
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }


        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    $split = explode("#",$delete);
                    PdmNotaPendapat::deleteAll(['no_register_perkara' => $split[0],'id_nota_pendapat'=>$split[1]]);
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
    
    public function actionCetak($id){
        $id_perpanjang  = rawurldecode($id);
        $connection     = \Yii::$app->db;
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $nota_pend      = PdmNotaPendapat::findOne(['id_nota_pendapat'=>$id_perpanjang]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $nota_pend->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        
        
        return $this->render('cetak', ['spdp'=>$spdp,'nota_pend'=>$nota_pend]);
    }

     public function actionReferTersangka() {
         $session = new Session();

        $no_register_perkara = $session->get('no_register_perkara');
        $searchModel = new MsTersangkaSearch();
        $dataProvider2 = $searchModel->searchTersangkaBa4New($no_register_perkara ,Yii::$app->request->queryParams);

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
     * Finds the PdmNotaPendapat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $no_register_perkara
     * @param string $jenis_nota_pendapat
     * @param integer $id_nota_pendapat
     * @return PdmNotaPendapat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_register_perkara, $jenis_nota_pendapat, $id_nota_pendapat)
    {
        if (($model = PdmNotaPendapat::findOne(['no_register_perkara' => $no_register_perkara, 'jenis_nota_pendapat' => $jenis_nota_pendapat, 'id_nota_pendapat' => $id_nota_pendapat])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
