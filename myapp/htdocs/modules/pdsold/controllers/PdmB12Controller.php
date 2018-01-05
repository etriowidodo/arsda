<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmB12;
use app\modules\pdsold\models\PdmB12Search;
use app\modules\pdsold\models\PdmPenandatangan;
use Jaspersoft\Client\Client;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\PdmBarangsitaanB12;

/**
 * PdmB12Controller implements the CRUD actions for PdmB12 model.
 */
class PdmB12Controller extends Controller
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
     * Lists all PdmB12 models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $id_perkara = $session->get('id_perkara');
		
        $searchModel = new PdmB12Search();
        $dataProvider = $searchModel->search($id_perkara);
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B12 ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmB12 model.
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
     * Creates a new PdmB12 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
         $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B12 ]);
		$session = new Session();
		$id = $session->get('id_perkara');
		
        
		
		$model = new PdmB12();
		
		$model2 = Yii::$app->db->createCommand("select a.*,'' as is_checked
 from pidum.pdm_ms_benda_sitaan a  ")->queryAll();
		
		

        if ($model->load(Yii::$app->request->post()) ) {
			$transaction = Yii::$app->db->beginTransaction();

            try {
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b12', 'id_b12', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

			if($model->id_perkara != null){
				$model->update();
			}else {
				$model->id_perkara = $id;
				$model->id_b12 = $seq['generate_pk'];
				$model->save();
				
				Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::B12);    
			}
				
			PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::B12]);
			if(isset($_POST['new_tembusan'])){
        		for($i = 0; $i < count($_POST['new_tembusan']); $i++){
	        		$modelNewTembusan= new PdmTembusan();
	        		$modelNewTembusan->id_table = $model->id_b12;
					$seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
	        		$modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
					$modelNewTembusan->kode_table =  GlobalConstMenuComponent::B12;
					$modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];					
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
					$modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];	        		
					$modelNewTembusan->id_perkara = $model->id_perkara;
					$modelNewTembusan->nip = null;
					$modelNewTembusan->save();
        		}
        	}
			
			PdmBarangsitaanB12::deleteAll(['id_b12' => $model->id_b12]);
			for($i=0;$i<count($_POST['id_msbendasitaan']);$i++){
				$modelBarang = new PdmBarangsitaanB12;
				$modelBarang->id_b12 = $model->id_b12;
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
            return $this->redirect(['update','id'=>$model->id_b12]);
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
     * Updates an existing PdmB12 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B12 ]);
		$session = new Session();
		$id_perkara = $session->get('id_perkara');
		
        $model = $this->findModel($id);
		
		if($model == null){
            $model = new PdmB12();
        }
		
		$model2 = Yii::$app->db->createCommand("select a.*,case when b.id_msbendasitaan is null then '' else 'checked' end as is_checked
 from pidum.pdm_ms_benda_sitaan a left join pidum.pdm_barangsitaan_b12 b on a.id = b.id_msbendasitaan and b.id_b12 = '$id' order by a.id ")->queryAll();
		
		

        if ($model->load(Yii::$app->request->post()) ) {
			$transaction = Yii::$app->db->beginTransaction();

            try {
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b12', 'id_b12', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

			if($model->id_perkara != null){
				$model->update();
			}else {
				$model->id_perkara = $id_perkara;
				$model->id_b12 = $seq['generate_pk'];
				$model->save();
				
				Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::B12);    
			}
				
			PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::B12]);
			if(isset($_POST['new_tembusan'])){
        		for($i = 0; $i < count($_POST['new_tembusan']); $i++){
	        		$modelNewTembusan= new PdmTembusan();
	        		$modelNewTembusan->id_table = $model->id_b12;
					$seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
	        		$modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
					$modelNewTembusan->kode_table =  GlobalConstMenuComponent::B12;
					$modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];					
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
					$modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];	        		
					$modelNewTembusan->id_perkara = $model->id_perkara;
					$modelNewTembusan->nip = null;
					$modelNewTembusan->save();
        		}
        	}
			
			PdmBarangsitaanB12::deleteAll(['id_b12' => $model->id_b12]);
			for($i=0;$i<count($_POST['id_msbendasitaan']);$i++){
				$modelBarang = new PdmBarangsitaanB12;
				$modelBarang->id_b12 = $model->id_b12;
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
            return $this->redirect(['update','id'=>$model->id_b12]);
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
            ]);
        }
    }

    /**
     * Deletes an existing PdmB12 model.
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
                PdmB12::deleteAll('id_perkara=:id_perkara', [':id_perkara' => $id_perkara]);
            } else {
                for ($i = 0; $i < count($id); $i++) {
                    $model = $this->findModel($id[$i])->delete();
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
     * Finds the PdmB12 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB12 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
       if (($model = PdmB12::findOne(['id_b12' => $id])) !== null) {
            return $model;
        }
    }
	
	public function actionCetak($id){

        $odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/b12.odt");
		
		$connection = \Yii::$app->db;
		$sql =" select a.* ,b.nama, c.peg_nip_baru , b.pangkat, d.nama as sifat_surat "
				. " from pidum.pdm_b12 a "
				. " inner join (select peg_nik,nama,pangkat,jabatan from pidum.pdm_penandatangan group by peg_nik,nama,pangkat,jabatan)b  "
				. " inner join kepegawaian.kp_pegawai c on b.peg_nik = c.peg_nik "
				. " on a.id_penandatangan = b.peg_nik "
				. " left join public.ms_sifat_surat d on cast(a.sifat as integer) = d.id "
				. " where a.id_b12 = '$id' ";
        $model = $connection->createCommand($sql);
        $data = $model->queryOne();
		    $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_b12 b','a.peg_nik = b.id_penandatangan')
->where ("id_b12='".$id."'")
->one(); 
		$odf->setVars('nomor', ucfirst(strtolower($data['no_surat'])));  
        $odf->setVars('sifat', ucfirst(strtolower($data['sifat_surat'])));  
        $odf->setVars('lampiran', ucfirst(strtolower($data['lampiran'])));  
        $odf->setVars('nomor_barbuk', ucfirst(strtolower('-')));  
        $odf->setVars('subjek_peneliti', ucfirst(strtolower('-')));  
		$odf->setVars('kepada', ucfirst(strtolower($data['kepada'])));  
		$odf->setVars('detail_barbuk', ucfirst(strtolower($data['barbuk'])));  
		$odf->setVars('ditempat', ucfirst(strtolower($data['di_kepada'])));  
		$odf->setVars('kejaksaan', ucfirst(strtolower(Yii::$app->globalfunc->getSatker()->inst_nama)));  
		$odf->setVars('Kejaksaan', $pangkat->jabatan);  
		$odf->setVars('nama_penandatangan', ucfirst(strtolower($data['nama'])));  
		$odf->setVars('pangkat', ucfirst(strtolower($data['pangkat'])));  
		$odf->setVars('nip_penandatangan', ucfirst(strtolower($data['peg_nip_baru']))); 
		//$odf->setVars('kondisi_barbuk', '1. Test <br/> 2. t'); 
		$odf->setVars('tanggal_ba', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_dikeluarkan'])); 
		

		#tembusan
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='".$data['id_perkara']."' AND kode_table='".GlobalConstMenuComponent::B12."'")
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
				. " pidum.pdm_barangsitaan_b12 a "
				. " inner join pidum.pdm_ms_benda_sitaan b  "
				. " on a.id_msbendasitaan = b.id "
				. " where a.id_b12='".$id."' order by a.id_msbendasitaan ";
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
