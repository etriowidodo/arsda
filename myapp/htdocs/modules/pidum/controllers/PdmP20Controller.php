<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\PdmP19;
use app\modules\pidum\models\PdmP20;
use app\modules\pidum\models\PdmP20Search;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusanP20;
use app\modules\pidum\models\PdmTrxPemrosesan;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\MsTersangkaBerkas;
use app\modules\pidum\models\PdmPengantarTahap1;
use yii\base\Object;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\data\SqlDataProvider;
use yii\web\UploadedFile;

/**
 * PdmP20Controller implements the CRUD actions for PdmP20 model.
 */
class PdmP20Controller extends Controller
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
     * Lists all PdmP20 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $berkas = Yii::$app->session->get('perilaku_berkas');
        
	if($berkas == ''){
            
            $session        = new Session();
            $id_berkas      = $session->get('id_berkas');
            $id_perkara = Yii::$app->session->get('id_perkara');
            $id_berkas      = Yii::$app->session->get('id_berkas');
            $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P20]);
            $searchModel    = new PdmP20Search();
            $dataProvider   = $searchModel->searchdetail($id_perkara);
            return $this->render('index', [
                'dataProvider'  => $dataProvider,
                'sysMenu'       => $sysMenu
            ]);
        }else{
            $query = "select d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') as berkas,a.id_pengantar,coalesce(b.id_p20,'0') as id_p20 ,f.nama as nama
                    ,c.no_surat ||'<br/>'||to_char(c.tgl_dikeluarkan,'DD-MM-YYYY') as p19,to_char(c.tgl_terima,'DD-MM-YYYY') as tgl_p19
                    ,coalesce(b.no_surat||'<br/>'||to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),'-')  as p20,d.id_berkas
                    from 
                    pidum.pdm_berkas_tahap1 d 
                    INNER JOIN (select max(id_pengantar) as id_pengantar,id_berkas 
                        from 
                        pidum.pdm_pengantar_tahap1 
                        group by id_berkas) as e on d.id_berkas = e.id_berkas


                    INNER JOIN (select string_agg(nama,', ') as nama ,id_berkas 
                        from 
                        pidum.ms_tersangka_berkas
                        group by id_berkas) as  f on d.id_berkas = f.id_berkas
                    INNER JOIN pidum.pdm_p24 a on e.id_pengantar = a.id_pengantar                   
                    inner join pidum.pdm_p19 c on e.id_berkas = c.id_berkas
                    left join pidum.pdm_p20 b on e.id_pengantar = b.id_pengantar
                    where d.id_berkas='".$berkas."' 
                    GROUP BY d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') ,a.id_pengantar,coalesce(b.id_p20,'0')
                    ,c.no_surat ||'<br/>'||to_char(c.tgl_dikeluarkan,'DD-MM-YYYY'),to_char(c.tgl_terima,'DD-MM-YYYY') 
                    ,b.no_surat||'<br/>'||to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),c.tgl_terima,d.id_berkas,f.nama";
            $command        = Yii::$app->db->createCommand($query);
            $rows           = $command->queryAll();
            $id_p20         = $rows[0]['id_p20'];
            $id_pengantar   = $rows[0]['id_pengantar'];

            if($id_pengantar!="")
            {
                return $this->redirect(['update','id'=>$id_p20,'id_pengantar'=>$id_pengantar]);
            }
            else
            {
                    $session        = new Session();
                    $id_berkas      = $session->get('id_berkas');
                    $id_perkara = Yii::$app->session->get('id_perkara');
                    $id_berkas      = Yii::$app->session->get('id_berkas');
                    $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P20]);
                    $searchModel    = new PdmP20Search();
                    $dataProvider   = $searchModel->searchdetail($id_perkara);
                    return $this->render('index', [
                        'dataProvider'  => $dataProvider,
                        'sysMenu'       => $sysMenu
                    ]);
            }
        }
    }

    /**
     * Displays a single PdmP20 model.
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
     * Creates a new PdmP20 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->redirect(['update']);
        
        // $model = new PdmP20();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id_p20]);
        // } else {
        //     return $this->render('create', [
        //         'model' => $model,
        //     ]);
        // }
    }

    /**
     * Updates an existing PdmP20 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id,$id_pengantar)
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P20]);
        $id_perkara = Yii::$app->session->get('id_perkara');
        $model = $this->findModel($id);
		
		
        if ($model == null) {
            $model = new PdmP20();
			$file_lama = '';
        }else{
			$file_lama = $model->getOldAttributes()['file_upload'];
		}
		
		$modelPengantar = PdmPengantarTahap1::findOne(['id_pengantar'=>$id_pengantar]);
        
        $ex_id = explode('|', $id_pengantar);
        $modelTersangka = MsTersangkaBerkas::find()->where(['id_berkas' => $ex_id[0], 'no_pengantar'=> $ex_id[1]])->orderBy(['no_urut'=>sort_asc])->all();

		$data_berkas = Yii::$app->db->createCommand("SELECT b.no_berkas,to_char(b.tgl_berkas,'DD-MM-YYYY') as tgl_berkas, to_char(a.tgl_terima,'DD-MM-YYYY') as tgl_terima FROM pidum.pdm_pengantar_tahap1 a INNER JOIN pidum.pdm_berkas_tahap1 b ON a.id_berkas = b.id_berkas WHERE a.id_pengantar = '".$id_pengantar."'  ")->queryOne();
		
		 


        if ($model->load(Yii::$app->request->post())) {
            
           $jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p20 WHERE id_berkas='".$modelPengantar->id_berkas."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
			
			$files = UploadedFile::getInstance($model, 'file_upload');
			
			if ($files != false && !empty($files) ) {
				if($file_lama !=''){
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p20_'.$file_lama.'.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p20_'.$file_lama.'.'.$files->extension;
					$files->saveAs($path);
				}else{
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p20_'.$jml_pt['jml'].'.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p20_'.$jml_pt['jml'].'.'.$files->extension;
					$files->saveAs($path);
				}
			}else{
				$model->file_upload = $file_lama;
			}
			

            
				if($_POST['hdn_nama_penandatangan'] != ''){
					$model->nama = $_POST['hdn_nama_penandatangan'];
					$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
					$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
				}
               
			
           
                $model->id_p20 = $modelPengantar->id_berkas."|".$_POST['PdmP20']['no_surat'];
                $model->id_pengantar = $id_pengantar;
                $model->id_berkas = $modelPengantar->id_berkas;
				if($_POST['hdn_nama_penandatangan'] != ''){
					$model->nama = $_POST['hdn_nama_penandatangan'];
					$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
					$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
				}
                if(!$model->save()){
					var_dump($model->getErrors());exit;
				}
				if ($files != false && !empty($files) ) {
						$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p20_'.$model->id_p20.'.'. $files->extension;
						$files->saveAs($path);
				}
              
            PdmTembusanP20::deleteAll(['id_p20' => $model->id_p20]);
            if (isset($_POST['new_tembusan'])) {
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanP20();
                    $modelNewTembusan->id_p20 = $model->id_p20;
                    $modelNewTembusan->id_tembusan = $model->id_p20."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                    if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
                }
            }

            

            //notifkasi simpan
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
            //return $this->redirect(\Yii::$app->urlManager->createUrl("pidum/spdp/index"));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        //'modelPasalBerkas' => $modelPasalBerkas,
                       // 'modelP19' => $modelP19,
                        //'modelSpdp' => $modelSpdp,
                        'modelTersangka' => $modelTersangka,
                        'sysMenu' => $sysMenu,
                        'data_berkas' => $data_berkas
            ]);
        }
    }

    /**
     * Deletes an existing PdmP20 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = $_POST['hapusIndex'];

		$session = new Session();
		$id_perkara = $session->get('id_perkara'); 
  
		$connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
			if($id == "all"){ 
				Yii::$app->db->createCommand(" DELETE FROM pidum.pdm_p20 WHERE id_berkas IN (SELECT id_berkas FROM pidum.pdm_berkas_tahap1 where id_perkara='".$id_perkara."') ")->execute();
			
			}else{
			   for ($i = 0; $i < count($id); $i++) {
				   PdmP20::deleteAll(['id_p20' => $id[$i]]);
				   
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

    /**
     * Finds the PdmP20 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP20 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP20::findOne(['id_p20' => $id])) !== null) {
            return $model;
        } /* else {
            throw new NotFoundHttpException('The requested page does not exist.');
        } */
    }
    
    protected function findModelSpdp($id)
    {
    	if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
    		return $modelSpdp;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist2.');
    	}
    }
    
    public function actionCetak($id_p20) {
		 $id_perkara = Yii::$app->session->get('id_perkara');
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path'] . "web/template/pidum/p20.odt");

        $model = PdmP20::findOne(['id_p20' => $id_p20]);
        $berkas = Yii::$app->db->createCommand("SELECT a.no_berkas,a.tgl_berkas as tgl_berkas,b.tgl_terima as tgl_terima FROM pidum.pdm_berkas_tahap1 a INNER JOIN pidum.pdm_pengantar_tahap1 b on a.id_berkas = b.id_berkas WHERE b.id_pengantar='".$model->id_pengantar."' ")->queryOne();

        $spdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
		
       $listTersangka = Yii::$app->db->createCommand(" select a.nama FROM pidum.ms_tersangka_berkas a WHERE a.id_berkas='".$model->id_berkas."' ORDER BY a.no_urut desc  ")->queryAll();
			
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

        
        $odf->setVars('tersangka_lampiran', $nama_tersangka);
        
        $odf->setVars('tersangka', $nama_tersangka);

        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kepala', $model->jabatan);
        $odf->setVars('nomor', $model->no_surat);
        $sifat = \app\models\MsSifatSurat::findOne(['id'=>$model->sifat]);
        $odf->setVars('sifat', $sifat->nama);
        $odf->setVars('lampiran', $model->lampiran);
        $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
        $odf->setVars('tanggal_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
        
        $dft_pasal = Yii::$app->globalfunc->getAlternativePasal($id_perkara);
        $odf->setVars('pasal', $dft_pasal);
        $odf->setVars('kepada', $model->kepada);
        $odf->setVars('di_tempat', $model->di_kepada);
        $odf->setVars('nomorpengirimanberkas', $berkas['no_berkas']);
        $odf->setVars('tanggalpengirimanberkas', Yii::$app->globalfunc->ViewIndonesianFormat($berkas['tgl_berkas']));
        $odf->setVars('tanggalterimapengirimanberkas', Yii::$app->globalfunc->ViewIndonesianFormat($berkas['tgl_terima']));
		 #tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_p20')
                ->where("id_p20='" . $model->id_p20 . "' ")
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
        #penanda tangan
        
        $odf->setVars('nama_penandatangan', $model->nama);
        $odf->setVars('pangkat', preg_replace("/\/ (.*)/", "", $model->pangkat));

        $odf->setVars('nip_penandatangan', $model->id_penandatangan);



       

        $odf->exportAsAttachedFile('P20.odt');
        
    }
}
