<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\Models\MsAgama;
use app\Models\MsJkl;
use app\Models\MsPendidikan;
use app\Models\MsWarganegara;
use app\modules\pidum\models\MsPenyidik;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\MsTersangkaSearch;
use app\modules\pidum\models\PdmPenetapanHakim;
use app\modules\pidum\models\PdmBa15;
use app\modules\pidum\models\PdmBA15Search;
use app\modules\pidum\models\PdmJaksaPenerima;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmT4;
use app\modules\pidum\models\PdmTanyaJawab;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use Odf;
use Yii;
use yii\db\Exception;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Session;
use yii\web\UploadedFile;
use yii\data\SqlDataProvider;
use yii\web\Response;

use app\modules\pidum\models\PdmJaksaSaksi;
/**
 * PdmBA15Controller implements the CRUD actions for PdmBA15 model.
 */
class PdmBa15Controller extends Controller {

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
     * Lists all PdmBA15 models.
     * @return mixed
     */
    public function actionIndex() {
		$no_register_perkara = Yii::$app->session->get('no_register_perkara');
        $searchModel = new PdmBA15Search();
        $dataProvider = $searchModel->search($no_register_perkara,Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = '15';
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA15]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmBA15 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdatetersangka() {
        $idTersangka = $_POST['update_id_tersangka'];
        $idPerkara = $_POST['update_id_perkara'];
        $idIdentitas = $_POST['MsTersangka']['id_identitas'];
        $noIdentitas = $_POST['update_no_identitas'];
        $nama = $_POST['update_nama'];
        $idJkl = $_POST['MsTersangka']['id_jkl'];
        $tempatLahir = $_POST['update_tempat_lahir'];
        $tglLahir = $_POST['MsTersangka']['tgl_lahir'];
        $alamat = $_POST['update_alamat'];
        $warganegara = $_POST['update_warganegara'];
        $suku = $_POST['update_suku'];
        $idPendidikan = $_POST['MsTersangka']['id_pendidikan'];
        $idAgama = $_POST['MsTersangka']['id_agama'];
        $pekerjaan = $_POST['update_pekerjaan'];

        $model = MsTersangka::findOne(['id_tersangka' => $idTersangka]);
        $model->id_tersangka = $idTersangka;
        $model->id_perkara = $idPerkara;
        $model->tmpt_lahir = $tempatLahir;
        $model->tgl_lahir = date('Y-m-d', strtotime($tglLahir));
        $model->alamat = $alamat;
        $model->no_identitas = $noIdentitas;
        $model->warganegara = $warganegara;
        $model->pekerjaan = $pekerjaan;
        $model->suku = $suku;
        $model->nama = $nama;
        $model->id_jkl = $idJkl;
        $model->id_identitas = $idIdentitas;
        $model->id_agama = $idAgama;
        $model->id_pendidikan = $idPendidikan;

        if ($model->save()) {
            return $this->redirect(\Yii::$app->urlManager->createUrl("pidum/pdm-ba15/update"));
        }
    }

    /**
     * Creates a new PdmBA15 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA15]);
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $model = new PdmBa15();

        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $penetapan = PdmPenetapanHakim::findAll(['no_register_perkara'=>$no_register_perkara]);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            //echo '<pre>';print_r($_POST);exit;
            try {
                $model->no_register_perkara = $no_register_perkara;


                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->id_kejati = $session->get('kode_kejati');
                $model->id_kejari = $session->get('kode_kejari');
                $model->id_cabjari = $session->get('kode_cabjari');
                if(!$model->save()){
                  var_dump($model->getErrors());exit;
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
                return $this->redirect(['index']);
            } catch (Exception $ex) {
                $transaction->rollback();
                print_r($ex);exit;
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal disimpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'no_register_perkara'=>$no_register_perkara,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'dataJPU' => $dataJPU,
                        'sysMenu' => $sysMenu,
                        'id' => $id,
                        'penetapan' => $penetapan,
            ]);
        }
    }

    /**
     * Updates an existing PdmBA15 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionDetailPenetapan() {
        $nomor = $_POST['no_penetapan'];
        $has = PdmPenetapanHakim::findOne(['no_penetapan_hakim'=>$nomor]);
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'tanggal' => $has->tgl_penetapan_hakim,
        ];

    }
    public function actionUpdate($id) {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA15]);
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $model = $this->findModel($no_register_perkara,$id);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $penetapan = PdmPenetapanHakim::findAll(['no_register_perkara'=>$no_register_perkara]);
        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try { 
                //echo '<pre>';print_r($_POST);exit;
               $model->no_register_perkara = $no_register_perkara;
               $model->updated_by=\Yii::$app->user->identity->peg_nip;
               $model->updated_time=date('Y-m-d H:i:s');
               $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
               if(!$model->update()){
                 var_dump($model->getErrors());exit;
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
                return $this->redirect(['index']);
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal disimpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'no_register_perkara'=>$no_register_perkara,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'dataJPU' => $dataJPU,
                        'sysMenu' => $sysMenu,
                        'penetapan' => $penetapan,
                        'id' => $id
            ]);
        }
    }

    /**
     * Deletes an existing PdmBA15 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        
            if($id_tahap=='all'){
                    $id_tahapx=PdmBa15::find()->select("tgl_ba15")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['tgl_ba15'];
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }

        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
            //echo '<pre>';print_r($delete);exit;
             try{
                    PdmBa15::deleteAll(['no_register_perkara' => $no_register_perkara, 'tgl_ba15'=>$delete]);
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

    protected function findModel($no_register_perkara,$id) {
        if (($model = PdmBa15::findOne(['no_register_perkara'=>$no_register_perkara, 'tgl_ba15'=>$id])) !== null) {
            return $model;
        } 
    }

    public function actionCetak($id) {
      $session = new session();
      $no_register_perkara = $session->get('no_register_perkara');
      $model = $this->findModel($no_register_perkara,$id);
      return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model]); 
    }


    public function actionCetakDraft() {
      $session = new session();
      $no_register_perkara = $session->get('no_register_perkara');
      $model = new PdmBa15();
      return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model]); 
    }


    public function actionTersangka() {
        $id = $_POST['id'];
        $idba15 = $_POST['id_ba15'];
        $perkara = $_POST['perkara'];

        $cekdata = PdmBa15::findOne(['id_tersangka' => $id]);

        if ($cekdata != null && $cekdata->id_ba15 != $idba15) {
            $json = 1;
            echo json_encode($json);
        } else {
            $modelTersangka = MsTersangka::findOne(['id_tersangka' => $id]);
            if ($modelTersangka != null) {
                if ($modelTersangka->tgl_lahir != null) {
                    $modelTersangka->tgl_lahir = date('d-m-Y', strtotime($modelTersangka->tgl_lahir));
                }
                $json = array("nama" => $modelTersangka->nama,
                    "tempat_lahir" => $modelTersangka->tmpt_lahir,
                    "tanggal_lahir" => $modelTersangka->tgl_lahir,
                    "jenis_kelamin" => $modelTersangka->id_jkl,
                    "warga_negara" => $modelTersangka->warganegara,
                    "tempat_tinggal" => $modelTersangka->alamat,
                    "agama" => $modelTersangka->id_agama,
                    "pekerjaan" => $modelTersangka->pekerjaan,
                    "pendidikan" => $modelTersangka->id_pendidikan,
                    "id" => $id,
                );
                echo json_encode($json);
            } else {
                $json = 'data kosong';
                echo json_encode($json);
            }
        }
    }

}
