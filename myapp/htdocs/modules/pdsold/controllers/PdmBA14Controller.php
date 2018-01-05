<?php 
  
namespace app\modules\pdsold\controllers; 

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

use app\modules\pdsold\models\PdmTrxPemrosesan;
use app\components\GlobalConstMenuComponent;  
use app\modules\pdsold\models\PdmT8;
use app\modules\pdsold\models\PdmBa14;
use app\modules\pdsold\models\PdmBa14Search;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmJpu;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\Msloktahanan;
use app\modules\pdsold\models\PdmTerdakwa;
use app\modules\pdsold\models\VwTerdakwa;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\MsTersangkaSearch;
use app\modules\pdsold\models\PdmSysMenu;

use app\modules\pdsold\models\PdmRp9;
use app\modules\pdsold\models\PdmRt3;

/**
 * PdmBA14Controller implements the CRUD actions for PdmBA14 model.
 */
class PdmBa14Controller extends Controller
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
     * Lists all PdmBA14 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA14 ]);
        $idPerkara = Yii::$app->session->get('id_perkara');

        $searchModel = new PdmBa14Search();
        $dataProvider = $searchModel->search($idPerkara, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmBA14 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /** '
	
     * Creates a new PdmBA14 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA14 ]);
        $model = new PdmBa14();
        $id_perkara = Yii::$app->session->get('id_perkara');

        $modeljaksi = $model->jaksaPelaksana($id_perkara);

        $modelRp9 = PdmRp9::findOne(['id_perkara' => $id_perkara]);
        

        
        $modelTersangka = $this->findModelTersangka($id_perkara);
        $modelSpdp = $this->findModelSpdp($id_perkara);      
        $modelt8 = Pdmt8::findOne(['id_perkara' => $id_perkara]);
        

        if ($model->load(Yii::$app->request->post())) {
            $Input =  Yii::$app->request->post();
            $id_tersangka = $Input['PdmBa14']['id_tersangka'];
            $modelRt3 = PdmRt3::findOne(['id_perkara' => $id_perkara, 'id_tersangka' => $id_tersangka]);    
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba14', 'id_ba14', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
            $model->id_ba14 = $seq['generate_pk'];
            $model->id_perkara =  $id_perkara;
            $model->no_reg_tahanan= (string)$modelRt3['no_urut'];
            $model->save();
            
            $jaksa_pelaksana = explode("#", $_POST['jaksa_pelaksana']); // [0] => nip, [1] => nama, [2] => jabatan, [3] => pangkat
            PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA14, 'id_table' => $model->id_ba14]);
            $modeljaksi2 = new PdmJaksaSaksi();
            $seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
            $modeljaksi2->id_perkara = $model->id_perkara;
            $modeljaksi2->id_jpp = $seqJpu['generate_pk'];
            $modeljaksi2->code_table = GlobalConstMenuComponent::BA14;
            $modeljaksi2->id_table = $model->id_ba14;
            $modeljaksi2->nip = $jaksa_pelaksana[0];
            $modeljaksi2->nama = $jaksa_pelaksana[1];
            $modeljaksi2->jabatan = $jaksa_pelaksana[2];
            $modeljaksi2->pangkat = $jaksa_pelaksana[3];
            $modeljaksi2->save();
                    
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
                'modelTersangka' => $modelTersangka,
                'modelSpdp' => $modelSpdp,
                'modeljaksi' => $modeljaksi, 
                'sysMenu' => $sysMenu,
                'modelRp9' =>$modelRp9,
            ]);
        }
    }

    /**
     * Updates an existing PdmBA14 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_ba14)
    { 
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA14 ]);
		
        $model = $this->findModel($id_ba14);
        if($model == null){
            $model = new PdmBa14();
        }

        $modeljaksiChoosen = PdmJaksaSaksi::findOne(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA14, 'id_table' => $model->id_ba14]);

        $modeljaksi = $model->jaksaPelaksana($model->id_perkara);

        $modelRp9 = PdmRp9::findOne(['id_perkara' => $model->id_perkara]);
        $modelRt3 = PdmRt3::findOne(['id_perkara' => $model->id_perkara, 'id_tersangka' => $model->id_tersangka]);

        $modelTersangka = $this->findModelTersangka($model->id_perkara);
        $modelSpdp = $this->findModelSpdp($model->id_perkara);		
		$modelt8 = Pdmt8::findOne(['id_perkara' => $model->id_perkara]);

        if ($model->load(Yii::$app->request->post())) {
            $model->flag = '2';
            $model->update();
				
            PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA14, 'id_table' => $model->id_ba14]);
            
            $jaksa_pelaksana = explode("#", $_POST['jaksa_pelaksana']); // [0] => nip, [1] => nama, [2] => jabatan, [3] => pangkat
            
            $modeljaksi2 = new PdmJaksaSaksi();
            $seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

            $modeljaksi2->id_perkara = $model->id_perkara;
            $modeljaksi2->id_jpp = $seqJpu['generate_pk'];
            $modeljaksi2->code_table = GlobalConstMenuComponent::BA14;
            $modeljaksi2->id_table = $model->id_ba14;
            $modeljaksi2->nip = $jaksa_pelaksana[0];
            $modeljaksi2->nama = $jaksa_pelaksana[1];
            $modeljaksi2->jabatan = $jaksa_pelaksana[2];
            $modeljaksi2->pangkat = $jaksa_pelaksana[3];
            $modeljaksi2->save();

           
			
			//notifkasi simpan
			Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Diubah', // String
                'title' => 'Ubah Data', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);
			
			return $this->redirect(['index']);
			
			} else {
            return $this->render('update', [
                'model' => $model,
				'modelTersangka' => $modelTersangka,
				'modelSpdp' => $modelSpdp,
				'searchJPU' => $searchJPU,
				'dataJPU' => $dataJPU,
                'modeljaksi' => $modeljaksi,
				'modeljaksiChoosen' => $modeljaksiChoosen,
                'sysMenu' => $sysMenu,
                'modelRp9' =>$modelRp9,
				]);
        }
    }
	
	 public function actionJpu()
    {
    	$searchModel = new VwJaksaPenuntutSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$dataProvider->pagination->pageSize=10;
    	return $this->renderAjax('jpu_', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }


    /**
     * Deletes an existing PdmBA14 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        try{
            $id = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id_perkara = $session->get('id_perkara');

                PdmBa13::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                    $model = $this->findModel($id[$i]);
                    $model->flag = '3';
                    $model->update();
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
        }catch (Exception $e){
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

	public function actionCetak($id){
		
		$connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/ba14.odt");
		
		$BA14 = PdmBa14::findOne(['id_ba14' => $id]);
		$t8= PdmT8::findOne(['id_perkara'=>$BA14->id_perkara]);
                $spdp = PdmSpdp::findOne(['id_perkara' => $BA14->id_perkara]);
		$msloktahanan= Msloktahanan::findOne(['id_loktahanan'=>$BA14->id_ms_loktahanan]);
		$pasal = PdmPasal::findOne(['id_perkara'=>$BA14->id_perkara]);

        $modelRp9 = PdmRp9::findOne(['id_perkara' => $BA14->id_perkara]);
        $modelRt3 = PdmRt3::findOne(['id_perkara' => $BA14->id_perkara, 'id_tersangka' => $BA14->id_tersangka]);
		
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
		$odf->setvars('hari',Yii::$app->globalfunc->GetNamaHari( $BA14->tgl_pembuatan));
		$odf->setvars('tanggal',Yii::$app->globalfunc->getTanggalBeritaAcara( $BA14->tgl_pembuatan));
		$odf->setVars('reg_tahanan', $modelRt3['no_urut']);
		$odf->setVars('reg_perkara', $modelRp9['no_urut']);
		$odf->setVars('ditahan_sejak',Yii::$app->globalfunc->ViewIndonesianFormat( $BA14->tgl_mulai_tahan));
		$odf->setVars('mulai_tgl', Yii::$app->globalfunc->ViewIndonesianFormat($t8->tgl_mulai));
		$odf->setVars('lokasi', $msloktahanan->nama);
		$odf->setVars('kepala_rutan', $BA14->kepala_rutan);
		$odf->setVars('pasal', $pasal->pasal);
		$odf->setVars('kepala_rutan', is_null($BA14->kepala_rutan)?'........................' : $BA14->kepala_rutan);

        #no surat
        $querySuratPerintah = Yii::$app
                            ->db
                            ->createCommand("SELECT t8.no_surat, t8.tgl_permohonan FROM pidum.pdm_ba14 ba14
                                INNER JOIN pidum.pdm_t8 t8 ON ba14.id_perkara = t8.id_perkara
                                WHERE ba14.id_ba14 = '$id' AND ba14.id_perkara = '$BA14->id_perkara' AND t8.flag <> '3'
                                AND t8.tgl_permohonan = (SELECT MAX(tgl_permohonan) FROM pidum.pdm_t8 WHERE id_perkara = '$BA14->id_perkara')")
                            ->queryOne();

        #isi
        $odf->setVars('kejaksaan', ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama)));
        $odf->setVars('nomor', $querySuratPerintah['no_surat']);
        $odf->setVars('tanggal_permohonan', Yii::$app->globalfunc->ViewIndonesianFormat($querySuratPerintah['tgl_permohonan']));
           
		 #tersangka
        $sql ="SELECT tersangka.* FROM "
                . " pidum.pdm_ba14 ba14 LEFT OUTER JOIN pidum.vw_tersangka tersangka ON (ba14.id_tersangka = tersangka.id_tersangka ) "
                . "WHERE ba14.id_tersangka='".$BA14->id_tersangka."' "
                . "ORDER BY id_tersangka "
                . "LIMIT 1 ";
        $sqlTersangka = $connection->createCommand($sql);
        $tersangka = $sqlTersangka->queryOne();
        $umur = Yii::$app->globalfunc->datediff($tersangka['tgl_lahir'],date("Y-m-d"));
        $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($tersangka['tgl_lahir']);        
        $odf->setVars('nama_lengkap', ucfirst(strtolower($tersangka['nama'])));       
        $odf->setVars('tempat_lahir', ucfirst(strtolower($tersangka['tmpt_lahir'])));       
        $odf->setVars('tgl_lahir', $tgl_lahir); 
        $odf->setVars('jns_kelamin', ucfirst(strtolower($tersangka['is_jkl']))); 
        $odf->setVars('warganegara', ucfirst(strtolower($tersangka['warganegara']))); 
        $odf->setVars('tmpt_tinggal', ucfirst(strtolower($tersangka['alamat']))); 
        $odf->setVars('agama', ucfirst(strtolower($tersangka['is_agama']))); 
        $odf->setVars('pekerjaan', ucfirst(strtolower($tersangka['pekerjaan']))); 
        $odf->setVars('pendidikan', ucfirst(strtolower($tersangka['is_pendidikan'])));

        #list pasal
        $dft_pasal ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_pasal')
                ->where("id_perkara='".$BA14->id_perkara."'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();  
        foreach($listPasal as $key){            
            $dft_pasal .= $key[undang].' '.$key['pasal'].',';
        }
        $dft_pasal= substr_replace($dft_pasal,"",-1);
        $odf->setVars('pasal', $dft_pasal); 
		
		#Jaksa Penerima
        $query = new Query;
        $query->select('kpeg.peg_nip_baru,jpu.nama,jabatan,pangkat ')
                ->from('pidum.pdm_jaksa_saksi jpu, kepegawaian.kp_pegawai kpeg')
                ->where(" kpeg.peg_nik = jpu.nip and jpu.id_perkara='".$BA14->id_perkara."' AND jpu.id_table = '" . $BA14->id_ba14 . "' AND jpu.code_table='".GlobalConstMenuComponent::BA14."'")
                ->orderby('jpu.no_urut');
        $dt_jaksaPenerima = $query->createCommand();
        $listjaksaPenerima = $dt_jaksaPenerima->queryAll();
        $dft_jaksaPenerima = $odf->setSegment('jaksaPenerima');
        $i=1;
        foreach($listjaksaPenerima as $element){
                $pangkat = explode('/',$element['pangkat']);
                $dft_jaksaPenerima->nama_pegawai($element['nama']);
                $dft_jaksaPenerima->nip_pegawai($element['peg_nip_baru']);
                $dft_jaksaPenerima->pangkat_pegawai($pangkat[0]);
                $dft_jaksaPenerima->merge();
            $i++;
        }
        $odf->mergeSegment($dft_jaksaPenerima);
		
		  #penanda tangan
        $sql = new Query;
        $sql->select('kpeg.peg_nip_baru,jpu.nama,jabatan,pangkat')
                ->from('pidum.pdm_jaksa_saksi jpu, kepegawaian.kp_pegawai kpeg')
                ->where(" kpeg.peg_nik = jpu.nip and jpu.id_perkara='".$BA14->id_perkara."' AND jpu.id_table = '" . $BA14->id_ba14 . "' AND jpu.code_table='".GlobalConstMenuComponent::BA14."'");
        $penandatangan = $sql->createCommand();
		$penandatangan = $penandatangan->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);       
        $odf->setVars('pangkat', preg_replace("/ \/ (.*)/", "", $penandatangan['pangkat']));
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);       
	//	 $odf->setVars('kepala_rutan', '------------------------'); 
        
		$odf->exportAsAttachedFile('ba14.odt');
		
	}
	
    /**
     * Finds the PdmBA14 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBA14 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmBa14::findOne(['id_ba14'=>$id])) !== null) {
            return $model;
        } 
    }
	
	protected function findModelTersangka($id)
    {
        if (($modelTersangka = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $modelTersangka;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
		
 protected function findModelPasal($id)
    {
        if (($model = PdmPasal::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}