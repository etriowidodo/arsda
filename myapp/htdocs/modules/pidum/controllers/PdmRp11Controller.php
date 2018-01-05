<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmRp11;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmTahapDuaSearch;
use app\modules\pidum\models\PdmRp11Search;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\components\GlobalConstMenuComponent;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
//use yii\data\ActiveDataProvider;
/**
 * PdmRp11Controller implements the CRUD actions for PdmRp11 model.
 */
class PdmRp11Controller extends Controller
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
     * Lists all PdmRp11 models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $session = new Session();
        $session->remove('no_eksekusi');
        $session->remove('id_berkas');
        $session->remove('id_perkara');
        $session->remove('no_reg_tahanan');
        $session->remove('no_akta');
        $session->remove('no_register_perkara');
        $searchModel = new PdmRp11Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::RP11 ]);
        //echo '<pre>';print_r($dataProvider->getTotalCount());exit;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmRp11 model.
     * @param string $no_register_perkara
     * @param string $no_akta
     * @param string $no_reg_tahanan
     * @return mixed
     */
    public function actionView($no_register_perkara, $no_akta, $no_reg_tahanan)
    {
        return $this->render('view', [
            'model' => $this->findModel($no_register_perkara, $no_akta, $no_reg_tahanan),
        ]);
    }

    /**
     * Creates a new PdmRp11 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmRp11();

        $searchModelBerkas = new PdmTahapDuaSearch();
        $dataProviderBerkas = $searchModelBerkas->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::RP11 ]);

        $session = new session();
        if ($model->load(Yii::$app->request->post())) {
             
            $transaction = Yii::$app->db->beginTransaction();
            try{
  
                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                  
                $model->id_kejati = $session->get('kode_kejati');
                $model->id_kejari = $session->get('kode_kejari');
                $model->id_cabjari = $session->get('kode_cabjari');
                
                $model->no_akta = $_POST['PdmRp11']['no_akta'];
                $id_berkas = PdmTahapDua::findOne(['no_register_perkara'=>$model->no_register_perkara])->id_berkas;
                $id_perkara = PdmBerkasTahap1::findOne(['id_berkas'=>$id_berkas])->id_perkara;
                $model->id_perkara = $id_perkara;
                
                if(!$model->save()){
                    var_dump($model->getErrors());exit;
                }else{
                    $transaction->commit();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil di Simpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['update','no_akta'=>$model->no_akta]);
                }
            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['create']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'searchModelBerkas' => $searchModelBerkas,
                'dataProviderBerkas' => $dataProviderBerkas,
                'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Updates an existing PdmRp11 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $no_register_perkara
     * @param string $no_akta
     * @param string $no_reg_tahanan
     * @return mixed
     */
    public function actionUpdate($no_akta)
    {
        $model = $this->findModel($no_akta);
        $searchModelBerkas = new PdmTahapDuaSearch();
        $dataProviderBerkas = $searchModelBerkas->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::RP11 ]);

        $session = new Session();
        $session->destroySession('id_perkara');
        $session->destroySession('no_register_perkara');
        $session->destroySession('no_akta');
        $session->destroySession('no_reg_tahanan');
        

        $session->set('id_perkara', $model->id_perkara);
        $session->set('no_register_perkara', $model->no_register_perkara);
        $session->set('no_akta', $no_akta);
        $session->set('no_reg_tahanan',$model->no_reg_tahanan);

        //echo '<pre>';print_r($_SESSION);exit;
        if ($model->load(Yii::$app->request->post())) {
             //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $stat = $_POST['PdmRp11']['id_status_yakum'];
                if($stat=='1'){
                    $model->no_permohonan_kasasi = NULL;
                    $model->tgl_permohonan_kasasi = NULL;
                }
                $model->id_kejati = $session->get('kode_kejati');
                $model->id_kejari = $session->get('kode_kejari');
                $model->id_cabjari = $session->get('kode_cabjari');
                $model->no_akta = trim($_POST['PdmRp11']['no_akta']);
                $id_berkas = PdmTahapDua::findOne(['no_register_perkara'=>$model->no_register_perkara])->id_berkas;
                $id_perkara = PdmBerkasTahap1::findOne(['id_berkas'=>$id_berkas])->id_perkara;
                $model->id_perkara = $id_perkara;
                if(!$model->update()){
                    var_dump($model->getErrors());exit;
                }else{
                    $transaction->commit();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil di Ubah',
                        'title' => 'Simpan Data',
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['index']);
                }
            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['create']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'searchModelBerkas' => $searchModelBerkas,
                'dataProviderBerkas' => $dataProviderBerkas,
                'sysMenu' => $sysMenu,
                
            ]);
        }
    }

    /**
     * Deletes an existing PdmRp11 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $no_register_perkara
     * @param string $no_akta
     * @param string $no_reg_tahanan
     * @return mixed
     */
    public function actionDelete()
    {
        $arr= array();
        //$id_tahap = $_POST['hapusIndex'][0];
        //echo '<pre>';print_r($_POST);exit;
            if($id_tahap=='all'){
              $id_tahapx=PdmRp11::find()->select("no_register_perkara,no_akta,id_status_yakum,no_reg_tahanan")->asArray()->all();
              foreach ($id_tahapx as $key => $value) {
                  $arr[] = $value['no_register_perkara']."#".$value['no_akta']."#".$value['id_status_yakum']."#".$value['no_reg_tahanan'];
              }
              $id_tahap=$arr; 
            }else{
              $id_tahap = $_POST['hapusIndex'];
            }

          $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    $split = explode("#",$delete);

                    PdmRp11::deleteAll(['no_register_perkara' => $split[0],'no_akta'=>$split[1], 'id_status_yakum'=>$split[2],'no_reg_tahanan'=>$split[3]]);
                    //echo '<pre>';print_r($split[2]);
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

    /**
     * Finds the PdmRp11 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $no_register_perkara
     * @param string $no_akta
     * @param string $no_reg_tahanan
     * @return PdmRp11 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionGetTerdakwa()
    {
        $no_register_perkara = $_POST['no_register_perkara'];
       $terdakwa = VwTerdakwaT2::find()->select('no_reg_tahanan, nama')->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
        //echo '<pre>';print_r($terdakwa);exit;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $terdakwa;
    }

    protected function findModel($no_akta)
    {
        if (($model = PdmRp11::findOne(['no_akta' => $no_akta])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
