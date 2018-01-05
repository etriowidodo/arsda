<?php

namespace app\modules\pdsold\controllers;
use Odf;
use Yii;
use app\modules\pdsold\models\VLaporanP7;
use app\modules\pdsold\models\LaporanP7;
use app\models\KpInstSatker;
//use app\modules\pdsold\models\VLaporanP7Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;

/**
 * VLaporanP7Controller implements the CRUD actions for VLaporanP7 model.
 */
class PdmLp7Controller extends Controller
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
     * Lists all VLaporanP7 models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new VLaporanP7Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);*/

        $model = new VLaporanP7();
	    $modelLap7 = new LaporanP7();
        
		
        return $this->render('index', [
            'model' => $model,
			'modelLap7'=> $modelLap7,
    
			/*'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,*/
        ]);
    }

    /**
     * Displays a single VLaporanP7 model.
     * @param  $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VLaporanP7 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VLaporanP7();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->w]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VLaporanP7 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		// var_dump($modelLap7); exit();
		
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
          //  return $this->redirect(['view', 'id' => $model->w]);
				return $this->redirect(['update','id'=>id]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'id' => $id,
				'modelLap7'=> $modelLap7,
            ]);
        }
		}

    /**
     * Deletes an existing VLaporanP7 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCetak()
    {
        $idSatker = Yii::$app->request->post('VLaporanP7');
        $bulan = Yii::$app->request->post('bulan');
        $tahun = Yii::$app->request->post('tahun');
		//var_dump($idSatker); exit();
		
		$id_penandatangan = Yii::$app->request->post('penandatangan'); 
		$tgl_dikeluarkan = Yii::$app->request->post('tgl_dikeluarkan');
		$dikeluarkan = Yii::$app->request->post('dikeluarkan');
    	
		$session= new Session();
		$id_perkara = $session->get('id_perkara'); 
		
		#query utama
		 $connection = \Yii::$app->db;
		$query = new Query();
        $laporan = $query->select('*')
            ->from('pidum.v_laporan_p7')
            ->where('satker=:satker AND EXTRACT(YEAR FROM pidum.v_laporan_p7.tgl_terima)=:tahun AND EXTRACT(MONTH FROM pidum.v_laporan_p7.tgl_terima)=:bulan',[
            ':satker' => $idSatker['satker'],
            ':tahun' => $tahun,
            ':bulan' => $bulan,
        ])->all();
		
		$odf = new Odf(Yii::$app->params['report-path']."modules/pdsold/template/lp7.odt");
		$lp7 = VLaporanP7::findOne(['satker' => $idSatker ]);
		$laporanp7= LaporanP7::findOne(['id_p7'=>$id_p7]);
		
		$list_laporan= $odf->setSegment('lap7');
		$i = '1';
        foreach($laporan as $lap7):
        $list_laporan->no($i);
	    $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($idSatker['satker'])->inst_nama);
        $odf->setVars('tahun', $tahun);
        $odf->setVars('bulan', strtoupper($this->getNamaBulan($bulan)));
		$odf->setVars('pasal', $lp7->pasal);
		$odf->setVars('pidana', $lp7->tindak_pidana);
		$odf->setVars('pasal', $lp7->pasal);
		$odf->setVars('sisa_bln_lalu', $lp7->sisa_bulan_lalu);
       	$odf->setVars('laporan', $lp7->masuk_bulan_lap); 
		$odf->setVars('instansi_lain', $lp7->kirim_instansi_lain);
		$odf->setVars('dihentikan',$lp7->dihentikan);
		$odf->setVars('kepentingan_umum',$lp7->kepentingan_umum);
		$odf->setVars('apb', $lp7->apb);
		$odf->setVars('aps', $lp7->aps);
		$odf->setVars('jml_selesai', $lp7->jml_selesai);
		$odf->setVars('proses_persidangan', $lp7->proses_persidangan);
		$odf->setVars('pn', $lp7->putus_pn);
		$odf->setvars('dikeluarkan',$dikeluarkan);
		$odf->setVars('tanggal',Yii::$app->globalfunc->ViewIndonesianFormat($tgl_dikeluarkan));
		$list_laporan->merge();
        $i++;
        endforeach;
        $odf->mergeSegment($list_laporan);
		
		#penanda tangan
		
        $sql = "SELECT  DISTINCT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru 
		FROM pidum.pdm_penandatangan a, kepegawaian.kp_pegawai c
		where a.peg_nik =c.peg_nik and a.peg_nik ='".$id_penandatangan."'";
        $model = $connection->createCommand($sql);
		$penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);   
		$pangkat =explode('/',$penandatangan['pangkat']);
        $odf->setVars('pangkat', $pangkat[0]);       
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']); 
		
		$odf->exportAsAttachedFile();
    }

    /**
     * Finds the VLaporanP7 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  $id
     * @return VLaporanP7 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VLaporanP7::findOne($id)) !== null) {
            return $model;
         } //else {
            // throw new NotFoundHttpException('The requested page does not exist.');
        // }
    }
	
	 protected function getNamaBulan($bln)
    {
        switch($bln) {
            case 1 : $bln = 'Januari';
                break;
            case 2 : $bln = 'Februari';
                break;
            case 3 : $bln = 'Maret';
                break;
            case 4 : $bln = 'April';
                break;
            case 5 : $bln = 'Mei';
                break;
            case 6 : $bln = 'Juni';
                break;
            case 7 : $bln = 'Juli';
                break;
            case 8 : $bln = 'Agustus';
                break;
            case 9 : $bln = 'September';
                break;
            case 10 : $bln = 'Oktober';
                break;
            case 11 : $bln = 'November';
                break;
            case 12 : $bln = 'Desember';
                break;
        }
        return $bln;
    }
    
    public function getSatker() {
        $satker = KpInstSatker::find()
                ->select("inst_satkerkd as id, inst_nama as text")
                ->asArray()
                ->all();

        return $satker;
    }
}
