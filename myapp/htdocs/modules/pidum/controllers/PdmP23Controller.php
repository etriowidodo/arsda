<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use Odf;
use Yii;
use app\modules\pidum\models\PdmP23;
use app\modules\pidum\models\PdmP23Search;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidum\models\PdmP22;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmTrxPemrosesan;
use app\modules\pidum\models\PdmTembusanP23;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmPengantarTahap1;
use yii\web\Session;

/**
 * PdmP23Controller implements the CRUD actions for PdmP23 model.
 */
class PdmP23Controller extends Controller
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
     * Lists all PdmP23 models.
     * @return mixed
     */
    public function actionIndex(){
        $berkas  = Yii::$app->session->get('perilaku_berkas');
        if($berkas == ''){
            $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P23]);
            $id_perkara     = Yii::$app->session->get('id_perkara');
            $searchModel    = new PdmP23Search();
            $dataProvider   = $searchModel->search2(Yii::$app->request->queryParams);
            $models         = $dataProvider->getModels();		
            return $this->render('index', [
                'dataProvider'  => $dataProvider,
                'sysMenu'       => $sysMenu,
                'model'         => $model,
                'searchModel'   => $searchModel
            ]);
        }else{
            $query = (new \yii\db\Query())
                    ->select (['pidum.pdm_pengantar_tahap1.no_pengantar','pidum.pdm_p22.id_p22','coalesce(id_p23,\'0\') as id_p23 ','pidum.pdm_p22.tgl_dikeluarkan','pidum.pdm_p22.no_surat','pidum.pdm_berkas_tahap1.no_berkas','pidum.pdm_berkas_tahap1.tgl_berkas','pidum.pdm_berkas_tahap1.id_berkas','pidum.pdm_p22.id_pengantar',"string_agg(pidum.ms_tersangka_berkas.nama,', ') as nama"])
                    ->from('pidum.pdm_berkas_tahap1')
                    ->join('INNER JOIN', 'pidum.pdm_pengantar_tahap1', 'pidum.pdm_pengantar_tahap1.id_berkas = pidum.pdm_berkas_tahap1.id_berkas')
                    ->join('INNER JOIN', 'pidum.ms_tersangka_berkas', 'pidum.ms_tersangka_berkas.id_berkas=pidum.pdm_pengantar_tahap1.id_berkas')
//                    ->join('INNER JOIN', 'pidum.pdm_p19', 'pidum.pdm_p19.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
                    ->join('INNER JOIN', 'pidum.pdm_p22', 'pidum.pdm_p22.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
                    ->join('LEFT JOIN', 'pidum.pdm_p23', 'pidum.pdm_p23.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
                    ->where("pidum.pdm_berkas_tahap1.id_berkas = '".$berkas."' GROUP BY pidum.pdm_p22.id_pengantar,pidum.pdm_pengantar_tahap1.no_pengantar,pidum.pdm_berkas_tahap1.no_berkas,pidum.pdm_berkas_tahap1.tgl_berkas,pidum.pdm_p22.id_p22,pidum.pdm_p23.id_p23,pidum.pdm_berkas_tahap1.id_berkas")
                    ->all();
            $id_pengantar   = $query[0]['id_pengantar'];
            $id_p23         = $query[0]['id_p23'];
//            echo $id_pengantar.' '.$id_p23.' '.$berkas;exit();
            return $this->redirect(['update','id_pengantar'=>$id_pengantar,'id'=>$id_p23]);
        }
    }


    public function actionUpdate($id,$id_pengantar)
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P23 ]);
        $id_perkara = Yii::$app->session->get('id_perkara');
		
		
        $model = $this->findModel($id);
		if ($model == null) {
            $model = new PdmP23();
			$file_lama = '';
        }else{
			$file_lama = $model->getOldAttributes()['file_upload'];
		}
        
		$modelPengantar = PdmPengantarTahap1::findOne(['id_pengantar'=>$id_pengantar]);
		$p22 = PdmP22::findOne(['id_pengantar'=>$id_pengantar]);
        $searchModel = new PdmP23Search();
		$dataProvider = $searchModel->searchTersangka($modelPengantar->no_pengantar);
        $modelSpdp = PdmSpdp::findOne($id_perkara);
        

        if ($model->load(Yii::$app->request->post())) {
			$transaction = Yii::$app->db->beginTransaction();
            try{
                $model->id_pengantar = $id_pengantar;
				$model->id_berkas = $modelPengantar->id_berkas;
				$model->id_p23= $modelPengantar->id_berkas."|".$_POST['PdmP23']['no_surat'];
				
				if($_POST['hdn_nama_penandatangan'] != ''){
					$model->nama = $_POST['hdn_nama_penandatangan'];
					$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
					$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
				}
				if(!$model->save()){
					var_dump($model->getErrors());exit;
				}

				$id_p23= $modelPengantar->id_berkas."|".$_POST['PdmP23']['no_surat'];
				PdmTembusanP23::deleteAll(['id_p23' => $id_p23]);
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanP23();
                    $modelNewTembusan->id_p23 = $id_p23;
                    $modelNewTembusan->id_tembusan = $id_p23."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                    if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
                }
				
				$transaction->commit();

				Yii::$app->getSession()->setFlash('success', [
					'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
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
                    return $this->redirect('create');
            }
        } else {
            return $this->render('update', [
                    'model' => $model,
                    'sysMenu' => $sysMenu,
                    'modelSpdp' => $modelSpdp,
					'dataProvider' => $dataProvider,
					'p22' => $p22,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP23 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
	 
	 public function actionHapus()
    {	
		$id = $_POST['hapusIndex'];
		$model1 = PdmP23::findOne(['id_pengantar' => $id]);
		PdmTembusan::deleteAll(['id_table' => $model1->id_p23, 'kode_table' => GlobalConstMenuComponent::P23]);
				
				$filename = Yii::$app->basePath . '/web/template/pidum_surat/' .preg_replace('/[^A-Za-z0-9\-]/', '',$model1->id_perkara). '/p23_'.$model1->id_p23.'.pdf';
				if (file_exists($filename)) {
					chmod($filename,0777);
					unlink($filename);
				}
		$this->findModel($id)->delete();
        return $this->redirect(['index']);		
    }
    public function actionDelete()
    {
        $id =  $_POST['hapusIndex'];
		$pot=  (string) $_POST['hapusIndex'];
		$id_perkara = $_SESSION['id_perkara'];
		if($id == "all"){ 
				Yii::$app->db->createCommand(" DELETE FROM pidum.pdm_p23 WHERE id_berkas IN (SELECT id_berkas FROM pidum.pdm_berkas_tahap1 where id_perkara='".$id_perkara."') ")->execute();
			
		}else{
			   
				PdmP23::deleteAll(['id_p23' => substr(($id[$i]),-16) ]);
				
			
		}
        return $this->redirect(['index']);	
    }

    public function actionCetak($idp23)
    {
		$id_perkara=Yii::$app->session->get('id_perkara');
	$odf = new Odf(Yii::$app->params['report-path'] . "web/template/pidum/p23.odt");
         $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p23 b','a.peg_nik = b.id_penandatangan')
->where ("id_p23='".$id."'")
->one();
        $model = PdmP23::findOne(['id_p23' => $idp23]);
        $pdmP22 = PdmP22::findOne(['id_berkas'=>$model->id_berkas]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);

        $listTersangka = Yii::$app->db->createCommand(" select a.nama FROM pidum.ms_tersangka_berkas a WHERE a.id_berkas='".$model->id_berkas."' ORDER BY a.no_urut asc  ")->queryAll();
			
			 if (count($listTersangka) == 1) {
            foreach ($listTersangka as $key) {
				$nama_tersangka = ucfirst(strtolower($key[nama])) ;
			}
        } else if(count($listTersangka) == 2){
			 $i=1;
			 foreach ($listTersangka as $key) {
				if($i==1){
					$nama_tersangka = ucfirst(strtolower($key[nama]))." dan " ;
				}else{
					$nama_tersangka .= ucfirst(strtolower($key[nama])) ;
				}
				$i++;
			 }
		}else {
            foreach ($listTersangka as $key) {
				$i=1;
				if($i==1){
					$nama_tersangka = ucfirst(strtolower($key[nama]))." dkk. " ;
				}
			}
        }
		
        $odf->setVars('tersangka_lampiran',$nama_tersangka);

        $odf->setVars('nomor', $model->no_surat);
        
        $sifat = \app\models\MsSifatSurat::findOne(['id'=>$model->sifat]);
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('sifat', $sifat->nama);
        $odf->setVars('lampiran', $model->lampiran);
        $odf->setVars('pasal', Yii::$app->globalfunc->getAlternativePasal($id_perkara));
        $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
        $odf->setVars('tgl_keluar', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
        $odf->setVars('kepada', $model->kepada);
        $odf->setVars('di_tempat', $model->di_kepada);
        $odf->setVars('nomor_p22', $pdmP22->no_surat);
		$odf->setVars('kepala',$model->jabatan);
        $odf->setVars('tanggal_p22', Yii::$app->globalfunc->ViewIndonesianFormat($pdmP22->tgl_dikeluarkan));
		#penanda tangan
				$odf->setVars('nama_penandatangan', $model->nama);
				$odf->setVars('pangkat', $model->pangkat);
				$odf->setVars('nip_penandatangan', $model->id_penandatangan);
        #tembusan
        $query = new Query();
        $query->select('*')
                ->from('pidum.pdm_tembusan_p23 ')
                ->where("id_p23 ='" . $model->id_p23 . "'")
                ->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($element['no_urut']);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);

        $odf->exportAsAttachedFile('p23.odt');
    }

    /**
     * Finds the PdmP23 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP23 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP23::findOne(['id_p23' => $id])) !== null) {
            return $model;
        } /* else {
            throw new NotFoundHttpException('The requested page does not exist.');
        } */
    }
}
