<?php

namespace app\modules\pidum\controllers;
use Yii;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\MsLoktahanan;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\PdmP31;
use app\modules\pidum\models\PdmBa5;

use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusanP31;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\pdmP31Search;
use yii\db\Exception;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmP31Controller implements the CRUD actions for PdmP31 model.
 */
class PdmP31Controller extends Controller
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
     * Lists all PdmP31 models.
     * @return mixed
     */
    public function actionIndex()
    {
        // no need index page so redirect to update
        return $this->redirect(['update']);
        // $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P31]);

        // $session = new Session();
        // $id_perkara = $session->get('id_perkara');

        // $searchModel = new PdmP31Search();
        // $dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        //     'sysMenu'=>$sysMenu,
        // ]);
    }

    /**
     * Displays a single PdmP31 model.
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
     * Creates a new PdmP31 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->redirect(['update']);
        // $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P31]);
        // $model = new PdmP31();
        // $id = Yii::$app->session->get('id_perkara');

        // $searchModelTersangka = new \app\modules\pidum\models\MsTersangkaSearch();
        // $dataProviderTersangka = $searchModelTersangka->searchTersangka($id);
        // $dataProviderTersangka->pagination = ['defaultPageSize' => 10];

        // if ($model->load(Yii::$app->request->post())) {
        // $transaction = Yii::$app->db->beginTransaction();
        //     try {
        //         $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p31', 'id_p31', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
        //         $model->id_perkara = $id;
        //         $model->id_p31 = $seq['generate_pk'];
        //         $model->save();

        //         PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::P31, 'id_table' => $model->id_p31]);
        //         if (isset($_POST['new_tembusan'])) {
        //             for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
        //                 $modelNewTembusan = new PdmTembusan();
        //                 $modelNewTembusan->id_table = $model->id_p31;
        //                 $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
        //                 $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
        //                 $modelNewTembusan->kode_table = GlobalConstMenuComponent::P31;
        //                 $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
        //                 $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
        //                 $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
        //                 $modelNewTembusan->id_perkara = $model->id_perkara;
        //                 $modelNewTembusan->nip = null;
        //                 $modelNewTembusan->save();
        //             }
        //         }


        //         $transaction->commit();

        //         Yii::$app->getSession()->setFlash('success', [
        //             'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
        //             'duration' => 5000, //Integer //3000 default. time for growl to fade out.
        //             'icon' => 'glyphicon glyphicon-ok-sign', //String
        //             'message' => 'Data Berhasil Disimpan', // String
        //             'title' => 'Save', //String
        //             'positonY' => 'top', //String // defaults to top, allows top or bottom
        //             'positonX' => 'center', //String // defaults to right, allows right, center, left
        //             'showProgressbar' => true,
        //         ]);

        //         return $this->redirect(['update', 'id' => $model->id_p31]);
                
        //     } catch (Exception $e) {
        //         $transaction->rollBack();

        //         Yii::$app->getSession()->setFlash('success', [
        //             'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
        //             'duration' => 5000, //Integer //3000 default. time for growl to fade out.
        //             'icon' => 'glyphicon glyphicon-ok-sign', //String
        //             'message' => 'Data Gagal Disimpan', // String
        //             'title' => 'Save', //String
        //             'positonY' => 'top', //String // defaults to top, allows top or bottom
        //             'positonX' => 'center', //String // defaults to right, allows right, center, left
        //             'showProgressbar' => true,
        //         ]);

        //          return $this->redirect(['view', 'id' => $model->id_p31]);
        //     }
        // } else {
        //     return $this->render('create', [
        //         'model' => $model,
        //          'dataProviderTersangka' => $dataProviderTersangka, 
        //         'id' => $id,
        //         'sysMenu'=>$sysMenu,
        //     ]);
        // }
    }

    /**
     * Updates an existing PdmP31 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
  
    public function actionUpdate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P31]);
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');

        $model = $this->findModel($no_register_perkara);
        if($model == null)
            $model = new PdmP31();

        $modelSpdp = $this->findModelSpdp($idPerkara);
        $terdakwa = VwTerdakwaT2::find()->where(['no_register_perkara'=>$no_register_perkara])->all();
     
          
        $searchModelTersangka = new \app\modules\pidum\models\MsTersangkaSearch();
        $dataProviderTersangka = $searchModelTersangka->searchTersangkaBa4($no_register_perkara,Yii::$app->request->queryParams);
        $dataProviderTersangka->pagination = ['defaultPageSize' => 10];
        
        if($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
          $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->no_register_perkara = $no_register_perkara;
                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];
                $model->nama_ttd = $_POST['hdn_nama_penandatangan'];

                $model->id_kejati = $session->get('kode_kejati');
                $model->id_kejari = $session->get('kode_kejari');
                $model->id_cabjari = $session->get('kode_cabjari');
                if(!$model->save()){
                    var_dump($model->getErrors());exit;
                }else{
                //echo '<pre>';print_r(count($_POST['new_tembusan']));exit;
                    PdmTembusanP31::deleteAll(['no_register_perkara'=>$no_register_perkara]);
                    for ($i=0; $i < count($_POST['new_tembusan']); $i++) { 
                        $modelTembusan = new PdmTembusanP31();
                        $modelTembusan->no_urut = $i+1;
                        $modelTembusan->tembusan =  $_POST['new_tembusan'][$i];
                        $modelTembusan->no_register_perkara = $no_register_perkara;
                        $modelTembusan->no_surat_p31 = $_POST['PdmP31']['no_surat_p31'];
                        if(!$modelTembusan->save()){
                                var_dump($modelTembusan->getErrors());exit;
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
                }
                return $this->redirect(['update']);
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
                'id' => $idPerkara,
                'model' => $model,
                'modelSpdp' => $modelSpdp,
                'modelTersangka'=>$modelTersangka,
                 'dataProviderTersangka' => $dataProviderTersangka, 
               'sysMenu'=> $sysMenu,
            ]);
        }
    }

    /**
     * Updates an existing PdmP31 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
  
    public function actionUpdate2($id)
    {
    //     $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P31]);
    //     $session = new Session();
        
    //     $model=$this->findModelP31($id);
    //     if($model == null)
    //         $model = new PdmP31();

    //     ///$modelSpdp = $this->findModelSpdp($idPerkara);
    //     //$terdakwa = VwTerdakwa::find()->where(['id_perkara'=>$idPerkara])->all();
    //       $modelTersangka = $this->findModelTersangka($id);
     
          
    //     $searchModelTersangka = new \app\modules\pidum\models\MsTersangkaSearch();
    //     $dataProviderTersangka = $searchModelTersangka->searchTersangka($id);
    //     $dataProviderTersangka->pagination = ['defaultPageSize' => 10];
        
    //     if($model->load(Yii::$app->request->post())) {
    //       $transaction = Yii::$app->db->beginTransaction();
    //         try {
    //             $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p31', 'id_p31', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

    //             if($model->id_perkara != null) {
    //                 //$model->flag = '2';
    //                 $model->update();
    //             } else {
    //                 $model->id_perkara = $idPerkara;
    //                 $model->id_p31 = $seq['generate_pk'];
    //                 $model->flag = '1';
    //                 $model->save();
    //             }

    //             PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::P31, 'id_table' => $model->id_p31]);
    //             if (isset($_POST['new_tembusan'])) {
    //                 for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
    //                     $modelNewTembusan = new PdmTembusan();
    //                     $modelNewTembusan->id_table = $model->id_p31;
    //                     $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
    //                     $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
    //                     $modelNewTembusan->kode_table = GlobalConstMenuComponent::P31;
    //                     $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
    //                     $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
    //                     $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
    //                     $modelNewTembusan->id_perkara = $model->id_perkara;
    //                     $modelNewTembusan->nip = null;
    //                     $modelNewTembusan->save();
    //                 }
    //             }

    //             $transaction->commit();

    //             Yii::$app->getSession()->setFlash('success', [
    //                 'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
    //                 'duration' => 5000, //Integer //3000 default. time for growl to fade out.
    //                 'icon' => 'glyphicon glyphicon-ok-sign', //String
    //                 'message' => 'Data Berhasil Disimpan', // String
    //                 'title' => 'Save', //String
    //                 'positonY' => 'top', //String // defaults to top, allows top or bottom
    //                 'positonX' => 'center', //String // defaults to right, allows right, center, left
    //                 'showProgressbar' => true,
    //             ]);

    //              return $this->redirect(['update', 'id' => $model->id_p31]);
    //         } catch(Exception $e) {
    //             $transaction->rollBack();

    //             Yii::$app->getSession()->setFlash('success', [
    //                 'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
    //                 'duration' => 5000, //Integer //3000 default. time for growl to fade out.
    //                 'icon' => 'glyphicon glyphicon-ok-sign', //String
    //                 'message' => 'Data Gagal Disimpan', // String
    //                 'title' => 'Save', //String
    //                 'positonY' => 'top', //String // defaults to top, allows top or bottom
    //                 'positonX' => 'center', //String // defaults to right, allows right, center, left
    //                 'showProgressbar' => true,
    //             ]);

    //             return $this->redirect('update');
    //         }
    //     } else {
    //         return $this->render('update', [
    //             'id' => $idPerkara,
    //             'model' => $model,
    //             'modelSpdp' => $modelSpdp,
    //             'modelTersangka'=>$modelTersangka,
    //              'dataProviderTersangka' => $dataProviderTersangka, 
    //            'sysMenu'=> $sysMenu,
    //         ]);
    //     }
    }

    /**
     * Deletes an existing PdmP31 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {   
        $id_p31 = $_POST['hapusp31'];
        if($id_p31[0]=='1')
        {
            PdmP11::updateAll(['flag' => 3]);
        }else{
            for($i=0;$i<count($id_p31);$i++){
                $p31 =$this->findModelP31($id_p31[$i]);
                $p31->flag = '3';
                $p31->update();
            }
        
        }
        
        /*$spdp = $this->findModel($id);
        $spdp->flag = '3';
        $spdp->update();*/

        
        return $this->redirect(['index']);
    }

	public function actionCetak($id)
    {
		$session = new session();
        $no_register_perkara = $session->get('no_register_perkara');        
        $tersangka = Yii::$app->globalfunc->getListTerdakwaBa4($no_register_perkara);
        $ba5 = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);
        $model = $this->findModel($no_register_perkara);
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_uu_pasal_tahap2')
                ->where("no_register_perkara='" . $no_register_perkara . "'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();
        $tahap2 = PdmTahapDua::findOne(['no_register_perkara'=>$no_register_perkara]);
        $listTembusan = PdmTembusanP31::findAll(['no_register_perkara'=>$no_register_perkara]);
        return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model, 'tersangka'=>$tersangka, 'ba5'=>$ba5, 'listPasal'=>$listPasal, 'tahap2'=>$tahap2, 'listTembusan'=>$listTembusan ]);
	}
        
    /**
     * Finds the PdmP31 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP31 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP31::findOne(['no_register_perkara'=>$id])) !== null) {
            return $model;
        } 
    }
    protected function findModelP31($id)
    {
        if (($model = PdmP31::findOne(['id_p31'=>$id])) !== null) {
            return $model;
        }
    }
    protected function findModelSpdp($id)
    {
        if(($model = PdmSpdp::findOne(['id_perkara'=>$id])) !== null)
            return $model;
    }
    
     protected function findModelTersangka($id)
    {
        if (($model = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
