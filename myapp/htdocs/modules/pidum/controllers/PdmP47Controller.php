<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\VwJaksaPenuntutSearch;

use app\modules\pidum\models\PdmP47;
use app\modules\pidum\models\PdmP42;
use app\modules\pidum\models\PdmTembusanP47;
use app\modules\pidum\models\PdmP47Search;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmPkTingRef;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmPutusanPn;
use app\modules\pidum\models\PdmPutusanPnTerdakwa;
use app\modules\pidum\models\PdmP45;
use app\modules\pidum\models\PdmUuPasalTahap2;
use Odf;
use Yii;

use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Session;
use yii\web\NotFoundHttpException;

/**
 * PdmP47Controller implements the CRUD actions for PdmP47 model.
 */
class PdmP47Controller extends Controller {

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
     * Lists all PdmP47 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmP47Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P47]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmP47 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP47 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmP47();
        
        

        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $terdakwa  = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$no_reg_tahanan]);
        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P47]);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            //echo '<pre>';print_r($_POST);exit;
            try {
                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->no_register_perkara = $no_register_perkara;
                $model->no_akta = $no_akta;
                $model->no_reg_tahanan = $no_reg_tahanan;

                $data = $_POST['txt_nama_timbang'];
                $model->pertimbangan =  json_encode($data);

                if(!$model->save()){
                        var_dump($model->getErrors());exit;
                }else{
                    PdmTembusanP47::deleteAll(['no_register_perkara'=>$no_register_perkara, 'no_akta'=>$no_akta]);
                    for ($i=0; $i < count($_POST['new_no_urut']); $i++) { 
                        $modelNewTembusan = new PdmTembusanP47();
                        $modelNewTembusan->no_akta = $no_akta;
                        $modelNewTembusan->no_register_perkara = $no_register_perkara;
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $i+1;
                        if(!$modelNewTembusan->save()){
                                var_dump($modelNewTembusan->getErrors());exit;
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
                }
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
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'sysMenu' => $sysMenu,
                        'terdakwa' => $terdakwa,
                        'dataJPU' => $dataJPU,
                        'searchJPU' => $searchJPU,
            ]);
        }
    }

    /**
     * Updates an existing PdmP47 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $session = new session();

        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $terdakwa  = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$no_reg_tahanan]);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        
        
               
        $model = $this->findModel($no_register_perkara,$no_akta,$no_reg_tahanan);

        //echo '<pre>';print_r($model);exit;
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P47]);

        if ($model->load(Yii::$app->request->post())){
            $transaction = Yii::$app->db->beginTransaction();
            //echo '<pre>';print_r($_POST);exit;
            try {
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->no_register_perkara = $no_register_perkara;
                $model->no_akta = $no_akta;
                $model->no_reg_tahanan = $no_reg_tahanan;

                $data = $_POST['txt_nama_timbang'];
                $model->pertimbangan =  json_encode($data);
                if(!$model->update()){
                        var_dump($model->getErrors());exit;
                }else{
                    PdmTembusanP47::deleteAll(['no_register_perkara'=>$no_register_perkara, 'no_akta'=>$no_akta]);
                    for ($i=0; $i < count($_POST['new_no_urut']); $i++) { 
                        $modelNewTembusan = new PdmTembusanP47();
                        $modelNewTembusan->no_akta = $no_akta;
                        $modelNewTembusan->no_register_perkara = $no_register_perkara;
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $i+1;
                        if(!$modelNewTembusan->save()){
                                var_dump($modelNewTembusan->getErrors());exit;
                               }
                    }

                $transaction->commit();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Ubah',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                }
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

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'sysMenu' => $sysMenu,
                        'terdakwa' => $terdakwa,
                        'dataJPU' => $dataJPU,
                        'searchJPU' => $searchJPU,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP47 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $session = new session();
        
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        
        PdmP47::deleteAll(['no_register_perkara'=>$no_register_perkara, 'no_akta'=>$no_akta, 'no_reg_tahanan'=>$no_reg_tahanan]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmP47 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP47 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_register_perkara,$no_akta,$no_reg_tahanan) {
        if (($model = PdmP47::findOne($no_register_perkara,$no_akta,$no_reg_tahanan)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {


        $session = new session();
        
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        //$id = $session->get('id_perkara');

        $model = $this->findModel($no_register_perkara,$id,$no_reg_tahanan);

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);

        $putusan_pn_terdakwa = PdmPutusanPnTerdakwa::findOne(['no_register_perkara'=>$no_register_perkara, 'status_rentut'=>3, 'no_reg_tahanan'=>$no_reg_tahanan]);
        $putusan_pn = PdmPutusanPn::findOne(['no_register_perkara'=>$no_register_perkara]);
        $pasal = json_decode($putusan_pn_terdakwa->undang_undang);
        $amar = json_decode(PdmP45::find()->select('menyatakan')->where(['no_register_perkara'=>$no_register_perkara])->scalar());
        $terdakwa = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$no_reg_tahanan]); 
        $p42 = PdmP42::findOne(['no_register_perkara'=>$no_register_perkara]);
        $listPasal = "";
        $tembusan = PdmTembusanP47::findAll(['no_register_perkara'=>$no_register_perkara, 'no_akta'=>$no_akta]);
        $jum = count($pasal->undang);
        foreach ($pasal->undang as $key => $value) {
            $pasal = PdmUuPasalTahap2::find()->select('undang, pasal')->where(['id_pasal'=>$value])->one();
            
            if($jum==1 || $key==0){
                $listPasal .= $pasal->undang.' '.$pasal->pasal;
            }else if($jum==2 && $key == 1){
                $listPasal .= ' dan '.$pasal->undang.' '.$pasal->pasal;
            }else{
                $listPasal .= ', '.$pasal->undang.' '.$pasal->pasal;
            }
        }        
        //echo $listPasal;exit;
        
        return $this->render('cetak', [
                        'model' => $model,
                        'listPasal' => $listPasal,
                        'tersangka' => $terdakwa,
                        'session' => $_SESSION,
                        'putusan_pn' => $putusan_pn,
                        'putusan_pn_terdakwa' => $putusan_pn_terdakwa,
                        'amar' => $amar,
                        'tembusan' =>$tembusan,
                        'p42'=>$p42,
            ]);
        }



        /*
        $p47 = PdmP47::findOne($id);
        $id_perkara = \Yii::$app->session->get('id_perkara');
        $spdp = PdmSpdp::findOne(['id_perkara' => $p47->id_perkara]);
        $pidana = PdmPkTingRef::findOne(['id' => $spdp->id_pk_ting_ref]);
        $tersangka = VwTerdakwa::findOne(['id_tersangka' => $p47->id_tersangka]);
        $modeljaksi = PdmJaksaSaksi::findOne(['id_perkara' => $p47->id_perkara, 'id_table' => $p47->id_p47, 'code_table' => GlobalConstMenuComponent::P47]);
        $pasal = PdmPasal::findAll(['id_perkara' => $p47->id_perkara]);
        $pasal1 = "";
        if (count($pasal) == 1) {
            $pasal1 = $pasal[0]->pasal;
        } else if (count($pasal) == 2) {
            $i = 0;
            foreach ($pasal as $key) {
                if ($i == 0) {
                    $pasal1 .= $key->pasal;
                    $i = 1;
                } else {
                    $pasal1 .= ' dan ' . $key->pasal;
                }
            }
        } else if (count($pasal) > 2) {
            $i = 1;
            foreach ($pasal as $key) {
                if ($i == count($pasal)) {
                    $pasal1 .= 'dan ' . $key->pasal;
                } else {
                    $pasal1 .= $key->pasal . ', ';
                    $i++;
                }
            }
        }
		 $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p47 b','a.peg_nik = b.id_penandatangan')
->where ("id_p47='".$id."'")
->one(); 
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/p47.odt");

        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kejaksaan', $pangkat->jabatan);
        //$odf->setVars('kejaksaan1', ucfirst(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_lokinst)));

        $odf->setVars('dikeluarkan', $p47->dikeluarkan);
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($p47->tgl_dikeluarkan));

        $odf->setVars('kepada', strtoupper($p47->kepada));
        $odf->setVars('ditempat', $p47->di_kepada);
        $odf->setVars('ket_pengadilan', $p47->pengadilan_negeri);
        $odf->setVars('nomor', $spdp->no_surat);
        $odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($spdp->tgl_surat));

        $odf->setVars('nama_lengkap', $tersangka->nama);
        $odf->setVars('tempat_lahir', $tersangka->tmpt_lahir);
        $odf->setVars('tgl_lahir', Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir));
        $umur = Yii::$app->globalfunc->datediff($tersangka->tgl_lahir, date("Y-m-d"));
        $odf->setVars('umur', $umur['years'] . ' tahun');
        $odf->setVars('jenis_kelamin', $tersangka->is_jkl);
        $odf->setVars('kebangsaan', $tersangka->warganegara);
        $odf->setVars('tempat_tinggal', $tersangka->alamat);
        $odf->setVars('agama', $tersangka->is_agama);
        $odf->setVars('pekerjaan', $tersangka->pekerjaan);
        $odf->setVars('pendidikan', $tersangka->is_pendidikan);


        $odf->setVars('amar_putusan', $pasal1);
        $odf->setVars('dakwaan', $p47->dakwaan);

        $odf->setVars('alasan', $p47->alasan);
        $odf->setVars('dalam_hal', $p47->penetapan_hakim);
        $odf->setVars('dalam_hal2', '-');
        $odf->setVars('pasal', $pasal1);
        $odf->setVars('dengan_cara', '-');
        $odf->setVars('di', '-');
        $odf->setVars('tindak_pidana', '-');
        $odf->setVars('denda', '-');
        $odf->setVars('sebesar', $p47->biaya_perkara);

        $connection = \Yii::$app->db;
        #penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
            . " pidum.pdm_penandatangan a, pidum.pdm_p47 b , kepegawaian.kp_pegawai c "
            . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_p47='" . $p47->id_p47 . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $odf->setVars('pangkat', $penandatangan['pangkat']);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);
        
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $p47->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::P47 . "'and id_table = '" . $p47->id_p47 . "' order by no_urut");
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($element['no_urut']);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);
        
        
        $odf->exportAsAttachedFile();
    }*/

}
