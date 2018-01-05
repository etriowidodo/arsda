<?php

namespace app\modules\pidum\controllers;

use app\Models\MsAgama;
use app\modules\pidum\models\PdmP28;
use app\modules\pidum\models\PdmBa2;
use app\modules\pidum\models\PdmP29;
use app\modules\pidum\models\PdmP30;
use app\modules\pidum\models\PdmP31;
use app\modules\pidum\models\PdmP40;
use app\modules\pidum\models\PdmRp9;
use app\modules\pidum\models\PdmRt3;
use app\modules\pidum\models\PdmRb2;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSidang;
use app\modules\pidum\models\VwTerdakwa;
use app\modules\pidum\models\PdmP28Search;
use app\modules\pidum\models\MsLokTahanan;
use app\modules\pidum\models\PdmMsSaksiAhli;
use app\modules\pidum\models\PdmPasalDakwaan;
use app\modules\pidum\models\PdmPutusanHakim44;
use app\modules\pidum\models\PdmTahananPenyidik;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\components\GlobalConstMenuComponent;

/**
 * PdmP28Controller implements the CRUD actions for PdmP28 model.
 */
class PdmP28Controller extends Controller
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
     * Lists all PdmP28 models.
     * @return mixed
     */
    public function actionIndex()
    {
        // no need index page so redirect to update
//        return $this->redirect('update');
         $searchModel = new PdmP28Search();
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         return $this->render('index', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
         ]);
    }

    /**
     * Displays a single PdmP28 model.
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
     * Creates a new PdmP28 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmP28();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_p28]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdmP28 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $session = new Session();
        $id = $session->get('id_perkara');

        $model = $this->findModel($id);
        $modelRp9 = PdmRp9::findOne(['id_perkara' => $id]);
        $rt3 = PdmRt3::findAll(['id_perkara' => $id]);
        $modelRt3 = '';
        foreach ($rt3 as $row) {
            $modelRt3 .= $row->no_urut . ', ';
        }
        $modelRt3 = preg_replace("/, $/", "", $modelRt3);
        $modelRb2 = PdmRb2::findOne(['id_perkara' => $id]);
        $modelSidang = PdmSidang::find()->where(['id_p28'=>$model->id_p28])->andWhere("flag <> '3'")->all();

        if($model == null){
            $model = new PdmP28();
        }

        if($modelSidang == null){
            $modelSidang = new PdmSidang();
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try{
                $modelSidang = Yii::$app->request->post('PdmSidang');
                
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p28', 'id_p28', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
				
                if($model->id_perkara != null && $model->flag != '3'){
                	$model->update();

                    $hapus_sidang = $_POST['hapus_sidang_tanggal'];
                    if (!empty($hapus_sidang)) {
                        for ($j = 0; $j < count($hapus_sidang); $j++) { 
                            $modelSidangHapus = PdmSidang::findOne(['id_sidang' => $hapus_sidang[$j]]);
                            $modelSidangHapus->flag = '3';
                            $modelSidangHapus->update();
                        }
                    }

                    if (!empty($modelSidang['tgl_sidang_baru'])) {
                        for($i=0; $i<count($modelSidang['tgl_sidang_baru']); $i++){
                            $modelSidang1 = new PdmSidang();
                            $seqSidang = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_sidang', 'id_sidang', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                            $modelSidang1->id_sidang = $seqSidang['generate_pk'];
                            $modelSidang1->id_p28 = $model->id_p28;
                            $modelSidang1->tgl_sidang = date('Y-m-d', strtotime($modelSidang['tgl_sidang_baru'][$i]));
                            $modelSidang1->save();
                        
                        }
                    }
                }else{
	                $model->id_p28 = $seq['generate_pk'];
	                $model->id_perkara = $id;
	                $model->save();

                    if (!empty($modelSidang['tgl_sidang'])) {
    	                for($i=0; $i<count($modelSidang['tgl_sidang']); $i++){
    	                    $modelSidang1 = new PdmSidang();
    	                    $seqSidang = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_sidang', 'id_sidang', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
    	                    $modelSidang1->id_sidang = $seqSidang['generate_pk'];
    	                    $modelSidang1->id_p28 = $model->id_p28;
    	                    $modelSidang1->tgl_sidang = date('Y-m-d', strtotime($modelSidang['tgl_sidang'][$i]));
    	                    $modelSidang1->save();
    	                }
                    }

                    if (!empty($modelSidang['tgl_sidang_baru'])) {
                        for($i=0; $i<count($modelSidang['tgl_sidang_baru']); $i++){
                            $modelSidang1 = new PdmSidang();
                            $seqSidang = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_sidang', 'id_sidang', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                            $modelSidang1->id_sidang = $seqSidang['generate_pk'];
                            $modelSidang1->id_p28 = $model->id_p28;
                            $modelSidang1->tgl_sidang = date('Y-m-d', strtotime($modelSidang['tgl_sidang_baru'][$i]));
                            $modelSidang1->save();
                        }
                    }
                }


               $transaction->commit();
               
               if($model->save()){
		    //Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::P28); 
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
                    return $this->redirect('update');
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
                    return $this->redirect('update');
                }
            }catch (Exception $e) {
                $transaction->rollback();
            }
            
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelRp9' => $modelRp9,
                'modelRt3' => $modelRt3,
                'modelRb2' => $modelRb2,
                'modelSidang'=>$modelSidang,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP28 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionCetak($id)
    {
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/p28.odt");
        
        $pdmP28 = PdmP28::findOne(['id_p28'=>$id]);
        $spdp = PdmSpdp::findOne(['id_perkara'=>$pdmP28->id_perkara]);
        $pdmSidang = PdmSidang::findAll(['id_p28'=>$id]);
        $pdmJaksaPertama = PdmJaksaSaksi::findAll(['id_perkara' => $pdmP28->id_perkara, 'code_table' => GlobalConstMenuComponent::P16]);
        $pdmJaksaPu = PdmJaksaSaksi::findAll(['id_perkara' => $pdmP28->id_perkara, 'code_table' => GlobalConstMenuComponent::P16A]);
        $p30 = PdmP30::findOne(['id_perkara' => $pdmP28->id_perkara]);
        $p31 = PdmP31::findOne(['id_perkara' => $pdmP28->id_perkara]);
        $terdakwa = VwTerdakwa::find()->where(['id_perkara' => $pdmP28->id_perkara])->orderBy('id_tersangka asc')->all();
        $ba2 = PdmBa2::find()->select('id_ms_saksi_ahli')->where(['id_perkara' => $pdmP28->id_perkara])->andWhere("flag <> '3'")->all();
        
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('no_rp', $pdmP28->no_surat);
        
        $odf->setVars('berkas_dari', $spdp->idAsalsurat->nama);        
        $odf->setVars('penyidik', $spdp->idPenyidik->nama);
        $odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($spdp->tgl_surat));
        $odf->setVars('nomor', $spdp->no_surat);
        
        $odf->setVars('no_rt2', $pdmP28->no_rt2);
        $odf->setVars('no_rt3', $pdmP28->no_rt3);
        $odf->setVars('no_rb1', $pdmP28->no_rb1);
        $odf->setVars('no_rb2', $pdmP28->no_rb2);
        
        $odf->setVars('ketua', $pdmP28->hakim1);
        $odf->setVars('anggota1', $pdmP28->hakim2);
        $odf->setVars('anggota2', $pdmP28->hakim3);
        
        $jaksaPenuntutUmum = $odf->setSegment('jpu');
        $i = 1;
        foreach ($pdmJaksaPu as $value){
            $jaksaPenuntutUmum->no_urut_jpu($i);
            $jaksaPenuntutUmum->nama_jpu($value['nama']);
            $jaksaPenuntutUmum->merge();
            $i++;
        }
        $odf->mergeSegment($jaksaPenuntutUmum);

        $jaksaTahapPertama = $odf->setSegment('jtp');
        $j = 1;
        foreach ($pdmJaksaPertama as $value){
            $jaksaTahapPertama->no_urut_jtp($j);
            $jaksaTahapPertama->nama_jtp($value['nama']);
            $jaksaTahapPertama->merge();
            $j++;
        }
        $odf->mergeSegment($jaksaTahapPertama);
        
        $odf->setVars('jak_pu_pengganti', '-');
        $odf->setVars('dilimpahkan_kepn', '-');

        $apbAbs = !empty($p30) ? $p30->tgl_dikeluarkan : $p31->tgl_dikeluarkan ;
        $odf->setVars('apb_aps_tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($apbAbs));
        
        $sidang = $odf->setSegment('sidang');
        foreach($pdmSidang as $element){
                $sidang->hari_pengadilan(Yii::$app->globalfunc->GetNamaHari($element['tgl_sidang']));
                $sidang->tanggal_pengadilan(Yii::$app->globalfunc->ViewIndonesianFormat($element['tgl_sidang']));
                $sidang->merge();
        }
        $odf->mergeSegment($sidang);
        
        $odf->setVars('panitera', $pdmP28->panitera);
        $odf->setVars('penasehat', $pdmP28->penasehat);

        #terdakwa dan riwayat penahanan
        $segmentTerdakwa = $odf->setSegment('riwayatTerdakwa');
        $undangPasal = '';
        $k = 1;
        foreach ($terdakwa as $elTerdakwa) {
            $segmentTerdakwa->no_urut_terdakwa($k);
            $segmentTerdakwa->nama_terdakwa($elTerdakwa->nama);
            $segmentTerdakwa->dipidana('-');
            $segmentTerdakwa->jenis_penahanan(
                MsLokTahanan::findOne(
                    PdmTahananPenyidik::findOne([
                        'id_perkara' => $pdmP28->id_perkara,
                        'id_tersangka' => $elTerdakwa->id_tersangka])
                    ->id_msloktahanan
                )->nama
            );
            $segmentTerdakwa->tgl_mulai_penyidik(
                Yii::$app->globalfunc->ViewIndonesianFormat(
                    PdmTahananPenyidik::findOne([
                        'id_perkara' => $pdmP28->id_perkara,
                        'id_tersangka' => $elTerdakwa->id_tersangka])
                    ->tgl_mulai
                )
            );
            $segmentTerdakwa->tgl_mulai_jpu('-');
            $segmentTerdakwa->tgl_mulai_pn_pt_ma('-');
            $pasalDakwaan = PdmPasalDakwaan::find()
                            ->where(['id_perkara' => $pdmP28->id_perkara, 'id_tersangka' => $elTerdakwa->id_tersangka])
                            ->andWhere("flag <> '3'")
                            ->all();
            foreach ($pasalDakwaan as $value) {
                $undangPasal .= $value['undang'] . ' ' . $value['pasal'] . ', ';
            }
            $segmentTerdakwa->pasal_didakwakan(preg_replace('/, $/', '', $undangPasal));
            $segmentTerdakwa->ket_terdakwa('-');
            $segmentTerdakwa->merge();

            $k++;
        }
        $odf->mergeSegment($segmentTerdakwa);

        #saksi - saksi (diambil dari Ba2)
        $id_saksi = '';
        foreach ($ba2 as $value) {
            $id_saksi .= "'" . $value->id_ms_saksi_ahli . "',";
        }
        $id_saksi = preg_replace("/,$/", "", $id_saksi);
        $segmentSaksi = $odf->setSegment('saksi');
        if(!empty($id_saksi)){
            $saksi = PdmMsSaksiAhli::find()->where('id_saksi_ahli in (' . $id_saksi . ')')->all();
            $l = 1;
            foreach ($saksi as $rowSaksi) {
                $segmentSaksi->no_urut_saksi($l);
                $segmentSaksi->nama_saksi(ucfirst(strtolower($rowSaksi->nama)));
                if(!empty($rowSaksi->tgl_lahir)){
                    $umur = Yii::$app->globalfunc->datediff($rowSaksi->tgl_lahir,date("Y-m-d"));
                    $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($rowSaksi->tgl_lahir);  
                }else{
                    $tgl_lahir = '-';
                }
                $segmentSaksi->tgl_lahir_saksi($tgl_lahir);
                $segmentSaksi->tempat_lahir_saksi(ucfirst(strtolower($rowSaksi->tmpt_lahir)));
                $segmentSaksi->alamat_saksi($rowSaksi->alamat);
                $segmentSaksi->agama_saksi(MsAgama::findOne(['id_agama'=> $rowSaksi->id_agama])->nama);
                $segmentSaksi->pekerjaan_saksi(ucfirst(strtolower($rowSaksi->pekerjaan)));
                $segmentSaksi->ket_saksi('-');
                $segmentSaksi->merge();

                $l++;
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

        #tuntutan pidana & putusan pengadilan
        $segmentPutusan = $odf->setSegment('putusan');
        $l = 1;
        foreach ($terdakwa as $rowTerdakwa) {
            $segmentPutusan->no_urut_putusan($l);
            $p40 = PdmP40::findOne(['id_perkara' => $pdmP28->id_perkara, 'id_tersangka' => $rowTerdakwa->id_tersangka]);
            $segmentPutusan->requisitoir(
                'Tanggal: ' . Yii::$app->globalfunc->ViewIndonesianFormat($p40->tgl_dikeluarkan) . ', ' .
                'Diktum: ' . $p40->diktum
            );
            $p29 = PdmP29::findOne(['id_perkara' => $pdmP28->id_perkara, 'id_tersangka' => $rowTerdakwa->id_tersangka]);
            $segmentPutusan->amar_putusan(
                'Tanggal: ' . Yii::$app->globalfunc->ViewIndonesianFormat($p29->tgl_dikeluarkan) . ', ' . 
                'Nomor: -, ' . 
                'Amar Putusan: ' . PdmP29::getStaticDakwaan($pdmP28->id_perkara, $rowTerdakwa->id_tersangka)['dakwaan']
            );
            $putusanHakim44 = PdmPutusanHakim44::findOne(['id_perkara' => $id_perkara, 'id_tersangka' => $rowTerdakwa->id_tersangka]);
            $sikap_jpu = '';
            if ($putusanHakim44->is_sikap_jaksa == 1) {
                $sikap_jpu = "Menerima";
            }elseif ($putusanHakim44->is_sikap_jaksa == 2) {
                $sikap_jpu = "Banding";
            }else{
                $sikap_jpu = "Kasasi";
            }
            $sikap_terdakwa = '';
            if ($putusanHakim44->is_sikap_tersangka == 1) {
                $sikap_terdakwa = "Menerima";
            }else{
                $sikap_terdakwa = "Banding";
            }
            $segmentPutusan->sikap_jpu($sikap_jpu);
            $segmentPutusan->sikap_terdakwa($sikap_terdakwa);
            $segmentPutusan->tgl_pelaksana('-');
            $segmentPutusan->ket_putusan('-');
            $segmentPutusan->merge();

            $l++;
        }
        $odf->mergeSegment($segmentPutusan);

        #upaya hukum
        $odf->setVars('no_urut_upaya', '-');
        $odf->setVars('tgl_put_pt', '-');
        $odf->setVars('tgl_put_kasasi', '-');
        $odf->setVars('tgl_put_pkmk', '-');
        $odf->setVars('tgl_put_grasi', '-');
        $odf->setVars('ket_upaya', '-');

        #eksekusi
        $odf->setVars('no_urut_eksekusi', '-');
        $odf->setVars('tgl_pidana', '-');
        $odf->setVars('uang', '-');
        $odf->setVars('kurungan', '-');
        $odf->setVars('barang_bukti', '-');
        $odf->setVars('uang_pengganti', '-');
        $odf->setVars('biaya_perkara', '-');
        $odf->setVars('ket_eksekusi', '-');

        $odf->exportAsAttachedFile('p28.odt');
    }

    /**
     * Finds the PdmP28 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP28 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP28::find()->where(['id_perkara' => $id])->andWhere("flag <> '3'")->one()) !== null) {
            return $model;
        }
    }
}
