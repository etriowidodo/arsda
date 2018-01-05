<?php


namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmB16;
use app\modules\pdsold\models\PdmB16Search;
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
use app\modules\pdsold\models\PdmBarbukTambahan;
use app\modules\pdsold\models\PdmB4;

/**
 * PdmB16Controller implements the CRUD actions for PdmB16 model.
 */
class PdmB16Controller extends Controller
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
     * Lists all PdmB16 models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $id_perkara = $session->get('id_perkara');
		
        $searchModel = new PdmB16Search();
        $dataProvider = $searchModel->searchIndex($id_perkara);
		
		 $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B16 ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmB16 model.
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
     * Creates a new PdmB16 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B16 ]);
		$session = new Session();
		$id = $session->get('id_perkara');
		
        //$model = $this->findModel($id);
		if($model == null){
            $model = new PdmB16();
        }
		
		$queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            ->where('a.id_perkara=:id_perkara AND a.id_tersangka NOT IN (select id_tersangka from pidum.pdm_b16 where pidum.pdm_b16.flag<>\'3\')', [':id_perkara' => $id])->all();
			
			
        if ($model->load(Yii::$app->request->post())) {
			$transaction = Yii::$app->db->beginTransaction();
			try {
				$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b16', 'id_b16', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

				if($model->id_perkara != null){
					$model->update();
				}else {
					$model->id_perkara = $id;
					$model->id_b16 = $seq['generate_pk'];
					$model->save();
					
					Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::B16);    
				}
				
				PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::B16]);
				if(isset($_POST['new_tembusan'])){
					for($i = 0; $i < count($_POST['new_tembusan']); $i++){
						$modelNewTembusan= new PdmTembusan();
						$modelNewTembusan->id_table = $model->id_b16;
						$seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
						$modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
						$modelNewTembusan->kode_table =  GlobalConstMenuComponent::B16;
						$modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];					
											$modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
						$modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];	        		
						$modelNewTembusan->id_perkara = $model->id_perkara;
						$modelNewTembusan->nip = null;
						$modelNewTembusan->save();
					}
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
			
				  return $this->redirect(['update','id'=>$model->id_b16]);
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
            ]);
        }
    }

    /**
     * Updates an existing PdmB16 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B16 ]);
	$session = new Session();
		$id_perkara = $session->get('id_perkara');
		
        $model = $this->findModel($id);
		
		if($model == null){
            $model = new PdmB16();
			
        }
		
		$queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            ->where('a.id_perkara=:id_perkara ', [':id_perkara' => $id_perkara])->all();
			
			
        if ($model->load(Yii::$app->request->post())) {
			$transaction = Yii::$app->db->beginTransaction();
			try {
				$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b16', 'id_b16', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

				if($model->id_perkara != null){
					$model->update();
				}else {
					$model->id_perkara = $id_perkara;
					$model->id_b16 = $seq['generate_pk'];
					$model->save();
					
					Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::B16);    
				}
				
				PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::B16]);
				if(isset($_POST['new_tembusan'])){
					for($i = 0; $i < count($_POST['new_tembusan']); $i++){
						$modelNewTembusan= new PdmTembusan();
						$modelNewTembusan->id_table = $model->id_b16;
						$seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
						$modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
						$modelNewTembusan->kode_table =  GlobalConstMenuComponent::B16;
						$modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];					
											$modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
						$modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];	        		
						$modelNewTembusan->id_perkara = $model->id_perkara;
						$modelNewTembusan->nip = null;
						$modelNewTembusan->save();
					}
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
			
				 return $this->redirect(['index']);
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
				'sysMenu'=>$sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmB16 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $id_b16 = $_POST['hapusIndex'];

            $session = new Session();
            $id_perkara = $session->get('id_perkara');

            if ($id_b16 === 'all') {
                PdmB16::updateAll(['flag' => '3'], 'id_perkara=:id_perkara', [':id_perkara' => $id_perkara]);

            
            } else {
                for ($i = 0; $i < count($id_b16); $i++) {
                    $model = $this->findModel($id_b16[$i]);
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
     * Finds the PdmB16 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB16 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmB16::findOne($id)) !== null)
            return $model;
    }
	
	 public function actionCetak($id)
    {
		$odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/b16.odt");
		$connection = \Yii::$app->db;
		$sql =" select a.* ,b.nama, c.peg_nip_baru , b.pangkat, d.nama as nama_tersangka,e.nama as sifat_surat "
				. " from pidum.pdm_b16 a "
				. " inner join (select peg_nik,nama,pangkat,jabatan from pidum.pdm_penandatangan group by peg_nik,nama,pangkat,jabatan)b  "
				. " on a.id_penandatangan = b.peg_nik "
				. " inner join kepegawaian.kp_pegawai c on b.peg_nik = c.peg_nik "
				. " inner join pidum.ms_tersangka d on a.id_tersangka = d.id_tersangka "
				. " left join public.ms_sifat_surat e on cast(a.sifat as integer) = e.id "
				. " where a.id_b16 = '$id' ";
        $model = $connection->createCommand($sql);
        $data = $model->queryOne();
		   $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_b16 b','a.peg_nik = b.id_penandatangan')
->where ("id_b16='".$id."'")
->one(); 
		$odf->setVars('nomor', ucfirst(strtolower($data['no_surat'])));  
        $odf->setVars('sifat', ucfirst(strtolower($data['sifat_surat'])));  
		$odf->setVars('kepada', ucfirst(strtolower($data['kepada'])));  
		$odf->setVars('lampiran', ucfirst(strtolower($data['lampiran'])));  
		$odf->setVars('ditempat', ucfirst(strtolower($data['di_kepada'])));  
		$odf->setVars('barbuk_berupa', ucfirst(strtolower('-')));  
		$odf->setVars('register_barbuk', ucfirst(strtolower('-')));  
		$odf->setVars('perkara', ucfirst(strtolower('-')));  
		$odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_dikeluarkan'])); 
		$odf->setVars('kejaksaan', ucfirst(Yii::$app->globalfunc->getSatker()->inst_nama));  
		$odf->setVars('Kejaksaan', $pangkat->jabatan);  
		$odf->setVars('nama_penandatangan', ucfirst(strtolower($data['nama'])));  
		$odf->setVars('pangkat', ucfirst(strtolower($data['pangkat'])));  
		$odf->setVars('nip_penandatangan', ucfirst(strtolower($data['peg_nip_baru']))); 
		$odf->setVars('kepala', ucfirst(strtolower($data['surat_perintah_kepada']))); 
		$odf->setVars('lokasi_pengadilan', ucfirst(strtolower($data['lokasi_penetapan']))); 
		//$odf->setVars('barbuk_berupa', ucfirst(strtolower(''))); 
		//$odf->setVars('register_barbuk', ucfirst(strtolower(''))); 
		$odf->setVars('pelaksanaan_lelang', ucfirst(strtolower($data['pelaksanaan_lelang']))); 
		$odf->setVars('tanggal_lelang', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_lelang'])); 
		$odf->setVars('total_rupiah', ucfirst(strtolower($data['total']))); 
		$odf->setVars('bank', ucfirst(strtolower($data['bank']))); 
		$odf->setVars('ba_penitipan', ucfirst(strtolower($data['ba_penitipan']))); 
		$odf->setVars('tanggal_ba', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_ba'])); 
		//$odf->setVars('pengganti', ucfirst(strtolower('-'))); 
		//$odf->setVars('perkara', ucfirst(strtolower($data['peg_nip_baru']))); 
		$odf->setVars('nama_tersangka', ucfirst(strtolower($data['nama_tersangka']))); 
		$odf->setVars('nama_tersangka2', ucfirst(strtolower($data['nama_tersangka']))); 
		$odf->setVars('kepala2', ucfirst(strtolower($data['surat_perintah_kepada']))); 
		$odf->setVars('lokasi_pengadilan2', ucfirst(strtolower($data['lokasi_penetapan']))); 
		$odf->setVars('no_persetujuan', ucfirst(strtolower($data['no_persetujuan']))); 
		$odf->setVars('tanggal_persetujuan', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_persetujuan'])); 
		$odf->setVars('pelaksanaan_lelang2', ucfirst(strtolower($data['kantor_lelang']))); 
		$odf->setVars('nomor_lelang', ucfirst(strtolower($data['no_risalan']))); 
		$odf->setVars('tanggal_ba2', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_ba'])); 

		#tembusan
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='".$data['id_perkara']."' AND kode_table='".GlobalConstMenuComponent::B16."'")
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
