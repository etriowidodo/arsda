<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\components\ConstSysMenuComponent;
use app\modules\pdsold\models\PdmJpu;
use app\modules\pdsold\models\PdmP16;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\MsPenyidik;
use app\modules\pdsold\models\MsInstPenyidik;
use app\modules\pdsold\models\MsInstPelakPenyidikan;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmTembusanP16;
use app\modules\pdsold\models\PdmStatusSurat;
use app\modules\pdsold\models\PdmP16Search;
use app\modules\pdsold\models\PdmJaksaP16;
use app\modules\pdsold\models\PdmTrxPemrosesan;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use Jaspersoft\Client\Client;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\web\UploadedFile;
/**
 * P16Controller implements the CRUD actions for PdmP16 model.
 */
class P16Controller extends Controller {

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
     * Lists all PdmP16 models.
     * @return mixed
     */
    public function actionIndex() {
        // no need index page so redirect to update
      //  return $this->redirect(['update']);

	   $session = new Session();
         $id_perkara = $session->get('id_perkara');
//var_dump($id_perkara);exit;
       // $model = $this->findModel($id);
	$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P16]);

       $searchModel = new PdmP16Search();
       $dataProvider = $searchModel->search($id_perkara,Yii::$app->request->queryParams);
        $model = new PdmP16();
         return $this->render('index', [
            'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
		'sysMenu' => $sysMenu,
             'model'=>$model
        ]);
    }
    
    public function actionUnggah(){
        $session = new Session();
        $id=$_POST['id_p16'];
        echo "celek".$id;
        $model = $this->findModel($id);
        if ($model == null) {
            $model = new PdmP16();
        }
        $id_perkara = $session->get('id_perkara');
        $jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p16 WHERE id_perkara='".$id_perkara."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
        $files = UploadedFile::getInstance($model, 'file_upload');
        $file_lama = $model->getOldAttributes()['file_upload'];
        if ($files != false && !empty($files) ) {
            if($file_lama !=''){
            $model->file_upload = $file_lama;
            $path = Yii::$app->basePath . '/web/template/pdsold_surat/' . $file_lama;
            $files->saveAs($path);
            }else{
                $file_lama=preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
                $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
                $path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
                $files->saveAs($path);
            }
            
        }else{
            $model->file_upload = $file_lama;
        }
        
        try{
            Yii::$app->db->createCommand("Update pidum.pdm_p16 set file_upload = '".$file_lama."' where id_p16='".$id."'")->execute();
            return $this->redirect(['index']);
        }catch (Exception $e) {
            if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
    }

    /**
     * Displays a single PdmP16 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP16 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P16]);
        $session = new Session();

        $id = $session->get('id_perkara');
		$model = new PdmP16();
		$modelttd = new PdmPenandatangan();
        $modelSpdp = $this->findModelSpdp($id);
        $modelTersangka = $this->findModelTersangka($id);
        $modelPasal = $this->findModelPasal($id);
        $modelJpu = PdmJaksaP16::find()->where(['id_perkara' => $id, 'id_p16' => $model->id_p16])->orderBy('no_urut asc')->all();

        $searchModelTersangka = new \app\modules\pidum\models\MsTersangkaSearch();
        $dataProviderTersangka = $searchModelTersangka->searchTersangka($id);
        $dataProviderTersangka->pagination = ['defaultPageSize' => 10];

        if ($modelPasal == null) {
            $modelPasal = new PdmPasal();
        }

		$tgl_max = PdmP16::findOne(['id_perkara' => $id])->tgl_dikeluarkan;


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
			$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p16 WHERE id_perkara='".$id."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
            //CMS_PIDUM00-EtrioWidodo -Create

            $trim = explode('-',$_POST['tgl_dikeluarkan-pdmp16-tgl_dikeluarkan']);
            $tgl = $trim[2].'-'.$trim[1].'-'.$trim[0];
            //CMS_PIDUM00-EtrioWidodo -Create
            //$tgl = $_POST['tgl_dikeluarkan-pdmp16-tgl_dikeluarkan'];
            //echo $tgl;exit;
			$nop16 = str_replace("'","''",$model->no_surat);
            $seq = Yii::$app->db->createCommand("select public.generate_pk_perkara('pidum.pdm_p16', 'id_p16', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" .$nop16. "')")->queryOne();

			if($_POST['hdn_nama_penandatangan'] != ''){
				$model->nama = $_POST['hdn_nama_penandatangan'];
				$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
				$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
			}

                $model->id_perkara = $id;
                $model->id_p16 = $seq['generate_pk_perkara'];
				$model->tgl_dikeluarkan = $tgl;
        $files = UploadedFile::getInstance($model, 'file_upload');
  			$file_lama = $model->getOldAttributes()['file_upload'];
        // print_r($files);exit;
				if ($files != false && !empty($files) ) {
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
					$files->saveAs($path);
				}

                if(!$model->save()){

        					echo "P-16".var_dump($model->getErrors());exit;
        				}


			$jml_is_akhir = Yii::$app->db->createCommand(" select count(*) from pidum.pdm_status_surat where id_sys_menu = 'P-16' and id_perkara='".$id."' ")->queryScalar();
			if($jml_is_akhir < 1){
				Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::P16);
				Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='0' WHERE id_sys_menu = 'SPDP' AND id_perkara=:id")
					->bindValue(':id', $id)
					->execute();
			}

            $nip = $_POST['nip_jpu'];
            $nama = $_POST['nama_jpu'];
            $jabatan = $_POST['jabatan_jpu'];
            $pangkat = $_POST['gol_jpu'];
            $no_urut = $_POST['no_urut'];
            $nip_baru = $_POST['nip_baru'];

            if (!empty($nip)) {
                PdmJaksaP16::deleteAll(['id_perkara' => $model->id_perkara, 'id_p16' => $model->id_p16]);
                for ($i = 0; $i < count($nip); $i++) {
                    $modelJpu1 = new PdmJaksaP16();
                    $modelJpu1->id_perkara = $id;
                    $modelJpu1->id_jpp = $model->id_p16."|".($i+1);
                    $modelJpu1->id_p16 = $model->id_p16;
                    $modelJpu1->nip = $nip_baru[$i];
                    $modelJpu1->nama = $nama[$i];
                    $modelJpu1->jabatan = $jabatan[$i];
                    $modelJpu1->pangkat = $pangkat[$i];
                    $modelJpu1->no_urut = ($i+1);
                    if(!$modelJpu1->save()){
						echo "Jaksa".var_dump($modelJpu1->getErrors());exit;
					}
                }
            }

            //Insert tabel tembusan
            if (isset($_POST['new_tembusan'])) {
                PdmTembusanP16::deleteAll(['id_p16' => $model->id_p16]);
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanP16();
                    $modelNewTembusan->id_p16 = $model->id_p16;
                    $modelNewTembusan->id_tembusan = $model->id_p16."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                     if(!$modelNewTembusan->save()){
						echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
					}
                }
            }





				$transaction->commit();

				 if(isset($_POST['printToSave']))
                {
                   // $this->actionCetak($model->id_p16);
                   if($_POST['printToSave']==1)
                   {
                    echo $model->id_p16;
                   }
                   else
                    {
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
                    }

                }



            }catch (Exception $e) {
                $transaction->rollback();
				 Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('create');
            }
        } else {

            return $this->render('update', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'modelTersangka' => $modelTersangka,
                        'modelPasal' => $modelPasal,
                        'modelJpu' => $modelJpu,
                        'sysMenu' => $sysMenu,
                        'dataProviderTersangka' => $dataProviderTersangka,
                        'tgl_max' => $tgl_max
            ]);
        }

    }

    /**
     * Updates an existing PdmP16 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P16]);
        $session = new Session();

       $id_perkara = $session->get('id_perkara');
       //var_dump($id);exit;
        $model = $this->findModel($id);
        if ($model == null) {
            $model = new PdmP16();
        }

        $modelSpdp = $this->findModelSpdp($model->id_perkara);
        $modelTersangka = $this->findModelTersangka($model->id_perkara);
        $modelPasal = $this->findModelPasal($model->id_perkara);
        $modelJpu = PdmJaksaP16::find()->where(['id_p16' => $id])->orderBy('no_urut asc')->all();

        $searchModelTersangka = new \app\modules\pidum\models\MsTersangkaSearch();
        $dataProviderTersangka = $searchModelTersangka->searchTersangka($model->id_perkara);
        $dataProviderTersangka->pagination = ['defaultPageSize' => 10];

        if ($modelPasal == null) {
            $modelPasal = new PdmPasal();
        }

        if ($model->load(Yii::$app->request->post())) {
			/*$transaction = Yii::$app->db->beginTransaction();
            try{*/

			$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p16 WHERE id_perkara='".$id_perkara."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();

            if($_POST['hdn_nama_penandatangan'] != ''){
				$model->nama = $_POST['hdn_nama_penandatangan'];
				$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
				$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
			}

            $nip = $_POST['nip_jpu'];
            $nama = $_POST['nama_jpu'];
            $jabatan = $_POST['jabatan_jpu'];
            $pangkat = $_POST['gol_jpu'];
            $no_urut = $_POST['no_urut'];
            $nip_baru = $_POST['nip_baru'];


            // exit();
            //CMS_PIDUM00-EtrioWidodo -Update
			$trim = explode('-',$_POST['tgl_dikeluarkan-pdmp16-tgl_dikeluarkan']);
            $tgl = $trim[2].'-'.$trim[1].'-'.$trim[0];
            //CMS_PIDUM00-EtrioWidodo -Update

			$nop16 = str_replace("'","''",$_POST['PdmP16']['no_surat']);
            $seq = Yii::$app->db->createCommand("select public.generate_pk_perkara('pidum.pdm_p16', 'id_p16', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" .$nop16. "')")->queryOne();
			$model->id_p16 = $seq['generate_pk_perkara'];

			$files = UploadedFile::getInstance($model, 'file_upload');
			$file_lama = $model->getOldAttributes()['file_upload'];

			if ($files != false && !empty($files) ) {
				if($file_lama !=''){
					$model->file_upload = $file_lama;
					$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . $file_lama;
					$files->saveAs($path);
				}else{

					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
					$files->saveAs($path);
				}

			}else{
				$model->file_upload = $file_lama;
			}

            if(!$model->save()){
				var_dump($model->getErrors());exit;
			}


             if (!empty($nip_baru)) {
				//var_dump($nip_baru);exit;
                PdmJaksaP16::deleteAll(['id_p16' => $seq['generate_pk_perkara']]);
				//Yii::$app->db->createCommand(" DELETE FROM pidum.pdm_jaksa_p16 WHERE id_p16='".$id."' ")->execute();
				//echo " DELETE FROM pidum.pdm_jaksa_p16 WHERE id_p16='".$id."' ";exit;
                for ($i = 0; $i < count($nip_baru); $i++) {
                    $modelJpu1 = new PdmJaksaP16();
                    $modelJpu1->id_perkara = $id_perkara;
                    $modelJpu1->id_jpp = $seq['generate_pk_perkara']."|".($i+1);
                    $modelJpu1->id_p16 = $seq['generate_pk_perkara'];
                    $modelJpu1->nip = $nip_baru[$i];
                    $modelJpu1->nama = $nama[$i];
                    $modelJpu1->jabatan = $jabatan[$i];
                    $modelJpu1->pangkat = $pangkat[$i];
                    $modelJpu1->no_urut = ($i+1);
                    $modelJpu1->save();
                }

            }

            //Insert tabel tembusan
            if (isset($_POST['new_tembusan'])) {

                PdmTembusanP16::deleteAll(['id_p16' => $model->id_p16]);
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanP16();
                    $modelNewTembusan->id_p16 = $model->id_p16;
                    $modelNewTembusan->id_tembusan = $model->id_p16."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                    if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
                }
            }

			//$transaction->commit();

           if(isset($_POST['printToSave']))
                {
                   // $this->actionCetak($model->id_p16);
                   if($_POST['printToSave']==2)
                   {
                    echo $model->id_p16;
                   }
                   else
                    {
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
                    }

                }


            /*}catch (Exception $e) {
                $transaction->rollback();
				 Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('create');
            }*/
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'modelTersangka' => $modelTersangka,
                        'modelPasal' => $modelPasal,
                        'modelJpu' => $modelJpu,
                        'sysMenu' => $sysMenu,
                        'dataProviderTersangka' => $dataProviderTersangka
            ]);
        }
    }

    /**
     * Deletes an existing PdmP16 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
		$id = $_POST['hapusIndex'];

		$session = new Session();
		$id_perkara = $session->get('id_perkara');
		$total = Yii::$app->db->createCommand(" select count(*) as total from pidum.pdm_p16 where id_perkara='".$id_perkara."' ")->queryOne();

		$connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
			if($total['total'] <= 1){ // jika data p-16 hanya diajukan sekali
				 PdmP16::deleteAll(['id_p16' => $id]);
				 PdmJaksaP16::deleteAll(['id_p16' => $id]);
				 PdmStatusSurat::deleteAll(['id_perkara' => $id_perkara,'id_sys_menu'=>'P-16']);
				 Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='1' WHERE id_sys_menu = 'SPDP' AND id_perkara=:id")
					->bindValue(':id', $id_perkara)
					->execute();
			}else{
				if($id == "all"){
					PdmP16::deleteAll(['id_perkara' => $id_perkara]);
					PdmJaksaP16::deleteAll(['id_perkara' => $id_perkara]);
					 Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='1' WHERE id_sys_menu = 'SPDP' AND id_perkara=:id")
						->bindValue(':id', $id_perkara)
						->execute();
				}else{
				   for ($i = 0; $i < count($id); $i++) {
					   PdmP16::deleteAll(['id_p16' => $id[$i]]);
					   PdmJaksaP16::deleteAll(['id_p16' => $id[$i]]);

					}
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
			$transaction->commit();
		} catch(Exception $e) {
			$transaction->rollback();
		}
		return $this->redirect(['index']);
    }

    public function actionJpu() {
        $searchModel = new VwJaksaPenuntutSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
 //var_dump ($dataProvider);exit;
//echo $dataProvider['pangkat'];exit;
  $dataProvider->pagination->pageSize = 5;
        return $this->renderAjax('_jpu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

	public function actionJpu16a() {
		$id_perkara = Yii::$app->session->get('id_perkara');

        $searchModel = new VwJaksaPenuntutSearch();
        $dataProvider = $searchModel->search16a(Yii::$app->request->queryParams);
		$dataProvider->pagination->pageSize = 5;
        return $this->renderAjax('_jpu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }


	//validasi no p16
	 public function actionCekNoSuratP16()
    {
        $nop16 = str_replace(" ","",$_POST['no_surat']);
        $query = PdmP16::find()
        ->where(['REPLACE(no_surat,\' \',\'\')' => $nop16])
        ->all();
        echo count($query);
    }

	public function actionAlertSukses()
    {
        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'success',
                            'duration' => 3000,
                            'icon' => 'fa fa-users',
                            'message' => 'Transaksi Berhasil',
                            'title' => 'Simpan Data',
                            'positonY' => 'top',
                            'positonX' => 'center',
                            'showProgressbar' => true,
                        ]);
    }
    public function actionJpupenerima() {
        $searchModel = new VwJaksaPenuntutSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
		//var_dump($dataProvider);exit;
        $dataProvider->pagination->pageSize = 5;
        return $this->renderAjax('_jpupenerima', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the PdmP16 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP16 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP16::findOne(['id_p16' => $id])) !== null) {
         //var_dump($model);exit;
			return $model;
        }  /*else {
          $model= new PdmP16();
          $model->id_perkara=$id;
          $model->save();
          return $this->findModel($id);
          } */
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
			//var_dump($modelSpdp);exit;
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelTersangka($id) {
        if (($model = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
           // var_dump($model);exit;
			return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelPasal($id) {
        if (($model = PdmPasal::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $connection = \Yii::$app->db;
		  $p16 = PdmP16::findOne(['id_p16' => $id]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $p16->id_perkara]);

        # tersangkadugaan-pelanggaran
        $sql_tersangka = "SELECT DISTINCT tersangka.* FROM "
                . " pidum.pdm_p16 p16 LEFT OUTER JOIN pidum.vw_tersangka tersangka ON (p16.id_perkara = tersangka.id_perkara ) "
                . "WHERE p16.id_perkara='" . $p16->id_perkara . "' "
                . "ORDER BY id_tersangka ";
        $model_tersangka = $connection->createCommand($sql_tersangka);
        $tersangka = $model_tersangka->queryAll();
//        echo count($tersangka);exit();
        
#Jaksa Peneliti
        
        $odf = new \Odf(Yii::$app->params['report-path'] . "web/template/pdsold/p16.odt");
	//print_r($odf);exit;
        $dft_tersangkaDetail = $odf->setSegment('tersangkaDetail');

        $j = 1;
        foreach ($tersangka as $element) {
            if ($element['tgl_lahir']) {
                $umur = Yii::$app->globalfunc->datediff($tersangka[($j - 1)]['tgl_lahir'], date("Y-m-d"));
                $tgl_lahir = $umur['years'] . ' tahun / ' . Yii::$app->globalfunc->ViewIndonesianFormat($tersangka[($j - 1)]['tgl_lahir']);
            } else {
                $tgl_lahir = '-';
            }
            if (count($tersangka) > 1) {
                $dft_tersangkaDetail->urutan($j . '.');

            } else {
                $dft_tersangkaDetail->urutan('');
            }
			//CMS_PIDUM004_35 03 juni 2016 #bowo #menambahkan kondisi default ( - ) jika data null
			if ($element['tmpt_lahir'] != '') {
				$tempat_lahir = $element['tmpt_lahir'];
			} else {
				$tempat_lahir = '-';
			}
			if ($element['is_jkl'] != '') {
				$jns_kelamin = $element['is_jkl'];
			} else {
				$jns_kelamin = '-';
			}
			if ($element['warganegara'] != '') {
				$warganegara = $element['warganegara'];
			} else {
				$warganegara = '-';
			}
			if ($element['alamat'] != '') {
				$tmpt_tinggal = $element['alamat'];
			} else {
				$tmpt_tinggal = '-';
			}
			if ($element['is_agama'] != '') {
				$agama = $element['is_agama'];
			} else {
				$agama = '-';
			}
			if ($element['pekerjaan'] != '') {
				$pekerjaan = $element['pekerjaan'];
			} else {
				$pekerjaan = '-';
			}
			if ($element['is_pendidikan'] != '') {
				$pendidikan = $element['is_pendidikan'];
			} else {
				$pendidikan = '-';
			}
			//end

            $dft_tersangkaDetail->nama_lengkap($element['nama']);
			$dft_tersangkaDetail->tempat_lahir($tempat_lahir);
            $dft_tersangkaDetail->tgl_lahir(ucfirst(strtolower($tgl_lahir)));
            $dft_tersangkaDetail->jns_kelamin(ucfirst(strtolower($jns_kelamin)));
            $dft_tersangkaDetail->warganegara(ucfirst(strtolower($warganegara)));
            $dft_tersangkaDetail->tmpt_tinggal(ucfirst($tmpt_tinggal));
            $dft_tersangkaDetail->agama(ucfirst(strtolower($agama)));
            $dft_tersangkaDetail->pekerjaan($pekerjaan);
            $dft_tersangkaDetail->pendidikan($pendidikan);
            $dft_tersangkaDetail->lain_lain('-');
            $dft_tersangkaDetail->merge();
			//print_r($dft_tersangkaDetail);exit;
            $j++;
        }
        $odf->mergeSegment($dft_tersangkaDetail);
//        }else{
//            $odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/p16.odt");
//            if($tersangka[0]['tgl_lahir']){
//                $umur = Yii::$app->globalfunc->datediff($tersangka[0]['tgl_lahir'],date("Y-m-d"));
//                $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($tersangka[0]['tgl_lahir']);
//            }else{
//                $tgl_lahir = '-';
//            }
//            $odf->setVars('nama_lengkap', ucfirst(strtolower($tersangka[0]['nama'])));
//            $odf->setVars('tempat_lahir', ucfirst(strtolower($tersangka[0]['tmpt_lahir'])));
//            $odf->setVars('tgl_lahir', $tgl_lahir);
//            $odf->setVars('jns_kelamin', ucfirst(strtolower($tersangka[0]['is_jkl'])));
//            $odf->setVars('warganegara', ucfirst(strtolower($tersangka[0]['warganegara'])));
//            $odf->setVars('tmpt_tinggal', ucfirst(strtolower($tersangka[0]['alamat'])));
//            $odf->setVars('agama', ucfirst(strtolower($tersangka[0]['is_agama'])));
//            $odf->setVars('pekerjaan', ucfirst(strtolower($tersangka[0]['pekerjaan'])));
//            $odf->setVars('pendidikan', $tersangka[0]['is_pendidikan']);
//            $odf->setVars('lain_lain', '-');
//
//        }

$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p16 b','a.peg_nik = b.id_penandatangan')
->where ("id_p16='".$id."'")
->one();

//var_dump();
//exit;
//print_r($pangkat);exit;
	//bowo 01 juni 2016 #menambahkan kondisi #update 06062016 //CMS_PIDUM_P16_11 #tambahan dari pak agus => Jaksa agung muda pidum ditambah tindak #16 juni 2016 #bowo

	$kode=$spdp->wilayah_kerja;

	if ($kode=='00'){
		$odf->setVars('Kejaksaan', 'JAKSA AGUNG MUDA TINDAK PIDANA UMUM');
		$odf->setVars('kepala','');
		$odf->setVars('Kejaksaan2', 'JAKSA AGUNG MUDA TINDAK PIDANA UMUM');
		$odf->setVars('kepala2','');
	}	else {
		$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
		$odf->setVars('kepala','KEPALA');
		$odf->setVars('Kejaksaan2', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
		$odf->setVars('kepala2','KEPALA');
	}
		$odf->setVars('Kejaksaan1', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('Kejaksaan_lower', ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama)));
        $odf->setVars('nomor_print', $p16->no_surat);
        $odf->setVars('kejaksaan', $p16->jabatan);
        $odf->setVars('dikeluarkan', ucfirst(strtolower($p16->dikeluarkan)));
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($p16->tgl_dikeluarkan));
        $odf->setVars('tgl_spdp', Yii::$app->globalfunc->ViewIndonesianFormat($spdp->tgl_terima));
        $odf->setVars('asal_penyidik', ucwords(MsInstPelakPenyidikan::findOne(['kode_ipp' =>$spdp->id_penyidik])->nama));
        //$odf->setVars('asal_penyidik', ucwords(strtolower(MsInstPenyidik::findOne($spdp->id_penyidik)->nama)));

        #list Tersangka
        /*
         * NOT used
         * USING global func component (getListTerdakwa()) directly
         *
          $dft_tersangka ='';
          $query = new Query;
          $query->select('*')
          ->from('pidum.ms_tersangka')
          ->where("id_perkara='".$id."'");
          $data = $query->createCommand();
          $listTersangka = $data->queryAll();
          foreach($listTersangka as $key){
          $dft_tersangka .= $key[nama].',';
          }
          $dft_tersangka= substr_replace($dft_tersangka,"",-1);
         *
         *
         */





        $odf->setVars('tersangka', Yii::$app->globalfunc->getListTerdakwa($p16->id_perkara));

        #Jaksa Peneliti
        $query = new Query;
        $query->select('jpu.nip,jpu.nama,jpu.jabatan,jpu.pangkat')
                ->from('pidum.pdm_jaksa_p16 jpu')
                ->where("id_p16='" . $p16->id_p16 . "'") //bowo #ubah cara pengambilan jabatan dan pangkat & menambahkan filter id_table #23-05-2016
                ->orderby('no_urut');
        $dt_jaksaPeneliti = $query->createCommand();
        $listjaksaPeneliti = $dt_jaksaPeneliti->queryAll();
        
//        echo count($listjaksaPeneliti);exit();
        if (count($listjaksaPeneliti) == 1){
            $odf->setVars('seorang', "seorang");
        }else{
            $odf->setVars('seorang', "beberapa orang");
        }
        
        $dft_jaksaPeneliti = $odf->setSegment('jaksaPeneliti');
        $i = 1;
        foreach ($listjaksaPeneliti as $element) {
            $pangkat = explode('/', $element['pangkat']);
            $dft_jaksaPeneliti->urutan($i);
            $dft_jaksaPeneliti->nama_pegawai($element['nama']);
            $dft_jaksaPeneliti->nip_pegawai($element['nip']);
            $dft_jaksaPeneliti->pangkat($pangkat[0]);
            //$dft_jaksaPeneliti->jabatan($element['jabatan']);
            $dft_jaksaPeneliti->merge();
            $i++;
        }
        $odf->mergeSegment($dft_jaksaPeneliti);

        #list pasal
        $dft_pasal = '';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_pasal')
                ->where("id_perkara='" . $p16->id_perkara . "'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();
        foreach ($listPasal as $key) {
            $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
        }
        $odf->setVars('pasal', $spdp->undang_pasal);
		//$odf->setVars('pasal', empty($dft_pasal) ? $spdp->undang_pasal : preg_replace("/, $/", "", $dft_pasal)); //CMS_PIDUM_p16_13 #default pasal diambil dr spdp UU&Pasal #bowo #16 juni 2016

        #tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_p16')
                ->where("id_p16='" . $id . "'")
                ->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
		//bowo dibuat index untuk cetakan tembusan
        $i=1;
		foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($i);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
			$i++;
        }
        $odf->mergeSegment($dft_tembusan);

        #penanda tangan
		/* $ttd = PdmPenandatangan::find()
->select ("a.nama as nama,a.pangkat as pangkat,a.peg_nik as peg_nik")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p16 b','a.peg_nik = b.id_penandatangan')
->where ("id_p16='".$id."'")
->one(); */
//print_r($ttd);exit;
/*        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
              . " pidum.pdm_penandatangan a, pidum.pdm_p16 b , kepegawaian.kp_pegawai c "
              . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='" . $p16->id_perkara . "'"; */

		//bowo 30 mei 2016 #ubah pengambilan query untuk penandatangan => ditambahkan filter id_p16 dan meambahkan field peg_nip_baru
			/* $sql = "SELECT a.nama,a.pangkat,a.jabatan,a.peg_nip_baru FROM  "
              . " pidum.pdm_penandatangan a, pidum.pdm_p16 b "
              . "where a.peg_nik = b.id_penandatangan and b.id_perkara='" . $p16->id_perkara . "' and id_p16='" . $p16->id_p16 . "'"; */
			  $sql = "SELECT * FROM  "
              . " pidum.pdm_p16 "
              . "where id_perkara='" . $p16->id_perkara . "' and id_p16='" . $p16->id_p16 . "'";
			  $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        // echo '<pre>';
        // print_r($penandatangan);
        // exit;
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $pangkat = explode('/', $penandatangan['pangkat']);
        //$odf->setVars('pangkat', $penandatangan[0]);
		$odf->setVars('pangkat', $penandatangan['pangkat']);
        $odf->setVars('nip_penandatangan', $penandatangan['id_penandatangan']);


        $odf->exportAsAttachedFile('p16.odt');
    }

}
