<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmP40;
use app\modules\pidum\models\PdmTembusanP40;
use app\modules\pidum\models\PdmP40Search;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\modules\pidum\models\VwTerdakwaT2;
use app\models\MsSifatSurat;
/**
 * PdmP40Controller implements the CRUD actions for PdmP40 model.
 */
class PdmP40Controller extends Controller
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
     * Lists all PdmP40 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        
        $searchModel = new PdmP40Search();
        $dataProvider = $searchModel->search($no_register_perkara,Yii::$app->request->queryParams);
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P40 ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmP40 model.
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
     * Creates a new PdmP40 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmP40();
		
		$session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
		
		$kd_wilayah = PdmSpdp::findOne($id_perkara)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
		
		
		
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P40 ]);
		
		$searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $listTersangka = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);

        if ($model->load(Yii::$app->request->post()) ) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //echo '<pre>';print_r($_POST);exit;
			     $model->no_register_perkara = $no_register_perkara;
                 $model->nama = $_POST['PdmP40']['nama'];
                 $model->created_time=date('Y-m-d H:i:s');
                 $model->created_by=\Yii::$app->user->identity->peg_nip;
                 $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                 
                 $model->updated_by=\Yii::$app->user->identity->peg_nip;
                 $model->updated_time=date('Y-m-d H:i:s');
                 $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                 
                 $model->id_kejati = $session->get('kode_kejati');
                 $model->id_kejari = $session->get('kode_kejari');
                 $model->id_cabjari = $session->get('kode_cabjari');
                 if(!$model->save()){
                         var_dump($model->getErrors());exit;
                }else{
                            if (isset($_POST['new_tembusan'])) {
                            for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                                $modelNewTembusan = new PdmTembusanP40();
                                $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                                $modelNewTembusan->no_urut = $i+1;
                                $modelNewTembusan->no_register_perkara = $no_register_perkara;
                                $modelNewTembusan->no_surat_p40 = $_POST['PdmP40']['no_surat_p40'];
                                $modelNewTembusan->save();
                            }
                        }
                $transaction->commit();
                 Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                    return $this->redirect(['index']);
                }

				
            
			}catch (Exception $e) {
                echo '<pre>';print_r($e);exit;
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
                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                'model' => $model,
				'sysMenu' => $sysMenu,
				'wilayah' => $wilayah,
				'dataJPU' => $dataJPU,
            	'searchJPU' => $searchJPU,
				'listTersangka' => $listTersangka,
            ]);
        }
    }

    /**
     * Updates an existing PdmP40 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
		
		$session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
		$model = $this->findModel($no_register_perkara,$id);

		$kd_wilayah = PdmSpdp::findOne($id)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
		
		
		
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P40 ]);
		
		$searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $listTersangka = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);
		

        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $model->no_register_perkara = $no_register_perkara;
            $model->nama = $_POST['PdmP40']['nama'];
            $model->updated_by=\Yii::$app->user->identity->peg_nip;
            $model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
            if($model->update()){
                PdmTembusanP40::deleteAll(['no_register_perkara'=>$no_register_perkara, 'no_surat_p40'=>$model->no_surat_p40]);
                // echo $model->no_surat_p40;exit;
                if (isset($_POST['new_tembusan'])) {
                            for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                                $modelNewTembusan = new PdmTembusanP40();
                                $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                                $modelNewTembusan->no_urut = $i+1;
                                $modelNewTembusan->no_register_perkara = $no_register_perkara;
                                $modelNewTembusan->no_surat_p40 = $_POST['PdmP40']['no_surat_p40'];
                                //echo '<pre>';print_r($modelNewTembusan);exit;
                                $modelNewTembusan->save();
                            }
                }
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['index']);
            }else{
                var_dump($model->getErrors());exit;
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
				'sysMenu' => $sysMenu,
				'wilayah' => $wilayah,
				'dataJPU' => $dataJPU,
            	'searchJPU' => $searchJPU,
				'listTersangka' => $listTersangka,
				'modeljaksi' => $modeljaksi,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP40 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        
            if($id_tahap=='all'){
                    $id_tahapx=PdmP40::find()->select("no_surat_p40")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_surat_p40'];
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }

        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
            //echo '<pre>';print_r($delete);exit;
             try{
                    PdmP40::deleteAll(['no_register_perkara' => $no_register_perkara, 'no_surat_p40'=>$delete]);
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
     * Finds the PdmP40 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP40 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP40::findOne([$no_register_perkara,$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionCetak($id){
    $session = new session();
    $no_register_perkara = $session->get('no_register_perkara');
    $model = $this->findModel($no_register_perkara, $id);
    $tersangka      = VwTerdakwaT2::findAll(['no_register_perkara' => $model->no_register_perkara]);
    $listTembusan   = PdmTembusanP40::findAll(['no_surat_p40' => $model->no_surat_p40]);
    $sifat          = MsSifatSurat::findOne(['id'=>$model->sifat]);
    $query = new Query;
    $query->select('*')
            ->from('pidum.pdm_uu_pasal_tahap2')
            ->where("no_register_perkara='".$no_register_perkara."' ");
    $data = $query->createCommand();
    $listPasal = $data->queryAll();
    return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model, 'tersangka'=>$tersangka, 'listTembusan'=>$listTembusan, 'sifat'=>$sifat, 'listPasal'=>$listPasal]);
       
    }
}
