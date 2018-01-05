<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\JenisInstansi;

class InstansiController extends Controller{

    public function actionIndex(){
	   $searchModelJenis = new InstansiSearch;
	   $dataProviderJenis = $searchModelJenis->searchCustomjenis(Yii::$app->request->get());


		$query = " SELECT max(CAST(coalesce(kode_jenis_instansi, '0') AS integer)+1)as urut FROM datun.jenis_instansi  ";		
		$curut = Yii::$app->db->createCommand($query)->queryScalar(); 
	
		
		if($curut==0){
			$dkode=1;							 
		}else{
			$dkode=$curut;
		}
		$urut = sprintf("%02d", $dkode);
		
 			   
        return $this->render('index', [
                'dataProviderJenis' => $dataProviderJenis,
                'searchModelJenis' => $searchModelJenis,
				'urut'				=> $urut,
				
        ]);
				
    }


    public function actionIndex2($id)
    {
			
	   $searchModelInstansi = new InstansiSearch;
	   $dataProviderInstansi = $searchModelInstansi->searchCustominstansi(Yii::$app->request->get());
	   

        return $this->render('_instansi', [
                'dataProviderInstansi' => $dataProviderInstansi,
                'searchModelInstansi' => $searchModelInstansi,				
				
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
  
  public function actionCreate()
    {
        $model = new InstansiSearch;

        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            MenuHelper::invalidate();
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
		

	   
	   $dataProvider = $searchModel->searchCustom(Yii::$app->request->get());

        return $this->render('instansi', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
		
    }

	
	 public function actionCreatejenis()
    {
        $model = new InstansiSearch;
		
        //$model->type = Item::TYPE_ROLE;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            MenuHelper::invalidate();
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('createjenis', ['model' => $model,]);
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
			$model = new InstansiSearch;
			$hasil = $model->cekRolejenis(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}
	
    public function actionCekInstansi(){
		if (Yii::$app->request->isAjax) {
			$model = new InstansiSearch;
			$hasil = $model->cekInstansi(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionCekInstansiJenis(){
		if (Yii::$app->request->isAjax) {
			$model = new InstansiSearch;
			$hasil = $model->cekInstansi(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}	
	
    public function actionSimpanjenis(){
		$model 	= new InstansiSearch;       
	   
		$kode1    = Yii::$app->request->post('kode_jenis_instansi');
		$status    = Yii::$app->request->post('status');

		
		$query = " select count(*) from datun.jenis_instansi where kode_jenis_instansi='$kode1'  ";		
		if($status == 0){
			$cek = Yii::$app->db->createCommand($query)->queryScalar(); 	
		}else{
			$cek =0;	
		}		
		
		if ($cek >=1){
			Yii::$app->session->setFlash('success', ['title'=>'GAGAL SIMPAN','type'=>'danger', 'message'=>'Maaf, Kode   '.$kode1.'   Sudah Ada. Ganti dengan yang lain']);
            return $this->redirect(['index']);
			
		}else{
		
				$sukses = $model->simpanDataJenis(Yii::$app->request->post());
				if($sukses){
					Yii::$app->session->setFlash('success', ['title'=>'SUCCESS','type'=>'success', 'message'=>'Data berhasil disimpan']);
					return $this->redirect(['index']);
				} else{
					Yii::$app->session->setFlash('success', ['title'=>'WARNING','type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
					return $this->redirect(['index']);
				}
		}
    }

	
    public function actionSimpaninstansi(){
		$model 	= new InstansiSearch;
		
		$kode1    = Yii::$app->request->post('kode_jenis_instansi');		
		$kode2    = Yii::$app->request->post('kode_instansi');	
		$status    = Yii::$app->request->post('status_instansi');
		
		$query = " select count(*) from datun.instansi where kode_jenis_instansi='$kode1' and kode_instansi='$kode2' ";			
		if($status == 0){
			$cek = Yii::$app->db->createCommand($query)->queryScalar(); 	
		}else{
			$cek =0;	
		}		

		
		if ($cek >=1){
			Yii::$app->session->setFlash('success', ['title'=>'GAGAL SIMPAN','type'=>'danger', 'message'=>'Maaf, Kode '.$kode1.' Sudah Ada. Ganti dengan yang lain']);
            return $this->redirect(['pilih_jenis?id='.$kode1, 
									'id' => $model->kode_jenis_instansi]);			
		}else{		
		
			$sukses = $model->simpanDatainstansi(Yii::$app->request->post());
			if($sukses){
				Yii::$app->session->setFlash('success', ['title'=>'SUCCESS','type'=>'success', 'message'=>'Data berhasil disimpan']);
				return $this->redirect(['pilih_jenis?id='.$kode1, 
										'id' => $model->kode_jenis_instansi]);
				} else{
				Yii::$app->session->setFlash('success', ['title'=>'WARNING','type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
				return $this->redirect(['pilih_jenis?id='.$kode1, 
										'id' => $model->kode_jenis_instansi]);
				}
			}
		}	
	
	
    public function actionSimpanwilayah(){
		
		$kode1    = Yii::$app->request->post('kode_jenis_instansi');
		$kode2    = Yii::$app->request->post('kode_instansi');

		
        $model 	= new InstansiSearch;
		$sukses = $model->simpanDatawilayah(Yii::$app->request->post());
        if($sukses){
			Yii::$app->session->setFlash('success', ['title'=>'SUCCESS','type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['instansi/pilih_instansi?id='.$kode1.'/'.$kode2, 
									'id' => $model->kode_jenis_instansi]);
        } else{
			Yii::$app->session->setFlash('success', ['title'=>'WARNING','type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
            return $this->redirect(['instansi/pilih_instansi?id='.$kode1.'/'.$kode2, 
									'id' => $model->kode_jenis_instansi]);
        }
		//}
    }	
	

    public function actionHapusdatawilayah(){
		if (Yii::$app->request->isAjax) {
			$model = new InstansiSearch;
			$hasil = $model->hapusDatawilayah(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
    }
	
	
    public function actionHapusdatainstansi(){
		if (Yii::$app->request->isAjax) {
			$model = new InstansiSearch;
			$hasil = $model->hapusDatainstansi(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
    }
	
	
    public function actionHapusdatajenis(){
		if (Yii::$app->request->isAjax) {
			$model = new InstansiSearch;
			$hasil = $model->hapusDatajenis(Yii::$app->request->post());
			if($hasil){
			Yii::$app->session->setFlash('hasil', ['title'=>'SUCCESS','type'=>'success', 'message'=>'Data berhasil dihapus']);
			}
			return $this->redirect(['index']);
			
		//	$hasil = ($hasil)?true:false;			
		//	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		//	return ['hasil'=>$hasil];
			
		
		}    
    }	
	

	
	   public function actionUpdatejenis($id){
        $model = new InstansiSearch;
		
		$query = " SELECT deskripsi_jnsinstansi FROM datun.jenis_instansi where kode_jenis_instansi='$id' ";		
		$desc = Yii::$app->db->createCommand($query)->queryScalar();
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 
									'kode1' => $model->kode_jenis_instansi]);
        } else {
	
			return $this->render('_jenis_instansi', [
								 'model' 	=> $model,
								 'kode1'	   	=> $id,								 							
								 'desc'	   	=> $desc,
								 ]);		
			
			
		}
			
			

		
    }
	
	   public function actionUpdateinstansi($id){
		//$model = Penandatangan::findBySql("SELECT * FROM datun.m_penandatangan where kode='$id' ")->asArray()->one();
        $model = new InstansiSearch;
		 $cid  	= htmlspecialchars($id, ENT_QUOTES);
		 list($kdjns, $kdins) = explode("/", $cid);

		$query = " SELECT deskripsi_jnsinstansi FROM datun.jenis_instansi where kode_jenis_instansi='$kdjns' ";		
		$nmjns = Yii::$app->db->createCommand($query)->queryScalar();
				 
		$query = " SELECT deskripsi_instansi FROM datun.instansi where kode_jenis_instansi='$kdjns' and kode_instansi='$kdins' ";		
		$desc = Yii::$app->db->createCommand($query)->queryScalar();
		
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index2', 
									'kode' => $id]);
        } else {
								 
		            return $this->render('_tambah_instansi', [
								 'model' 	=> $model,
								 'kode1'	   	=> $kdjns,
								 'kode2'	   	=> $kdins,
								 'nmjns'		=> $nmjns,								 
								 'desc'	   	=> $desc,
								 ]);						 
								 
        }
		
    }	
	
	
	
    public function actionPilih_instansi($id){		

	   $searchModelWilayah = new InstansiSearch ;	   
	   $cid  	= htmlspecialchars($id, ENT_QUOTES);
	   list($kode1,$kode2) = explode("/", $cid);
	   $dataProviderWilayah = $searchModelWilayah->searchCustomwilayah(Yii::$app->request->get());				
	   
	   $query = " SELECT deskripsi_instansi FROM datun.instansi where kode_jenis_instansi='$kode1' and kode_instansi='$kode2' ";		
		$desc = Yii::$app->db->createCommand($query)->queryScalar();
		
        return $this->render('_wilayah', [
                'dataProviderWilayah' => $dataProviderWilayah,
                'searchModelWilayah' => $searchModelWilayah,
				'kode1' => $kode1,
				'kode2' => $kode2,				
				'desc'   =>  $desc,
				
				
        ]);	
		
	
	
		
    }	
	
    public function actionPilih_jenis($id){		

	   $searchModelInstansi = new InstansiSearch;
	   $dataProviderInstansi = $searchModelInstansi->searchCustominstansi(Yii::$app->request->get());

		
	    $query = " SELECT deskripsi_jnsinstansi FROM datun.jenis_instansi where kode_jenis_instansi='$id' ";		
		$desc = Yii::$app->db->createCommand($query)->queryScalar();

		$query = " SELECT max(CAST(coalesce(kode_instansi, '0') AS integer)+1)as urut FROM datun.instansi where kode_jenis_instansi='$id'  ";		
		$curut = Yii::$app->db->createCommand($query)->queryScalar(); 
				
		if($curut==0){
			$dkode=1;							 
		}else{
			$dkode=$curut;
		}
		$urut = sprintf("%03d", $dkode);
		
	  
        return $this->render('_instansi', [
                'dataProviderInstansi' => $dataProviderInstansi,
                'searchModelInstansi' => $searchModelInstansi,
				'kode1'	   	=> $id,
				'nmjns'	   	=> $desc,
				'urut'		=> $urut,
				]);
	
    }	
	

 public function actionPilih_wilayah($id){		

	   $searchModelWilayah = new InstansiSearch;
	   $cid  	= htmlspecialchars($id, ENT_QUOTES);
	   list($kode1,$kode2,$kode3,$kode4,$kode5,$c1,$c2,$c3,$c4) = explode("/", $cid);

		$dataProviderWilayah = $searchModelWilayah->searchCustomwilayah(Yii::$app->request->get());
		   
	 return $this->render('_instansi_wilayah', [
                'dataProviderWilayah' => $dataProviderWilayah,
                'searchModelWilayah' => $searchModelWilayah,
				'kode1' => $kdjns,
				'kode2' => $kdins,
				'kode3' => $id_prop,
				'kode4' => $kd_kabupaten,
				'kode5' => $kdins,
				'kode6' => $kdins,
				'c1' => $c1,
				'c2' => $c2,
				'c3' => $c3,
				'c4' => $c4,
				
        ]);	
	
	
    }		
	
		
 public function actionUpdatewilayah($id){
         $model = new InstansiSearch;
		 $cid  	= htmlspecialchars($id, ENT_QUOTES);

		   list($kode1, $kode2, $kode3, $kode4, $kode5, $kode6) = explode("/", $cid);		
	       $seq = Yii::$app->db->createCommand("select nama,alamat,no_tlp,deskripsi_inst_wilayah from datun.instansi_wilayah where kode_jenis_instansi = '".$kode1."' and kode_instansi = '".$kode2."' and kode_provinsi = '".$kode3."'and kode_kabupaten = '".$kode4."'and kode_tk = '".$kode5."' and no_urut = '".$kode6."' ")->queryOne();   
          		 		  
		  $c1=($seq['nama']);
		  $c2=($seq['alamat']);
		  $c3=($seq['no_tlp']);
		  $c4=($seq['deskripsi_inst_wilayah']);
		  
	   			
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['instansi/pilih_instansi?id='.$kode1.'/'.$kode2, 
									'id' => $model->kode_jenis_instansi]);
        } else {
		            return $this->render('_instansi_wilayah', [
								'model' 	=> $model,
								'kode1'	   	=> $kode1,
								'kode2'	   	=> $kode2,
								'kode3'	   	=> $kode3,
								'kode4'	   	=> $kode4,
								'kode5'	   	=> $kode5,
								'kode6'	   	=> $kode6,
								'c1'	   		=> $c1,
								'c2'	  	 	=> $c2,
								'c3'	   		=> $c3,
								'c4'	  	 	=> $c4,
								 
								 ]);						 
								 
        }
		
    }	
	
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->getAuthManager()->remove($model->item);
        MenuHelper::invalidate();

        return $this->redirect(['index']);
    }


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
    public function actionSearchxx($id, $target, $term = '')
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



    public function actionGetkabupaten(){
		if (Yii::$app->request->isAjax) {
			$model = new InstansiSearch;
			$hasil = $model->getKabupaten(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $hasil;
		}    
	}
	
	
	    public function actionGetjenis(){
		if (Yii::$app->request->isAjax) {
			$model = new InstansiSearch;
			$hasil = $model->getJenis(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $hasil;
		}    
	}
	
	
	
	
	
	
}