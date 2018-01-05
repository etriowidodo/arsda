<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\PenandatanganSurat;
use app\modules\pengawasan\models\PenandatanganSuratSearch;
use app\modules\pengawasan\models\JabatanMaster;
use app\modules\pengawasan\models\JabatanMasterSearch;
use app\modules\pengawasan\models\PenandatanganDetail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class PenandatangansuratController extends Controller
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
     * Lists all InspekturModel models.
     * @return mixed
     */
    public function actionIndex()
    {
      $keyWord  = htmlspecialchars($_GET['PenandatanganSuratSearch']['id_surat'], ENT_QUOTES);
        $query = " SELECT a.id_penandatangan_surat,a.id_surat,a.nip, c.nama_penandatangan as nama_penandatangan, c.jabatan_penandatangan as jabatan, 
           c.golongan_penandatangan as gol_kd, c.pangkat_penandatangan as gol_pangkat2
           FROM was.penandatangan_surat a
      INNER JOIN was.penandatangan c ON a.nip::text = c.nip::text";
        
        if($_GET['PenandatanganSuratSearch']['id_surat']!=''){
        $query .=" And (upper(a.id_surat) like'%".strtoupper($keyWord)."%'";
        $query .=" Or upper(a.nip) like'%".strtoupper($keyWord)."%'";
        $query .=" or upper(c.nama_penandatangan) like'%".strtoupper($keyWord)."%')";
        // $query .=" Or upper(b.nama) like'%".strtoupper($keyWord)."%')";
        }
        
        $query .=" order by a.id_surat, c.unitkerja_kd";
      $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();
    $searchModel=new PenandatanganSuratSearch();

    $dataProvider = new SqlDataProvider([
      'sql' => $query,
      'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'id_surat',
              'nip',
              'nama',
              'nama'
              
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);
        $models = $dataProvider->getModels();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
        // $searchModel = new PenandatanganSuratSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
    }

    /**
     * Displays a single InspekturModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionGetdetail()
    {

      $id=split(',', $_POST['id']);
      $id_surat=split('#', $_POST['id_surat']);
      // echo strlen($_POST['unitkerja_kd']);
      $connection = \Yii::$app->db;
      $sql="select distinct a.nip, c.jabatan_penandatangan, c.nama_penandatangan 
              from 
                was.penandatangan_surat a 
              inner join 
                was.was_jabatan b on b.id_jabatan=a.id_jabatan 
              inner join 
                was.penandatangan c on a.nip=c.nip
              where 
                a.id_jabatan in('".$id[0]."','".$id[1]."','".$id[2]."') and a.id_surat='".$id_surat[0]."'";
              
                if($id_surat[1]=='28' and $id_surat[0]=='was1' and strlen($_POST['unitkerja_kd'])=='9'){
              $sql .=" and substring(a.unitkerja_kd,1,7)='".substr($_POST['unitkerja_kd'],0, 7)."' and kode_level='28'";
                }else if($id_surat[1]=='28' and $id_surat[0]=='was1' and  strlen($_POST['unitkerja_kd'])=='10'){
              $sql .=" and substring(a.unitkerja_kd,1,8)='".substr($_POST['unitkerja_kd'],0, 8)."' and kode_level='28'";
                }

               if($id_surat[1]=='44' and $id_surat[0]=='was1' and strlen($_POST['unitkerja_kd'])=='7'){
              $sql .=" and substring(a.unitkerja_kd,1,5)='".substr($_POST['unitkerja_kd'],0, 5)."' and kode_level='44'";
                }else if($id_surat[1]=='44' and $id_surat[0]=='was1' and  strlen($_POST['unitkerja_kd'])=='8'){
              $sql .=" and substring(a.unitkerja_kd,1,6)='".substr($_POST['unitkerja_kd'],0, 6)."' and kode_level='44'";
                }


      $result_query=$connection->createCommand($sql)->queryAll();
      $no=1;
            foreach ($result_query as $key) {
              echo '<tr>
              <td>'.$no.'</td>
              <td>'.$key['nip'].'</td>
              <td>'.$key['nama_penandatangan'].'</td>
              <td>'.$key['jabatan_penandatangan'].'</td>
              </tr>';
            $no++;
            }
    }

    /**
     * Creates a new InspekturModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PenandatanganSurat();
            $jabtan_alias=['AN','Plh','Plt'];
            $jabtan_alias_kode=['101','201','301','001'];
           

        if ($model->load(Yii::$app->request->post())){
          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          try {
            $model->id_jabatan=$jabtan_alias_kode[3];
            $model->unitkerja_kd=$_POST['unitkerja_kd'];
            $model->id_surat=$_POST['PenandatanganSurat']['id_surat'];
            $model->save();

            for ($i=0; $i < count($_POST['nip_alias']); $i++) { 
            for ($x=0; $x < 3; $x++) { 
                // echo $_POST['jabtan1'][$x];
                $modeldetail = new PenandatanganDetail();
                $modeldetail->id_penandatangan_surat=$model->id_penandatangan_surat;
                $modeldetail->nip_penandatangan=$_POST['nip_alias'][$i];
                $modeldetail->kode_jabatan=$jabtan_alias_kode[$x];
                $modeldetail->akronim=$jabtan_alias[$x];
                $modeldetail->jbtn_alias_panjang=$jabtan_alias[$x].' '.$_POST['jabatan_asli'];
                $modeldetail->jabatan_asli=$_POST['jabatan_alias'][$i];
                $modeldetail->unitkerja_kd=$_POST['unitkerja_kd_alias'][$i];
                $modeldetail->unitkerja_alias=$_POST['unitkerja_kd'];
                $modeldetail->save();
               }
            }
               $transaction->commit();
            return $this->redirect(['index']);
          } catch (Exception $e) {
               $transaction->rollback();
                if(YII_DEBUG){throw $e; exit;} else{return false;}
          }
         
        }   else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InspekturModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel2($id);

        $connection = \Yii::$app->db;
            $query = "select a.id_surat, a.nip, a.id_jabatan, b.nama from was.penandatangan_surat a inner join was.was_jabatan b on a.id_jabatan=b.id_jabatan where a.id_surat='".$id."' and a.nip='".$nip."' and a.id_jabatan='".$idjab."'";
            // $query = "select a.nama from was.was_jabatan a inner join was.penandatangan_surat b on a.id_jabatan=b.id_jabatan where a.id_surat='".$id."'";
            $query2 = "select a.nip, b.nama_penandatangan,b.jabatan_penandatangan, a.unitkerja_kd from was.penandatangan_surat a inner join was.penandatangan b on a.nip=b.nip where a.nip='".$nip."'";
            $nama_ttd = $connection->createCommand($query2)->queryOne();
            $query_alias=" SELECT distinct a.nip_penandatangan AS nip, c.nama as nama_penandatangan, a.jabatan_asli AS jabatan_asli,a.unitkerja_kd
           FROM was.penandatangan_detail a
            JOIN was.penandatangan_surat b ON a.id_penandatangan_surat = b.id_penandatangan_surat
            JOIN kepegawaian.kp_pegawai c ON a.nip_penandatangan::text = c.peg_nip_baru::text
          where a.id_penandatangan_surat='".$id."'";
           /*di off dulu*/
            // /*ini untuk was1 pemeriksa*/
            // if($model['id_surat']=='was1' and $model['kode_level']=='28' and strlen($model['unitkerja_kd'])=='9'){
            // $query_alias .=" and substring(a.unitkerja_kd,1,7)='".substr($model['unitkerja_kd'],0,7 )."' 
            //          and b.kode_level='".$model['kode_level']."' 
            //          and a.nip<>'".$model['nip']."'";
            // }else if($model['id_surat']=='was1' and $model['kode_level']=='28' and strlen($model['unitkerja_kd'])=='10'){
            // $query_alias .=" and substring(a.unitkerja_kd,1,8)='".substr($model['unitkerja_kd'],0,8 )."' 
            //          and b.kode_level='".$model['kode_level']."' 
            //          and a.nip<>'".$model['nip']."'";
            // }

            // /*ini untuk was1 IRMUD*/
            // if($model['id_surat']=='was1' and $model['kode_level']=='44' and strlen($model['unitkerja_kd'])=='7'){
            // $query_alias .=" and substring(a.unitkerja_kd,1,5)='".substr($model['unitkerja_kd'],0,5 )."' 
            //          and b.kode_level='".$model['kode_level']."' 
            //          and a.nip<>'".$model['nip']."'";
            // }else if($model['id_surat']=='was1' and $model['kode_level']=='44' and strlen($model['unitkerja_kd'])=='8'){
            // $query_alias .=" and substring(a.unitkerja_kd,1,6)='".substr($model['unitkerja_kd'],0,6 )."' 
            //          and b.kode_level='".$model['kode_level']."' 
            //          and a.nip<>'".$model['nip']."'";
            // }

            // /*ini untuk was1 INSPEKTUR*/
            // if($model['id_surat']=='was1' and $model['kode_level']=='7'){
            // $query_alias .=" and b.kode_level='".$model['kode_level']."' 
            //          and a.nip<>'".$model['nip']."'";
            // }
            
            $result_alias = $connection->createCommand($query_alias)->queryAll();

            $jbtn = $connection->createCommand($query)->queryOne();
            $jabtan_alias=['AN','Plh','Plt'];
            $jabtan_alias_kode=['101','201','301','001'];

        if ($model->load(Yii::$app->request->post())){

           // // $model->save();
           //       // PenandatanganSurat::deleteAll("id_jabatan = '310' and nip='197001311998032001'");
           // for ($i=0; $i < count($_POST['nip_alias']); $i++) { 
           //     for ($x=0; $x < 3; $x++) { 
           //       PenandatanganSurat::deleteAll("id_jabatan = '".$_POST['jabatan2'][$x]."' and nip='".$_POST['nip_alias'][$i]."'");
           //      // echo $_POST['jabatan2'][$x];
           //      // echo $_POST['nip_alias'][$i];
                
           //      $modeldetail = new PenandatanganSurat();
           //      $modeldetail->id_surat=$_POST['PenandatanganSurat']['id_surat'];
           //      $modeldetail->nip=$_POST['nip_alias'][$i];
           //      $modeldetail->id_jabatan=$_POST['jabatan2'][$x];
           //      $modeldetail->unitkerja_kd=$_POST['unitkerja_kd_alias'][$i];
           //      $modeldetail->save();

           //     }
           //  }

          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          try {
            $model->id_jabatan=$jabtan_alias_kode[3];
            $model->unitkerja_kd=$_POST['unitkerja_kd'];
            $model->id_surat=$_POST['PenandatanganSurat']['id_surat'];
            $model->save();

            PenandatanganDetail::deleteAll(['id_penandatangan_surat'=>$model->id_penandatangan_surat]);
            for ($i=0; $i < count($_POST['nip_alias']); $i++) { 
            for ($x=0; $x < 3; $x++) { 
                // echo $_POST['jabtan1'][$x];
                $modeldetail = new PenandatanganDetail();
                $modeldetail->id_penandatangan_surat=$model->id_penandatangan_surat;
                $modeldetail->nip_penandatangan=$_POST['nip_alias'][$i];
                $modeldetail->kode_jabatan=$jabtan_alias_kode[$x];
                $modeldetail->akronim=$jabtan_alias[$x];
                $modeldetail->jbtn_alias_panjang=$jabtan_alias[$x].' '.$_POST['jabatan_asli'];
                $modeldetail->jabatan_asli=$_POST['jabatan_alias'][$i];
                $modeldetail->unitkerja_kd=$_POST['unitkerja_kd_alias'][$i];
                $modeldetail->unitkerja_alias=$_POST['unitkerja_kd'];
                $modeldetail->save();
               }
            }
               $transaction->commit();
            return $this->redirect(['index']);
          } catch (Exception $e) {
               $transaction->rollback();
                if(YII_DEBUG){throw $e; exit;} else{return false;}
          }
            // return $this->redirect(['view', 'id' => $model->id_inspektur]);
            // return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'jbtn' => $jbtn,
                'nama_ttd' => $nama_ttd,
                'result_alias' => $result_alias,
            ]);
        }
    }

    /**
     * Deletes an existing InspekturModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {

      echo $_POST['jml'];
      $pecah=explode(',', $_POST['id']);
        //Yii::$app->controller->enableCsrfValidation = false;
        //print_r($_POST);
        // if(count($_POST['id'])>0){
            for ($i=0; $i < $_POST['jml']; $i++) { 
              # code...
            // foreach ($_POST['id'] as $key => $value) {
                // $this->findModel2($value)->delete();
                PenandatanganSurat::deleteAll(['id_penandatangan_surat'=>$pecah[$i]]);
                PenandatanganDetail::deleteAll(['id_penandatangan_surat'=>$pecah[$i]]);
            // return $this->redirect(['index']);
            // }
            // }
        }
        // $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InspekturModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InspekturModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PenandatanganSurat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel2($id)
    {
        if (($model = PenandatanganSurat::findBySql("select*from was.penandatangan_surat a inner join was.penandatangan b on a.nip=b.nip where a.id_penandatangan_surat='".$id."'")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
