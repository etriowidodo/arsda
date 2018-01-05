<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\MsPenyidik;
use app\modules\pidum\models\MsPenyidikSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PenyidikController implements the CRUD actions for MsPenyidik model.
 */
class PenyidikController extends Controller
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
     * Lists all MsPenyidik models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsPenyidikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsPenyidik model.
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
     * Creates a new MsPenyidik model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsPenyidik();

        // $id_penyidik = Yii::$app->autoincrement->Generate(20);

        if ($model->load(Yii::$app->request->post())) {
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.ms_penyidik', 'id_penyidik', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
            $model->id_penyidik = $seq['generate_pk'];
            $model->id_asalsurat = $_POST['MsPenyidik']['id_asalsurat'];
            // $model->id_penyidik = $id_penyidik;
            $model->flag='1';
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
                    return $this->redirect(['index']);
           } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsPenyidik model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_penyidik)
    {
        $model = MsPenyidik::findOne(['id_penyidik' =>$id_penyidik]);

        if ($model->load(Yii::$app->request->post())) {
             $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.ms_penyidik', 'id_penyidik', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
             if($model->id_penyidik != null){
			$model->flag='2';	
                        $model->id_asalsurat = $_POST['MsPenyidik']['id_asalsurat'];
			$model->update();
		}else{
			$model->id_penyidik = $seq['generate_pk'];
			$model->save();
			}
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
                    return $this->redirect(['index']);
               } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MsPenyidik model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        try{
            $id_penyidik = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id_penyidik = $session->get('id_penyidik');
				
		MsPenyidik::updateAll(['flag' => '3'], "id_penyidik = '" . $id_penyidik . "'");
            }else{
                for($i=0;$i<count($id_penyidik);$i++){
                    MsPenyidik::updateAll(['flag' => '3'], "id_penyidik = '" . $id_penyidik[$i] . "'");
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
        }catch (Exception $e){
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
     * Finds the MsPenyidik model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MsPenyidik the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsPenyidik::findOne($id)) !== null) {
            return $model;
        } 
    }
}
