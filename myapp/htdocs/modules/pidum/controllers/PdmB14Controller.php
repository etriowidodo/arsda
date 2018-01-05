<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmB14;
use app\modules\pidum\models\PdmB14Search;
use app\modules\pidum\models\PdmPenandatangan;
use Jaspersoft\Client\Client;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmBarangsitaanB14;
use app\modules\pidum\models\PdmJaksaSaksi;
/**
 * PdmB14Controller implements the CRUD actions for PdmB14 model.
 */
class PdmB14Controller extends Controller
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
     * Lists all PdmB14 models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $id_perkara = $session->get('id_perkara');
		
        $searchModel = new PdmB14Search();
        $dataProvider = $searchModel->search($id_perkara,Yii::$app->request->queryParams);
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B14 ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmB14 model.
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
     * Creates a new PdmB14 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B14 ]);
		$session = new Session();
		$id = $session->get('id_perkara');
		
        $model = new PdmB14();
		
		$model2 = Yii::$app->db->createCommand("select a.*,'' as is_checked
 from pidum.pdm_ms_benda_sitaan a   order by a.id ")->queryAll();
		
		
        if ($model->load(Yii::$app->request->post()) ) {
		
			$transaction = Yii::$app->db->beginTransaction();

            try {
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b14', 'id_b14', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

			if($model->id_perkara != null){
				$model->update();
			}else {
				$model->id_perkara = $id;
				$model->id_b14 = $seq['generate_pk'];
				$model->save();
				
				Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::B14);    
			}
				
			PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::B14]);
			if(isset($_POST['new_tembusan'])){
        		for($i = 0; $i < count($_POST['new_tembusan']); $i++){
	        		$modelNewTembusan= new PdmTembusan();
	        		$modelNewTembusan->id_table = $model->id_b14;
					$seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
	        		$modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
					$modelNewTembusan->kode_table =  GlobalConstMenuComponent::B14;
					$modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];					
                                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
					$modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];	        		
					$modelNewTembusan->id_perkara = $model->id_perkara;
					$modelNewTembusan->nip = null;
					$modelNewTembusan->save();
        		}
        	}
			
			
			$nip = $_POST['nip_jpu'];
	            $nama = $_POST['nama_jpu'];
	            $jabatan = $_POST['jabatan_jpu'];
	            $pangkat = $_POST['gol_jpu'];
	            $no_urut = $_POST['no_urut'];
	            $nip_baru = $_POST['nip_baru'];

                PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=>GlobalConstMenuComponent::B14, 'id_table'=>$model->id_b14]);
	            for ($i = 0; $i < count($nip); $i++) {
	            	$modelJpu1 = new PdmJaksaSaksi();
	            	$seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
	            	
	            	$modelJpu1->id_perkara = $id;
	            	$modelJpu1->id_jpp = $seqJpu['generate_pk'];
                    $modelJpu1->code_table = GlobalConstMenuComponent::B14;
                    $modelJpu1->id_table = $model->id_b14;
	            	$modelJpu1->nip = $nip[$i];
	            	$modelJpu1->nama = $nama[$i];
	            	$modelJpu1->jabatan = $jabatan[$i];
	            	$modelJpu1->pangkat = $pangkat[$i];
                    $modelJpu1->no_urut = $no_urut[$i];
                    $modelJpu1->peg_nip_baru = $nip_baru[$i];
	            	$modelJpu1->save();
	            }
			
			
			PdmBarangsitaanB14::deleteAll(['id_b14' => $model->id_b14]);
			for($i=0;$i<count($_POST['id_msbendasitaan']);$i++){
				$modelBarang = new PdmBarangsitaanB14;
				$modelBarang->id_b14 = $model->id_b14;
				$modelBarang->id_msbendasitaan = $_POST['id_msbendasitaan'][$i];
				$modelBarang->save();
			}
			
			$transaction->commit();
			 Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
            return $this->redirect(['update','id'=>$model->id_b14]);
			}catch (Exception $e) {
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
                $transaction->rollback();
            }
        } else {
			
            return $this->render('create', [
                'model' => $model,
                'model2' => $model2,
				'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Updates an existing PdmB14 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B14 ]);
		$session = new Session();
		$id_perkara = $session->get('id_perkara');
		
        $model = $this->findModel($id);
		
		if($model == null){
            $model = new PdmB14();
        }
		
		$model2 = Yii::$app->db->createCommand("select a.*,case when b.id_msbendasitaan is null then '' else 'checked' end as is_checked
 from pidum.pdm_ms_benda_sitaan a left join pidum.pdm_barangsitaan_b14 b on a.id = b.id_msbendasitaan and b.id_b14 = '$id' order by a.id ")->queryAll();
		
		$modelJpu = PdmJaksaSaksi::find()->where(['id_perkara' => $id_perkara, 'code_table' => GlobalConstMenuComponent::B14, 'id_table' => $model->id_b14])->orderBy('no_urut asc')->all();

        if ($model->load(Yii::$app->request->post()) ) {
		
			$transaction = Yii::$app->db->beginTransaction();

            try {
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b14', 'id_b14', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

			if($model->id_perkara != null){
				$model->update();
			}else {
				$model->id_perkara = $id_perkara;
				$model->id_b14 = $seq['generate_pk'];
				$model->save();
				
				Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::B14);    
			}
				
			PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::B14]);
			if(isset($_POST['new_tembusan'])){
        		for($i = 0; $i < count($_POST['new_tembusan']); $i++){
	        		$modelNewTembusan= new PdmTembusan();
	        		$modelNewTembusan->id_table = $model->id_b14;
					$seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
	        		$modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
					$modelNewTembusan->kode_table =  GlobalConstMenuComponent::B14;
					$modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];					
                                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
					$modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];	        		
					$modelNewTembusan->id_perkara = $model->id_perkara;
					$modelNewTembusan->nip = null;
					$modelNewTembusan->save();
        		}
        	}
			
			
			$nip = $_POST['nip_jpu'];
	            $nama = $_POST['nama_jpu'];
	            $jabatan = $_POST['jabatan_jpu'];
	            $pangkat = $_POST['gol_jpu'];
	            $no_urut = $_POST['no_urut'];
	            $nip_baru = $_POST['nip_baru'];

                PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=>GlobalConstMenuComponent::B14, 'id_table'=>$model->id_b14]);
	            for ($i = 0; $i < count($nip); $i++) {
	            	$modelJpu1 = new PdmJaksaSaksi();
	            	$seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
	            	
	            	$modelJpu1->id_perkara = $id_perkara;
	            	$modelJpu1->id_jpp = $seqJpu['generate_pk'];
                    $modelJpu1->code_table = GlobalConstMenuComponent::B14;
                    $modelJpu1->id_table = $model->id_b14;
	            	$modelJpu1->nip = $nip[$i];
	            	$modelJpu1->nama = $nama[$i];
	            	$modelJpu1->jabatan = $jabatan[$i];
	            	$modelJpu1->pangkat = $pangkat[$i];
                    $modelJpu1->no_urut = $no_urut[$i];
                    $modelJpu1->peg_nip_baru = $nip_baru[$i];
	            	$modelJpu1->save();
	            }
			
			
			PdmBarangsitaanB14::deleteAll(['id_b14' => $model->id_b14]);
			for($i=0;$i<count($_POST['id_msbendasitaan']);$i++){
				$modelBarang = new PdmBarangsitaanB14;
				$modelBarang->id_b14 = $model->id_b14;
				$modelBarang->id_msbendasitaan = $_POST['id_msbendasitaan'][$i];
				$modelBarang->save();
			}
			
			$transaction->commit();
			 Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
            return $this->redirect(['update','id'=>$model->id_b14]);
			}catch (Exception $e) {
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
                $transaction->rollback();
            }
        } else {
			
            return $this->render('update', [
                'model' => $model,
                'model2' => $model2,
				'sysMenu' => $sysMenu,
				'modelJpu' => $modelJpu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmB14 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
       
		
		$transaction = Yii::$app->db->beginTransaction();
        try {
            $id = $_POST['hapusIndex'];

            $session = new Session();
            $id_perkara = $session->get('id_perkara');

            if ($id === 'all') {
                PdmB14::updateAll(['flag' => '3'], 'id_perkara=:id_perkara', [':id_perkara' => $id_perkara]);
                // PdmB14::deleteAll('id_perkara=:id_perkara', [':id_perkara' => $id_perkara]);
            } else {
                for ($i = 0; $i < count($id); $i++) {
                    PdmB14::updateAll(['flag'=>'3'],'id_b14=:id_b14',[':id_b14'=>$id[$i]]);
                    // $model = $this->findModel($id[$i])->delete();
                }
            }

            $transaction->commit();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        } catch (Exception $e) {
            $transaction->rollBack();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Gagal Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the PdmB14 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB14 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
       if (($model = PdmB14::findOne(['id_b14' => $id])) !== null) {
            return $model;
        }
    }
	
	public function actionCetak($id){

        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/b14.odt");

      $connection = \Yii::$app->db;
		$sql =" select a.* ,b.nama, c.peg_nip_baru , b.pangkat, d.nip as nip_jaksa,d.nama as nama_jaksa,d.jabatan as jabatan_jaksa "
				. " from pidum.pdm_b14 a "
				. " inner join (select peg_nik,nama,pangkat,jabatan from pidum.pdm_penandatangan group by peg_nik,nama,pangkat,jabatan)b  "
				. " inner join kepegawaian.kp_pegawai c on b.peg_nik = c.peg_nik "
				. " on a.id_penandatangan = b.peg_nik "
				. " left join pidum.pdm_jaksa_saksi d on a.id_perkara = d.id_perkara and d.id_table = a.id_b14 and d.code_table = 'B-14' "
				. " where a.id_b14 = '$id' ";
        $model = $connection->createCommand($sql);
        $data = $model->queryOne();
    	    $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_b14 b','a.peg_nik = b.id_penandatangan')
->where ("id_b14='".$id."'")
->one(); 
		$odf->setVars('nomor', ucfirst(strtolower($data['no_sprint'])));  
        $odf->setVars('kejaksaan', ucfirst(strtolower(Yii::$app->globalfunc->getSatker()->inst_nama)));  
		$odf->setVars('Kejaksaan', $pangkat->jabatan);  
		$odf->setVars('subjek_kepala', ucfirst(strtolower(Yii::$app->globalfunc->getSatker()->inst_nama)));
		$odf->setVars('nama_penandatangan', ucfirst(strtolower($data['nama'])));  
		$odf->setVars('pangkat', ucfirst(strtolower($data['pangkat'])));  
		$odf->setVars('subjek_tersangka', ucfirst(strtolower('-')));  
		$odf->setVars('pasal_dilanggar', ucfirst(strtolower('-')));  
		$odf->setVars('subjek_ba', ucfirst(strtolower('-')));  
		$odf->setVars('lokasi_penetapan', ucfirst(strtolower('-')));  
		$odf->setVars('tanggal_penetapan', ucfirst(strtolower('-')));  
		$odf->setVars('subjek_jaksa', ucfirst(strtolower($data['nip_jaksa'].'/'.$data['nama_jaksa'].'/'.$data['jabatan_jaksa'])));  
		$odf->setVars('nip_penandatangan', ucfirst(strtolower($data['peg_nip_baru']))); 		
		
		#tembusan
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='".$data['id_perkara']."' AND kode_table='".GlobalConstMenuComponent::B14."'")
				->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach($listTembusan as $element){
                $dft_tembusan->urutan_tembusan($element['no_urut']);
                $dft_tembusan->nama_tembusan($element['tembusan']);
                $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);
		
		#kondisibarbuk
		
		$sql =" select b.nama from"
				. " pidum.pdm_barangsitaan_b14 a "
				. " inner join pidum.pdm_ms_benda_sitaan b  "
				. " on a.id_msbendasitaan = b.id "
				. " where a.id_b14='".$id."' order by a.id_msbendasitaan ";
        $dt_kondisibarbuk = $connection->createCommand($sql);
		
        $listKondisibarbuk = $dt_kondisibarbuk->queryAll();
        $dft_kondisibarbuk = $odf->setSegment('kondisibarbuk');
		$i = 0;
		$alfabet = array("0"=>"a","1"=>"b","2"=>"c","3"=>"d","4"=>"e","5"=>"f","6"=>"g","7"=>"h","8"=>"i","9"=>"j");
        foreach($listKondisibarbuk as $element){
                $dft_kondisibarbuk->urutan_barbuk($alfabet[$i]);
                $dft_kondisibarbuk->kondisi_barbuk($element['nama']);
                $dft_kondisibarbuk->merge();
				$i++;
        }
        $odf->mergeSegment($dft_kondisibarbuk);
		
        $odf->exportAsAttachedFile();
       
    }
}
