<?php

namespace app\controllers;

use Yii;
use app\models\BackupData;
use app\modules\pidum\models\MsJenisPidanaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
/**
 * MsJenisPidanaController implements the CRUD actions for MsJenisPidana model.
 */
class BackupDataController extends Controller
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
      
        if(isset($_POST['actionButton']))
        {

        
        if(!file_exists($_POST['BackupData']['file']))
        {
            echo "<script>alert('Direktori Tidak Ditemukan ');window.location = '/backup-data';</script>";exit;
        }
        
        set_time_limit (0);
         $name_file = str_replace(' ','',str_replace(':','',str_replace('-','',$_POST['BackupData']['last_backup']))).'_Simkari_CMS.sqlc';
          $folder_file = $_POST['BackupData']['file'].'\\'.$name_file;
          $dump=$folder_file;
          exec("C:\myapp\dump.bat ".escapeshellarg($dump),$return);
          print_r($output);

            if($return)
            {
               
            echo "<script>alert('Data Berhasil di Backup ');window.location = '/backup-data';</script>";
            }
            else
            {
                echo 'Data Gagal di Backup Silahkan Ulangi Proses Backup';  
            }
        }
        else
        {
          $model = new BackupData();
            return $this->render('_form', [
               'model' => $model
            ]);  
        }
        
    }

   
}


/**
*C:\Users\A\AppData\Roaming\postgresql ->>for automatic password 
*system. example = localhost:5432:*:postgres:Simkari123
*/
