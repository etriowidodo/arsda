<?php
/**
 * Created by PhpStorm.
 * User: rio
 * Date: 09/04/15
 * Time: 10:57
 */

namespace app\controllers;


use app\models\P16;
use app\models\P16Search;
use Yii;
use yii\web\Controller;

class SynController extends Controller{
   public function actionIndex()
   {
      $searchModel = new P16Search();
      $searchModel->status_sinkron = '1';
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->pagination->pageSize=10;
      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
   }

   public function actionSave()
   {
      $no_p16 = $_POST['no_p16'];
      
      for($i=0;$i<count($no_p16);$i++){
         $model = P16::find()
             ->select('*')
             ->leftJoin('simkari.pdm_tersangka', 'pdm_tersangka.no_p16 = p16.no_p16')
             ->where(['p16.no_p16' => $no_p16[$i], 'p16.status_sinkron' => '1'])
             ->with('pdmTersangkas')
             ->all();

         foreach($model as $key => $value){
            echo $value['no_p16'];
            try{
               $username="simkari_baru";
               $password="bandung";
               $dbname="192.168.11.11/sismiop";
               $connection=oci_connect($username, $password, $dbname);
               $sql1="insert into PDM_PERKARA(nomor_perkara, no_p16,no_spdp, tgl_spdp, penyidik, tgl_diterima, inst_satkerkd)
                      VALUES('".$value['no_p16']."','".$value['no_p16']."','".$value['no_spdp']."',TO_DATE('".$value['tgl_spdp']."', 'yyyy/mm/dd'),'".$value['penyidik']."',TO_DATE('".$value['tgl_terima']."', 'yyyy/mm/dd'), '09.01')";

               $result=oci_parse($connection,$sql1);
               oci_execute($result);

               $array = oci_parse($connection, "SELECT max(id) FROM pdm_perkara");

               oci_execute($array);

               while ($row = oci_fetch_array($array)) {
               		$sql2="insert into PDM_TERSANGKA(nama, tempat_lahir,tgl_lahir, jkl, kewarganegaraan, alamat, id_perkara)
                          VALUES('".$value['nama']."','".$value['tempat_lahir']."',TO_DATE('".$value['tgl_lahir']."', 'yyyy/mm/dd'),'".$value['jkl']."', '".$value['kewarganegaraan']."', '".$value['alamat']."', '$row[0]')";

                        $result2=oci_parse($connection,$sql2);
                        oci_execute($result2);

                        $array1 = oci_parse($connection, "SELECT max(id) FROM pdm_tersangka");

                        oci_execute($array1);

                        /*while ($row1 = oci_fetch_array($array1)) {
                            $sql3="insert into PDM_PASAL(id_tersangka, pasal)
                          VALUES('$row1[0]','$this->pasal')";

                            $result3=oci_parse($connection,$sql3);
                            oci_execute($result3);
                        }*/

                        $modelJpu = P16::find()
			             ->select('*')
			             ->leftJoin('simkari.pdm_tim_jpu', 'pdm_tim_jpu.no_p16 = p16.no_p16')
			             ->where(['p16.no_p16' => $no_p16[$i], 'p16.status_sinkron' => '1'])
			             ->with('pdmTimJpus')
			             ->all();

			             foreach ($modelJpu as $key => $value) {
			             	$nip_jpu = $value['nip_pegawai'];
                            $sql4="insert into PDM_TIM_JPU(id_perkara, nip_pegawai)
                          VALUES('$row[0]','$nip_jpu')";

                            $result4=oci_parse($connection,$sql4);
                            oci_execute($result4);
			             }

                        /*for($i=0;$i<count($this->nip_jpu);$i++){
                            $nip_jpu = $this->nip_jpu[$i];
                            $sql3="insert into PDM_TIM_JPU(id_perkara, nip_pegawai)
                          VALUES('$row[0]','$nip_jpu')";

                            $result3=oci_parse($connection,$sql3);
                            oci_execute($result3);
                        }*/
               }

               

               $modelP16 = P16::findOne(['no_p16' => $no_p16[$i]]);
               $modelP16->status_sinkron = 0;
               $modelP16->save();
            }catch (ErrorException $e){
               if($e->getMessage()){
                  $this->status_sinkron = 1;
                  $this->save();
                  echo "<script>alert('Data gagal sinkron ke database simkari harap melakukan sinkronisasi manual'); window.location.assign('".Url::to('index')."');</script>";

               }

            }
         }
      }

   }
}