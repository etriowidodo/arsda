<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was16a;
use app\modules\pengawasan\models\Was16aSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\TembusanWas16a;
use app\modules\pengawasan\models\VTerlapor;
use app\modules\pengawasan\models\VTembusanWas16a;
use app\models\KpInstSatkerSearch;
use app\models\KpInstSatker;
use app\modules\pengawasan\models\LookupItem;
use app\modules\pengawasan\models\VPejabatPimpinan;
use app\modules\pengawasan\models\VWas16a;
use app\components\GlobalFuncComponent;
use Odf;
use app\modules\pengawasan\models\TembusanWas16c;
use Nasution\Terbilang;

/**
 * Was16aController implements the CRUD actions for Was16a model.
 */
class Was16aController extends Controller {

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
   * Lists all Was16a models.
   * @return mixed
   */
  public function actionIndex() {
    /* $searchModel = new Was16aSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
    ]); */
	echo "asdadad";
  }

  /**
   * Displays a single Was16a model.
   * @param string $id
   * @return mixed
   */
  public function actionView($id) {
    return $this->render('view', [
                'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Was16a model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {

    $model = new Was16a();

   
   
    $connection = \Yii::$app->db;

    //Simpan data
    if ($model->load(Yii::$app->request->post())) {
      $tembusan = $_POST['id_jabatan'];
      $model->id_terlapor = $_POST['Was16a']['id_terlapor'];
      $model->kpd_was_16a = $_POST['Was16a']['kpd_was_16a'];
      $model->ttd_was_16a = $_POST['Was16a']['ttd_was_16a'];
      $model->no_was_16a = "R-" . $_POST['no_was_16a'];

      $model->created_ip = Yii::$app->getRequest()->getUserIP();

      $files = \yii\web\UploadedFile::getInstance($model, 'upload_file');
      $model->upload_file = $files->name;

      $transaction = $connection->beginTransaction();
      try {
        if ($model->save()) {

          if ($files != false) {
            $path = \Yii::$app->params['uploadPath'] . 'was_16a/' . $files->name;
            $files->saveAs($path);
          }
          for ($i = 0; $i < count($tembusan); $i++) {
            $saveTembusan = new TembusanWas16a();
            $saveTembusan->id_was_16a = $model->id_was_16a;
            $saveTembusan->id_pejabat_tembusan = $tembusan[$i];
            $saveTembusan->save();
          }
        }
        $transaction->commit();
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
        return $this->redirect(['create']);
      } catch (Exception $e) {
        $transaction->rollback();
      }
    } else {
      return $this->render('create',[
						'model'=>$model,
			]);
    }
  }

  public function actionCetak($id) {
    $odf = new Odf(Yii::$app->params['report-path'] . "modules/pengawasan/template/was_16a.odt");

    $was_16a = VWas16a::find()->where("id_was_16a='" . $id . "'")->one();
    //var_dump($was_16a); exit();
    $tembusan = VTembusanWas16a::find()->where("id_was_16a='" . $id . "'")->all();

    $odf->setVars('no_was_16a', $was_16a->no_was_16a);
    $odf->setVars('kpd_was_16a', $was_16a->kpd);
    $odf->setVars('ttd_dari', $was_16a->dari);
    $odf->setVars('perihal', $was_16a->perihal);
    $odf->setVars('tgl_was_16a', GlobalFuncComponent::tglToWord($was_16a->tgl_was_16a));
    $odf->setVars('kejaksaan', $was_16a->kejaksaan);
    $odf->setVars('sifat_surat', $was_16a->sifat);

    //jumlah lampiran
    if ($was_16a->jml_lampiran != '') {
      $terbilang = new Terbilang();
      $ini = $was_16a->jml_lampiran . " (" . $terbilang->convert($was_16a->jml_lampiran) . ")";
      $odf->setVars('jml_lampiran', $ini);
    } else {
      $odf->setVars('jml_lampiran', "-");
    }

    $odf->setVars('nama_terlapor', ""); //nama di hidden, karena muncul 2x
    //$odf->setVars('pangkat_terlapor', $was_16a->sifat);
    $odf->setVars('nip_terlapor', $was_16a->nip);
    $odf->setVars('jabatan_terlapor', $was_16a->jabatan);
    $odf->setVars('ttd_jabatan', $was_16a->ttd_jabatan);
    $odf->setVars('ttd_peg_nama', $was_16a->ttd_peg_nama);
    $odf->setVars('ttd_peg_nip', $was_16a->ttd_peg_nip);

    $odf->setVars('surat', "SP-WAS-2");
    $odf->setVars('nomor_surat', $was_16a->no_surat_dinas);
    $odf->setVars('tanggal', GlobalFuncComponent::tglToWord($was_16a->tanggal_surat_dinas));
    $odf->setVars('pelanggaran_disiplin', $was_16a->dugaan_pelanggaran);
    $isi_hukuman_disiplin = $was_16a->keterangan . ' ' . $was_16a->aturan_hukum;
    $odf->setVars('isi_hukuman_disiplin', $isi_hukuman_disiplin);

    $odf->setVars('tempat', $was_16a->tempat);
    #tembusan
    $dft_tembusan = $odf->setSegment('tembusan');
    $i = 1;
    foreach ($tembusan as $element) {
      $dft_tembusan->urutan_tembusan($i);
      $dft_tembusan->jabatan_tembusan($element['jabatan']);
      $dft_tembusan->merge();
      $i++;
    }

    $odf->mergeSegment($dft_tembusan);

    $dugaan = \app\modules\pengawasan\models\DugaanPelanggaran::findBySql("select a.id_register,a.no_register,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor from was.dugaan_pelanggaran a
inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
inner join (
select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
    inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
    inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
        inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
            count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
        on (a.id_register=f.id_register) where a.id_register = :idRegister", [":idRegister" => $was_16a->id_register])->asArray()->one();
    $odf->exportAsAttachedFile("WAS16a - " . $dugaan['terlapor'] . ".odt");
  }

//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id_was_16a]);
//        } else {
////            return $this->render('update', [
//            return $this->render('_formTerlapor', [
//                'model' => $model,
//            ]);
//        }
//    }

  public function actionUpdate() {
    //$key = $_POST['id_was16a'];
    $key = $_POST['id_was16a'];
    $model = $this->findModel($key);
    $searchModel = new \app\modules\pengawasan\models\Was1Search();

    //$modelTembusan = TembusanWas16a::find()->where('id_was_16a=:id_was',[':id_was'=>$key]);
    $modelTembusan = TembusanWas16a::findAll(['id_was_16a' => $key]);
    //print_r($modelTembusan); exit();
    $no_register = $searchModel->searchRegister($was_register);
    $data_satker = $searchModel->searchSatker($was_register);
    $searchSatker = new KpInstSatkerSearch();
    $dataProviderSatker = $searchSatker->searchSatker(Yii::$app->request->queryParams);

    $view_pemberitahuan = $this->renderAjax('_formTerlapor', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
        'no_register' => $no_register,
        'data_satker' => $data_satker,
        'searchSatker' => $searchSatker,
        'dataProviderSatker' => $dataProviderSatker,
    ]);
    //   header('Content-Type: application/json; charset=utf-8');
    echo \yii\helpers\Json::encode(['key' => $key, 'view_pemberitahuan' => $view_pemberitahuan]);
    \Yii::$app->end();
    //return CJSON::encode(['key'=>$key,'view_pemberitahuan'=>$view_pemberitahuan]);
    //  return json_encode($key);
  }

  public function actionUpdate2($id) {
    $model = Was16a::findOne(array("id_was_16a" => $id, "flag" => '1'));
    $model2 = Was16a::findOne(array("id_was_16a" => $id, "flag" => '1'));
    $model->id_was_16a = $id;
    $model->no_was_16a = "R-" . $_POST["no_was_16a"];
//      $model->id_register = $_POST[];
    $model->inst_satkerkd = $_POST["inst_satkerkd"];
    $model->kpd_was_16a = $_POST["Was16a"]["kpd_was_16a"];
//      $model->id_terlapor = $_POST["Was16a"]["id_terlapor"];
    $model->tgl_was_16a = $_POST["Was16a"]["tgl_was_16a"];
    $model->sifat_surat = $_POST["Was16a"]["sifat_surat"];
    $model->jml_lampiran = $_POST["Was16a"]["jml_lampiran"];
//      $model->satuan_lampiran = $_POST[];
    $model->perihal = $_POST["Was16a"]["perihal"];
    $model->ttd_was_16a = $_POST["Was16a"]["ttd_was_16a"];
    $model->ttd_peg_nik = $_POST["Was16a"]["ttd_peg_nik"];
    $model->ttd_id_jabatan = $_POST["Was16a"]["ttd_id_jabatan"];
    $model->updated_ip = Yii::$app->getRequest()->getUserIP();

    $file = \yii\web\UploadedFile::getInstance($model, 'upload_file');
    //$model->upload_file = $files->name;
    if (empty($file)) {
      $model->upload_file = $model2->upload_file;
    } else {
      $model->upload_file = $file->name;
    }

    $tembusan = $_POST['id_jabatan'];

    $connection = \Yii::$app->db;
    $transaction = $connection->beginTransaction();
    try {
      if ($model->save()) {
        if ($files != false) {
          $path = \Yii::$app->params['uploadPath'] . 'was_16a/' . $files->name;
          $files->saveAs($path);
        }

        //hapus tembusan lalu disimpan lagi 
        TembusanWas16a::deleteAll('id_was_16a=:del', [':del' => $model->id_was_16a]);
        for ($i = 0; $i < count($tembusan); $i++) {
          $saveTembusan = new TembusanWas16a();
          $saveTembusan->id_was_16a = $model->id_was_16a;
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
      }
      $transaction->commit();

      return $this->redirect(['create']);
    } catch (Exception $e) {
      $transaction->rollback();
    }
  }

  /**
   * Deletes an existing Was16a model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param string $id
   * @return mixed
   */
  public function actionDelete() {
    $id_was_16a = $_POST['data'];
    $arrIdWas16a = explode(',', $id_was_16a);


    for ($i = 0; $i < count($arrIdWas16a); $i++) {

      if (Was16a::updateAll(["flag" => '3'], "id_was_16a ='" . $arrIdWas16a[$i] . "'")) {
        TembusanWas16a::updateAll(["flag" => '3'], "id_was_16a ='" . $arrIdWas16a[$i] . "'");
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
        return $this->redirect(['create']);
      } else {
        Yii::$app->getSession()->setFlash('success', [
            'type' => 'danger',
            'duration' => 3000,
            'icon' => 'fa fa-users',
            'message' => 'Data Gagal di Hapus',
            'title' => 'Error',
            'positonY' => 'top',
            'positonX' => 'center',
            'showProgressbar' => true,
        ]);
      }
    }
  }

  public function actionHapus() {
    $id_was_16a = $_GET['id'];
    if (Was16a::updateAll(["flag" => '3'], "id_was_16a ='" . $id_was_16a . "'")) {
      TembusanWas16a::updateAll(["flag" => '3'], "id_was_16a ='" . $id_was_16a . "'");
      Yii::$app->getSession()->setFlash('success', [
          'type' => 'success',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'Data Berhasil Dihapus',
          'title' => 'Hapus Data',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    } else {
      Yii::$app->getSession()->setFlash('success', [
          'type' => 'danger',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'Data Gagal Dihapus',
          'title' => 'Error',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    }
    return $this->redirect(['create']);
  }

  /**
   * Finds the Was16a model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param string $id
   * @return Was16a the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = Was16a::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

  public function actionRegisterWas() {
    $key = $_POST['id_register'];

    $view_pemberitahuan = $this->renderAjax('view2', [
        'model' => $this->findModel($key),
    ]);

    echo \yii\helpers\Json::encode(['key' => $key, 'view_pemberitahuan' => $view_pemberitahuan]);
  }

}
