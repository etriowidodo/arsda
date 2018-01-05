<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmBa19;
use app\modules\pidum\models\PdmBa19Search;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmJaksaPenerima;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\VwJaksaPenuntutSearch;

/**
 * PdmBa19Controller implements the CRUD actions for PdmBa19 model.
 */
class PdmBa19Controller extends Controller
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
     * Lists all PdmBa19 models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $id_perkara = $session->get('id_perkara');
		
        $searchModel = new PdmBa19Search();
        $dataProvider = $searchModel->search($id_perkaras);
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA19 ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmBa19 model.
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
     * Creates a new PdmBa19 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmBa19();

		$session = new Session();
		$id = $session->get('id_perkara');
		
		$kd_wilayah = PdmSpdp::findOne($id)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
		
		
		
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA19 ]);
		
		$searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
		
		
		
		$queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            ->where('a.id_perkara=:id_perkara ', [':id_perkara' => $id])->all();
		
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
		
        if ($model->load(Yii::$app->request->post())) {
            
             $transaction = Yii::$app->db->beginTransaction();

            try {
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba19', 'id_ba19', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

			if($model->id_perkara != null){
				$model->update();
			}else {
				$model->id_perkara = $id;
				$model->id_ba19 = $seq['generate_pk'];
				$model->save();
				
				Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::BA19);    
			}
			
				$nip = $_POST['nip_jpu'];
	            $nama = $_POST['nama_jpu'];
	            $jabatan = $_POST['jabatan_jpu'];
	            $pangkat = $_POST['gol_jpu'];
	            $no_urut = $_POST['no_urut'];
	            $nip_baru = $_POST['nip_baru'];

                PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=>GlobalConstMenuComponent::BA19, 'id_table'=>$model->id_ba19]);
	            for ($i = 0; $i < count($nip); $i++) {
	            	$modelJpu1 = new PdmJaksaSaksi();
	            	$seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
	            	
	            	$modelJpu1->id_perkara = $id;
	            	$modelJpu1->id_jpp = $seqJpu['generate_pk'];
                    $modelJpu1->code_table = GlobalConstMenuComponent::BA19;
                    $modelJpu1->id_table = $model->id_ba19;
	            	$modelJpu1->nip = $nip[$i];
	            	$modelJpu1->nama = $nama[$i];
	            	$modelJpu1->jabatan = $jabatan[$i];
	            	$modelJpu1->pangkat = $pangkat[$i];
                    $modelJpu1->no_urut = $no_urut[$i];
                    $modelJpu1->peg_nip_baru = $nip_baru[$i];
	            	$modelJpu1->save();
	            }
				
				PdmJaksaPenerima::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=>GlobalConstMenuComponent::BA19]);
        	
        	$jaksa = $_POST['PdmJaksaSaksi'];
        	
        	if(!empty($jaksa)){
        		$modeljaksi1 = new PdmJaksaPenerima();
        		$seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
        	
        		$modeljaksi1->id_jpp = $seqjpp['generate_pk'];
        		$modeljaksi1->id_perkara = $model->id_perkara;
        		$modeljaksi1->code_table = GlobalConstMenuComponent::BA19;
        		$modeljaksi1->id_table = $model->id_ba19;
        		$modeljaksi1->flag = '1';
        		$modeljaksi1->nama = $jaksa['nama'];
        		$modeljaksi1->nip = $jaksa['nip'];
        		$modeljaksi1->jabatan = $jaksa['jabatan'];
        		$modeljaksi1->pangkat = $jaksa['pangkat'];
        		$modeljaksi1->save();
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
            return $this->redirect(['update','id'=>$model->id_ba19]);
            
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
				'wilayah' => $wilayah,
				'dataJPU' => $dataJPU,
            	'searchJPU' => $searchJPU,
            	'data_barbuk' => $data_barbuk,
            ]);
        }
    }

    /**
     * Updates an existing PdmBa19 model.
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
		
		
		
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA19 ]);
		
		$searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
		
		
		
		$queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            ->where('a.id_perkara=:id_perkara ', [':id_perkara' => $id_perkara])->all();
		
		$connection = \Yii::$app->db;
		
		$sql = " select b.nama
from 
pidum.pdm_b4 a
left join pidum.pdm_barbuk_tambahan b on a.id_b4 = b.id_b4
where a.id_perkara = '".$id_perkara."'
union all
select b.nama
from 
pidum.pdm_ba18 a
left join pidum.pdm_barbuk b on a.id_ba18 = b.id_ba18
where a.id_perkara = '".$id_perkara."' ";
		$cmd_barbuk = $connection->createCommand($sql);
        $data_barbuk = $cmd_barbuk->queryAll();
		
		$modeljaksi = PdmJaksaPenerima::findOne(['id_perkara' => $id_perkara, 'id_table' => $model->id_ba19, 'code_table' => GlobalConstMenuComponent::BA19]);
		
		
		$modelJpu = PdmJaksaSaksi::find()->where(['id_perkara' => $id_perkara, 'code_table' => GlobalConstMenuComponent::BA19, 'id_table' => $model->id_ba19])->orderBy('no_urut asc')->all();
		
        if ($model->load(Yii::$app->request->post()) ) {
			$transaction = Yii::$app->db->beginTransaction();
			
			try {
				if($model->id_perkara != null){
					$model->update();
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
				'sysMenu' => $sysMenu,
				'wilayah' => $wilayah,
				'dataJPU' => $dataJPU,
            	'searchJPU' => $searchJPU,
            	'modelJpu' => $modelJpu,
				'data_barbuk' => $data_barbuk,
				'modeljaksi' => $modeljaksi,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBa19 model.
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
                PdmBa19::deleteAll('id_perkara=:id_perkara', [':id_perkara' => $id_perkara]);

            
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
     * Finds the PdmBa19 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa19 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmBa19::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
		
	public function actionCetak($id)
    {
		$odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/ba19.odt");
		
		$connection = \Yii::$app->db;
		$sql =" select a.*,b.nip as nip_jpu, b.nama as nama_jpu, b.pangkat as pangkat_jpu, "
			 ."	to_char(a.tgl_surat,'D') as hari, "
			 ."	to_char(a.tgl_surat,'YYYY') as tahun, "
			 ."	to_char(a.tgl_surat,'MM')::integer as bulan, "
             ." to_char(a.tgl_surat,'DD')::integer as tgl "
             ." from pidum.pdm_ba19 a "
			 ." left join pidum.pdm_jaksa_penerima b on b.id_perkara = a.id_perkara and b.code_table = 'BA-19' and b.id_table = a.id_ba19 "
			 . " where a.id_ba19 = '$id' ";
			 
        $model = $connection->createCommand($sql);
        $data = $model->queryOne();
		
		$odf->setVars('tanggal', ucfirst(strtolower($data['tgl'])));  
		$odf->setVars('tahun', ucfirst(strtolower($data['tahun'])));  
		$odf->setVars('nomor', ucfirst(strtolower($data['nomor'])));  
		$odf->setVars('nama_jaksa', ucfirst(strtolower($data['nama_jpu'])));  
		$odf->setVars('pangkat', ucfirst(strtolower($data['pangkat_jpu'])));  
		$odf->setVars('nip', ucfirst(strtolower($data['nip_jpu'])));  
		$odf->setVars('putusan', ucfirst(strtolower('-')));  
		$odf->setVars('nomor_putusan', ucfirst(strtolower('-')));  
		$odf->setVars('tanggal_putusan', ucfirst(strtolower('-')));  
		$odf->setVars('kepada', ucfirst(strtolower('-')));  
		$odf->setVars('nama_pemilik', ucfirst(strtolower('Terpidana')));  
		$odf->setVars('tanggal_kepala', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_surat'])); 
        $odf->setVars('bulan', ucfirst(Yii::$app->globalfunc->getNamaBulan($data['bulan'])));
		$odf->setVars('kejaksaan', ucfirst(Yii::$app->globalfunc->getSatker()->inst_nama));  
		$odf->setVars('kepala', ucfirst(Yii::$app->globalfunc->getSatker()->inst_nama));  
		
		#saksi
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_jaksa_saksi')
                ->where("id_perkara='".$data['id_perkara']."' AND code_table='".GlobalConstMenuComponent::BA19."' AND id_table = '".$id."'");
        $dt_saksi = $query->createCommand();
        $listSaksi = $dt_saksi->queryAll();
        $dft_saksi = $odf->setSegment('saksi');
		$no = 1;
        foreach($listSaksi as $element){
                $dft_saksi->urutan($no);
                $dft_saksi->nama_saksi($element['nama']);
                $dft_saksi->pangkat_saksi($element['pangkat']);
                $dft_saksi->nip_saksi($element['nip']);
                $dft_saksi->jabatan_saksi($element['jabatan']);
                $dft_saksi->merge();
				$no++;
        }
        $odf->mergeSegment($dft_saksi);
		
		$dft_lampiransaksi = $odf->setSegment('lampiransaksi');
		$no = 1;
        foreach($listSaksi as $element){
                $dft_lampiransaksi->urutan($no);
                $dft_lampiransaksi->nama_saksi($element['nama']);
                $dft_lampiransaksi->pangkat_saksi($element['pangkat']);
                $dft_lampiransaksi->nip_saksi($element['nip']);
                $dft_lampiransaksi->jabatan_saksi($element['jabatan']);
                $dft_lampiransaksi->merge();
				$no++;
        }
        $odf->mergeSegment($dft_lampiransaksi);
		
		$odf->exportAsAttachedFile();
	}
}
