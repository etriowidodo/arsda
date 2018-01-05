<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\MsJenisPerkara;
use app\modules\pidum\models\MsJenisPerkaraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
/**
 * MsJenisPerkaraController implements the CRUD actions for MsJenisPerkara model.
 */
class MsJenisPerkaraController extends Controller
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
     * Lists all MsJenisPerkara models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
		
        $searchModel = new MsJenisPerkaraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsJenisPerkara model.
     * @param integer $kode_pidana
     * @param integer $jenis_perkara
     * @return mixed
     */
    public function actionView($kode_pidana, $jenis_perkara)
    {
        return $this->render('view', [
            'model' => $this->findModel($kode_pidana, $jenis_perkara),
        ]);
    }

    /**
     * Creates a new MsJenisPerkara model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsJenisPerkara();
           // print_r($_POST);exit;
        if ($model->load(Yii::$app->request->post()) ) {
			$jml = Yii::$app->db->createCommand(" SELECT max(jenis_perkara)+1 as jml FROM pidum.ms_jenis_perkara WHERE kode_pidana = '".$_POST['MsJenisPerkara']['kode_pidana']."' ")->queryOne();
			$model->jenis_perkara = $jml['jml'];
            $model->save();
            // echo $model->jenis_perkara;exit;
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsJenisPerkara model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $kode_pidana
     * @param integer $jenis_perkara
     * @return mixed
     */
    public function actionUpdate($kode_pidana, $jenis_perkara)
    {
        $model = $this->findModel($kode_pidana, $jenis_perkara);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MsJenisPerkara model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $kode_pidana
     * @param integer $jenis_perkara
     * @return mixed
     */
    public function actionDelete()
    {

        // print_r($_POST);exit;

        $id = $_POST['hapusIndex'];

        if($id[0] == 'all'){ 
            try{          
                    MsJenisPerkara::deleteAll();  
                }catch (\yii\db\Exception $e) {
                          $count =1;
                } 
             if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  ' Data Jenis Perkara Tidak Dapat Dihapus Karena Sudah Digunakan Di Referensi Lainya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }      
        }
        else
        {
             $count = 0;
           foreach($id AS $key_delete => $delete){
             try{
                $array = explode('#',$delete);
                $kode_pidana = $array[0];
                $jenis_perkara = $array[1];
                $this->findModel($kode_pidana, $jenis_perkara)->delete();
                }catch (\yii\db\Exception $e) {
                  $count++;
                }
            }
            if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  $count.' Data Jenis Perkara Tidak Dapat Dihapus Karena Sudah Digunakan Di Referensi Lainya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }
            else
            {
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
            }
        }

        //$this->findModel($kode_pidana, $jenis_perkara)->delete();

        //return $this->redirect(['index']);
    }

    /**
     * Finds the MsJenisPerkara model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $kode_pidana
     * @param integer $jenis_perkara
     * @return MsJenisPerkara the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kode_pidana, $jenis_perkara)
    {
        if (($model = MsJenisPerkara::findOne(['kode_pidana' => $kode_pidana, 'jenis_perkara' => $jenis_perkara])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
