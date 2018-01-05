<?php

namespace app\modules\pdsold\controllers;
use Jaspersoft\Client\Client;
use Yii;
use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmBa2;
use app\modules\pdsold\models\PdmBerkas;
use app\modules\pdsold\models\PdmMsSaksiAhli;
use app\modules\pdsold\models\PdmP11;
use app\modules\pdsold\models\PdmP11Search;
use app\modules\pdsold\models\PdmPkTingRef;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmP17Controller implements the CRUD actions for PdmP17 model.
 */
class PdmP11Controller extends Controller
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
     * Lists all PdmP17 models.
     * @return mixed
     */
    public function actionIndex()
    {   $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P11]);
        $id_perkara = Yii::$app->session->get('id_perkara');        
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P11]);
        $searchModel = new PdmP11Search();
        $dataProvider = $searchModel->search($id_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
            'sysMenu' => $sysMenu,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmP11 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP11 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $id_perkara = Yii::$app->session->get('id_perkara');
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P11]);
		
        $model = new PdmP11();
		//print_r($model);exit;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $model->attributes = Yii::$app->request->post('PdmP11');
               
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p11', 'id_p11', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                $model->id_perkara = $id_perkara;
                $model->id_p11 = $seq['generate_pk'];

                $model->save();
                        

                $transaction->commit();

                if($model->save()){
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
                    return $this->redirect('index');
                }else{
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

            }catch (Exception $e) {
                $transaction->rollback();
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Updates an existing PidumPdmSpdp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P11]);
        $session = new Session();

        $id = $session->get('id_perkara');
        $model = $this->findModel($id);
        if($model == null){
            $model = new PdmP11();
        }

       if ($model->load(Yii::$app->request->post())) {
            $id_p11 = PdmP11::findOne(['id_p11' => $id]);
            
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p11', 'id_P11', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

            if($model->id_p11 != null){
                $model->flag = '2';
                $model->update();
            }else{
                //$model->id_perkara = $id;
                $model->id_p11 = $id_p11->id_p11;
                $model->id_p11 = $seq['generate_pk'];
                $model->save();
            }

             if($model->save()){
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
                //return $this->redirect('index');
                return $this->redirect(['update','id'=>$model->id_p11]);
            }
            
			
        } else {
            return $this->render('update', [
                'model' => $model,
                'sysMenu' => $sysMenu,
                'modelTersangka' => $modelTersangka,
                'modelSpdp' => $modelSpdp,
                'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PidumPdmSpdp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate2($id)
    {
       $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P11]);
       $model = PdmP11::findOne(['id_p11' => $id]);
       $modelTersangka = \app\modules\pidum\models\VwSaksiahliba2::findAll(['id_perkara'=>$model->id_perkara]);
       
       
       if ($model->load(Yii::$app->request->post())) {
            $model->flag = '2';
            $model->update();
            
             
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
        return $this->redirect(['update2','id'=>$model->id_p11]);

            
			
        } else {
            return $this->render('update', [
                'model' => $model,
                'sysMenu' => $sysMenu,
                'modelTersangka' => $modelTersangka,
                'modelSpdp' => $modelSpdp,
                'sysMenu' => $sysMenu,
            ]);
        }
    }
    public function actionCetak($id){
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/p11.odt");

        $p11 = PdmP11::findOne(['id_p11' => $id]);

        $idd = $p11->id_perkara;
        $spdp = PdmSpdp::findOne(['id_perkara' => $idd]);
        $berkas = PdmBerkas::findOne(['id_perkara' => $idd]);
        $ba2 = PdmBa2::find()->select('id_ms_saksi_ahli')->where(['id_perkara' => $idd])->andWhere("flag <> '3'")->all();
     $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p11 b','a.peg_nik = b.id_penandatangan')
->where ("id_p11='".$id."'")
->one(); 
        #header
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kepala', $pangkat->jabatan);
        $odf->setVars('kepala_lower', ucwords(strtolower(Yii::$app->globalfunc->setKepalaReport($spdp->wilayah_kerja))));

        $odf->setVars('nomor', $p11->no_surat); 
        $odf->setVars('sifat', MsSifatSurat::findOne($p11->sifat)->nama); 
        $odf->setVars('lampiran', $p11->lampiran); 
        $odf->setVars('kepada', $p11->kepada); 
        $odf->setVars('tempat', $p11->di_kepada); 
        $odf->setVars('dikeluarkan', ucfirst(strtolower($p11->dikeluarkan)));
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($p11->tgl_dikeluarkan));

        $odf->setVars('nomor_berkas', $berkas->no_pengiriman);
        $odf->setVars('tanggal_berkas', Yii::$app->globalfunc->ViewIndonesianFormat($berkas->tgl_pengiriman));

        $odf->setVars('tersangka', Yii::$app->globalfunc->getDaftarTerdakwa($idd));

        $odf->setVars('pidana', PdmPkTingRef::findOne($spdp->id_pk_ting_ref)->nama); 
          
        #nama saksi
        $id_saksi = '';
        foreach ($ba2 as $value) {
            $id_saksi .= "'" . $value->id_ms_saksi_ahli . "',";
        }
        $id_saksi = preg_replace("/,$/", "", $id_saksi);
        $segmentSaksi = $odf->setSegment('saksi');
        if(!empty($id_saksi)){
            $saksi = PdmMsSaksiAhli::find()->where('id_saksi_ahli in (' . $id_saksi . ')')->all();
            $no=1;
            foreach($saksi as $row){
                    $segmentSaksi->no_urut($no);
                    $segmentSaksi->nm_saksi($row->nama);
                    $segmentSaksi->alamat($row->alamat);
                    $segmentSaksi->keterangan('-');
                    $segmentSaksi->merge();

                    $no++;
            }
        }else{
            $segmentSaksi->no_urut_saksi('-');
            $segmentSaksi->nama_saksi('-');
            $segmentSaksi->tgl_lahir_saksi('-');
            $segmentSaksi->tempat_lahir_saksi('-');
            $segmentSaksi->alamat_saksi('-');
            $segmentSaksi->agama_saksi('-');
            $segmentSaksi->pekerjaan_saksi('-');
            $segmentSaksi->ket_saksi('-');
            $segmentSaksi->merge();
        }
        $odf->mergeSegment($segmentSaksi);
      
        #penanda tangan
        $sql ="SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_p16 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='".$idd."'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);       
        $odf->setVars('pangkat', preg_replace("/\/ (.*)/", "", $penandatangan['pangkat']));
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);       
        
      
        $odf->exportAsAttachedFile('p11.odt');
    }

    /**
     * Deletes an existing PdmP11 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id_p11 = $_POST['hapusp11'];
		if($id_p11[0]=='1')
		{
			PdmP11::updateAll(['flag' => 3]);
		}else{
			for($i=0;$i<count($id_p11);$i++){
				$p11 =$this->findModelP11($id_p11[$i]);
				$p11->flag = '3';
				$p11->update();
			}
		}
		
		
        
        /*$spdp = $this->findModel($id);
        $spdp->flag = '3';
        $spdp->update();*/

        return $this->redirect(['pdm-p11/index']);
    }

    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the PdmP11 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP11 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP11::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        }/* else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }
    protected function findModelP11($id)
    {
        if (($model = PdmP11::findOne(['id_p11' => $id])) !== null) {
            return $model;
        }/* else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }
    protected function findModelTersangka($id)
    {
        if (($model = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelBa2($id)
    {
        if (($model = PdmBa2::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSaksiAhli($id)
    {
        if (($model = PdmMsSaksiAhli::findAll(['id_saksi_ahli' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
