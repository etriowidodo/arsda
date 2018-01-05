<?php

namespace app\modules\pengawasan\controllers;

use app\models\KpInstSatkerSearch;
use app\modules\pengawasan\models\VTerlapor;
use Yii;
use app\modules\pengawasan\models\Tun;
use app\modules\pengawasan\models\TunSearch;
use yii\db\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\UploadedFile;

/**
 * TunController implements the CRUD actions for Tun model.
 */
class TunController extends Controller
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
     * Lists all Tun models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = new Session();
        $id_register = $session->get('was_register');

        $searchModel = new TunSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($id_register);

        $searchSatker = new KpInstSatkerSearch();
        $dataProviderSatker = $searchSatker->searchSatker(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchSatker' => $searchSatker,
            'dataProviderSatker' => $dataProviderSatker,
        ]);
    }

    /**
     * Displays a single Tun model.
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
     * Creates a new Tun model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tun();

        $session = new Session();
        $id_register = $session->get('was_register');

        if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->id_tun]);
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $model->id_register = $id_register;
                $model->created_ip = Yii::$app->getRequest()->getUserIP();
                $files = UploadedFile::getInstance($model, 'upload_file');
                $model->upload_file = $files->name;
                if ($model->save(true)) {
                    if ($files != false) {
                        $path = Yii::$app->params['uploadPath'] . 'tun/' . $files->name;
                        $files->saveAs($path);
                    }
                }

                $transaction->commit();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Berhasil Disimpan', // String
                    'title' => 'Create', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['index']);
            } catch(Exception $e) {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Disimpan', // String
                    'title' => 'Create', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['index']);
            }
        } else if(Yii::$app->request->isAjax) {
            #menampilkan terlapor
            $queryTerlapor = new Query();
            $terlapor = $queryTerlapor->select(["a.id_terlapor", "CONCAT(a.peg_nip,' - ',a.peg_nama) AS terlapor"])
                ->from('was.v_terlapor a')
                ->where('a.id_register=:id_register', [':id_register' => $id_register])
                ->all();

            #menampilkan nama kejaksaan
            $query = new Query();
            $instansi = $query->select('a.inst_satkerkd, b.inst_nama')
                ->from('was.dugaan_pelanggaran a')
                ->innerJoin('kepegawaian.kp_inst_satker b', 'a.inst_satkerkd = b.inst_satkerkd')
                ->where('length(a.inst_satkerkd)=:inst_satkerkd AND a.id_register=:id_register AND b.is_active=:is_active',
                    [':inst_satkerkd' => 2, ':id_register' => $id_register, ':is_active' => 1])->one();

            return $this->renderAjax('_form', [
                'model' => $model,
                'terlapor' => $terlapor,
                'instansi' => $instansi,
            ]);
        }
    }

    /**
     * Updates an existing Tun model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->id_tun]);
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $model->updated_ip = Yii::$app->getRequest()->getUserIP();
                $modelTun = Tun::findOne($model->id_tun);
                $files = UploadedFile::getInstance($model, 'upload_file');
                if (empty($files)) {
                    $model->upload_file = $modelTun->upload_file;
                } else {
                    $model->upload_file = $files->name;
                }

                if ($model->update(true)) {
                    if ($files != false) {
                        $path = Yii::$app->params['uploadPath'] . 'tun/' . $files->name;
                        $files->saveAs($path);
                    }
                }

                $transaction->commit();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Berhasil Diubah', // String
                    'title' => 'Update', //String
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
                    'message' => 'Data Gagal Diubah', // String
                    'title' => 'Update', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect('index');
            }
        } else if(Yii::$app->request->isAjax) {
            #menampilkan terlapor
            $queryTerlapor = new Query();
            $terlapor = $queryTerlapor->select(["a.id_terlapor", "CONCAT(a.peg_nip,' - ',a.peg_nama) AS terlapor"])
                ->from('was.v_terlapor a')
                ->where('a.id_register=:id_register', [':id_register' => $model->id_register])
                ->all();

            #query menampilkan nama instansi
            $query = new Query();
            $instansi = $query->select('a.inst_satkerkd, b.inst_nama')
                ->from('was.tun a')
                ->innerJoin('kepegawaian.kp_inst_satker b', 'a.inst_satkerkd = b.inst_satkerkd')
                ->where('a.id_tun=:id_tun AND b.is_active=:is_active',
                    [':id_tun' => $model->id_tun, ':is_active' => 1])->one();

            return $this->renderAjax('_form', [
                'model' => $model,
                'terlapor' => $terlapor,
                'instansi' => $instansi,
            ]);
        }
    }

    /**
     * Deletes an existing Tun model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        //$this->findModel($id)->delete();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $session = new Session();
            $id_register = $session->get('was_register');

            $id_tun = Yii::$app->request->post('hapusIndex');

            if ($id_tun === 'all') {
                Tun::updateAll(['flag' => '3'], 'id_register=:id_register', [':id_register' => $id_register]);
            } else {
                for ($i = 0; $i < count($id_tun); $i++) {
                    Tun::updateAll(['flag' => '3'], 'id_tun=:id', [':id' => $id_tun[$i]]);
                }
            }

            $transaction->commit();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        } catch(Exception $e) {
            $transaction->rollBack();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Gagal Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Tun model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tun the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tun::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
