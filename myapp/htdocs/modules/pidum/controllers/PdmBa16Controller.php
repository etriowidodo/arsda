<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmBa16;
use app\modules\pidum\models\PdmBa16Search;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmJaksaPenerima;
use app\components\GlobalConstMenuComponent;
use app\components\GlobalFuncComponent;

/**
 * PdmBa16Controller implements the CRUD actions for PdmBa16 model.
 */
class PdmBa16Controller extends Controller
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
     * Lists all PdmBa16 models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $id_perkara = $session->get('id_perkara');
		
        $searchModel = new PdmBa16Search();
        $dataProvider = $searchModel->search($id_perkara);
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA16 ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmBa16 model.
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
     * Creates a new PdmBa16 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmBa16();
		$session = new Session();
		$id = $session->get('id_perkara');
		
		$kd_wilayah = PdmSpdp::findOne($id)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
		
		$modelJpu = PdmJaksaPenerima::find()->where(['id_perkara' => $id, 'code_table' => GlobalConstMenuComponent::BA16, 'id_table' => $model->id_ba16])->orderBy('no_urut asc')->all();
		
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA16 ]);
		
		$queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            ->where('a.id_perkara=:id_perkara ', [':id_perkara' => $id])->all();
			//var_dump( $listTersangka);exit;
		$connection = \Yii::$app->db;
		
		$sql = " select b.nama
from 
pidum.pdm_b4 a
left join pidum.pdm_barbuk_tambahan b on a.id_b4 = b.id_b4
where a.id_perkara = '".$id."'
union all
select b.nama
from 
pidum.pdm_ba18 a
left join pidum.pdm_barbuk b on a.id_ba18 = b.id_ba18
where a.id_perkara = '".$id."' ";
		$cmd_barbuk = $connection->createCommand($sql);
        $data_barbuk = $cmd_barbuk->queryAll();
		
        if ($model->load(Yii::$app->request->post()) ) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba16', 'id_ba16', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

			if($model->id_perkara != null){
				$model->update();
			}else {
				$model->id_perkara = $id;
				$model->id_ba16 = $seq['generate_pk'];
				$model->save();
				
				Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::BA16);    
			}
			
			$nip = $_POST['nip_jpu'];
	            $nama = $_POST['nama_jpu'];
	            $jabatan = $_POST['jabatan_jpu'];
	            $pangkat = $_POST['gol_jpu'];
	            $no_urut = $_POST['no_urut'];
	            $nip_baru = $_POST['nip_baru'];

                PdmJaksaPenerima::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=>GlobalConstMenuComponent::BA16, 'id_table'=>$model->id_ba16]);
	            for ($i = 0; $i < count($nip); $i++) {
	            	$modelJpu1 = new PdmJaksaPenerima();
	            	$seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
	            	
	            	$modelJpu1->id_perkara = $id;
	            	$modelJpu1->id_jpp = $seqJpu['generate_pk'];
                    $modelJpu1->code_table = GlobalConstMenuComponent::BA16;
                    $modelJpu1->id_table = $model->id_ba16;
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
            return $this->redirect(['update','id'=>$model->id_ba16]);
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
				'sysMenu' => $sysMenu,
				'modelJpu' => $modelJpu,
				'wilayah' => $wilayah,
				'listTersangka' => $listTersangka,
				'data_barbuk' => $data_barbuk,
            ]);
        }
    }

    /**
     * Updates an existing PdmBa16 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$session = new Session();
		$id_perkara = $session->get('id_perkara');
		
		
		
		$kd_wilayah = PdmSpdp::findOne($id)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;

		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA16 ]);
		
		$modelJpu = PdmJaksaPenerima::find()->where(['id_perkara' => $id_perkara, 'code_table' => GlobalConstMenuComponent::BA16, 'id_table' => $id])->orderBy('no_urut asc')->all();
		
		
		
		$queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            ->where('a.id_perkara=:id_perkara ', [':id_perkara' => $id_perkara])->all();
			
		$connection = \Yii::$app->db;
		
		$sql = " select b.nama
from 
pidum.pdm_b4 a
left join pidum.pdm_barbuk_tambahan b on a.id_b4 = b.id_b4
where a.id_perkara = '".$id."'
union all
select b.nama
from 
pidum.pdm_ba18 a
left join pidum.pdm_barbuk b on a.id_ba18 = b.id_ba18
where a.id_perkara = '".$id."' ";
		$cmd_barbuk = $connection->createCommand($sql);
        $data_barbuk = $cmd_barbuk->queryAll();
		
        if ($model->load(Yii::$app->request->post()) ) {
			 $transaction = Yii::$app->db->beginTransaction();
            try {
					$model->update();
					
					$nip = $_POST['nip_jpu'];
	            $nama = $_POST['nama_jpu'];
	            $jabatan = $_POST['jabatan_jpu'];
	            $pangkat = $_POST['gol_jpu'];
	            $no_urut = $_POST['no_urut'];
	            $nip_baru = $_POST['nip_baru'];

                PdmJaksaPenerima::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=>GlobalConstMenuComponent::BA16, 'id_table'=>$model->id_ba16]);
	            for ($i = 0; $i < count($nip); $i++) {
	            	$modelJpu1 = new PdmJaksaPenerima();
	            	$seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
	            	
	            	$modelJpu1->id_perkara = $model->id_perkara;
	            	$modelJpu1->id_jpp = $seqJpu['generate_pk'];
                    $modelJpu1->code_table = GlobalConstMenuComponent::BA16;
                    $modelJpu1->id_table = $model->id_ba16;
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
                    'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Berhasil Disimpan', // String
                    'title' => 'Save', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);
					return $this->redirect(['update','id'=>$model->id_ba16]);
				} catch (Exception $e) {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Diubah', // String
                    'title' => 'Update', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['update', 'id' => $model->id_ba16]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelJpu' => $modelJpu,
                'listTersangka' => $listTersangka,
				'sysMenu' => $sysMenu,
				'wilayah' => $wilayah,
				'data_barbuk' => $data_barbuk,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBa16 model.
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
                PdmBa16::deleteAll('id_perkara=:id_perkara', [':id_perkara' => $id_perkara]);

            
            } else {
                for ($i = 0; $i < count($id_ba8); $i++) {
                    $model = $this->findModel($id_ba8[$i])->delete();

                    
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
     * Finds the PdmBa16 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa16 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmBa16::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionCetak($id)
    {
		$odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/ba16.odt");
		$connection = \Yii::$app->db;
		$sql =" select a.*,c.nama as nama_tersangka, "
			 ."	to_char(a.tgl_surat,'D') as hari, "
			 ."	to_char(a.tgl_surat,'YYYY') as tahun, "
			 ."	to_char(a.tgl_surat,'MM')::integer as bulan, "
             ." to_char(a.tgl_surat,'DD')::integer as tgl "
             ." from pidum.pdm_ba16 a "
			 ." left join pidum.pdm_jaksa_penerima b on a.id_perkara = b.id_perkara and b.code_table = 'BA-16' and b.id_table = a.id_ba16 "
			 ." left join pidum.ms_tersangka c on a.id_perkara = c.id_perkara and c.id_tersangka =  a.id_tersangka "
			 . " where a.id_ba16 = '$id' ";
        $model = $connection->createCommand($sql);
        $data = $model->queryOne();
		
		$odf->setVars('hari', ucfirst(strtolower(Yii::$app->globalfunc->getNamaHari($data['hari']))));  
		$odf->setVars('tahun', ucfirst(strtolower($data['tahun'])));  
		$odf->setVars('penggeledahan', ucfirst(strtolower($data['penggeledahan'])));  
		$odf->setVars('penyitaan', ucfirst(strtolower($data['penyitaan'])));  
		$odf->setVars('terdakwa', ucfirst(strtolower($data['nama_tersangka'])));  
		$odf->setVars('nomor', ucfirst(strtolower('-')));  
		$odf->setVars('nomor_terdakwa', ucfirst(strtolower('-')));  
		$odf->setVars('tanggal_terdakwa', ucfirst(strtolower('-')));  
		$odf->setVars('nomor_kejari', ucfirst(strtolower('-')));  
		$odf->setVars('tanggal_kejari', ucfirst(strtolower('-')));  
		$odf->setVars('nama_saksi', ucfirst(strtolower($data['nama1'])));  
		$odf->setVars('umur_saksi', ucfirst(strtolower($data['umur1'])));  
		$odf->setVars('pekerjaan_saksi', ucfirst(strtolower($data['pekerjaan1']))); 
		$odf->setVars('nama_saksi2', ucfirst(strtolower($data['nama2'])));  
		$odf->setVars('umur_saksi2', ucfirst(strtolower($data['umur2'])));  
		$odf->setVars('pekerjaan_saksi2', ucfirst(strtolower($data['pekerjaan2'])));		
        $odf->setVars('tgl_pembuatan', ucfirst($data['tgl']." ".Yii::$app->globalfunc->getNamaBulan($data['bulan']))); 
		$odf->setVars('Kejaksaan', ucfirst(Yii::$app->globalfunc->getSatker()->inst_nama));	
		$odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_surat'])); 		

		#jaksa pelaksana
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_jaksa_penerima')
                ->where("id_perkara='".$data['id_perkara']."' AND code_table='".GlobalConstMenuComponent::BA16."'");
				
        $dt_jaksa = $query->createCommand();
        $listJaksa = $dt_jaksa->queryAll();
        $dft_jaksa = $odf->setSegment('jaksaPelaksana');
		$no = 1;
        foreach($listJaksa as $element){
                $dft_jaksa->urutan($no);
                $dft_jaksa->nama_pegawai($element['nama']);
                $dft_jaksa->nip_pegawai($element['nip']);
                $dft_jaksa->pangkat_pegawai($element['pangkat']);
                $dft_jaksa->jabatan_pegawai($element['jabatan']);
                $dft_jaksa->merge();
				$no++;
        }
        $odf->mergeSegment($dft_jaksa);
		
		$odf->exportAsAttachedFile();
	}
	
}
