<?php

namespace app\modules\pengawasan\controllers;

use app\models\KpInstSatkerSearch;
use Yii;
use app\modules\pengawasan\models\MkjBapeg;
use app\modules\pengawasan\models\MkjBapegSearch;
use yii\db\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\UploadedFile;

/**
 * MkjBapegController implements the CRUD actions for MkjBapeg model.
 */
class MkjBapegController extends Controller
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
     * Lists all MkjBapeg models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $session = new Session();
        // $id_register = $session->get('was_register');

        // $searchModel = new MkjBapegSearch();
        // $dataProvider = $searchModel->search($id_register);

        // $searchSatker = new KpInstSatkerSearch();
        // $dataProviderSatker = $searchSatker->searchSatker(Yii::$app->request->queryParams);

        return $this->render('index');
        // echo "string";
    }

    /**
     * Displays a single MkjBapeg model.
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
     * Creates a new MkjBapeg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MkjBapeg();

        if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->id_mkj_bapeg]);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->id_register = $id_register;
                $model->created_ip = Yii::$app->getRequest()->getUserIP();
                $files = UploadedFile::getInstance($model, 'upload_file');
                $model->upload_file = $files->name;
                if ($model->save(true)) {
                    if ($files != false) {
                        $path = Yii::$app->params['uploadPath'] . 'mkj_bapeg/' . $files->name;
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
        } else {
            

            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MkjBapeg model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->id_mkj_bapeg]);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->hasil_putusan != 2) $model->tingkat_kd = null;
                $model->updated_ip = Yii::$app->getRequest()->getUserIP();
                $modelMkjBapeg = MkjBapeg::findOne($model->id_mkj_bapeg);
                $files = UploadedFile::getInstance($model, 'upload_file');
                if (empty($files)) {
                    $model->upload_file = $modelMkjBapeg->upload_file;
                } else {
                    $model->upload_file = $files->name;
                }

                if ($model->update(true)) {
                    if ($files != false) {
                        $path = Yii::$app->params['uploadPath'] . 'mkj_bapeg/' . $files->name;
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
                ->from('was.mkj_bapeg a')
                ->innerJoin('kepegawaian.kp_inst_satker b', 'a.inst_satkerkd = b.inst_satkerkd')
                ->where('a.id_mkj_bapeg=:id_mkj_bapeg AND b.is_active=:is_active',
                    [':id_mkj_bapeg' => $model->id_mkj_bapeg, ':is_active' => 1])->one();

            #menampilkan hukuman disiplin
            $queryHukdis = new Query();
            $hukdis = $queryHukdis->select(["a.tingkat_kd","CONCAT(b.keterangan,' - ',a.bentuk_hukuman) AS hukdis"])
                ->from(['was.sp_r_tingkatphd a'])
                ->innerJoin(['was.sp_r_jnsphd b'],'a.phd_jns = b.phd_jns')
                ->where('a.aturan_hukum=:aturan_hukum',[':aturan_hukum'=>'Peraturan Pemerintah RI No. 53 Tahun 2010'])
                ->orderBy('a.phd_jns, a.tingkat_kd')
                ->all();

            return $this->renderAjax('_form', [
                'model' => $model,
                'terlapor' => $terlapor,
                'instansi' => $instansi,
                'hukdis' => $hukdis,
            ]);
        }
    }

    /**
     * Deletes an existing MkjBapeg model.
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

            $id_mkj_bapeg = Yii::$app->request->post('hapusIndex');

            if ($id_mkj_bapeg === 'all') {
                MkjBapeg::updateAll(['flag' => '3'], 'id_register=:id_register', [':id_register' => $id_register]);
            } else {
                for ($i = 0; $i < count($id_mkj_bapeg); $i++) {
                    MkjBapeg::updateAll(['flag' => '3'], 'id_mkj_bapeg=:id', [':id' => $id_mkj_bapeg[$i]]);
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
     * Finds the MkjBapeg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MkjBapeg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MkjBapeg::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
