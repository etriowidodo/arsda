<?php

namespace app\modules\pidum\controllers;

use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmSysMenuSearch;
use Yii;
use yii\db\Query;
use yii\web\Session;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PdmSysMenuController implements the CRUD actions for PdmSysMenu model.
 */
class PdmSysMenuController extends Controller {

    public function behaviors() {
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
     * Lists all PdmSysMenu models.
     * @return mixed
     */
    public function actionIndex() {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
        $searchModel = new PdmSysMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmSysMenu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmSysMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $session = new Session();
        $id = $session->get('id');
        $model = new PdmSysMenu();

        $query = new Query;
        //$query->select('count(*) as jlh')
        $query->select('max(id) as jlh')
                ->from('pidum.pdm_sys_menu');
        $data = $query->createCommand();
        $listTersangka = $data->queryAll();
        $id = $listTersangka[0]['jlh'] + 1;

        if ($model->load(Yii::$app->request->post())) {

            $model->id = $id;
            $model->no_surat = $_POST['PdmSysMenu']['no_surat'];
            $model->is_show = $_POST['PdmSysMenu']['is_show'];

            $files = UploadedFile::getInstance($model, 'file_name');
            $model->file_name = $files->name;
            $model->is_path = Yii::$app->basePath . "/web/template/pidum/";

            if ($model->save()) {
                if ($files != false) {
                    $path = Yii::$app->basePath . '/web/template/pidum/' . $files->name;
                    $files->saveAs($path);
                }
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
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdmSysMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $model = PdmSysMenu::findOne(['id' => $id]);
        // print_r($_POST);exit;

        $oldFileName = $model->file_name;
        $oldFile = (isset($model->file_name) ? Yii::$app->basePath . '/web/template/pidum/' . $model->file_name : null);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->id = $id;
                $model->no_surat = $_POST['PdmSysMenu']['no_surat'];
                $model->is_show = $_POST['PdmSysMenu']['is_show'];

                $files = UploadedFile::getInstance($model, 'file_name');
				
				$file_lama = $model->getOldAttributes()['file_name'];
				
				if ($files != false && !empty($files) ) {
					if($file_lama !=''){
						$model->file_name = $file_lama;
						$path = Yii::$app->basePath . '/web/template/pidum/' . $file_lama;
						$files->saveAs($path);
					}else{
						$model->file_name = $file_lama;
						$path = Yii::$app->basePath . '/web/template/pidum/' . $file_lama;
						$files->saveAs($path);
					}
					
				}else{
					$model->file_upload = $file_lama;
				}
					
                $model->is_path = Yii::$app->basePath . '/web/template/pidum/';
				
                if ($model->save()) {
                  
                }

                // if ($model->save()) {
                //     if ($files != false) {
                //         $path = Yii::$app->basePath . '/web/image/upload_file/sysmenu/' . $files->name;
                //         $files->saveAs($path);
                //     }
                // }

                // $filess = UploadedFile::getInstance($model, 'file_name');
                // if ($filess == false) {
                //     $file_name = $oldFileName;
                // } else {
                //     $file_name = $filess->name;
                // }

                // $model->file_name = $file_name;
                if ($model->update() !== false) {
                    
                } else {
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal disimpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                }


                $transaction->commit();
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
                return $this->redirect(['update','id'=>$id]);
            } catch (Exception $ex) {
                $transaction->rollback();

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
            }
            return $this->redirect(['update','id'=>$id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PdmSysMenu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete() {
        try {
            $id = $_POST['hapusIndex'];

            if ($id == "all") {
                $session = new Session();
                $id = $session->get('id');

                PdmSysMenu::updateAll(['flag' => '3'], "id = '" . $id . "'");
            } else {
                for ($i = 0; $i < count($id); $i++) {
                    PdmSysMenu::updateAll(['flag' => '3'], "id = '" . $id[$i] . "'");
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
     * Finds the PdmSysMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PdmSysMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmSysMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
