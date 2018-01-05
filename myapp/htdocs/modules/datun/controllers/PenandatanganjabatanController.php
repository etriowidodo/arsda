<?php

namespace app\modules\datun\controllers;

use Yii;
use app\modules\datun\models\Penandatangan;
use app\modules\datun\models\Penandatanganjabatan;
//use app\modules\datun\models\PenandatanganSearch;
use app\modules\datun\models\VwJaksaPenuntutSearch;
use app\modules\datun\models\JaksaPenerima;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\rbac\Item;
use mdm\admin\components\MenuHelper;

class PenandatanganjabatanController extends Controller
{

    /**
     * @inheritdoc
     */
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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex($id)
    {
		// var_dump($_POST);
		// exit;
        $searchModel = new Penandatanganjabatan;
		$dataProvider = $searchModel->searchCustom($id);
        //$dataProvider = $searchModel->searchCustom(Yii::$app->request->get());
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
				'kode'	   => $id
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param  string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', ['model' => $model]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {	
		 $searchJPU = new VwJaksaPenuntutSearch();
         $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
         $dataJPU->pagination->pageSize = 5;
		
        $model = new Penandatanganjabatan;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            MenuHelper::invalidate();
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            //return $this->render('create', ['model' => $model,]);
            return $this->render('create', ['model' => $model,
                'searchJPU' => $searchJPU,
                'dataJPU' 	=> $dataJPU,
				'model' 	=> $model,
				'kode'      => $id,
               ]);
        }
        
    }

    public function actionGetmenu(){
		if (Yii::$app->request->isAjax) {
        	$model1 = new MenuSearch;
			$hasil 	= $model1->getMenu(Yii::$app->request->post());
			return $this->renderAjax('_getMenu', ['hasil' => $hasil, 'params'=>Yii::$app->request->post()]);
		}    
	}

    public function actionCekrole(){
		if (Yii::$app->request->isAjax) {
			$model = new Penandatanganjabatan;
			$hasil = $model->cekRole(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpan(){
		//var_dump($_POST);
		//exit;
		$kdttd    = Yii::$app->request->post('kode1');
		$nip_jbt  = Yii::$app->request->post('nip_jbt');
		$status   = Yii::$app->request->post('stptd');
		$ststtd   = Yii::$app->request->post('ttd');
		
        $model 	 = new Penandatanganjabatan;
		$sukses  = $model->simpanData(Yii::$app->request->post());
        if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index?id='.$kdttd]);	
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
            return $this->redirect(['create']);
        }
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new Penandatanganjabatan;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
			
		}    
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  string $id
     * @return mixed
     */
    public function actionUpdate($id){
		 $searchJPU = new VwJaksaPenuntutSearch();
		 $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
		 $dataJPU->pagination->pageSize = 5;
		
		 $model 	= new Penandatanganjabatan;
		 $ckdx  	= htmlspecialchars($id, ENT_QUOTES);
		 list($kdtk, $kdtd, $niptd, $sttd, $nmtd, $jbtd, $pktd) = explode("-", $ckdx);
		
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            MenuHelper::invalidate();
            return $this->redirect(['index', 
									'kode' => $id]);
        } else {
            //return $this->render('create', ['model' => $model,]);
            return $this->render('update', ['model' => $model,
                'searchJPU' 	=> $searchJPU,
                'dataJPU'		=> $dataJPU,
				'model' 		=> $model,
				'kodeTK'        => $kdtk,
				'kode'      	=> $kdtd,
				'nip'	      	=> $niptd,
				'sts'  	    	=> $sttd,
				'nmtd'      	=> $nmtd,
				'jbtd'	      	=> $jbtd,
				'pktd'  	   	=> $pktd,
               ]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->getAuthManager()->remove($model->item);
        MenuHelper::invalidate();

        return $this->redirect(['index']);
    }

    /**
     * Assign or remove items
     * @param string $id
     * @param string $action
     * @return array
     */
    public function actionAssign()
    {
        $post = Yii::$app->getRequest()->post();
        $id = $post['id'];
        $action = $post['action'];
        $roles = $post['roles'];
        $manager = Yii::$app->getAuthManager();
        $parent = $manager->getRole($id);
        $error = [];
        if ($action == 'assign') {
            foreach ($roles as $role) {
                $child = $manager->getRole($role);
                $child = $child ? : $manager->getPermission($role);
                try {
                    $manager->addChild($parent, $child);
                } catch (\Exception $e) {
                    $error[] = $e->getMessage();
                }
            }
        } else {
            foreach ($roles as $role) {
                $child = $manager->getRole($role);
                $child = $child ? : $manager->getPermission($role);
                try {
                    $manager->removeChild($parent, $child);
                } catch (\Exception $e) {
                    $error[] = $e->getMessage();
                }
            }
        }
        MenuHelper::invalidate();
        Yii::$app->response->format = 'json';

        return[
            'type' => 'S',
            'errors' => $error,
        ];
    }

    /**
     * Search role
     * @param string $id
     * @param string $target
     * @param string $term
     * @return array
     */
    public function actionSearchRole($id, $target, $term = '')
    {
        $result = [
            'Roles' => [],
            'Permissions' => [],
            'Routes' => [],
        ];
        $authManager = Yii::$app->authManager;
        if ($target == 'avaliable') {
            $children = array_keys($authManager->getChildren($id));
            $children[] = $id;
            foreach ($authManager->getRoles() as $name => $role) {
                if (in_array($name, $children)) {
                    continue;
                }
                if (empty($term) or strpos($name, $term) !== false) {
                    $result['Roles'][$name] = $name;
                }
            }
            foreach ($authManager->getPermissions() as $name => $role) {
                if (in_array($name, $children)) {
                    continue;
                }
                if (empty($term) or strpos($name, $term) !== false) {
                    $result[$name[0] === '/' ? 'Routes' : 'Permissions'][$name] = $name;
                }
            }
        } else {
            foreach ($authManager->getChildren($id) as $name => $child) {
                if (empty($term) or strpos($name, $term) !== false) {
                    if ($child->type == Item::TYPE_ROLE) {
                        $result['Roles'][$name] = $name;
                    } else {
                        $result[$name[0] === '/' ? 'Routes' : 'Permissions'][$name] = $name;
                    }
                }
            }
        }
        Yii::$app->response->format = 'json';

        return array_filter($result);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  string        $id
     * @return AuthItem      the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $item = Yii::$app->getAuthManager()->getRole($id);
        if ($item) {
            return new AuthItem($item);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}