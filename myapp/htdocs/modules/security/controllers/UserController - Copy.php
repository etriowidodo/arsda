<?php

namespace app\modules\security\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\helpers\Json;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post('User');
            
            $model->username = $post['username'];
            $model->email = $post['email'];
            $model->peg_nip = $post['peg_nip'];
            $model->kd_satker = $post['kd_satker'];
            
            $model->password_hash = Yii::$app->security->generatePasswordHash($post['password_hash'], 10);
            
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post('User');

            $model->username = $post['username'];
            $model->email = $post['email'];
            $model->peg_nip = $post['peg_nip'];
            $model->kd_satker = $post['kd_satker'];

            //$model->password_hash = Yii::$app->security->generatePasswordHash($post['password_hash'], 10);

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionProfile()
    {
        $this->layout = false;
        $model = $this->findModel(Yii::$app->user->identity->id);

        if($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post('User');
            //echo Yii::$app->security->generatePasswordHash($post['password'], 10);die;
            $model->password_hash = Yii::$app->security->generatePasswordHash($post['password'], 10);
            
            if($model->save()){
                echo "aa";
            }else{
                echo "bbb";
            }
            /*Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Password Berhasil di Rubah',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);*/
        }
        return $this->render('profile', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionPegawai($q = null){
    	
    	$query = new Query();
    	$query->select(["concat(peg_nip ||' - '|| peg_nama) as peg_nama, peg_nip"])
                ->from('kepegawaian.kp_pegawai')
                ->where("concat(peg_nip,'||',lower(peg_nama)) LIKE '%" . $q . "%'")->orderBy('peg_nip');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out [] = [
                'value' => $d ['peg_nip'],
                'nama' => $d ['peg_nama'],
                'id' => $d ['peg_nip']
            ];
        }
        echo Json::encode($out);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
