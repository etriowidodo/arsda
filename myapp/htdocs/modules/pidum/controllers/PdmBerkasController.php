<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\MsPenyidik;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\MsTersangkaSearch;
use yii\web\Session;
use app\modules\pidum\models\PdmBerkas;
use app\modules\pidum\models\PdmStatusSurat;
use app\modules\pidum\models\PdmP24;
use app\modules\pidum\models\PdmBerkasSearch;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmRp9;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTahananPenyidik;
use app\modules\pidum\models\PdmTrxPemrosesan;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PdmBerkasController implements the CRUD actions for PdmBerkas model.
 */
class PdmBerkasController extends Controller
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
     * Lists all PdmBerkas models.
     * @return mixed
     */
    public function actionIndex()
    {
		
		 $session = new Session();
         $id_perkara = $session->get('id_perkara');
        // no need index page so redirect to update
        //return $this->redirect(['update']);
		
         $searchModel = new PdmBerkasSearch();
             $dataProvider = $searchModel->searchTersangka3($id_perkara,Yii::$app->request->queryParams);

       return $this->render('index', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
         ]);
    }

    /**
     * Displays a single PdmBerkas model.
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
     * Creates a new PdmBerkas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::CekBerkas ]);
         $session = new Session();

        $id = $session->get('id_perkara');

        $model = $this->findModel($id);
 $model = new PdmBerkas();
      $modelp24 = new Pdmp24(); 
//var_dump ($model);exit;

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);
       // $modelTersangka = MsTersangka::find()
                       //                 ->where('id_perkara=:id_perkara AND flag <>:flag order by no_urut', [':id_perkara' => $id, ':flag' => '3'])
                       //                 ->all();
    $modelTersangka = MsTersangka::find()
				    ->select('a.id_tersangka as id, a.nama as nama,a.id_perkara')
                    ->from('pidum.ms_tersangka a')
					->join ('left join','pidum.pdm_tahanan_penyidik b','a.id_perkara = b.id_perkara AND a.id_tersangka = b.id_tersangka')
                    ->where(" a.id_perkara = '".$id."' AND b.id is null ")
                    ->all();
					
		//print_r($modelTersangka);exit;
        $modelPasal = '';
        $modelRp9 = PdmRp9::findOne(['id_perkara' => $id]);
        $modelTahananPenyidik = $this->findModelTahananPenyidik($id);

        $searchModelTersangka = new \app\modules\pidum\models\MsTersangkaSearch();
        $dataProviderTersangka = $searchModelTersangka->searchTersangka($id);
		//var_dump($dataProviderTersangka);
        $dataProviderTersangka->pagination = ['defaultPageSize' => 10];

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
			
			  // Danar Wido 27-07-2016 SPDP 86
					$UpdateTempatKejadian = Yii::$app->db->createCommand("UPDATE pidum.pdm_spdp SET tempat_kejadian = '".$_POST['PdmSpdp']['tempat_kejadian']."' WHERE id_perkara = '".$model->id_perkara."' ");
                    $UpdateTempatKejadian->execute();
			 // END Danar Wido 27-07-2016
			 
			
			$jml_is_akhir = Yii::$app->db->createCommand(" select count(*) from pidum.pdm_status_surat where id_sys_menu = 'CekBerkas' and id_perkara='".$id."' ")->queryScalar();
			if($jml_is_akhir < 1){
				Yii::$app->globalfunc->getSetStatusProcces($id, GlobalConstMenuComponent::CekBerkas);
				Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='0' WHERE (id_sys_menu = 'SPDP' OR id_sys_menu = 'P-16' OR id_sys_menu = 'T-4' OR id_sys_menu = 'T-5'  OR id_sys_menu = 'P-17'  ) AND id_perkara=:id")
					->bindValue(':id', $id)
					->execute();
			}
         
                $seq2 = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_berkas', 'id_berkas', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
				
			
                $model->id_perkara = $id;
			    $model->id_berkas = $seq2['generate_pk'];
					
		
					//print_r($model);
					//print_r($modelp24);exit;
					
				if(!$model->save()){
					var_dump($model->getErrors());exit;
					 $alert_script =  "<script>alert('tanggal terima sudah ada pada berkas ini') 
					 window.location= '/pidum/pdm-berkas/create'
					 </script>";
					//print_r ($model->getErrors());
					ECHO $alert_script;
					
				}
				else
				{ 
				$modelSpdpUpdate = Yii::$app->request->post('PdmSpdp');
                $modelSpdp->no_reg = $modelSpdpUpdate["no_reg"];
                $modelSpdp->save();

	
             
	
                   //var_dump($model);exit;
                   $NextProcces = array(ConstSysMenuComponent::CekBerkas);
                   Yii::$app->globalfunc->getNextProcces($model->id_perkara,$NextProcces); 
              

                $undang = $_POST['undang'];

                if(isset($undang)){
                    for($i=0;$i<count($undang);$i++){

                        $pdmPasal1 = new PdmPasal();

                        $seqPasal = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_pasal', 'id_pasal', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

                        $pdmPasal1->id_pasal = $seqPasal['generate_pk'];
                        $pdmPasal1->id_perkara = $id;
                        $pdmPasal1->undang = $_POST['undang'][$i];
                        $pdmPasal1->pasal = $_POST['pasal'][$i];
                        $pdmPasal1->save();
						//var_dump($pdmPasal1);exit;
                    }
                }
				$tahanan =$_POST['id_tersangka'];
				$test = $_POST['loktah'];
						$test2 = $_POST['lokasi'];
						$test3 = $_POST['tglmulai'];
						$test4 = $_POST['tglselesai'];
						 if(!empty($tahanan)){
                   PdmTahananPenyidik::deleteAll(['id_perkara' => $model->id_perkara,'id_tersangka' => $modelTahananPenyidik->id_tersangka]);
                    $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tahanan_penyidik', 'id', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

             
                    for ($i = 0; $i < count($tahanan); $i++) {
                        $modelTahananPenyidik1 = new PdmTahananPenyidik();
	//print_r($model);
//var_dump($seq2);exit;
                        $seqTahananPenyidik = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tahanan_penyidik', 'id', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
//var_dump($seqTahananPenyidik);exit;
                        $modelTahananPenyidik1->id = $seqTahananPenyidik['generate_pk'];
                        $modelTahananPenyidik1->id_perkara = $id;
                        $modelTahananPenyidik1->id_tersangka = $tahanan[$i];
						 $modelTahananPenyidik1->id_berkas = $seq2['generate_pk'];;
                        $modelTahananPenyidik1->id_msloktahanan = $test[$i];
                        $modelTahananPenyidik1->tgl_mulai = $test3[$i];
                        $modelTahananPenyidik1->tgl_selesai = $test4[$i];
                        $modelTahananPenyidik1->lokasi_rutan = !empty($test2[$i]) ? $test2[$i]: NULL ;
                       $modelTahananPenyidik1->save();
					    //var_dump($seq2);exit;
						//print_r($modelTahananPenyidik1);exit;

				
					}	
                }
				 $hapusPasal = $_POST['hapus_undang_pasal'];
                
                if(isset($hapusPasal)){
                	for($a=0;$a<count($hapusPasal);$a++){
                		//\app\modules\pidum\models\PdmPasal::deleteAll(['id_pasal' => $hapusPasal[$a]]);
                		$pasal = Yii::$app->db->createCommand("DELETE FROM pidum.pdm_pasal WHERE id_pasal='$hapusPasal[$a]'");
                		$pasal->execute();
                		
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
			}
	        
               // print_r($model);
//print_r($seq2);exit;
           //     var_dump($seq2);exit;
               // $modelTahananPenyidik = Yii::$app->request->post('PdmTahananPenyidik');
		//	var_dump($modelTahananPenyidik);exit;

//var_dump($tahanan);exit;
               

                /* $trxPemroresan = PdmTrxPemrosesan::findOne(['id_perkara' => $id]);
                $trxPemroresan->id_perkara = $id;
                $trxPemroresan->id_sys_menu = "29";
                $trxPemroresan->id_user_login = Yii::$app->user->identity->username;
                $trxPemroresan->update(); */
                
               
            /*catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['index']);
            }*/
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelSpdp' => $modelSpdp,
                'modelRp9' => $modelRp9,
                'modelTersangka' => $modelTersangka,
                'dataProviderTersangka' => $dataProviderTersangka,
                'modelTahananPenyidik' => $modelTahananPenyidik,
                'modelPasal' => $modelPasal,
                'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmBerkas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {	
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::CekBerkas ]);
        $id2 = Yii::$app->session->get('id_perkara');
		
        $model = PdmBerkas::findOne(['id_perkara' => $id2 ,'id_berkas' => $id]);

  //var_dump($id2);exit;
        if($model == null){
            $model = new PdmBerkas();
        }


        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $model->id_perkara]);
      //  $modelTersangka = MsTersangka::find()
        //                                ->where('id_perkara=:id_perkara AND flag <>:flag order by no_urut', [':id_perkara' => $id, ':flag' => '3'])
          //                              ->all();
    $modelTersangka = MsTersangka::find()->select('tsk.id as id,tersangka.id_tersangka as id_tersangka, tersangka.nama as nama,tsk.id_perkara,tsk.id_berkas as id_berkas')
                    ->from('pidum.pdm_tahanan_penyidik tsk,pidum.ms_tersangka tersangka')
                    ->where("tsk.id_tersangka = tersangka.id_tersangka and tsk.id_perkara = '".$id2."' and tsk.id_berkas='".$id."' and tsk.flag != '3' order by tsk.id ")
                    ->all();
//var_dump($modelTersangka->id_tersangka);exit;
        
		
	  $modelPasal = PdmPasal::findAll(['id_perkara' => $id2]);
        $modelRp9 = PdmRp9::findOne(['id_perkara' => $id2]);
    //$modelTahananPenyidik2 = $this->findModelTahananPenyidik($id,$id2);
		     $modelTahananPenyidik2 = PdmTahananPenyidik::findOne(['id_perkara' => $id2 ,'id_berkas' => $id]);
			 $id3=$modelTahananPenyidik2->id;
		     //$modelTahananPenyidik = PdmTahananPenyidik::findAll(['id'=>$modelTahananPenyidik2->id]);
			 
			    $modelTahananPenyidik = PdmTahananPenyidik::find()
				    ->select('tsk.id as id,
   tersangka.id_tersangka AS id_tersangka,
   tersangka.nama AS nama,
   tsk.id_perkara,
   tsk.id_berkas AS id_berkas,
   tsk.id_msloktahanan AS id_msloktahanan,
   tsk.tgl_mulai,
   tsk.tgl_selesai,
   tsk.lokasi_rutan')
                    ->from('pidum.pdm_tahanan_penyidik tsk,
   pidum.ms_tersangka tersangka')
                    ->where("tsk.id_tersangka = tersangka.id_tersangka and  tsk.id_perkara='".$id2."' and tsk.id_berkas='".$id."' order by tsk.id")
                    ->all();
						//echo count($modelTahananPenyidik);exit;
				 	//var_dump($modelTahananPenyidik);exit;    
					 $modelTahananPenyidikBks = PdmTahananPenyidik::find()
										->select('tersangka.id_tersangka as id_tersangka, tersangka.nama as nama,tsk.id_perkara,tsk.id_berkas as id_berkas,tsk.id_msloktahanan
										,tsk.tgl_mulai,tsk.tgl_selesai,tsk.lokasi_rutan')
										->from('pidum.ms_tersangka tersangka, pidum.pdm_tahanan_penyidik tsk')
										->where("tsk.id_tersangka = tersangka.id_tersangka and tsk.id_perkara = '".$id2."' and tsk.id_berkas='".$id."'")
										->all();
					// $modelTahananPenyidik1 = PdmTahananPenyidik::findOne(['id_perkara' => $id]);
				// var_dump($modelTahananPenyidik1);exit;
//print_r($modelSpdp);
//var_dump($modelTahananPenyidikBks);exit;
      
	  $searchModelTersangka = new \app\modules\pidum\models\MsTersangkaSearch();
        $dataProviderTersangka = $searchModelTersangka->searchTersangka($id2);
        $dataProviderTersangka->pagination = ['defaultPageSize' => 10];

        if ($model->load(Yii::$app->request->post())) {
		
            $transaction = Yii::$app->db->beginTransaction();
            try{
				
			
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_berkas', 'id_berkas', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                
              //  $modelSpdpUpdate = Yii::$app->request->post('PdmSpdp');
               // $modelSpdp->no_reg = $modelSpdpUpdate["no_reg"];
               // $modelSpdp->update();

              $idkirim=$_POST['PdmBerkas'];
			  // Danar Wido 27-07-2016 SPDP 86
					$UpdateTempatKejadian = Yii::$app->db->createCommand("UPDATE pidum.pdm_spdp SET tempat_kejadian = '".$_POST['PdmSpdp']['tempat_kejadian']."' WHERE id_perkara = '".$model->id_perkara."' ");
                    $UpdateTempatKejadian->execute();
			 // END Danar Wido 27-07-2016
			 
			   $model->no_pengiriman = $idkirim['no_pengiriman'];
			   $model->tgl_terima = $idkirim['tgl_terima'];
			    $model->tgl_pengiriman = $idkirim['tgl_pengiriman'];
                   // $model->id_perkara = $id;
                   // $model->id_berkas = $seq['generate_pk'];
                    $model->update();
                   // print_r ($model);exit;
                    $NextProcces = array(ConstSysMenuComponent::P24);
                    Yii::$app->globalfunc->getNextProcces($model->id_perkara,$NextProcces); 
                   
				   $tsk = $_POST['id_tersangka'];
				$nama = $_POST['nama_tersangka'];
          
			

                $undang = $_POST['undang'];

                if(isset($undang)){
                    for($i=0;$i<count($undang);$i++){

                        $pdmPasal1 = new PdmPasal();

                        $seqPasal = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_pasal', 'id_pasal', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

                        $pdmPasal1->id_pasal = $seqPasal['generate_pk'];
                        $pdmPasal1->id_perkara = $id2;
                        $pdmPasal1->undang = $_POST['undang'][$i];
                        $pdmPasal1->pasal = $_POST['pasal'][$i];
                        $pdmPasal1->update();
                    }
                }
                	$idtsk=$_POST['id_tersangka'];
				$test = $_POST['loktah'];
						$test2 = $_POST['lokasi'];
						$test3 = $_POST['tglmulai'];
						$test4 = $_POST['tglselesai'];
//	var_dump($idtsk);		
//var_dump($test2);
//var_dump($test);exit;

				//	echo count($idtsk);
			//		var_dump ($idtsk[1]);exit;
               // $modelTahananPenyidik1 = PdmTahananPenyidik::findall(['id_berkas'=>$id,'id_perkara'=>$id2,'id_tersangka'=>$idtsk]);
							$idhapus = $_POST['nama_update'];
//var_dump($idhapus);exit;
			if(!empty($idhapus)){
              
                for($a=0;$a<count($idhapus);$a++){
                    $tersangka = Yii::$app->db->createCommand("UPDATE pidum.pdm_tahanan_penyidik SET id_berkas = '' WHERE id_tersangka = '$idhapus[$a]'");
                    $tersangka->execute();
				//	var_dump($tersangka);exit;
				
			
                }
            }
if(!empty($idtsk)){
                 PdmTahananPenyidik::deleteAll(['id_perkara' => $model->id_perkara,'id_tersangka'=>$modelTahananPenyidik->id_tersangka]);

                
				              //  $modelTahananPenyidik->id_tersangka = $modelTahananPenyidikupdate["id_tersangka"];

                    $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_perpanjangan_tahanan', 'id', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
					
					
$modelTahananPenyidikupdate = Yii::$app->request->post('PdmTahananPenyidik');

                    for ($i = 0; $i < count($idtsk); $i++) {

						$modelTahananPenyidik1 = new PdmTahananPenyidik();
$modelTahananPenyidik2 = PdmTahananPenyidik::find()
                ->where("id_perkara='".$id2."' and id_berkas='".$id."' and id_tersangka='".$idtsk[$i]."' order by id")
               ->one();
//echo $i;
//var_dump($modelTahananPenyidik2->id_tersangka);//exit;	
//print_r($modelTahananPenyidikupdate[0]);	echo '<br>';
//print_r($modelTahananPenyidikupdate[1]);	echo '<br>';
//print_r($modelTahananPenyidikupdate[2]);	echo '<br>';exit;

	if($idtsk[$i]!=$modelTahananPenyidik2->id_tersangka){  
 	$seqTahananPenyidik = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tahanan_penyidik', 'id', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

                        $modelTahananPenyidik1->id = $seqTahananPenyidik['generate_pk'];
                       $modelTahananPenyidik1->id_perkara = $id2;
                   $modelTahananPenyidik1->id_tersangka = $idtsk[$i];
				   		 $modelTahananPenyidik1->id_berkas = $id;
                       $modelTahananPenyidik1->id_msloktahanan = $test[$i];
                    $modelTahananPenyidik1->tgl_mulai = $test3[$i];
                 $modelTahananPenyidik1->tgl_selesai = $test4[$i];
				 $modelTahananPenyidik1->flag = '1';
                        $modelTahananPenyidik1->lokasi_rutan = !empty($test2[$i]) ? $test2[$i] : NULL ;
                    $modelTahananPenyidik1->save();
					
					//print_r ($modelTahananPenyidik1);exit;
					}else{   $seqTahananPenyidik = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tahanan_penyidik', 'id', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
//var_dump($seqTahananPenyidik);exit;

 // print_r ($modelTahananPenyidikupdate[3]['id_msloktahanan']);echo '<br>';
                       // $modelTahananPenyidik1->id = $seqTahananPenyidik['generate_pk'];
                     //  $modelTahananPenyidik1->id_perkara = $id2;
                 //  $modelTahananPenyidik1->id_tersangka = $idtsk[$i];
				   //		 $modelTahananPenyidik1->id_berkas = $id;
                       $modelTahananPenyidik2->id_msloktahanan = $modelTahananPenyidikupdate[$i]['id_msloktahanan'];
                      $modelTahananPenyidik2->tgl_mulai = $modelTahananPenyidikupdate[$i]['tgl_mulai'];
                       $modelTahananPenyidik2->tgl_selesai = $modelTahananPenyidikupdate[$i]['tgl_selesai'];
					   		 $modelTahananPenyidik2->flag = '1';
                        $modelTahananPenyidik2->lokasi_rutan = !empty($modelTahananPenyidikupdate[$i]['lokasi_rutan']) ? $modelTahananPenyidikupdate[$i]['lokasi_rutan'] : NULL ;
                    $modelTahananPenyidik2->update();
					}
					
;
		
				//print_r ($modelTahananPenyidik1);echo '<br>';
                   // print_r ($modelTahananPenyidik2->id_msloktahanan);echo '<br>';
					}//exit;
                }

                /* $trxPemroresan = PdmTrxPemrosesan::findOne(['id_perkara' => $id]);
                $trxPemroresan->id_perkara = $id;
                $trxPemroresan->id_sys_menu = "29";
                $trxPemroresan->id_user_login = Yii::$app->user->identity->username;
                $trxPemroresan->update(); */
                
                $hapusPasal = $_POST['hapus_undang_pasal'];
                
                if(isset($hapusPasal)){
                	for($a=0;$a<count($hapusPasal);$a++){
                		//\app\modules\pidum\models\PdmPasal::deleteAll(['id_pasal' => $hapusPasal[$a]]);
                		$pasal = Yii::$app->db->createCommand("DELETE FROM pidum.pdm_pasal WHERE id_pasal='$hapusPasal[$a]'");
                		$pasal->execute();
                		
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
            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['update']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelSpdp' => $modelSpdp,
                'modelRp9' => $modelRp9,
                'modelTersangka' => $modelTersangka,
                'dataProviderTersangka' => $dataProviderTersangka,
                'modelTahananPenyidik' => $modelTahananPenyidik,
                'modelPasal' => $modelPasal,
                'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Deletes an existing PdmBerkas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
		$id = $_POST['hapusIndex'];
		$session = new Session();
		$id_perkara = $session->get('id_perkara');
		$total = Yii::$app->db->createCommand(" select count(*) as total from pidum.pdm_berkas where id_perkara='".$id_perkara."' ")->queryOne();  

		$connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
			if($total['total'] <= 1){ // jika data berkas hanya diajukan sekali
				 PdmStatusSurat::deleteAll(['id_perkara' => $id_perkara,'id_sys_menu'=>'CekBerkas']);
				 Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='1' WHERE (id_sys_menu = 'P-16' OR id_sys_menu = 'T-4' OR id_sys_menu = 'T-5') AND id_perkara=:id")
					->bindValue(':id', $id_perkara)
					->execute();
			}
			if($id == "all"){ 
				PdmBerkas::deleteAll(['id_perkara' => $id_perkara]);
				PdmTahananPenyidik::deleteAll(['id_perkara' => $id_perkara]);
				
				Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='1' WHERE (id_sys_menu = 'P-16' OR id_sys_menu = 'T-4' OR id_sys_menu = 'T-5') AND id_perkara=:id")
					->bindValue(':id', $id_perkara)
					->execute();
			}else{
				
			   for ($i = 0; $i < count($id); $i++) {
				   
				   PdmBerkas::deleteAll(['id_berkas' => $id[$i]]);
				   PdmTahananPenyidik::deleteAll(['id_berkas' => $id[$i]]);
				  
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
	
	public function actionCetak($id){
		$connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."web/template/pidum/checklist.odt");
		  $id2 = Yii::$app->session->get('id_perkara');
		
        $spdp = PdmSpdp::findOne(['id_perkara' => $id2]);
        $pdm_berkas = PdmBerkas::findOne(['id_perkara' => $id2]);
		 $modelTersangka = MsTersangka::find()->select('tsk.id as id,tersangka.id_tersangka as id_tersangka, tersangka.nama as nama,tsk.id_perkara,tsk.id_berkas as id_berkas')
                    ->from('pidum.pdm_tahanan_penyidik tsk,pidum.ms_tersangka tersangka')
                    ->where("tsk.id_tersangka = tersangka.id_tersangka and tsk.id_perkara = '".$id2."' and tsk.id_berkas='".$id."' and tsk.flag != '3' order by tsk.id ")
                    ->all();
				
       /*  #list Tersangka
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
		$odf->setVars('nama_tersangka', $dft_tersangka);  
			 
	       # tersangka
        $dft_tersangka ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.ms_tersangka')
                ->where("id_tersangka='".$id."'");
        $data = $query->createCommand();
        $listTersangka = $data->queryAll();  
        foreach($listTersangka as $key){			
            $dft_tersangka .= $key[nama].',';
        }  
		 */

		# jpu peneliti
        $dft_jaksa_saksi ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_jaksa_saksi')
                ->where("code_table = '" . GlobalConstMenuComponent::P16 . "' AND id_perkara='".$id2."'");
        $data = $query->createCommand();
        $listJaksaSaksi = $data->queryOne();

		/*
        # penyidik
        $dft_penyidik ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.ms_penyidik')
                ->where("id_penyidik='".$id."'");
        $data = $query->createCommand();
        $listPenyidik = $data->queryAll();  
        foreach($listPenyidik as $key){			
            $dft_penyidik .= $key['nama'].',';
        }
        $odf->setVars('nama', $dft_penyidik);   */
		/*  # jaksa_saksi
        $sql ="SELECT jaksa_saksi.* FROM "
                . " pidum.pdm_berkas berkas LEFT OUTER JOIN pidum.pdm_jaksa_saksi jaksa_saksi ON (berkas.id_perkara = jaksa_saksi.id_perkara ) "
                . "WHERE berkas.id_perkara='".$id."'"
                . "ORDER BY id_perkara "
                . "LIMIT 1 ";
        $model = $connection->createCommand($sql);
        $tersangka = $model->queryOne();
        $odf->setVars('nama_peneliti', ucfirst(strtolower($tersangka['nama'])));    */


		$odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat( $pdm_berkas->tgl_pengiriman));
        $odf->setVars('no_berkas', $pdm_berkas->no_pengiriman);
		$odf->setVars('tgl_berkas_perkara', Yii::$app->globalfunc->ViewIndonesianFormat($pdm_berkas->tgl_terima));
		$odf->setVars('jenis_perkara','-');
		//$odf->setVars('nama_tersangka', Yii::$app->globalfunc->getListTerdakwa($spdp->id_perkara));
		$odf->setVars('disangkakan', $spdp->undang_pasal);
		$odf->setVars('masa_penyidik', '-');
		$odf->setVars('penuntutan','-');
        $odf->setVars('tgl_penyerahan', Yii::$app->globalfunc->ViewIndonesianFormat($pdm_berkas->tgl_terima));
		$odf->setVars('jam_penyerahan','-');
		$odf->setVars('jpu_peneliti', '-');
		$odf->setVars('no_rp7', '-');
        $odf->setVars('nama_peneliti', $listJaksaSaksi['nama']);
        $odf->setVars('nip_peneliti', $listJaksaSaksi['peg_nip_baru']);
		$odf->setVars('pangkat_peneliti', preg_replace("/\/ (.*)/", "", $listJaksaSaksi['pangkat']));
		$odf->setVars('waktu_peneliti', Yii::$app->globalfunc->ViewIndonesianFormat($pdm_berkas->tgl_pengiriman ));
   		
		 	 $dft_tersangkaDetail = $odf->setSegment('tersangkaDetail');
	 foreach ($modelTersangka as $element) {
	//print_r($element);exit;
	$dft_tersangkaDetail->nama_tersangka(ucfirst(strtolower($element['nama'])));
	  $dft_tersangkaDetail->merge();
	//print_r($dft_tersangkaDetail->nama_tersangka(ucfirst(strtolower($element['nama']))));exit;
	//$odf->setVars('nama_tersangka', $element['nama']);
	 }
	  $odf->mergeSegment($dft_tersangkaDetail);
		$odf->exportAsAttachedFile('checklist.odt');
	}
    /**
     * Finds the PdmBerkas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBerkas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmBerkas::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        } /*else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }


    protected function findModelTahananPenyidik($id)
    {
        if (($model = PdmTahananPenyidik::findAll(['id_berkas' => $id])) !== null ) {
            return $model;
        }
    }
	
	 protected function findModelTahananPenyidik1($id)
    {
        if (($model = PdmTahananPenyidik::findOne(['id_berkas'=>$id,'id_perkara'=>$id2,'id_tersangka'=>$idtsk])) !== null ) {
            return $model;
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
	public function actionTersangka() {
        $searchModel = new MsTersangkaSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
		 $dataProvider2 = $searchModel->search3(Yii::$app->request->queryParams);
		 $dataProvider3 = $searchModel->search4(Yii::$app->request->queryParams);
//var_dump ($dataProvider2);exit;
//echo $dataProvider['id_tersangka'];exit;
  $dataProvider->pagination->pageSize = 5;
   $dataProvider2->pagination->pageSize = 5;
	$dataProvider3->pagination->pageSize = 5;
        return $this->renderAjax('_tersangka', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
					       'dataProvider2' => $dataProvider3,
        ]);
    }
}

