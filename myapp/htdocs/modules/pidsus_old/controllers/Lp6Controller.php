<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\Pidsus2Search;
use app\modules\pidsus\models\SimkariJenisSurat;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class Lp6Controller extends Controller
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
     * Updates an existing PdsLid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionIndex()
    {	    
    	if(isset($_POST['select_satker'])){
    		$modelJenisSurat= SimkariJenisSurat::findOne(trim('lp6'));
    		$urlReport =str_replace("%7BID_SATKER%7D",$_POST['select_satker'],$modelJenisSurat->url_report);
    		$urlReport =str_replace("%7BID_JENIS_KASUS%7D",$_POST['select_jenis_kasus'],$urlReport);	
    		$urlReport =str_replace("%7BBULAN%7D",$_POST['select_bulan'],$urlReport);	
    		$urlReport =str_replace("%7BTAHUN%7D",$_POST['select_tahun'],$urlReport);	
    		return $this->redirect($urlReport);
    	die();
    	}	else {
            return $this->render('index', [
            	'readOnly' => false,
            ]);   
    	}     
    }

   
    protected function findModel($id,$jenisSurat)
    {
        if (($model = PdsDikSurat::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_dik=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
            $model= new PdsDikSurat();
			$model->id_pds_dik=$id;
			$model->id_jenis_surat=$jenisSurat;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->perihal_lap='Pemberitahuan Dimulainya Penyidikan Perkara Tindak Pidana Korupsi/ Pelanggaran HAM yang berat';
			$model->save();
			return $this->findModel($id,$jenisSurat);
        }
    }
    protected function findModelDik($id)
    {
    	if (($modelLid = PdsDik::findOne($id)) !== null) {
    		return $modelLid;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    protected function findModelTembusan($id)
    {
    	return $model = PdsDiktembusan::find()->where('id_pds_dik_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
}
