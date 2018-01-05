<?php

namespace app\modules\pdsold\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmP19;
use app\modules\pdsold\models\PdmBerkas;
use app\modules\pdsold\models\PdmTrxPemrosesan;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmPengantarTahap1;
use app\modules\pdsold\models\PdmTembusanP22;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\MsTersangkaBerkas;
use app\components\ConstSysMenuComponent;
use app\modules\pdsold\models\PdmP22;
use app\modules\pdsold\models\PdmP22Search;
use app\components\GlobalConstMenuComponent;
use yii\web\Session;
use Odf;
use yii\web\UploadedFile;
/**
 * PdmP22Controller implements the CRUD actions for PdmP22 model.
 */
class PdmP22Controller extends Controller {

    public function behaviors() {
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
     * Lists all PdmP22 models.
     * @return mixed
     */
   public function actionIndex() {
       $berkas  = Yii::$app->session->get('perilaku_berkas');

       $no_pengantar  = Yii::$app->session->get('no_pengantar');
       $id_pengantar = PdmPengantarTahap1::findOne(['no_pengantar'=>$no_pengantar])->id_pengantar;
       if($berkas == ''){
           $session         = new Session();
           $id_perkara      = $session->get('id_perkara');
           $sysMenu         = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P22]);
           $searchModel     = new PdmP22Search();
           $dataProvider    = $searchModel->searchdetail($id_perkara);
           return $this->render('index', [
               'dataProvider' => $dataProvider,
               'sysMenu' => $sysMenu
           ]);
       }else{
           $query = "select d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') as berkas,a.id_pengantar,coalesce(b.id_p22,'0') as id_p22 ,string_agg(f.nama,', ') as nama
                    ,c.no_surat ||'<br/>'||to_char(c.tgl_dikeluarkan,'DD-MM-YYYY') as p19,to_char(c.tgl_terima,'DD-MM-YYYY') as tgl_p19
                    ,coalesce(b.no_surat||'<br/>'||to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),'-')  as p22,d.id_berkas
                    from 
                    pidum.pdm_berkas_tahap1 d 
                    INNER JOIN (
                    select x.* from 
                    pidum.pdm_pengantar_tahap1 x inner join (
                    select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
                    )y on x.id_pengantar = y.id_pengantar
                    ) e on d.id_berkas = e.id_berkas
                    INNER JOIN pidum.ms_tersangka_berkas f on e.id_berkas = f.id_berkas
                    INNER JOIN pidum.pdm_p24 a on e.id_pengantar = a.id_pengantar
                    left join pidum.pdm_p22 b on a.id_pengantar = b.id_pengantar
                    inner join pidum.pdm_p19 c on a.id_pengantar = c.id_pengantar
                    where d.id_berkas='".$berkas."' 
                    GROUP BY d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') ,a.id_pengantar,coalesce(b.id_p22,'0')
                    ,c.no_surat ||'<br/>'||to_char(c.tgl_dikeluarkan,'DD-MM-YYYY'),to_char(c.tgl_terima,'DD-MM-YYYY') 
                    ,b.no_surat||'<br/>'||to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),c.tgl_terima,d.id_berkas";
          //echo '<pre>';print_r($query);exit;
           $command         = Yii::$app->db->createCommand($query);
           $rows            = $command->queryAll();
           $id_p22          = $rows[0]['id_p22'];
           if($id_p22==''){
            $id_p22= '0';
           }
           //$id_pengantar    = $rows[0]['id_pengantar'];
           return $this->redirect(['update','id'=>$id_p22,'id_pengantar'=>$id_pengantar]);
       }
   }

    public function actionUpdate($id,$id_pengantar)
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P22]);
        $id_perkara = Yii::$app->session->get('id_perkara');
        $model = $this->findModel($id);
        $id_p22 = $id;
        $ex_id = explode('|', $id_pengantar);
		
		if ($model == null) {
            $model = new PdmP22();
			$file_lama = '';
        }else{
			$file_lama = $model->getOldAttributes()['file_upload'];
		}
		
		$modelPengantar = PdmPengantarTahap1::findOne(['id_pengantar'=>$id_pengantar]);
    $modelTersangka = MsTersangkaBerkas::findAll(['no_pengantar'=>$ex_id[1]]);
    // /echo '<pre>';print_r($modelTersangka);exit;
		$data_berkas = Yii::$app->db->createCommand("SELECT b.no_berkas,to_char(b.tgl_berkas,'DD-MM-YYYY') as tgl_berkas, to_char(a.tgl_terima,'DD-MM-YYYY') as tgl_terima FROM pidum.pdm_pengantar_tahap1 a INNER JOIN pidum.pdm_berkas_tahap1 b ON a.id_berkas = b.id_berkas WHERE a.id_pengantar = '".$id_pengantar."'  ")->queryOne();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
			
			$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p22 WHERE id_berkas='".$modelPengantar->id_berkas."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
			
			$files = UploadedFile::getInstance($model, 'file_upload');
			
			if ($files != false && !empty($files) ) {
				if($file_lama !=''){
					$model->file_upload = $file_lama;
					$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p22_'.$file_lama.'.'.$files->extension;
					$files->saveAs($path);
				}else{
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p22_'.$jml_pt['jml'].'.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p22_'.$jml_pt['jml'].'.'.$files->extension;
					$files->saveAs($path);
				}
			}else{
				$model->file_upload = $file_lama;
			}
            $model->id_p22 = $modelPengantar->id_berkas."|".$_POST['PdmP22']['no_surat'];
            $model->id_pengantar = $id_pengantar;
            $model->id_berkas = $modelPengantar->id_berkas;
			
			if($_POST['hdn_nama_penandatangan'] != ''){
				$model->nama = $_POST['hdn_nama_penandatangan'];
				$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
				$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
			}

                if($id_p22 == 0 || $model->id_p22 == null)
              {

                  $id_perkara_p22 = Yii::$app->session->get('id_perkara');
                  $NextProcces = array(ConstSysMenuComponent::P23);
                  Yii::$app->globalfunc->getNextProcces($id_perkara_p22,$NextProcces); 
              }

            if(!$model->save()){
				echo "---";var_dump($model->getErrors());exit;
			}

            
			
            if (isset($_POST['new_tembusan'])) {
				$id_p22= $modelPengantar->id_berkas."|".$_POST['PdmP22']['no_surat'];
				
				PdmTembusanP22::deleteAll(['id_p22'=>$id_p22]);
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanP22();
                    $modelNewTembusan->id_p22 = $id_p22;
                    $modelNewTembusan->id_tembusan = $id_p22."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                    if(!$modelNewTembusan->save()){
						echo "--";var_dump($modelNewTembusan->getErrors());exit;
					}
                }
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
            return $this->redirect(['update', 'id'=>$model->id_p22, 'id_pengantar'=>$id_pengantar]);
			
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
                        'modelTersangka' => $modelTersangka,
                        'sysMenu' => $sysMenu,
                        'data_berkas' => $data_berkas
            ]);
        }
    }
    /**
     * Deletes an existing PdmP22 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
       $id = $_POST['hapusIndex'];

		$session = new Session();
		$id_perkara = $session->get('id_perkara'); 
  
		$connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
			if($id == "all"){ 
				Yii::$app->db->createCommand(" DELETE FROM pidum.pdm_p22 WHERE id_berkas IN (SELECT id_berkas FROM pidum.pdm_berkas_tahap1 where id_perkara='".$id_perkara."') ")->execute();
			
			}else{
			   for ($i = 0; $i < count($id); $i++) {
				   PdmP22::deleteAll(['id_p22' => $id[$i]]);
				   
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

    #ceepee

    public function actionCetak($id_p22) {
		$id_perkara=Yii::$app->session->get('id_perkara');
        $odf = new Odf(Yii::$app->params['report-path'] . "web/template/pdsold/p22.odt");

        $model = $model = PdmP22::findOne(['id_p22' => $id_p22]);
        $pdmP19 = PdmP19::findOne(["id_p19" => $model->id_berkas]);
		
         $berkas = Yii::$app->db->createCommand("SELECT d.no_surat as no_p19,d.tgl_dikeluarkan as tgl_p19,a.no_berkas,a.tgl_berkas as tgl_berkas,b.tgl_terima as tgl_terima FROM pidum.pdm_berkas_tahap1 a INNER JOIN pidum.pdm_pengantar_tahap1 b on a.id_berkas = b.id_berkas 
		 INNER JOIN (
			select x.* from 
			pidum.pdm_pengantar_tahap1 x inner join (
				select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
			)y on x.id_pengantar = y.id_pengantar
                    ) c on b.id_berkas = c.id_berkas
			inner join pidum.pdm_p19 d on b.id_pengantar = d.id_pengantar
		 WHERE b.id_pengantar='".$model->id_pengantar."' ")->queryOne();
		
        $spdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
 $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p21a b','a.peg_nik = b.id_penandatangan')
->where ("id_p21a='".$id."'")
->one();
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        
        $odf->setVars('nomor', $model->no_surat);
	$sifat = \app\models\MsSifatSurat::findOne(['id'=>$model->sifat]);
        $odf->setVars('sifat', $sifat->nama);
        $odf->setVars('lampiran', $model->lampiran);
        $odf->setVars('kepada', $model->kepada);
        $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
        $odf->setVars('di_tempat', $model->di_kepada);
        $odf->setVars('nomorP19', $berkas['no_p19']);
        $odf->setVars('tanggalP19', Yii::$app->globalfunc->ViewIndonesianFormat($berkas['tgl_p19']));
        $odf->setVars('nomorpengirimanberkas', $berkas['no_berkas']);
        $odf->setVars('tanggalpengirimanberkas', Yii::$app->globalfunc->ViewIndonesianFormat($berkas['tgl_berkas']));
        $odf->setVars('tglterimaberkasMax', Yii::$app->globalfunc->ViewIndonesianFormat($berkas['tgl_terima']));



		
        
        $odf->setVars('pasal', Yii::$app->globalfunc->getAlternativePasal($id_perkara));
		
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
		
        $odf->setVars('nama', $nama_tersangka);
		
		$odf->setVars('kepala', $model->jabatan);
        $odf->setVars('nama_penandatangan', $model->nama);
        $odf->setVars('pangkat', preg_replace("/\/ (.*)/", "", $model->pangkat));
        $odf->setVars('nip_penandatangan', $model->id_penandatangan);

        #tembusan
        $query = new Query();
        $query->select('*')
                ->from('pidum.pdm_tembusan_p22')
                ->where("id_p22='" . $model->id_p22 . "' ")
                ->orderBy('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($element['no_urut']);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);

        $odf->exportAsAttachedFile('p22.odt');
    }

    /**
     * Finds the PdmP22 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP22 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP22::findOne(['id_p22' => $id])) !== null) {
            return $model;
        } /* else {
          throw new NotFoundHttpException('The requested page does not exist.');
          } */
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist2.');
        }
    }

}
