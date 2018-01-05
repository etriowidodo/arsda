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
class BackupController extends Controller
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

        ini_set(session.gc_maxlifetime, 10800);
        ini_set(max_input_time, 10800);
        ini_set(max_execution_time,10800);
        ini_set(upload_max_filesize ,'110M');
        ini_set(post_max_size ,'120M' );  


        $host = 'localhost';
        $user = 'postgres';
        $db   = 'db_db';
        $pass = 'Simkari123';
 
        // $content = $host.':5432:*:'.$user.':'.$pass;
        // $base_win_dir = getenv("HOMEDRIVE").getenv("HOMEPATH");
        // $dir_password = '%APPDATA%\postgresql';
        // $a = exec($dir_password);
        // $fp = fopen($dir_password,"w") or die ("Error opening file in write mode!");
        // fputs($fp,$content);
        // fclose($fp) or die ("Error closing file!");
            $dir1 = "c:\Program Files\PostgreSQL";
            $dir2 = "c:\Program Files (x86)\PostgreSQL";
        if(file_exists($dir1))
        {
            $dir = $dir1;
        }
        else if(file_exists($dir2))
        {
            $dir = $dir2;
        }
        else
        {
            echo 'DataBase Tidak ditemukan';
        }
         $base_path = $dir;
         $dir_array = scandir($dir);
         $get_dir = '';
         foreach($dir_array as $_dir)
         {
            if($_dir>0)
            {
                $get_dir = $_dir;
            }
         }
         $name_file = str_replace(' ','',str_replace(':','',str_replace('-','',$_POST['BackupData']['last_backup']))).'_Simkari_CMS.sqlc';
         $base_path = str_replace("\\", '/', $base_path);
         $base_path = $base_path."/".$get_dir."/bin/pg_dump.exe";
         $folder_file = $_POST['BackupData']['file'].'\\'.$name_file;
         //echo $folder_file;exit;
         exec('cmd /k "'.$base_path.'" -h '.$host.' -U '.$user.' -d '.$db.' -F c -v --file='.$folder_file,$output, $return);
            if(!$return)
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

    public function actionRestore()
    {
      return $this->redirect(['/restore-data']);
    }

   
}


/**
*C:\Users\A\AppData\Roaming\postgresql ->>for automatic password 
*system. example = localhost:5432:*:postgres:Simkari123
*/
