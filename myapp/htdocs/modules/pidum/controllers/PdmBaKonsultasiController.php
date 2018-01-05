<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmBaKonsultasi;
use app\modules\pidum\models\PdmBaKonsultasiSearch;
use app\modules\pidum\models\PdmJaksaP16;
use app\modules\pidum\models\PdmSpdp;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * PdmBaKonsultasiController implements the CRUD actions for PdmBaKonsultasi model.
 */
class PdmBaKonsultasiController extends Controller
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
     * Lists all PdmBaKonsultasi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        
        $searchModel = new PdmBaKonsultasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id_perkara);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmBaKonsultasi model.
     * @param string $id_perkara
     * @param integer $id_ba_konsultasi
     * @return mixed
     */
    public function actionView($id_perkara, $id_ba_konsultasi)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_perkara, $id_ba_konsultasi),
        ]);
    }

    /**
     * Creates a new PdmBaKonsultasi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $connection = \Yii::$app->db;
        $model      = new PdmBaKonsultasi();
        $session    = new session();
        $id_perkara = $session->get('id_perkara');
        $jaksa      = PdmJaksaP16::findAll(['id_perkara'=>$id_perkara]);
        $sql        = "select * from pidum.pdm_p16 where id_perkara = '".$id_perkara."' order by tgl_dikeluarkan desc limit 1";
        $model_p16  = $connection->createCommand($sql);
        $jaksa_p16  = $model_p16->queryOne();
        //$sql = "select count(*)"

        
        if ($model->load(Yii::$app->request->post())) {
            $id_ba = Yii::$app->db->createCommand("select cast(nextval('pidum.seq_ba_konsultasi') as int)")->queryOne();
            //$id_ba = intval(array($id_ba));
            //echo '<pre>';print($id_ba['nextval']);exit;
            $Jpilih = PdmJaksaP16::findOne(['nip'=>$_POST['PdmBaKonsultasi']['nip_jaksa']]);
            $model->nama_jaksa = $Jpilih->nama;
            $model->jabatan_jaksa = $Jpilih->jabatan;
            $model->pangkat_jaksa = $Jpilih->pangkat;
            $model->id_perkara = $id_perkara;
            $model->id_ba_konsultasi = $id_ba['nextval'];
            $model->file_upload         = $_POST['PdmBaKonsultasi']['file_upload']; 
//            echo '<pre>';print_r($model);exit();
             if(!$model->save()){
                    echo'<pre>';var_dump($model->getErrors());exit;
                }

            //return $this->redirect(['view', 'id_perkara' => $model->id_perkara, 'id_ba_konsultasi' => $model->id_ba_konsultasi]);
            Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Berhasil Disimpan', // String
                    'title' => 'Ubah Data', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

            return $this->redirect('index');
        }else{
            return $this->render('create', [
                'model' => $model,
                'jaksa' => $jaksa,
                'jaksa_p16' => $jaksa_p16,
            ]);
        }
    }

    /**
     * Updates an existing PdmBaKonsultasi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id_perkara
     * @param integer $id_ba_konsultasi
     * @return mixed
     */
    public function actionUpdate($id_perkara, $id_ba_konsultasi)
    {
        $connection = \Yii::$app->db;
        $model = $this->findModel($id_perkara, $id_ba_konsultasi);
        $jaksa = PdmJaksaP16::findAll(['id_perkara'=>$id_perkara]);
        $sql        = "select * from pidum.pdm_p16 where id_perkara = '".$id_perkara."' order by tgl_dikeluarkan desc limit 1";
        $model_p16  = $connection->createCommand($sql);
        $jaksa_p16  = $model_p16->queryOne();
        if ($model->load(Yii::$app->request->post())) {
            $Jpilih = PdmJaksaP16::findOne(['nip'=>$_POST['PdmBaKonsultasi']['nip_jaksa']]);
            $model->nama_jaksa = $Jpilih->nama;
            $model->jabatan_jaksa = $Jpilih->jabatan;
            $model->pangkat_jaksa = $Jpilih->pangkat;
            $model->id_perkara = $id_perkara;
            $model->file_upload         = $_POST['PdmBaKonsultasi']['file_upload']; 

            if(!$model->save()){
                    var_dump($model->getErrors());exit;
                   }
            //return $this->redirect(['view', 'id_perkara' => $model->id_perkara, 'id_ba_konsultasi' => $model->id_ba_konsultasi]);
            Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Berhasil Diubah', // String
                    'title' => 'Ubah Data', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
                'jaksa' => $jaksa,
                'jaksa_p16' => $jaksa_p16,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBaKonsultasi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id_perkara
     * @param integer $id_ba_konsultasi
     * @return mixed
     */
    public function actionDelete(){
        $session = new session();
        $id_perkara = $session->get('id_perkara');

        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];

            if($id_tahap=='all'){
                    $id_tahapx=PdmBaKonsultasi::find()->select("id_ba_konsultasi")->where(['id_perkara'=>$id_perkara])->asArray()->all();
                    //echo '<pre>';print_r($id_tahapx);exit;
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['id_ba_konsultasi'];
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }


        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    PdmBaKonsultasi::deleteAll(['id_perkara'=>$id_perkara, 'id_ba_konsultasi' => $delete]);
                }catch (\yii\db\Exception $e) {
                  $count++;
                }
            }
            if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  $count.' BA Konsultasi Tidak Dapat Dihapus Karena Sudah Digunakan Di Persuratan Lainnya',
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
     * Finds the PdmBaKonsultasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id_perkara
     * @param integer $id_ba_konsultasi
     * @return PdmBaKonsultasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_perkara, $id_ba_konsultasi)
    {
        if (($model = PdmBaKonsultasi::findOne(['id_perkara' => $id_perkara, 'id_ba_konsultasi' => $id_ba_konsultasi])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id_ba_konsultasi){
        $connection = \Yii::$app->db;
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $spdp       = PdmSpdp::findOne(['id_perkara'=>$id_perkara]);
        $model      = $this->findModel($id_perkara, $id_ba_konsultasi);
        $sql        = "select * from pidum.pdm_p16 where id_perkara = '".$id_perkara."' order by tgl_dikeluarkan desc limit 1";
        $model_p16  = $connection->createCommand($sql);
        $jaksa_p16  = $model_p16->queryOne();
        return $this->render('cetak', ['model'=>$model, 'spdp'=>$spdp, 'jaksa_p16'=>$jaksa_p16]);
    }
    
    public function actionCetakdraf(){
        $connection = \Yii::$app->db;
        $session    = new session();
        $id_perkara = $session->get('id_perkara');
        $spdp       = PdmSpdp::findOne(['id_perkara'=>$id_perkara]);
        $sql        = "select * from pidum.pdm_p16 where id_perkara = '".$id_perkara."' order by tgl_dikeluarkan desc limit 1";
        $model      = $connection->createCommand($sql);
        $jaksa_p16  = $model->queryOne();
//        $jaksa_p16  = PdmJaksaP16::findAll(['id_perkara'=>$id_perkara]);
        return $this->render('cetak_draf', ['spdp'=>$spdp, 'id_perkara'=>$id_perkara, 'jaksa_p16'=>$jaksa_p16]);
    }
}
