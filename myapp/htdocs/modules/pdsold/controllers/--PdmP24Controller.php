<?php

namespace app\modules\pdsold\controllers;

use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmJpu;
use app\modules\pdsold\models\PdmP16;
use app\modules\pdsold\models\PdmP17;
use app\modules\pdsold\models\PdmP24;
use app\modules\pdsold\models\PdmP24Search;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
//use app\modules\pdsold\models\PdmP16;

/**
 * PdmP24Controller implements the CRUD actions for PdmP24 model.
 */
class PdmP24Controller extends Controller
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
     * Lists all PdmP24 models.
     * @return mixed
     */
    public function actionIndex()
    {
	$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P24]);
        $id_perkara = Yii::$app->session->get('id_perkara');

        $searchModel = new PdmP24Search();
        $dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmP24 model.
     * @param string $id
     * @return mixed
     */
   /* public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Creates a new PdmP24 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P24]);
        $id_perkara = Yii::$app->session->get('id_perkara');

        $modelSpdp = $this->findModelSpdp($id_perkara);
		$modelJpu = PdmJaksaSaksi::find()->where(['id_perkara' => $id_perkara, 'code_table' => GlobalConstMenuComponent::P16])->orderBy('no_urut asc')->all();
        $model = new PdmP24();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p24', 'id_p24', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            $model->id_p24 = $seq['generate_pk'];
            $model->id_perkara = $id_perkara;
            if($_POST['PdmP24']['pendapat'] =='Berkas perkara telah memenuhi syarat untuk dilimpahkan ke Pengadilan') {
                $model->id_ms_hasil_berkas =1;
            }elseif ($_POST['PdmP24']['pendapat']=='Masih Perlu melengkapi berkas perkara atas nama tersangka '.Yii::$app->globalfunc->getListTerdakwa($modelSpdp->id_perkara)) {
               $model->id_ms_hasil_berkas =3;
            }else{
                $model->id_ms_hasil_berkas =2;
            }    
            $model->save();
            
            
            //Insert tabel tembusan 
            PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::P24]);
            if (isset($_POST['new_tembusan'])) {
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusan();
                    $modelNewTembusan->id_table = $model->id_p24;
                    $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                    $modelNewTembusan->kode_table = GlobalConstMenuComponent::P24;
                    $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                    $modelNewTembusan->id_perkara = $model->id_perkara;
                    $modelNewTembusan->nip = null;
                    $modelNewTembusan->save();
                }
            }
            
            if($model->id_ms_hasil_berkas== '1'){ //Lengkap
                $NextProcces = array(ConstSysMenuComponent::P21);
                Yii::$app->globalfunc->getNextProcces($model->id_perkara,$NextProcces); 
            }elseif($model->id_ms_hasil_berkas== '2'){// tdk lengkap
                $NextProcces = array(ConstSysMenuComponent::P18,  ConstSysMenuComponent::P19);
                Yii::$app->globalfunc->getNextProcces($model->id_perkara,$NextProcces); 
            }else{ //optomal
                $NextProcces = array(ConstSysMenuComponent::P22);
                Yii::$app->globalfunc->getNextProcces($model->id_perkara,$NextProcces); 
            }
            $transaction->commit();
            
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
            return $this->redirect('index');

            // return $this->redirect(['view', 'id' => $model->id_p24]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'sysMenu' => $sysMenu,
						'modelJpu' =>$modelJpu,
            ]);
        }
    }

    /**
     * Updates an existing PdmP24 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_p24)
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P24]);
        $id = Yii::$app->session->get('id_perkara');

        $model = PdmP24::findOne(['id_p24' => $id_p24]);
        if ($model == null) {
            $model = new PdmP24();
        }

        $modelTersangka = $this->findModelTersangka($id);
        $modelSpdp = $this->findModelSpdp($id);
        $modelJpu = PdmJpu::findAll(['id_perkara' => $id]);
        $modelJpu = PdmJaksaSaksi::find()->where(['id_perkara' => $id, 'code_table' => GlobalConstMenuComponent::P16])->orderBy('no_urut asc')->all();

        if ($model->load(Yii::$app->request->post())) {
            $id_p17 = PdmP17::findOne(['id_perkara' => $id]);

            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p24', 'id_p24', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

            if ($model->id_perkara != null) {
                $model->flag = '2';
                $model->update();
            } else {
                $model->id_perkara = $id;
                $model->id_p17 = $id_p17->id_p17;
                $model->id_p24 = $seq['generate_pk'];
                $model->save();
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::P24);
            }
            $nip = $_POST['nip_jpu'];
            $nama = $_POST['nama_jpu'];
            $jabatan = $_POST['jabatan_jpu'];
            $pangkat = $_POST['gol_jpu'];
            $no_urut = $_POST['no_urut'];

            PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::P24, 'id_table' => $model->id_p24]);
            for ($i = 0; $i < count($nip); $i++) {
                $modelJpu1 = new PdmJaksaSaksi();
                $seqJpu = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                $modelJpu1->id_perkara = $id;
                $modelJpu1->id_jpp = $seqJpu['generate_pk'];
                $modelJpu1->code_table = GlobalConstMenuComponent::P24;
                $modelJpu1->id_table = $model->id_p24;
                $modelJpu1->nip = $nip[$i];
                $modelJpu1->nama = $nama[$i];
                $modelJpu1->jabatan = $jabatan[$i];
                $modelJpu1->pangkat = $pangkat[$i];
                $modelJpu1->no_urut = $no_urut[$i];
                $modelJpu1->save();
            }

            //Insert tabel tembusan 
            PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::P24]);
            if (isset($_POST['new_tembusan'])) {
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusan();
                    $modelNewTembusan->id_table = $model->id_p24;
                    $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                    $modelNewTembusan->kode_table = GlobalConstMenuComponent::P24;
                    $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                    $modelNewTembusan->id_perkara = $model->id_perkara;
                    $modelNewTembusan->nip = null;
                    $modelNewTembusan->save();
                }
            }

            //notifikasi simpan
            if ($model->save()) {
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
                // return $this->redirect(['update','id'=>$model->id_perkara]);
            }

            return $this->redirect(['index']);
            //return $this->redirect(\Yii::$app->urlManager->createUrl("pidum/spdp/index"));
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelTersangka' => $modelTersangka,
                        'modelSpdp' => $modelSpdp,
                        'modelJpu' => $modelJpu,
                        'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP24 model.
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

                PdmP24::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                   PdmP24::updateAll(['flag' => '3'], "id_p24 = '" . $id[$i] . "'");
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

	public function actionCetak($id_p24)
	{
            
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pdsold/template/p24.odt");

        $model = PdmP24::findOne(['id_p24' => $id_p24]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $model->id_perkara]);
        $p16 = PdmP16::findOne(['id_perkara' => $model->id_perkara]);
        
        $tanggalSurat = Yii::$app->globalfunc->getTanggalBeritaAcara($model->tgl_ba);
        $hari = Yii::$app->globalfunc->GetNamahari($model->tgl_ba);
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('no_p16', $p16->no_surat);
        $odf->setVars('tgl_p16', Yii::$app->globalfunc->ViewIndonesianFormat($p16->tgl_dikeluarkan));
        $odf->setVars('hari', ucfirst($hari));
        $odf->setVars('tgl_surat', $tanggalSurat ); //
        $odf->setVars('ket_saksi', $model->ket_saksi);
        $odf->setVars('ket_ahli', $model->ket_ahli);
        $odf->setVars('alat_bukti', $model->alat_bukti);
        $odf->setVars('benda_sitaan', $model->benda_sitaan);
        $odf->setVars('ket_tersangka', $model->ket_tersangka);
        $odf->setVars('fakta_hukum', $model->fakta_hukum);
        $odf->setVars('yuridis', $model->yuridis);
        $odf->setVars('kesimpulan', $model->kesimpulan);
        
        $odf->setVars('pendapat', $model->pendapat);
        $odf->setVars('reg_no', $spdp->no_reg);
        $odf->setVars('pasal', $spdp->undang_pasal);
        #list Tersangka
        $dft_tersangka = '';
        $query = new Query;
        $query->select('*')
                ->from('pidum.ms_tersangka')
                ->where("id_perkara='" . $model->id_perkara . "'");
        $data = $query->createCommand();
        $listTersangka = $data->queryAll();
        foreach ($listTersangka as $key) {
            $dft_tersangka .= $key[nama] . ',';
        }
        $dft_tersangka = substr_replace($dft_tersangka, "", -1);
        $dft_tersangka = Yii::$app->globalfunc->getDaftarTerdakwa($model->id_perkara);
        $odf->setVars('tersangka', $dft_tersangka);
        $odf->setVars('kejaksaan', ucfirst(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama)));

        #Jaksa Peneliti
        $query = new Query;
        $query->select('jpu.peg_nip_baru,jpu.nama,jabatan,pangkat')
                ->from('pidum.pdm_jaksa_saksi jpu, kepegawaian.kp_pegawai ')
                ->where(" peg_nik=nip and id_perkara='" . $model->id_perkara . "' AND code_table='" . GlobalConstMenuComponent::P16 . "'")
                ->orderby('no_urut');
        $dt_jaksaPeneliti = $query->createCommand();
        $listjaksaPeneliti = $dt_jaksaPeneliti->queryAll();
        $dft_jaksaPeneliti = $odf->setSegment('jaksaPeneliti');
        $i = 1;
        foreach ($listjaksaPeneliti as $element) {
            $pangkat = explode('/', $element['pangkat']);
            $dft_jaksaPeneliti->urutan($i);
            $dft_jaksaPeneliti->nama_pegawai($element['nama']);
            $dft_jaksaPeneliti->pangkat($pangkat[0] . ' / ' . $element['peg_nip_baru']);
            $dft_jaksaPeneliti->jabatan($element['jabatan']);
            $dft_jaksaPeneliti->merge();
            $i++;
        }
        $odf->mergeSegment($dft_jaksaPeneliti);

        $odf->exportAsAttachedFile('p24.odt');
    
        }
	
    /**
     * Finds the PdmP24 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP24 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP24::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        } /*else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }

    protected function findModelTersangka($id)
    {
        if (($modelTersangka = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $modelTersangka;
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
