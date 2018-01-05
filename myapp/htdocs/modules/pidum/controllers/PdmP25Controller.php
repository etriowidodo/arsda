<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmP25;
use app\modules\pidum\models\PdmP25Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmDasarKeputusan;
use app\modules\pidum\models\PdmTemplateBerkas;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmSysMenu;
use yii\db\Query;
use yii\web\Session;

/**
 * PdmP25Controller implements the CRUD actions for PdmP25 model.
 */
class PdmP25Controller extends Controller
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
     * Lists all PdmP25 models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P25 ]);

        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $searchModel = new PdmP25Search();
        $dataProvider = $searchModel->search($id_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmP25 model.
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
     * Creates a new PdmP25 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P25 ]);
        $id_perkara = Yii::$app->session->get('id_perkara');

        $model = new PdmP25();
        $modelSpdp = $this->findModelSpdp($id_perkara);
        
        $dasar =  PdmTemplateBerkas::find()->where("kd_berkas='P-25' AND type_surat='Dasar'")->asArray()->all();       
        $pertimbangan =   PdmTemplateBerkas::find()->where("kd_berkas='P-25' AND type_surat='Pertimbangan'")->asArray()->all();
        $modelJaksaSaksi = new PdmJaksaSaksi();
        $pT7 = \app\modules\pidum\models\PdmT7::findOne(['id_perkara' => $id_perkara]); 

        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post()) ) {
           
             $transaction = Yii::$app->db->beginTransaction();
            try{
                $seqPdmP25 = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p25', 'id_p25', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                         $model->id_p25 = $seqPdmP25['generate_pk'];
                         $model->id_perkara = $modelSpdp->id_perkara;
                if($model->save()){
/*                    $deleteKeputusanDasar = PdmDasarKeputusan::deleteAll("id_table = :idTable and kode_table = :codeTable and type_surat='DASAR'",[":idTable"=>$model->id_p25,":codeTable"=>GlobalConstMenuComponent::P25]); 
                     for($i=0;$i<count($_POST['dasar']);$i++){
                          $seqPdmDasar = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_dasar_keputusan', 'id', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                      
                         $modelDasar = new PdmDasarKeputusan();
                         $modelDasar->kode_table = GlobalConstMenuComponent::P25;
                         $modelDasar->id = $seqPdmDasar['generate_pk'];
                         $modelDasar->id_table = $model->id_p25;
                         $modelDasar->type_surat = "DASAR";
                         $modelDasar->isi_surat = $_POST['dasar'][$i];
                         $modelDasar->save();
                     }
                     
                       $deleteKeputusanPertimbangan = PdmDasarKeputusan::deleteAll("id_table = :idTable and kode_table = :codeTable and type_surat='PERTIMBANGAN'",[":idTable"=>$model->id_p25,":codeTable"=>GlobalConstMenuComponent::P25]);
                     for($i=0;$i<count($_POST['pertimbangan']);$i++){
                           $seqPdmPertimbangan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_dasar_keputusan', 'id', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                       
                         $modelPertimbangan = new PdmDasarKeputusan();
                         $modelPertimbangan->id = $seqPdmPertimbangan['generate_pk'];
                         $modelPertimbangan->kode_table = GlobalConstMenuComponent::P25;
                         $modelPertimbangan->id_table = $model->id_p25;
                         $modelPertimbangan->type_surat = "PERTIMBANGAN";
                         $modelPertimbangan->isi_surat = $_POST['pertimbangan'][$i];
                         $modelPertimbangan->save();
                     }
                
*/                    
                
                $no_urut = $_POST["no_urut"];
                if (!empty($_POST['txtnip'])) { //peg_nip_baru
                    $count = 0;
                    foreach ($_POST['txtnip'] as $key) {
                        $query = new Query;
                        $query->select('*')
                                ->from('pidum.vw_jaksa_penuntut')
                                ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nip_baru='" . $key . "'");
                        $command = $query->createCommand();
                        $data = $command->queryAll();
                        $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modeljaksi = new PdmJaksaSaksi();
                        $modeljaksi->id_jpp = $seqjpp['generate_pk'];
                        $modeljaksi->id_perkara = $model->id_perkara;
                        $modeljaksi->code_table = GlobalConstMenuComponent::P25;
                        $modeljaksi->id_table = $model->id_p25;
                        $modeljaksi->flag = '1';
                        $modeljaksi->nama = $data[0]['peg_nama'];
                        $modeljaksi->nip = $data[0]['peg_nip'];
                        $modeljaksi->peg_nip_baru = $data[0]['peg_nip_baru'];
                        $modeljaksi->jabatan = $data[0]['jabatan'];
                        $modeljaksi->pangkat = $data[0]['pangkat'];
                        $modeljaksi->no_urut = $no_urut[$count];
                        $modeljaksi->save();

                        $count++;
                    }
                }

                   // $deletePdm =  PdmTembusan::deleteAll('id_perkara = :idPerkara', [":idPerkara"=>$model->id_perkara]);     
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::P25]);
                if(isset($_POST['new_tembusan'])){
                    for($i = 0; $i < count($_POST['new_tembusan']); $i++){
                            $modelNewTembusan= new PdmTembusan();
                            $modelNewTembusan->id_table = $model->id_p25;
                            $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                            $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                            $modelNewTembusan->kode_table =  GlobalConstMenuComponent::P25;
                            $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];                 
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];                   
                            $modelNewTembusan->id_perkara = $model->id_perkara;
                            $modelNewTembusan->nip = null;
                            $modelNewTembusan->save();
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
                 // return $this->redirect(['update']);
                 return $this->redirect(['update', 'id_p25' => $model->id_p25]);
                }else{
       

                      $transaction->rollback();
                       Yii::$app->getSession()->setFlash('danger', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                        'sysMenu' => $sysMenu,   
                    ]);
                    return $this->render('update', [
                'model' => $model,
                'pT7' => $pT7,
                'dasar' => $dasar,
                'pertimbangan' => $pertimbangan,
                'modelSpdp' => $modelSpdp,
                'modelJaksaSaksi' => $modelJaksaSaksi,
                'sysMenu' => $sysMenu        
            ]); 
                }
               
            } catch (Exception $ex) {
                   
               
                 $transaction->rollback();
            }
           
        } else {
               
            return $this->render('update', [
                'model' => $model,
                'pT7' => $pT7,
                'dasar' => $dasar,
                'pertimbangan' => $pertimbangan,
                'modelSpdp' => $modelSpdp,
                'modelJaksaSaksi' => $modelJaksaSaksi,
                'searchJPU' => $searchJPU,
                'dataJPU' => $dataJPU,
                'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Updates an existing PdmP25 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_p25)
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P25 ]);
       
        $model = $this->findModel($id_p25);
        $modelSpdp = $this->findModelSpdp($model->id_perkara);        
        $dasar =  PdmTemplateBerkas::find()->where("kd_berkas='P-25' AND type_surat='Dasar'")->asArray()->all();
       
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        $pertimbangan =   PdmTemplateBerkas::find()->where("kd_berkas='P-25' AND type_surat='Pertimbangan'")->asArray()->all();
        $modelJaksaSaksi = new PdmJaksaSaksi();
        if($model == null){
        	$model = new PdmP25();
        }else{
            $dasar = PdmDasarKeputusan::find()->where("id_table = :idTable and kode_table = :codeTable and type_surat='DASAR'",[":idTable"=>$model->id_p25,":codeTable"=>GlobalConstMenuComponent::P25])->asArray()->all();
            $pertimbangan = PdmDasarKeputusan::find()->where("id_table = :idTable and kode_table = :codeTable and type_surat='PERTIMBANGAN'",[":idTable"=>$model->id_p25,":codeTable"=>GlobalConstMenuComponent::P25])->asArray()->all();
            $modelJaksaSaksi = PdmJaksaSaksi::find()->where('id_perkara = :idPerkara and id_table = :idTable and code_table = :codeTable',[":idPerkara"=>$model->id_perkara,":idTable"=>$model->id_p25,":codeTable"=>GlobalConstMenuComponent::P25])->all();
        }
        $pT7 = \app\modules\pidum\models\PdmT7::findOne(['id_perkara' => $model->id_perkara]); 

        if ($model->load(Yii::$app->request->post()) ) {
           
             $transaction = Yii::$app->db->beginTransaction();
            try{
                // $seqPdmP25 = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p25', 'id_p25', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                         // $model->id_p25 = $seqPdmP25['generate_pk'];
                         // $model->id_perkara = $modelSpdp->id_perkara;
                if($model->save()){
                    $deleteKeputusanDasar = PdmDasarKeputusan::deleteAll("id_table = :idTable and kode_table = :codeTable and type_surat='DASAR'",[":idTable"=>$model->id_p25,":codeTable"=>GlobalConstMenuComponent::P25]); 
                     for($i=0;$i<count($_POST['dasar']);$i++){
                          $seqPdmDasar = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_dasar_keputusan', 'id', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                      
                         $modelDasar = new PdmDasarKeputusan();
                         $modelDasar->kode_table = GlobalConstMenuComponent::P25;
                         $modelDasar->id = $seqPdmDasar['generate_pk'];
                         $modelDasar->id_table = $model->id_p25;
                         $modelDasar->type_surat = "DASAR";
                         $modelDasar->isi_surat = $_POST['dasar'][$i];
                         $modelDasar->save();
                     }
                     
                       $deleteKeputusanPertimbangan = PdmDasarKeputusan::deleteAll("id_table = :idTable and kode_table = :codeTable and type_surat='PERTIMBANGAN'",[":idTable"=>$model->id_p25,":codeTable"=>GlobalConstMenuComponent::P25]);
                     for($i=0;$i<count($_POST['pertimbangan']);$i++){
                           $seqPdmPertimbangan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_dasar_keputusan', 'id', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                       
                         $modelPertimbangan = new PdmDasarKeputusan();
                         $modelPertimbangan->id = $seqPdmPertimbangan['generate_pk'];
                         $modelPertimbangan->kode_table = GlobalConstMenuComponent::P25;
                         $modelPertimbangan->id_table = $model->id_p25;
                         $modelPertimbangan->type_surat = "PERTIMBANGAN";
                         $modelPertimbangan->isi_surat = $_POST['pertimbangan'][$i];
                         $modelPertimbangan->save();
                     }
                
                    
                    PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::P25, 'id_table' => $model->id_p25]);
                    $no_urut = $_POST["no_urut"];
                    if (!empty($_POST['txtnip'])) { //peg_nip_baru
                        $count = 0;
                        foreach ($_POST['txtnip'] as $key) {
                            $query = new Query;
                            $query->select('*')
                                    ->from('pidum.vw_jaksa_penuntut')
                                    ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nip_baru='" . $key . "'");
                            $command = $query->createCommand();
                            $data = $command->queryAll();
                            $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                            $modeljaksi = new PdmJaksaSaksi();
                            $modeljaksi->id_jpp = $seqjpp['generate_pk'];
                            $modeljaksi->id_perkara = $model->id_perkara;
                            $modeljaksi->code_table = GlobalConstMenuComponent::P25;
                            $modeljaksi->id_table = $model->id_p25;
                            $modeljaksi->flag = '1';
                            $modeljaksi->nama = $data[0]['peg_nama'];
                            $modeljaksi->nip = $data[0]['peg_nip'];
                            $modeljaksi->peg_nip_baru = $data[0]['peg_nip_baru'];
                            $modeljaksi->jabatan = $data[0]['jabatan'];
                            $modeljaksi->pangkat = $data[0]['pangkat'];
                            $modeljaksi->no_urut = $no_urut[$count];
                            $modeljaksi->save();

                            $count++;
                        }
                    }
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::P25]);		
                if(isset($_POST['new_tembusan'])){
                    for($i = 0; $i < count($_POST['new_tembusan']); $i++){
                            $modelNewTembusan= new PdmTembusan();
                            $modelNewTembusan->id_table = $model->id_p25;
                            $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                            $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                            $modelNewTembusan->kode_table =  GlobalConstMenuComponent::P25;
                            $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];					
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];	        		
                            $modelNewTembusan->id_perkara = $model->id_perkara;
                            $modelNewTembusan->nip = null;
                            $modelNewTembusan->save();
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
                 return $this->redirect(['update', 'id_p25' => $model->id_p25]);
                }else{
       

                      $transaction->rollback();
                       Yii::$app->getSession()->setFlash('danger', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                        'sysMenu' => $sysMenu,   
                    ]);
                    return $this->render('update', [
                'model' => $model,
                'pT7' => $pT7,
                'dasar' => $dasar,
                'pertimbangan' => $pertimbangan,
                'modelSpdp' => $modelSpdp,
                'modelJaksaSaksi' => $modelJaksaSaksi,
                'sysMenu' => $sysMenu        
            ]); 
                }
               
            } catch (Exception $ex) {
                   
               
                 $transaction->rollback();
            }
           
        } else {
               
            return $this->render('update', [
                'model' => $model,
                'pT7' => $pT7,
                'dasar' => $dasar,
                'pertimbangan' => $pertimbangan,
                'modelSpdp' => $modelSpdp,
                'searchJPU' => $searchJPU,
                'dataJPU' => $dataJPU,
                'modelJaksaSaksi' => $modelJaksaSaksi,
                'sysMenu' => $sysMenu,
            ]);
        }
    }


    public function actionCetak($id_p25){
        
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/p25.odt");
        
        $p25 = PdmP25::findOne(['id_p25'=>$id_p25]);
 $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p25 b','a.peg_nik = b.id_penandatangan')
->where ("id_p25='".$id_p25."'")
->one();

        $spdp = PdmSpdp::findOne(['id_perkara' => $p25->id_perkara]);
        
        $pasal = PdmPasal::findOne(['id_perkara'=>$p25->id_perkara]);
        
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kepala', $pangkat->jabatan);
        $odf->setvars('nomor_print', $p25->no_surat);
        

        //perkara
        $sql =" SELECT a.no_pengiriman, a.tgl_terima "
            . " FROM pidum.pdm_berkas a"
            . " WHERE id_perkara='".$p25->id_perkara."'"
            . " LIMIT 1";
        $perkara = $connection->createCommand($sql);
        $listPerkara = $perkara->queryOne();
        $odf->setvars('no_perkara',$listPerkara['no_pengiriman']);  
        $odf->setvars('tgl_perkara', Yii::$app->globalfunc->ViewIndonesianFormat ($listPerkara['tgl_terima']));  

        //Penyidik
        $sql =" SELECT b.nama "
            . " FROM pidum.pdm_spdp a INNER JOIN pidum.ms_penyidik b ON (a.id_penyidik = b.id_penyidik) "
            . " WHERE id_perkara='".$p25->id_perkara."'";
        $penyidik = $connection->createCommand($sql);
        $listPenyidik = $penyidik->queryOne();
        $odf->setVars('penyidik', $listPenyidik['nama']);  


        #list Tersangka
        $dft_tersangka ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.ms_tersangka')
                ->where("id_tersangka='".$p25->id_tersangka."'");
        $data = $query->createCommand();
        $listTersangka = $data->queryAll();  
        foreach($listTersangka as $key){            
            $dft_tersangka .= ucfirst(strtolower($key[nama])).',';
        }
        $dft_tersangka= substr_replace($dft_tersangka,"",-1);
        $odf->setVars('nama', $dft_tersangka); 


        $jaksi = "select a.nama, a.pangkat, a.jabatan, b.peg_nip_baru from pidum.pdm_jaksa_saksi a, kepegawaian.kp_pegawai b where a.nip = b.peg_nip"
                . " and a.code_table = '" . GlobalConstMenuComponent::P25 . "' and a.id_perkara='" . $p25->id_perkara . "' and a.id_table='" . $id_p25. "'";
        $jaksis = $connection->createCommand($jaksi);
        $jaksiss = $jaksis->queryAll();
        $i = 1;
        $dft_jaksi = $odf->setSegment('jaksi');
        foreach ($jaksiss as $key) {
            $dft_jaksi->urut($i);
            $dft_jaksi->nama_pegawai($key['nama']);
            $dft_jaksi->nip_pegawai($key['peg_nip_baru']);
            $dft_jaksi->pangkat_pegawai(preg_replace("/ \/(.*)/", "", $key['pangkat']));
            $dft_jaksi->merge();
            $i++;
        }
        $odf->mergeSegment($dft_jaksi);


        $odf->setVars('dikeluarkan', $p25->dikeluarkan);
        $odf->setvars('pada_tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($p25->tgl_surat));


        //  #penanda tangan
        $sql ="SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_p25 b , kepegawaian.kp_pegawai c "
                . " where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_p25='".$id_p25."'";
        $sqlExec = $connection->createCommand($sql);
        $penandatangan = $sqlExec->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);       
        $odf->setVars('pangkat', preg_replace("/\/ (.*)/", "", $penandatangan['pangkat']));       
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);    


        #tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $p25->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::P25 . "'and id_table = '" . $p25->id_p25 . "'")
                ->orderBy('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($element['no_urut']);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);
        $odf->exportAsAttachedFile('P25.odt');
    }
  
    

    /**
     * Deletes an existing PdmP25 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $id_p25 = $_POST['hapusIndex'];

            $session = new Session();
            $id_perkara = $session->get('id_perkara');

            if($id_p25 === 'all') {
                PdmP25::updateAll(['flag'=>'3'],'id_perkara=:id_perkara',[':id_perkara'=>$id_perkara]);
            } else {
                for($i=0;$i<count($id_p25);$i++) {
                    $model = $this->findModel($id_p25[$i]);
                    $model->flag = '3';
                    $model->update(true);
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
        } catch(Exception $e) {
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

        /*$this->findModel($id)->delete();
        return $this->redirect(['index']);*/
    }

    /**
     * Finds the PdmP25 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP25 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
       // if ((
                $model = PdmP25::findOne(['id_p25'=>$id]);
             //   ) !== null) {
            
       // } 
        return $model;
       // else {
        //    throw new NotFoundHttpException('The requested page does not exist.');
       // }
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
