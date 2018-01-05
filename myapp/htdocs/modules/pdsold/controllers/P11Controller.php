<?php

namespace app\modules\pdsold\controllers;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmP11;
use app\modules\pdsold\models\PdmP11Search;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmTembusan;
use Jaspersoft\Client\Client;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pdsold\models\PdmSysMenu;
use yii\db\Query;

/**
 * PdmP17Controller implements the CRUD actions for PdmP17 model.
 */
class P11Controller extends Controller
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
     * Lists all PdmP17 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PdmP11Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmP11 model.
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
     * Creates a new PdmP11 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmP11();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_p11]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdmP11 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P11 ]);
        $session = new Session();

        $id = $session->get('id_perkara');
        $model = $this->findModel($id);
        if($model == null){
            $model = new PdmP11();
        }

        $modelTersangka = $this->findModelTersangka($id);
        $modelSpdp = $this->findModelSpdp($id);

        if ($model->load(Yii::$app->request->post())) {
            $id_p11 = PdmP11::findOne(['id_perkara' => $id]);
            
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p11', 'id_p11', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

            if($model->id_perkara != null){
                $model->flag = '2';
                $model->update();
            }else{
                $model->id_perkara = $id;
                $model->id_p11 = $id_p11->id_p11;
                $model->id_p11 = $seq['generate_pk'];
                $model->save();
            }

            //Insert tabel tembusan 

            PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara]);		
            if(isset($_POST['new_tembusan'])){
                     for($i = 0; $i < count($_POST['new_tembusan']); $i++){
                        $modelNewTembusan= new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_p11;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table =  GlobalConstMenuComponent::P11;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];					
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];	        		
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                  }
        	}

            
            /*
            $trxPemroresan = PdmTrxPemrosesan::findOne(['id_perkara' => $id]);
            $trxPemroresan->id_perkara = $id;
            $trxPemroresan->id_sys_menu = "2";
            $trxPemroresan->id_user_login = Yii::$app->user->identity->username;
            $trxPemroresan->update();
             
             */
             if($model->save()){
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                //return $this->redirect('index');
                return $this->redirect(['update','id'=>$model->id_perkara]);
            }
            
			
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTersangka' => $modelTersangka,
                'modelSpdp' => $modelSpdp,
                'sysMenu' => $sysMenu,
            ]);
        }
    }

    public function actionCetak($id){
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/p11.odt");

        $spdp = PdmSpdp::findOne(['id_perkara' => $id]);
        $p11 = PdmP11::findOne(['id_perkara' => $id]);
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kepala', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        //$odf->setVars('nomor', $p11->no_surat);
    
        
        #list Tersangka
        $dft_tersangka ='';
        // $query = new Query;
        // $query->select('*')
        //         ->from('pidum.ms_tersangka')
        //         ->where("id_perkara='".$id."'");
        // $data = $query->createCommand();
        // $listTersangka = $data->queryAll();  
        // foreach($listTersangka as $key){            
        //     $dft_tersangka .= $key[nama].',';
        // }
        // $odf->setVars('tersangka', $dft_tersangka);       
           
        # tersangka
        $sql ="select no_surat,sifat,lampiran,kepada,di,tgl_dikeluarkan from pidum.pdm_p11 where pdm_p11.id_perkara='".$id."'";
        $model = $connection->createCommand($sql);
        $ket_surat = $model->queryOne();

        // if($tersangka['tgl_lahir']){
        // $umur = Yii::$app->globalfunc->datediff($tersangka['tgl_lahir'],date("Y-m-d"));
        // $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($tersangka['tgl_lahir']);  
        // }else{
        //     $tgl_lahir = '-';
        // }
        // $odf->setVars('nama_lengkap', ucfirst(strtolower($tersangka['nama'])));       
        // $odf->setVars('tempat_lahir', ucfirst(strtolower($tersangka['tmpt_lahir'])));       
        // $odf->setVars('tgl_lahir', $tgl_lahir); 
        $odf->setVars('nomor', ucfirst(strtolower($ket_surat['no_surat']))); 
        $odf->setVars('sifat', ucfirst(strtolower($ket_surat['sifat']))); 
        $odf->setVars('lampiran', ucfirst(strtolower($ket_surat['lampiran']))); 
        $odf->setVars('kepada', ucfirst(strtolower($ket_surat['kepada']))); 
        $odf->setVars('tempat', ucfirst(strtolower($ket_surat['di']))); 
        $odf->setVars('tanggal', ucfirst(strtolower($ket_surat['tgl_dikeluarkan']))); 

        $strsql="select*from pidum.ms_tersangka where id_perkara='".$id."'";
        $model = $connection->createCommand($strsql);
        $tersangka = $model->queryOne();
        $odf->setVars('tersangka', ucfirst(strtolower($tersangka['nama']))); 
        // $odf->setVars('warganegara', ucfirst(strtolower($tersangka['warganegara']))); 
        // $odf->setVars('tmpt_tinggal', ucfirst(strtolower($tersangka['alamat']))); 
        // $odf->setVars('agama', ucfirst(strtolower($tersangka['is_agama']))); 
        // $odf->setVars('pekerjaan', ucfirst(strtolower($tersangka['pekerjaan']))); 
        // $odf->setVars('pendidikan', ucfirst(strtolower($tersangka['is_pendidikan']))); 
        // $odf->setVars('lain-lain', '-');
         #Jaksa Peneliti
        // $query = new Query;
        // $query->select('peg_nip_baru,jpu.nama,jabatan,pangkat')
        //         ->from('pidum.pdm_jaksa_saksi jpu, kepegawaian.kp_pegawai ')
        //         ->where(" peg_nik=nip and id_perkara='".$id."' AND code_table='".GlobalConstMenuComponent::P16."'")
        //         ->orderby('no_urut');
        // $dt_jaksaPeneliti = $query->createCommand();
        // $listjaksaPeneliti = $dt_jaksaPeneliti->queryAll();
        // $dft_jaksaPeneliti = $odf->setSegment('jaksaPeneliti');
        // $i=1;
        // foreach($listjaksaPeneliti as $element){
        //         $dft_jaksaPeneliti->urutan($i);
        //         $dft_jaksaPeneliti->nama_pegawai($element['nama']);
        //         $dft_jaksaPeneliti->nip_pegawai($element['peg_nip_baru']);
        //         $dft_jaksaPeneliti->pangkat($element['pangkat']);
        //         $dft_jaksaPeneliti->jabatan($element['jabatan']);
        //         $dft_jaksaPeneliti->merge();
        //     $i++;
        // }
        //$odf->mergeSegment($dft_jaksaPeneliti);  
          
          
        #tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_p9');
                // ->orderby('no_urut');
                // ->where("id_perkara='".$id."' AND kode_table='".GlobalConstMenuComponent::P16."'")
        $dt_saksi = $query->createCommand();
        $listTembusan = $dt_saksi->queryAll();
        $dft_saksi = $odf->setSegment('saksi');

        $no=1;
        foreach($listTembusan as $element){
                $dft_saksi->no_urut($no);
                $dft_saksi->nm_saksi($element['kepada']);
                // $dft_saksi->nm_saksi($element['kepada']);s
                $dft_saksi->merge();
                $no++;
        }
        $odf->mergeSegment($dft_saksi);
      
        #penanda tangan
        $sql ="SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_p16 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='".$id."'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama', $penandatangan['nama']);       
        $odf->setVars('pangkat', $penandatangan['pangkat']);       
        // $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);       
        
      
        $odf->exportAsAttachedFile();
        //$c = new Client("http://192.168.11.11/jasperserver", "jasperadmin", "jasperadmin");
        /* $js = $c->jobService();
        $js->getJob("/reports/pdsold/hargaResorces");
        $c->setRequestTimeout(60);

        $coba = new \Jaspersoft\Dto\Resource\ReportUnit();

        $coba->label = 'coba report'; */

        // $controls = array(
        //     'id_perkara' => ["$id"]
        // );


        // $report = $c->reportService()->runReport('/reports/pdsold/pdm_p11', 'rtf', null, null, $controls);

        /* header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=pdm-p16.docx');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');*/

        /*header('Content-Description: File Transfer');
        //header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header("Content-Disposition: attachment; filename=pdm_p11.rtf");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($report));

        echo $report;*/
    }

    /**
     * Deletes an existing PdmP11 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmP11 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP11 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP11::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        }/* else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }

    protected function findModelTersangka($id)
    {
        if (($model = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
