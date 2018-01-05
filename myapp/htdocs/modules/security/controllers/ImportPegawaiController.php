<?php

namespace app\modules\security\controllers;

use Yii;
use app\models\BackupData;
use app\modules\pidum\models\MsJenisPidanaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use app\modules\security\models\KpPegawai;
use app\modules\security\models\ConfigSatker;
use app\modules\security\models\ConfigSatkerSearch;
/**
 * MsJenisPidanaController implements the CRUD actions for MsJenisPidana model.
 */
class ImportPegawaiController extends Controller
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
     * Lists all MsJenisPidana models.
     * @return mixed
     */
    public function actionIndex()
    {
         //$model = new BackupData();
            return $this->render('pegawai', [
               //'model' => $model
            ]);  
        
    }
    public function actionOrang(){
    
        if (Yii::$app->request->post()) {
           $pegawai = json_decode($_POST['data']);
           $KpPegawai = new KpPegawai(); 
           $peg = $KpPegawai::findOne(['peg_nip_baru'=>$pegawai->{'PEG_NIP_BARU'}]);
            $KpPegawai::deleteAll(['peg_nip_baru' => $pegawai->{'PEG_NIP_BARU'}]);
              //peg_instakhir inst_satkerkd
              $KpPegawai->is_verified     = $pegawai->{'0'};
              $KpPegawai->peg_foto_baru   = $pegawai->{'1'};
              $KpPegawai->peg_jnspeg      = $pegawai->{'2'};
              $KpPegawai->tanggal_lp2p    = $pegawai->{'3'}; 
              $KpPegawai->tanggal_lkpn    = $pegawai->{'4'};
              $KpPegawai->cpns_tmt        = $pegawai->{'5'};
              $KpPegawai->pns_tmt         = $pegawai->{'6'};
              $KpPegawai->peg_karpegno    = $pegawai->{'7'};
              $KpPegawai->peg_nik         = $pegawai->{'8'};
              $KpPegawai->peg_nip         = $pegawai->{'9'};
              $KpPegawai->peg_nrp         = $pegawai->{'10'};
              $KpPegawai->peg_nip_baru    = $pegawai->{'11'};
              $KpPegawai->nip_nrp         = $pegawai->{'12'};
              $KpPegawai->nama            = $pegawai->{'13'};
              $KpPegawai->peg_jender      = $pegawai->{'14'};
              $KpPegawai->peg_agama       = $pegawai->{'15'};
              $KpPegawai->tlahir          = $pegawai->{'16'};
              $KpPegawai->peg_tgllahir    = $pegawai->{'17'};
              $KpPegawai->usia            = $pegawai->{'18'};
              $KpPegawai->peg_gelar           = $pegawai->{'19'};
              $KpPegawai->jabat_jenisjabatan  = $pegawai->{'20'};
              $KpPegawai->jaksa_tmt           = $pegawai->{'21'};
              $KpPegawai->jabatan             = $pegawai->{'22'};
              $KpPegawai->ref_jabatan_desc_singkat  = $pegawai->{'23'};
              $KpPegawai->ref_jabatan_kd            = $pegawai->{'24'};
              $KpPegawai->jabat_nosk      = $pegawai->{'25'};
              $KpPegawai->jabat_tglsk     = $pegawai->{'26'};
              $KpPegawai->jabatan_panjang = $pegawai->{'27'};
              $KpPegawai->unitkerja_kd    = $pegawai->{'28'};
              $KpPegawai->unitkerja_idk   = $pegawai->{'29'};
              $KpPegawai->unitkerja_nama  = $pegawai->{'30'};
              $KpPegawai->kode_jabatan    = $pegawai->{'31'};
              $KpPegawai->is_verified_jabatan = $pegawai->{'32'};
              $KpPegawai->jabat_tmt           = $pegawai->{'33'};
              $KpPegawai->peg_golakhir_mkth   = $pegawai->{'34'};
              $KpPegawai->eselon              = $pegawai->{'35'};
              $KpPegawai->jenjang             = $pegawai->{'36'}; 
              $KpPegawai->di_level            = $pegawai->{'37'};
              $KpPegawai->inst_satkerkd       = $_SESSION['inst_satkerkd'];
              $KpPegawai->is_active_satker    = $pegawai->{'39'};
              $KpPegawai->instansi            = $pegawai->{'40'};
              $KpPegawai->jabat_unitkerja     = $pegawai->{'41'};
              $KpPegawai->kelas_jabatan       = $pegawai->{'42'};
              $KpPegawai->gol_kd              = $pegawai->{'43'};
              $KpPegawai->gol_pangkat         = $pegawai->{'44'};
              $KpPegawai->gol_pangkat2        = $pegawai->{'45'};
              $KpPegawai->gol_mk_thn          = $pegawai->{'46'};
              $KpPegawai->gol_mk_bln          = $pegawai->{'47'};
              $KpPegawai->pns_jnsjbtfungsi    = $pegawai->{'48'};
              $KpPegawai->peg_jbtakhirfs      = $pegawai->{'49'};
              $KpPegawai->peg_jbtakhirstk     = $pegawai->{'50'};
              $KpPegawai->peg_stsmarital      = $pegawai->{'51'};
              $KpPegawai->marital             = $pegawai->{'52'};
              $KpPegawai->peg_alamat          = $pegawai->{'53'};
              $KpPegawai->peg_almtposkd       = $pegawai->{'54'}; 
              $KpPegawai->gol_pangkatjaksa    = $pegawai->{'55'};
              $KpPegawai->gol_tmt               = $pegawai->{'56'};
              $KpPegawai->is_verified_golongan  = $pegawai->{'57'};
              $KpPegawai->pns_kddkn_hkm         = $pegawai->{'58'};
              $KpPegawai->peg_pddkn_fml         = $pegawai->{'59'};
              $KpPegawai->is_verified_peg_pddkn_fml = $pegawai->{'60'};
              $KpPegawai->diklat_struktur           = $pegawai->{'61'};
              $KpPegawai->is_verified_diklat_struktur = $pegawai->{'62'}; 
              $KpPegawai->pendidikan                  = $pegawai->{'63'};
              $KpPegawai->pendidikan_panjang          = $pegawai->{'64'};
              $KpPegawai->spend_akronim               = $pegawai->{'65'};
              $KpPegawai->pend_tahunlulus             = $pegawai->{'66'};
              $KpPegawai->pend_namagelar              = $pegawai->{'67'};     
              $KpPegawai->status                      = $pegawai->{'68'};
              $KpPegawai->jenisjabatan                = $pegawai->{'69'};
              $KpPegawai->jabat_mk_th                 = $pegawai->{'70'};
              $KpPegawai->jabat_mk_bln                = $pegawai->{'71'};
              $KpPegawai->cpns_mk_th                  = $pegawai->{'72'};
              $KpPegawai->cpns_mk_bln                 = $pegawai->{'73'};
              $KpPegawai->masuk_masa_pensiun          = $pegawai->{'74'};
              $KpPegawai->no_askes                    = $pegawai->{'75'};
              $KpPegawai->pns_tgldisumpah             = $pegawai->{'76'}; 
              $KpPegawai->jumlah_keluarga             = $pegawai->{'77'};
              $KpPegawai->gaji_tmt                    = $pegawai->{'78'};
              $KpPegawai->kgb_tmt_yad                 = $pegawai->{'79'}; 
              $KpPegawai->max_gaji_tmt                = $pegawai->{'80'};
              $KpPegawai->kgb_gapok                   = $pegawai->{'81'};
              $KpPegawai->jabat_angkakredit           = $pegawai->{'82'};
              $KpPegawai->lon                         = $pegawai->{'83'};
              $KpPegawai->lat                         = $pegawai->{'84'};
              $KpPegawai->peg_instakhir_uk            = $pegawai->{'85'};
              $KpPegawai->peg_instakhir               = $_SESSION['inst_satkerkd'];
              $KpPegawai->gol_pangkat_jaksa_tu        = $pegawai->{'87'};
              $KpPegawai->gol_status_jaksa_tu         = $pegawai->{'88'};       
              $KpPegawai->pangkat_gol_jaksa_tu        = $pegawai->{'89'};

              $KpPegawai->save();

        }
    }
    public function actionInstansi(){
       $pegawai = json_decode($_POST['data']);
       // print_r($pegawai);
       $i = 0;
       $KpPegawaid = new KpPegawai(); 
       $KpPegawaid::deleteAll();
       foreach ($pegawai AS $key => $pegawai)
       {
         // echo ($val[$i]->{1});
        foreach($pegawai AS $key1=>$val1){
         // echo $i;
          $KpPegawai = new KpPegawai(); 
              $KpPegawai->is_verified     = $pegawai[$i]->{'0'};
              $KpPegawai->peg_foto_baru   = $pegawai[$i]->{'1'};
              $KpPegawai->peg_jnspeg      = $pegawai[$i]->{'2'};
              $KpPegawai->tanggal_lp2p    = $pegawai[$i]->{'3'}; 
              $KpPegawai->tanggal_lkpn    = $pegawai[$i]->{'4'};
              $KpPegawai->cpns_tmt        = $pegawai[$i]->{'5'};
              $KpPegawai->pns_tmt         = $pegawai[$i]->{'6'};
              $KpPegawai->peg_karpegno    = $pegawai[$i]->{'7'};
              $KpPegawai->peg_nik         = $pegawai[$i]->{'8'};
              $KpPegawai->peg_nip         = $pegawai[$i]->{'9'};
              $KpPegawai->peg_nrp         = $pegawai[$i]->{'10'};
              $KpPegawai->peg_nip_baru    = $pegawai[$i]->{'11'};
              $KpPegawai->nip_nrp         = $pegawai[$i]->{'12'};
              $KpPegawai->nama            = $pegawai[$i]->{'13'};
              $KpPegawai->peg_jender      = $pegawai[$i]->{'14'};
              $KpPegawai->peg_agama       = $pegawai[$i]->{'15'};
              $KpPegawai->tlahir          = $pegawai[$i]->{'16'};
              $KpPegawai->peg_tgllahir    = $pegawai[$i]->{'17'};
              $KpPegawai->usia            = $pegawai[$i]->{'18'};
              $KpPegawai->peg_gelar           = $pegawai[$i]->{'19'};
              $KpPegawai->jabat_jenisjabatan  = $pegawai[$i]->{'20'};
              $KpPegawai->jaksa_tmt           = $pegawai[$i]->{'21'};
              $KpPegawai->jabatan             = $pegawai[$i]->{'22'};
              $KpPegawai->ref_jabatan_desc_singkat  = $pegawai[$i]->{'23'};
              $KpPegawai->ref_jabatan_kd            = $pegawai[$i]->{'24'};
              $KpPegawai->jabat_nosk      = $pegawai[$i]->{'25'};
              $KpPegawai->jabat_tglsk     = $pegawai[$i]->{'26'};
              $KpPegawai->jabatan_panjang = $pegawai[$i]->{'27'};
              $KpPegawai->unitkerja_kd    = $pegawai[$i]->{'28'};
              $KpPegawai->unitkerja_idk   = $pegawai[$i]->{'29'};
              $KpPegawai->unitkerja_nama  = $pegawai[$i]->{'30'};
              $KpPegawai->kode_jabatan    = $pegawai[$i]->{'31'};
              $KpPegawai->is_verified_jabatan = $pegawai[$i]->{'32'};
              $KpPegawai->jabat_tmt           = $pegawai[$i]->{'33'};
              $KpPegawai->peg_golakhir_mkth   = $pegawai[$i]->{'34'};
              $KpPegawai->eselon              = $pegawai[$i]->{'35'};
              $KpPegawai->jenjang             = $pegawai[$i]->{'36'}; 
              $KpPegawai->di_level            = $pegawai[$i]->{'37'};
              $KpPegawai->inst_satkerkd       = $_SESSION['inst_satkerkd'];
              $KpPegawai->is_active_satker    = $pegawai[$i]->{'39'};
              $KpPegawai->instansi            = $pegawai[$i]->{'40'};
              $KpPegawai->jabat_unitkerja     = $pegawai[$i]->{'41'};
              $KpPegawai->kelas_jabatan       = $pegawai[$i]->{'42'};
              $KpPegawai->gol_kd              = $pegawai[$i]->{'43'};
              $KpPegawai->gol_pangkat         = $pegawai[$i]->{'44'};
              $KpPegawai->gol_pangkat2        = $pegawai[$i]->{'45'};
              $KpPegawai->gol_mk_thn          = $pegawai[$i]->{'46'};
              $KpPegawai->gol_mk_bln          = $pegawai[$i]->{'47'};
              $KpPegawai->pns_jnsjbtfungsi    = $pegawai[$i]->{'48'};
              $KpPegawai->peg_jbtakhirfs      = $pegawai[$i]->{'49'};
              $KpPegawai->peg_jbtakhirstk     = $pegawai[$i]->{'50'};
              $KpPegawai->peg_stsmarital      = $pegawai[$i]->{'51'};
              $KpPegawai->marital             = $pegawai[$i]->{'52'};
              $KpPegawai->peg_alamat          = $pegawai[$i]->{'53'};
              $KpPegawai->peg_almtposkd       = $pegawai[$i]->{'54'}; 
              $KpPegawai->gol_pangkatjaksa    = $pegawai[$i]->{'55'};
              $KpPegawai->gol_tmt               = $pegawai[$i]->{'56'};
              $KpPegawai->is_verified_golongan  = $pegawai[$i]->{'57'};
              $KpPegawai->pns_kddkn_hkm         = $pegawai[$i]->{'58'};
              $KpPegawai->peg_pddkn_fml         = $pegawai[$i]->{'59'};
              $KpPegawai->is_verified_peg_pddkn_fml = $pegawai[$i]->{'60'};
              $KpPegawai->diklat_struktur           = $pegawai[$i]->{'61'};
              $KpPegawai->is_verified_diklat_struktur = $pegawai[$i]->{'62'}; 
              $KpPegawai->pendidikan                  = $pegawai[$i]->{'63'};
              $KpPegawai->pendidikan_panjang          = $pegawai[$i]->{'64'};
              $KpPegawai->spend_akronim               = $pegawai[$i]->{'65'};
              $KpPegawai->pend_tahunlulus             = $pegawai[$i]->{'66'};
              $KpPegawai->pend_namagelar              = $pegawai[$i]->{'67'};     
              $KpPegawai->status                      = $pegawai[$i]->{'68'};
              $KpPegawai->jenisjabatan                = $pegawai[$i]->{'69'};
              $KpPegawai->jabat_mk_th                 = $pegawai[$i]->{'70'};
              $KpPegawai->jabat_mk_bln                = $pegawai[$i]->{'71'};
              $KpPegawai->cpns_mk_th                  = $pegawai[$i]->{'72'};
              $KpPegawai->cpns_mk_bln                 = $pegawai[$i]->{'73'};
              $KpPegawai->masuk_masa_pensiun          = $pegawai[$i]->{'74'};
              $KpPegawai->no_askes                    = $pegawai[$i]->{'75'};
              $KpPegawai->pns_tgldisumpah             = $pegawai[$i]->{'76'}; 
              $KpPegawai->jumlah_keluarga             = $pegawai[$i]->{'77'};
              $KpPegawai->gaji_tmt                    = $pegawai[$i]->{'78'};
              $KpPegawai->kgb_tmt_yad                 = $pegawai[$i]->{'79'}; 
              $KpPegawai->max_gaji_tmt                = $pegawai[$i]->{'80'};
              $KpPegawai->kgb_gapok                   = $pegawai[$i]->{'81'};
              $KpPegawai->jabat_angkakredit           = $pegawai[$i]->{'82'};
              $KpPegawai->lon                         = $pegawai[$i]->{'83'};
              $KpPegawai->lat                         = $pegawai[$i]->{'84'};
              $KpPegawai->peg_instakhir_uk            = $pegawai[$i]->{'85'};
              $KpPegawai->peg_instakhir               = $_SESSION['inst_satkerkd'];
              $KpPegawai->gol_pangkat_jaksa_tu        = $pegawai[$i]->{'87'};
              $KpPegawai->gol_status_jaksa_tu         = $pegawai[$i]->{'88'};       
              $KpPegawai->pangkat_gol_jaksa_tu        = $pegawai[$i]->{'89'}; 

              $KpPegawai->save();
          ++$i;
        }
        

       }

    }

    public function actionRestore()
    {
      return $this->redirect(['/restore-data']);
    }

   
}


/**
*C:\Users\A\AppData\Roaming\postgresql ->>for automatic password 
*system. example = localhost:5432:*:postgres:Simkari123
*/
