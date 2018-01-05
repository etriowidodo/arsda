<?php
/**
 * Created by PhpStorm.
 * User: rio
 * Date: 09/04/15
 * Time: 10:57
 */

namespace app\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SynchronizeController extends Controller{
    public $connection;
    public $summary=array();

    public function init()
    {
        parent::init();
        $this->connection = Yii::$app->db;
    }

     public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'    => ['post'],
                   //'check-db'  => ['post'],
                   //'insert-setting' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
       
        return $this->render('index');
    }

    public function actionCheckDb()
    {
    $get_time = Yii::$app->db->createCommand(" select * from public.sync_schedule order by sync_id Desc limit 1")->queryAll();
     $query = Yii::$app->db->createCommand(" select * from public.sync_schedule order by sync_id Desc limit 1")->queryScalar();
        if($query>0)
            {
               $data = array(
                          'time_of_sync'     => $get_time[0]['time_of_sync'],
                          'time_for_compare' => date('H:i:s'),
                          'satker'           => \Yii::$app->globalfunc->getSatker()->inst_satkerkd
                          );
                echo json_encode($data); 
            }
        else
            {
                $data = array(
                          'time_of_sync'     => '16:00:00',
                          'time_for_compare' => date('H:i:s'),
                          'satker'           => \Yii::$app->globalfunc->getSatker()->inst_satkerkd
                          );
                echo json_encode($data); 
            }
    }
    public function actionProsesPeriodik()
    {

          $result = Yii::$app->db->createCommand(" select message||';'AS message,date_log from public.log  where status<>'1';  ")->queryAll();
          $finalresult = array();
           foreach($result AS $key=>$val)
           {
            $finalresult[] = $result[$key]['message'];
           }

          
           $send = array (
                           'data'=> json_encode($finalresult),
                           'satker'=>\Yii::$app->globalfunc->getSatker()->inst_satkerkd,
                           'count' => count($finalresult)
                         );
            echo json_encode($send);
    }

    public function actionProsesInsidental()
    {
     
     $pilihan = array(1=>'pidum',2=>'datun',3=>'was');

            $pidum = Yii::$app->db->createCommand(" select message||';'AS message,date_log from public.log where message like'%".$pilihan[$_POST['pidum']]."%' AND status<>'1';  ")->queryAll();
            $datun = Yii::$app->db->createCommand(" select message||';'AS message,date_log from public.log where message like'%".$pilihan[$_POST['datun']]."%' AND status<>'1';  ")->queryAll();
            $was = Yii::$app->db->createCommand(" select message||';'AS message,date_log from public.log where message like'%".$pilihan[$_POST['was']]."%' AND status<>'1';  ")->queryAll();
           $result = array_merge($pidum,$datun,$was);

           $finalresult = array();
           foreach($result AS $key=>$val)
           {
            $finalresult[] = $result[$key]['message'];
           }

          
           $send = array (
                           'data'=> json_encode($finalresult),
                           'satker'=>\Yii::$app->globalfunc->getSatker()->inst_satkerkd,
                           'count' => count($finalresult)
                         );
            echo json_encode($send);
    }
     public function actionInsertSetting()
    {
        if($_POST['send_method']==1)
        {
            $time_of_sync   = $_POST['time_of_sync'];
            $timezones      = $_POST['timezones'];
            if($timezones==''||$timezones==null)
            {
                $timezones =1;
            }

            Yii::$app->db->createCommand()->insert('public.sync_schedule', [
                'time_of_sync'   => $time_of_sync,
                'time_zones'     => $timezones,
                'last_update'    => date('Y-m-d H:i:s')
            ])->execute();
            echo "<script>window.location = '/synchronize';</script>";
        }   
    }

    public function actionSuccessSync()
    {
      Yii::$app->db->createCommand("update public.log set status = '1' ")->execute();
    }

    public function actionSuccessPelimpahan()
    {
      $data = json_decode($_POST['call_back']);
      foreach($data AS $key=>$_data)
      {
        Yii::$app->db->createCommand("update pidum.pdm_spdp set proses_pelimpahan = '1' where id_perkara='".$_data."'")->execute();
      }
    }

    public function actionSyncPelimpahan()
    {
      
    $ip =  Yii::$app->db->createCommand("SELECT a.id_satker_tujuan, REPLACE(b.ip,' ','')AS ip FROM pidum.pdm_spdp a 
              INNER JOIN public.ms_ip b 
                ON  b.id_satker = a.id_satker_tujuan
              WHERE a.wilayah_kerja <> a.id_satker_tujuan 
                AND a.id_satker_tujuan is not null 
                AND proses_pelimpahan = '0' 
              GROUP BY a.id_satker_tujuan,b.ip;")->queryAll();
     $countIp = count($ip);
    if($countIp>0)
    {
        foreach($ip AS $key=>$val)
         {
            $ip[$key]['data'] = json_encode(
                                array( 
                                      'spdp' => json_encode(Yii::$app->db->createCommand("SELECT * FROM pidum.pdm_spdp a WHERE a.wilayah_kerja <> a.id_satker_tujuan AND a.id_satker_tujuan is not null AND proses_pelimpahan = '0' AND a.id_satker_tujuan ='". $ip[$key]['id_satker_tujuan']."';")->queryAll()
                                        ),
                                      'p16' => ''
                                    )
                                );

         }

          $send = array (
                           'data'   => json_encode($ip),
                           'satker' =>\Yii::$app->globalfunc->getSatker()->inst_satkerkd,
                           'count'  => $countIp
                         );
         echo json_encode($send);
         
         // echo '<pre>';
        
         // $data =  array_keys($ip[0]['spdp'][0]);
         // foreach($data as $a)
         // {
         //  echo $a;
         // }
    }
    else
    {
           $send = array (
                           'data'   => '',
                           'satker' =>\Yii::$app->globalfunc->getSatker()->inst_satkerkd,
                           'count'  => $countIp
                         );
           echo json_encode($send); 
    }
       
    }
}