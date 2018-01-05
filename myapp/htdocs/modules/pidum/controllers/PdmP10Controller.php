<?php

namespace app\modules\pidum\controllers;

use app\models\PdmPasal;
use app\models\PdmTersangka;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmTrxPemrosesan;
use Yii;
use yii\db\Query;
use app\modules\pidum\models\PdmP10;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmP10Search;
use yii\web\Controller;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmSysMenu;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
/**
 * PdmP10Controller implements the CRUD actions for PdmP10 model.
 */
class PdmP10Controller extends Controller
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
     * Lists all PdmP10 models.
     * @return mixed
     */
    public function actionIndex()
    {
	$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P10]);
        $idPerkara = Yii::$app->session->get('id_perkara');

        $searchModel = new PdmP10Search();
        $dataProvider = $searchModel->search($idPerkara, Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmP10 model.
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
     * Creates a new PdmP10 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P10]);
        $session = new Session();
        $id = $session->get('id_perkara');

//        $modelTersangka = $this->findModelTersangka($id);
        $modelTersangka = \app\modules\pidum\models\VwTersangka::findAll(['id_perkara'=>$id]);
        $modelSpdp = $this->findModelSpdp($id);
        $model = new PdmP10();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p10', 'id_p10', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                $model->flag = '1';
                $model->id_perkara = $id;
                $model->id_p10 = $seq['generate_pk'];
                $model->save();

                if ($model->save()) {

                    PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::P10]);
                    if (isset($_POST['new_tembusan'])) {
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan = new PdmTembusan();
                            $modelNewTembusan->id_table = $model->id_p10;
                            $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                            $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                            $modelNewTembusan->kode_table = GlobalConstMenuComponent::P10;
                            $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                            $modelNewTembusan->id_perkara = $model->id_perkara;
                            $modelNewTembusan->nip = null;
                            $modelNewTembusan->save();
                        }
                    }

                    Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::P10);
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
                    return $this->redirect('index');
                } else {
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Ubah',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('index');
                }
            } catch (Exception $e) {
                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'modelTersangka' => $modelTersangka,
                        'id' => $id,
                        'sysMenu' => $sysMenu
            ]);
        }
	
}

    /**
     * Updates an existing PdmP10 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$session= new Session();
        $id_perkara = $session->get('id_perkara');
		
    	$model = $this->findModel($id);
        $modelTersangka = \app\modules\pidum\models\VwTersangka::findAll(['id_perkara'=>$model->id_perkara]);
                
        //$modelTersangka = $this->findModelTersangka($id_perkara);
        $modelSpdp = $this->findModelSpdp($id_perkara);
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$transaction = Yii::$app->db->beginTransaction();
            
			try {
    			PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::P10]);
    			if(isset($_POST['new_tembusan'])){			
    			 for($i = 0; $i < count($_POST['new_tembusan']); $i++){
    				$modelNewTembusan= new PdmTembusan();
    				$seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
    				$modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
    				$modelNewTembusan->kode_table =  GlobalConstMenuComponent::P10;
                    $modelNewTembusan->id_table = $model->id_p10;
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
                return $this->redirect(['update','id'=>$model->id_p10]);
			} catch (Exception $e) {
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
				
			
			// $trxPemroresan = PdmTrxPemrosesan::findOne(['id_perkara' => $id]);
            // $trxPemroresan->id_perkara = $id;
            // $trxPemroresan->id_sys_menu = "13";
            // $trxPemroresan->id_user_login = Yii::$app->user->identity->username;
            // $trxPemroresan->update();
            // return $this->redirect(['update','id'=>$model->id_perkara]);
			//return $this->redirect(\Yii::$app->urlManager->createUrl("pidum/spdp/index"));
			
          } else {
            return $this->render('update', [
                'model' => $model,
                'modelTersangka' => $modelTersangka,
                'modelSpdp' => $modelSpdp,
				'sysMenu' => $sysMenu
            ]);
        }			
    }

	
	public function actionCetak($id){
		
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path'] . "modules/pidum/template/p10.odt");
        $p10 = PdmP10::findOne(['id_p10' => $id]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $p10->id_perkara]);
         $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p10 b','a.peg_nik = b.id_penandatangan')
->where ("id_p10='".$id."'")
->one(); 

        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kepala', $pangkat->jabatan);
        
        $sifat = \app\models\MsSifatSurat::findOne(['id'=>$p10->sifat]);
        $odf->setVars('nomor', $p10->no_surat);
        $odf->setVars('sifat', $sifat->nama);
        $odf->setVars('lampiran', $p10->lampiran);
        $odf->setVars('dikeluarkan', $p10->dikeluarkan);
        $odf->setVars('tanggal_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($p10->tgl_dikeluarkan));
        $odf->setVars('kepada', $p10->kepada);
        $odf->setVars('ahli_dari', $p10->ket_ahli);
        $odf->setVars('di_tempat', $p10->di_kepada);
        
        $berkas = \app\modules\pidum\models\PdmBerkas::findOne(['id_perkara'=>$p10->id_perkara]);
        $odf->setVars('berkas_perkara', $berkas->no_pengiriman);
        $dilakukan = Yii::$app->globalfunc->getListTerdakwa($p10->id_perkara);
        $odf->setVars('dilakukan', $dilakukan);
        #tembusan
        $dft_tembusan = '';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_table='" . $id . "' and kode_table='" . GlobalConstMenuComponent::P10 . "'");
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($element['no_urut']);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);


        #penanda tangan
        $sql = "SELECT ttd.nama,ttd.jabatan,ttd.peg_nip_baru,ttd.pangkat FROM "
             . " pidum.vw_tandatangan ttd inner join pidum.pdm_p10 p10 on (p10.id_penandatangan=ttd.peg_nik) "
             . " where  p10.id_p10='" . $p10->id_p10 . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $odf->setVars('pangkat', $penandatangan['pangkat']);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);


        $odf->exportAsAttachedFile('p10.odf');
    }
    /**
     * Deletes an existing PdmP10 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
		try{
            $id = $_POST['hapusIndex'];
			
			if($id == "all"){
                $session = new Session();
                $id_perkara = $session->get('id_perkara');

                PdmP10::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                    PdmP10::updateAll(['flag' => '3'], "id_p10 = '" . $id[$i] . "'");
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

    /**
     * Finds the PdmP10 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP10 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP10::findOne($id)) !== null) {
            return $model;
        }
    }
	
	protected function findModelTersangka($id)
    {
        if (($model = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
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
