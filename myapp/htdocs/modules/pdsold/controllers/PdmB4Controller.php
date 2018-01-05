<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmBarbukTambahan;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmP25;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmTembusan;

use kartik\sidenav\SideNav;
use Odf;
use Yii;
use app\modules\pdsold\models\PdmB4;
use app\modules\pdsold\models\PdmB4Search;
use yii\base\Exception;
//use yii\console\Response;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\Session;
use yii\web\UploadedFile;

/**
 * PdmB4Controller implements the CRUD actions for PdmB4 model.
 */
class PdmB4Controller extends Controller
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
     * Lists all PdmB4 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = new Session();
        $id_perkara = $session->get('id_perkara');

        $searchModel = new PdmB4Search();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchIndex($id_perkara);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmB4 model.
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
     * Creates a new PdmB4 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmB4();

        $session = new Session();
        $idPerkara = $session->get('id_perkara');

        $searchModel = new PdmB4Search();
        $dataProvider = $searchModel->searchJaksa($idPerkara);

        $kd_wilayah = PdmSpdp::findOne($idPerkara)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;

        $queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            //->innerJoin('pidum.pdm_b4 b','a.id_perkara=b.id_perkara')
            ->where('a.id_perkara=:id_perkara AND a.id_tersangka NOT IN (select id_tersangka from pidum.pdm_b4 where pidum.pdm_b4.flag<>\'3\')', [':id_perkara' => $idPerkara])->all();

        $query = new Query();
        $tindak_pidana = $query->select('b.nama')->from('pidum.pdm_spdp a')->innerJoin('pidum.pdm_pk_ting_ref b', 'b.id = a.id_pk_ting_ref')
            ->where('a.id_perkara=:id_perkara', ['id_perkara' => $idPerkara])->one();

        if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->id_b4]);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b4', 'id_b4', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_b4 = $seq['generate_pk'];
                $model->id_perkara = $idPerkara;
                $model->created_ip = Yii::$app->getRequest()->getUserIP();

                $files = UploadedFile::getInstance($model, 'upload_file');
                $model->upload_file = $files->name;

                if ($model->save(true)) {
                    if ($files != false) {
                        $path = Yii::$app->params['uploadPath'] . 'b4/' . $files->name;
                        $files->saveAs($path);
                    }
                }

                $nm_barbuk = Yii::$app->request->post('pdmBarbukNama');
                $jml_barbuk = Yii::$app->request->post('pdmBarbukJumlah');
                $satuan_barbuk = Yii::$app->request->post('pdmBarbukSatuan');
                $sita_barbuk = Yii::$app->request->post('pdmBarbukSitaDari');
                $tindakan = Yii::$app->request->post('pdmBarbukTindakan');
                $kondisi_barbuk = Yii::$app->request->post('pdmBarbukKondisi');
                for($i=0;$i<count($nm_barbuk);$i++) {
                    $modelBarbukTambahan = new PdmBarbukTambahan();
                    $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_barbuk_tambahan', 'id', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $modelBarbukTambahan->id = $seq['generate_pk'];
                    $modelBarbukTambahan->id_b4 = $model->id_b4;
                    $modelBarbukTambahan->nama = $nm_barbuk[$i];
                    $modelBarbukTambahan->jumlah = $jml_barbuk[$i];
                    $modelBarbukTambahan->id_satuan = $satuan_barbuk[$i];
                    $modelBarbukTambahan->sita_dari = $sita_barbuk[$i];
                    $modelBarbukTambahan->tindakan = $tindakan[$i];
                    $modelBarbukTambahan->id_stat_kondisi = $kondisi_barbuk[$i];
                    $modelBarbukTambahan->id_perkara = $model->id_perkara;
                    $modelBarbukTambahan->save(true);
                }

                //Insert tabel tembusan
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::B4]);
                if (isset($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_b4;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B4;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
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

                return $this->redirect(['index']);
            } catch (Exception $e) {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Disimpan', // String
                    'title' => 'Create', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'wilayah' => $wilayah,
                'tindak_pidana' => $tindak_pidana,
                'dataProvider' => $dataProvider,
                'list_tersangka' => $listTersangka,
            ]);
        }
    }

    /**
     * Updates an existing PdmB4 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $searchModel = new PdmB4Search();
        $dataProvider = $searchModel->searchJaksa($model->id_perkara);

        $kd_wilayah = PdmSpdp::findOne($model->id_perkara)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;

        /*$dft_tersangka = '';
        foreach(MsTersangka::findAll(['id_perkara'=>$idPerkara]) as $key){
            $dft_tersangka .= $key[nama].', ';
        }*/

        $listTersangka = MsTersangka::find()->where('id_perkara=:id_perkara', [':id_perkara' => $model->id_perkara])->all();

        $tabelbarbuk = PdmBarbukTambahan::find()->where('id_b4=:id_b4 AND flag<>:flag',[':id_b4'=>$model->id_b4,':flag'=>'3'])->all();

        $query = new Query();
        $tindak_pidana = $query->select('b.nama')->from('pidum.pdm_spdp a')->innerJoin('pidum.pdm_pk_ting_ref b', 'b.id = a.id_pk_ting_ref')
            ->where('a.id_perkara=:id_perkara', ['id_perkara' => $model->id_perkara])->one();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $modelB4 = PdmB4::findOne(['id_perkara' => $model->id_perkara]);
                $files = UploadedFile::getInstance($model, 'upload_file');
                $model->updated_ip = Yii::$app->getRequest()->getUserIP();
                if (empty($files)) {
                    $model->upload_file = $modelB4->upload_file;
                } else {
                    $model->upload_file = $files->name;
                }

                $idBarbuk = Yii::$app->request->post('idBarbuk');
                $nm_barbuk = Yii::$app->request->post('pdmBarbukNama');
                $jml_barbuk = Yii::$app->request->post('pdmBarbukJumlah');
                $satuan_barbuk = Yii::$app->request->post('pdmBarbukSatuan');
                $sita_barbuk = Yii::$app->request->post('pdmBarbukSitaDari');
                $tindakan = Yii::$app->request->post('pdmBarbukTindakan');
                $kondisi_barbuk = Yii::$app->request->post('pdmBarbukKondisi');
                for($i=0;$i<count($idBarbuk);$i++) {
                    if(empty($idBarbuk[$i])) {
                        $modelBarbukTambahan = new PdmBarbukTambahan();
                        $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_barbuk_tambahan', 'id', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelBarbukTambahan->id = $seq['generate_pk'];
                        $modelBarbukTambahan->id_b4 = $model->id_b4;
                        $modelBarbukTambahan->nama = $nm_barbuk[$i];
                        $modelBarbukTambahan->jumlah = $jml_barbuk[$i];
                        $modelBarbukTambahan->id_satuan = $satuan_barbuk[$i];
                        $modelBarbukTambahan->sita_dari = $sita_barbuk[$i];
                        $modelBarbukTambahan->tindakan = $tindakan[$i];
                        $modelBarbukTambahan->id_stat_kondisi = $kondisi_barbuk[$i];
                        $modelBarbukTambahan->id_perkara = $model->id_perkara;
                        $modelBarbukTambahan->save(true);
                    }
                }

                if ($model->update(true)) {
                    if ($files != false) {
                        $path = Yii::$app->params['uploadPath'] . 'b4/' . $files->name;
                        $files->saveAs($path);
                    }
                }

                $id_barbuk_tambahan = Yii::$app->request->post('hapusIndex');
                for($i=0;$i<count($id_barbuk_tambahan);$i++) {
                    $modelBarbukTambahan = $this->findModelBarbuk($id_barbuk_tambahan[$i]);
                    $modelBarbukTambahan->flag = '3';
                    $modelBarbukTambahan->update(true);
                    //PdmBarbukTambahan::updateAll(['flag'=>'3'],'id=:id',[':id'=>$id_barbuk_tambahan[$i]]);
                }

                //Insert tabel tembusan
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::B4]);
                if (isset($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_b4;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B4;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
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

                return $this->redirect(['update', 'id' => $model->id_b4]);
            } catch (Exception $e) {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Diubah', // String
                    'title' => 'Update', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['update', 'id' => $model->id_b4]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'wilayah' => $wilayah,
                //'tersangka' => $dft_tersangka,
                'list_tersangka' => $listTersangka,
                'tindak_pidana' => $tindak_pidana,
                'dataProvider' => $dataProvider,
                'tabelbarbuk' => $tabelbarbuk,
            ]);
        }
    }

    /**
     * Deletes an existing PdmB4 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $id_b4 = $_POST['hapusIndex'];

            $session = new Session();
            $id_perkara = $session->get('id_perkara');

            if ($id_b4 === 'all') {
                PdmB4::updateAll(['flag' => '3'], 'id_perkara=:id_perkara', [':id_perkara' => $id_perkara]);

                $model = PdmB4::findAll(['id_perkara'=>$id_perkara]);
                foreach($model as $models):
                    PdmBarbukTambahan::updateAll(['flag'=>'3'],'id_b4=:id_b4',[':id_b4'=>$models['id_b4']]);
                endforeach;
            } else {
                for ($i = 0; $i < count($id_b4); $i++) {
                    $model = $this->findModel($id_b4[$i]);
                    $model->flag = '3';
                    $model->update(true);

                    PdmBarbukTambahan::updateAll(['flag'=>'3'],'id_b4=:id_b4',[':id_b4'=>$id_b4[$i]]);
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

    public function actionCetak($id)
    {
            
         $odf = new Odf(Yii::$app->params['report-path'] . "modules/pdsold/template/b4.odt");

        $model = PdmB4::findOne($id);

        $query = new Query();
        $tindak_pidana = $query->select('b.nama')->from('pidum.pdm_spdp a')->innerJoin('pidum.pdm_pk_ting_ref b', 'b.id = a.id_pk_ting_ref')
            ->where('a.id_perkara=:id_perkara', ['id_perkara' => $model->id_perkara])->one();

        // $dft_tersangka = '';
        // foreach (MsTersangka::findAll(['id_perkara' => $model->id_perkara]) as $key) {
        //     $dft_tersangka .= $key[nama] . ', ';
        // }
        $spdp = PdmSpdp::findOne(['id_perkara' => $model->id_perkara]);
        $ttd = PdmPenandatangan::findOne(['peg_nik' => $model->id_penandatangan]);

        $dft_tersangka = Yii::$app->globalfunc->getListTerdakwa($model->id_perkara);
        $kepala = Yii::$app->globalfunc->setKepalaReport($spdp->wilayah_kerja);
       
                $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_b4 b','a.peg_nik = b.id_penandatangan')
->where ("id_b4='".$id."'")
->one(); 

        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kepala',$pangkat->jabatan);
        $odf->setVars('no_surat', $model->no_surat);
        $odf->setVars('nomor_uud', '-');
        $odf->setVars('thn_uud', '-');
        $odf->setVars('tentang_uud', '-');
        $odf->setVars('penyidikan_penuntutan', $model->kepentingan);
        $odf->setVars('tindak_pidana', $tindak_pidana['nama']);
        $odf->setVars('nama_tersangka', trim($dft_tersangka, ', '));
        $odf->setVars('kepala_kejaksaan', $model->sprint_kepala);
        $odf->setVars('nomor_prin', $model->no_sprint);
        $odf->setVars('tanggal_prin', Yii::$app->globalfunc->indonesianFormat($model->tgl_sprint));
        $odf->setVars('penggeledahan', $model->penggeledahan);
        //$odf->setVars('penyitaan', $model->penyitaan);
        $odf->setVars('dikeluarkan', $model->dikeluarkan);
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->indonesianFormat($model->tgl_dikeluarkan));
        $odf->setVars('penandatangan', $ttd->nama);

        #penyitaan
        $query = new Query();
        $listSita = $query->select('*')->from('pidum.pdm_b4 a')
            ->innerJoin('pidum.pdm_barbuk_tambahan b','a.id_b4 = b.id_b4')
            ->where("a.id_b4='".$model->id_b4."' AND b.flag <> '3'")
            ->orderBy('b.id')->all();
        $i = '1';
        $dft_sita = $odf->setSegment('penyitaan');
        foreach ($listSita as $penyitaan) {
            $dft_sita->no_urut_sita($i);
            $dft_sita->nama_barang_sita($penyitaan['nama']);
            /*$dft_jaksa->pangkat_penyidik($jaksa['pangkat']);
            $dft_jaksa->nip_penyidik($jaksa['nip']);*/
            $i++;
            $dft_sita->merge();
        }
        $odf->mergeSegment($dft_sita);

        #penyidik
        $query = new Query();
        $listJaksa = $query->select('*')->from('pidum.pdm_jaksa_saksi')->where('id_perkara=:id_perkara AND code_table=:kode_tabel', [
            ':id_perkara' => $model->id_perkara,
            ':kode_tabel' => GlobalConstMenuComponent::P16A,
        ])->all();
        $i = '1';
        $dft_jaksa = $odf->setSegment('penyidik');
        foreach ($listJaksa as $jaksa) {
            $dft_jaksa->no_urut_penyidik($i);
            $dft_jaksa->nama_penyidik($jaksa['nama']);
            $dft_jaksa->pangkat_penyidik($jaksa['pangkat']);
            $dft_jaksa->nip_penyidik($jaksa['nip']);
            $i++;
            $dft_jaksa->merge();
        }
        $odf->mergeSegment($dft_jaksa);

        #tembusan
        $query = new Query();
        $query->select('*')
            ->from('pidum.pdm_tembusan')
            ->where("id_perkara='" . $model->id_perkara . "' and kode_table ='" . GlobalConstMenuComponent::B4 . "'");
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
    }

    public function actionTersangka()
    {
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id_tersangka = Yii::$app->request->post('id_tersangka');

            $tersangka = PdmP25::findOne(['id_tersangka'=>$id_tersangka]);

            return [
                'tersangka' => $tersangka
            ];
        }
    }

    /**
     * Finds the PdmB4 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB4 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmB4::findOne($id)) !== null)
            return $model;

        /*if (($model = PdmB4::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }

    protected function findModelBarbuk($id)
    {
        if(($model = PdmBarbukTambahan::findOne($id)) !== null)
            return $model;
    }
}
