<?php

namespace app\controllers;

use Yii;
use app\models\ContactForm;
use app\models\LoginForm;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'errorwas' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '..\..\..\..\views\site\error.php',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
		$this->layout = 'index_cms';
		if(!Yii::$app->user->isGuest){
			$id = Yii::$app->user->identity->id;
        	$query = new Query();
        	$query->select(['c.module'])->distinct()
			->from('mdm_user a')
			->join('join', 'mdm_user_role b', 'a.id = b.id_user')
			->join('join', 'mdm_role c', 'b.id_role = c.id_role')
			->where("a.id = '".$id."'");
        	$model = $query->all();
        	return $this->render('index', ['data' => $model]);
		}
    }

	public function actionErrornya()
	{
		$exception = Yii::$app->errorHandler->exception;
		if ($exception !== null) {
			return $this->render('error');
		}
	}

    public function actionLogin()
    {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/');
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
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
                'value' => $d ['peg_nama'],
                'nama' => $d ['peg_nama'],
                'id' => $d ['peg_nip']
            ];
        }
        echo Json::encode($out);
    }
    
    public function actionPegawainik($q = null){
        
        $query = new Query();
        $query->select(["concat(peg_nik ||' - '|| peg_nama) as peg_nama, peg_nik,concat(peg_nik ||' # '||peg_nip) as peg_id"])
                ->from('kepegawaian.kp_pegawai')
                ->where("concat(peg_nik,'||',lower(peg_nama),'||',peg_nik) LIKE '%" . $q . "%'")->orderBy('peg_nik');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out [] = [
                'value' => $d ['peg_nama'],
                'nama' => $d ['peg_nip'],
                'id' => $d ['peg_id']
            ];
        }
        echo Json::encode($out);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionOracle()
    {
        return $this->render('oracle');
    }
}
