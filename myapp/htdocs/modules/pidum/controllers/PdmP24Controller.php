<?php

namespace app\modules\pidum\controllers;

use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\PdmJaksaP16;
use app\modules\pidum\models\PdmJpu;
use app\modules\pidum\models\PdmP16;
use app\modules\pidum\models\PdmP17;
use app\modules\pidum\models\PdmP24;
use app\modules\pidum\models\PdmP24Search;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmBerkas;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\MsTersangkaBerkas;
use app\modules\pidum\models\PdmCeklistTahap1;
use app\modules\pidum\models\PdmPengantarTahap1;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\db\Connection;
use yii\db\Expression;
use yii\di\Instance;
use yii\data\SqlDataProvider;
//use app\modules\pidum\models\PdmP16;

/**
 * PdmP24Controller implements the CRUD actions for PdmP24 model.
 */
class PdmP24Controller extends Controller
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
     * Lists all PdmP24 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id_berkas = Yii::$app->session->get('id_berkas');
        $berkas = Yii::$app->session->get('perilaku_berkas');
        $no_pengantar = Yii::$app->session->get('no_pengantar');
        $berkasdanpengantar = $id_berkas.'|'.$no_pengantar;
//        echo $berkasdanpengantar;exit();
        if($no_pengantar == ''){
            if($berkas == ''){
                $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P24]);
                $id_perkara     = Yii::$app->session->get('id_perkara');
                //$searchModel = new PdmP24Search();
                //$dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);
                $query = "select
                        a.id_berkas,
                        to_char(a.tgl_berkas,'dd-mm-YYYY') as tgl_berkas,
                        a.no_berkas,
                        STRING_AGG(b.nama, '<br/>' ORDER BY b.no_urut ) as nama_tersangka
                        FROM
                        pidum.pdm_berkas_tahap1 a
                        INNER JOIN pidum.pdm_pengantar_tahap1 c on a.id_berkas = c.id_berkas
                        INNER JOIN pidum.ms_tersangka_berkas b on b.id_berkas = a.id_berkas
                        INNER JOIN pidum.pdm_ceklist_tahap1 d on a.id_berkas = d.id_berkas
                        where
                        a.id_perkara = '".$id_perkara."'
                        GROUP BY
                        a.id_berkas
                        ";
                $jml            = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();
                $dataProvider   = new SqlDataProvider([
                    'sql'           => $query,
                    'totalCount'    => (int)$jml,
                    'sort'          => [
                        'attributes' => [
                            'id_berkas',
                            'no_berkas',
                            'tgl_berkas',
                            'nama_tersangka',
                         ],
                    ],
                    'pagination' => [
                        'pageSize' => 10,
                    ]
                ]);
                $models = $dataProvider->getModels();
                return $this->render('index', [
                    'dataProvider'  => $dataProvider,
                    'sysMenu'       => $sysMenu,
                ]);
            }else{
                $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P24]);
                $id_perkara = Yii::$app->session->get('id_perkara');
                //$searchModel = new PdmP24Search();
                //$dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);
                $query = "select
                        a.id_berkas,
                        to_char(a.tgl_berkas,'dd-mm-YYYY') as tgl_berkas,
                        a.no_berkas,
                        STRING_AGG(b.nama, '<br/>' ORDER BY b.no_urut ) as nama_tersangka
                        FROM
                        pidum.pdm_berkas_tahap1 a
                        INNER JOIN pidum.pdm_pengantar_tahap1 c on a.id_berkas = c.id_berkas
                        INNER JOIN pidum.ms_tersangka_berkas b on b.id_berkas = a.id_berkas
                        INNER JOIN pidum.pdm_ceklist_tahap1 d on a.id_berkas = d.id_berkas
                        where
                        a.id_berkas = '".$berkas."'
                        GROUP BY
                        a.id_berkas
                        ";
                $jml            = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();
                $dataProvider   = new SqlDataProvider([
                    'sql'           => $query,
                    'totalCount'    => (int)$jml,
                    'sort' => [
                        'attributes' => [
                            'id_berkas',
                            'no_berkas',
                            'tgl_berkas',
                            'nama_tersangka',
                        ],
                    ],
                    'pagination'    => [
                        'pageSize' => 10,
                    ]
                ]);
                $models = $dataProvider->getModels();
                return $this->render('index_1', [
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu,
                ]);
            }
        }else{
            return $this->redirect(['../pidum/pdm-p24/create?id_pengantar='.$berkasdanpengantar]);
        }
    }

    /**
     * Displays a single PdmP24 model.
     * @param string $id
     * @return mixed
     */
   /* public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Creates a new PdmP24 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_pengantar)
    {
//        echo $id_pengantar;exit();    
        $ex_id = explode('|', $id_pengantar);
        $id_p24         = PdmP24::findOne(['id_p24'=> $id_pengantar]);
//        echo $id_p24->id_p24;exit();
        if ($id_p24->id_p24 == ''){
            $id_perkara     = Yii::$app->session->get('id_perkara');
            $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P24]);
            $id_perkara     = Yii::$app->session->get('id_perkara');
            $modelBerkas    = $this->findModelBerkas($id_pengantar)[0];

            $modelSpdp      = $this->findModelSpdp($id_perkara);
            $modelP16       = Yii::$app->globalfunc->GetLastP16();
            $modelCeklis    = PdmCeklistTahap1::findOne(['no_pengantar'=>$modelBerkas['no_pengantar']])->tgl_selesai;
            $modelCeklis1   = PdmCeklistTahap1::findOne(['id_ceklist'=>$id_pengantar]);
    //        echo (explode(",", $modelCeklis1->id_pendapat_jaksa));exit;
            $modelJpu       = PdmJaksaP16::find()->where(['id_p16' => $modelP16->id_p16])->orderBy('no_urut asc')->all();
            $model          = new PdmP24();
            $modelGridTersangka = MsTersangkaBerkas::find()->where(['id_berkas' => $ex_id[0], 'no_pengantar'=>$ex_id[1]])->orderBy(['no_urut'=>sort_asc])->all();

            if ($model->load(Yii::$app->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                $ttd=$_POST['idttd'];
                $data_ttd                   = Yii::$app->db->createCommand("SELECT * FROM pidum.vw_jaksa_penuntut WHERE peg_nip_baru='".$ttd."' ")->queryOne();
                $model->id_p24              = $modelBerkas['id_berkas']."|".$modelBerkas['no_pengantar'];
                $model->id_penandatangan    = $ttd;
                $model->id_berkas           = $modelBerkas['id_berkas'];
                $model->no_pengantar        = $modelBerkas['no_pengantar'];
                $model->id_pengantar        = $id_pengantar;
                $model->nama                = $data_ttd['peg_nama'];
                $model->pangkat             = $data_ttd['pangkat'];
                $model->jabatan             = $data_ttd['jabatan'];
                $model->file_upload         = $_POST['PdmP24']['file_upload']; 

                if($_POST['PdmP24']['id_pendapat']== '1' && $_POST['PdmP24']['saran_disetujui']=='1' && $_POST['PdmP24']['petunjuk_disetujui']=='1'){ //Lengkap
                $NextProcces = array(ConstSysMenuComponent::P21);
                Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);

                $model->id_hasil            ='1';

                }else if($_POST['PdmP24']['id_pendapat']== '1' && $_POST['PdmP24']['saran_disetujui']=='0' && $_POST['PdmP24']['petunjuk_disetujui']=='0'){ //Lengkap
                    $NextProcces = array(ConstSysMenuComponent::P21);
                    Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
                                    $model->id_hasil='1';
                }else if($_POST['PdmP24']['id_pendapat']== '2' && $_POST['PdmP24']['saran_disetujui']=='1' && $_POST['PdmP24']['petunjuk_disetujui']=='0'){ //Lengkap
                    $NextProcces = array(ConstSysMenuComponent::P21);
                    Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
                                    $model->id_hasil='1';
                }else if($_POST['PdmP24']['id_pendapat']== '2' && $_POST['PdmP24']['saran_disetujui']=='0' && $_POST['PdmP24']['petunjuk_disetujui']=='1'){ //Lengkap
                    $NextProcces = array(ConstSysMenuComponent::P21);
                    Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
                                    $model->id_hasil='1';
                }else if ($_POST['PdmP24']['id_pendapat']== '1' && $_POST['PdmP24']['saran_disetujui']=='1' && $_POST['PdmP24']['petunjuk_disetujui']=='0'){// Pemeriksaan tambahan P-22
                    $NextProcces = array(ConstSysMenuComponent::P18,  ConstSysMenuComponent::P19);
                    Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
                                    $model->id_hasil='2';
                }else if ($_POST['PdmP24']['id_pendapat']== '1' && $_POST['PdmP24']['saran_disetujui']=='0' && $_POST['PdmP24']['petunjuk_disetujui']=='1'){// Pemeriksaan tambahan P-22
                    $NextProcces = array(ConstSysMenuComponent::P18,  ConstSysMenuComponent::P19);
                    Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
                                    $model->id_hasil='2';
                }else if ($_POST['PdmP24']['id_pendapat']== '2' && $_POST['PdmP24']['saran_disetujui']=='1' && $_POST['PdmP24']['petunjuk_disetujui']=='1'){// Pemeriksaan tambahan P-22
                    $NextProcces = array(ConstSysMenuComponent::P18,  ConstSysMenuComponent::P19);
                    Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
                                    $model->id_hasil='2';
                }else if ($_POST['PdmP24']['id_pendapat']== '2' && $_POST['PdmP24']['saran_disetujui']=='0' && $_POST['PdmP24']['petunjuk_disetujui']=='0'){// Pemeriksaan tambahan P-22
                    $NextProcces = array(ConstSysMenuComponent::P18,  ConstSysMenuComponent::P19);
                    Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
                                    $model->id_hasil='2';
                }else{
                                    echo "KOSONG";exit;
                            }
//                echo '<pre>';print_r($model);exit();
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
                return $this->redirect('index');

                // return $this->redirect(['view', 'id' => $model->id_p24]);
            } else {
                return $this->render('create', [
                    'model'             => $model,
                    'modelSpdp'         => $modelSpdp,
                    'sysMenu'           => $sysMenu,
                    'modelJpu'          => $modelJpu,
                    'modelBerkas'       => $modelBerkas,
                    'modelP16'          => $modelP16,
                    'modelGridTersangka' => $modelGridTersangka,
                    'modelCeklis'       => $modelCeklis,
                    'id_pengantar'       => $id_pengantar,
                    'modelCeklis1'      => $modelCeklis1
                ]);
            }
        } else {
            return $this->redirect(['../pidum/pdm-p24/update?id_p24='.$id_p24->id_p24.'& id_pengantar='.$id_p24->id_p24]);
        }
    }

    /**
     * Updates an existing PdmP24 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionGetPengantarThp1()
    {
        $id_berkas =  $_POST['id_berkas'];
        $query = "select
                        a.id_berkas,
                        a.tgl_berkas,
                        d.id_p24,
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
                        LEFT JOIN pidum.pdm_p24 d on d.id_pengantar = c.id_pengantar
                    where c.id_berkas  = '".$id_berkas."'
                    GROUP BY
                        a.id_berkas,c.id_pengantar,d.id_p24 
                        order by c.id_pengantar desc  limit 1
                  ";

        $result = Yii::$app->db->createCommand($query)->queryAll();

        $data = array (
                        'count'     => count($result),
                        'result'    => str_replace("'","\'",trim(json_encode($result)))
                     );
      echo json_encode($data);
    }

    public function actionUpdate($id_p24,$id_pengantar){
		$id_perkara       = Yii::$app->session->get('id_perkara');
        $ex_id = explode('|', $id_pengantar);
		$modelP16         = Yii::$app->globalfunc->GetLastP16();
		$modelBerkas      = $this->findModelBerkas($id_pengantar)[0];
		$modelGridTersangka = MsTersangkaBerkas::find()->where(['id_berkas' => $ex_id[0], 'no_pengantar'=> $ex_id[1]])->orderBy(['no_urut'=>sort_asc])->all();
        $modelCeklis        = PdmCeklistTahap1::findOne(['id_berkas'=>$modelBerkas['id_berkas']])->tgl_selesai;
		$listTersangka    = Yii::$app->db->createCommand("
            select
                        a.id_berkas,
                        a.tgl_berkas,
                        d.id_p24,
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
                        LEFT JOIN pidum.pdm_p24 d on d.id_pengantar = c.id_pengantar    AND d.id_berkas = c.id_berkas
                    where c.id_pengantar  = '".$id_pengantar."'
                    GROUP BY
                        a.id_berkas,c.id_pengantar,d.id_p24

            ")->queryScalar();

		//echo $id_p24."--".$id_berkas;exit;
		if($id_p24=="null"){
			//$this->actionCreate($id_berkas);
			$this->redirect(['create','id_pengantar'=>$id_pengantar]);
		}else{
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P24]);
        $id = Yii::$app->session->get('id_perkara');

        $model = PdmP24::findOne(['id_p24' => $id_p24]);
        if ($model == null) {
            $model = new PdmP24();
        }

        $modelTersangka = $this->findModelTersangka($id);

        $modelSpdp = $this->findModelSpdp($id);

        $modelJpu = PdmJaksaP16::find()->where(['id_p16' => $modelP16->id_p16])->orderBy('no_urut asc')->all();
  $modelJpu2 = PdmJaksaP16::find()->select("a.nama as nama,a.nip as nip")
  ->from("pidum.pdm_jaksa_p16 a ")
  ->join('inner join','pidum.pdm_p24 b','a.nip=b.id_penandatangan')
  ->where(['a.id_perkara' => $id])
  ->orderBy('a.no_urut asc')->one();


  $modelJpu3 = PdmJaksaP16::find()->select ("a.nip as nip,a.nama as nama")
  ->from("pidum.pdm_jaksa_saksi a,pidum.pdm_p24 b ")
  ->where("a.id_perkara = '".$id."'
and a.nip != b.id_penandatangan
and a.nip != '".$model->id_penandatangan."'")
  ->groupBy(['a.nip','a.nama'])->all();
        if ($model->load(Yii::$app->request->post())) {
            $id_p17 = PdmP17::findOne(['id_perkara' => $id]);

$ttd=$_POST['idttd'];
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p24', 'id_p24', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();



          $data_ttd = Yii::$app->db->createCommand("SELECT * FROM pidum.vw_jaksa_penuntut WHERE peg_nip_baru='".$ttd."' ")->queryOne();


				$model->id_penandatangan =  $ttd;
				$model->nama = $data_ttd['peg_nama'];
				$model->pangkat = $data_ttd['pangkat'];
				$model->jabatan = $data_ttd['jabatan'];

				if($_POST['PdmP24']['id_pendapat']== '1' && $_POST['PdmP24']['saran_disetujui']=='1' && $_POST['PdmP24']['petunjuk_disetujui']=='1'){ //Lengkap
                $NextProcces = array(ConstSysMenuComponent::P21);
                Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
				$model->id_hasil='1';
            }else if($_POST['PdmP24']['id_pendapat']== '1' && $_POST['PdmP24']['saran_disetujui']=='0' && $_POST['PdmP24']['petunjuk_disetujui']=='0'){ //Lengkap
                $NextProcces = array(ConstSysMenuComponent::P21);
                Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
				$model->id_hasil='1';
            }else if($_POST['PdmP24']['id_pendapat']== '2' && $_POST['PdmP24']['saran_disetujui']=='1' && $_POST['PdmP24']['petunjuk_disetujui']=='0'){ //Lengkap
                $NextProcces = array(ConstSysMenuComponent::P21);
                Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
				$model->id_hasil='1';
            }else if($_POST['PdmP24']['id_pendapat']== '2' && $_POST['PdmP24']['saran_disetujui']=='0' && $_POST['PdmP24']['petunjuk_disetujui']=='1'){ //Lengkap
                $NextProcces = array(ConstSysMenuComponent::P21);
                Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
				$model->id_hasil='1';
            }else if ($_POST['PdmP24']['id_pendapat']== '1' && $_POST['PdmP24']['saran_disetujui']=='1' && $_POST['PdmP24']['petunjuk_disetujui']=='0'){// Pemeriksaan tambahan P-22
                $NextProcces = array(ConstSysMenuComponent::P18,  ConstSysMenuComponent::P19);
                Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
				$model->id_hasil='2';
            }else if ($_POST['PdmP24']['id_pendapat']== '1' && $_POST['PdmP24']['saran_disetujui']=='0' && $_POST['PdmP24']['petunjuk_disetujui']=='1'){// Pemeriksaan tambahan P-22
                $NextProcces = array(ConstSysMenuComponent::P18,  ConstSysMenuComponent::P19);
                Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
				$model->id_hasil='2';
            }else if ($_POST['PdmP24']['id_pendapat']== '2' && $_POST['PdmP24']['saran_disetujui']=='1' && $_POST['PdmP24']['petunjuk_disetujui']=='1'){// Pemeriksaan tambahan P-22
                $NextProcces = array(ConstSysMenuComponent::P18,  ConstSysMenuComponent::P19);
                Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
				$model->id_hasil='2';
            }else if ($_POST['PdmP24']['id_pendapat']== '2' && $_POST['PdmP24']['saran_disetujui']=='0' && $_POST['PdmP24']['petunjuk_disetujui']=='0'){// Pemeriksaan tambahan P-22
                $NextProcces = array(ConstSysMenuComponent::P18,  ConstSysMenuComponent::P19);
                Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces);
				$model->id_hasil='2';
            }else{
				echo "KOSONG";exit;
			}

                        $model->file_upload         = $_POST['PdmP24']['file_upload']; 
//                        echo '<pre>';print_r($model);exit();
                        $model->save();

                //Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::P24);


            $nip = $_POST['nip_jpu'];
            $nama = $_POST['nama_jpu'];
            $jabatan = $_POST['jabatan_jpu'];
            $pangkat = $_POST['gol_jpu'];
            $no_urut = $_POST['no_urut'];






            //notifikasi simpan
            if ($model->save()) {
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
                // return $this->redirect(['update','id'=>$model->id_perkara]);
            }

            return $this->redirect(['index']);
            //return $this->redirect(\Yii::$app->urlManager->createUrl("pidum/spdp/index"));
        } else {
            return $this->render('update', [
                        'model' => $model,
							'listTersangka' => $listTersangka,
                        'modelTersangka' => $modelTersangka,
                        'modelSpdp' => $modelSpdp,
                        'modelJpu' => $modelJpu,
						 'modelJpu2' => $modelJpu2,
						  'modelJpu3' => $modelJpu3,
                        'sysMenu' => $sysMenu,
						'modelBerkas' => $modelBerkas,
						'modelP16' => $modelP16,
						'modelGridTersangka' => $modelGridTersangka,
                        'modelCeklis'       => $modelCeklis
            ]);
        }

		}//end edit
    }

    /**
     * Deletes an existing PdmP24 model.
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

                PdmP24::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                   PdmP24::updateAll(['flag' => '3'], "id_p24 = '" . $id[$i] . "'");
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
    public function actionCetakdraft($id_pengantar){
        $odf    = new Odf(Yii::$app->params['report-path'] . "web/template/pidum/p24-draf.odt");
        $id     = Yii::$app->session->get('id_perkara');
        $model  = PdmPengantarTahap1::findOne([$id_pengantar]);
        $spdp   = PdmSpdp::findOne(['id_perkara' => $id]);
        $p16    = PdmP16::findOne(['id_perkara' => $id]);
        
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('no_p16', $p16->no_surat);
        $odf->setVars('tgl_p16', Yii::$app->globalfunc->ViewIndonesianFormat($p16->tgl_dikeluarkan));
//         $odf->setVars('hari', '');
//        $odf->setVars('tgl_surat',''); //
        $odf->setVars('ket_saksi', '');
        $odf->setVars('ket_ahli', '');
        $odf->setVars('alat_bukti', '');
        $odf->setVars('benda_sitaan', '');
        $odf->setVars('ket_tersangka', '');
        $odf->setVars('fakta_hukum', '');
        $odf->setVars('yuridis', '');
        $odf->setVars('kesimpulan', '');
//		$odf->setVars('pendapat', '');
//		$odf->setVars('pendapat1', '');
//		$odf->setVars('pendapat1a', '');
//		$odf->setVars('no1', '');
//		$odf->setVars('no2', '');
        $odf->setVars('reg_no', '.........................');
        
        $no_pengantar       = Yii::$app->session->get('no_pengantar');
        $id_pengantar       = Yii::$app->session->get('id_berkas');
        $berkasdanpengantar = $id_pengantar.'|'.$no_pengantar;
        $pdm_uu             = Yii::$app->db->createCommand("select * from pidum.pdm_uu_pasal_tahap1 where id_pengantar = '".$berkasdanpengantar."' ")->queryAll();
//        echo '<pre>';print_r(Yii::$app->inspektur->getGeneratePasalUU($pdm_uu));exit();
        foreach ($pdm_uu as $row_uu){
            $undang .= $row_uu['undang']. ' '. $row_uu['pasal'] .', ';
        }
        $undang = substr($undang, 0,-2);
        $odf->setVars('pasal', $undang);
//        $odf->setVars('undang', '');
//        $odf->setVars('saran','');
//        $odf->setVars('petunjuk','');

		#Jaksa Peneliti
        $query = new Query;
        $query->select('a.nip,a.nama,a.jabatan,a.pangkat')
                ->from('pidum.pdm_jaksa_p16 a, pidum.pdm_p16 b')
                ->where(" a.id_p16=b.id_p16 and b.id_perkara='" . $id . "' ")
                ->orderby('a.no_urut');
        $dt_jaksaPeneliti = $query->createCommand();
        $listjaksaPeneliti = $dt_jaksaPeneliti->queryAll();
        $dft_jaksaPeneliti = $odf->setSegment('jaksaPeneliti');
        $i = 1;
        foreach ($listjaksaPeneliti as $element) {
            $pangkat = explode('/', $element['pangkat']);
            $dft_jaksaPeneliti->urutan($i);
            $dft_jaksaPeneliti->nama_pegawai($element['nama'].'');
            $dft_jaksaPeneliti->pangkat($pangkat[0] . ' / ' . $element['nip']);
            //$dft_jaksaPeneliti->jabatan($element['jabatan']);
            $dft_jaksaPeneliti->merge();
            $i++;
        }
        $odf->mergeSegment($dft_jaksaPeneliti);
        // echo '<pre>';
        //   echo $listjaksaPeneliti[0]['nip'];
        // print_r($listjaksaPeneliti);exit;
        //
        // echo '</pre>';
        $dft_jaksaTtd = $odf->setSegment('ttd');
//        $dft_jaksaTtd->kepala('');
        $dft_jaksaTtd->nama_penandatangan($listjaksaPeneliti[0]['nama']);
        $dft_jaksaTtd->pangkat_penandatangan($listjaksaPeneliti[0]['pangkat']);
        $dft_jaksaTtd->nip_penandatangan($listjaksaPeneliti[0]['nip']);
        $dft_jaksaTtd->merge();
        $odf->mergeSegment($dft_jaksaTtd);
           
        $listTersangka = Yii::$app->db->createCommand(" select a.nama FROM pidum.ms_tersangka_berkas a WHERE a.id_berkas='".$model->id_berkas."' ORDER BY a.no_urut asc  ")->queryAll();

        if (count($listTersangka) == 1) {
            foreach ($listTersangka as $key) {
                $nama_tersangka = $key[nama] ;
            }
        } else if(count($listTersangka) == 2){
            $i=1;
            foreach ($listTersangka as $key) {
                if($i==1){
                    $nama_tersangka = $key[nama]." dan " ;
                }else{
                    $nama_tersangka .= $key[nama] ;
                }
                $i++;
             }
        } else {
            foreach ($listTersangka as $key) {
                $i=1;
                if($i==1){
                    $nama_tersangka = $key[nama]." dkk. " ;
                }
            }
        }
        $odf->setVars('tersangka', $nama_tersangka);
        $kode=$spdp->wilayah_kerja;
        if ($kode=='00'){
            $odf->setVars('kejaksaan', 'JAKSA AGUNG MUDA TINDAK PIDANA UMUM');
        }
        else{
           $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        }
            $odf->exportAsAttachedFile('p24-draf.odt');
	}
        
        
	public function actionCetak($id_p24,$id_berkas)
	{
        //echo '<pre>';print_r($id_p24);exit;
        $ex_id = explode('|', $id_p24);
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "web/template/pidum/p24.odt");
		  $id = Yii::$app->session->get('id_perkara');
   $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p24 b','a.peg_nik = b.id_penandatangan')
->where ("id_p24='".$id_p24."'")
->one();

 $modelJpu2 = PdmJaksaP16::find()->select("a.nama as nama,a.nip as peg_nip_baru, a.pangkat as jabatan")
  ->from("pidum.pdm_jaksa_p16 a ")
  ->join('inner join','pidum.pdm_p24 b','a.nip=b.id_penandatangan')
  ->where(['b.id_p24' => $id_p24])
  ->orderBy('a.no_urut asc')->one();



        $model = PdmP24::findOne(['id_p24' => $id_p24]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $id]);
		//$modelpasal = PdmPasal::findOne(['id_perkara' => $model->id_perkara]);
        $p16 = PdmP16::findOne(['id_perkara' => $id]);
                $modelTersangka = $this->findModelTersangka($id);
        $tanggalSurat = Yii::$app->globalfunc->getTanggalBeritaAcara($model->tgl_ba);
        $hari = Yii::$app->globalfunc->GetNamahari($model->tgl_ba);
        //$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        //$odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('no_p16', $p16->no_surat);
        $odf->setVars('tgl_p16', Yii::$app->globalfunc->ViewIndonesianFormat($p16->tgl_dikeluarkan));
        $odf->setVars('hari', ucfirst($hari));
        $odf->setVars('tgl_surat', $tanggalSurat ); //
        $odf->setVars('ket_saksi', $model->ket_saksi);
        $odf->setVars('ket_ahli', $model->ket_ahli);
        $odf->setVars('alat_bukti', $model->alat_bukti);
        $odf->setVars('benda_sitaan', $model->benda_sitaan);
        $odf->setVars('ket_tersangka', $model->ket_tersangka);
        $odf->setVars('fakta_hukum', $model->fakta_hukum);
        $odf->setVars('yuridis', $model->yuridis);
        $odf->setVars('kesimpulan', $model->kesimpulan);

		 $dft_jaksaTtd = $odf->setSegment('ttd');
		  $dft_jaksaTtd->kepala($modelJpu2->pangkat);
		 $dft_jaksaTtd->nama_penandatangan($modelJpu2->nama);
		  $dft_jaksaTtd->pangkat_penandatangan($modelJpu2->jabatan);
		   $dft_jaksaTtd->nip_penandatangan($modelJpu2->peg_nip_baru);
		    $dft_jaksaTtd->merge();

				$odf->mergeSegment($dft_jaksaTtd);

						//print_r($modelJpu2);exit;
		//cetakan pendapat untuk default #bowo #23062016
		$kode = $model->id_hasil;
		$no1='a.';
		$no2='b.';
		$a='Berkas perkara telah memenuhi syarat untuk dilimpahkan ke Pengadilan (P-21)';
		$b='Masih perlu melengkapi berkas perkara atas nama tersangka';
		$c='dengan melakukan pemeriksaan tambahan (P-22)';
		if ($kode=='3'){
        $odf->setVars('pendapat', $a);
		$odf->setVars('pendapat1', $b);
		$odf->setVars('pendapat1a', $c);
		$odf->setVars('no1', $no1);
		$odf->setVars('no2', $no2);
		}else{
		$odf->setVars('pendapat', $model->pendapat);
		$odf->setVars('pendapat1', '');
		$odf->setVars('pendapat1a', '');
		$odf->setVars('no1', '');
		$odf->setVars('no2', '');
		}

        $odf->setVars('reg_no', '');
        $odf->setVars('pasal', $modelpasal->pasal);
		$odf->setVars('undang', $modelpasal->undang);
        #list Tersangka
        /*$listTersangka = Yii::$app->db->createCommand(" select a.nama FROM pidum.ms_tersangka_berkas a WHERE a.id_berkas='".$model->id_berkas."' ORDER BY a.no_urut asc  ")->queryAll();

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
        }*/
        $nama_tersangka = Yii::$app->globalfunc->getListTerdakwaBerkas($ex_id[1]);

		$odf->setVars('tersangka', $nama_tersangka);
		$kode=$spdp->wilayah_kerja;

        if ($kode=='00'){
            //$odf->setVars('kejaksaan', 'JAKSA AGUNG MUDA TINDAK PIDANA UMUM');
//            echo 'cel 00';exit();
            $odf->setVars('Kejaksaan', 'JAKSA AGUNG MUDA TINDAK PIDANA UMUM');
        }else{
//            echo 'cel';exit();
           //$odf->setVars('kejaksaan', ucfirst(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama)));
           $odf->setVars('Kejaksaan', ucfirst(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama)));
        }

		 $odf->setVars('saran',$model->saran);

		  $odf->setVars('petunjuk',$model->petunjuk);

        #Jaksa Peneliti
        $query = new Query;
        $query->select('a.nip,a.nama,a.jabatan,a.pangkat')
                ->from('pidum.pdm_jaksa_p16 a, pidum.pdm_p16 b')
                ->where(" a.id_p16=b.id_p16 and b.id_perkara='" . $id . "' ")
                ->orderby('a.no_urut');
        $dt_jaksaPeneliti = $query->createCommand();
        $listjaksaPeneliti = $dt_jaksaPeneliti->queryAll();
//        echo '<pre>';print_r($listjaksaPeneliti);exit();
        $dft_jaksaPeneliti = $odf->setSegment('jaksaPeneliti');
        $i = 1;
        foreach ($listjaksaPeneliti as $element) {
            $pangkat = explode('/', $element['pangkat']);
            $dft_jaksaPeneliti->urutan($i);
            $dft_jaksaPeneliti->nama_pegawai($element['nama']);
            $dft_jaksaPeneliti->pangkat($pangkat[0] . ' / ' . $element['nip']);
            //$dft_jaksaPeneliti->jabatan($element['jabatan']);
            $dft_jaksaPeneliti->merge();
            $i++;
        }
        $odf->mergeSegment($dft_jaksaPeneliti);

        $odf->exportAsAttachedFile('p24.odt');

        }

    /**
     * Finds the PdmP24 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP24 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP24::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        } /*else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }

    protected function findModelTersangka($id)
    {
        if (($modelTersangka = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $modelTersangka;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
 protected function findModelBerkas($id)
    {

    $modelBerkas  = Yii::$app->db->createCommand("
        select
                    a.id_berkas,
                    a.tgl_berkas,
                    d.id_p24,
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
                    LEFT JOIN pidum.pdm_p24 d on d.id_pengantar = c.id_pengantar  and d.id_berkas = c.id_berkas
                where c.id_pengantar  = '".$id."'
                GROUP BY
                    a.id_berkas,c.id_pengantar,d.id_p24

        ")->queryAll();

        if (count($modelBerkas) > 0) {
            return $modelBerkas;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

		 }
