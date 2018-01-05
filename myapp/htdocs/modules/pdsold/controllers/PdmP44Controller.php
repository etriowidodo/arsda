<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmP44;
use app\modules\pdsold\models\PdmP44Search;
use yii\web\Controller;
use yii\web\Session;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmPutusanHakim44;
use app\modules\pdsold\models\PdmVwP44;
use app\modules\pdsold\models\PdmVwP44Search;
use yii\db\Query;
/**
 * PdmP44Controller implements the CRUD actions for PdmP44 model.
 */
class PdmP44Controller extends Controller
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
     * Lists all PdmP44 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        /*$searchModel = new PdmVwP44Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P44]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);*/
        return $this->redirect(['cetak','id'=>$no_register_perkara]);
    }

    /**
     * Displays a single PdmP44 model.
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
     * Creates a new PdmP44 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	
	 public function actionShowPutusantersangka()
    {
       
        $id_perkara = \Yii::$app->session->get('id_perkara');
		/*$queryTersangka = new Query();
        $modelPutusan = $queryTersangka->select('a.*')->from('pidum.pdm_putusan_hakim44 a')
            ->where('a.id_tersangka=:id_tersangka AND flag<>\'3\'', [':id_tersangka' => $_GET['id_tersangka']])->all();
        */
		$modelPutusan = PdmPutusanHakim44::findOne(['id_perkara' => $id_perkara],['id_tersangka' => $id_tersangka]);
		if($modelPutusan == null){
			$modelPutusan =  new PdmPutusanHakim44();
			//echo $_GET['id_tersangka'];exit;
		}
		$rentut = array("1"=>"Pidana Mati","2"=>"Pidana Seumur Hidup","3"=>"Pidana Penjara","4"=>"Pidana Kurungan-Denda","5"=>"Bebas");
		$sikap_jaksa = array(array("id"=>"1","nama"=>"Menerima"),array("id"=>"2","nama"=>"Banding"),array("id"=>"3","nama"=>"Kasasi"));
		$sikap_tersangka = array(array("id"=>"1","nama"=>"Menerima"),array("id"=>"2","nama"=>"Banding"));
		$pengawasan = array("1"=>"Dikembalikan Kepada Orang Tua","2"=>"Diserahkan Kepada Negara","3"=>"Diserahkan Kepada Departemen Sosial","4"=>"Diserahkan kepada organisasi Sosial Kemasyarakatan");
		
		if ($modelPutusan->load(Yii::$app->request->post()) ) {
			$modelPutusan->id_perkara = $id_perkara;
			$modelPutusan->id_tersangka = $_GET['id_tersangka'];
            if(!$modelPutusan->save()){
				var_dump($modelPutusan->getErrors());exit;
			}else{
				return $this->redirect(['create']);
			}
        } else {
        return $this->renderAjax('_popPutusantersangka', [
            'modelPutusan' => $modelPutusan,
            'rentut' => $rentut,
            'pengawasan' => $pengawasan,
            'sikap_jaksa' => $sikap_jaksa,
            'sikap_tersangka' => $sikap_tersangka,
			'id_tersangka'=>$_GET['id_tersangka'],
        ]);
		}
    }
	
    public function actionCreate()
    {
        
		
		$id = \Yii::$app->session->get('id_perkara');
		
		$model = PdmP44::findOne(["id_perkara"=>$id]);
        if($model == null){
			$model = new PdmP44();
		}
		
        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);
		
		$searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
		
		$kd_wilayah = PdmSpdp::findOne($id)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
		
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P44 ]);
		
		/*$queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            ->where('a.id_perkara=:id_perkara AND flag<>\'3\'', [':id_perkara' => $id])->all();
			*/
			$connection = \Yii::$app->db;
		
		$sql = " select a.id_tersangka as tersangka_id,a.nama,b.*,coalesce(c.pasal,'-') as pasal
from
pidum.ms_tersangka a
left join 
pidum.pdm_putusan_hakim44 b on
a.id_perkara = b.id_perkara and a.id_tersangka = b.id_tersangka
left join (
SELECT id_perkara,id_tersangka, 
    STRING_AGG(pasal, '<br/>') As pasal
    from pidum.pdm_pasal_dakwaan
    group by id_perkara,id_tersangka
)c on a.id_perkara = c.id_perkara and a.id_tersangka = c.id_tersangka
where a.id_perkara='".$id."' ";

		$cmd_tersangka = $connection->createCommand($sql);
        $listTersangka = $cmd_tersangka->queryAll();
		
		$modeljaksasaksi = PdmJaksaSaksi::findOne(['id_perkara' => $id, 'id_table' => $model->id_p44, 'code_table' => GlobalConstMenuComponent::P44]);
		
		$modeljaksapenerima = PdmJaksaPenerima::findOne(['id_perkara' => $id, 'id_table' => $model->id_p44, 'code_table' => GlobalConstMenuComponent::P44]);


        if ($model->load(Yii::$app->request->post()) ) {
				
            
             $transaction = Yii::$app->db->beginTransaction();

            try {
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p44', 'id_p44', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

			if($model->id_perkara != null){
				$model->update();
			}else {
				$model->id_perkara = $id;
				$model->id_p44 = $seq['generate_pk'];
				$model->save();
				
				Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::P44);    
			}
			
				
				$jaksa = $_POST['PdmJaksaSaksi'];
        	
        	if(!empty($jaksa['nama'])){
				
				PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=>GlobalConstMenuComponent::P44, 'id_table'=>$model->id_p44]);
        		$modeljaksi1 = new PdmJaksaSaksi();
        		$seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
        	
        		$modeljaksi1->id_jpp = $seqjpp['generate_pk'];
        		$modeljaksi1->id_perkara = $model->id_perkara;
        		$modeljaksi1->code_table = GlobalConstMenuComponent::P44;
        		$modeljaksi1->id_table = $model->id_p44;
        		$modeljaksi1->flag = '1';
        		$modeljaksi1->nama = $jaksa['nama'];
        		$modeljaksi1->nip = $jaksa['nip'];
        		$modeljaksi1->jabatan = $jaksa['jabatan'];
        		$modeljaksi1->pangkat = $jaksa['pangkat'];
        		if(!$modeljaksi1->save()){
					echo "Error Jaksa Saksi";var_dump($modeljaksi1->getErrors());exit;
				}
				
        	}
			
			$jaksa2 = $_POST['PdmJaksaPenerima'];
        	
        	if(!empty($jaksa2['nama'])){
				PdmJaksaPenerima::deleteAll(['id_perkara' => $model->id_perkara,'code_table'=>GlobalConstMenuComponent::P44, 'id_table'=>$model->id_p44]);
        		$modeljaksi2 = new PdmJaksaPenerima();
        		$seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
        	
        		$modeljaksi2->id_jpp = $seqjpp['generate_pk'];
        		$modeljaksi2->id_perkara = $model->id_perkara;
        		$modeljaksi2->code_table = GlobalConstMenuComponent::P44;
        		$modeljaksi2->id_table = $model->id_p44;
        		$modeljaksi2->flag = '1';
        		$modeljaksi2->nama = $jaksa2['nama'];
        		$modeljaksi2->nip = $jaksa2['nip'];
        		$modeljaksi2->jabatan = $jaksa2['jabatan'];
        		$modeljaksi2->pangkat = $jaksa2['pangkat'];
        		if(!$modeljaksi2->save()){
					echo "Error Jaksa Penerima";var_dump($modeljaksi2->getErrors());exit;
				}
        	}
				
			
				$transaction->commit();
				
				$modeljaksasaksi = PdmJaksaSaksi::findOne(['id_perkara' => $id, 'id_table' => $model->id_p44, 'code_table' => GlobalConstMenuComponent::P44]);
		
		$modeljaksapenerima = PdmJaksaPenerima::findOne(['id_perkara' => $id, 'id_table' => $model->id_p44, 'code_table' => GlobalConstMenuComponent::P44]);

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
            return $this->render('create', [
                'model' => $model,
                'modelSpdp' => $modelSpdp,
            	'dataJPU' => $dataJPU,
            	'searchJPU' => $searchJPU,
            	'wilayah' => $wilayah,
            	'sysMenu' => $sysMenu,
            	'listTersangka' => $listTersangka,
				'modeljaksasaksi' => $modeljaksasaksi,
            	'modeljaksapenerima' => $modeljaksapenerima,
            ]);
            
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
           return $this->render('create', [
                'model' => $model,
                'modelSpdp' => $modelSpdp,
            	'dataJPU' => $dataJPU,
            	'searchJPU' => $searchJPU,
            	'wilayah' => $wilayah,
            	'sysMenu' => $sysMenu,
            	'listTersangka' => $listTersangka,
				'modeljaksasaksi' => $modeljaksasaksi,
            	'modeljaksapenerima' => $modeljaksapenerima,
            ]);
        }
    }

    /**
     * Updates an existing PdmP44 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
       
		
		$id_perkara = \Yii::$app->session->get('id_perkara');
         $model = PdmP44::findOne(["id_perkara"=>$id_perkara]);
		 
        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
		
		$searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
		
		$kd_wilayah = PdmSpdp::findOne($id_perkara)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
		
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P44 ]);
		
		/*$queryTersangka = new Query();
        $listTersangka = $queryTersangka->select('a.id_tersangka, a.nama')->from('pidum.ms_tersangka a')
            ->where('a.id_perkara=:id_perkara AND flag<>\'3\'', [':id_perkara' => $id])->all();
			*/
			$connection = \Yii::$app->db;
		
		$sql = " select a.id_tersangka,a.nama,b.*
from
pidum.ms_tersangka a
left join 
pidum.pdm_putusan_hakim44 b on
a.id_perkara = b.id_perkara and a.id_tersangka = b.id_tersangka
where a.id_perkara='".$id_perkara."' ";
		$cmd_tersangka = $connection->createCommand($sql);
        $listTersangka = $cmd_tersangka->queryAll();

		$modeljaksasaksi = PdmJaksaSaksi::findOne(['id_perkara' => $id_perkara, 'id_table' => $model->id_p44, 'code_table' => GlobalConstMenuComponent::P44]);
		
		$modeljaksapenerima = PdmJaksaPenerima::findOne(['id_perkara' => $id_perkara, 'id_table' => $model->id_p44, 'code_table' => GlobalConstMenuComponent::P44]);
		

        if ($model->load(Yii::$app->request->post()) ) {
            return $this->redirect(['update']);
        } else {
            return $this->render('update', [
                'model' => $model,
				'modelSpdp' => $modelSpdp,
            	'dataJPU' => $dataJPU,
            	'searchJPU' => $searchJPU,
            	'wilayah' => $wilayah,
            	'sysMenu' => $sysMenu,
            	'listTersangka' => $listTersangka,
            	'modeljaksasaksi' => $modeljaksasaksi,
            	'modeljaksapenerima' => $modeljaksapenerima,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP44 model.
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
     * Finds the PdmP44 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP44 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP44::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
public function actionCetak($id)
    {

		$connection = \Yii::$app->db;
		$sql =" SELECT b.no_register_perkara,  b.nama as tersangka,
                a.undang_undang, COALESCE(a.pidana_badan_tahun,0) as y_badan , coalesce(a.pidana_badan_bulan,0) as m_badan, COALESCE(a.pidana_badan_hari,0) as d_badan,
                COALESCE(a.masa_percobaan_tahun,0) as y_coba , coalesce(a.masa_percobaan_bulan,0) as m_coba, COALESCE(a.masa_percobaan_hari,0) as d_coba,
                COALESCE(a.denda ,0) as denda, COALESCE(a.biaya_perkara,0) as biaya,a.no_surat_p41, a.no_reg_tahanan,


                c.undang_undang as undang_undang_pn, COALESCE(c.pidana_badan_tahun,0) as y_badan_pn , coalesce(c.pidana_badan_bulan,0) as m_badan_pn, COALESCE(c.pidana_badan_hari,0) as d_badan_pn,
                COALESCE(c.masa_percobaan_tahun,0) as y_coba_pn , coalesce(c.masa_percobaan_bulan,0) as m_coba_pn, COALESCE(c.masa_percobaan_hari,0) as d_coba_pn,
                COALESCE(c.denda ,0) as denda_pn, COALESCE(c.biaya_perkara,0) as biaya_pn, c.usuljpu


                FROM pidum.pdm_p41_terdakwa a 
                LEFT JOIN pidum.vw_terdakwat2 b on a.no_register_perkara=b.no_register_perkara and a.no_reg_tahanan=b.no_reg_tahanan
                LEFT JOIN pidum.pdm_putusan_pn_terdakwa c on a.no_register_perkara=c.no_register_perkara and a.no_reg_tahanan=c.no_reg_tahanan
                WHERE a.no_register_perkara='$id' and a.status_rentut=3 
                ORDER BY b.no_urut_tersangka ";
        //echo '<pre>';print_r($sql);exit;
 
 
        $query = $connection->createCommand($sql);
        $tersangka = $query->queryAll();
        //echo '<pre>';print_r($tersangka);exit;
        //echo '<pre>';print_r($tersangka);exit;

        return $this->render('cetak', ['tersangka'=>$tersangka, 'session' =>$_SESSION]);
		/*
		$sql_jpu = " select * from pidum.pdm_jaksa_penerima where id_perkara = '".$id."' and code_table = 'P-44' ";
		
		$model_jpu = $connection->createCommand($sql_jpu);
        $data_jpu = $model_jpu->queryOne();
		
		$odf->setVars('nama_jaksa_pu', ucfirst($data_jpu['nama'])); 
		$odf->setVars('nama_penandatangan', ucfirst($data_jpu['nama'])); 
		$odf->setVars('pangkat', ucfirst($data_jpu['pangkat'])); 
		$odf->setVars('nip_penandatangan', ucfirst($data_jpu['nip'])); 
		
		$dft_no_urut = $odf->setSegment('no_urut');
		$i = 1;
		
		foreach($datas as $data){
                $dft_no_urut->nourut($i);
                $dft_no_urut->merge();
				$i++;
        }
		$odf->mergeSegment($dft_no_urut);
		
		$dft_noreg = $odf->setSegment('noreg');
		foreach($datas as $data){
                $dft_noreg->isi('isi');
                $dft_noreg->merge();
				$i++;
        }
		$odf->mergeSegment($dft_noreg);
		
		$dft_terdakwa = $odf->setSegment('terdakwa');
		foreach($datas as $data){
                $dft_terdakwa->isi($data['nama']);
                $dft_terdakwa->merge();
				$i++;
        }
		$odf->mergeSegment($dft_terdakwa);
		
		$dft_pasaldakwaan = $odf->setSegment('pasaldakwaan');
		foreach($datas as $data){
                $dft_pasaldakwaan->isi($data['pasal']);
                $dft_pasaldakwaan->merge();
				$i++;
        }
		$odf->mergeSegment($dft_pasaldakwaan);
		
		$dft_dakwaanbukti = $odf->setSegment('dakwaanbukti');
		foreach($datas as $data){
                $dft_dakwaanbukti->isi('isi');
                $dft_dakwaanbukti->merge();
				$i++;
        }
		$odf->mergeSegment($dft_dakwaanbukti);
		
		$dft_pidanabadan = $odf->setSegment('pidanabadan');
		foreach($datas as $data){
                $dft_pidanabadan->isi($data['tahun_badan']." Tahun ".$data['bulan_badan']." Bulan ".$data['hari_badan']." Hari");
                $dft_pidanabadan->merge();
				$i++;
        }
		$odf->mergeSegment($dft_pidanabadan);
		
		$dft_denda = $odf->setSegment('denda');
		foreach($datas as $data){
                $dft_denda->isi($data['denda']);
                $dft_denda->merge();
				$i++;
        }
		$odf->mergeSegment($dft_denda);
		
		$dft_barbuk = $odf->setSegment('barbuk');
		foreach($datas as $data){
                $dft_barbuk->isi('isi');
                $dft_barbuk->merge();
				$i++;
        }
		$odf->mergeSegment($dft_barbuk);
		
		$dft_biayaperkara = $odf->setSegment('biayaperkara');
		foreach($datas as $data){
                $dft_biayaperkara->isi($data['biaya_perkara']);
                $dft_biayaperkara->merge();
				$i++;
        }
		$odf->mergeSegment($dft_biayaperkara);
		
		$dft_up = $odf->setSegment('up');
		foreach($datas as $data){
                $dft_up->isi('isi');
                $dft_up->merge();
				$i++;
        }
		$odf->mergeSegment($dft_up);
		
		$dft_dakwaanbukti2 = $odf->setSegment('dakwaanbukti2');
		foreach($datas as $data){
                $dft_dakwaanbukti2->isi('isi');
                $dft_dakwaanbukti2->merge();
				$i++;
        }
		$odf->mergeSegment($dft_dakwaanbukti2);
		
		$dft_pidanabadan2 = $odf->setSegment('pidanabadan2');
		foreach($datas as $data){
                $dft_pidanabadan2->isi('isi');
                $dft_pidanabadan2->merge();
				$i++;
        }
		$odf->mergeSegment($dft_pidanabadan2);
		
		$dft_denda2 = $odf->setSegment('denda2');
		foreach($datas as $data){
                $dft_denda2->isi('isi');
                $dft_denda2->merge();
				$i++;
        }
		$odf->mergeSegment($dft_denda2);
		
		$dft_barbuk2 = $odf->setSegment('barbuk2');
		foreach($datas as $data){
                $dft_barbuk2->isi('isi');
                $dft_barbuk2->merge();
				$i++;
        }
		$odf->mergeSegment($dft_barbuk2);
		
		$dft_biayaperkara2 = $odf->setSegment('biayaperkara2');
		foreach($datas as $data){
                $dft_biayaperkara2->isi('isi');
                $dft_biayaperkara2->merge();
				$i++;
        }
		$odf->mergeSegment($dft_biayaperkara2);
		
		$dft_up2 = $odf->setSegment('up2');
		foreach($datas as $data){
                $dft_up2->isi('isi');
                $dft_up2->merge();
				$i++;
        }
		$odf->mergeSegment($dft_up2);
		
		$dft_sikapjpu = $odf->setSegment('sikapjpu');
		foreach($datas as $data){
                $dft_sikapjpu->isi('isi');
                $dft_sikapjpu->merge();
				$i++;
        }
		$odf->mergeSegment($dft_sikapjpu);
		
		$dft_ket = $odf->setSegment('ket');
		foreach($datas as $data){
                $dft_ket->isi('isi');
                $dft_ket->merge();
				$i++;
        }
		$odf->mergeSegment($dft_ket);
		
		$odf->setVars('kejaksaan', ucfirst(Yii::$app->globalfunc->getSatker()->inst_nama));   
		$odf->exportAsAttachedFile();*/
	}
}
