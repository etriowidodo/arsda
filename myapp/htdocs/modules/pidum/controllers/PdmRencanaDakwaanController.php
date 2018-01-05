<?php

namespace app\modules\pidum\controllers;

namespace app\modules\pidum\controllers;

use Yii;
use app\models\MsJkl;
use app\models\MsAgama;
use app\models\MsWarganegara;
use app\models\MsPendidikan;
use app\modules\pidum\models\PdmT6;
use app\modules\pidum\models\PdmT7;
use app\modules\pidum\models\PdmT8;
use app\modules\pidum\models\PdmRencanaDakwaan;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmP29;
use app\modules\pidum\models\PdmRp9;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmBerkas;
use app\modules\pidum\models\PdmMsUu;
use app\modules\pidum\models\VwTerdakwa;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\PdmMsRentut;
use app\modules\pidum\models\MsLokTahanan;
use app\modules\pidum\models\PdmRencanaDakwaanSearch;
use app\modules\pidum\models\PdmPasalDakwaan;
use app\modules\pidum\models\PdmAmarPutusP29;
use app\modules\pidum\models\PdmTahananPenyidik;
use yii\db\Query;
use yii\db\Exception;
use yii\web\Session;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\components\GlobalConstMenuComponent;
use app\components\ConstSysMenuComponent;
use yii\data\SqlDataProvider;
/**
 * PdmP29Controller implements the CRUD actions for PdmP29 model.
 */
class PdmRencanaDakwaanController extends Controller {

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
     * Lists all PdmP29 models.
     * @return mixed
     */
    public function actionIndex() {
       //$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::RencanaDakwaan]);

        $session = new Session();
        $id_perkara = $session->get("id_perkara");

       // $searchModel = new PdmRencanaDakwaanSearch();
        //$dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);
$query = " select a.id_berkas,coalesce(d.id_rencana_dakwaan,'0') as id_rencana_dakwaan,a.no_pengiriman ||' Tgl : '||tgl_pengiriman as no_tgl_berkas,a.tgl_terima,
STRING_AGG(c.nama, '<br/>' ORDER BY c.id_tersangka) as nama_tersangka
from pidum.pdm_berkas a
inner join pidum.pdm_tahanan_penyidik b on a.id_berkas = b.id_berkas
inner join pidum.ms_tersangka c on b.id_tersangka = c.id_tersangka
left join pidum.pdm_rencana_dakwaan d on a.id_berkas = d.id_berkas
where b.id_berkas is not null and b.flag <> '3' and a.flag <> '3' and a.id_perkara = '".$id_perkara."'
GROUP BY a.id_berkas,coalesce(d.id_rencana_dakwaan,'0'),a.no_pengiriman ||' Tgl : '||tgl_pengiriman
 ";
//print_r($query);exit;
	  $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


	$dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'id_berkas',
              'id_rencana_dakwaan',
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
        return $this->render('index', [
            'sysMenu' => $sysMenu,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmP29 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP29 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_berkas) {
       // $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::RencanaDakwaan]);

        $session = new Session();
        $id_perkara = $session->get("id_perkara");
		$id_berkas = PdmBerkas::findOne(['id_berkas' => $id_berkas]);
        $model = new PdmRencanaDakwaan();
        $modelAmarPutusan = new PdmAmarPutusP29();
        $modelSpdp = $this->findModelSpdp($id_perkara);
        $modelRp9 = PdmRp9::findOne(['id_perkara' => $id_perkara]);
        $modelPasal = new PdmPasalDakwaan();
        $modelJPU = PdmJaksaSaksi::find()->where(['id_perkara' => $id_perkara, 'code_table' => GlobalConstMenuComponent::P16])->orderBy('no_urut asc')->all();
        $modelUu = json_encode(PdmMsUu::find()->select('uu as id, uu as text')->asArray()->all());

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_rencana_dakwaan', 'id_rencana_dakwaan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                
                $model->id_rencana_dakwaan = $seq['generate_pk'];
				$model->id_berkas = $id_berkas->id_berkas;
                $model->id_perkara = $id_perkara;
				//print_r($model);exit;
				$model->save();
                if($model->save()){
                   // Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::P29);
                   // $NextProcces = array(ConstSysMenuComponent::P31);
                   // Yii::$app->globalfunc->getNextProcces($model->id_perkara,$NextProcces);

                   // $modelAmarPutusan->attributes = Yii::$app->request->post('PdmAmarPutusP29');
                    $undang = $_POST['undang'];
                    $pasal = $_POST['pasal'];

                    if(!empty($undang) || !empty($pasal)){
                        for($i=0; $i<count($undang); $i++){

                            $pdmPasalDakwaan = new PdmPasalDakwaan();

                            $seqPasal = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_pasal_dakwaan', 'id_pasal', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

                            $pdmPasalDakwaan->id_pasal = $seqPasal['generate_pk'];
                            $pdmPasalDakwaan->id_perkara = $model->id_perkara;
                            $pdmPasalDakwaan->id_tersangka = $model->id_tersangka;
                            $pdmPasalDakwaan->undang = $undang[$i];
                            $pdmPasalDakwaan->pasal = $pasal[$i];
                            $pdmPasalDakwaan->save();
                        }
                    }

                    if(!empty($modelAmarPutusan)){
                        $seqAmar = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_amar_putusp29', 'id_amar', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                        
                        $modelAmarPutusan->id_amar = $seqAmar['generate_pk'];
                        $modelAmarPutusan->id_perkara = $model->id_perkara;
                        $modelAmarPutusan->id_tersangka = $model->id_tersangka;
                        $modelAmarPutusan->is_surat = 'P-29';
                        $modelAmarPutusan->save();
                    }

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
            return $this->render('create', [
                'sysMenu' => $sysMenu,
				'id_berkas' => $id_berkas,
                'model' => $model,
                'modelSpdp' => $modelSpdp,
                'modelRp9' => $modelRp9,
                'modelPasal' => $modelPasal,
                'modelJPU' => $modelJPU,
                'modelUu' => $modelUu,
                'modelAmarPutusan' => $modelAmarPutusan,
            ]);
        }
    }

    /**
     * Updates an existing PdmP29 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_rencana_dakwaan,$id_berkas) {
		if($id_rencana_dakwaan=="0"){
			//$this->actionCreate($id_berkas);
			$this->redirect(['create','id_berkas'=>$id_berkas]);
		}else{
       // $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P29]);

        if(!empty($id_rencana_dakwaan)){
            $model = $this->findModel($id_rencana_dakwaan);
        }

        if (empty($model->id_perkara)) {
            $this->redirect('/pidum/spdp/index');
        }
        
        $session = new Session();
        $session->destroySession('id_perkara');
		 $id_perkara = $session->get("id_perkara");
        $session->set('id_perkara', $model->id_perkara);
		$id_berkas = PdmBerkas::findOne(['id_berkas' => $id_berkas]);
        $modelAmarPutusan = PdmAmarPutusP29::findOne(['id_perkara' => $model->id_perkara, 'id_tersangka' => $model->id_tersangka, 'is_surat' => 'P-29']);
        $modelSpdp = $this->findModelSpdp($model->id_perkara);
        $modelRp9 = PdmRp9::findOne(['id_perkara' => $model->id_perkara]);
        $modelPasal = PdmPasalDakwaan::find()
                        ->where('id_perkara=:id_perkara AND id_tersangka=:id_tersangka AND flag <>:flag', 
                            [':id_perkara' => $model->id_perkara, ':id_tersangka' => $model->id_tersangka, ':flag' => '3'])
                        ->all();
						
		
  
        $modelJPU = PdmJaksaSaksi::find()->where(['id_perkara' => $id_perkara, 'code_table' => GlobalConstMenuComponent::P16])->orderBy('no_urut asc')->all();
		
						  $modelJpu2 = PdmJaksaSaksi::find()->select('a.nama as nama,a.nip as peg_nip_baru')
->from('pidum.pdm_jaksa_saksi a, pidum.pdm_rencana_dakwaan b')
  ->where(" a.id_perkara = '".$id_perkara."' and a.code_table = 'P-16'
  and a.nip = b.id_penandatangan")
 ->one();
  
   $modelJpu3 = PdmJaksaSaksi::find()->select('a.nama as nama,a.nip as peg_nip_baru')
->from('pidum.pdm_jaksa_saksi a, pidum.pdm_rencana_dakwaan b')
  ->where(" a.id_perkara = '".$id_perkara."' and a.code_table = 'P-16'
  and a.nip != b.id_penandatangan")
 ->all();
 
 /*$modelJpu3 = PdmJaksaSaksi::find()->select("a.nama as nama,a.nip as peg_nip_baru")
  ->from("pidum.pdm_jaksa_saksi a,pidum.pdm_rencana_dakwaan b ")
  ->where(" a.code_table = 'P-16'
AND a.id_perkara = '".$id_perkara."'
and a.nip != b.id_penandatangan")
  ->orderBy('a.no_urut asc')->all();*/
 // print_r($modelJpu2);exit;
        $modelUu = json_encode(PdmMsUu::find()->select('uu as id, uu as text')->asArray()->all());

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
//print_r($model);exit;
            try{
                if($model->save() || $model->update()){

                    $modelAmarPutusan->attributes = Yii::$app->request->post('PdmAmarPutusP29');
                    $undang = $_POST['undang'];
                    $pasal = $_POST['pasal'];
                    $hapusUndangPasal = $_POST['hapus_undang_pasal'];
                    
                    if(!empty($hapusUndangPasal)){
                        for($a=0;$a<count($hapusUndangPasal);$a++){
                            $pasalUndang = Yii::$app->db->createCommand("UPDATE pidum.pdm_pasal_dakwaan SET flag = '3' WHERE id_pasal='$hapusUndangPasal[$a]'");
                            $pasalUndang->execute();
                            
                        }
                    }

                    if(!empty($undang) || !empty($pasal)){
                        for($i=0; $i<count($undang); $i++){

                            $pdmPasalDakwaan = new PdmPasalDakwaan();

                            $seqPasal = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_pasal_dakwaan', 'id_pasal', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

                            $pdmPasalDakwaan->id_pasal = $seqPasal['generate_pk'];
                            $pdmPasalDakwaan->id_perkara = $model->id_perkara;
                            $pdmPasalDakwaan->id_tersangka = $model->id_tersangka;
                            $pdmPasalDakwaan->undang = $undang[$i];
                            $pdmPasalDakwaan->pasal = $pasal[$i];
                            $pdmPasalDakwaan->save();
                        }
                    }

                    if(!empty($modelAmarPutusan)){
                        $modelAmarPutusan->is_surat = 'P-29';
                        $modelAmarPutusan->update();
                    }

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
                    return $this->redirect(['update', 'id_rencana_dakwaan' => $model->id_rencana_dakwaan]);
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
                return $this->redirect(['update', 'id_rencana_dakwaan' => $model->id_rencana_dakwaan]);
            }
            
        } else {
            return $this->render('update', [
                'sysMenu' => $sysMenu,
				'id_berkas' => $id_berkas,
                'model' => $model,
                'modelSpdp' => $modelSpdp,
                'modelRp9' => $modelRp9,
                'modelPasal' => $modelPasal,
                'modelUu' => $modelUu,
                'modelJPU' => $modelJPU,
				 'modelJpu2' => $modelJpu2,
						  'modelJpu3' => $modelJpu3,
                'modelAmarPutusan' => $modelAmarPutusan,
            ]);
        }
    }
	}
    /**
     * Deletes an existing PdmP29 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        try{
            $id = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id_perkara = $session->get('id_perkara');

                PdmP29::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
                PdmPasalDakwaan::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                    $id_tersangka = PdmP29::findOne(['id_rencana_dakwaan' => $id[$i]])->id_tersangka;
                    PdmPasalDakwaan::updateAll(['flag' => '3'], "id_tersangka = '" . $id_tersangka . "'");
                    PdmP29::updateAll(['flag' => '3'], "id_rencana_dakwaan = '" . $id[$i] . "'");
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

    public function actionCetak($id){
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/rencana.odt");
        
        $PdmRencanaDakwaan = PdmRencanaDakwaan::findOne(['id_rencana_dakwaan' => $id]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $PdmRencanaDakwaan->id_perkara]);
        $amarPutusan = PdmAmarPutusP29::findOne(['id_perkara' =>  $PdmRencanaDakwaan->id_perkara, 'id_tersangka' => $PdmRencanaDakwaan->id_tersangka]);
        $pasalDakwaan = PdmPasalDakwaan::findAll(['id_perkara' => $PdmRencanaDakwaan->id_perkara, 'id_tersangka' => $PdmRencanaDakwaan->id_tersangka]);
        $tersangka = MsTersangka::findOne(['id_tersangka' => $PdmRencanaDakwaan->id_tersangka]);
        $tahananPenyidik = PdmTahananPenyidik::findOne(['id_perkara' => $PdmRencanaDakwaan->id_perkara, 'id_tersangka' => $PdmRencanaDakwaan->id_tersangka]);
        $t6 = PdmT6::findOne(['id_perkara' => $PdmRencanaDakwaan->id_perkara, 'id_tersangka' => $PdmRencanaDakwaan->id_tersangka]);
        $t7 = PdmT7::findOne(['id_perkara' => $PdmRencanaDakwaan->id_perkara, 'id_tersangka' => $PdmRencanaDakwaan->id_tersangka]);
        $t8 = PdmT8::findOne(['id_perkara' => $PdmRencanaDakwaan->id_perkara, 'id_tersangka' => $PdmRencanaDakwaan->id_tersangka]);

        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('no_reg_perkara', $PdmRencanaDakwaan->no_perkara);

        $odf->setVars('nama', ucfirst(strtolower($tersangka->nama)));
        $odf->setVars('tempat_lahir', ucfirst(strtolower($tersangka->tmpt_lahir)));
        
        if($tersangka->tgl_lahir){
            $umur = Yii::$app->globalfunc->datediff($tersangka->tgl_lahir,date("Y-m-d"));
            $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir);  
        }else{
            $tgl_lahir = '-';
        }
        $odf->setVars('tgl_lahir', $tgl_lahir);
        $odf->setVars('jenis_kelamin', ucfirst(strtolower(MsJkl::findOne(['id_jkl' => $tersangka->id_jkl])->nama))); 
        $odf->setVars('kebangsaan', ucfirst(strtolower(MsWarganegara::findOne(['id' => $tersangka->warganegara])->nama)));
        $odf->setVars('tempat_tinggal', ucfirst(strtolower($tersangka->alamat))); 
        $odf->setVars('agama', ucfirst(strtolower(MsAgama::findOne(['id_agama' => $tersangka->id_agama])->nama))); 
        $odf->setVars('pekerjaan', ucfirst(strtolower($tersangka->pekerjaan))); 
        $odf->setVars('pendidikan', ucfirst(strtolower(MsPendidikan::findOne(['id_pendidikan' => $tersangka->id_pendidikan])->nama))); 

        #penahanan
        $lokasi = MsLokTahanan::findOne(['id_loktahanan' => $tahananPenyidik->id_msloktahanan]);

        $rutan_mulai = $lokasi->nama == "Rutan" ? Yii::$app->globalfunc->ViewIndonesianFormat($tahananPenyidik->tgl_mulai) : '-';
        $rutan_selesai = $lokasi->nama == "Rutan" ? Yii::$app->globalfunc->ViewIndonesianFormat($tahananPenyidik->tgl_selesai) : '-';
        $odf->setVars('rutan_mulai', $rutan_mulai);
        $odf->setVars('rutan_selesai', $rutan_selesai);

        $rumah_mulai = $lokasi->nama == "Rumah" ? Yii::$app->globalfunc->ViewIndonesianFormat($tahananPenyidik->tgl_mulai) : '-';
        $rumah_selesai = $lokasi->nama == "Rumah" ? Yii::$app->globalfunc->ViewIndonesianFormat($tahananPenyidik->tgl_selesai) : '-';
        $odf->setVars('rumah_mulai', $rumah_mulai);
        $odf->setVars('rumah_selesai', $rumah_selesai);

        $kota_mulai = $lokasi->nama == "Kota" ? Yii::$app->globalfunc->ViewIndonesianFormat($tahananPenyidik->tgl_mulai) : '-';
        $kota_selesai = $lokasi->nama == "Kota" ? Yii::$app->globalfunc->ViewIndonesianFormat($tahananPenyidik->tgl_selesai) : '-';
        $odf->setVars('kota_mulai', $kota_mulai);
        $odf->setVars('kota_selesai', $kota_selesai);

        $no_perpanjangan = !empty($t6) ? $t6->no_surat : '-';
        $tgl_perpanjangan = !empty($t6) ? Yii::$app->globalfunc->ViewIndonesianFormat($t6->tgl_dikeluarkan) : '-';
        $odf->setVars('perpanjang_penahanan', $no_perpanjangan);
        $odf->setVars('tgl_perpanjangan', $tgl_perpanjangan);

        $no_pengalihan = !empty($t7) ? $t7->no_surat : '-';
        $tgl_pengalihan = !empty($t7) ? Yii::$app->globalfunc->ViewIndonesianFormat($t7->tgl_dikeluarkan) : '-';
        $odf->setVars('pengalihan_jenis', $no_pengalihan);
        $odf->setVars('tgl_pengalihan', $tgl_pengalihan);

        // penangguhan penahanan --> putusan 1
        // pengeluaran dari tahanan --> putusan 2
        // pencabutan penangguhan penahanan --> putusan 3
        if(!empty($t8)){
            if($t8->putusan == 1){
                $no_penangguhan = $t8->no_surat;
                $tgl_penangguhan = Yii::$app->globalfunc->ViewIndonesianFormat($t8->tgl_dikeluarkan);
                $no_pencabutan = '-';
                $tgl_pencabutan = '-';
                $no_pengeluaran = '-';
                $tgl_pengeluaran = '-';
            }else if($t8->putusan == 2){
                $no_penangguhan = '-';
                $tgl_penangguhan = '-';
                $no_pencabutan = $t8->no_surat;
                $tgl_pencabutan = Yii::$app->globalfunc->ViewIndonesianFormat($t8->tgl_dikeluarkan);
                $no_pengeluaran = '-';
                $tgl_pengeluaran = '-';
            }else if($t8->putusan == 3){
                $no_penangguhan = '-';
                $tgl_penangguhan = '-';
                $no_pencabutan = '-';
                $tgl_pencabutan = '-';
                $no_pengeluaran = $t8->no_surat;
                $tgl_pengeluaran = Yii::$app->globalfunc->ViewIndonesianFormat($t8->tgl_dikeluarkan);
            }else{
                $no_penangguhan = '-';
                $tgl_penangguhan = '-';
                $no_pencabutan = '-';
                $tgl_pencabutan = '-';
                $no_pengeluaran = '-';
                $tgl_pengeluaran = '-';
            }
        }else{
            $no_penangguhan = '-';
            $tgl_penangguhan = '-';
            $no_pencabutan = '-';
            $tgl_pencabutan = '-';
            $no_pengeluaran = '-';
            $tgl_pengeluaran = '-';
        }
        $odf->setVars('penangguhan_penahanan', $no_penangguhan);
        $odf->setVars('tgl_penangguhan', $tgl_penangguhan);
        $odf->setVars('pencabutan', $no_pencabutan);
        $odf->setVars('tgl_pencabutan', $tgl_pencabutan);
        $odf->setVars('dikeluarkan_tahanan', $no_pengeluaran);
        $odf->setVars('tgl_dikeluarkan_tahanan', $tgl_pengeluaran);

        #dakwaan
        $dakwaan = PdmMsRentut::findOne(['id' => $amarPutusan->id_ms_rentut])->nama . ", ";
        $listDakwaan = $PdmRencanaDakwaan->getDakwaan($PdmRencanaDakwaan->id_perkara, $PdmRencanaDakwaan->id_tersangka);
        $dakwaan .= $listDakwaan['dakwaan'];
        $odf->setVars('dakwaan', $dakwaan);
        
        #pasal
        $dft_undang_pasal = '';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_pasal_dakwaan p')
                ->where("p.id_perkara='" . $PdmRencanaDakwaan->id_perkara . "' AND flag <> '3' AND p.id_tersangka = '" . $p29->id_tersangka . "'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();
        foreach($listPasal as $key){            
            $dft_undang_pasal .= $key['undang'] . ' ' . $key['pasal'] . ',';
        }
        $odf->setVars('pasal', preg_replace("/,$/", "", $dft_undang_pasal));

        #tandatangan
        $odf->setVars('dikeluarkan', ucfirst(strtolower($PdmRencanaDakwaan->dikeluarkan)));
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($PdmRencanaDakwaan->tgl_dikeluarkan));
        
        $qJpu = new Query;
        $qJpu->select('kpeg.peg_nip_baru,jpu.nama,jabatan,pangkat')
                        ->from('pidum.pdm_jaksa_saksi jpu, kepegawaian.kp_pegawai kpeg')
                        ->where(" kpeg.peg_nik = jpu.nip and jpu.nip = '" . $PdmRencanaDakwaan->id_penandatangan . "' ");
        $qJpu = $qJpu->createCommand();
        $qJpu = $qJpu->queryOne();

        $odf->setVars('nama_jpu', $qJpu['nama']);
        $odf->setVars('nip_jpu', $qJpu['peg_nip_baru']);
        $odf->setVars('pangkat_jpu', preg_replace("/\/ (.*)/", "", $qJpu['pangkat']));

        $odf->exportAsAttachedFile();
    }

    /**
     * Finds the PdmP29 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP29 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmRencanaDakwaan::findOne(['id_rencana_dakwaan' => $id])) !== null) {
            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne(['id_perkara' => $id])) !== null) {
            return $modelSpdp;
        }
    }

    public function getTerdakwa($form, $model, $modelSpdp, $readonly) {
        if($readonly){
            $terdakwa = $form->field($model, 'id_tersangka')->dropDownList(
                            ArrayHelper::map(
                                VwTerdakwa::find()
                                    ->where(['=', 'id_perkara', $modelSpdp->id_perkara] )
									
                                    ->all(), 
                                'id_tersangka',
                                'nama'
                            ),
                            ['prompt' => 'Pilih Terdakwa', 'class' => 'cmb_terdakwa', 'disabled' => true]
                    )->label(false);
        }else{
            $tersangkaP29 = '';
            $listTersangkaP29 = PdmP29::find()
                                ->select('id_tersangka')
                                ->where(['id_perkara' => $modelSpdp->id_perkara])
                                ->andWhere(['<>', 'flag', '3'])
                                ->all();
            for($i = 0; $i < count($listTersangkaP29); $i++){
                $tersangkaP29 .= $listTersangkaP29[$i]->id_tersangka . ', ';
            }
            $tersangkaP29 = preg_replace('/, $/', '', $tersangkaP29);
            $terdakwa = $form->field($model, 'id_tersangka')->dropDownList(
                        ArrayHelper::map(
                            VwTerdakwa::find()
                                ->where(['=', 'id_perkara', $modelSpdp->id_perkara])
                                ->andWhere(['not in', 'id_tersangka', [$tersangkaP29]])
                                ->all(), 
                            'id_tersangka',
                            'nama'
                        ),
                        ['prompt' => 'Pilih Terdakwa', 'class' => 'cmb_terdakwa']
                )->label(false);
        }

        $js = <<< JS
            $('.cmb_terdakwa').change(function(){

            $.ajax({
                type: "POST",
                url: '/pidum/default/terdakwa',
                data: 'id_tersangka='+$('.cmb_terdakwa').val(),
                success:function(data){
                    console.log(data);
                    $('#data-terdakwa').html(
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Tempat Lahir</label>'+
                            '<div class="col-sm-4">'+data.tmpt_lahir+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Tanggal Lahir</label>'+
                            '<div class="col-sm-4">'+data.tgl_lahir+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Jenis Kelamin</label>'+
                            '<div class="col-sm-4">'+data.jns_kelamin+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Tempat Tinggal</label>'+
                            '<div class="col-sm-4">'+data.alamat+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Agama</label>'+
                            '<div class="col-sm-4">'+data.agama+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Pekerjaan</label>'+
                            '<div class="col-sm-4">'+data.pekerjaan+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Pendidikan</label>'+
                            '<div class="col-sm-4">'+data.pendidikan+'</div>'+
                        '</div>'
                    );
                    $('.no_reg_tahanan').val(data.reg_tahanan);
                    $('.ditahan_sejak').val(data.ditahan_sejak);
                }
            });
            /*$.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : '/pidum/default/terdakwa', //Your form processing file URL
                data      : 'aa', //Forms name
                dataType  : 'json',
                success   : function(data) {
                            console.log(data);
            };*/
        });
JS;

        $this->view->registerJs($js);
        return $terdakwa;
    }

}
