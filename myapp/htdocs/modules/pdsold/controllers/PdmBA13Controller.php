<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmBa13;
use app\modules\pdsold\models\PdmBa13Search;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmRp9;
use app\modules\pdsold\models\PdmRt3;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\MsLoktahanan;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmTahananPenyidik;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\components\GlobalConstMenuComponent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pdsold\models\PdmSysMenu;
use Odf;
use app\models\KpPegawai;
use yii\db\Query;
/**
 * PdmBA13Controller implements the CRUD actions for PdmBA13 model.
 */
class PdmBa13Controller extends Controller
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
     * Lists all PdmBA13 models.
     * @return mixed
     */
   /*  public function actionIndex()
    {
        $searchModel = new PdmBA13Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    */
    public function actionIndex()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA13 ]);
        $idPerkara = Yii::$app->session->get('id_perkara');

        $searchModel = new PdmBa13Search();
        $dataProvider = $searchModel->search($idPerkara, Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = '15';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
        
    }
    
    /**
     * Displays a single PdmBA13 model.
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
     * Creates a new PdmBA13 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA13 ]);
        $model = new PdmBa13();
        $id_perkara = Yii::$app->session->get('id_perkara');
   
        // $modeljaksi = PdmJaksaSaksi::findAll(['id_perkara' => $id_perkara, 'code_table' => GlobalConstMenuComponent::BA13, 'id_table' => $model->id_ba13]);
        // if ($modeljaksi == null) {
        //     $modeljaksi = new PdmJaksaSaksi();
        // }
        
        $modeljaksi = $model->jaksaPelaksana($id_perkara);
        
        $modelSpdp = $this->findModelSpdp($id_perkara); 
        $modelPasal = $this->findModelPasal($id_perkara);
        $modelLokTahanan = \yii\helpers\ArrayHelper::map(MsLoktahanan::find()->asArray()->all(),'id_loktahanan','nama');

        $modelRp9 = PdmRp9::findOne(['id_perkara' => $id_perkara]);
        
       
       if ($model->load(Yii::$app->request->post())) {
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba13', 'id_ba13', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
            $model->id_ba13 = $seq['generate_pk'];
            $model->id_perkara =  $id_perkara;
            $model->save();
            
            // $nip = $_POST['txtnip'];
            // $nama = $_POST['txtnama'];
            // $pangkat = $_POST['txtpangkat'];
            // $jabatan = $_POST['txtjabatan'];
            // for ($i = 0; $i < count($nip); $i++) {
            $jaksa_pelaksana = explode("#", $_POST['jaksa_pelaksana']); // [0] => nip, [1] => nama, [2] => jabatan, [3] => pangkat
            $modeljaksi2 = new PdmJaksaSaksi();
            $seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
            $modeljaksi2->id_perkara = $id_perkara;
            $modeljaksi2->id_jpp = $seqJpu['generate_pk'];
            $modeljaksi2->code_table = GlobalConstMenuComponent::BA13;
            $modeljaksi2->id_table = $model->id_ba13;
            $modeljaksi2->nip = $jaksa_pelaksana[0];
            $modeljaksi2->nama = $jaksa_pelaksana[1];
            $modeljaksi2->jabatan = $jaksa_pelaksana[2];
            $modeljaksi2->pangkat = $jaksa_pelaksana[3];
            $modeljaksi2->save();
            // }
                    
            // if($model->save()){
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
            return $this->redirect(['index']);
            //}
        } else {
            return $this->render('create', [
                'model' => $model,
                // 'searchJPU' => $searchJPU,
                // 'dataJPU' => $dataJPU,
                'modelRp9' => $modelRp9,
                'modeljaksi' => $modeljaksi,
                'modelSpdp' => $modelSpdp,
                'modelLokTahanan' => $modelLokTahanan,
                'sysMenu' => $sysMenu,
            ]); 
        }
    }

    /**
     * Updates an existing PdmBA13 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_ba13)
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA13 ]);

        $model = $this->findModel($id_ba13);
        if($model == null){
            $model = new PdmBa13();
        }

        $modeljaksiChoosen = PdmJaksaSaksi::findOne(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA13, 'id_table' => $model->id_ba13]);

        $modeljaksi = $model->jaksaPelaksana($model->id_perkara);

        $modelSpdp = $this->findModelSpdp($model->id_perkara);
        $modelPasal = $this->findModelPasal($model->id_perkara);
        $modelLokTahanan = \yii\helpers\ArrayHelper::map(MsLoktahanan::find()->asArray()->all(),'id_loktahanan','nama');
        
        $modelRp9 = PdmRp9::findOne(['id_perkara' => $model->id_perkara]);
        $modelRt3 = PdmRt3::findOne(['id_perkara' => $model->id_perkara, 'id_tersangka' => $model->id_tersangka]);
        $tahanan = PdmTahananPenyidik::findOne(['id_perkara' => $model->id_perkara, 'id_tersangka' => $model->id_tersangka]);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //update tabel pdm_ba13
            $model->flag = '2';
            $model->update();

            PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=> GlobalConstMenuComponent::BA13]);
            // $nip = $_POST['txtnip'];
            // $nama = $_POST['txtnama'];
            // $pangkat = $_POST['txtpangkat'];
            // $jabatan = $_POST['txtjabatan'];
            // for ($i = 0; $i < count($nip); $i++) {
            $jaksa_pelaksana = explode("#", $_POST['jaksa_pelaksana']); // [0] => nip, [1] => nama, [2] => jabatan, [3] => pangkat
            $modeljaksi2 = new PdmJaksaSaksi();
            $seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

            $modeljaksi2->id_perkara = $model->id_perkara;
            $modeljaksi2->id_jpp = $seqJpu['generate_pk'];
            $modeljaksi2->code_table = GlobalConstMenuComponent::BA13;
            $modeljaksi2->id_table = $model->id_ba13;
            $modeljaksi2->nip = $jaksa_pelaksana[0];
            $modeljaksi2->nama = $jaksa_pelaksana[1];
            $modeljaksi2->jabatan = $jaksa_pelaksana[2];
            $modeljaksi2->pangkat = $jaksa_pelaksana[3];
            $modeljaksi2->save();
            // }
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Diubah', // String
                'title' => 'Ubah Data', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);    
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'searchJPU' => $searchJPU,
                'dataJPU' => $dataJPU,
                'tahanan' => $tahanan,
                'modelRp9' => $modelRp9,
                'modelRt3' => $modelRt3,
                'modeljaksi' => $modeljaksi,
                'modeljaksiChoosen' => $modeljaksiChoosen,
                'modelSpdp' => $modelSpdp,
                'modelLokTahanan' => $modelLokTahanan,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Deletes an existing PdmBA13 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        try{
            $id = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id_perkara = $session->get('id_perkara');

                PdmBa13::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                    $model = $this->findModel($id[$i]);
                    $model->flag = '3';
                    $model->update();
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
            return $this->redirect(['index']);
        }catch (Exception $e){
            Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Hapus',
                        'title' => 'Hapus Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
            return $this->redirect(['index']);
        }
    }

	
	public function actionCetak($id) {
		$connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pdsold/template/ba13.odt");
		$model = PdmBa13::findOne(['id_ba13' => $id]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $model->id_perkara]);
		$jaksa = PdmJaksaSaksi::findOne(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA13]);
		$modelPegawai = KpPegawai::findOne(['peg_nik' => $jaksa->nip]);		
        $tahanan = PdmTahananPenyidik::findOne(['id_perkara' => $model->id_perkara, 'id_tersangka' => $model->id_tersangka]);
        
        $odf->setVars('hari', Yii::$app->globalfunc->getNamaHari($model->tgl_pembuatan));
        $odf->setVars('tgl_pembuatan', Yii::$app->globalfunc->getTanggalBeritaAcara($model->tgl_pembuatan));
        $odf->setVars('Kejaksaan', ucwords(strtolower(Yii::$app->globalfunc->setKepalaReport($spdp->wilayah_kerja))));
        $msloktahanan=Msloktahanan::findOne(['id_loktahanan'=>$model->id_ms_loktahanan]);
        $odf->setVars('dari_tahanan',$msloktahanan->nama );
        
        $querySuratPerintah = Yii::$app
                            ->db
                            ->createCommand("SELECT t8.no_surat, t8.tgl_permohonan FROM pidum.pdm_ba13 ba13
                                INNER JOIN pidum.pdm_t8 t8 ON ba13.id_perkara = t8.id_perkara
                                WHERE ba13.id_ba13 = '$id' AND ba13.id_perkara = '$model->id_perkara' AND t8.flag <> '3'
                                AND t8.tgl_permohonan = (SELECT MAX(tgl_permohonan) FROM pidum.pdm_t8 WHERE id_perkara = '$model->id_perkara')")
                            ->queryOne();
        #isi
        $odf->setVars('nomor', $querySuratPerintah['no_surat']);
        $odf->setVars('tanggal_permohonan', Yii::$app->globalfunc->ViewIndonesianFormat($querySuratPerintah['tgl_permohonan']));
        
        # tersangka
        $sql ="SELECT tersangka.* FROM "
                . " pidum.pdm_ba13 ba13 INNER JOIN pidum.vw_tersangka tersangka ON (ba13.id_tersangka = tersangka.id_tersangka ) "
                . "WHERE ba13.id_ba13='".$id."' "
                . "ORDER BY id_tersangka "
                . "LIMIT 1 ";
        $sqlTersangka = $connection->createCommand($sql);
        $tersangka = $sqlTersangka->queryOne();
        if($tersangka['tgl_lahir']){
        $umur = Yii::$app->globalfunc->datediff($tersangka['tgl_lahir'],date("Y-m-d"));
        $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($tersangka['tgl_lahir']);  
        }else{
            $tgl_lahir = '-';
        }
        $odf->setVars('nama_lengkap', ucfirst(strtolower($tersangka['nama'])));       
        $odf->setVars('tmpt_lahir', ucfirst(strtolower($tersangka['tmpt_lahir'])));       
        $odf->setVars('tgl_lahir', $tgl_lahir); 
        $odf->setVars('jenis_kelamin', ucfirst(strtolower($tersangka['is_jkl']))); 
        $odf->setVars('warganegara', ucfirst(strtolower($tersangka['warganegara']))); 
        $odf->setVars('tmpt_tinggal', ucfirst(strtolower($tersangka['alamat']))); 
        $odf->setVars('agama', ucfirst(strtolower($tersangka['is_agama']))); 
        $odf->setVars('pekerjaan', ucfirst(strtolower($tersangka['pekerjaan']))); 
        $odf->setVars('pendidikan', ucfirst($tersangka['is_pendidikan'])); 
        $odf->setVars('tgl_penahanan', !empty($tahanan->tgl_mulai) ? Yii::$app->globalfunc->ViewIndonesianFormat( $tahanan->tgl_mulai) : '-');
        $odf->setVars('no_reg_perkara',$model->no_reg_perkara); 
        $odf->setVars('no_reg_tahanan',$model->no_reg_tahanan); 
        
        #list pasal
        $dft_pasal ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_pasal')
                ->where("id_perkara='".$model->id_perkara."'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();  
        foreach($listPasal as $key){            
            $dft_pasal .= $key[undang].' '.$key['pasal'].',';
        }
        $dft_pasal= substr_replace($dft_pasal,"",-1);
        $odf->setVars('pasal', $dft_pasal); 
        
        
        #Jaksa Peneliti
        $query = new Query;
        $query->select('kpeg.peg_nip_baru,jpu.nama,jabatan,pangkat')
                ->from('pidum.pdm_jaksa_saksi jpu, kepegawaian.kp_pegawai kpeg')
                ->where(" kpeg.peg_nik = jpu.nip and jpu.id_perkara='".$model->id_perkara."' AND jpu.id_table = '" . $model->id_ba13 . "' AND jpu.code_table='".GlobalConstMenuComponent::BA13."'")
                ->orderby('jpu.no_urut');
        $dt_jaksaPeneliti = $query->createCommand();
        $listjaksaPeneliti = $dt_jaksaPeneliti->queryAll();
        $dft_jaksaPeneliti = $odf->setSegment('jaksaPeneliti');
        $i=1;
        foreach($listjaksaPeneliti as $element){
                $pangkat = explode('/',$element['pangkat']);
                $dft_jaksaPeneliti->urutan($i);
                $dft_jaksaPeneliti->nama_jaksa($element['nama']);
                $dft_jaksaPeneliti->nip_jaksa($element['peg_nip_baru']);
                $dft_jaksaPeneliti->pangkat_jaksa($pangkat[0]);
                $dft_jaksaPeneliti->merge();
            $i++;
        }
        $odf->mergeSegment($dft_jaksaPeneliti);  
        
      # Penandatangan
        $pangkat = explode ('/',$jaksa->pangkat );
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('nama_penandatangan', $jaksa->nama);
        $odf->setVars('nip_penandatangan', $modelPegawai->peg_nip_baru);
        $odf->setVars('pangkat', $pangkat[0]);
        $odf->setVars('kepala_rutan', $model->kepala_rutan);

        $odf->exportAsAttachedFile();
    }
    /**
     * Finds the PdmBA13 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBA13 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmBa13::findOne($id)) !== null) {
            return $model;
        } 
    }
    
    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne(['id_perkara' => $id])) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
     protected function findModelPasal($id) {
        if (($modelPasal = PdmPasal::findAll(['id_perkara' => $id])) !== null) {
            return $modelPasal;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
