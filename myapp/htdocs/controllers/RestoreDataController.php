<?php

namespace app\controllers;

use Yii;
use app\models\BackupData;
use app\modules\pidum\models\MsJenisPidanaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\UploadedFile;

/**
 * MsJenisPidanaController implements the CRUD actions for MsJenisPidana model.
 */
class RestoreDataController extends Controller
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
     * Lists all MsJenisPidana models.
     * @return mixed
     */
    public function actionIndex()
    {
        $files1 = $_FILES['file_restore_data']['name'];
        if($file1)
        {
            echo 'hallo';
        }
        else
        {
            $model = new BackupData();
            return $this->render('_form', [
               'model' => $model
            ]); 
        }
            
    }

    public function actionInsert()
    {
        if(empty($_FILE["file_restore_data"]["name"]))
        {
            set_time_limit (0);
            ini_set(session.gc_maxlifetime, 10800);
            ini_set(max_input_time, 10800);
            ini_set(max_execution_time,10800);
            ini_set(upload_max_filesize ,'500M');
            ini_set(post_max_size ,'500M' );  
        
            
            if (!file_exists(Yii::$app->basePath . '/web/restore_cms_simkari')) 
            {
                mkdir(Yii::$app->basePath . '/web/restore_cms_simkari');
            }
            $dir = Yii::$app->basePath.'/web/restore_cms_simkari/'.$_FILES['file_restore_data']['name'];
            $upload = $_FILES['file_restore_data']['tmp_name'];
            $realPath = realpath(Yii::$app->basePath . '/web/restore_cms_simkari/').'\\'.$_FILES['file_restore_data']['name'];

            move_uploaded_file($upload ,$dir);
            // system("cmd /c C:\myapp\drop.bat");
            // system("cmd /c C:\myapp\create.bat");
              $connection = new \yii\db\Connection([
                'dsn' => 'pgsql:host=localhost;port=411',
                'username' => 'postgres',
                'password' => ''
            ]);
             $connection->open(); 
              
             $command = $connection->createCommand(" SELECT pg_terminate_backend (pg_stat_activity.pid) FROM pg_stat_activity WHERE pg_stat_activity.datname = 'simkari_cms' ");
             $command->execute();
             $command = $connection->createCommand('DROP DATABASE simkari_cms');
             // $command->execute();
             // $command = $connection->createCommand('CREATE DATABASE simkari_cms');
            // exec('C:\myapp\drop.bat ',$return);
            exec('C:\myapp\create.bat ',$return);
           exec('C:\myapp\restore.bat '.escapeshellarg($realPath),$return);
              print_r($return);
                if($return)
                {    
                    $unlink = Yii::$app->basePath.'/web/restore_cms_simkari/'.$_FILES['file_restore_data']['name'];
                    unlink($unlink);               
                    echo "<script>alert('Data Berhasil di Restore ');window.location = '/restore-data';</script>";
                }
                else
                {
                    echo 'Data Gagal di Backup Silahkan Ulangi Proses Backup';  
                }
         
         }
    }

   
}
