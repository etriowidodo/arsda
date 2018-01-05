<?php
namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DownloadFileController extends Controller{
    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(){
		$param = Yii::$app->request->get();
		$filename = base64_decode($param['fn']);
		$filelink = base64_decode($param['id']);
	
		if(file_exists($filelink)){
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filelink));
			ob_clean();
			flush();
			readfile($filelink);
			exit;
		} else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, file tidak ditemukan']);
			return $this->redirect(Yii::$app->request->referrer);
		}
    }
}
