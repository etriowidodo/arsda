<?php

namespace app\modules\pdsold\controllers;

use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmP13;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\PdmTembusanP26;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\PdmJaksaP16aSearch;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\MsPenyidik;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmMsAlasanP26;
use Yii;
use app\modules\pdsold\models\PdmP26;
use app\modules\pdsold\models\PdmP26Search;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\Models\MsJkl;
use app\Models\MsAgama;
use app\Models\MsWarganegara;
use app\Models\MsPendidikan;
use app\modules\pdsold\models\MsTersangka;
use app\components\GlobalConstMenuComponent;
use yii\web\Session;

/**
 * PdmP26Controller implements the CRUD actions for PdmP26 model.
 */
class PdmP26Controller extends Controller
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
     * Lists all PdmP26 models.
     * @return mixed
     */
    public function actionIndex()
    {
//        return $this->redirect('update');
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $searchModel    = new PdmP26Search();
        $dataProvider   = $searchModel->search($no_register,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmP26 model.
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
     * Updates an existing PdmP26 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    
    public function actionCreate()
    {
        $session        = new Session();
        $id             = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = new PdmP26();
        $modelJpu       = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register]);
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register]);
        $searchJPU      = new PdmJaksaP16aSearch();
        $dataJPU        = $searchJPU->search2($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;


        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
//                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p26', 'id_p26', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                $model->no_register_perkara = $no_register;
                $model->no_surat_p16a       = $_POST['PdmJaksaSaksi']['no_surat_p16a'];
                $model->no_urut_jaksa_p16a  = $_POST['PdmJaksaSaksi']['no_urut'];
                $model->alasan              = $_POST['alasan'];
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user"); 
                $model->save();
                
                if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP26::deleteAll(['no_surat_p26' => $model->no_surat_p26]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan   = new PdmTembusanP26();
                            $modelNewTembusan->no_surat_p26        = $model->no_surat_p26;
                            $modelNewTembusan->no_register_perkara  = $model->no_register_perkara;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }

                $transaction->commit();

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

                return $this->redirect('index');

            } catch(Exception $e) {
                echo '<pre>';print_r($e);exit();
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Disimpan', // String
                    'title' => 'Save', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect('create');
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'modelJpu'      => $modelJpu,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
                'no_register'   => $no_register,
            ]);
        }
    }
    
    
    public function actionUpdate($no_surat_p26)
    {
        $session        = new Session();
        $id             = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $model          = PdmP26::findOne(['no_surat_p26'=>$no_surat_p26]);
        $modelJpu       = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register]);
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register,'no_surat_p16a'=>$model->no_surat_p16a,'no_urut'=>$model->no_urut_jaksa_p16a]);
        $searchJPU      = new PdmJaksaP16aSearch();
        $dataJPU        = $searchJPU->search2($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
//                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p26', 'id_p26', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                if($_POST['PdmJaksaSaksi']['no_surat_p16a'] != ''){
                    $model->no_surat_p16a       = $_POST['PdmJaksaSaksi']['no_surat_p16a'];
                    $model->no_urut_jaksa_p16a  = $_POST['PdmJaksaSaksi']['no_urut'];
                }else{
                    
                }
                $model->no_register_perkara = $no_register;
                $model->alasan              = $_POST['alasan'];
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user"); 
//                echo '<pre>';print_r($model);exit();
                $model->save();

                if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP26::deleteAll(['no_surat_p26' => $model->no_surat_p26]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan   = new PdmTembusanP26();
                            $modelNewTembusan->no_surat_p26        = $model->no_surat_p26;
                            $modelNewTembusan->no_register_perkara  = $model->no_register_perkara;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }

                $transaction->commit();

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

                return $this->redirect('index');

            } catch(Exception $e) {
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Disimpan', // String
                    'title' => 'Save', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect('update');
            }
        } else {
            return $this->render('update', [
                'model'         => $model,
                'modelJpu'      => $modelJpu,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
                'no_register'   => $no_register,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP26 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id                     = $_POST['hapusIndex'];
        $total                  = count($id);
        $session                = new Session();
        $id_perkara             = $session->get('id_perkara');
        $no_register_perkara    = $session->get('no_register_perkara');
        $connection             = \Yii::$app->db;
        try {
            if($total <= 1){ 
                Yii::$app->db->createCommand()
                ->delete('pidum.pdm_p26', ['no_surat_p26' => $id[0]])
                ->execute();
            }else{
                if($id == "all"){
                    Yii::$app->db->createCommand()
                    ->delete('pidum.pdm_p26', ['no_surat_p26' => $id])
                    ->execute();
                }else{
                   for ($i = 0; $i < count($id); $i++) {
                       Yii::$app->db->createCommand()
                       ->delete('pidum.pdm_p26', ['no_surat_p26' => $id[$i]])
                       ->execute();
                    }
                }
            }
            
            
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
            return $this->redirect(['index']);
        } catch (Exception $e) {
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 3000,
                'icon' => 'fa fa-users',
                'message' => 'Data Gagal di Hapus',
                'title' => 'Hapus Data',
                'positonY' => 'top',
                'positonX' => 'center',
                'showProgressbar' => true,
            ]);
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the PdmP26 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP26 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP26::findOne(['no_surat_p26' => $id])) !== null) {
            return $model;
        }
    }

    protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne(['id_perkara' => $id])) !== null) {
            return $modelSpdp;
        }
    }
    
    public function actionCetak($id) {
        $id1            = rawurldecode($id);
        $p26            = PdmP26::findOne(['no_surat_p26' => $id1]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p26->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $penyidik       = MsPenyidik::findOne(['id_penyidik' => $spdp->id_penyidik]);
        $jaksa          = PdmJaksaP16a::findOne(['no_surat_p16a' => $p26->no_surat_p16a,'no_urut' => $p26->no_urut_jaksa_p16a]);
        $tersangka      = VwTerdakwaT2::findOne(['no_register_perkara' => $p26->no_register_perkara,'no_urut_tersangka' => $p26->id_tersangka]);
        $alasan         = PdmMsAlasanP26::findOne(['id' => $p26->alasan]);
        $listTembusan   = PdmTembusanP26::findAll(['no_surat_p26' => $p26->no_surat_p26]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $p26->id_penandatangan]);
//        echo '<pre>';print_r($tersangka);exit();
        
        return $this->render('cetak', ['spdp'=>$spdp,'p26'=>$p26,'penyidik'=>$penyidik,'jaksa'=>$jaksa,'tersangka'=>$tersangka,'alasan'=>$alasan,'listTembusan'=>$listTembusan,'pangkat'=>$pangkat]);
    }
    
}
