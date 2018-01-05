<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\MsAsalsurat;
use app\modules\pidum\models\MsPenyidik;
use app\modules\pidum\models\MsLoktahanan;
use app\modules\pidum\models\MsTersangkaPt;
use app\modules\pidum\models\PdmP16;
use app\modules\pidum\models\PdmPerpanjanganTahanan;
use app\modules\pidum\models\PdmTahananPenyidik;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmT4;
use app\modules\pidum\models\PdmT4Search;
use app\modules\pidum\models\PdmTembusanT4;
use app\modules\pidum\models\PdmStatusSurat;
use app\modules\pidum\models\VwTersangkaPt;
use app\modules\pidum\models\MsInstPelakPenyidikan;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\helpers\ArrayHelper;
use app\modules\pidum\models\PdmPenandatangan;
use yii\web\UploadedFile;
/**
 * PdmT4Controller implements the CRUD actions for PdmT4 model.
 */
class PdmT4Controller extends Controller {

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
     * Lists all PdmT4 models.
     * @return mixed
     */
    public function actionIndex() {

        $session = new Session();        
        $id_perkara = $session->get('id_perkara');
        $searchModel = new PdmT4Search();
        $dataProvider = $searchModel->search($id_perkara);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
// post combo DANAR WIDO CMS_PIDUM033
 public function actionPenyidik()
    {
        $id_tersangka = $_POST['id_tersangka'];	
		
		$mulai = PdmTahananPenyidik::find()->where(['id_tersangka' => $id_tersangka])->all();
		foreach ($mulai as $value) {
			
            $option .= '<option selected="selected" value ="' . $value->tgl_mulai . '">' . $value->tgl_mulai . '</option>';
        }
        echo $option;
		
		
		

    }
	
// end post combo DANAR WIDO CMS_PIDUM033
	
    public function actionRiwayattahanan()
    {
        $id_perpanjangan = $_POST['id_perpanjangan'];	
		$riwayat = PdmPerpanjanganTahanan::find()->where(['id_perpanjangan' => $id_perpanjangan])->one();
		if($riwayat->id_msloktahanan == '1'){
                    $jenis_penahanan = 'Rutan';
		}else if($riwayat->id_msloktahanan == '2'){
                    $jenis_penahanan = 'Rumah';
		}else if($riwayat->id_msloktahanan == '3'){
                    $jenis_penahanan = 'Kota';
		}else{
                    $jenis_penahanan = '';
		}
		echo json_encode(array(
                    "id_riwayat_tahanan"=>$riwayat->id_msloktahanan ,
                    "tgl_surat"=>$riwayat->tgl_surat,
                    "lokasi"=>$riwayat->lokasi_penahanan,
                    "persetujuan"=>$riwayat->persetujuan,
                    "jenis_penahanan"=>$jenis_penahanan,
                    "tgl_awal"=>$riwayat->tgl_mulai ? date('d-m-Y', strtotime($riwayat->tgl_mulai)) : '',
                    "tgl_akhir"=>$riwayat->tgl_selesai ? date('d-m-Y', strtotime($riwayat->tgl_selesai)) : '',
                    "tgl_mulai_permintaan"=>$riwayat->tgl_mulai_permintaan ? date('Y-m-d', strtotime($riwayat->tgl_mulai_permintaan)) : '',
                    "tgl_mulai_permintaan_disp"=>$riwayat->tgl_mulai_permintaan ? date('d-m-Y', strtotime($riwayat->tgl_mulai_permintaan)) : '',
                    "tgl_selesai_permintaan"=>$riwayat->tgl_selesai_permintaan ? date('Y-m-d', strtotime($riwayat->tgl_selesai_permintaan)) : '',
                    "tgl_selesai_permintaan_disp"=>$riwayat->tgl_selesai_permintaan ? date('d-m-Y', strtotime($riwayat->tgl_selesai_permintaan)) : ''));
		exit;
    }
	
	
    /**
     * Displays a single PdmT4 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmT4 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmT4();
        $id = trim(Yii::$app->session->get('id_perkara'));
        $modelSpdp = $this->findModelSpdp($id);
        $modelTersangka = new MsTersangkaPt();
        $modelPerpanjangan = PdmPerpanjanganTahanan::findOne(['id_perkara' => $id]);
		
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $jml_pt = Yii::$app->db->createCommand(" SELECT (count(a.*)+1) as jml FROM pidum.pdm_t4 a INNER JOIN pidum.pdm_perpanjangan_tahanan b on a.id_perpanjangan = b.id_perpanjangan WHERE b.id_perkara='".$id."' AND (a.file_upload is NOT null OR a.file_upload <> '') ")->queryOne();
                $model->id_t4 = $_POST['PdmT4']['id_perpanjangan']."|".$_POST['PdmT4']['no_surat'];
                if($_POST['hdn_nama_penandatangan'] != ''){
                    $model->nama = $_POST['hdn_nama_penandatangan'];
                    $model->pangkat = $_POST['hdn_pangkat_penandatangan'];
                    $model->jabatan = $_POST['hdn_jabatan_penandatangan'];
                }
                $files = UploadedFile::getInstance($model, 'file_upload');
                if ($files != false && !empty($files) ) {
                    $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/T4_'.$jml_pt['jml'].'.'. $files->extension;
                    $path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/T4_'.$jml_pt['jml'].'.'. $files->extension;
                    $files->saveAs($path);
                }
//                echo '<pre>';print_r($_POST);exit();
                $model->id_perpanjangan     = $_POST['PdmT4']['id_perpanjangan'];
                $model->tgl_selesai         = $_POST['PdmT4']['tgl_selesai'];
                $model->lokasi         = $_POST['PdmT4']['lokasi'];
                $model->id_loktahanan         = $_POST['PdmT4']['id_loktahanan'];
                $pdm_perpanjangan           = PdmPerpanjanganTahanan::findOne(['id_perpanjangan' => $model->id_perpanjangan]);
                $model->no_surat_penahanan  = $pdm_perpanjangan->no_surat_penahanan;
                
//		echo '<pre>';print_r($model);exit();			
                if(!$model->save()){
                    echo "T-4";var_dump($model->getErrors());exit;
                }
                    $no_penahanan       = $pdm_perpanjangan->no_surat_penahanan;
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanT4::deleteAll(['id_t4'=>$model->id_t4]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan = new PdmTembusanT4();
                            $modelNewTembusan->id_t4 = $model->id_t4;
                            $modelNewTembusan->id_tembusan = $model->id_t4."|".($i+1);
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut = ($i+1);
                            $modelNewTembusan->no_surat_penahanan = $no_penahanan;
                            if(!$modelNewTembusan->save()){
								var_dump($modelNewTembusan->getErrors());echo "Tembusan";exit;
							}
                        }
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

                    return $this->redirect(['index']);
                
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal disimpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'modelTersangka' => $modelTersangka,
                        'id' => $id,
                        'modelPerpanjangan' => $modelPerpanjangan,

					
            ]);
        }
    }

    /**
     * Updates an existing PdmT4 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
	$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T4 ]);
        $session = new Session();
		
        $id_perkara = Yii::$app->session->get('id_perkara');
        $id_t4 = $id;
        $model = PdmT4::findOne($id);
//		echo '<pre>';print_r($model);exit();
        $modelTersangka = MsTersangkaPt::findOne(['id_perpanjangan' => $model->id_perpanjangan]);
		if ($modelTersangka == null){
			$modelTersangka = new MsTersangkaPt();
		}
		
        $modelSpdp = $this->findModelSpdp($id_perkara);
		
        $modelPerpanjangan = PdmPerpanjanganTahanan::findOne(['id_perpanjangan' => $model->id_perpanjangan]);
		
		if($modelPerpanjangan->id_msloktahanan == '1'){
			$jenis_penahanan = 'Rutan';
		}else if($modelPerpanjangan->id_msloktahanan == '2'){
			$jenis_penahanan = 'Rumah';
		}else if($modelPerpanjangan->id_msloktahanan == '3'){
			$jenis_penahanan = 'Kota';
		}else{
			$jenis_penahanan = '';
		}
		
		
		
		$riwayat_tahanan = array("lokasi"=>$modelPerpanjangan->lokasi_penahanan,"jenis_penahanan"=>$jenis_penahanan,"tgl_awal"=>date('d-m-Y', strtotime($modelPerpanjangan->tgl_mulai)),"tgl_akhir"=>$modelPerpanjangan->tgl_selesai ? date('d-m-Y', strtotime($modelPerpanjangan->tgl_selesai)) : '');
		
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $jml_pt = Yii::$app->db->createCommand(" SELECT (count(a.*)+1) as jml FROM pidum.pdm_t4 a INNER JOIN pidum.pdm_perpanjangan_tahanan b on a.id_perpanjangan = b.id_perpanjangan WHERE b.id_perkara='".$id."' AND (a.file_upload is NOT null OR a.file_upload <> '') ")->queryOne();
                $model->id_t4 = $model->id_perpanjangan."|".$_POST['PdmT4']['no_surat'];
                if($_POST['hdn_nama_penandatangan'] != ''){
                    $model->nama = $_POST['hdn_nama_penandatangan'];
                    $model->pangkat = $_POST['hdn_pangkat_penandatangan'];
                    $model->jabatan = $_POST['hdn_jabatan_penandatangan'];
                }
					
                $files = UploadedFile::getInstance($model, 'file_upload');
                $file_lama = $model->getOldAttributes()['file_upload'];
					
                if ($files != false && !empty($files) ) {
                    if($file_lama !=''){
                        $model->file_upload = $file_lama;
                        $path = Yii::$app->basePath . '/web/template/pidum_surat/' . $file_lama;
                        $files->saveAs($path);
                    }else{
                        $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/T4_'.$jml_pt['jml'].'.'. $files->extension;
                        $path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/T4_'.$jml_pt['jml'].'.'. $files->extension;
                        $files->saveAs($path);
                    }
                }else{
                    $model->file_upload = $file_lama;
                }
                $pdm_perpanjangan           = PdmPerpanjanganTahanan::findOne(['id_perpanjangan' => $model->id_perpanjangan]);
                $model->no_surat_penahanan  = $pdm_perpanjangan->no_surat_penahanan;
//                echo '<pre>';print_r($model);exit();	
                if(!$model->save()){
                    var_dump($model->getErrors());exit;
                }
                $no_penahanan       = $model->no_surat_penahanan;
                //Insert tabel tembusan 
                if (isset($_POST['new_tembusan'])) {
					$id_t4 = $model->id_perpanjangan."|".$_POST['PdmT4']['no_surat'];
						PdmTembusanT4::deleteAll(['id_t4'=>$id_t4]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan = new PdmTembusanT4();
                            $modelNewTembusan->id_t4 = $id_t4;
                            $modelNewTembusan->id_tembusan = $id_t4."|".($i+1);
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut = ($i+1);
                            $modelNewTembusan->no_surat_penahanan = $no_penahanan;
                            if(!$modelNewTembusan->save()){
								var_dump($modelNewTembusan->getErrors());echo "Tembusan";exit;
							}
                        }
                    }

                

                $transaction->commit();

                if ($model->save()) {
                     if(isset($_POST['ctk']))
                    {

                        echo '<script> window.open(\'cetak?id_t4='.$id_t4.'\',"_self");setTimeout(function(){ window.location = \'update?id='.$id_t4.'\'; }, 500)</script>'; 
                        exit;
                    }
                    
                   
                
                    return $this->redirect(['index']);
                } else {
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
                }
            } catch (Exception $e) {
                $transaction->rollback();
                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'modelTersangka' => $modelTersangka,
                        'id' => trim($id),
                        'modelPerpanjangan' => $modelPerpanjangan,
						'sysMenu'=> $sysMenu,
						'riwayat_tahanan'=> $riwayat_tahanan,
						'jenis_penahanan'=> $jenis_penahanan,
	
            ]);
        }
    }

    /**
     * Deletes an existing PdmT4 model.
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
		PdmStatusSurat::deleteAll(['id_perkara' => $id_perkara,'id_sys_menu'=>GlobalConstMenuComponent::T4]);
		if($id == "all"){ // hapus semua
			PdmT4::deleteAll(['id_perkara'=>$id_perkara]);
		}else{
			for ($i = 0; $i < count($id); $i++) {
				PdmT4::deleteAll(['id_t4' => $id[$i]]);
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
        /*for ($i = 0; $i < count($id); $i++) {
            $model = PdmT4::findOne(['id_t4' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }*/
        return $this->redirect(['index']);
    }

    public function actionCetak($id_t4) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "web/template/pidum/t4.odt");
		$session = new Session();
        $id_perkara = $session->get('id_perkara');
		
        $model = PdmT4::findOne(['id_t4' => $id_t4]);
        $riwayat = PdmPerpanjanganTahanan::findOne(['id_perpanjangan'=>$model->id_perpanjangan]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        $p16 = PdmP16::findOne(['id_perkara' => $id]);

        $p16 = PdmP16::findAll(['id_perkara' => $id]);


        $tersangka = Yii::$app->db->createCommand(" SELECT a.*,b.nama as nama_negara,c.nama as nama_agama, d.nama as nama_pendidikan FROM pidum.ms_tersangka_pt a INNER JOIN public.ms_warganegara b on a.warganegara=b.id INNER JOIN public.ms_agama c ON a.id_agama = c.id_agama INNER JOIN public.ms_pendidikan d on a.id_pendidikan = d.id_pendidikan WHERE id_perpanjangan='".$riwayat->id_perpanjangan."' ")->queryOne();
        $asalsurat = MsAsalsurat::findOne(['id_asalsurat' => $spdp->id_asalsurat]);
		$penyidik =  MsInstPelakPenyidikan::findOne(['kode_ipp' => $spdp->id_penyidik]);
        $lokasi = MsLoktahanan::findOne(['id_loktahanan'=>$model->id_loktahanan]);
	if($tersangka['tgl_lahir']){
            $umur = Yii::$app->globalfunc->datediff($tersangka['tgl_lahir'],date("Y-m-d"));
            $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($tersangka['tgl_lahir']);  
        }else{
            $tgl_lahir = '-';
        }
		$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_t4 b','a.peg_nik = b.id_penandatangan')
->where ("id_t4='".$id_t4."'")
->one();

$ttd = PdmPenandatangan::find()
->select ("a.nama as nama,a.pangkat as pangkat,a.peg_nik as peg_nik")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_t4 b','a.peg_nik = b.id_penandatangan')
->where ("id_t4='".$id_t4."'")
->one();
//print_r(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);exit;
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
		
		//CMS_PIDUM04_T4_09 #bowo #header cetakan #06062016
//		$kode=$spdp->wilayah_kerja;
//		if ($kode=='00'){
//			$odf->setVars('Kejaksaan', 'JAKSA AGUNG MUDA TINDAK PIDANA UMUM');
//			$odf->setVars('Kepala', '');
//		}	else {
//			$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);	
//			$odf->setVars('Kepala', 'KEPALA');
//		}

        $odf->setVars('kepala', $model->jabatan);
        $odf->setVars('nomor_surat', $model->no_surat);
        $odf->setVars('nomor_riwayat', $riwayat->no_surat);
        $odf->setVars('tanggal_riwayat', Yii::$app->globalfunc->ViewIndonesianFormat($riwayat->tgl_surat));
        $odf->setVars('penyidik', $penyidik->nama);
        $odf->setVars('uraian_perkara', strtolower($spdp->ket_kasus));
        $odf->setVars('pasal', $spdp->undang_pasal);


        $odf->setVars('tgl_mulai', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_mulai));
        $odf->setVars('tgl_selesai', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_selesai));
// new \DateTime('now', new \DateTimeZone('UTC'));
        $start_date = new \DateTime($model->tgl_mulai);
                            $end_date = new \DateTime($model->tgl_selesai);
                            $interval = $start_date->diff($end_date);
                            $hari = "$interval->days"; // hasil : 217 hari 
        $odf->setVars('hari', $hari);
        $odf->setVars('lokasi_tahanan', $lokasi->nama);
        $odf->setVars('lokasi_lp', $model->lokasi);
	
        $odf->setVars('nm_tersangka', ucfirst($tersangka['nama']));
        $odf->setVars('nama', ucfirst($tersangka['nama']));
		
		//bowo 06 juni 2016 #default jika kolom kosong
		if ($tersangka['tmpt_lahir'] != '') {
				$tempat_lahir = $tersangka['tmpt_lahir'];
			} else {
				$tempat_lahir = '-';
			}
		if ($tersangka['tgl_lahir'] != '') {
				$tgl_lahir = ucfirst(strtolower($tersangka['tgl_lahir']));
			} else {
				$tgl_lahir = '-';
			}	
		if ($tersangka['id_jkl'] != '') {
				if($tersangka['id_jkl']=='1'){
					$is_jkl = 'Laki-Laki';
				}else{
					$is_jkl = 'Perempuan';
				}
				
			} else {
				$is_jkl = '-';
			}	
		$warganegara = ucfirst(strtolower($tersangka['nama_negara']));	
		if ($tersangka['alamat'] != '') {
				$alamat = $tersangka['alamat'];
			} else {
				$alamat = '-';
			}		
		$is_agama = ucfirst($tersangka['nama_agama']);		
		if ($tersangka['pekerjaan'] != '') {
				$pekerjaan = ucfirst(strtolower($tersangka['pekerjaan']));
			} else {
				$pekerjaan = '-';
			}
		$is_pendidikan = $tersangka['nama_pendidikan'];
		
        $odf->setVars('tmpt_lahir', $tempat_lahir);		
        $odf->setVars('tgl_lahir',$tersangka['umur']." Tahun/".Yii::$app->globalfunc->ViewIndonesianFormat($tgl_lahir));
        $odf->setVars('jenis_kelamin', $is_jkl);
        $odf->setVars('warganegara', $warganegara);
        $odf->setVars('tmpt_tinggal', $alamat);
        $odf->setVars('agama', $is_agama);
        $odf->setVars('pekerjaan', $pekerjaan);
        $odf->setVars('pendidikan', $is_pendidikan);
        $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));

        
        $odf->setVars('nama_penandatangan', $model->nama);
        $odf->setVars('pangkat', $model->pangkat);
        $odf->setVars('nip_penandatangan', $model->id_penandatangan);
        

        #tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_t4')
                ->where(" id_t4 ='".$model->id_t4."' ")
                ->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
		$i=1;
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($i);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
			$i++;
        }
        $odf->mergeSegment($dft_tembusan);

        $odf->exportAsAttachedFile('t4.odt');
    }
 public function actionShowTersangka()
    {
        if($_GET['id_tersangka'] != null){
            $modelTersangka = MsTersangkaPt::findOne(['id_tersangka' => $_GET['id_tersangka']]);
        }else{
            $modelTersangka = new MsTersangkaPt();
        }
        
        $identitas = ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama');
        $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
        $pendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
        $warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
        
        return $this->renderAjax('_popTersangka', [
            'modelTersangka' => $modelTersangka,
            'agama' => $agama,
            'identitas' => $identitas,
            'pendidikan' => $pendidikan,
            'warganegara' => $warganegara
        ]);
    }
    /**
     * Finds the PdmT4 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmT4 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmT4::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        } /* else {
          throw new NotFoundHttpException('The requested page does not exist.');
          } */
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne(['id_perkara' => trim($id)])) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not existtt.');
        }
    }
	
    protected function findModelTersangka($id) {
        if (($model = MsTersangkaPt::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTersangka() {
        $id = $_POST['id'];
        $idt4 = $_POST['id_t4'];
        $perkara = $_POST['perkara'];

        $cekdata = PdmT4::findOne(['id_tersangka' => $id]);

        if ($cekdata != null && $cekdata->id_t4 != $idt4) {
            $json = 1;
            echo json_encode($json);
        } else {
            $modelTersangka = MsTersangkaPt::findOne(['id_tersangka' => $id]);
            //print_r($modelTersangka);
            //exit;
            $modelPerpanjangan = PdmPerpanjanganTahanan::findOne(['id_perkara' => $perkara]);

            if ($modelTersangka != null) {
                if ($modelTersangka->tgl_lahir != null) {
                    $modelTersangka->tgl_lahir = date('d-m-Y', strtotime($modelTersangka->tgl_lahir));
                }
                $json = array("nama" => $modelTersangka->nama,
                    "tempat_lahir" => $modelTersangka->tmpt_lahir,
                    "tanggal_lahir" => $modelTersangka->tgl_lahir,
                    "jenis_kelamin" => $modelTersangka->id_jkl,
                    "warga_negara" => $modelTersangka->warganegara,
                    "tempat_tinggal" => $modelTersangka->alamat,
                    "agama" => $modelTersangka->id_agama,
                    "pekerjaan" => $modelTersangka->pekerjaan,
                    "pendidikan" => $modelTersangka->id_pendidikan,
					"umur" => $modelTersangka->umur,
                    "id" => $id,
                    "no_panjang" => $modelPerpanjangan->no_surat,
                    "tgl_panjang" => date('d-m-Y', strtotime($modelPerpanjangan->tgl_surat)),
                );
                echo json_encode($json);
            } else {
                $json = 'data kosong';
                echo json_encode($json);
            }
        }
    }

}
