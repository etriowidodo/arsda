<?php

namespace app\modules\pidum\controllers;

use Yii;
use yii\db\Query;
use yii\web\Session;
use app\modules\pidum\models\PdmD3;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmPutusanPn;
use app\modules\pidum\models\PdmPutusanPnTerdakwa;
use app\modules\pidum\models\PdmP48;
use app\modules\pidum\models\PdmD3Search;
use app\modules\pidum\models\VwJaksaPenuntutSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\pidum\models\PdmMsStatusData;
use app\components\GlobalConstMenuComponent;
use app\components\ConstSysMenuComponent;
use app\modules\pidum\models\PdmSpdp;





/**
 * PdmD3Controller implements the CRUD actions for PdmD3 model.
 */
class PdmD3Controller extends Controller
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
     * Lists all PdmD3 models.
     * @return mixed
     */
    public function actionIndex(){
      $session = new session();
      $no_eksekusi = $session->get('no_eksekusi');
      return $this->redirect(['update', 'no_eksekusi' => $no_eksekusi]);
    }

    /**
     * Displays a single PdmD3 model.
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
     * Creates a new PdmD3 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate($no_eksekusi)
    {
        $session = new session();
      
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi = $session->get('no_eksekusi');
        $sql = "SELECT count(*) from pidum.pdm_d3 where no_eksekusi='$no_eksekusi'";
        $jum = Yii::$app->db->createCommand($sql)->queryScalar();
        $jum++;
        $no_putusan = PdmP48::findOne(['no_surat'=>$no_eksekusi])->no_putusan;
        $putusan = PdmPutusanPnTerdakwa::findOne(['no_surat'=>$no_putusan]);
        //echo '<pre>';print_r($putusan);exit;
        $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$no_reg_tahanan]);
        $model = $this->findModel($no_eksekusi);
        if($model== NULL){$model = new PdmD3();}

        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->searchttd(Yii::$app->request->queryParams);
        //echo '<pre>';print_r($dataJPU);exit;
        $dataJPU->pagination->pageSize = 5;
        if ($model->load(Yii::$app->request->post())) {
          $transaction = Yii::$app->db->beginTransaction();
          try {
            //echo '<pre>';print_r($no_eksekusi);exit;
              $model->no_register_perkara = $no_register_perkara;
              $model->no_reg_tahanan = $no_reg_tahanan;
              $model->det_angsuran = json_encode($_POST['PdmD3']['angsuran']);
              $model->no_eksekusi = $no_eksekusi;

                            $model->created_time=date('Y-m-d H:i:s');
                            $model->created_by=\Yii::$app->user->identity->peg_nip;
                            $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                            
                            $model->updated_by=\Yii::$app->user->identity->peg_nip;
                            $model->updated_time=date('Y-m-d H:i:s');
                            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                            
                                          
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
                return $this->redirect(['update', 'no_eksekusi' => $no_eksekusi]);         
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
            }          
           // return $this->redirect(['view', 'id' => $model->id_d3]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tersangka' => $tersangka,
                'putusan' => $putusan,
                'jum' => $jum,
                'searchJPU' => $searchJPU,
                'dataJPU' => $dataJPU,
            ]);
        }
    }

    /**
     * Updates an existing PdmD3 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionCreate($id_d3)
    {
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
	$model = PdmD3::findOne(['id_d3'=>$id_d3]);
 

        if ($model->load(Yii::$app->request->post())) {
            
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_d3', 'id_d3', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
			
			
		if($model->id_perkara != null){
			$model->flag='2';	
                        $model->rincian_angsur = $_POST['PdmD3']['rincian_angsur'];
                        $model->tgl_angsur = $_POST['PdmD3']['tgl_angsur'];
			$model->save();
		}else{
			$model->id_perkara = $id_perkara;
			$model->id_d3 = $seq['generate_pk'];
                         $model->rincian_angsur = $_POST['PdmD3']['rincian_angsur'];
                        $model->tgl_angsur = $_POST['PdmD3']['tgl_angsur'];
			$model->save();
			}
            //notifikasi simpan
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
            return $this->redirect(['update', 'id_d3' => $model->id_d3]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PdmD3 model.
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

                PdmD3::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                   PdmD3::updateAll(['flag' => '3'], "id_d3 = '" . $id[$i] . "'");
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
   public function actionCetak($no_urut){
       $session = new session();
       $id_perkara = $session->get('id_perkara');
       $no_register_perkara = $session->get('no_register_perkara');
       $no_akta = $session->get('no_akta');
       $no_reg_tahanan = $session->get('no_reg_tahanan');
       $no_eksekusi = $session->get('no_eksekusi');
       $spdp = PdmSpdp::findOne(['id_perkara'=>$id_perkara]);
       $no_urut = $no_urut - 1;
       $model = $this->findModel($no_eksekusi);
       /*$dec = json_decode($model->det_angsuran);
       echo '<pre>';print_r($dec->ke[$no_urut].' - '.$dec->no_kwitansi[$no_urut]);exit;*/
      // $d1 = PdmD1::findOne(['no_eksekusi'=>$no_eksekusi]);
       $p48 = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
       $putusan = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
       $putusan_terdakwa = PdmPutusanPnTerdakwa::findOne(['no_surat'=>$p48->no_putusan]);
       $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan]);
       
       //echo '<pre>';print_r($p48);exit;
       return $this->render('cetak', ['tersangka'=>$tersangka, 'p48'=>$p48 ,'model'=>$model, 'spdp'=>$spdp, 'putusan'=>$putusan, 'no_urut'=>$no_urut,'putusan_terdakwa'=>$putusan_terdakwa]);
      
  }
/**
     * Finds the PdmD3 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmD3 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_eksekusi)
    {
        if (($model = PdmD3::findOne(['no_eksekusi'=> $no_eksekusi])) !== null) {
            return $model;
        } 
    }
}
