<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
#use app\modules\pdsold\models\PdmB18;
use app\modules\pdsold\models\PdmBerkasTahap1Grid;
use app\modules\pdsold\models\PdmBerkasTahap1GridSearch;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmP16a;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\PdmBarbuk;
use app\modules\pdsold\models\PdmPkTingRef;
use app\modules\pdsold\models\PdmTetapHakim;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\VwGridPrapenuntutanSearch;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\data\SqlDataProvider;

/**
 * PdmB18Controller implements the CRUD actions for PdmB18 model.
 */
class PdmBerkasTahap1GridController extends Controller {

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
     * Lists all PdmB18 models.
     * @return mixed
     */
    public function actionIndex() {
        
        $searchModel = new PdmBerkasTahap1GridSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      /*$query = "SELECT a.id_berkas,a.no_berkas, a.tgl_berkas,a.id_perkara, COALESCE(string_agg(b.nama,'^'),'') as nama_tersangka from pidum.pdm_berkas_tahap1 a 
left join pidum.ms_tersangka_berkas b on a.id_berkas=b.id_berkas
 
group by a.no_berkas,a.tgl_berkas,a.id_berkas
order by a.tgl_berkas";*/
//print_r($query);exit;
      //$jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


    /*$dataProvider = new SqlDataProvider([
      'sql' => $query,
      'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'no_berkas',
              'tgl_berkas',
              'Nama_tersangka',
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);*/
        $model = $dataProvider->getModels();


//         $queryx = "SELECT a.id_perkara,a.no_surat, a.tgl_surat from pidum.pdm_spdp a order by a.tgl_surat";
// //print_r($query);exit;
//       $jmlx = Yii::$app->db->createCommand(" select count(*) from (".$queryx.")a ")->queryScalar();


//     $dataProviderx = new SqlDataProvider([
//       'sql' => $queryx,
//       'totalCount' => (int)$jmlx,
//       'sort' => [
//           'attributes' => [
//               'id_perkara',
//               'no_surat',
//               'tgl_surat',
//          ],
//      ],
//       'pagination' => [
//           'pageSize' => 10,
//       ]
// ]);
//         $models = $dataProviderx->getModels();

        $searchModelx = new VwGridPrapenuntutanSearch();
        $dataProviderx = $searchModelx->searchGridTahap1(Yii::$app->request->queryParams);
        $dataProviderx->pagination->pageSize = '15';




        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchmodel'=> $searchModel,
            'dataProviderx' => $dataProviderx,
            'searchmodelx'=> $searchModelx,
        ]);
    }

    /**
     * Displays a single PdmB18 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmB18 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmB18();
        $session = new Session();
        $id = $session->get('id_perkara');
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B18]);
        $modelSpdp = PdmSpdp::findOne($id);
        $model->wilayah = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama;
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $modelP16A = PdmP16a::find()->where(['id_perkara' => $id])->orderBy('tgl_dikeluarkan desc')->one();
        $modeljaksi = PdmJaksaSaksi::find()->where(['id_perkara' => $id, 'code_table' => GlobalConstMenuComponent::P16A, 'id_table' => $modelP16A->id_p16a])->orderBy('no_urut')->All();
        $model->dikeluarkan = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_lokinst;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b18', 'id_b18', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_perkara = $id;
                $model->id_b18 = $seq['generate_pk'];
                $model->save();
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B18);
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
                        $modeljaksi2 = new PdmJaksaSaksi();
                        $modeljaksi2->id_jpp = $seqjpp['generate_pk'];
                        $modeljaksi2->id_perkara = $model->id_perkara;
                        $modeljaksi2->code_table = GlobalConstMenuComponent::B18;
                        $modeljaksi2->id_table = $model->id_b18;
                        $modeljaksi2->flag = '1';
                        $modeljaksi2->nama = $data[0]['peg_nama'];
                        $modeljaksi2->nip = $data[0]['peg_nip'];
                        $modeljaksi2->peg_nip_baru = $data[0]['peg_nip_baru'];
                        $modeljaksi2->jabatan = $data[0]['jabatan'];
                        $modeljaksi2->pangkat = $data[0]['pangkat'];
                        $modeljaksi2->no_urut = $no_urut[$count];
                        $modeljaksi2->save();
                        $count++;
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
                return $this->redirect(['update', 'id' => $model->id_b18]);
            } catch (Exception $ex) {
                $transaction->rollback();
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
                return $this->redirect('create');
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'modeljaksi' => $modeljaksi,
            ]);
        }
    }

    /**
     * Updates an existing PdmB18 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B18]);
        $modelSpdp = PdmSpdp::findOne($id);
        $model->wilayah = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama;
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $modeljaksi = PdmJaksaSaksi::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::B18, 'id_table' => $model->id_b18]);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->update();
                $modeljaksi = PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::B18, 'id_table' => $model->id_b18]);
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
                        $modeljaksi2 = new PdmJaksaSaksi();
                        $modeljaksi2->id_jpp = $seqjpp['generate_pk'];
                        $modeljaksi2->id_perkara = $model->id_perkara;
                        $modeljaksi2->code_table = GlobalConstMenuComponent::B18;
                        $modeljaksi2->id_table = $model->id_b18;
                        $modeljaksi2->flag = '1';
                        $modeljaksi2->nama = $data[0]['peg_nama'];
                        $modeljaksi2->nip = $data[0]['peg_nip'];
                        $modeljaksi2->peg_nip_baru = $data[0]['peg_nip_baru'];
                        $modeljaksi2->jabatan = $data[0]['jabatan'];
                        $modeljaksi2->pangkat = $data[0]['pangkat'];
                        $modeljaksi2->no_urut = $no_urut[$count];
                        $modeljaksi2->save();
                        $count++;
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
                return $this->redirect(['update', 'id' => $model->id_b18]);
            } catch (Exception $ex) {
                $transaction->rollback();
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
                return $this->redirect(['update', 'id' => $model->id_b18]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'modeljaksi' => $modeljaksi,
            ]);
        }
    }

    /**
     * Deletes an existing PdmB18 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id); $i++) {
            $model = PdmB18::findOne(['id_b18' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmB18 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB18 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*protected function findModel($id) {
        if (($model = PdmB18::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }*/

    public function actionCetak($id) {
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/b18.odt");
   		$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p52 b','a.peg_nik = b.id_penandatangan')
->where ("id_p52='".$id."'")
->one();

        $b18 = Pdmb18::findOne($id);
        $spdp = PdmSpdp::findOne(['id_perkara' => $b18->id_perkara]);
        $barbuk = PdmBarbuk::findOne(['id_perkara'=>$b18->id_perkara]);
        $THakim = PdmTetapHakim::findOne(['id_perkara'=>$b18->id_perkara]);
        $pidana = PdmPkTingRef::findOne(['id'=>$spdp->id_pk_ting_ref]);
        

        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kepala', $pangkat->jabatan);
        $odf->setVars('nomor', $b18->no_surat);
        $odf->setVars('berupa',$barbuk->nama);
        $odf->setVars('tgl', Yii::$app->globalfunc->ViewIndonesianFormat ($THakim->tgl_surat));
        $odf->setVars('nomor', $THakim->no_surat);
        $odf->setVars('pidana', $pidana->nama);
  
        
          $odf->setVars('dikeluarkan', $b18->dikeluarkan);
          $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($b18->tgl_dikeluarkan));


                #penanda tangan
                $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                        . " pidum.pdm_penandatangan a, pidum.pdm_b18 b , kepegawaian.kp_pegawai c "
                        . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='" . $b18->id_perkara . "'";
                $SqlExec = $connection->createCommand($sql);
                $penandatangan = $SqlExec->queryOne();
                $odf->setVars('nama_penandatangan', $penandatangan['nama']);
                $odf->setVars('pangkat', $penandatangan['pangkat']);
                $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);
                             
#JaksaSaksi
		$query = new Query;
                $query->select('pegawai.peg_nip_baru,peg_nama,pangkat,jabatan')
                ->from('pidum.pdm_jaksa_saksi jaksa_saksi, kepegawaian.kp_pegawai pegawai')
                ->where(" peg_nik=nip and id_perkara='".$b18->id_perkara."' AND code_table='".GlobalConstMenuComponent::B18."' AND id_table ='".$b18->id_b18."'");
                $dt_jaksaPeneliti = $query->createCommand();
                $listjaksaPeneliti = $dt_jaksaPeneliti->queryAll();
                $dft_jaksaPeneliti = $odf->setSegment('jaksaPeneliti');
		$i=1;
        foreach($listjaksaPeneliti as $element){
                $dft_jaksaPeneliti->urutan($i);
                $dft_jaksaPeneliti->nama_pegawai($element['peg_nama']);
                $dft_jaksaPeneliti->pangkat( $element['pangkat'].' / '.$element['peg_nip_baru']);
                $dft_jaksaPeneliti->jabatan($element['jabatan']);
                $dft_jaksaPeneliti->merge();
		$i++;
        }
        $odf->mergeSegment($dft_jaksaPeneliti);  
        
     #list Tersangka
        $dft_tersangka ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.ms_tersangka')
                ->where("id_perkara='".$b18->id_perkara."'");
        $data = $query->createCommand();
        $listTersangka = $data->queryAll();  
        foreach($listTersangka as $key){			
            $dft_tersangka .= $key[nama].',';
        }
        $odf->setVars('terdakwa', $dft_tersangka);  
		
        $odf->exportAsAttachedFile();
    }
protected function findModel($id)
    {
        if (($model = PdmSpdp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

 public function actionCreateBerkasTahap1($id){
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $id);
        $model = $this->findModel($id);
        $session->set('nomor_perkara', $model->no_surat);
        $session->set('tgl_perkara', date('d-m-Y', strtotime($model->tgl_surat)));
        $session->set('tgl_terima', date('d-m-Y', strtotime($model->tgl_terima)));
        return $this->redirect(['pdm-berkas-tahap1/create']);

 }

  public function actionUpdateBerkasTahap1($id,$id_berkas){
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $id);
        $session->set('perilaku_berkas', $id_berkas);
        $model = $this->findModel($id);
        $session->set('nomor_perkara', $model->no_surat);
        $session->set('tgl_perkara', date('d-m-Y', strtotime($model->tgl_surat)));
        $session->set('tgl_terima', date('d-m-Y', strtotime($model->tgl_terima)));
//        echo $id_berkas;exit();
        return $this->redirect(['pdm-berkas-tahap1/update','id' => $id_berkas ]);

 }  

}
