<?php

namespace app\modules\pidum\controllers;
use app\models\Pdmt8Search;
use app\models\PdmTersangka;
use app\modules\pidum\models\MsTersangka;
use app\Models\MsAgama;
use app\Models\MsJkl;
use app\Models\MsPendidikan;
use app\Models\MsWarganegara;
use app\modules\pidum\models\MsLokTahanan;
use app\modules\pidum\models\MsTersangkaSearch;
use app\modules\pidum\models\PdmJaksaPenerima;
use app\modules\pidum\models\PdmJaksaP16a;
use app\modules\pidum\models\PdmTerdakwa;
/*use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmRp9;
use app\modules\pidum\models\PdmRt3;
*/use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmTrxPemrosesan;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\modules\pidum\models\PdmTahananPenyidik;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmBa11;
use app\modules\pidum\models\PdmT7;
use app\modules\pidum\models\PdmBa11Search;
use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\Pdmt8;
use yii\db\Query;
use yii\web\Session;
use app\modules\pidum\models\PdmSysMenu;

/**
 * PdmBA12Controller implements the CRUD actions for PdmBA12 model.
 */
class PdmBa11Controller extends Controller
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
     * Lists all PdmBA12 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA11]);

        $id_perkara = Yii::$app->session->get('id_perkara');

        $searchModel = new PdmBa11Search();
        $dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
            'sysMenu' => $sysMenu,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmBA12 model.
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
     * Creates a new PdmBA12 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA11 ]);

        $session = new Session();
        $id_perkara = $session->get("id_perkara");
        $no_register_perkara = $session->get("no_register_perkara");

        $model = new PdmBa11();
        $modelTersangka = $this->findModelTersangka($no_register_perkara);
        $modeljaksiChoosen = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register_perkara]);
        $modelLokTahanan = \yii\helpers\ArrayHelper::map(MsLoktahanan::find()->asArray()->all(),'id_loktahanan','nama');
        //$modeljaksi = $model->jaksaPelaksana($id_perkara);
        //$modelSpdp = $this->findModelSpdp($id_perkara);
        /*$modelt8 = Yii::$app
                    ->db
                    ->createCommand("SELECT t8.* FROM pidum.pdm_ba12 ba12
                        INNER JOIN pidum.pdm_t8 t8 ON ba12.id_perkara = t8.id_perkara
                        WHERE ba12.id_perkara = '$id_perkara' AND t8.flag <> '3'
                        AND t8.tgl_permohonan = (SELECT MAX(tgl_permohonan) FROM pidum.pdm_t8 WHERE id_perkara = '$id_perkara')")
                    ->queryOne();
        $modelRp9 = PdmRp9::findOne(['id_perkara' => $id_perkara]);
        $modelRt3 = PdmRt3::findOne(['id_perkara' => $id_perkara, 'id_tersangka' => $model->id_tersangka]);
        $tahanan = PdmTahananPenyidik::findOne(['id_perkara' => $id_perkara, 'id_tersangka' => $model->id_tersangka]);

        $queryTerdakwa = new Query;
        $queryTerdakwa->select('a.*')
                ->from('pidum.ms_tersangka a')
                ->innerJoin('pidum.pdm_terdakwa b on (a.id_tersangka=b.id_tersangka)')
                ->innerJoin('pidum.pdm_t8 c on (a.id_tersangka=c.id_tersangka)')
                ->innerJoin('pidum.pdm_ba12 d on (a.id_tersangka=d.id_tersangka)')
                ->where(['a.id_perkara' => $id_perkara, 'c.id_tersangka' => $modelt8['id_tersangka']]);

        $terdakwa = $queryTerdakwa->one();*/
        $searchTersangka = new Query;
        $searchTersangka->select('a.id_tersangka as no_urut, b.nama as nama, b.no_reg_tahanan as no_reg_tahanan, a.no_surat_t8')
                ->from('pidum.pdm_t8 a')
                ->innerJoin('pidum.pdm_ba4_tersangka b on (a.no_register_perkara=b.no_register_perkara) and (cast (a.id_tersangka as text)=cast(b.no_urut_tersangka as text))')
                //->innerJoin('pidum.pdm_t8 c on (a.id_tersangka=c.id_tersangka)')
                ->andWhere(['=', 'a.no_register_perkara', $no_register_perkara])
                ->andWhere(['=', 'a.id_ms_status_t8', '3']);
        $dataTersangka = $searchTersangka->all();
        //echo '<pre>';print_r($dataTersangka);exit;

        if ($model->load(Yii::$app->request->post())) {

            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try{
               // $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba12', 'id_ba12', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                
                //$model->id_ba12 = $seq['generate_pk'];
                $model->nama = $_POST['PdmBa11']['nama'];
                $model->no_register_perkara = $no_register_perkara;
                $model->no_surat_t8 = $_POST['PdmBa11']['no_surat_t8'];
                $model->tgl_ba11 = date('Y-m-d', strtotime($_POST['PdmBa11']['tgl_ba11']));
                $model->nip_jaksa = $_POST['PdmBa11']['nip_jaksa'];
                $model->no_reg_tahanan_jaksa = $_POST['PdmBa11']['no_reg_tahanan_jaksa'];
                $model->id_tersangka = $_POST['PdmBa11']['id_tersangka'];
                $model->tgl_penahanan = date('Y-m-d', strtotime($_POST['tgl_mulai']));
                $model->tindakan = $_POST['PdmBa11']['tindakan'];
                $model->id_ms_loktahanan = $_POST['PdmBa11']['id_ms_loktahanan'];
                $model->id_kejati = $session->get('kode_kejati');
                $model->id_kejari = $session->get('kode_kejari');
                $model->id_cabjari = $session->get('kode_cabjari');

                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();

                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

                
                if($model->save()){
                    //var_dump($model->getErrors());echo "Ba11";exit;
                    /*Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::BA12);

                    if (!empty($_POST['jaksa_pelaksana'])) {
                        $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        
                        $jaksa = explode("#", $_POST['jaksa_pelaksana']);
                        $modeljaksi = new PdmJaksaSaksi();
                        $modeljaksi->id_jpp = $seqjpp['generate_pk'];
                        $modeljaksi->id_perkara = $model->id_perkara;
                        $modeljaksi->code_table = GlobalConstMenuComponent::BA12;
                        $modeljaksi->id_table = $model->id_ba12;
                        $modeljaksi->flag = '1';
                        $modeljaksi->nama = $jaksa[2];
                        $modeljaksi->peg_nip_baru = $jaksa[0];
                        $modeljaksi->nip = $jaksa[1];
                        $modeljaksi->jabatan = $jaksa[3];
                        $modeljaksi->pangkat = $jaksa[4];
                        
                        $modeljaksi->save();
                    }*/

                    $transaction->commit();

                    //simpan
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil di Simpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    
                    return $this->redirect(['index']);
                }
                else{
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['create']);
                }
            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['create']);
            }
			
        } else {
            //echo '<pre>';print_r($model);exit;
            return $this->render('create', [
                'model' => $model,
                'modeljaksiChoosen' => $modeljaksiChoosen,
                'modelLokTahanan' => $modelLokTahanan,
                //'modeljaksi' => $modeljaksi,
                //'searchTersangka' => $searchTersangka,
                'dataTersangka' => $dataTersangka,
                'sysMenu' => $sysMenu,
                'no_register_perkara' =>$no_register_perkara,
	            //'id' =>$id,
				
            ]);
        }
    }

    /**
     * Updates an existing PdmBA12 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_tersangka,$no_register_perkara)
    {
        $session = new Session();
        $session->destroySession('no_register_perkara');
        //$session->set('id_perkara', $model->id_perkara);
        $session->set('no_register_perkara',$no_register_perkara);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA11 ]);

        if(!empty($id_tersangka)){
            $model = $this->findModel($id_tersangka, $no_register_perkara);
        }

        //echo '<pre>';print_r($id_tersangka);exit;
        if(empty($model->no_register_perkara)){
            $this->redirect('/pidum/pdm-ba11/index');
        }
        $modeljaksiChoosen = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register_perkara]);
        $modelLokTahanan = \yii\helpers\ArrayHelper::map(MsLoktahanan::find()->asArray()->all(),'id_loktahanan','nama');
        //$session = new Session();
        //$session->destroySession('id_perkara');
        //$session->set('id_perkara', $model->id_perkara);

        //$modelTersangka = $this->findModelTersangka($model->id_perkara);
        //$modeljaksiChoosen = PdmJaksaSaksi::findOne(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA12, 'id_table' => $model->id_ba12]);
        //$modeljaksi = $model->jaksaPelaksana($model->id_perkara);
        //$modelSpdp = $this->findModelSpdp($model->id_perkara);
		/*modelt8 = Yii::$app
                    ->db
                    ->createCommand("SELECT t8.* FROM pidum.pdm_ba12 ba12
                        INNER JOIN pidum.pdm_t8 t8 ON ba12.id_perkara = t8.id_perkara
                        WHERE ba12.id_ba12 = '$model->id_ba12' AND ba12.id_perkara = '$model->id_perkara' AND t8.flag <> '3'
                        AND t8.tgl_permohonan = (SELECT MAX(tgl_permohonan) FROM pidum.pdm_t8 WHERE id_perkara = '$model->id_perkara')")
                    ->queryOne();
        $modelRp9 = PdmRp9::findOne(['id_perkara' => $model->id_perkara]);
        $modelRt3 = PdmRt3::findOne(['id_perkara' => $model->id_perkara, 'id_tersangka' => $model->id_tersangka]);
        $tahanan = PdmTahananPenyidik::findOne(['id_perkara' => $model->id_perkara, 'id_tersangka' => $model->id_tersangka]);*/

		$searchTersangka = new Query;
        $searchTersangka->select('a.id_tersangka as no_urut, b.nama as nama, b.no_reg_tahanan as no_reg_tahanan, a.no_surat_t8')
                ->from('pidum.pdm_t8 a')
                ->innerJoin('pidum.pdm_ba4_tersangka b on (a.no_register_perkara=b.no_register_perkara) and (cast (a.id_tersangka as text)=cast(b.no_urut_tersangka as text))')
                //->innerJoin('pidum.pdm_t8 c on (a.id_tersangka=c.id_tersangka)')
                ->andWhere(['=', 'a.no_register_perkara', $no_register_perkara])
                ->andWhere(['=', 'a.id_ms_status_t8', '3']);
        $dataTersangka = $searchTersangka->all();

		if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            //echo '<pre>';print_r($_POST);exit;
            try{
                $model->nama = $_POST['PdmBa11']['nama'];
                $model->no_register_perkara = $no_register_perkara;
                $model->no_surat_t8 = $_POST['PdmBa11']['no_surat_t8'];
                $model->tgl_ba11 = date('Y-m-d', strtotime($_POST['PdmBa11']['tgl_ba11']));
                $model->nip_jaksa = $_POST['PdmBa11']['nip_jaksa'];
                $model->no_reg_tahanan_jaksa = $_POST['PdmBa11']['no_reg_tahanan_jaksa'];
                $model->id_tersangka = $_POST['PdmBa11']['id_tersangka'];
                $model->tgl_penahanan = date('Y-m-d', strtotime($_POST['tgl_mulai']));
                $model->tindakan = $_POST['PdmBa11']['tindakan'];
                $model->id_ms_loktahanan = $_POST['PdmBa11']['id_ms_loktahanan'];
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                if($model->save() || $model->update()){

                    /*PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA12, 'id_table' => $model->id_ba12]);
                    if (!empty($_POST['jaksa_pelaksana'])) {
        				$seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
        				
                        $jaksa = explode("#", $_POST['jaksa_pelaksana']);
        				$modeljaksi = new PdmJaksaSaksi();
        				$modeljaksi->id_jpp = $seqjpp['generate_pk'];
        				$modeljaksi->id_perkara = $model->id_perkara;
        				$modeljaksi->code_table = GlobalConstMenuComponent::BA12;
        				$modeljaksi->id_table = $model->id_ba12;
        				$modeljaksi->flag = '1';
        				$modeljaksi->nama = $jaksa[2];
                        $modeljaksi->peg_nip_baru = $jaksa[0];
        				$modeljaksi->nip = $jaksa[1];
        				$modeljaksi->jabatan = $jaksa[3];
        				$modeljaksi->pangkat = $jaksa[4];
        				
        				$modeljaksi->save();
                    }*/

                    $transaction->commit();

        			//simpan
        			Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil di Ubah',
                        'title' => 'Ubah Data',
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    
                    return $this->redirect(['index']);
                }else{
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal di Ubah',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['update', 'id_ba12' => $model->id_ba12]);
                }
            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['update', 'id_ba12' => $model->id_ba12]);
            }
			
        } else {
            return $this->render('update', [
                'model' => $model,
                'modeljaksiChoosen' => $modeljaksiChoosen,
                'modelLokTahanan' => $modelLokTahanan,
                //'modeljaksi' => $modeljaksi,
                //'searchTersangka' => $searchTersangka,
                'dataTersangka' => $dataTersangka,
                'sysMenu' => $sysMenu,
                'no_register_perkara' =>$no_register_perkara,
            ]);
        }
	}

    public function actionTerdakwa()
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $query = new Query;
        $query->select('vwt.*, b.tgl_penangguhan, b.no_surat_t8')
                ->from('pidum.vw_terdakwat2 vwt')
                ->innerJoin('pidum.pdm_t8 b on vwt.no_register_perkara=b.no_register_perkara and cast(vwt.no_urut_tersangka as text)=cast(b.id_tersangka as text)')
                ->where(['vwt.no_reg_tahanan' => $_POST['no_reg_tahanan']])
                ->andWhere(['=', 'vwt.no_register_perkara',$no_register_perkara ]);
        $terdakwa = $query->createCommand();
        $terdakwa = $terdakwa->queryOne();
        //echo '<pre>';print_r($terdakwa);exit;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'tmpt_lahir' => $terdakwa['tmpt_lahir'],
            'tgl_lahir' => ($terdakwa['tgl_lahir'] != null) ? date('d-m-Y', strtotime($terdakwa['tgl_lahir'])) : '',
            'jns_kelamin' => $terdakwa['is_jkl'],
            'alamat' => $terdakwa['alamat'],
            'agama' => $terdakwa['is_agama'],
            'pekerjaan' => $terdakwa['pekerjaan'],
            'pendidikan' => $terdakwa['is_pendidikan'],
            'ditahan_sejak' => $terdakwa['tgl_mulai'],
            'no_reg_tahanan' => $terdakwa['no_reg_tahanan'],
            'no_surat_t8' => $terdakwa['no_surat_t8'],
            'nama' => $terdakwa['nama'],
            'no_urut_tersangka' => $terdakwa['no_urut_tersangka'],
            'tgl_mulai' => ($terdakwa['tgl_mulai'] != null) ? date('d-m-Y', strtotime($terdakwa['tgl_mulai'])) : '',
        ];
    }

public function actionJpu()
    {
    	$searchModel = new VwJaksaPenuntutSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$dataProvider->pagination->pageSize=10;
    	return $this->renderAjax('_jpu', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }

    public function actionCetak ($id,$tgl_surat) {		
        $connection = \Yii::$app->db;
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $t8 = Pdmt8::findOne(['no_register_perkara' => $no_register_perkara, 'id_tersangka'=>$id]);
        $ba11 = PdmBa11::findOne(['no_register_perkara' => $no_register_perkara, 'id_tersangka'=>$id, 'tgl_ba11'=>$tgl_surat]);
        $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_urut_tersangka'=>$id]);
        
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_uu_pasal_tahap2')
                ->where("no_register_perkara='" . $no_register_perkara . "'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();
        $lokasi = MsLoktahanan::findOne(['id_loktahanan'=>$ba11->id_ms_loktahanan]);
        //echo '<pre>';print_r($lokasi);exit;
        return $this->render('cetak',['session'=>$_SESSION, 't8'=>$t8, 'ba11'=>$ba11, 'tersangka'=>$tersangka, 'listPasal'=>$listPasal, 'lokasi'=>$lokasi]);        
        /*$odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/ba12.odt");

        $ba12 = PdmBa12::findOne(['id_ba12' => $id]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $ba12->id_perkara]);
        $tahanan = PdmTahananPenyidik::findOne(['id_perkara' => $ba12->id_perkara, 'id_tersangka' => $ba12->id_tersangka]);

		$odf->setVars('Kejaksaan', ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama)));
		$odf->setVars('tgl_pembuatan', Yii::$app->globalfunc->getTanggalBeritaAcara( $ba12->tgl_pembuatan));
		$odf->setVars('tgl_mulai', Yii::$app->globalfunc->ViewIndonesianFormat( $ba12->tgl_mulai));
		$odf->setVars('hari', Yii::$app->globalfunc->GetNamaHari( $ba12->tgl_pembuatan));
		$odf->setVars('tgl_sp', Yii::$app->globalfunc->ViewIndonesianFormat( $ba12->tgl_sp));
		$odf->setVars('tgl_penahanan', !empty($tahanan->tgl_mulai) ? Yii::$app->globalfunc->ViewIndonesianFormat( $tahanan->tgl_mulai) : '-');
		$odf->setVars('no_reg_tahanan', $ba12->no_reg_tahanan);
		$odf->setVars('no_reg_perkara', $ba12->no_reg_perkara);
		$odf->setVars('no_sp', $ba12->no_sp);
		$odf->setVars('kepala_rutan', '..................');
		$odf->setVars('dari_tahanan', MsLokTahanan::findOne($tahanan->id_msloktahanan)->nama);
		
		# tersangka
        $sql ="SELECT * FROM "
                . " pidum.vw_tersangka "
                . "WHERE id_tersangka='".$ba12->id_tersangka."' ";
        $model = $connection->createCommand($sql);
        $tersangka = $model->queryOne();

        if(!empty($tersangka['tgl_lahir'])){
        $umur = Yii::$app->globalfunc->datediff($tersangka['tgl_lahir'],date("Y-m-d"));
        $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($tersangka['tgl_lahir']);  
        }else{
            $tgl_lahir = '-';
        }
        $odf->setVars('namaTersangka', ucfirst(strtolower($tersangka['nama'])));       
        $odf->setVars('tmpt_lahir', ucfirst(strtolower($tersangka['tmpt_lahir'])));       
        $odf->setVars('tgl_lahir', $tgl_lahir); 
        $odf->setVars('jenis_kelamin', ucfirst(strtolower($tersangka['is_jkl']))); 
        $odf->setVars('warganegara', ucfirst(strtolower($tersangka['warganegara']))); 
        $odf->setVars('tmpt_tinggal', ucfirst(strtolower($tersangka['alamat']))); 
        $odf->setVars('agama', ucfirst(strtolower($tersangka['is_agama']))); 
        $odf->setVars('pekerjaan', ucfirst(strtolower($tersangka['pekerjaan']))); 
        $odf->setVars('pendidikan', $tersangka['is_pendidikan']); 
        
        #Jaksa Pelaksana
        $query = new Query;
        $query->select('kpeg.peg_nip_baru,jpu.nama,jabatan,pangkat')
              ->from('pidum.pdm_jaksa_saksi jpu, kepegawaian.kp_pegawai kpeg')
              ->where(" kpeg.peg_nik = jpu.nip and jpu.id_perkara='".$ba12->id_perkara."' AND jpu.id_table = '" . $ba12->id_ba12 . "' AND jpu.code_table='".GlobalConstMenuComponent::BA12."'")
              ->orderby('jpu.no_urut');
        $dt_jaksaPelaksana = $query->createCommand();
        $listjaksaPelaksana = $dt_jaksaPelaksana->queryAll();
        $dft_jaksaPelaksana = $odf->setSegment('jaksaPelaksana');
        $i=1;
        foreach($listjaksaPelaksana as $element){
                $pangkat = explode('/',$element['pangkat']);

                $dft_jaksaPelaksana->urutan($i);
                $dft_jaksaPelaksana->nama_pegawai($element['nama']);
                $dft_jaksaPelaksana->nip_pegawai($element['peg_nip_baru']);
                $dft_jaksaPelaksana->pangkat_pegawai($pangkat[0]);
                $dft_jaksaPelaksana->merge();
            $i++;
        }
        $odf->mergeSegment($dft_jaksaPelaksana);  

        $queryLimitJaksa = new Query;
        $queryLimitJaksa->select('kpeg.peg_nip_baru,jpu.nama,jabatan,pangkat')
                        ->from('pidum.pdm_jaksa_saksi jpu, kepegawaian.kp_pegawai kpeg')
                        ->where(" kpeg.peg_nik = jpu.nip and jpu.id_perkara='".$ba12->id_perkara."' AND jpu.id_table = '" . $ba12->id_ba12 . "' AND jpu.code_table='".GlobalConstMenuComponent::BA12."'")
                        ->orderby('jpu.no_urut')
                        ->limit(1);
        $q_jaksa = $queryLimitJaksa->createCommand();
        $jaksa_penerima = $q_jaksa->queryAll();

        $odf->setVars('nama', $jaksa_penerima[0]['nama']);
        $odf->setVars('nip_pegawai', $jaksa_penerima[0]['peg_nip_baru']);
        $odf->setVars('pangkat', preg_replace("/\/ (.*)/", "", $jaksa_penerima[0]['pangkat']));
		
		#list pasal
        $dft_pasal ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_pasal')
                ->where("id_perkara='".$ba12->id_perkara."'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();  
        foreach($listPasal as $key){			
            $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
        }
        $odf->setVars('pasal', preg_replace('/, $/', '', $dft_pasal));
        
		$odf->exportAsAttachedFile();*/	
	}
    /**
     * Deletes an existing PdmBA12 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        /*try{
            $id = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id_perkara = $session->get('id_perkara');

                PdmBa12::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                    PdmBa12::updateAll(['flag' => '3'], "id_ba12 = '" . $id[$i] . "'");
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
        }*/
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        
            if($id_tahap=='all'){
                    $id_tahapx=PdmBa11::find()->select("id_tersangka, tgl_ba11")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['id_tersangka'].'#'.$value['tgl_ba11'];
                        
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }

        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                $ex = explode('#', $delete);
                $id_tersangka = $ex[0];
                $tgl_ba11 = $ex[1];
                    PdmBa11::deleteAll(['no_register_perkara' => $no_register_perkara, 'id_tersangka'=>$id_tersangka, 'tgl_ba11'=>$tgl_ba11]);
                }catch (\yii\db\Exception $e) {
                  $count++;
                }
            }
            if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  $count.' Data Berkas Tidak Dapat Dihapus Karena Sudah Digunakan Di Persuratan Lainnya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }

            return $this->redirect(['index']);
    }
    /**
     * Finds the PdmBA12 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBA12 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_tersangka, $no_register_perkara)
    {
        //echo '<pre>';print_r($id_tersangka.$no_register_perkara);exit;
        if (($model = PdmBa11::findOne(['no_register_perkara' => $no_register_perkara, 'id_tersangka' => $id_tersangka])) !== null) {
            return $model;
        }
    }
	
	protected function findModelTersangka($no_register_perkara)
    {
        if (($model = Pdmt8::findAll(['no_register_perkara' => $no_register_perkara, 'id_ms_status_t8'=>'1'])) !== null) {
            return $model;
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } 
    }
	
	
}