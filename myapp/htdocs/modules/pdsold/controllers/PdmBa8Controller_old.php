<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmBa8;
use app\modules\pdsold\models\PdmBa8Search;
use Jaspersoft\Client\Client;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\PdmBarbukTambahan;
use app\modules\pdsold\models\PdmB4;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmSpdp;

/**
 * PdmBa8Controller implements the CRUD actions for PdmBa8 model.
 */
class PdmBa8Controller extends Controller
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
     * Lists all PdmBa8 models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $id_perkara = $session->get('id_perkara');
		
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA8 ]);
		
        $searchModel = new PdmBa8Search();
        $dataProvider = $searchModel->searchIndex($id_perkara);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmBa8 model.
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
     * Creates a new PdmBa8 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
         $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA8 ]);
		$session = new Session();
		$id = $session->get('id_perkara');
		
        //$model = $this->findModel($id);
		if($model == null){
            $model = new PdmBa8();
        }
		
		
		$kd_wilayah = PdmSpdp::findOne($id)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
		
		
		$queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            ->where('a.id_perkara=:id_perkara AND a.id_tersangka NOT IN (select id_tersangka from pidum.pdm_ba8 where pidum.pdm_ba8.flag<>\'3\')', [':id_perkara' => $id])->all();
			
		$modelJpu = PdmJaksaSaksi::find()->where(['id_perkara' => $id, 'code_table' => GlobalConstMenuComponent::BA8, 'id_table' => $model->id_ba8])->orderBy('no_urut asc')->all();
			
        if ($model->load(Yii::$app->request->post())) {
			$transaction = Yii::$app->db->beginTransaction();
			try {
				$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba8', 'id_ba8', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

				if($model->id_perkara != null){
					$model->update();
				}else {
					$model->id_perkara = $id;
					$model->id_ba8 = $seq['generate_pk'];
					$model->save();
					
					Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::BA8);    
				}
				
				PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::BA8]);
				if(isset($_POST['new_tembusan'])){
					for($i = 0; $i < count($_POST['new_tembusan']); $i++){
						$modelNewTembusan= new PdmTembusan();
						$modelNewTembusan->id_table = $model->id_ba8;
						$seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
						$modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
						$modelNewTembusan->kode_table =  GlobalConstMenuComponent::BA8;
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

                PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=>GlobalConstMenuComponent::BA8, 'id_table'=>$model->id_ba8]);
	            for ($i = 0; $i < count($nip); $i++) {
	            	$modelJpu1 = new PdmJaksaSaksi();
	            	$seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
	            	
	            	$modelJpu1->id_perkara = $id;
	            	$modelJpu1->id_jpp = $seqJpu['generate_pk'];
                    $modelJpu1->code_table = GlobalConstMenuComponent::BA8;
                    $modelJpu1->id_table = $model->id_ba8;
	            	$modelJpu1->nip = $nip[$i];
	            	$modelJpu1->nama = $nama[$i];
	            	$modelJpu1->jabatan = $jabatan[$i];
	            	$modelJpu1->pangkat = $pangkat[$i];
                    $modelJpu1->no_urut = $no_urut[$i];
                    $modelJpu1->peg_nip_baru = $nip_baru[$i];
	            	$modelJpu1->save();
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
			
				 return $this->redirect(['update','id'=>$model->id_ba8]);
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
				 return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
				'list_tersangka' => $listTersangka,
				'modelJpu' => $modelJpu,
				'sysMenu' => $sysMenu,
				'wilayah' => $wilayah,
            ]);
        }
    }

    /**
     * Updates an existing PdmBa8 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA8 ]);
	$session = new Session();
		$id_perkara = $session->get('id_perkara');
		
		$kd_wilayah = PdmSpdp::findOne($id_perkara)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
		
        $model = $this->findModel($id);
		
		if($model == null){
            $model = new PdmBA8();
			
        }
		
		$queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            ->where('a.id_perkara=:id_perkara ', [':id_perkara' => $id_perkara])->all();
			
		$modelJpu = PdmJaksaSaksi::find()->where(['id_perkara' => $id_perkara, 'code_table' => GlobalConstMenuComponent::BA8, 'id_table' => $model->id_ba8])->orderBy('no_urut asc')->all();
		
        if ($model->load(Yii::$app->request->post())) {
			$transaction = Yii::$app->db->beginTransaction();
			try {
				$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba8', 'id_ba8', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

				if($model->id_perkara != null){
					$model->update();
				}else {
					$model->id_perkara = $id_perkara;
					$model->id_ba8 = $seq['generate_pk'];
					$model->save();
					
					Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::BA8);    
				}
				
				PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::BA8]);
				if(isset($_POST['new_tembusan'])){
					for($i = 0; $i < count($_POST['new_tembusan']); $i++){
						$modelNewTembusan= new PdmTembusan();
						$modelNewTembusan->id_table = $model->id_ba8;
						$seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
						$modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
						$modelNewTembusan->kode_table =  GlobalConstMenuComponent::BA8;
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

                PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=>GlobalConstMenuComponent::BA8, 'id_table'=>$model->id_ba8]);
	            for ($i = 0; $i < count($nip); $i++) {
	            	$modelJpu1 = new PdmJaksaSaksi();
	            	$seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
	            	
	            	$modelJpu1->id_perkara = $id;
	            	$modelJpu1->id_jpp = $seqJpu['generate_pk'];
                    $modelJpu1->code_table = GlobalConstMenuComponent::BA8;
                    $modelJpu1->id_table = $model->id_ba8;
	            	$modelJpu1->nip = $nip[$i];
	            	$modelJpu1->nama = $nama[$i];
	            	$modelJpu1->jabatan = $jabatan[$i];
	            	$modelJpu1->pangkat = $pangkat[$i];
                    $modelJpu1->no_urut = $no_urut[$i];
                    $modelJpu1->peg_nip_baru = $nip_baru[$i];
	            	$modelJpu1->save();
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
			
				 return $this->redirect(['update','id'=>$id]);
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
				 return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
				'list_tersangka' => $listTersangka,
				'modelJpu' => $modelJpu,
				'wilayah' => $wilayah,
				'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBa8 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $id_ba8 = $_POST['hapusIndex'];

            $session = new Session();
            $id_perkara = $session->get('id_perkara');

            if ($id_ba8 === 'all') {
                PdmBa8::updateAll(['flag' => '3'], 'id_perkara=:id_perkara', [':id_perkara' => $id_perkara]);

            
            } else {
                for ($i = 0; $i < count($id_ba8); $i++) {
                    $model = $this->findModel($id_ba8[$i]);
                    $model->flag = '3';
                    $model->update(true);

                    
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
     * Finds the PdmBa8 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa8 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmBa8::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionCetak($id)
    {
		$odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/ba8.odt");
		
		$connection = \Yii::$app->db;
		$sql =" select a.* ,to_char(a.tgl_surat,'D') as hari,  d.nama as nama_tersangka,e.nip as nip_jaksa,e.nama as nama_jaksa, e.jabatan as jabatan_jaksa "
				. " , e.pangkat as pangkat_jaksa "
				. " from pidum.pdm_ba8 a "
				. " inner join pidum.ms_tersangka d on a.id_tersangka = d.id_tersangka "
				. " inner join pidum.pdm_jaksa_saksi e on a.id_ba8 = e.id_table and e.code_table = 'BA-8' "
				. " where a.id_ba8 = '$id' ";
        $model = $connection->createCommand($sql);
        $data = $model->queryOne();
		
		$odf->setVars('kejaksaan', ucfirst(Yii::$app->globalfunc->getSatker()->inst_nama)); 
		$odf->setVars('nama_pegawai', ucfirst(strtolower($data['nama_jaksa']))); 
		$odf->setVars('pangkat', ucfirst(strtolower($data['pangkat_jaksa']))); 
		$odf->setVars('nip', ucfirst(strtolower($data['nip_jaksa']))); 
		$odf->setVars('nomor', ucfirst(strtolower('-'))); 
		$odf->setVars('pengadilan', ucfirst(strtolower('-'))); 
		$odf->setVars('amar_putusan', ucfirst(strtolower('-'))); 
		$odf->setVars('rutan', ucfirst(strtolower('-'))); 
		$odf->setVars('kurungan_selama', ucfirst(strtolower('-'))); 
		$odf->setVars('membebaskan', ucfirst(strtolower('-'))); 
		$odf->setVars('kepala_rutan', ucfirst(strtolower('Nama Kepala Rutan'))); 
		$odf->setVars('jabatan', ucfirst(strtolower($data['jabatan_jaksa']))); 
		$odf->setVars('nama_penandatangan', ucfirst(strtolower($data['nama_jaksa']))); 
		$odf->setVars('nip_penandatangan', ucfirst(strtolower($data['nip_jaksa']))); 
		$odf->setVars('terdakwa', ucfirst(strtolower($data['nama_tersangka']))); 
		$odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_surat'])); 
		$odf->setVars('hari', ucfirst(strtolower(Yii::$app->globalfunc->getNamaHari($data['hari'])))); 
		
		#tembusan
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='".$data['id_perkara']."' AND kode_table='".GlobalConstMenuComponent::BA8."'")
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
		
		$odf->exportAsAttachedFile();
	}
}
