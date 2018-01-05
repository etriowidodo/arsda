<?php

namespace app\modules\pdsold\controllers;


use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmP48;
use app\modules\pdsold\models\PdmTembusanP48;
use app\modules\pdsold\models\PdmRp11;
use app\modules\pdsold\models\PdmPutusanPnTerdakwa;
use app\modules\pdsold\models\PdmP48Search;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmTahapDuaSearch;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmUuPasalTahap2;
use app\modules\pdsold\models\PdmJaksaP16a;
use Jaspersoft\Client\Client;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\web\Response;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\PdmBarangsitaanP48;
use app\modules\pdsold\models\PdmJaksaSaksi;

/**
 * PdmP48Controller implements the CRUD actions for PdmP48 model.
 */
class PdmRp13Controller extends Controller
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
     * Lists all PdmP48 models.
     * @return mixed
     */
    public function actionIndex(){
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->destroySession('no_register_perkara');
        $session->destroySession('no_akta');
        $session->destroySession('no_reg_tahanan');
        
        $searchModel = new PdmP48Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::RP13 ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,

        ]);
    }

    /**
     * Displays a single PdmP48 model.
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
     * Creates a new PdmP48 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = new session();
        //$no_register_perkara = $session->get('no_register_perkara');
        //$no_reg_tahanan = $session->get('no_reg_tahanan');

        $model = new PdmP48();
        $searchRegister = new PdmTahapDuaSearch();
        $dataRegister = $searchRegister->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P48 ]);


        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try{
                //$model->no_register_perkara = $_POST['PdmP48']['no_register_perkara'];
                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];
                $model->nama_ttd    = $_POST['hdn_nama_penandatangan'];

                $id_berkas = PdmTahapDua::findOne(['no_register_perkara'=>$_POST['PdmP48']['no_register_perkara']])->id_berkas;
                $id_perkara = PdmBerkasTahap1::findOne(['id_berkas'=>$id_berkas])->id_perkara;
                $model->id_perkara = $id_perkara;

                if(!$model->save()){
                    var_dump($model->getErrors());echo 'header';exit;
                }else{
                    for ($i=0; $i < count($_POST['new_no_urut']); $i++) { 
                        $modelTembusan = new PdmTembusanP48();
                        $modelTembusan->no_register_perkara = $_POST['PdmP48']['no_register_perkara'];
                        $modelTembusan->no_surat = $_POST['PdmP48']['no_surat'];
                        $modelTembusan->no_urut = $i+1;
                        $modelTembusan->tembusan = $_POST['new_tembusan'][$i];
                        if(!$modelTembusan->save()){
                                var_dump($modelTembusan->getErrors());exit;
                               }
                    }
                    
                    //echo '<pre>';print_r($model);exit;

                    $transaction->commit();
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
                    return $this->redirect(['update','id_p48'=>$_POST['PdmP48']['no_surat']]);
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

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'searchRegister' => $searchRegister,
                'dataRegister' => $dataRegister,
                'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Updates an existing PdmP48 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_p48)
    {
            
	    $model = $this->findModel($id_p48);
       //echo '<pre>';print_r($model);exit;
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P48 ]);
		$session = new Session();
        $session->destroySession('id_perkara');
        $session->destroySession('no_register_perkara');
        $session->destroySession('no_akta');
        $session->destroySession('no_reg_tahanan');
        $session->destroySession('no_eksekusi');

        //$id_perkara = PdmRp11::findOne(['no_akta'=>$model->no_akta])->id_perkara;
        //echo '<pre>';print_r($id_perkara);exit;
        $session->set('id_perkara', $model->id_perkara);
        $session->set('no_register_perkara', $model->no_register_perkara);
        $session->set('no_akta', $model->no_akta);
        $session->set('no_reg_tahanan',$model->no_reg_tahanan);
        $session->set('no_eksekusi',$id_p48);
		
		$kd_wilayah = PdmSpdp::findOne($id)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;

		$searchRegister = new PdmTahapDuaSearch();
        $dataRegister = $searchRegister->search(Yii::$app->request->queryParams);
        //$model = $this->findModel($id);
		
		
		
		
		//$modelJpu = PdmJaksaSaksi::find()->where(['id_perkara' => $id, 'code_table' => GlobalConstMenuComponent::P48, 'id_table' => $model->id_p48])->orderBy('no_urut asc')->all();

        if ($model->load(Yii::$app->request->post()) ) {
		
			$transaction = Yii::$app->db->beginTransaction();

            try {
			    $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];
                $model->nama_ttd    = $_POST['hdn_nama_penandatangan'];

                $id_berkas = PdmTahapDua::findOne(['no_register_perkara'=>$_POST['PdmP48']['no_register_perkara']])->id_berkas;
                $id_perkara = PdmBerkasTahap1::findOne(['id_berkas'=>$id_berkas])->id_perkara;
                $model->id_perkara = $id_perkara;
				if(!$model->update()){
                    var_dump($model->getErrors());echo 'header';exit;
                }

			     PdmTembusanP48::deleteAll(['no_surat' => $model->no_surat]);
    			if(isset($_POST['new_tembusan'])){
            		for($i = 0; $i < count($_POST['new_tembusan']); $i++){
    	        		$modelTembusan = new PdmTembusanP48();
                        $modelTembusan->no_register_perkara = $_POST['PdmP48']['no_register_perkara'];
                        $modelTembusan->no_surat = $_POST['PdmP48']['no_surat'];
                        $modelTembusan->no_urut = $i+1;
                        $modelTembusan->tembusan = $_POST['new_tembusan'][$i];
                        if(!$modelTembusan->save()){
                                var_dump($modelTembusan->getErrors());exit;
                               }
            		}
            	}
			
			
			    
	
			
			$transaction->commit();
			 Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
            return $this->redirect(['update','id_p48'=>$_POST['PdmP48']['no_surat']]);
			}catch (Exception $e) {
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
        } else {
			
            return $this->render('update', [
                'model' => $model,
				'sysMenu' => $sysMenu,
				'wilayah' => $wilayah,
                'searchRegister' => $searchRegister,
                'dataRegister' => $dataRegister,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP48 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
           $arr= array();
           $id_tahap = $_POST['hapusIndex'][0];
                if($id_tahap=='all'){
                        $id_tahapx=PdmP48::find()->select("no_surat")->asArray()->all();
                        foreach ($id_tahapx as $key => $value) {
                            $arr[] = $value['no_surat'];
                        }
                        $id_tahap=$arr;
                }else{
                   $id_tahap = $_POST['hapusIndex'];
                }


           $count = 0;
              foreach($id_tahap AS $key_delete => $delete){
                try{
                       PdmP48::deleteAll(['no_surat' => $delete]);
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

    public function actionGetTerdakwa()
    {
        $no_register_perkara = $_POST['no_register_perkara'];
       /*$terdakwa = PdmPutusanPnTerdakwa::find()->select('no_reg_tahanan, nama')->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();*/
        $sql = "SELECT distinct a.no_reg_tahanan, b.nama 
                from pidum.pdm_putusan_pn_terdakwa a 
                left join pidum.vw_terdakwat2 b on a.no_register_perkara=b.no_register_perkara and a.no_reg_tahanan=b.no_reg_tahanan
                where a.no_register_perkara ='$no_register_perkara'";
        $query= \Yii::$app->db->createCommand($sql);
        $terdakwa = $query->queryAll();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $terdakwa;
    }

    public function actionGetPutusan(){
        $no_register_perkara = $_POST['no_register_perkara'];
        $no_reg_tahanan = $_POST['no_reg_tahanan'];
        $sql = "SELECT a.no_reg_tahanan,a.no_register_perkara,a.no_surat, b.no_akta, a.id_ms_rentut, b.tgl_dikeluarkan as tgl_hidden, to_char(
        (b .tgl_dikeluarkan) :: TIMESTAMP WITH TIME ZONE,
        'DD-MM-YYYY' :: TEXT
        ) AS tgl_show,c.nama
                from pidum.pdm_putusan_pn_terdakwa a 
                left join pidum.pdm_putusan_pn b on a.no_register_perkara=b.no_register_perkara and a.no_surat=b.no_surat
                left join pidum.vw_terdakwat2 c on a.no_register_perkara=c.no_register_perkara and a.no_reg_tahanan=c.no_reg_tahanan
                where a.no_register_perkara = '$no_register_perkara' and a.no_reg_tahanan='$no_reg_tahanan'
                group by a.no_reg_tahanan,a.no_register_perkara,a.no_surat, b.tgl_dikeluarkan,c.nama, b.no_akta, a.id_ms_rentut
                order by b.tgl_dikeluarkan desc limit 1";
        //return $sql;exit;
        $query= \Yii::$app->db->createCommand($sql);
        $putusan = $query->queryAll();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $putusan;
    }

    /**
     * Finds the PdmP48 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP48 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_p48)
    {
        if (($model = PdmP48::findOne(['no_surat'=>$id_p48])) !== null) {
            return $model;
        }
    }
	
	public function actionCetak($id)
    {
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');

        $model = $this->findModel($id);
        $spdp = PdmSpdp::findOne($id_perkara);
        $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan]);
        $putusan = PdmPutusanPnTerdakwa::findOne(['no_surat'=>trim($model->no_putusan)]);
        $jaksa = PdmJaksaP16a::findAll(['no_register_perkara'=>$no_register_perkara]);
        //echo '<pre>';print_r(count($jaksa));exit;
        $undang = json_decode($putusan->undang_undang);
        $listPasal = "";
        $jum = count($undang->undang);
        //echo '<pre>';print_r($jum);exit;
        foreach ($undang->undang as $key => $value) {
            $pasal = PdmUuPasalTahap2::find()->select('undang, pasal')->where(['id_pasal'=>$value])->one();
            
            if($jum==1 || $key==0){
                $listPasal .= $pasal->undang.' '.$pasal->pasal;
            }else if($jum==2 && $key == 1){
                $listPasal .= ' dan '.$pasal->undang.' '.$pasal->pasal;
            }else{
                $listPasal .= ', '.$pasal->undang.' '.$pasal->pasal;
            }
        }
        $listTembusan = PdmTembusanP48::findAll(['no_surat'=>$model->no_surat]);

        return $this->render('cetak', ['model'=>$model,'spdp'=>$spdp,'tersangka'=>$tersangka, 'listPasal'=>$listPasal, 'putusan'=>$putusan ,'listTembusan'=>$listTembusan, 'jaksa'=>$jaksa]);
        //$PdmPutusan = PdmPutusanPn::findOne(['no_akta'=>$no_akta]);
        //echo '<pre>';print_r($PdmPutusan);exit;
        //echo '<pre>';print_r($spdp);exit;
		/*$odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/p48.odt");
		
		$connection = \Yii::$app->db;
		$sql =" select a.* ,b.nama, c.peg_nip_baru , b.pangkat "
				. " from pidum.pdm_p48 a "
				. " inner join (select peg_nik,nama,pangkat,jabatan from pidum.pdm_penandatangan group by peg_nik,nama,pangkat,jabatan)b  "
				. " on a.id_penandatangan = b.peg_nik "
				. " inner join kepegawaian.kp_pegawai c on b.peg_nik = c.peg_nik "
				. " where a.id_perkara = '$id' ";
        $model = $connection->createCommand($sql);
        $data = $model->queryOne();
		 $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p48 b','a.peg_nik = b.id_penandatangan')
->where ("id_p48='".$id."'")
->one(); 
		$odf->setVars('no_print', ucfirst(strtolower($data['no_surat'])));  
		$odf->setVars('Kejaksaan', ucfirst(Yii::$app->globalfunc->getSatker()->inst_nama));  
		$odf->setVars('kepala', $pangkat->jabatan);  
		$odf->setVars('nama_penandatangan', ucfirst(strtolower($data['nama'])));  
		$odf->setVars('pangkat', ucfirst(strtolower($data['pangkat'])));  
		$odf->setVars('nip_penandatangan', ucfirst(strtolower($data['peg_nip_baru']))); 
		$odf->setVars('dikeluarkan', ucfirst(strtolower($data['dikeluarkan']))); 
		$odf->setVars('pd_tgl', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_dikeluarkan'])); 
		$odf->setVars('nomor', ucfirst(strtolower($data['no_surat']))); 
		$odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_putusan'])); 

		#tembusan
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='".$id."' AND kode_table='".GlobalConstMenuComponent::P48."'")
				->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach($listTembusan as $element){
                $dft_tembusan->urutan_tembusan($element['no_urut']);
                $dft_tembusan->nama_tembusan($element['tembusan']);
                $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);
		
		#jpu
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_jaksa_saksi')
                ->where("id_perkara='".$id."' AND code_table='".GlobalConstMenuComponent::P48."'")
				->orderby('no_urut');
        $dt_jpu = $query->createCommand();
        $listJpu = $dt_jpu->queryAll();
        $dft_jpu = $odf->setSegment('jpu');
        foreach($listJpu as $element){
                $dft_jpu->urutan_jpu($element['no_urut']);
                $dft_jpu->nama_jpu($element['nama']);
                $dft_jpu->pangkat_jpu($element['pangkat']);
                $dft_jpu->jabatan_jpu($element['jabatan']);
                $dft_jpu->merge();
        }
        $odf->mergeSegment($dft_jpu);
		
		$odf->exportAsAttachedFile();*/
	}
}
