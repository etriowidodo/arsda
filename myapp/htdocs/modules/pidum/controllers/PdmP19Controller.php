<?php

namespace app\modules\pidum\controllers;
use Yii;
use yii\web\Controller;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Object;
use yii\db\Query;
use app\components\GlobalConstMenuComponent;
use app\components\ConstSysMenuComponent;
use app\modules\pidum\models\PdmP19;
use app\modules\pidum\models\PdmP19Search;
use app\modules\pidum\models\PdmP18;
use app\modules\pidum\models\PdmP24;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmPengantarTahap1;
use app\modules\pidum\models\MsTersangkaBerkas;
use app\modules\pidum\models\MsInstPenyidik;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusanP19;
use app\modules\pidum\models\PdmP18Search;
use app\modules\pidum\models\PdmTrxPemrosesan;
use app\modules\pidum\models\PdmPenandatangan;

use yii\web\UploadedFile;
use yii\data\SqlDataProvider;


/**
 * PdmP19Controller implements the CRUD actions for PdmP19 model.
 */
class PdmP19Controller extends Controller {

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
     * Lists all PdmP19 models.
     * @return mixed
     */
   public function actionIndex() {
       $berkas = Yii::$app->session->get('perilaku_berkas');
       $no_pengantar = Yii::$app->session->get('no_pengantar');
       if($berkas == ''){
           $id_perkara = Yii::$app->session->get('id_perkara');
           $query = "select
                    a.id_berkas,
                    a.tgl_berkas,
                    a.no_berkas ||' '||to_char(a.tgl_berkas,'DD-MM-YYYY') as no_tgl_berkas,
                     coalesce('' ||'No P-18 : '|| e.no_surat ||' Tgl P-18: '||to_char(e.tgl_dikeluarkan,'DD-MM-YYYY'),'-') as no_tgl_p18,
                    d.id_p24,
                    d.pendapat,
                    a.no_berkas,
                    STRING_AGG(b.nama, '<br/>' ORDER BY b.id_tersangka) as nama_tersangka,
                    c.id_pengantar,
                    c.no_pengantar,
                    to_char(c.tgl_pengantar,'DD-MM-YYYY') as tgl_pengantar,
                    to_char(c.tgl_terima,'DD-MM-YYYY') as tgl_terima,
                    e.id_p19
                    FROM
                    pidum.pdm_berkas_tahap1 a
                    INNER JOIN pidum.pdm_pengantar_tahap1 c on a.id_berkas = c.id_berkas
                    INNER JOIN pidum.ms_tersangka_berkas b on b.id_berkas = a.id_berkas
                    INNER JOIN pidum.pdm_p24 d on d.id_pengantar = c.id_pengantar
                    INNER  JOIN pidum.pdm_p19 e on e.id_pengantar = c.id_pengantar and e.id_berkas = c.id_berkas
                    WHERE d.id_hasil = '2' and a.id_perkara = '".$id_perkara ."'
                    GROUP BY
                    e.id_p19,a.id_berkas,c.id_pengantar,d.id_p24,c.no_pengantar,to_char(c.tgl_terima,'DD-MM-YYYY'),to_char(c.tgl_pengantar,'DD-MM-YYYY')
                    ,to_char(c.tgl_terima,'DD-MM-YYYY')
                    ";
            $jml            = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();
            $dataProvider   = new SqlDataProvider([
                'sql'           => $query,
                'totalCount'    => (int)$jml,
                'sort'          => [
                    'attributes' => [
                        'id_pengantar',
                        'id_p18',
                        'id_p19',
                        'id_berkas',
                        'pendapat',
                        'no_tgl_berkas',
                        'tgl_terima',
                        'nama_tersangka',
                        'noSuratp18',
                        'tglDikeluarkan18'
                     ],
                 ],
                 'pagination' => [
                     'pageSize' => 10,
                 ]
            ]);
            $models = $dataProvider->getModels();
            /*return $this->render('index', [
            'dataProvider' => $dataProvider,
            ]);*/
       }else{
        //echo '<pre>';print_r('lelelel');exit;
           $query = "select
                    a.id_berkas,
                    a.tgl_berkas,
                    a.no_berkas ||' '||to_char(a.tgl_berkas,'DD-MM-YYYY') as no_tgl_berkas,
                     coalesce('' ||'No P-18 : '|| e.no_surat ||' Tgl P-18: '||to_char(e.tgl_dikeluarkan,'DD-MM-YYYY'),'-') as no_tgl_p18,
                    d.id_p24,
                    g.id_p19,
                    d.pendapat,
                    a.no_berkas,
                    STRING_AGG(b.nama, '<br/>' ORDER BY b.id_tersangka) as nama_tersangka,
                    c.id_pengantar,
                    c.no_pengantar,
                    to_char(c.tgl_pengantar,'DD-MM-YYYY') as tgl_pengantar,
                    to_char(c.tgl_terima,'DD-MM-YYYY') as tgl_terima,
                    e.id_p18
                    FROM
                    pidum.pdm_berkas_tahap1 a
                    INNER JOIN pidum.pdm_pengantar_tahap1 c on a.id_berkas = c.id_berkas
                    INNER JOIN pidum.ms_tersangka_berkas b on b.id_berkas = a.id_berkas
                    INNER JOIN pidum.pdm_p24 d on d.id_pengantar = c.id_pengantar
                    INNER  JOIN pidum.pdm_p18 e on e.id_pengantar = c.id_pengantar and e.id_berkas = c.id_berkas
                    INNER  JOIN pidum.pdm_p19 g on e.id_pengantar = c.id_pengantar and e.id_berkas = c.id_berkas
                    WHERE d.id_hasil = '2' and a.id_berkas = '".$berkas."' and b.no_pengantar='".$no_pengantar."'
                    GROUP BY
                    e.id_p18,g.id_p19,a.id_berkas,c.id_pengantar,d.id_p24,c.no_pengantar,to_char(c.tgl_terima,'DD-MM-YYYY'),to_char(c.tgl_pengantar,'DD-MM-YYYY')
                    ,to_char(c.tgl_terima,'DD-MM-YYYY')
                    "; 
            //echo '<pre>';print_r($query);exit;
            $jml            = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();
            $dataProvider   =	new SqlDataProvider([
                'sql'           => $query,
                'totalCount'    => (int)$jml,
                'sort' => [
                    'attributes' => [
                        'id_pengantar',
                        'id_p18',
                        'id_p19',
                        'id_berkas',
                        'pendapat',
                        'no_tgl_berkas',
                        'tgl_terima',
                        'nama_tersangka',
                        'noSuratp18',
                        'tglDikeluarkan18'
                    ],
                ],
                'pagination'    => [
                    'pageSize'  => 10,
                ]
            ]);
            $models = $dataProvider->getModels();
            /*return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);*/
       }
       
       //echo '<pre>';print_r($models[0]['id_p19']);exit;
       $id_pengantar = Yii::$app->globalfunc->GetLastPengantar()->id_pengantar;
       $id_p19 = $models[0]['id_p19']== NULL ? '0' : $models[0]['id_p19'];

       return $this->redirect(['update','id_p19'=>$id_p19,'id_pengantar'=>$id_pengantar, 'id_berkas'=>$berkas]);
   }

    /**
     * Displays a single PdmP19 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
					 'model2' => $this->findModel($id),
					  'model3' => $this->findModel($id),
        ]);
    }

 public function actionGetPengantarThp1()
    {
        $id_berkas =  $_POST['id_berkas'];
        $query = "
                  select
                        a.id_berkas,
                        a.tgl_berkas,
                        c.id_pengantar,
                        d.id_p19,
                        e.id_p24,
                        coalesce(d.no_surat,'-') as no_surat,
                        a.no_berkas,
                        STRING_AGG(b.nama, '<br/>' ORDER BY b.id_tersangka) as nama_tersangka,
                        c.id_pengantar,
                        c.no_pengantar,
                        to_char(c.tgl_pengantar,'DD-MM-YYYY') as tgl_pengantar,
                        to_char(c.tgl_terima,'DD-MM-YYYY') as tgl_terima
                    FROM
                        pidum.pdm_berkas_tahap1 a
                        INNER JOIN pidum.pdm_pengantar_tahap1 c on a.id_berkas = c.id_berkas
                        INNER JOIN pidum.ms_tersangka_berkas b on b.id_berkas = a.id_berkas
                        INNER JOIN pidum.pdm_p24 e on e.id_pengantar = c.id_pengantar   AND e.id_berkas = c.id_berkas
                        INNER JOIN pidum.pdm_p18 f on f.id_berkas = a.id_berkas
                        LEFT JOIN pidum.pdm_p19 d on d.id_p18 =  f.id_p18
                    where c.id_berkas  = '".$id_berkas."'
                    GROUP BY
                        a.id_berkas,c.id_pengantar,d.id_p19,e.id_p24
                        order by c.tgl_pengantar desc  limit 1
                  ";

        $result = Yii::$app->db->createCommand($query)->queryAll();

        $data = array (
                        'count'     => count($result),
                        'result'    => str_replace("'","\'",trim(json_encode($result)))
                     );
      echo json_encode($data);
    }
    /**
     * Creates a new PdmP19 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_p19,$id_berkas) {

		 $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P19]);
        $id = Yii::$app->session->get('id_perkara');
		if($id_p19!="0"){
			$model = new PdmP19();
		}
        if ($model == null) {
            $model = new PdmP19();
        }
	$model2 = PdmP19::find()
				->where("id_perkara='".$id."' and id_berkas='".$id_berkas."' ")
				->all();
        $modelSpdp = $this->findModelSpdp($id);
        $modelTersangka = Yii::$app->db->createCommand(" select
STRING_AGG(c.nama, ', ' ORDER BY c.id_tersangka) as nama_tersangka
from pidum.pdm_berkas a
inner join pidum.pdm_tahanan_penyidik b on a.id_berkas = b.id_berkas
inner join pidum.ms_tersangka c on b.id_tersangka = c.id_tersangka
inner join pidum.pdm_p24 d on a.id_berkas = d.id_berkas
left join pidum.pdm_p19 e on a.id_berkas = e.id_berkas
where b.id_berkas is not null and b.flag <> '3' and a.flag <> '3' and d.id_ms_hasil_berkas = '3' and a.id_berkas='".$id_berkas."'
GROUP BY a.id_berkas,coalesce(e.id_p19,'0'),e.id_p19,a.no_pengiriman ||' Tgl : '||tgl_pengiriman  ")->queryScalar();
        $modelPasalBerkas = Yii::$app->globalfunc->getAlternativePasal($id);
        $modelBerkas = PdmBerkas::findOne(['id_perkara' => $id]);

	if($id_p19!=null or $id_p19!="0"){


        if ($model->load(Yii::$app->request->post())) {

            $model->attributes = \Yii::$app->request->post('PdmP19');
            $p24 = PdmP24::findOne(['id_berkas' => $id_berkas]);
          $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p19', 'id_p19', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            // $NextProcces = array(ConstSysMenuComponent::P20,ConstSysMenuComponent::P22);
            // Yii::$app->globalfunc->getNextProcces($model->id_perkara,$NextProcces);

                $model->id_perkara = $id;
                $model->id_p19 = $seq['generate_pk'];
                $model->id_p24 = $p24->id_p24;
				$model->id_berkas = $id_berkas;

								//print_r($model);exit;
                $model->save();
                //Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::P19);



            if (isset($_POST['new_tembusan'])) {
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::P19]);
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                    $modelNewTembusan = new PdmTembusan();
                    $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                    $modelNewTembusan->id_table = $model->id_p19;
                    $modelNewTembusan->kode_table = GlobalConstMenuComponent::P19;
                    $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                    $modelNewTembusan->id_perkara = $model->id_perkara;
                    $modelNewTembusan->nip = null;
                    $modelNewTembusan->save();
                }
            }

            //notifkasi simpan
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

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
						'model2' => $model2,
                        'modelPasalBerkas' => $modelPasalBerkas,
                        'modelTersangka' => $modelTersangka,
                        'modelBerkas' => $modelBerkas,
                        'modelSpdp' => $modelSpdp,
                        'sysMenu' => $sysMenu
            ]);
        }
	}

    }

    /**
     * Updates an existing PdmP19 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_p19,$id_pengantar,$id_berkas) {
        require(Yii::$app->basePath .'/web/richtexteditor/include_rte.php');
        $ex_id = explode('|', $id_pengantar);
        //echo '<pre>';print_r($ex_id);exit;
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P19]);
        $id = Yii::$app->session->get('id_perkara');


		if($id_p19!=""){
			$model = PdmP19::find()
				->where("id_pengantar='".$id_pengantar."' and id_p19='".$id_p19."'")
				->one();
		}

        if ($model == null) {
            $model = new PdmP19();
			$file_lama1 = '';
			$file_lama2 = '';
        }else{
			$file_lama1 = $model->getOldAttributes()['file_upload_petunjuk_p19'];
			$file_lama2 = $model->getOldAttributes()['file_upload_p19'];
		}

        $modelSpdp = $this->findModelSpdp($id);
        /*$modelTersangka     = MsTersangkaBerkas::find()
                              ->where (['id_berkas' => $id_berkas])
                              ->all();*/
        $modelTersangka = MsTersangkaBerkas::find()->where(['id_berkas' => $ex_id[0], 'no_pengantar'=> $ex_id[1]])->orderBy(['no_urut'=>sort_asc])->all();
        $modelBerkas        = PdmBerkasTahap1::findOne(['id_perkara' => $id,'id_berkas'=>$id_berkas]);

		$modelPengantar     = PdmPengantarTahap1::findOne(['id_pengantar' => $id_pengantar]);

        $modelInsPenyidik   = MsInstPenyidik::findOne(['kode_ip' => $modelSpdp->id_asalsurat]);
        $modelP18           = PdmP18::findOne(['id_berkas' => $id_berkas]);
	    $countP19           = PdmP19::findAll(['id_berkas' => $id_berkas]);


        if ($model->load(Yii::$app->request->post())) {
            $model->attributes = \Yii::$app->request->post('PdmP19');

			$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_berkas_tahap1 WHERE id_perkara='".$id."' ")->queryOne();

            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p19', 'id_p19', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            $ttd = $model->id_penandatangan;
                    //echo $ttd;exit;
            $seqttd = Yii::$app->db->createCommand("select * from pidum.vw_penandatangan where peg_nip_baru = '".$ttd."' ")->queryOne();
            $model->nama    = $seqttd['nama'];
            $model->pangkat = $seqttd['pangkat'];
            $model->jabatan = $seqttd['jabatan'];
            $files1 = UploadedFile::getInstance($model, 'file_upload_petunjuk_p19');

            $files2 = UploadedFile::getInstance($model, 'file_upload_p19');



            if(!isset($_POST['PdmP19']['is_split']))
                {
                  $model->is_split = '0';
                }

			if ($files1 != false && !empty($files1) ) {
				if($file_lama1 !=''){
					$model->file_upload_petunjuk_p19 = $file_lama1;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/'.$file_lama1;
					$files1->saveAs($path);
				}else{
					$model->file_upload_petunjuk_p19 = preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p19Petunjuk_'.$jml_pt['jml'].'.'. $files1->extension;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p19Petunjuk_'.$jml_pt['jml'].'.'.$files1->extension;
					$files1->saveAs($path);
				}
			}else{
				$model->file_upload_petunjuk_p19 = $file_lama1;
			}

		if ($files2 != false && !empty($files2) ) {
				if($file_lama2 !=''){
					$model->file_upload_p19 = $file_lama2;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/'.$file_lama2;
					$files2->saveAs($path);
				}else{
					$model->file_upload_p19 = preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p19_'.$jml_pt['jml'].'.'. $files2->extension;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p19_'.$jml_pt['jml'].'.'.$files2->extension;
					$files2->saveAs($path);
				}
			}else{
				$model->file_upload_p19 = $file_lama2;
			}


          if($id_p19 == 0 || $model->id_p19 == null)
          {
              $id_perkara_p19 = Yii::$app->session->get('id_perkara');
              $NextProcces = array(ConstSysMenuComponent::P20,  ConstSysMenuComponent::P22);
              Yii::$app->globalfunc->getNextProcces($id_perkara_p19,$NextProcces);
		      }


      $model->id_p19       =  $modelP18->id_p18."|".$_POST['PdmP19']['no_surat'];
      $model->id_p18       =  $modelP18->id_p18;
      $model->id_berkas    =  $id_berkas;
      $model->id_pengantar =  $id_pengantar;
      // var_dump($model->id_p18 );exit;

		  if(!$model->save()){
			  var_dump($model->getErrors());exit;
		  }


            if (isset($_POST['new_tembusan'])) {
				$id_p19 = $modelP18->id_p18."|".$_POST['PdmP19']['no_surat'];
                PdmTembusanP19::deleteAll(['id_p19'=>$id_p19]);

                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {

                    $modelNewTembusan = new PdmTembusanP19();
					$modelNewTembusan->id_tembusan = $id_p19."|".($i+1);
                    $modelNewTembusan->id_p19= $id_p19;
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                     if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
                }
            }

            //notifkasi simpan
                if(!isset($_POST['updateToPrint'])&&!isset($_POST['saveToPrint']))
                {
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil Disimpan', // String
                        'title' => 'Save', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['index']);
                }
                else
                {
                    if(isset($_POST['saveToPrint']))
                    {

                        echo '<script>
                                    window.open(\'cetak?id='.$seq['generate_pk'].'&id_pengantar='.$id_pengantar.'\',"_self");
                                    setTimeout(function(){ window.location = \'update?id_p19='.$seq['generate_pk'].'&id_pengantar='.$id_pengantar.'&id_berkas='.$id_berkas.'\'; }, 500);
                             </script>';
                        //return $this->redirect(['index']);
                    }
                    if(isset($_POST['updateToPrint']))
                    {

                        echo '<script>
                                    window.open(\'cetak?id='.$id_p19.'&id_pengantar='.$id_pengantar.'\',"_self");
                                    setTimeout(function(){ window.location = \'update?id_p19='.$id_p19.'&id_pengantar='.$id_pengantar.'&id_berkas='.$id_berkas.'\'; }, 500);
                             </script>';
                        //return $this->redirect(['index']);
                    }
                }
        }
         else
        {
            return $this->render('update', [
                'model'             => $model,
                'dataProvider'      => $dataProvider,
    			      'modelInsPenyidik'  => $modelInsPenyidik,
                'modelPengantar'    => $modelPengantar,
                'modelTersangka'    => $modelTersangka,
                'modelBerkas'       => $modelBerkas,
                'modelSpdp'         => $modelSpdp,
                'sysMenu'           => $sysMenu,
                'modelP18'          => $modelP18,
                'countP19'          => $countP19
            ]);
        }
    }

    /**
     * Deletes an existing PdmP19 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmP19 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP19 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP19::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        } /* else {
          throw new NotFoundHttpException('The requested page does not exist.');
          } */
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist2.');
        }
    }

    public function actionCetak($id,$id_pengantar) {

        $ex_id = explode('|', $id_pengantar);
        //echo '<pre>';print_r($ex_id[1]);exit;

        $connection = \Yii::$app->db;

		$id_perkara = Yii::$app->session->get('id_perkara');

        $model = PdmP19::findOne(['id_p19' => $id]);


        $odf = new \Odf(Yii::$app->params['report-path'] . "web/template/pidum/p19.odt");

$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p19 b','a.peg_nik = b.id_penandatangan')
->where ("id_p19='".$id."'")
->one();

$ttd = PdmPenandatangan::find()
->select ("a.nama as nama,a.pangkat as pangkat,a.peg_nik as peg_nik")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p19 b','a.peg_nik = b.id_penandatangan')
->where ("id_p19='".$id."'")
->one();
        $berkas = PdmBerkasTahap1::findOne(['id_berkas' => $model->id_berkas]);
        $p18 = PdmP18::findOne(['id_p18' => $model->id_p18]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        $pengantar = PdmPengantarTahap1::findOne(['id_pengantar' => trim($id_pengantar) ]);

		$listTersangka = Yii::$app->db->createCommand(" select a.nama FROM pidum.ms_tersangka_berkas a WHERE a.id_berkas='".$model->id_berkas."' ORDER BY a.no_urut asc  ")->queryAll();

			 if (count($listTersangka) == 1) {
            foreach ($listTersangka as $key) {
				$nama_tersangka = ucfirst(strtolower($key[nama])) ;
			}
        } else if(count($listTersangka) == 2){
			 $i=1;
			 foreach ($listTersangka as $key) {
				if($i==1){
					$nama_tersangka = ucfirst(strtolower($key[nama]))." dan " ;
				}else{
					$nama_tersangka .= ucfirst(strtolower($key[nama])) ;
				}
				$i++;
			 }
		}else {
            foreach ($listTersangka as $key) {
				$i=1;
				if($i==1){
					$nama_tersangka = ucfirst(strtolower($key[nama]))." dkk. " ;
				}
			}
        }


       $sifat = \app\models\MsSifatSurat::findOne(['id'=>$model->sifat]);

        $kode=$spdp->wilayah_kerja;
        if ($kode='00'){
            $odf->setVars('Kejaksaan', 'JAKSA AGUNG MUDA TINDAK PIDANA UMUM');
            //$odf->setVars('kepala','');
        }   else {
            $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
            //$odf->setVars('kepala','KEPALA');
        }
        $odf->setVars('kepala', $model->jabatan);
        $odf->setVars('nomor', $model->no_surat);
        $odf->setVars('sifat', $sifat->nama);
        $odf->setVars('lampiran', $model->lampiran);
        //$odf->setVars('tersangka',$modelTersangka);
	      //$petunjuk_pentunjuk = htmlspecialchars_decode();

        $html =  new ClassHtml2Text($model->petunjuk);
        // echo $html->getText();
        // // echo $text;
        // exit;


        $undangx = Yii::$app->globalfunc->getPasalTahap1H($id_pengantar);
        //echo '<pre>';print_r($undangx);exit;
        $odf->setVars('kepada', $model->kepada);
        $odf->setVars('di_tempat', $model->di_kepada);
        $odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
        $odf->setVars('petunjuk',$html->getText());
        $odf->setVars('pasal', $undangx);
        $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
        $odf->setVars('nomorP18', $p18->no_surat);
        $odf->setVars('tanggalP18', Yii::$app->globalfunc->ViewIndonesianFormat($p18->tgl_dikeluarkan));
        $odf->setVars('nomorpengirimanberkas', $berkas->no_berkas);
        $odf->setVars('tanggalpengirimanberkas', Yii::$app->globalfunc->ViewIndonesianFormat($berkas->tgl_berkas));
        $odf->setVars('tanggalterimapengirimanberkas', Yii::$app->globalfunc->ViewIndonesianFormat($pengantar->tgl_terima));


        $odf->setVars('tersangka_lampiran', $nama_tersangka);

        $odf->setVars('tersangka', $nama_tersangka);

        #penanda tangan
        $sql = "SELECT * FROM  "
               . " pidum.pdm_p19 "
              . "where   id_p19='" .$id. "'";
        $sql = $connection->createCommand($sql);
        $penandatangan = $sql->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $odf->setVars('pangkat', preg_replace("/\/ (.*)/", "", $penandatangan['pangkat']));
        $odf->setVars('nip_penandatangan', $penandatangan['id_penandatangan']);



        #tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_p19')
                ->where("id_p19 = '" . $model->id_p19 . "'");
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($element['no_urut']);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);
  //print_r($odf);
  //print_r($modelTersangka);exit;

        $odf->exportAsAttachedFile('P19.odt');

    }

}
