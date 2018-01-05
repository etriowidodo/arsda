<?php

namespace app\modules\pdsold\controllers;
 
use Yii;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmT12;
use app\modules\pdsold\models\PdmT12Search;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\PdmTembusanT12;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\web\Response;

/**
 * PdmT12Controller implements the CRUD actions for PdmT12 model.
 */
class PdmT12Controller extends Controller
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
     * Lists all PdmT12 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T12 ]);

        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');

        $searchModel = new PdmT12Search();
        $dataProvider = $searchModel->search($no_register_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmT12 model.
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
     * Creates a new PdmT12 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T12 ]);

        $model = new PdmT12();
        
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $modelTersangka = VwTerdakwaT2::findAll(['no_register_perkara' => $no_register_perkara]);
        $modeljaksiChoosen = '';
        $modeljaksi = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register_perkara]);
        //echo '<pre>';print_r($modeljaksi);exit;
        /*$modelSpdp = $this->findModelSpdp($id_perkara);
        $modelt8 = Yii::$app
                    ->db
                    ->createCommand("SELECT t8.* FROM pidum.pdm_t12 t12
                        INNER JOIN pidum.pdm_t8 t8 ON t12.id_perkara = t8.id_perkara
                        WHERE t12.id_perkara = '$id_perkara' AND t8.flag <> '3'
                        AND t8.tgl_permohonan = (SELECT MAX(tgl_permohonan) FROM pidum.pdm_t8 WHERE id_perkara = '$id_perkara')")
                    ->queryOne();
        $modelRp9 = PdmRp9::findOne(['id_perkara' => $id_perkara]);
        $modelRt3 = PdmRt3::findOne(['id_perkara' => $id_perkara]);
        $tahanan = PdmTahananPenyidik::findOne(['id_perkara' => $model->id_perkara, 'id_tersangka' => $model->id_tersangka]);*/

        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try{            
                //$model->id_t12 = $seq['generate_pk'];
                $model->no_register_perkara = $no_register_perkara;
                $model->nama = $_POST['PdmT12']['nama'];
                $model->no_reg_tahanan_jaksa = $_POST['PdmT12']['no_reg_tahanan_jaksa'];
                $model->id_tersangka = $_POST['PdmT12']['id_tersangka'];
                $model->nip_jaksa = $_POST['PdmT12']['nip_jaksa'];
                $model->sifat = $_POST['PdmT12']['sifat'];
                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->id_kejati = $session->get('kode_kejati');
                $model->id_kejari = $session->get('kode_kejari');
                $model->id_cabjari = $session->get('kode_cabjari');
                

                //$model->id_t8 = $modelt8->id_t8;

                if($model->save()){
                    if(isset($_POST['new_tembusan'])){
                        for($i = 0; $i < count($_POST['new_tembusan']); $i++){
                            $modelNewTembusan= new PdmTembusanT12();
                            $modelNewTembusan->no_surat_t12 = $_POST['PdmT12']['no_surat_t12'];
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut= $i+1;                   
                            $modelNewTembusan->no_register_perkara = $no_register_perkara;
                            $modelNewTembusan->save();
                        }
                    }

                    $transaction->commit();

                    //simpan
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
                    
                    return $this->redirect(['index']);
                }else{
                    var_dump($model->getErrors());exit;
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['create']);
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
				'tahanan' => $tahanan,
                //'modelt8' => $modelt8,
                //'modelRp9' => $modelRp9,
                //'modelRt3' => $modelRt3,
                'modelTersangka' => $modelTersangka,
                'modeljaksiChoosen' => $modeljaksiChoosen,
                'modeljaksi' => $modeljaksi,
                'searchTersangka' => $searchTersangka,
                'dataTersangka' => $dataTersangka,
                'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmT12 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_t12){
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T12 ]);
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');

        $model = $this->findModel($id_t12,$no_register_perkara);
        if(empty($model)){
            $model = new PdmT12();
        }

        $modelTersangka = VwTerdakwaT2::findAll(['no_register_perkara' => $no_register_perkara]);
        $modeljaksiChoosen = '';
        $modeljaksi = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register_perkara]);


        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try{

                $model->nama = $_POST['PdmT12']['nama'];
                $model->no_register_perkara = $no_register_perkara;
                $model->no_reg_tahanan_jaksa = $_POST['PdmT12']['no_reg_tahanan_jaksa'];
                $model->id_tersangka = $_POST['PdmT12']['id_tersangka'];
                $model->nip_jaksa = $_POST['PdmT12']['nip_jaksa'];
                $model->sifat = $_POST['PdmT12']['sifat'];
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

                if($model->save() || $model->update()){

                    //Insert tabel tembusan 
                    if(!empty($_POST['new_tembusan'])){
                        PdmTembusanT12::deleteAll(['no_register_perkara' => $model->no_register_perkara, 'no_surat_t12'=>$model->no_surat_t12]);		
                        for($i = 0; $i < count($_POST['new_tembusan']); $i++){
                            $modelNewTembusan= new PdmTembusanT12();
                            $modelNewTembusan->no_surat_t12 = $_POST['PdmT12']['no_surat_t12'];
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut= $i+1;                   
                            $modelNewTembusan->no_register_perkara = $no_register_perkara;
                            $modelNewTembusan->save();
                        }
                    }

                    $transaction->commit();

                    //simpan
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil di Ubah',
                        'title' => 'Ubah Data',
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    
                    return $this->redirect(['index']);
                }else{
                    //if(!$model->save()){
                            var_dump($model->getErrors());exit;
                           //}
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal di Ubah',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['update', 'id_t12' => $model->id_t12]);
                }
            }catch (Exception $e) {
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
                return $this->redirect(['update', 'id_t12' => $model->id_t12]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
				//'tahanan' => $tahanan,
                //'modelt8' => $modelt8,
                //'modelRp9' => $modelRp9,
                //'modelRt3' => $modelRt3,
                'modelTersangka' => $modelTersangka,
                'modeljaksiChoosen' => $modeljaksiChoosen,
                'modeljaksi' => $modeljaksi,
                'searchTersangka' => $searchTersangka,
                'dataTersangka' => $dataTersangka,
                'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Deletes an existing PdmT12 model.
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
                    $id_tahapx=PdmT12::find()->select("no_surat_t12")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_surat_t12'];
                        
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }

        

        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    PdmT12::deleteAll(['no_register_perkara' => $no_register_perkara, 'no_surat_t12'=>$delete]);
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
	
	public function actionCetak ($id_t12) {     
        $connection = \Yii::$app->db;
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');

        $model = $this->findModel($id_t12,$no_register_perkara);
        $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_urut_tersangka'=>$model->id_tersangka]);
        $tembusan = PdmTembusanT12::findAll(['no_register_perkara' => $no_register_perkara, 'no_surat_t12'=>$id_t12]);
        //echo '<pre>';print_r($model);exit;
        return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model, 'tersangka'=>$tersangka, 'tembusan'=>$tembusan]);        
    }

    /**
     * Finds the PdmT12 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmT12 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionTerdakwa()
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $query = new Query;
        $query->select('vwt.*')
                ->from('pidum.vw_terdakwat2 vwt')
                ->where(['vwt.no_reg_tahanan' => $_POST['no_reg_tahanan']])
                ->andWhere(['=', 'vwt.no_register_perkara',$no_register_perkara ]);
        $terdakwa = $query->createCommand();
        $terdakwa = $terdakwa->queryOne();
        //echo '<pre>';print_r($terdakwa);exit;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'tmpt_lahir' => $terdakwa['tmpt_lahir'],
            'tgl_lahir' => ($terdakwa['tgl_lahir'] != null) ? date('d-m-Y', strtotime($terdakwa['tgl_lahir'])) : '',
            'jns_kelamin' => $terdakwa['is_jkl'],
            'alamat' => $terdakwa['alamat'],
            'agama' => $terdakwa['is_agama'],
            'pekerjaan' => $terdakwa['pekerjaan'],
            'pendidikan' => $terdakwa['is_pendidikan'],
            'ditahan_sejak' => date('d-m-Y', strtotime($terdakwa['tgl_mulai'])),
            'no_reg_tahanan' => $terdakwa['no_reg_tahanan'],
            'no_surat_t8' => $terdakwa['no_surat_t8'],
            'no_register_perkara' => $terdakwa['no_register_perkara'],
            'nama' => $terdakwa['nama'],
            'no_urut_tersangka' => $terdakwa['no_urut_tersangka'],
            'tgl_mulai' => ($terdakwa['tgl_mulai'] != null) ? date('d-m-Y', strtotime($terdakwa['tgl_mulai'])) : '',
        ];
    }


    protected function findModel($id,$no_register_perkara)
    {
          if (($model = PdmT12::findOne(['no_register_perkara'=>$no_register_perkara, 'no_surat_t12' => $id])) !== null) {
            return $model;
        }
    }
     protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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