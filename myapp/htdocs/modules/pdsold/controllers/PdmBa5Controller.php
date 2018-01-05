<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\KpPegawaiSearch;
use app\modules\pdsold\models\PdmRb2;
use app\modules\pdsold\models\PdmBa4;
use app\modules\pdsold\models\PdmP16a;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\PdmP16ASearch;
use app\modules\pdsold\models\PdmBa18;
use app\modules\pdsold\models\PdmBa5;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmBarbuk;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmMsSatuan;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmBa5Search;
use app\modules\pdsold\models\PdmMsStatusData;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\PdmBa5Saksi;
use app\modules\pdsold\models\PdmBa5Barbuk;
use app\modules\pdsold\models\PdmBa5Jaksa;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\PdmTahapDua;
use yii\db\Query;
use yii\web\Session;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\components\GlobalConstMenuComponent;
use yii\web\UploadedFile;

/**
 * PdmBa18Controller implements the CRUD actions for PdmBa18 model.
 */
class PdmBa5Controller extends Controller
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
     * Lists all PdmBa18 models.
     * @return mixed
     */

    /*public function actionUnggah() {
        $id_no_surat_p16a = $_POST['no_surat_p16a'];
        $id_file_upload = $_POST['PdmP16a']['file_upload']; 
        Yii::$app->db->createCommand()
             ->update('pidum.pdm_p16a', ['file_upload' => $id_file_upload], ['no_surat_p16a'=>$id_no_surat_p16a])
             ->execute();
        return $this->redirect(['index']);
    }*/

   public function actionIndex()
   {
        // no need index page so redirect to update
        return $this->redirect('update');
        // $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA18 ]);
        // $searchModel = new PdmBa18Search();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        //     'sysMenu' => $sysMenu,
        // ]);
   }

    /**
     * Displays a single PdmBa18 model.
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
     * Creates a new PdmBa18 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA5 ]);

        $session = new Session();
        $id_perkara = $session->get('id_perkara');

        $model = new PdmBa18();

         $searchJPU = new PdmP16ASearch();
        $dataJPU = $searchJPU->search2($id_perkara,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        echo '<pre>';print_r($dataJPU);exit;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_ba18]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'id_perkara' => $id_perkara,
                'sysMenu' => $sysMenu,
				'searchJPU' => $searchJPU,
				'dataJPU' => $dataJPU,
                'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmBa18 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA5]);
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');

        $id             = $session->get('id_perkara');
        $model = $this->findModel($no_register_perkara);
        if ($model == null) {
            $model = new PdmBa5();
        }
       
        $rp9 = PdmTahapDua::findOne($no_register_perkara);
        $modelSaksi = PdmBa5Saksi::findAll(['no_register_perkara' =>$no_register_perkara]);

        $p16a = Yii::$app->globalfunc->GetLastP16a($no_register_perkara);
        $jaksaba5   = PdmBa5Jaksa::findAll(['no_register_perkara' =>$no_register_perkara]);

        //echo '<pre>';print_r($p16a);exit;

        if(count($jaksaba5>0)){
            $modelJaksa = $jaksaba5;
        }else{
            $modelJaksa = PdmJaksaP16a::findAll(['no_register_perkara' =>$no_register_perkara, 'no_surat_p16a'=>$p16a->no_surat_p16a]);
        }
        $modelBarbuk = PdmBa5Barbuk::findAll(['no_register_perkara' =>$no_register_perkara]);

        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;



        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);print_r($_SESSION);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                    $model = new PdmBa5();
                    PdmBa5::deleteAll(['no_register_perkara'=>$no_register_perkara]);

                    $model->no_register_perkara = $no_register_perkara;
                    $model->tgl_ba5 = $rp9->tgl_terima;
                    $model->lokasi  = $_POST['PdmBa5']['lokasi'];
                    $model->asal_satker  = $_POST['PdmBa5']['asal_satker'];
                    $model->no_reg_bukti = $_POST['PdmBa5']['no_reg_bukti'];

                    $model->created_time=date('Y-m-d H:i:s');
                    $model->created_by=\Yii::$app->user->identity->peg_nip;
                    $model->created_ip = \Yii::$app->getRequest()->getUserIP();

                    $model->updated_by=\Yii::$app->user->identity->peg_nip;
                    $model->updated_time=date('Y-m-d H:i:s');
                    $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

                    $model->file_upload=$_POST['PdmBa5']['file_upload'];
                    $model->uploaded_time = date('Y-m-d H:i:s');


                    
                    if(!$model->save()){
                        var_dump($model->getErrors());echo "ba5";exit;
                    }

                    //Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::BA18);
                //}
                #-data-baru
                $jaksa_jp = $_POST['penerima-peg_nip_news'];
                $nama_jp = $_POST['penerima-peg_nama_news'];
                $jabatan_jp = $_POST['penerima-jabatan_news'];
                $pangkat_jp = $_POST['penerima-pangkat_news'];
                $no_urut = $_POST['penerima-no_urut_news'];
                //new PdmBa5Jaksa();
                //PdmBa5Jaksa::deleteAll(['no_register_perkara'=>$no_register_perkara]);
                //INSERT JAKSA PENUNTUT UMUM
                if (!empty($jaksa_jp)) {
//                    PdmJaksaPenerima::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA18, 'id_table' => $model->id_ba18]);
                    for ($i = 0; $i < count($jaksa_jp); $i++) {
                        $modelJaksaPenerima = new PdmBa5Jaksa();
                        $modelJaksaPenerima->no_register_perkara = $no_register_perkara;
                        $modelJaksaPenerima->tgl_ba5    = $_POST['PdmBa5']['tgl_ba5'];
                        $modelJaksaPenerima->no_urut    = $i+1;
                        $modelJaksaPenerima->nip    = $_POST['penerima-peg_nip_news'][$i];
                        $modelJaksaPenerima->peg_nip_baru   = $_POST['penerima-peg_nip_news'][$i];
                        $modelJaksaPenerima->nama   = $_POST['penerima-peg_nama_news'][$i];
                        $modelJaksaPenerima->pangkat    = $_POST['penerima-pangkat_news'][$i];
                        $modelJaksaPenerima->jabatan    = $_POST['penerima-jabatan_news'][$i];
                        $modelJaksaPenerima->id_kejati  = $session->get('kode_kejati');
                        $modelJaksaPenerima->id_kejari  = $session->get('kode_kejari');
                        $modelJaksaPenerima->id_cabjari = $session->get('kode_cabjari');


                        if(!$modelJaksaPenerima->save()){
                            var_dump($modelJaksaPenerima->getErrors());echo "Jaksa Ba 5";exit;
                        }
                    }
                }
                //INSERT SAKSI
                //new PdmBa5Saksi();
                //PdmBa5Saksi::deleteAll(['no_register_perkara'=>$no_register_perkara]);
                $j_saksi    = $_POST['saksi-peg_nama_news'];
                if (!empty($j_saksi)) {
                    for ($i = 0; $i < count($j_saksi); $i++) {
                        $modelSaksi = new PdmBa5Saksi();
                        $modelSaksi->no_register_perkara = $no_register_perkara;
                        $modelSaksi->tgl_ba5    = $_POST['PdmBa5']['tgl_ba5'];
                        $modelSaksi->no_urut    = $i+1;
                        $modelSaksi->nip    = $_POST['saksi-peg_nip_news'][$i];
                        $modelSaksi->peg_nip_baru   = $_POST['saksi-peg_nip_news'][$i];
                        $modelSaksi->nama   = $_POST['saksi-peg_nama_news'][$i];
                        $modelSaksi->pangkat    = $_POST['saksi-pangkat_news'][$i];
                        $modelSaksi->jabatan    = $_POST['saksi-jabatan_news'][$i];
                        $modelSaksi->peg_nip_baru   = $_POST['saksi-peg_nip_baru_news'][$i];

                        if(!$modelSaksi->save()){
                            var_dump($modelSaksi->getErrors());echo "saksi Ba 5";exit;
                        }
                    }
                }



                
                $nm_barbuk = Yii::$app->request->post('pdmBarbukNama');
                $jml_barbuk = Yii::$app->request->post('pdmBarbukJumlah');
                $satuan_barbuk = Yii::$app->request->post('pdmBarbukSatuan');
                $sita_barbuk = Yii::$app->request->post('pdmBarbukSitaDari');
                $tindakan = Yii::$app->request->post('pdmBarbukTindakan');
                $kondisi_barbuk = Yii::$app->request->post('pdmBarbukKondisi');
                               
                for ($i = 0; $i < count($nm_barbuk); $i++) {
                    
                    $modelBarbuk = new PdmBarbuk();
                    
                    $modelBarbuk->no_register_perkara = $no_register_perkara;
                    $modelBarbuk->tgl_ba5   = $_POST['PdmBa5']['tgl_ba5'];
                    $modelBarbuk->no_urut_bb   = $i+1;
                    $modelBarbuk->nama  = empty($nm_barbuk[$i])?'-':$nm_barbuk[$i];
                    $modelBarbuk->jumlah= empty($jml_barbuk[$i])? '0': $jml_barbuk[$i];
                    $modelBarbuk->id_satuan = $satuan_barbuk[$i];
                    $modelBarbuk->sita_dari = empty($sita_barbuk[$i])?' .':$sita_barbuk[$i];
                    $modelBarbuk->tindakan  = empty($tindakan[$i])?' .':$tindakan[$i];
                    $modelBarbuk->id_stat_kondisi   = $kondisi_barbuk[$i];
                    $modelBarbuk->created_by    = \Yii::$app->user->identity->peg_nip;
                    $modelBarbuk->updated_by    = \Yii::$app->user->identity->peg_nip;
                    $modelBarbuk->created_time  = date('Y-m-d H:i:s');
                    $modelBarbuk->updated_time  = date('Y-m-d H:i:s');
                    if(!$modelBarbuk->save()){
                            var_dump($modelBarbuk->getErrors());echo "Barbuk Ba 5";exit;
                        }
                }
                
               /*$id_barbuk = Yii::$app->request->post('hapusIndex');
               for($i=0;$i<count($id_barbuk);$i++) {       
                    
                    $modelBarbuk = PdmBarbuk::findOne(['id' => $id_barbuk[$i]]);
                    $modelBarbuk->flag = '3';
                    $modelBarbuk->jumlah = (int)$modelBarbuk->jumlah;
                    $modelBarbuk->update();
                }*/
                
                $transaction->commit();

                //notifikasi simpan
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

                return $this->redirect(['update']);
            } catch (Exception $e) {
                $transaction->rollBack();

                //notifikasi gagal
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'warning', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan', // String
                    'title' => 'Ubah Data', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['update']);
            }
        } else {
            //$model = PdmTahap2::findOne(['no_register_perkara' => $no_register_perkara]);
            //echo '<pre>';print_r($model);exit;
            return $this->render('update', [
                        'model' => $model,
                        'id_perkara' => $id_perkara,
                        'modelSaksi' => $modelSaksi,
                        'modelJaksa' => $modelJaksa,
                        'modelBarbuk' => $modelBarbuk,
                        //'searchJPU' => $searchJPU,
                        'rp9'     => $rp9,
                        'dataJPU' => $dataJPU,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    public function actionJpu()
    {
        $session = new Session();
        $id_perkara = $session->get("id_perkara");
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataProviderJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        //echo '<pre>';print_r($dataProviderJPU->getTotalCount());exit;
        if($dataProviderJPU->getTotalCount()<=0){
            $dataProviderJPU = $searchJPU->search16a(Yii::$app->request->queryParams);
        }
        $dataProviderJPU->pagination->pageSize = 5;
        // return $this->renderAjax('_m_jpu', [
        //         'searchModel' => $searchModel,
        //         'dataProvider' => $dataProvider,
        // ]);
        return $this->renderAjax('_m_jaksa', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProviderJPU,
        ]);
    }

    public function actionGetSaksi()
    {
        $session  = new session();
        $kode  = $session->get('inst_satkerkd');

        $searchModel = new KpPegawaiSearch();
        $dataProvider = $searchModel->searchSaksi(Yii::$app->request->queryParams,$kode);
        $dataProvider->pagination->pageSize=5;
        return $this->renderAjax('_m_saksi', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }


    public function actionBarbuk()
    {
        if(!empty($_GET['id_barbuk'])){
            $modelBarbuk = PdmBarbuk::findOne(['id' => $_GET['id_barbuk']]);
        }

        if(empty($modelBarbuk)){
            $modelBarbuk = new PdmBarbuk();
        }
        
        $satuan = ArrayHelper::map(PdmMsSatuan::find()->all(), 'id', 'nama');
        $kondisi = ArrayHelper::map(PdmMsStatusData::find()->where(['is_group' => 'KND'])->all(), 'id', 'nama');
        
        return $this->renderAjax('_popBarbuk', [
            'modelBarbuk' => $modelBarbuk,
            'satuan' => $satuan,
            'kondisi' => $kondisi
        ]);
    }
	
    public function actionCetak()//$no_urut
	{
        //$no_urut = $_POST['no_urut'];


        $connection = \Yii::$app->db;
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $satker  = $session->get('inst_satkerkd');
        //$odf = new \Odf(Yii::$app->params['report-path'] . "modules/pdsold/template/ba5.docx");//sebelumya ba18

        //$ba18 = Pdmba18::findOne(['id_ba18' => $id_ba18]);
        $ba5    = Pdmba5::findOne(['no_register_perkara' => $no_register_perkara]);
        $p16a   = Yii::$app->globalfunc->GetLastP16a();
        if($p16a == NULL){
            $p16a = Yii::$app->globalfunc->GetLastP16();
        }
        //echo '<pre>';print_r($p16a);exit;
        $ba4    = Pdmba4::findOne(['no_register_perkara' => $no_register_perkara]);
        // echo $no_urut;exit;

        #list pasal
       /* $dft_pasal = '';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_uu_pasal_tahap2')
                ->where("no_register_perkara='" . $no_register_perkara . "'");
        $data = $query->createCommand();*/
        $listPasal = Yii::$app->globalfunc->getPasalH($no_register_perkara);

        //echo '<pre>';print_r($listPasal);exit;


        $dft_barbuk = '';
        $dft_tindakan = '';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_barbuk')
                ->where("no_register_perkara='" . $no_register_perkara . "' ");
        $data = $query->createCommand();
        $listBarbuk = $data->queryAll();

        #penandatangan Jaksa Penuntut Umum
        $query = new Query;
        $query->select('pjp.nama, pjp.jabatan, pjp.pangkat, pjp.nip')
                ->from('pidum.pdm_ba5_jaksa pjp')
                ->where("pjp.no_register_perkara = '" . $no_register_perkara . "' ")
                ->limit(2);
        $limit_jpu_penerima = $query->createCommand();
        $list_jpu_penerima = $limit_jpu_penerima->queryAll();

        // /echo '<pre>';print_r($list_jpu_penerima);exit;

        #penandatangan Jaksa Saksi
        $query = new Query;
        $query->select('pjp.nama, pjp.jabatan, pjp.pangkat, pjp.nip')
                ->from('pidum.pdm_ba5_saksi pjp')
                ->where("pjp.no_register_perkara = '" . $no_register_perkara . "' ")
                ->limit(2);
        $limit_jpu_saksi = $query->createCommand();
        $list_jpu_saksi = $limit_jpu_saksi->queryAll();

        $ba5    = Pdmba5::findOne(['no_register_perkara' => $no_register_perkara]);
        //$p16a   = Yii::$app->globalfunc->GetLastP16a($no_register_perkara);
        $ba4    = Pdmba4::findOne(['no_register_perkara' => $no_register_perkara]);
        $jaksa  =   PdmBa5Jaksa::findAll(['no_register_perkara' => $no_register_perkara]);
        $saksi  =   PdmBa5Saksi::findAll(['no_register_perkara' => $no_register_perkara]);
        // print_r($saksi);exit;
        $this->render('cetak', ['p16a'=>$p16a, 'ba5'=>$ba5, 'ba4'=>$ba4, 'list_jpu_penerima'=>$jaksa, 'list_jpu_saksi'=>$list_jpu_saksi, 'listPasal'=>$listPasal, 'listBarbuk'=>$listBarbuk, 'satker'=>$satker, 'no_register_perkara'=>$no_register_perkara]);
    }

        public function actionCetakDraft()//$no_urut
        {
            //$no_urut = $_POST['no_urut'];
            $no_urut= 0;
            $connection = \Yii::$app->db;
            $session = new session();
            $no_register_perkara = $session->get('no_register_perkara');
            $satker  = $session->get('inst_satkerkd');
            //$odf = new \Odf(Yii::$app->params['report-path'] . "modules/pdsold/template/ba5.docx");//sebelumya ba18

            //$ba18 = Pdmba18::findOne(['id_ba18' => $id_ba18]);
            $ba5    = '';Pdmba5::findOne(['no_register_perkara' => $no_register_perkara]);
            $p16a   = PdmP16a::findOne(['no_register_perkara' => $no_register_perkara]);
            $ba4    = Pdmba4::findOne(['no_register_perkara' => $no_register_perkara]);
            // echo $no_urut;exit;

            #list pasal
            $dft_pasal = '';
            $query = new Query;
            $query->select('*')
                    ->from('pidum.pdm_uu_pasal_tahap2')
                    ->where("no_register_perkara='" . $no_register_perkara . "'");
            $data = $query->createCommand();
            $listPasal = $data->queryAll();

            $dft_barbuk = '';
            $dft_tindakan = '';
            $query = new Query;
            $query->select('*')
                    ->from('pidum.pdm_barbuk')
                    ->where("no_register_perkara='" . $no_register_perkara . "' ");
            $data = $query->createCommand();
            $listBarbuk = $data->queryAll();

            #penandatangan Jaksa Penuntut Umum
            $query = new Query;
            $query->select('pjp.nama, pjp.jabatan, pjp.pangkat, pjp.nip')
                    ->from('pidum.pdm_ba5_jaksa pjp')
                    ->where("pjp.no_register_perkara = '" . $no_register_perkara . "' ")
                    ->limit(2);
            $limit_jpu_penerima = $query->createCommand();
            $list_jpu_penerima = $limit_jpu_penerima->queryAll();


            #penandatangan Jaksa Saksi
            $query = new Query;
            $query->select('pjp.nama, pjp.jabatan, pjp.pangkat, pjp.nip')
                    ->from('pidum.pdm_ba5_saksi pjp')
                    ->where("pjp.no_register_perkara = '" . $no_register_perkara . "' ")
                    ->limit(2);
            $limit_jpu_saksi = $query->createCommand();
            $list_jpu_saksi = $limit_jpu_saksi->queryAll();

            $ba5    = Pdmba5::findOne(['no_register_perkara' => $no_register_perkara]);
            //$p16a   = PdmP16a::findOne(['no_register_perkara' => $no_register_perkara]);
            $p16a = PdmP16a::find()->where(['no_register_perkara' => $no_register_perkara])->orderBy('tgl_dikeluarkan desc')->limit(1)->one();
            //echo '<pre>';print_r($p16a);exit;
            $ba4    = Pdmba4::findOne(['no_register_perkara' => $no_register_perkara]);
            $jaksa  =   PdmBa5Jaksa::findAll(['no_register_perkara' => $no_register_perkara]);
            $saksi  =   PdmBa5Saksi::findAll(['no_register_perkara' => $no_register_perkara]);
            // print_r($saksi);exit;
            $this->actionCetak();
            return $this->render('cetak', ['p16a'=>$p16a, 'ba5'=>$ba5, 'ba4'=>$ba4, 'list_jpu_penerima'=>$jaksa, 'list_jpu_saksi'=>$list_jpu_saksi, 'listPasal'=>$listPasal, 'listBarbuk'=>$listBarbuk, 'satker'=>$satker, 'no_register_perkara'=>$no_register_perkara]);
        }



    /**
     * Deletes an existing PdmBa18 model.
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
     * Finds the PdmBa18 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa18 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /*if (($model = PdmBa18::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
		if (($model = PdmBa5::findOne(['no_register_perkara' => $id])) !== null) {
            return $model;
        }
    }
    
    protected function findModelBarbuk($id)
    {        
        if(($model = PdmBarbuk::findOne($id)) !== null)
            return $model;
    }
}
