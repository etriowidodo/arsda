<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was15;
use app\modules\pengawasan\models\Was15Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\Was15AKD;
use app\modules\pengawasan\models\Was15Ptimbangan;
use app\modules\pengawasan\models\Was15Saran;
use app\modules\pengawasan\models\SpRTingkatphd;
use app\modules\pengawasan\models\VWas15;
use app\modules\pengawasan\models\TembusanWas15;
use Odf;
use yii\web\CActiveForm;
use app\components\GlobalFuncComponent;
use app\modules\pengawasan\models\VTembusanWas15;
use yii\db\Query;
use app\modules\pengawasan\models\VWas15Hukdis;
use app\modules\pengawasan\models\VWas15InspeksiKasus;
use app\modules\pengawasan\models\DugaanPelanggaran;
use Nasution\Terbilang;

/**
 * Was15Controller implements the CRUD actions for Was15 model.
 */
class Was15Controller extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Was15 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Was15Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Was15 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        //print_r($id);exit();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Was15 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Was15();
        
        $was_register = 0;
        $searchModel = new \app\modules\pengawasan\models\Was1Search();
        if($model->isNewRecord){
            $session = Yii::$app->session;
            $was_register= $session->get('was_register'); 
            
        }else{
            $was_register = $model->id_register;
        } 
        $no_register = $searchModel->searchRegister($was_register);
        $model->no_register = $no_register->no_register;
        $model->id_register = $no_register->id_register;
        
        //get ringaksan from dugaan pelanggaran
        /*$model->ringkasan = DugaanPelanggaran::findOne(['id_register'=> $model->id_register])->ringkasan;
        print_r(DugaanPelanggaran::findOne(['id_register'=> $model->id_register])->ringkasan);exit();*/
        $modelDugaanPelanggaran = DugaanPelanggaran::findOne(['id_register'=> $model->id_register]); //perbaikan
        if (isset($was_register) && !empty($was_register)) {
            $findWas15 = Was15::findOne(['id_register'=>$was_register,'flag'=>'1']);
            if(isset($findWas15) && count($findWas15 > 0)){
                return $this->redirect(['update', 'id' => $findWas15->id_was_15]); 
            }
            else{
            
        if ($model->load(Yii::$app->request->post())){ //&& $model->save()) {
            $tembusan =  $_POST['id_jabatan']; 
            
            $model->no_was_15 = "R-".$_POST['Was15']['no_was_15'];
            $model->inst_satkerkd = $_POST['Was15']['inst_satkerkd'];
            $model->tgl_was_15 = $_POST['Was15']['tgl_was_15'];
            $model->sifat_surat = $_POST['Was15']['sifat_surat'];
            $model->jml_lampiran = $_POST['Was15']['jml_lampiran'];
            $model->satuan_lampiran = NULL;
            $model->rncn_jatuh_hukdis_1_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_1_was_15']; 
            $model->rncn_jatuh_hukdis_2_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_2_was_15'];
            $model->rncn_jatuh_hukdis_3_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_3_was_15'];
            $model->pendapat = $_POST['Was15']['pendapat'];
            $model->persetujuan = $_POST['Was15']['persetujuan'];
            $model->kepada = $_POST['Was15']['kepada']; //baru ditambahkan
            
            $model->ttd_was_15 = $_POST['Was15']['ttd_was_15']; //perlu ditanyakan
            $model->ttd_peg_nik = $_POST['Was15']['ttd_peg_nik'];
            $model->ttd_id_jabatan = $_POST['Was15']['ttd_id_jabatan'];
            
            $model->perihal = $_POST['Was15']['perihal'];
            $model->created_ip = Yii::$app->getRequest()->getUserIP();
            $modelDugaanPelanggaran->ringkasan = $_POST['Was15']['ringkasan']; //perbaikan
            //$model->upload_file = "Yes"; //masih belum
           
            //UPLOAD FILE
            $model->upload_file="filename";
            
            $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
            $model->upload_file = $files->name;
            if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'was_15/'.$files->name;
                    $files->saveAs($path);
                    }
            
            $model->save(); //menyimpan data di tabel was 15
            $modelDugaanPelanggaran->save; //mengupdate field ringkasan di Dugaan Pelanggaran
            //DATA-DATA
            for($i=0;$i<count($_POST['data']);$i++){
                $modeldata = new Was15AKD();
                $modeldata->id_was_15 = $model->id_was_15;
                $modeldata->analisa_kesimpulan = 3;
                $modeldata->isi = $_POST['data'][$i];
                $modeldata->upload_file = 'XXX'; //kurang jelas
                $modeldata->save();
            }
            
            //ANALISA
            for($i=0;$i<count($_POST['analisa']);$i++){
                $modelAnalisa = new Was15AKD();
                $modelAnalisa->id_was_15 = $model->id_was_15;
                $modelAnalisa->analisa_kesimpulan = 1;
                $modelAnalisa->isi = $_POST['analisa'][$i];
                $modelAnalisa->upload_file = 'XXX'; //kurang jelas
                $modelAnalisa->save();
            }
            
             //KESIMPULAN
            for($i=0;$i<count($_POST['kesimpulan']);$i++){
                $modelKesimpulan = new Was15AKD();
                $modelKesimpulan->id_was_15 = $model->id_was_15;
                $modelKesimpulan->analisa_kesimpulan = 2;
                $modelKesimpulan->isi = $_POST['kesimpulan'][$i];
                $modelKesimpulan->upload_file = 'XXX'; //kurang jelas
                $modelKesimpulan->save();
            }
            
            //Hal-hal memberatkan
            for($i=0;$i<count($_POST['memberatkan']);$i++){
                $modelBerat = new Was15Ptimbangan();
                $modelBerat->id_was_15 = $model->id_was_15;
                $modelBerat->ringan_berat = 1;
                $modelBerat->isi = $_POST['memberatkan'][$i];
                $modelBerat->upload_file = 'XXX'; //kurang jelas
                $modelBerat->save();
            }
            
            //Hal-hal meringankan
            for($i=0;$i<count($_POST['meringankan']);$i++){
                $modelRingan = new Was15Ptimbangan();
                $modelRingan->id_was_15 = $model->id_was_15;
                $modelRingan->ringan_berat = 2;
                $modelRingan->isi = $_POST['meringankan'][$i];
                $modelRingan->upload_file = 'XXX'; //kurang jelas
                $modelRingan->save();
            }
            
            
            //1.Rencana Penjatuhan Hukuman Disiplin 1
            for($i=0;$i<count($_POST['saran']);$i++){
                $modelJatuhHukumSatu = new Was15Saran();
                $modelJatuhHukumSatu->id_was_15 = $model->id_was_15;
                $modelJatuhHukumSatu->id_terlapor = $_POST['id_terlapor'][$i];
                $modelJatuhHukumSatu->id_peraturan = 0; //diset (perlu ditanyakan)
                $modelJatuhHukumSatu->tingkat_kd = $_POST['saran'][$i];
                $modelJatuhHukumSatu->upload_file = "XXX";//perlu ditanyakan
                $modelJatuhHukumSatu->rncn_jatuh_hukdis_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_1_was_15'];//perlu ditanyakan
                $modelJatuhHukumSatu->save();
            }
            
            //2.Rencana Penjatuhan Hukuman Disiplin 2
            for($i=0;$i<count($_POST['saran2']);$i++){
                $modelJatuhHukumDua = new Was15Saran();
                $modelJatuhHukumDua->id_was_15 = $model->id_was_15;
                $modelJatuhHukumDua->id_terlapor = $_POST['id_terlapor2'][$i];
                $modelJatuhHukumDua->id_peraturan = 0; //diset (perlu ditanyakan)
                $modelJatuhHukumDua->tingkat_kd = $_POST['saran2'][$i];
                $modelJatuhHukumDua->upload_file = "XXX";//perlu ditanyakan
                $modelJatuhHukumDua->rncn_jatuh_hukdis_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_2_was_15'];//perlu ditanyakan
                $modelJatuhHukumDua->save();
            }
            
            //3.Rencana Penjatuhan Hukuman Disiplin 3
            for($i=0;$i<count($_POST['saran3']);$i++){
                $modelJatuhHukumTiga = new Was15Saran();
                $modelJatuhHukumTiga->id_was_15 = $model->id_was_15;
                $modelJatuhHukumTiga->id_terlapor = $_POST['id_terlapor3'][$i];
                $modelJatuhHukumTiga->id_peraturan = 0; //diset (perlu ditanyakan)
                $modelJatuhHukumTiga->tingkat_kd = $_POST['saran3'][$i];
                $modelJatuhHukumTiga->upload_file = "XXX";//perlu ditanyakan
                $modelJatuhHukumTiga->rncn_jatuh_hukdis_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_3_was_15'];//perlu ditanyakan
                $modelJatuhHukumTiga->save();
            }
            
            for($i=0;$i<count($tembusan);$i++){
                    $saveTembusan = new TembusanWas15();
                    $saveTembusan->id_was_15 = $model->id_was_15;
                    $saveTembusan->id_pejabat_tembusan = $tembusan[$i];
                    $saveTembusan->save();
                    
                }
            
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

            return $this->redirect(['update', 'id' => $model->id_was_15]);
        } 

        else {
            return $this->render('create', [
                'model' => $model,
                'no_register' => $no_register,
                'was_register' => $was_register,
            ]);
            }
            
        }

        }
            else{
                $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/dugaan-pelanggaran/index"));
        }
    }

    public function actionCetak($id_was_15,$id_register)
    {
        $odf = new Odf(Yii::$app->params['report-path']."modules/pengawasan/template/was_15.odt");
        
        $was_15 = VWas15::find()->where("id_register='".$id_register."'")->andWhere("id_was_15='".$id_was_15."'")->one();
        //var_dump($was_15); exit();
        $tembusan = VTembusanWas15::find()->where("id_was_15='".$id_was_15."'")->all();
        $kepada = \app\modules\pengawasan\models\VPejabatPimpinan::find()->where("id_jabatan_pejabat='".$was_15->kepada."'")->one()->jabatan;
        $dari = \app\modules\pengawasan\models\VPejabatPimpinan::find()->where("id_jabatan_pejabat='".$was_15->ttd_was_15."'")->one()->jabatan;
        
        $odf->setVars('kejaksaan', $was_15->kejaksaan);
        $odf->setVars('kepada', $kepada);
        $odf->setVars('dari', $dari);
        $odf->setVars('tgl_was_15', GlobalFuncComponent::tglToWord($was_15->tgl_was_15));
        $odf->setVars('no_was_15', $was_15->no_was_15);
        $odf->setVars('sifat', $was_15->sifat);
        //$odf->setVars('jml_lampiran', $was_15->jml_lampiran);
        $odf->setVars('ttd_peg_nip', $was_15->ttd_peg_nip);
        $odf->setVars('ttd_peg_nama', $was_15->ttd_peg_nama);
        $odf->setVars('ttd_peg_jabatan', $was_15->ttd_peg_jabatan);
        
        
        
        $hukdis_1_pangkat = \app\models\LookupItem::findOne(['kd_lookup_group'=>'13','kd_lookup_item'=>$was_15->rncn_jatuh_hukdis_1_was_15]);
        $odf->setVars('hukdis_1_pangkat', $hukdis_1_pangkat->nm_lookup_item);
        
        $hukdis_2_pangkat = \app\modules\pengawasan\models\VPejabatTembusan::findOne(['id_pejabat_tembusan'=>$was_15->rncn_jatuh_hukdis_2_was_15]);
        $odf->setVars('hukdis_2_pangkat', $hukdis_2_pangkat->jabatan);
        
        $hukdis_3_pangkat = \app\modules\pengawasan\models\VPejabatPimpinan::findOne(['id_jabatan_pejabat'=>$was_15->rncn_jatuh_hukdis_3_was_15]);
        $odf->setVars('hukdis_3_pangkat', $hukdis_3_pangkat->jabatan);
        
        //inspeksi kasus
        $data_inspek = VWas15InspeksiKasus::findOne(['id_register'=>$was_15->id_register]);
        $odf->setVars('tgl_inspeksi', $data_inspek->tgl);
        $odf->setVars('nama_surat', $data_inspek->pejabat_sp_was_2);
        $odf->setVars('nomor_surat', $data_inspek->no_sp_was_2);
        $odf->setVars('tgl_surat', GlobalFuncComponent::tglToWord($data_inspek->tgl_sp_was_2));
        
        
        //jumlah lampiran
        if($was_15->jml_lampiran != ''){
          $terbilang = new Terbilang();
          $ini = $was_15->jml_lampiran." (".$terbilang->convert($was_15->jml_lampiran).")";
          $odf->setVars('jml_lampiran', $ini);
        }else{$odf->setVars('jml_lampiran', "-"); }
        
        //PELAPOR
        $query = new Query;
        $pelapor_was_15 = $query->select('b.no_register, b.tgl_dugaan, c.nama as nama_pelapor, c.alamat as alamat_pelapor')
                ->from('was.was_15 a')
                ->innerJoin('was.dugaan_pelanggaran b on(a.id_register = b.id_register)')
                ->innerJoin('was.v_pelapor c on(a.id_register = c.id_register)')
                ->where("a.id_register='".$id_register."'")
                ->all();
        
        //TERLAPOR
        $query = new Query;
        $terlapor_was_15 = $query->select('b.gol_pangkat,b.peg_nama nama_terlapor, b.jabatan as jabatan_terlapor,b.peg_nip, b.peg_nrp')
                ->from('was.was_15 a')
                ->innerJoin('was.v_terlapor b on(a.id_register = b.id_register)')
                ->where("a.id_register='".$id_register."'")
                ->all();
        //TERLAPOR
        $query = new Query;
        $permasalahan = $query->select('b.uraian as isi_permasalahan')
                ->from('was.was_15 a')
                ->innerJoin('was.v_dugaan_pelanggaran b on(a.id_register = b.id_register)')
                ->where("a.id_register='".$id_register."'")
                ->one();
        
        $odf->setVars('isi_permasalahan', $permasalahan['isi_permasalahan']);

        
        $query4 = new Query;
        $query4 = \app\modules\pengawasan\models\LookupItem::find()
                                ->select(['kd_lookup_item','nm_lookup_item'])
                                ->from('was.lookup_item')
                                ->where(['kd_lookup_group'=>'12'])
                                ->andWhere(['cast(kd_lookup_item as integer)'=>$was_15->persetujuan])
                                ->one();
        $odf->setVars('persetujuan', $query4->nm_lookup_item);
        $odf->setVars('pendapat', $was_15->pendapat);

       //print_r( $was_15->pendapat);
       //exit();
        
        
        #terlapor
        if(count($terlapor_was_15)>1){
          $nm_trlpr = $terlapor_was_15[0]['nama_terlapor']." , ".$terlapor_was_15[0]['jabatan_terlapor'].", dkk.";
          $odf->setVars('nama_terlapor', $nm_trlpr);
        }
        else{
          $odf->setVars('nama_terlapor', $terlapor_was_15[0]['nama_terlapor']." ".$terlapor_was_15[0]['jabatan_terlapor']);
        }
        $dft_terlapor = $odf->setSegment('terlapor');
        $i=1;
        foreach($terlapor_was_15 as $element){
            $dft_terlapor->no_terlapor($i);
            $dft_terlapor->nama_terlapor($element['nama_terlapor']);
            $dft_terlapor->nip_terlapor($element['peg_nip']);
            $dft_terlapor->nrp_terlapor($element['peg_nrp']);
            $dft_terlapor->jabatan_terlapor($element['jabatan_terlapor']);
            $dft_terlapor->pangkat_terlapor($element['gol_pangkat']);
            $dft_terlapor->merge();
            $i++;
        }
        $odf->mergeSegment($dft_terlapor);
        
        #pelapor
        $dft_pelapor = $odf->setSegment('pelapor');
        $i=1;
        foreach($pelapor_was_15 as $element){
            $dft_pelapor->no_pelapor($i);
            $dft_pelapor->no_register($element['no_register']);
            $dft_pelapor->tgl_dugaan(GlobalFuncComponent::tglToWord($element['tgl_dugaan']));
            $dft_pelapor->nama_pelapor($element['nama_pelapor']);
            $dft_pelapor->alamat_pelapor($element['alamat_pelapor']);
            $dft_pelapor->merge();
            $i++;
        }
        $odf->mergeSegment($dft_pelapor);
        
        
        $data = VWas15Hukdis::findAll(['rncn_jatuh_hukdis_was_15'=>$was_15->rncn_jatuh_hukdis_1_was_15]);
        
//        print_r(count($data));
//        exit();

        #hukdis1
        $dft_hukdis1 = $odf->setSegment('hukdis1');
        $i=1;
        foreach($data as $element){
            $dft_hukdis1->id_hukdis1($i);
            $dft_hukdis1->nama_terlapor($element['nama']);
            $dft_hukdis1->nip($element['nip']);
            $dft_hukdis1->nrp($element['nrp']);
            $dft_hukdis1->jabatan_terlapor($element['jabatan']);
            $dft_hukdis1->hukuman_disiplin($element['risedber']);
            $dft_hukdis1->isi_hukuman_disiplin($element['isi_hukuman_disiplin']);
            $dft_hukdis1->pasal_hukuman_disiplin($element['pasal']);
            $dft_hukdis1->merge();
            $i++;
        }
        $odf->mergeSegment($dft_hukdis1);
        
        
        $data2 = VWas15Hukdis::findAll(['rncn_jatuh_hukdis_was_15'=>$was_15->rncn_jatuh_hukdis_2_was_15]);
        
        #hukdis2
        $dft_hukdis2 = $odf->setSegment('hukdis2');
        $i=1;
        foreach($data2 as $element){
            $dft_hukdis2->id_hukdis2($i);
            $dft_hukdis2->nama_terlapor($element['nama']);
            $dft_hukdis2->nip($element['nip']);
            $dft_hukdis2->nrp($element['nrp']);
            $dft_hukdis2->jabatan_terlapor($element['jabatan']);
            $dft_hukdis2->hukuman_disiplin($element['risedber']);
            $dft_hukdis2->isi_hukuman_disiplin($element['isi_hukuman_disiplin']);
            $dft_hukdis2->pasal_hukuman_disiplin($element['pasal']);
            $dft_hukdis2->merge();
            $i++;
        }
        $odf->mergeSegment($dft_hukdis2);
         
        $data3 = VWas15Hukdis::findAll(['rncn_jatuh_hukdis_was_15'=>$was_15->rncn_jatuh_hukdis_3_was_15]);
        
//        print_r(count($data));
//        exit();

        #hukdis3
        $dft_hukdis3 = $odf->setSegment('hukdis3');
        $i=1;
        foreach($data3 as $element){
            $dft_hukdis3->id_hukdis3($i);
            $dft_hukdis3->nama_terlapor($element['nama']);
            $dft_hukdis3->nip($element['nip']);
            $dft_hukdis3->nrp($element['nrp']);
            $dft_hukdis3->jabatan_terlapor($element['jabatan']);
            $dft_hukdis3->hukuman_disiplin($element['risedber']);
            $dft_hukdis3->isi_hukuman_disiplin($element['isi_hukuman_disiplin']);
            $dft_hukdis3->pasal_hukuman_disiplin($element['pasal']);
            $dft_hukdis3->merge();
            $i++;
        }
        $odf->mergeSegment($dft_hukdis3);
        
        #tembusan
        $dft_tembusan = $odf->setSegment('tembusan');
        $i=1;
        foreach($tembusan as $element){
            $dft_tembusan->urutan_tembusan($i);
            $dft_tembusan->jabatan_tembusan($element['jabatan']);
            $dft_tembusan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_tembusan);
        
        
        ////////////////////////////////////
        $data = Was15AKD::find()->where(['analisa_kesimpulan'=>3,'id_was_15'=>$id_was_15])->all();
      
        #data
        $dft_data= $odf->setSegment('data');
        $i=1;
        foreach($data as $element){
            $dft_data->urutan_data($i);
            $dft_data->isi_data($element['isi']);
            $dft_data->merge();
            $i++;
        }
        $odf->mergeSegment($dft_data);
//      
        ///////////////////////////////////
        $analisa = Was15AKD::find()->where(['analisa_kesimpulan'=>1,'id_was_15'=>$id_was_15])->all();
       
        #analisa
        $dft_analisa = $odf->setSegment('analisa');
        $i=1;
        foreach($analisa as $element){
            $dft_analisa->urutan_analisa($i);
            $dft_analisa->isi_analisa($element['isi']);
            $dft_analisa->merge();
            $i++;
        }
        $odf->mergeSegment($dft_analisa);
//      ////////////////////////////////////////
        $kesimpulan = Was15AKD::find()->where(['analisa_kesimpulan'=>2,'id_was_15'=>$id_was_15])->all();
       
        #kesimpulan
        $dft_kesimpulan = $odf->setSegment('kesimpulan');
        $i=1;
        foreach($kesimpulan as $element){
            $dft_kesimpulan->urutan_kesimpulan($i);
            $dft_kesimpulan->isi_kesimpulan($element['isi']);
            $dft_kesimpulan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_kesimpulan);
//      ////////////////////////////////////////
        
        
        $data = Was15Ptimbangan::find()->where(['ringan_berat'=>1,'id_was_15'=>$id_was_15])->all();
      
        #memberatkan
        $dft_memberatkan= $odf->setSegment('memberatkan');
        $i=1;
        foreach($data as $element){
            //$dft_memberatkan->urutan_memberatkan($i);
            $dft_memberatkan->isi_memberatkan($element['isi']);
            $dft_memberatkan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_memberatkan);
        ////////////////////////////////////////////
        #meringankan
        $data = Was15Ptimbangan::find()->where(['ringan_berat'=>2,'id_was_15'=>$id_was_15])->all();
      
        $dft_meringankan= $odf->setSegment('meringankan');
        $i=1;
        foreach($data as $element){
            //$dft_meringankan->urutan_meringankan($i);
            $dft_meringankan->isi_meringankan($element['isi']);
            $dft_meringankan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_meringankan);
          
        $dugaan = \app\modules\pengawasan\models\DugaanPelanggaran::findBySql("select a.id_register,a.no_register,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor from was.dugaan_pelanggaran a
inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
inner join (
select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
    inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
    inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
        inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
            count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
        on (a.id_register=f.id_register) where a.id_register = :idRegister", [":idRegister"=>$id_register])->asArray()->one();
        
        $odf->exportAsAttachedFile("WAS15 - ".$dugaan['terlapor'].".odt");
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $was_register = 0;
        $searchModel = new \app\modules\pengawasan\models\Was1Search();
        if($model->isNewRecord){
            $session = Yii::$app->session;
            $was_register= $session->get('was_register'); 
            
        }else{
            $was_register = $model->id_register;
        } 
        $no_register = $searchModel->searchRegister($was_register);
        $model->no_register = $no_register->no_register;
        $model->id_register = $no_register->id_register;
        $model2 = Was15::findOne(array("id_was_15"=>$id));

        //get ringaksan from dugaan pelanggaran
        $model->ringkasan = DugaanPelanggaran::findOne(['id_register'=> $model->id_register])->ringkasan;
        $modelDugaanPelanggaran = DugaanPelanggaran::findOne(['id_register'=> $model->id_register]); //perbaikan
        //print_r(DugaanPelanggaran::findOne(['id_register'=> $model->id_register])->ringkasan);exit();
        
        //tembusan
        $modelTembusan = TembusanWas15::findAll(['id_was_15'=>$model->id_was_15]);
        
        //get nilai data2 tipe analisa kesimpulan = 3
        $modelData = Was15AKD::findAll(['id_was_15'=>$model->id_was_15,'analisa_kesimpulan'=>3]);
        
        //get nilai analisa tipe analisa kesimpulan = 1
        $modelAnalisa = Was15AKD::findAll(['id_was_15'=>$model->id_was_15,'analisa_kesimpulan'=>1]);
        
        //get nilai analisa tipe analisa kesimpulan = 2
        $modelKesimpulan = Was15AKD::findAll(['id_was_15'=>$model->id_was_15,'analisa_kesimpulan'=>2]);
     
        //Hal-hal memberatkan	Was_15_ptimbangan.ringan_berat = ‘1’
        $modelMemberatkan= Was15Ptimbangan::findAll(['id_was_15'=>$model->id_was_15,'ringan_berat'=>1]);
        
        //Hal-hal meringankan	Was_15_ptimbangan.ringan_berat = ‘2’
        $modelMeringankan= Was15Ptimbangan::findAll(['id_was_15'=>$model->id_was_15,'ringan_berat'=>2]);
        
        if ($model->load(Yii::$app->request->post())) {//&& $model->save()) {
              $tembusan =  $_POST['id_jabatan']; 
             
                $model->no_was_15 = "R-".$_POST['Was15']['no_was_15'];
                $model->inst_satkerkd = $_POST['Was15']['inst_satkerkd'];
                $model->tgl_was_15 = $_POST['Was15']['tgl_was_15'];
                $model->sifat_surat = $_POST['Was15']['sifat_surat'];
                $model->jml_lampiran = $_POST['Was15']['jml_lampiran'];
                $model->satuan_lampiran = NULL;
                $model->rncn_jatuh_hukdis_1_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_1_was_15']; 
                $model->rncn_jatuh_hukdis_2_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_2_was_15'];
                $model->rncn_jatuh_hukdis_3_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_3_was_15'];
                $model->pendapat = $_POST['Was15']['pendapat'];
                $model->persetujuan = $_POST['WAS15']['persetujuan'];
                $modelDugaanPelanggaran->ringkasan = $_POST['Was15']['ringkasan']; //perbaikan
                $model->perihal = $_POST['Was15']['perihal'];
                $model->updated_ip = Yii::$app->getRequest()->getUserIP();
                if(empty($_POST['Was15']['persetujuan'])){
                    $model->persetujuan = $model2->persetujuan;
                }
                else{
                    $model->persetujuan = $_POST['Was15']['persetujuan'];
                }
                $model->ttd_was_15 = $_POST['Was15']['ttd_was_15']; //perlu ditanyakan
                $model->ttd_peg_nik = $_POST['Was15']['ttd_peg_nik'];
                $model->ttd_id_jabatan = $_POST['Was15']['ttd_id_jabatan'];
                //$model->upload_file = "Yes"; //masih belum
               
                //UPLOAD FILE
                
                $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
                if(empty($files)){
                    $model->upload_file = $model2->upload_file;
                  }else{
                    $model->upload_file = $files->name;
                   }

               // $model->upload_file = $files->name;
                if ($files != false) {
                        $path = \Yii::$app->params['uploadPath'].'was_15/'.$files->name;
                        $files->saveAs($path);
                        }
                $modelDugaanPelanggaran->save();//mengupdate field ringkasan di Dugaan Pelanggaran
                $model->save(); //menyimpan data di tabel was 15
                
            //saat update, hapus dulu lalu simpan kembali
              Was15AKD::deleteAll('id_was_15=:del', [':del'=>$model->id_was_15]);

                //DATA-DATA
            for($i=0;$i<count($_POST['data']);$i++){
                $modeldata = new Was15AKD();
                $modeldata->id_was_15 = $model->id_was_15;
                $modeldata->analisa_kesimpulan = 3;
                $modeldata->isi = $_POST['data'][$i];
                $modeldata->upload_file = 'XXX'; //kurang jelas
                $modeldata->save();
            }
            
            //ANALISA
            for($i=0;$i<count($_POST['analisa']);$i++){
                $modelAnalisa = new Was15AKD();
                $modelAnalisa->id_was_15 = $model->id_was_15;
                $modelAnalisa->analisa_kesimpulan = 1;
                $modelAnalisa->isi = $_POST['analisa'][$i];
                $modelAnalisa->upload_file = 'XXX'; //kurang jelas
                $modelAnalisa->save();
            }
            
             //KESIMPULAN
            for($i=0;$i<count($_POST['kesimpulan']);$i++){
                $modelKesimpulan = new Was15AKD();
                $modelKesimpulan->id_was_15 = $model->id_was_15;
                $modelKesimpulan->analisa_kesimpulan = 2;
                $modelKesimpulan->isi = $_POST['kesimpulan'][$i];
                $modelKesimpulan->upload_file = 'XXX'; //kurang jelas
                $modelKesimpulan->save();
            }

             //saat update, hapus dulu lalu simpan kembali
              Was15Ptimbangan::deleteAll('id_was_15=:del', [':del'=>$model->id_was_15]);

            
            //Hal-hal memberatkan
            for($i=0;$i<count($_POST['memberatkan']);$i++){
                $modelBerat = new Was15Ptimbangan();
                $modelBerat->id_was_15 = $model->id_was_15;
                $modelBerat->ringan_berat = 1;
                $modelBerat->isi = $_POST['memberatkan'][$i];
                $modelBerat->upload_file = 'XXX'; //kurang jelas
                $modelBerat->save();
            }
            
            //Hal-hal meringankan
            for($i=0;$i<count($_POST['meringankan']);$i++){
                $modelRingan = new Was15Ptimbangan();
                $modelRingan->id_was_15 = $model->id_was_15;
                $modelRingan->ringan_berat = 2;
                $modelRingan->isi = $_POST['meringankan'][$i];
                $modelRingan->upload_file = 'XXX'; //kurang jelas
                $modelRingan->save();
            }
              //saat update, hapus dulu lalu simpan kembali
              Was15Saran::deleteAll('id_was_15=:del', [':del'=>$model->id_was_15]);

              for($i=0;$i<count($_POST['saran']);$i++){
                $modelJatuhHukumSatu = new Was15Saran();
                $modelJatuhHukumSatu->id_was_15 = $model->id_was_15;
                $modelJatuhHukumSatu->id_terlapor = $_POST['id_terlapor'][$i];
                $modelJatuhHukumSatu->id_peraturan = 0; //diset (perlu ditanyakan)
                $modelJatuhHukumSatu->tingkat_kd = $_POST['saran'][$i];
                $modelJatuhHukumSatu->upload_file = "XXX";//perlu ditanyakan
                $modelJatuhHukumSatu->rncn_jatuh_hukdis_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_1_was_15'];//perlu ditanyakan
                $modelJatuhHukumSatu->save();
            }
            
            //2.Rencana Penjatuhan Hukuman Disiplin 2
            for($i=0;$i<count($_POST['saran2']);$i++){
                $modelJatuhHukumDua = new Was15Saran();
                $modelJatuhHukumDua->id_was_15 = $model->id_was_15;
                $modelJatuhHukumDua->id_terlapor = $_POST['id_terlapor2'][$i];
                $modelJatuhHukumDua->id_peraturan = 0; //diset (perlu ditanyakan)
                $modelJatuhHukumDua->tingkat_kd = $_POST['saran2'][$i];
                $modelJatuhHukumDua->upload_file = "XXX";//perlu ditanyakan
                $modelJatuhHukumDua->rncn_jatuh_hukdis_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_2_was_15'];//perlu ditanyakan
                $modelJatuhHukumDua->save();
            }
            
            //3.Rencana Penjatuhan Hukuman Disiplin 3
            for($i=0;$i<count($_POST['saran3']);$i++){
                $modelJatuhHukumTiga = new Was15Saran();
                $modelJatuhHukumTiga->id_was_15 = $model->id_was_15;
                $modelJatuhHukumTiga->id_terlapor = $_POST['id_terlapor3'][$i];
                $modelJatuhHukumTiga->id_peraturan = 0; //diset (perlu ditanyakan)
                $modelJatuhHukumTiga->tingkat_kd = $_POST['saran3'][$i];
                $modelJatuhHukumTiga->upload_file = "XXX";//perlu ditanyakan
                $modelJatuhHukumTiga->rncn_jatuh_hukdis_was_15 = $_POST['Was15']['rncn_jatuh_hukdis_3_was_15'];//perlu ditanyakan
                $modelJatuhHukumTiga->save();
            }

            //saat update, hapus dulu lalu simpan kembali
              TembusanWas15::deleteAll('id_was_15=:del', [':del'=>$model->id_was_15]);

                for($i=0;$i<count($tembusan);$i++){
                    $saveTembusan = new TembusanWas15();
                    $saveTembusan->id_was_15 = $model->id_was_15;
                    $saveTembusan->id_pejabat_tembusan = $tembusan[$i];
                    $saveTembusan->save();
                    
                }
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

            return $this->redirect(['update', 'id' => $model->id_was_15]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTembusan'=>$modelTembusan,
                'no_register' => $no_register,
                'was_register' => $was_register,
                'modelData' => $modelData,
                'modelAnalisa' => $modelAnalisa,
                'modelKesimpulan' => $modelKesimpulan,
                'modelMemberatkan'=>$modelMemberatkan,
                'modelMeringankan' => $modelMeringankan,
                'modelSaran' => $modelSaran,
            ]);
        }
    }


    /**
     * Deletes an existing Was15 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Was15::updateAll(["flag" => '3'], "id_was_15 ='" . $id . "'")){
        Was15AKD::updateAll(["flag" => '3'], "id_was_15 ='" . $id . "'"); 
        Was15Ptimbangan::updateAll(["flag" => '3'], "id_was_15 ='" . $id . "'"); 
        Was15Saran::updateAll(["flag" => '3'], "id_was_15 ='" . $id . "'"); 
        TembusanWas15::updateAll(["flag" => '3'], "id_was_15 ='" . $id . "'");
        
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Dihapus', // String
                'title' => 'Save', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);
        }else{
            Yii::$app->getSession()->setFlash('danger', [
                'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Gagal Dihapus', // String
                'title' => 'Save', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);
        }
        return $this->redirect(['create']);
        //TembusanWas16a::updateAll(["flag" => '3'], "id_was_16a ='" . $arrIdWas16a[$i] . "'"
       /* return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
        //$this->findModel($id)->delete();

        //return $this->redirect(['index']);
    }

    /**
     * Finds the Was15 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was15 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was15::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}
