<?php

namespace app\modules\pdsold\controllers;
use Yii;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmP18;
use app\modules\pdsold\models\PdmP24;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmPengantarTahap1;
use app\modules\pdsold\models\MsTersangkaBerkas;
use app\modules\pdsold\models\MsInstPenyidik;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusanP18;
use app\modules\pdsold\models\PdmP18Search;
use app\modules\pdsold\models\PdmTrxPemrosesan;
use app\modules\pdsold\models\PdmPenandatangan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Object;
use yii\db\Query;
use yii\web\UploadedFile;
use yii\data\SqlDataProvider;

/**
 * PdmP18Controller implements the CRUD actions for PdmP18 model.
 */
class PdmP18Controller extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                   // 'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PdmP18 models.
     * @return mixed
     */
    public function actionIndex() {
        $berkas = Yii::$app->session->get('perilaku_berkas');
        if($berkas == ''){
            $id_perkara     = Yii::$app->session->get('id_perkara');
            $id_berkas      = Yii::$app->session->get('id_berkas');
            $query          = "SELECT
                a.id_berkas,
                a.tgl_berkas,
                a.no_berkas ||' '||to_char(a.tgl_berkas,'DD-MM-YYYY') as no_tgl_berkas,
                 coalesce(e.no_surat ||' ' ||to_char(e.tgl_dikeluarkan,'DD-MM-YYYY'),'-') as no_tgl_p18,                    
                d.id_p24,
                d.pendapat, 
                a.no_berkas,                    
                STRING_AGG(b.nama, '<br/>' ORDER BY b.id_tersangka) as nama_tersangka,
                c.id_pengantar,
                c.no_pengantar,
                to_char(c.tgl_pengantar,'DD-MM-YYYY') as tgl_pengantar,
                to_char(c.tgl_terima,'DD-MM-YYYY') as tgl_terima,
                coalesce(e.id_p18,'0') as id_p18
                FROM 
                pidum.pdm_berkas_tahap1 a
                INNER JOIN pidum.pdm_pengantar_tahap1 c on a.id_berkas = c.id_berkas
                INNER JOIN pidum.ms_tersangka_berkas b on b.id_berkas = a.id_berkas 
                INNER JOIN pidum.pdm_p24 d on d.id_pengantar = c.id_pengantar
                LEFT  JOIN pidum.pdm_p18 e on e.id_pengantar = c.id_pengantar    
                WHERE id_hasil = '2' and a.id_perkara = '".$id_perkara ."'
                GROUP BY 
                e.id_p18,a.id_berkas,c.id_pengantar,d.id_p24,c.no_pengantar,to_char(c.tgl_terima,'DD-MM-YYYY'),to_char(c.tgl_pengantar,'DD-MM-YYYY')
                ,to_char(c.tgl_terima,'DD-MM-YYYY')
            ";
            $command        = Yii::$app->db->createCommand($query);
            $rows           = $command->queryAll();
            $id_p18         = $rows[0]['id_p18'];
            $id_pengantar   = $rows[0]['id_pengantar'];
            if($id_p18 != null && $id_pengantar != null){
               return $this->redirect(['update','id_p18'=>$id_p18,'id_pengantar'=>$id_pengantar]);
            }
            else{
               $jml             = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();
               $qry             = Yii::$app->db->createCommand($query)->queryAll();
               $dataProvider    = new SqlDataProvider([
                    'sql' => $query,
                    'totalCount' => (int)$jml,
                    'sort' => [
                        'attributes' => [
                        'id_pengantar',
                        'id_p18',
                        'pendapat',
                        'no_tgl_berkas',
                        'tgl_terima',
                        'nama_tersangka',
                        ],
                    ],
                    'pagination' => [
                    'pageSize' => 10,
                    ]
                ]);
                $models = $dataProvider->getModels();
                return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    ]);
            }
        }else{
            $id_perkara = Yii::$app->session->get('id_perkara');
            $id_berkas  = Yii::$app->session->get('id_berkas');
            $query      = "SELECT
                a.id_berkas,
                a.tgl_berkas,
                a.no_berkas ||' '||to_char(a.tgl_berkas,'DD-MM-YYYY') as no_tgl_berkas,
                 coalesce(e.no_surat ||' ' ||to_char(e.tgl_dikeluarkan,'DD-MM-YYYY'),'-') as no_tgl_p18,                    
                d.id_p24,
                d.pendapat, 
                a.no_berkas,                    
                STRING_AGG(b.nama, '<br/>' ORDER BY b.id_tersangka) as nama_tersangka,
                c.id_pengantar,
                c.no_pengantar,
                to_char(c.tgl_pengantar,'DD-MM-YYYY') as tgl_pengantar,
                to_char(c.tgl_terima,'DD-MM-YYYY') as tgl_terima,
                coalesce(e.id_p18,'0') as id_p18
                FROM 
                pidum.pdm_berkas_tahap1 a
                INNER JOIN pidum.pdm_pengantar_tahap1 c on a.id_berkas = c.id_berkas
                INNER JOIN pidum.ms_tersangka_berkas b on b.id_berkas = a.id_berkas 
                INNER JOIN pidum.pdm_p24 d on d.id_pengantar = c.id_pengantar
                LEFT  JOIN pidum.pdm_p18 e on e.id_pengantar = c.id_pengantar    
                WHERE id_hasil = '2' and a.id_berkas = '".$berkas."'
                GROUP BY 
                e.id_p18,a.id_berkas,c.id_pengantar,d.id_p24,c.no_pengantar,to_char(c.tgl_terima,'DD-MM-YYYY'),to_char(c.tgl_pengantar,'DD-MM-YYYY')
                ,to_char(c.tgl_terima,'DD-MM-YYYY')
            ";

            //echo '<pre>';print_r($query);exit;
            $command        = Yii::$app->db->createCommand($query);
            $rows           = $command->queryAll();
            $id_p18         = $rows[0]['id_p18'];
            $id_pengantar   = $rows[0]['id_pengantar'];
            if($id_p18 != null && $id_pengantar != null){
               return $this->redirect(['update','id_p18'=>$id_p18,'id_pengantar'=>$id_pengantar]);
            }
            else{
               $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();
               $qry = Yii::$app->db->createCommand($query)->queryAll();
               $dataProvider =	new SqlDataProvider([
                    'sql' => $query,
                    'totalCount' => (int)$jml,
                    'sort' => [
                        'attributes' => [
                        'id_pengantar',
                        'id_p18',
                        'pendapat',
                        'no_tgl_berkas',
                        'tgl_terima',
                        'nama_tersangka',
                        ],
                    ],
                    'pagination' => [
                    'pageSize' => 10,
                    ]
                ]);
                $models = $dataProvider->getModels();
                return $this->render('index_1', [
                    'dataProvider' => $dataProvider,
                    ]);
            }
        }
    }

    /**
     * Displays a single PdmP18 model.
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
     * Creates a new PdmP18 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   public function actionCreate()
   {
        return $this->redirect(['update']);
       // $model = new PdmP18();

       // if ($model->load(Yii::$app->request->post()) && $model->save()) {
       //     return $this->redirect(['view', 'id' => $model->id_p18]);
       // } else {
       //     return $this->render('create', [
       //         'model' => $model,
       //     ]);
       // }
   }

    /**
     * Updates an existing PdmP18 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
     public function actionCekNoSurat()
    {
        //echo '<pre>';print_r($_);exit;
        $nop18 = str_replace(" ","",$_POST['no_surat']);
        $query = PdmP18::find()
        ->where(['REPLACE(no_surat,\' \',\'\')' => $nop18])
        ->all();
        echo count($query);
    }

    public function actionUpdate($id_p18,$id_pengantar)
    {
        
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P18]);
        $ex_id = explode('|', $id_pengantar);
        $id = Yii::$app->session->get('id_perkara');
		if($id_p18!="undefined"){
		$model = PdmP18::find()
				->where("id_pengantar='".$id_pengantar."' and id_p18='".$id_p18."'")
				->one();
		}
		
        if ($model == null) {
            $model = new PdmP18();
        }

		$pengantar = PdmPengantarTahap1::findOne(['id_pengantar'=>$id_pengantar]);
        $modelSpdp = $this->findModelSpdp($id);

        $modelPasalBerkas = Yii::$app->globalfunc->getAlternativePasal($id_pengantar);
        $modelTersangka = MsTersangkaBerkas::find()->where(['id_berkas' => $ex_id[0], 'no_pengantar'=> $ex_id[1]])->orderBy(['no_urut'=>sort_asc])->all();
        /*$modelTersangka   = MsTersangkaBerkas::find()
                              ->where (['id_berkas' => $pengantar->id_berkas])
                              ->all();*/
        
        
        $modelBerkas        = PdmBerkasTahap1::findOne(['id_perkara' => $id,'id_berkas'=>$pengantar->id_berkas]);
        $modelInsPenyidik   = MsInstPenyidik::findOne(['kode_ip' => $modelSpdp->id_asalsurat]);

        if ($model->load(Yii::$app->request->post())) {
			$transaction = Yii::$app->db->beginTransaction();
            //echo '<pre>';print_r($_POST);exit;
            try{



            $model->id_p18 = $pengantar->id_berkas."|".$_POST['PdmP18']['no_surat'];
            $ttd = $model->id_penandatangan;
                    //echo $ttd;exit;
            $seqttd = Yii::$app->db->createCommand("select * from pidum.vw_penandatangan where peg_nip_baru = '".$ttd."' ")->queryOne();
            $model->nama = $seqttd['nama'];
            $model->pangkat = $seqttd['pangkat'];
            $model->jabatan = $seqttd['jabatan'];
            $model->id_berkas = $pengantar->id_berkas;
            $model->id_pengantar = $id_pengantar;
            $files = UploadedFile::getInstance($model, 'file_upload'); 

            if ($files != false && !empty($files))
            {
                $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id).'/p18.' . $files->extension;
                $path = Yii::$app->basePath . '/web/template/pdsold_surat/' .preg_replace('/[^A-Za-z0-9\-]/', '',$id).'/p18.' . $files->extension;                        
                $files->saveAs($path);
            }
			
			if(file_exists(Yii::$app->basePath . '/web/template/pdsold_surat/' .preg_replace('/[^A-Za-z0-9\-]/', '',$id).'/p18.pdf'))
			{
			   $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id).'/p18.pdf';  
			}

            if(!$model->save()){
				var_dump($model->getErrors());exit;
			}


            
            if (isset($_POST['new_tembusan'])) {
               if($id_p18 != 0 or $model->id_p18 != null)
                {
                  PdmTembusanP18::deleteAll(['id_p18'=>$model->id_p18]);
                }
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {

                    $modelNewTembusan = new PdmTembusanP18();
                    $modelNewTembusan->id_p18 = $model->id_p18;
                    $modelNewTembusan->id_tembusan = $model->id_p18."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                    if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
                }
            }
            $transaction->commit();
                     Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil Disimpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                    ]);

                

    			if($_POST['print']=='0'){
                    return $this->redirect(['index']);
                }


			
            
            
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
                    return $this->redirect('index');
            }
            
        

        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'modelPengantar' => $pengantar,
                        'modelBerkas' => $modelBerkas,
                        'modelTersangka' => $modelTersangka,
                        'modelInsPenyidik' => $modelInsPenyidik,
                        'sysMenu' => $sysMenu
            ]);
        }
    }
	
	public function actionCetak($id_p18,$id_pengantar){
		$id_perkara = Yii::$app->session->get('id_perkara');
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path'] . "web/template/pdsold/p18.odt");
        $id = Yii::$app->session->get('id_perkara');
        $model = PdmP18::findOne(['id_p18' => $id_p18]);
        $berkas = PdmBerkasTahap1::findOne(['id_berkas' => $model->id_berkas]);
        $pengantar = PdmPengantarTahap1::findOne(['id_pengantar' => trim($id_pengantar) ]);
       
        $spdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        $sifat = \app\models\MsSifatSurat::findOne(['id'=>$model->sifat]);
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

$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p18 b','a.peg_nik = b.id_penandatangan')
->where ("id_p18='".$id_p18."'")
->one();

$ttd = PdmPenandatangan::find()
->select ("a.nama as nama,a.pangkat as pangkat,a.peg_nik as peg_nik")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p18 b','a.peg_nik = b.id_penandatangan')
->where ("id_p18='".$id_p18."'")
->one();
      $kode=$spdp->wilayah_kerja;
    if ($kode='00'){
        $odf->setVars('Kejaksaan', 'JAKSA AGUNG MUDA TINDAK PIDANA UMUM');
        //$odf->setVars('kepala','');
    }   else {
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);  
        //$odf->setVars('kepala','KEPALA');
    }
       $odf->setVars('kejaksaan', $model->jabatan);

        $odf->setVars('nomor', $model->no_surat);
        $odf->setVars('sifat', $sifat->nama);
        $odf->setVars('lampiran', $model->lampiran);
        $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
        $odf->setVars('tanggal_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
        $odf->setVars('kepada', $model->kepada);
        $odf->setVars('di_tempat', $model->di_kepada);
 //     print_r($modelTersangka);exit;

        #list Tersangka
        $odf->setVars('tersangka_lampiran', $nama_tersangka);
        $odf->setVars('tersangka',$nama_tersangka);
    
        $odf->setVars('no_berkas', $berkas->no_berkas);
        $odf->setVars('tanggal_berkas', Yii::$app->globalfunc->ViewIndonesianFormat($berkas->tgl_berkas));
        $odf->setVars('tanggal_terima', Yii::$app->globalfunc->ViewIndonesianFormat($pengantar->tgl_terima));

        $odf->setVars('pasal', Yii::$app->globalfunc->getAlternativePasal($model->id_pengantar));

        #tembusan
        $dft_tembusan = '';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_p18')
                ->where("id_p18='" . $model->id_p18 . "' ")
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
        $sql = "SELECT * FROM  "
              . " pidum.pdm_p18 "
              . "where id_p18='" .$id_p18. "'";
        $model1 = $connection->createCommand($sql);
        $penandatangan = $model1->queryOne();
        
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $odf->setVars('pangkat', preg_replace("/\/ (.*)/", "", $penandatangan['pangkat']));
        $odf->setVars('nip_penandatangan', $penandatangan['id_penandatangan']);


        $odf->exportAsAttachedFile('P18.odt');
    }

    /**
     * Deletes an existing PdmP18 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
         $id = $_POST['hapusIndex'];
         
         $id_perkara = Yii::$app->session->get('id_perkara');
		$cek = Yii::$app->db->createCommand(" SELECT count(*) jml FROM pidum.pdm_p19 a WHERE  a.id_p18='".$id[0]."' ")->queryOne();
		
		if($cek['jml'] > 0){
			
			Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data P-18 Sudah Digunakan Di P-19',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
		}else{
        if($id == "all")
        {   
			
            
            return $this->redirect(['index']);
        }
        else
        {  
               for ($i = 0; $i < count($id); $i++) 
               {   
					PdmP18::deleteAll(['id_p18' => $id[$i]]);
                    
                    
                }
        }
		}
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmP18 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP18 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP18::findOne(['id_perkara' => $id])) !== null) {
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
}
