<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmPenetapanBarbuk;
use app\modules\pdsold\models\PdmPenetapanBarbukSurat;
use app\modules\pdsold\models\PdmPenetapanBarbukSearch;
use app\modules\pdsold\models\PdmTembusanNarkotika;
use app\modules\pdsold\models\PdmBarbukPratut;
use app\modules\pdsold\models\PdmKepentinganBarbuk;
use app\modules\pdsold\models\PdmGridSitaNarkotika;
use app\modules\pdsold\models\PdmGridSitaNarkotikaSearch;
use app\modules\pdsold\models\PdmMsSatuan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pdsold\models\VwGridPrapenuntutanSearch;
use yii\web\Session;
/**
 * PdmPenetapanBarbukController implements the CRUD actions for PdmPenetapanBarbuk model.
 */
class PdmPenetapanBarbukController extends Controller
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
     * Lists all PdmPenetapanBarbuk models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
		
        $searchModel = new PdmGridSitaNarkotikasearch();
        $dataProvider = $searchModel->search('LOL');


        //echo '<pre>';print_r($searchModel);exit;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmPenetapanBarbuk model.
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
     * Creates a new PdmPenetapanBarbuk model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
    }

    public function actionCreate()
    {

        $model = new PdmPenetapanBarbuk();
		$searchModel = new VwGridPrapenuntutanSearch();
        $dataProvider = $searchModel->searchNarkotika(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = '5';



        if ($model->load(Yii::$app->request->post()) ) {
			$transaction = Yii::$app->db->beginTransaction();
            try{
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_penetapan_barbuk', 'id_sita', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
			$model->id_sita = $_POST['PdmPenetapanBarbuk']['no_penetapan'];
			$model->id_perkara = 'ID_PERKARA';
            $model->created_ip = $this->get_client_ip();
            $model->created_by = $_SESSION['nik_user'];
			if($_POST['hdn_nama_penandatangan'] != ''){
				$model->nama = $_POST['hdn_nama_penandatangan'];
				$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
				$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
			}
			if(!$model->save()){
				var_dump($model->getErrors());exit;
			}
			
           

			$txt_nama_surat = $_POST['txt_nama_surat'];
			$txt_nomor_surat = $_POST['txt_nomor_surat'];
			$txt_tgl_surat = $_POST['txt_tgl_surat'];
			$txt_tgl_terima = $_POST['txt_tgl_terima'];
			for($i=0;$i<count($txt_nama_surat);$i++){
				$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_penetapan_barbuk_surat', 'id_penetapan_barbuk_surat', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
				
				$modelSurat = new PdmPenetapanBarbukSurat();
				$modelSurat->id_penetapan_barbuk_surat = $seq['generate_pk'];
				$modelSurat->id_sita = $model->id_sita;
				$modelSurat->nama_surat = $txt_nama_surat[$i];
				$modelSurat->no_surat = $txt_nomor_surat[$i];
				$modelSurat->tgl_surat = date('Y-m-d',strtotime(trim($txt_tgl_surat[$i])));
				if($i==2){
					$modelSurat->tgl_diterima = date('Y-m-d',strtotime(trim($txt_tgl_terima)));
				}
				if(!$modelSurat->save()){
					var_dump($modelSurat->getErrors());exit;
				}
			}
			
            $nobarbuk   = $_POST['barbuk_pratut']['nobarbuk'];
            $namabarbuk = $_POST['barbuk_pratut']['namabarbuk'];
            $jumlahbarbuk = $_POST['barbuk_pratut']['jumlahbarbuk'];
            $satuanbarbuk = $_POST['barbuk_pratut']['satuanbarbuk'];
            $pemilikbarbuk  = $_POST['barbuk_pratut']['pemilikbarbuk'];

            for($i=0;$i<count($nobarbuk);$i++){
                $modelbarbuk = new PdmBarbukPratut();
                //$modelbarbuk->id_barbuk = $seqbarbuk['generate_pk'].'-'.$nobarbuk[$i];
                $modelbarbuk->id_sita   = $model->id_sita;
                $modelbarbuk->nama      = $namabarbuk[$i];
                $modelbarbuk->jumlah    = $jumlahbarbuk[$i];
                $modelbarbuk->id_satuan = $satuanbarbuk[$i];
                $modelbarbuk->pemilik = $pemilikbarbuk[$i];
                $modelbarbuk->no = $nobarbuk[$i];
                if(!$modelbarbuk->save()){
                    var_dump($modelbarbuk->getErrors());exit;
                }
            }

            $jumlah_pembuktian  = $_POST['pdm_kepentingan_barbuk']['jumlah_pembuktian'];
            $jumlah_iptek       = $_POST['pdm_kepentingan_barbuk']['jumlah_iptek'];
            $jumlah_diklat      = $_POST['pdm_kepentingan_barbuk']['jumlah_diklat'];
            $jumlah_dimusnahkan = $_POST['pdm_kepentingan_barbuk']['jumlah_dimusnahkan'];

            $satuan_pembuktian  = $_POST['pdm_kepentingan_barbuk']['satuan_pembuktian'];
            $satuan_iptek       = $_POST['pdm_kepentingan_barbuk']['satuan_iptek'];
            $satuan_diklat      = $_POST['pdm_kepentingan_barbuk']['satuan_diklat'];
            $satuan_dimusnahkan = $_POST['pdm_kepentingan_barbuk']['satuan_dimusnahkan'];

            for($i=0;$i<count($nobarbuk);$i++){
                $seqbarbuk = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_penetapan_barbuk_surat', 'id_penetapan_barbuk_surat', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                
                $modelbarbuk = new PdmKepentinganBarbuk();
                $modelbarbuk->id_sita           = $model->id_sita;
                $modelbarbuk->jumlah_pembuktian = $jumlah_pembuktian[$i];
                $modelbarbuk->jumlah_iptek      = $jumlah_iptek[$i];
                $modelbarbuk->jumlah_diklat     = $jumlah_diklat[$i];
                $modelbarbuk->jumlah_dimusnahkan= $jumlah_dimusnahkan[$i];

                $modelbarbuk->satuan_pembuktian = $satuan_pembuktian[$i];
                $modelbarbuk->satuan_iptek      = $satuan_iptek[$i];
                $modelbarbuk->satuan_diklat     = $satuan_diklat[$i];
                $modelbarbuk->satuan_dimusnahkan= $satuan_dimusnahkan[$i];

                $modelbarbuk->no = $nobarbuk[$i];
                if(!$modelbarbuk->save()){
                    var_dump($modelbarbuk->getErrors());exit;
                }
            }


			if (isset($_POST['new_tembusan'])) {
                PdmTembusanNarkotika::deleteAll(['id_sita' => $id]);
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanNarkotika();
                    $modelNewTembusan->id_sita = $model->id_sita;
                    $modelNewTembusan->id_tembusan = $model->id_sita."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                    if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
                }
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
            return $this->redirect(['index']);
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
                    return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'dataSPDP' => $dataProvider,
                'searchSPDP' => $searchModel,
            ]);
        }
    }

    /**
     * Updates an existing PdmPenetapanBarbuk model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$searchModel = new VwGridPrapenuntutanSearch();
        $dataProvider = $searchModel->searchNarkotika(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = '5';
		
        $ss = PdmBarbukPratut::findAll(['id_sita' => $id]);
        $sql = "SELECT a.* from pidum.pdm_kepentingan_barbuk a where a.id_sita='$id'";
        $kepentingan = PdmBarbukPratut::findBySql($sql)->asArray()->all();  

		$modelSurat = PdmPenetapanBarbukSurat::findAll(['id_sita'=>$id]);

        /* echo '<pre>';
         print_r($kepentingan);
         exit;*/


        if ($model->load(Yii::$app->request->post())) {
			$transaction = Yii::$app->db->beginTransaction();
            try{
				$model->id_sita = $_POST['PdmPenetapanBarbuk']['no_penetapan'];
                 $model->updated_ip = $this->get_client_ip();
                    $model->updated_by = $_SESSION['nik_user'];
				if($_POST['hdn_nama_penandatangan'] != ''){
					$model->nama = $_POST['hdn_nama_penandatangan'];
					$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
					$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
                   
				}
				if(!$model->save()){
					var_dump($model->getErrors());exit;
				}
				
				PdmPenetapanBarbukSurat::deleteAll(['id_sita' => $model->id_sita]);
                PdmKepentinganBarbuk::deleteAll(['id_sita' => $model->id_sita]);
                PdmBarbukPratut::deleteAll(['id_sita' => $model->id_sita]);
                
				$txt_nama_surat = $_POST['txt_nama_surat'];
				$txt_nomor_surat = $_POST['txt_nomor_surat'];
				$txt_tgl_surat = $_POST['txt_tgl_surat'];
				$txt_tgl_terima = $_POST['txt_tgl_terima'];
				for($i=0;$i<count($txt_nama_surat);$i++){
					$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_penetapan_barbuk_surat', 'id_penetapan_barbuk_surat', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
					
					$modelSurat = new PdmPenetapanBarbukSurat();
					$modelSurat->id_penetapan_barbuk_surat = $seq['generate_pk'];
					$modelSurat->id_sita = $_POST['PdmPenetapanBarbuk']['no_penetapan'];
					$modelSurat->nama_surat = $txt_nama_surat[$i];
					$modelSurat->no_surat = $txt_nomor_surat[$i];
					$modelSurat->tgl_surat = date('Y-m-d',strtotime(trim($txt_tgl_surat[$i])));
					if($i==2){
						$modelSurat->tgl_diterima = date('Y-m-d',strtotime(trim($txt_tgl_terima)));
					}
					if(!$modelSurat->save()){
						var_dump($modelSurat->getErrors());exit;
					}
				}

                //$ss = PdmBarbukPratut::findAll(['id_sita' => $id]);
                //echo '<pre>';var_dump($ss);exit;      
                /*PdmKepentinganBarbuk::deleteAll(['id_sita' => $id]);
                PdmBarbukPratut::deleteAll(['id_sita' => $id]);*/
                
                
                
                //echo '<pre>';print_r($_POST);exit;
                $nobarbuk   = $_POST['barbuk_pratut']['nobarbuk'];
                $namabarbuk = $_POST['barbuk_pratut']['namabarbuk'];
                $jumlahbarbuk = $_POST['barbuk_pratut']['jumlahbarbuk'];
                $satuanbarbuk = $_POST['barbuk_pratut']['satuanbarbuk'];
                $pemilikbarbuk  = $_POST['barbuk_pratut']['pemilikbarbuk'];

                for($i=0;$i<count($nobarbuk);$i++){
                    $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_penetapan_barbuk_surat', 'id_penetapan_barbuk_surat', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    
                    $modelbarbuk = new PdmBarbukPratut();
                    //$modelbarbuk->id_barbuk = $seq['generate_pk'].'-'.$nobarbuk[$i];
                    $modelbarbuk->id_sita = $model->id_sita;
                    $modelbarbuk->nama = $namabarbuk[$i];
                    $modelbarbuk->jumlah = $jumlahbarbuk[$i];
                    $modelbarbuk->id_satuan = $satuanbarbuk[$i];
                    $modelbarbuk->pemilik = $pemilikbarbuk[$i];
                    $modelbarbuk->no = $nobarbuk[$i];
                    if(!$modelbarbuk->save()){
                        var_dump($modelbarbuk->getErrors());exit;
                    }
                }

                $jumlah_pembuktian  = $_POST['pdm_kepentingan_barbuk']['jumlah_pembuktian'];
                $jumlah_iptek       = $_POST['pdm_kepentingan_barbuk']['jumlah_iptek'];
                $jumlah_diklat      = $_POST['pdm_kepentingan_barbuk']['jumlah_diklat'];
                $jumlah_dimusnahkan = $_POST['pdm_kepentingan_barbuk']['jumlah_dimusnahkan'];

                $satuan_pembuktian  = $_POST['pdm_kepentingan_barbuk']['satuan_pembuktian'];
                $satuan_iptek       = $_POST['pdm_kepentingan_barbuk']['satuan_iptek'];
                $satuan_diklat      = $_POST['pdm_kepentingan_barbuk']['satuan_diklat'];
                $satuan_dimusnahkan = $_POST['pdm_kepentingan_barbuk']['satuan_dimusnahkan'];

                for($i=0;$i<count($nobarbuk);$i++){
                    $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_penetapan_barbuk_surat', 'id_penetapan_barbuk_surat', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    
                    $modelbarbuk = new PdmKepentinganBarbuk();
                    //$modelbarbuk->id_barbuk = $seq['generate_pk'].'-'.$nobarbuk[$i];
                    $modelbarbuk->id_sita = $model->id_sita;
                    $modelbarbuk->jumlah_pembuktian = $jumlah_pembuktian[$i];
                    $modelbarbuk->jumlah_iptek      = $jumlah_iptek[$i];
                    $modelbarbuk->jumlah_diklat     = $jumlah_diklat[$i];
                    $modelbarbuk->jumlah_dimusnahkan= $jumlah_dimusnahkan[$i];

                    $modelbarbuk->satuan_pembuktian = $satuan_pembuktian[$i];
                    $modelbarbuk->satuan_iptek      = $satuan_iptek[$i];
                    $modelbarbuk->satuan_diklat     = $satuan_diklat[$i];
                    $modelbarbuk->satuan_dimusnahkan= $satuan_dimusnahkan[$i];

                    $modelbarbuk->no = $nobarbuk[$i];
                    if(!$modelbarbuk->save()){
                        var_dump($modelbarbuk->getErrors());exit;
                    }
                }

                /*PdmBarbukPratut::deleteAll(['id_sita' => $model->id_sita]);
                $txt_nama_surat = $_POST['txt_nama_surat'];
                $txt_nomor_surat = $_POST['txt_nomor_surat'];
                $txt_tgl_surat = $_POST['txt_tgl_surat'];
                $txt_tgl_terima = $_POST['txt_tgl_terima'];
                for($i=0;$i<count($txt_nama_surat);$i++){
                    $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_penetapan_barbuk_surat', 'id_penetapan_barbuk_surat', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    
                    $modelSurat = new PdmPenetapanBarbukSurat();
                    $modelSurat->id_penetapan_barbuk_surat = $seq['generate_pk'];
                    $modelSurat->id_sita = $_POST['PdmPenetapanBarbuk']['no_penetapan'];
                    $modelSurat->nama_surat = $txt_nama_surat[$i];
                    $modelSurat->no_surat = $txt_nomor_surat[$i];
                    $modelSurat->tgl_surat = date('Y-m-d',strtotime(trim($txt_tgl_surat[$i])));
                    if($i==2){
                        $modelSurat->tgl_diterima = date('Y-m-d',strtotime(trim($txt_tgl_terima)));
                    }
                    if(!$modelSurat->save()){
                        var_dump($modelSurat->getErrors());exit;
                    }
                }
*/

			
				if (isset($_POST['new_tembusan'])) {
					PdmTembusanNarkotika::deleteAll(['id_sita' => $model->id_sita]);
					for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
						$modelNewTembusan = new PdmTembusanNarkotika();
						$modelNewTembusan->id_sita = $_POST['PdmPenetapanBarbuk']['no_penetapan'];
						$modelNewTembusan->id_tembusan = $model->id_sita."|".($i+1);
						$modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
						$modelNewTembusan->no_urut = ($i+1);
						if(!$modelNewTembusan->save()){
							var_dump($modelNewTembusan->getErrors());exit;
						}
					}
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
            return $this->redirect(['index']);
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
                    return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                'model' => $model,
				'dataSPDP' => $dataProvider,
                'searchSPDP' => $searchModel,
                'modelSurat' => $modelSurat,
                'modelBarbuk' => $ss,
                'modelKepentingan' => $kepentingan,
            ]);
        }
    }

    /**
     * Deletes an existing PdmPenetapanBarbuk model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
		$arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
            if($id_tahap=='all'){
                    $id_tahapx=PdmPenetapanBarbuk::find()->select("id_sita")->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['id_sita'];
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }


        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    PdmPenetapanBarbuk::deleteAll(['id_sita' => $delete]);
                }catch (\yii\db\Exception $e) {
                  $count++;
                }
            }
            if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  $count.' Data Berkas Tidak Dapat Dihapus Karena Sudah Digunakan Di Persuratan Lainnya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }

            return $this->redirect(['index']);
    }
    
    public function actionSatuan(){
        $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
        $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all(); 
        echo json_encode($resOpt);
    }
    /**
     * Finds the PdmPenetapanBarbuk model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmPenetapanBarbuk the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmPenetapanBarbuk::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function findBarbukPratut($id)
    {
        if (($model = PdmBarbukPratut::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

