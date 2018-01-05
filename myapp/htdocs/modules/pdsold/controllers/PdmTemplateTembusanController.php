<?php

namespace app\modules\pdsold\controllers;

use app\modules\pdsold\models\PdmTemplateTembusan;
use app\modules\pdsold\models\PdmTemplateTembusanSearch;
use Yii;
use yii\db\Query;
use yii\web\Session;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PdmTemplateTembusanController implements the CRUD actions for PdmTemplateTembusan model.
 */
class PdmTemplateTembusanController extends Controller
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
     * Lists all PdmTemplateTembusan models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
		
        $searchModel = new PdmTemplateTembusanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmTemplateTembusan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmTemplateTembusan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmTemplateTembusan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$model->keterangan = $_POST['PdmTemplateTembusan']['keterangan'];
            //notifkasi simpan
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
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdmTemplateTembusan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id_tmp_tembusan)
    {
        
		//$model = new PdmTemplateTembusan();
        if (Yii::$app->request->post()) {
			PdmTemplateTembusan::deleteAll(['kd_berkas' => $id_tmp_tembusan]);
			$nama = $_POST['nama_tembusan'];
			for ($i = 0; $i < count($nama); $i++) {
					
                    $modelTembusan = new PdmTemplateTembusan();
                    $modelTembusan->kd_berkas = $id_tmp_tembusan;
                    $modelTembusan->no_urut = (string) ($i+1);
                    $modelTembusan->tembusan = $nama[$i];
                    $modelTembusan->keterangan = $nama[$i];
                    $modelTembusan->flag = '1';
                    if(!$modelTembusan->save()){
						var_dump($modelTembusan->getErrors());exit;
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
			  return $this->redirect(['update?id_tmp_tembusan='.$id_tmp_tembusan]); 
        } else {
			//$model = PdmTemplateTembusan::findOne(['kd_berkas'=>$id_tmp_tembusan]);
			$data_tembusan = PdmTemplateTembusan::find()->where(['kd_berkas' => $id_tmp_tembusan])->orderBy('no_urut asc')->all();
			$data_tembusan = Yii::$app->db->createCommand("SELECT b.kd_berkas,a.* FROM pidum.pdm_sys_menu b LEFT JOIN  pidum.pdm_template_tembusan a ON b.kd_berkas = a.kd_berkas WHERE b.kd_berkas='".$id_tmp_tembusan."'  ")->queryAll();
            return $this->render('update', [
                'data_tembusan' => $data_tembusan,
                //'model' => $model,
                'kd_berkas' => $id_tmp_tembusan,
            ]);
        }
    }

    /**
     * Deletes an existing PdmTemplateTembusan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmTemplateTembusan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PdmTemplateTembusan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmTemplateTembusan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
