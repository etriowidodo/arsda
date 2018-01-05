<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmJaksaP16;
use app\modules\pdsold\models\PdmBerkasTahap1Grid;
use app\modules\pdsold\models\PdmBerkasTahap1GridSearch;
use app\modules\pdsold\models\PdmJpu;
use app\modules\pdsold\models\PdmP16;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmPengantarTahap1;
use app\modules\pdsold\models\PdmUuPasalTahap1;
use app\modules\pdsold\models\PdmBerkasTahap1Search;
use app\modules\pdsold\models\MsTersangkaBerkas;
use app\modules\pdsold\models\MsJkl;
use app\modules\pdsold\models\PdmCeklistTahap1;
use app\modules\pdsold\models\MsUUndang;
use app\models\MsWarganegara;
use app\modules\pdsold\models\VwGridPrapenuntutanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\web\Session;
use Jaspersoft\Client\Client;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\data\SqlDataProvider;
use app\modules\pdsold\models\MsPedomanSearch;
use app\modules\pdsold\models\MsUUndangSearch;
use app\modules\pdsold\models\MsPasalSearch;
use app\modules\pdsold\models\MsJenisPerkaraSearch;
use app\modules\pdsold\models\MsTersangkaSearch;
use app\modules\pdsold\models\MsPasal;
use yii\data\ActiveDataProvider;


/**
 * PdmBerkasTahap1Controller implements the CRUD actions for PdmBerkasTahap1 model.
 */
class PdmBerkasTahap1Controller extends Controller
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
     * Lists all PdmBerkasTahap1 models.
     * @return mixed
     */
  //   public function actionIndex()
  //   {
		// $session = new Session();
  //       $id_perkara = $session->get('id_perkara');
  //       $searchModel = new PdmBerkasTahap1Search();
  //       $dataProvider = $searchModel->search3(Yii::$app->request->queryParams);

  //       return $this->render('index', [
  //           'searchModel' => $searchModel,
  //           'dataProvider' => $dataProvider,
		// 	'sysMenu' => $sysMenu,
		// 	'modelTersangka'=>$modelTersangka,
  //       ]);
  //   }

     public function actionIndex() {
        
        $searchModel = new PdmBerkasTahap1GridSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $session = new session();
        $session->remove('no_eksekusi');
        $session->remove('no_akta');
        $session->remove('no_register_perkara');
        $session->remove('no_reg_tahanan');
        $session->remove('id_berkas');
        $session->remove('id_perkara');
        $session->remove('no_pengantar');
        $session->remove('perilaku_berkas');
      /*$query = "SELECT a.id_berkas,a.no_berkas, a.tgl_berkas,a.id_perkara, COALESCE(string_agg(b.nama,'^'),'') as nama_tersangka from pidum.pdm_berkas_tahap1 a 
left join pidum.ms_tersangka_berkas b on a.id_berkas=b.id_berkas
 
group by a.no_berkas,a.tgl_berkas,a.id_berkas
order by a.tgl_berkas";*/
//print_r($query);exit;
      //$jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


    /*$dataProvider = new SqlDataProvider([
      'sql' => $query,
      'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'no_berkas',
              'tgl_berkas',
              'Nama_tersangka',
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);*/
        $model = $dataProvider->getModels();


//         $queryx = "SELECT a.id_perkara,a.no_surat, a.tgl_surat from pidum.pdm_spdp a order by a.tgl_surat";
// //print_r($query);exit;
//       $jmlx = Yii::$app->db->createCommand(" select count(*) from (".$queryx.")a ")->queryScalar();


//     $dataProviderx = new SqlDataProvider([
//       'sql' => $queryx,
//       'totalCount' => (int)$jmlx,
//       'sort' => [
//           'attributes' => [
//               'id_perkara',
//               'no_surat',
//               'tgl_surat',
//          ],
//      ],
//       'pagination' => [
//           'pageSize' => 10,
//       ]
// ]);
//         $models = $dataProviderx->getModels();

        $searchModelx = new VwGridPrapenuntutanSearch();
        $dataProviderx = $searchModelx->searchGridTahap1(Yii::$app->request->queryParams);
        $dataProviderx->pagination->pageSize = '10';




        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchmodel'=> $searchModel,
            'dataProviderx' => $dataProviderx,
            'searchmodelx'=> $searchModelx,
        ]);
    }
    public function actionCeklis()
    {
       // echo Yii::$app->session->get('perilaku_berkas');exit();
        $berkas = Yii::$app->session->get('id_berkas');
        $no_pengantar = Yii::$app->session->get('no_pengantar');
        $berkasdanpengantar = $berkas.'|'.$no_pengantar;
//        echo $berkas.'|'.$no_pengantar;exit();
        if($no_pengantar == ''){
            if($berkas == ''){
                $id_perkara = Yii::$app->session->get('id_perkara');
                $query =  "
                        select
                                a.id_berkas,
                                a.tgl_berkas,
                                a.no_berkas,
                                STRING_AGG(b.no_urut||'.'||b.nama, '<br/>' ORDER BY b.id_tersangka) as nama_tersangka
                            FROM
                                pidum.pdm_berkas_tahap1 a
                                INNER JOIN pidum.pdm_pengantar_tahap1 c on a.id_berkas = c.id_berkas
                                INNER JOIN pidum.ms_tersangka_berkas b on a.id_berkas = b.id_berkas
                            where
                                a.id_perkara = '".$id_perkara."'
                            GROUP BY
                                a.id_berkas
                        " ;
                $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();
                $dataProvider = new SqlDataProvider([
                    'sql' => $query,
                    'totalCount' => (int)$jml,
                    'sort' => [
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
                    return $this->render('ceklis', [
                        'searchModel' => $searchModel,
                        'id_berkas' => $berkas,
                        'dataProvider' => $dataProvider,
                    ]);
                    }
            else {
                $id_perkara = Yii::$app->session->get('id_perkara');
                    $query =  "
                            select
                                    a.id_berkas,
                                    a.tgl_berkas,
                                    a.no_berkas,
                                    STRING_AGG(b.no_urut||'.'||b.nama, '<br/>' ORDER BY b.id_tersangka) as nama_tersangka
                                FROM
                                    pidum.pdm_berkas_tahap1 a
                                    INNER JOIN pidum.pdm_pengantar_tahap1 c on a.id_berkas = c.id_berkas
                                    INNER JOIN pidum.ms_tersangka_berkas b on a.id_berkas = b.id_berkas
                                where
                                    a.id_berkas = '".$berkas."'
                                GROUP BY
                                    a.id_berkas
                            " ;
                    $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();
                    $dataProvider = new SqlDataProvider([
                      'sql' => $query,
                      'totalCount' => (int)$jml,
                      'sort' => [
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
                return $this->render('ceklis_1', [
                    'searchModel' => $searchModel,
                    'id_berkas' => $berkas,
                    'dataProvider' => $dataProvider,
                ]);
            }
        }else{
            return $this->redirect(['../pdsold/pdm-berkas-tahap1/pendapat?id_berkas='.$berkas.'&id_pengantar='.$no_pengantar.'&id_ceklist='.$berkasdanpengantar]);
            
        }
    }


    public function actionPendapat()
    {
        $id_perkara = Yii::$app->session->get('id_perkara');
        $id_pengantar = $_GET['id_pengantar'];
        $id_berkas = $_GET['id_berkas'];
        $id_ceklist = $_GET['id_ceklist'];
        $no_pengantar = Yii::$app->session->get('no_pengantar');
//        echo $id_pengantar.' '.$id_berkas.' '.$id_ceklist;exit();

        $modelP16 = ArrayHelper::map(PdmJaksaP16::find()->where(['id_perkara'=>$id_perkara])->all(),'nip','nama');

       
    			$modelCeklis = PdmCeklistTahap1::findOne(['id_ceklist'=>$id_ceklist]);
    		if($modelCeklis == NULL){
          $modelCeklis = new PdmCeklistTahap1();
        }

        //echo '<pre>';print_r($modelCeklis);exit;
        if ($modelCeklis->load(Yii::$app->request->post())) {
      			$jml_ceklist = Yii::$app->db->createCommand("SELECT (count(*)+1) as jml FROM pidum.pdm_ceklist_tahap1 WHERE id_berkas='".$id_berkas."' ")->queryOne();
      			$data_ttd = Yii::$app->db->createCommand("SELECT * FROM pidum.vw_jaksa_penuntut WHERE peg_nip_baru='".$_POST['PdmCeklistTahap1']['nik_ttd']."' ")->queryOne();
      	        $filename = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) .'/ceklist'.$jml_ceklist['jml'].'.odt';
                  $id_pendapat_jaksa = $_POST['rdPendapat'];
                  $jml_data=count($id_pendapat_jaksa);
      			$isi=null;
      			if(count($id_pendapat_jaksa)>0){
        			foreach ($id_pendapat_jaksa as $hasil) {
        				$isi .=$hasil.',';
        			}
      			}

            $upload = UploadedFile::getInstance($modelCeklis, 'file_upload');
            if ($upload != false && !empty($upload) ) {
                $modelCeklis->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/ceklist'.$jml_ceklist['jml'].'.' . $upload->extension;
            }

            $modelCeklis->id_pendapat_jaksa =$isi;

            $r_fileupload = " SELECT file_upload FROM pidum.pdm_ceklist_tahap1 where id_ceklist = '".$id_ceklist."' ";
//            $upload_file = Yii::$app->db->createCommand($r_fileupload)->queryScalar();
//            if ($upload == 'null' || empty($upload)) { //membedakan antara tidak upload dan hapus upload
//                if($upload_file != ''){
//                    $modelCeklis->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/ceklist'.$jml_ceklist['jml'].'.odt';//penamaan kembali file ketika edit dan upload berkas kosong
//                }else{
//                    if(file_exists($filename)){
//                    $modelCeklis->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/ceklist'.$jml_ceklist['jml'].'.odt';
//                    //var_dump($modelCeklis);
//                    //exit;
//                }
//                }
//            }else{
//
////                $modelCeklis->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/ceklist'.$jml_ceklist['jml'].'.' . $upload->extension; 
//            }
//                        echo $_POST['PdmCeklistTahap1']['file_upload'];exit();
			$modelCeklis->id_ceklist = $id_berkas."|".$_POST['no_pengantar'];
			$modelCeklis->id_berkas = $id_berkas;
			$modelCeklis->no_pengantar = $_POST['no_pengantar'];
			$modelCeklis->nama_ttd = $data_ttd['peg_nama'];
			$modelCeklis->pangkat_ttd = $data_ttd['pangkat'];
			$modelCeklis->jabatan_ttd = $data_ttd['jabatan'];
                        $modelCeklis->file_upload       = $_POST['PdmCeklistTahap1']['file_upload']; 
			if(!$modelCeklis->save()){
				var_dump($modelCeklis->getErrors());exit;
			}

            if ($upload != false) {

                if (file_exists($filename)) {
                    chmod($filename,0777);
                    unlink($filename);
                    $upload->saveAs($filename);
                } else {
                    $path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/ceklist'.$jml_ceklist['jml'].'.' . $upload->extension;  //penamaan file ke folder pidum surat
                    $upload->saveAs($path);
                }
            }
            
            return $this->redirect(['ceklis']);
            


        }else{
      		return $this->render('pendapat', [
                  'searchModel' => $searchModel,
                  'modelCeklis' => $modelCeklis,
                  'dataProvider' => $dataProvider,
                  'sysMenu' => $sysMenu,
                  'modelBerkas' => $modelBerkas,
                  'modelP16' => $modelP16,
                  'id_ceklist' => $id_ceklist,
              ]);
      }

    }



    /**
     * Displays a single PdmBerkasTahap1 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmBerkasTahap1 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	 
	private function actionKekata($x,$string) 
	{
		$x = abs($x);
		if($string ==0)
		{
			$angka = array("", "kesatu", "kedua", "ketiga", "keempat", "kelima",
		"keenam", "ketujuh", "kedelapan", "kesembilan", "kesepuluh", "kesebelas");
		}
		else
		{
			$angka = array("", "pertama", "kedua", "ketiga", "keempat", "kelima",
		"keenam", "ketujuh", "kedelapan", "kesembilan", "kesepuluh", "kesebelas");
		}

		$temp = "";
		if ($x <12) {
			$temp = " ". $angka[$x];
		} else if ($x <20) {
			$temp = kekata($x - 10). " belas";
		} else if ($x <100) {
			$temp = kekata($x/10)." puluh". kekata($x % 10);
		} else if ($x <200) {
			$temp = " seratus" . kekata($x - 100);
		} else if ($x <1000) {
			$temp = kekata($x/100) . " ratus" . kekata($x % 100);
		} else if ($x <2000) {
			$temp = " seribu" . kekata($x - 1000);
		} else if ($x <1000000) {
			$temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
		} else if ($x <1000000000) {
			$temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
		} else if ($x <1000000000000) {
			$temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
		} else if ($x <1000000000000000) {
			$temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
		}
			return $temp;
	}
	
	private function actionTerbilang($x, $style=4,$string=0) 
	{
		if($x<0) {
			$hasil = "minus ". trim(kekata($x,$string));
		} else {
			$hasil = trim($this->actionKekata($x,$string));
		}
		switch ($style) {
			case 1:
				$hasil = strtoupper($hasil);
				break;
			case 2:
				$hasil = strtolower($hasil);
				break;
			case 3:
				$hasil = ucwords($hasil);
				break;
			default:
				$hasil = ucfirst($hasil);
				break;
		}
		return $hasil;
	}
	
	private function actionSubsiderCount($x)
	{
		$lebih = '';
		for($i=1;$i<$x;$i++)
		{
			$lebih .= ' Lebih ';
		}
		return $lebih;
	}
	
	private function actionCreateAtau($varTau,$count)
	{
		if($varTau<$count)
		{
			return ' Atau <br>';
		}

	}
	
	public function actionExplodeAtau($atau)
   {
		$proses = explode('Atau',$atau);
		$count  = count($proses);
		$hasil = '';
		$str_atau = '';
		$varTau = 0;

		foreach($proses As $keyP=>$valP)
		{

			$hasil .= ' '.$this->actionTerbilang(++$varTau,3,1).' '.$valP.$this->actioncreateAtau($varTau,$count);
		}
		return $hasil;
   }

    public function actionGenerateUu($id_pengantar)
    {
                


                    

        // $model          = PdmUuPasalTahap1::find()->where(['id_pengantar' => '0000002016000010'])->orderBy(['id_pasal'=>'SORT_ASC'])->All();
        $model          = PdmUuPasalTahap1::find()->where(['id_pengantar' => $id_pengantar])->orderBy(['id_pasal'=>'SORT_ASC'])->All();
        $data_dakwaan = array('','Juncto','Dan','Atau','Subsider');
        $hasil ='';
        

        foreach($model AS $key=>$val)
        {
            $hasil .= $val->pasal.' '.$val->undang.' '.$data_dakwaan[$val->dakwaan].' ';
        }

$subsider   = explode('Subsider',$hasil);
$dan        = explode('Dan',$hasil);
$Catau      = explode('Atau',$hasil);
$atau       = $hasil;

$hasil_akhir="";
        

       

       $countS = count($subsider);
        if(count($subsider)>1)
        {
            $hasil_akhir .= 'Primer  ';
            $i = 0;
            foreach($subsider AS $key=>$val)
            {

                if($key ==0)
                {
                    $eDan    = explode('Dan',$val);
                    $eTau1   = explode('Atau',$val);
                    $countD  = count($eDan);
                    if(count($eDan)>1)
                    {
                        $ii=0;
                        foreach($eDan As $keyDan=>$valDan)
                        {
                            $hasil_akhir .= $this->actionTerbilang((++$ii),3,0).' ';
                            $eTau    = explode('Atau',$valDan);
                                if(count($eTau)>1)
                                {
                                    $hasil_akhir .= $this->actionExplodeAtau($valDan).' ';
                                }
                                else
                                {
                                    $hasil_akhir .= $valDan.' ';
                                }

                            if($ii<$countD )
                            {
                                $hasil_akhir .= 'Dan  ';
                            }

                        }
                    }
                    else if(count($eTau1 )>1)
                    {

                            if(count($eTau1)>1)
                            {
                                echo $this->actionExplodeAtau($val).' ';
                            }
                            else
                            {
                                echo $val.' ';
                            }
                    }
                    else
                    {
                        echo $val.' ';
                    }

                }


               if($key!=0)
               {
                 $hasil_akhir .= $val.' ';
               }

               if(++$i < $countS)
               {
                 $hasil_akhir .= $this->actionsubsiderCount($i);
                 $hasil_akhir .= 'Subsider';
               }

            }
        }
        else if(count($dan)>1)
        {
            $countD  = count($dan);
            $ii=0;
                foreach($dan As $keyDan=>$valDan)
                {
                    $hasil_akhir .= $this->actionTerbilang((++$ii),3,0).' ';
                    $eTau    = explode('Atau',$valDan);
                        if(count($eTau)>1)
                        {
                            $hasil_akhir .= $this->actionExplodeAtau($valDan).' ';
                        }
                        else
                        {
                            $hasil_akhir .= $valDan.' ';
                        }

                    if($ii<$countD )
                    {
                        $hasil_akhir .= 'Dan  ';
                    }

                }
        }
        else if(count($Catau)>1)
        {
            $hasil_akhir =  $this->actionExplodeAtau($atau).' ';
        }
        else
        {
             $hasil_akhir=$hasil;
        }
		return $hasil_akhir;
    }
    public function actionCreate()
    {
	    $session = new Session();
		$model = new PdmBerkasTahap1();
        $id = $session->get('id_perkara');
		$modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);
		//$modelPengantar = PdmPengantarTahap1::findOne(['id_berkas' => $id]);
		$searchModel = new PdmBerkasTahap1Search();
		$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) ) {

		$transaction = Yii::$app->db->beginTransaction();
			try{

				$jml_is_akhir = Yii::$app->db->createCommand(" select count(*) from pidum.pdm_status_surat where id_sys_menu = 'CekBerkas' and id_perkara='".$id."' ")->queryScalar();
			if($jml_is_akhir < 1){
				Yii::$app->globalfunc->getSetStatusProcces($id, GlobalConstMenuComponent::CekBerkas);
				Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='0' WHERE (id_sys_menu = 'SPDP' OR id_sys_menu = 'P-16' OR id_sys_menu = 'P-17') AND id_perkara=:id")
					->bindValue(':id', $id)
					->execute();
			}

			
			$model->id_berkas  =str_pad(\Yii::$app->globalfunc->getSatker()->inst_satkerkd,6,'0',STR_PAD_LEFT).$_POST['PdmBerkasTahap1']['no_berkas'];
			$model->id_perkara =$id;
			if(!$model->save()){
				var_dump($model->getErrors());exit;
			}
			//Update tempat kejadian SPDP
			if (($_POST['PengantarBaru']['tmpt_kejadian']) != null || ($_POST['PengantarBaru']['waktu_kejadian']) != null)
			{
			$UpdateTempatKejadian = Yii::$app->db->createCommand("UPDATE pidum.pdm_spdp SET tempat_kejadian = '".$_POST['PengantarBaru']['tmpt_kejadian']."',tgl_kejadian_perkara= '".$_POST['PengantarBaru']['waktu_kejadian']."' WHERE id_perkara = '".$id."' ");
            $UpdateTempatKejadian->execute();
			}
			//SIMPAN PENGANTAR
			if (!empty($_POST['PengantarBaru']['no_pengantar'])) { // jika pengantar tidak kosong
                    for($i=0; $i < count($_POST['PengantarBaru']['no_pengantar']); $i++)
                    {
                        $modelPengantarSave = new PdmPengantarTahap1();
						$seqPengantar = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_pengantar_tahap1','id_pengantar', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

                        $id_pengantar =  $model->id_berkas.'|'.$_POST['PengantarBaru']['no_pengantar'][$i];
                        // echo $id_pengantar;exit;
                        $modelPengantarSave ->id_pengantar= $id_pengantar;
                        $modelPengantarSave ->id_berkas = $model->id_berkas;
                        $modelPengantarSave ->no_pengantar = $_POST['PengantarBaru']['no_pengantar'][$i];
                        $modelPengantarSave ->tgl_pengantar = date('Y-m-d',strtotime($_POST['PengantarBaru']['tgl_pengantar'][$i]));
						$modelPengantarSave ->tgl_terima = date('Y-m-d',strtotime($_POST['PengantarBaru']['tgl_terima'][$i]));
                       	$idCOmparePengantar = $_POST['PengantarBaru']['generate_id'][$i];
                        if(!$modelPengantarSave ->save()){
                            var_dump($modelPengantarSave ->getErrors());echo "Pengantar";exit;
                        }
            //SIMPAN UNDANG2
            $undang = $_POST['MsUndang'][$idCOmparePengantar]['undang'];

                if(isset($undang)){
                    foreach($undang AS $key => $value )
                        {
                        $pdmPasal1 = new PdmUuPasalTahap1 ();

                        $seqPasal = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_uu_pasal_tahap1', 'id_pasal', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

                        $pdmPasal1->id_pasal        =  $seqPasal['generate_pk'];
                        $pdmPasal1->id_pengantar    =  $modelPengantarSave->id_pengantar;
                        $pdmPasal1->undang          =  $_POST['MsUndang'][$idCOmparePengantar]['undang'][$key];
                        $pdmPasal1->pasal           =  $_POST['MsUndang'][$idCOmparePengantar]['pasal'][$key];
                        $pdmPasal1->dakwaan         =  $_POST['MsUndang'][$idCOmparePengantar]['dakwaan'][$key];


                            if(!$pdmPasal1->save()){
                                var_dump($pdmPasal1->getErrors());echo "Pasal";exit;
                            }
                        }
                    }
                    //die();
            //SIMPAN TERSANGKA
           $tersangka = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['nama'];
            if(isset($tersangka))
            {
                foreach( $tersangka as $keyTersangka => $valTersangka)
                {
                    $modelTersangka1 = new MsTersangkaBerkas();
                        $id_tersangka =  $model->id_berkas."|".$modelPengantarSave->no_pengantar."|".$_POST['MsTersangkaBaru'][$idCOmparePengantar]['no_urut'][$keyTersangka];
                        $modelTersangka1->id_tersangka = $model->id_berkas."|".$modelPengantarSave->no_pengantar."|".$_POST['MsTersangkaBaru'][$idCOmparePengantar]['no_urut'][$keyTersangka];
                        $modelTersangka1->tmpt_lahir = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['tmpt_lahir'][$keyTersangka];
                        $modelTersangka1->tgl_lahir = date('Y-m-d',strtotime($_POST['MsTersangkaBaru'][$idCOmparePengantar]['tgl_lahir'][$keyTersangka]));
                        $modelTersangka1->umur = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['umur'][$keyTersangka];;
                        $modelTersangka1->alamat = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['alamat'][$keyTersangka];;
                        $modelTersangka1->no_identitas = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['no_identitas'][$keyTersangka];
                        $modelTersangka1->no_hp = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['no_hp'][$keyTersangka];
                        $modelTersangka1->warganegara = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['warganegara'][$keyTersangka];
                        $modelTersangka1->pekerjaan = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['pekerjaan'][$keyTersangka];
                        $modelTersangka1->suku = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['suku'][$keyTersangka];
                        $modelTersangka1->nama = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['nama'][$keyTersangka];
                        $modelTersangka1->id_jkl = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['id_jkl'][$keyTersangka];
                        $modelTersangka1->id_identitas = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['id_identitas'][$keyTersangka];
                        $modelTersangka1->id_agama = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['id_agama'][$keyTersangka];
                        $modelTersangka1->id_pendidikan = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['id_pendidikan'][$keyTersangka];
                        $modelTersangka1->no_urut = $_POST['MsTersangkaBaru'][$idCOmparePengantar]['no_urut'][$keyTersangka];
                        $modelTersangka1->no_pengantar = $modelPengantarSave->no_pengantar;
                        $modelTersangka1->id_berkas = $model->id_berkas;
                        if(!$modelTersangka1->save()){
                            var_dump($modelTersangka1->getErrors());exit;
                        }
                    }
                }
            }
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

                return $this->redirect(['update', 'id'=>$model->id_berkas]);
            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);

                return $this->render('create',[
				'model' => $model,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'modelSpdp' => $modelSpdp,
				'modelTersangka' => $modelTersangka,
                'modelPasal' => $modelPasal,
				'modelPengantar'=> $modelPengantar,
				]);

            }
        } else {
            return $this->render('create', [
                'model'             => $model,
				'searchModel'       => $searchModel,
				'dataProvider'      => $dataProvider,
				'modelSpdp'         => $modelSpdp,
				'modelTersangka'    => $modelTersangka,
                'modelPasal'        => $modelPasal,
				'modelPengantar'    => $modelPengantar,
            ]);
        }
    }

    /**
     * Updates an existing PdmBerkasTahap1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $session = new session();
        $session->set('id_berkas',$id);

        $id2 = Yii::$app->session->get('id_perkara');
        $model = PdmBerkasTahap1::findOne(['id_perkara' => $id2, 'id_berkas' => $id]);
        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id2]);
        $modelPengantar = PdmPengantarTahap1::find()
                ->where(['id_berkas' => $id])
                ->all();
        $generateUu =   $this->actionGenerateUu($modelPengantar->id_pengantar);
        $searchModel = new PdmBerkasTahap1Search();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);

		$array_uu = array();
		$i=0;
		foreach($modelPengantar as $key => $value){
			$array_uu[$i] = $this->actionGenerateUu($value->id_pengantar);
			$i++;
		}
		

        if ($model->load(Yii::$app->request->post())) {
            // echo '<pre>';
            // print_r($_POST);exit;
              $hapus_pengantar = $_POST['hapuspengantar'];
                           if(isset($hapus_pengantar))
                           {
                                $count_hapus_pengantar = 0;
                                $gagal = array();
                                foreach($hapus_pengantar AS $key_hapus => $_hapus_pengantar){
                                        try{
                                           PdmPengantarTahap1::deleteAll(['id_pengantar' => $_hapus_pengantar]);
                                        }catch (\yii\db\Exception $e) {
                                          $count_hapus_pengantar++;
                                          $gagal[] = $key_hapus;
                                        }
                                }

                                foreach($gagal AS $key_gagal => $_gagal) // JIka ada yang gagal maka hapus element yang gagal di array hapus pengantar.
                                {
                                    unset($hapus_pengantar[$_gagal]);
                                }

                                foreach($hapus_pengantar AS $key_hapus_hierarki => $hapus_pengantar_hierarki) // sisa dari unset /hpus gagal ;
                                {
                                     $hapus_no_pengantar_tersangka = explode('|',$hapus_pengantar_hierarki);
                                     MsTersangkaBerkas::deleteAll(['no_pengantar' =>  $hapus_no_pengantar_tersangka[1]]);
                                     PdmUuPasalTahap1::deleteAll(['id_pengantar'  => $hapus_pengantar_hierarki]);
                                }

                                if($count_hapus_pengantar>0){
                                    Yii::$app->getSession()->setFlash('success', [
                                         'type' => 'danger',
                                         'duration' => 5000,
                                         'icon' => 'fa fa-users',
                                         'message' =>  $count_hapus_pengantar.' Data Pengantar Tidak Dapat Dihapus Karena Sudah Digunakan Di Persuratan Lainnya',
                                         'title' => 'Error',
                                         'positonY' => 'top',
                                         'positonX' => 'center',
                                         'showProgressbar' => true,
                                     ]);
                                    return $this->redirect(['../pdsold/pdm-berkas-tahap1/index']);
                                }

                           }
            $transaction = Yii::$app->db->beginTransaction();
            try {
				$model->id_berkas  =substr($_POST['PdmBerkasTahap1']['id_berkas'], 0,6).$_POST['PdmBerkasTahap1']['no_berkas'];

                // echo $model->id_berkas;exit;
                $files = UploadedFile::getInstance($model, 'file_upload');
                if ($files != false && !empty($files)) {
                    $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '', $seq['generate_pk_perkara']) . '.' . $files->extension;
                }
					
				if(!$model->save()){
					var_dump($model->getErrors());exit;
				}
                //Update tempat kejadian SPDP
                if (($_POST['PengantarBaru']['tmpt_kejadian']) != null || ($_POST['PengantarBaru']['waktu_kejadian']) != null) {
                    $UpdateTempatKejadian = Yii::$app->db->createCommand("UPDATE pidum.pdm_spdp SET tempat_kejadian = '" . $_POST['PengantarBaru']['tmpt_kejadian'] . "',tgl_kejadian_perkara= '" . $_POST['PengantarBaru']['waktu_kejadian'] . "' WHERE id_perkara = '" . $id2 . "' ");
                    $UpdateTempatKejadian->execute();
                }
					
                /*
                Mulai Untuk Update Pengantar        
                <------------------------------------------------------------------------------------------------------------------------>
                    Update Pengantar berjalan ketika ada perubahan di pengantar.
                 */
					if(isset($_POST['PengantarUpdate'])) // Terjadi Jika salah satu pengantar di perbaharui
					{
                        
						foreach($_POST['PengantarUpdate']['no_pengantar']  AS $key=>$no_pengantar)
                        {
                           //Start Update Pengantar ;
                           $id_pengantar    = $_POST['removePengantar']['id_pengantar'][$key];
                           $id_berkas       = $model->id_berkas;
                           $no_pengantar    = $no_pengantar;
                           $tgl_pengantar   = date('Y-m-d',strtotime($_POST['PengantarUpdate']['tgl_pengantar'][$key]));
                           $tgl_terima      = date('Y-m-d',strtotime($_POST['PengantarUpdate']['tgl_terima'][$key]));
                           $UpdatePengantar = Yii::$app->db->createCommand("UPDATE pidum.pdm_pengantar_tahap1 SET id_berkas = '" . $model->id_berkas . "',no_pengantar= '" .$no_pengantar."', tgl_pengantar = '" .$tgl_pengantar."', tgl_terima = '" .$tgl_terima. "' WHERE id_pengantar = '" . $id_pengantar. "' ");
                            $UpdatePengantar->execute();
                           // End Update Pengantar ;
                           
                           // Hapus Semua Tersangka dan undang-undang berdasarkan id pengantar yang di update
                           $no_pengantar_tersangka = str_replace($model->id_berkas.'|','',$id_pengantar);
                           MsTersangkaBerkas::deleteAll(['no_pengantar' => $no_pengantar_tersangka]);
                           PdmUuPasalTahap1::deleteAll(['id_pengantar'  => $id_pengantar]);
                           // End Hapus Tersangka dan Undang-undang berdasarkan id pengantar yang di update;
                           
                           //Insert Undang-Undang Yang baru jika pengantar di update;
                           $dakwaan_undang_undang = $_POST['MsUndang'][$id_pengantar]['dakwaan'];
                           foreach($dakwaan_undang_undang AS $_key_undang_undang => $_dakwaan_undang_undang)
                           {
                               $pdmPasal1 = new PdmUuPasalTahap1 ();
                                $seqPasal = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_uu_pasal_tahap1', 'id_pasal', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                                $pdmPasal1->id_pasal        =  $seqPasal['generate_pk'];
                                $pdmPasal1->id_pengantar    =  $model->id_berkas.'|'.$no_pengantar;
                                $pdmPasal1->undang          =  $_POST['MsUndang'][$id_pengantar]['undang'][$_key_undang_undang];
                                $pdmPasal1->pasal           =  $_POST['MsUndang'][$id_pengantar]['pasal'][$_key_undang_undang];
                                $pdmPasal1->dakwaan         =  $_POST['MsUndang'][$id_pengantar]['dakwaan'][$_key_undang_undang];
                                    if(!$pdmPasal1->save()){
                                        var_dump($pdmPasal1->getErrors());echo "Gagal Simpan Undang - Undang Saat Update Pengantar";exit;
                                    }

                           }
                            //End Insert Undang-Undang yang baru jika pengantar di update;

                           //Insert Tersangka Yang baru jika pengantar di update;
                           $no_urut_tersangka = $_POST['MsTersangkaBaru'][$id_pengantar]['no_urut'];
                           foreach ($no_urut_tersangka AS $keyTersangka => $_no_urut_tersangka)
                           {
                                $modelTersangka1 = new MsTersangkaBerkas();
                                $id_tersangka =  $id_pengantar."|".$_no_urut_tersangka;
                                $modelTersangka1->id_tersangka = $id_tersangka;
                                $modelTersangka1->tmpt_lahir = $_POST['MsTersangkaBaru'][$id_pengantar]['tmpt_lahir'][$keyTersangka];
                                $modelTersangka1->tgl_lahir = date('Y-m-d',strtotime($_POST['MsTersangkaBaru'][$id_pengantar]['tgl_lahir'][$keyTersangka]));
                                $modelTersangka1->umur = $_POST['MsTersangkaBaru'][$id_pengantar]['umur'][$keyTersangka];;
                                $modelTersangka1->alamat = $_POST['MsTersangkaBaru'][$id_pengantar]['alamat'][$keyTersangka];;
                                $modelTersangka1->no_identitas = $_POST['MsTersangkaBaru'][$id_pengantar]['no_identitas'][$keyTersangka];
                                $modelTersangka1->no_hp = $_POST['MsTersangkaBaru'][$id_pengantar]['no_hp'][$keyTersangka];
                                $modelTersangka1->warganegara = $_POST['MsTersangkaBaru'][$id_pengantar]['warganegara'][$keyTersangka];
                                $modelTersangka1->pekerjaan = $_POST['MsTersangkaBaru'][$id_pengantar]['pekerjaan'][$keyTersangka];
                                $modelTersangka1->suku = $_POST['MsTersangkaBaru'][$id_pengantar]['suku'][$keyTersangka];
                                $modelTersangka1->nama = $_POST['MsTersangkaBaru'][$id_pengantar]['nama'][$keyTersangka];
                                $modelTersangka1->id_jkl = $_POST['MsTersangkaBaru'][$id_pengantar]['id_jkl'][$keyTersangka];
                                $modelTersangka1->id_identitas = $_POST['MsTersangkaBaru'][$id_pengantar]['id_identitas'][$keyTersangka];
                                $modelTersangka1->id_agama = $_POST['MsTersangkaBaru'][$id_pengantar]['id_agama'][$keyTersangka];
                                $modelTersangka1->id_pendidikan = $_POST['MsTersangkaBaru'][$id_pengantar]['id_pendidikan'][$keyTersangka];
                                $modelTersangka1->no_urut = $_POST['MsTersangkaBaru'][$id_pengantar]['no_urut'][$keyTersangka];
                                $modelTersangka1->no_pengantar =  $no_pengantar ;
                                $modelTersangka1->id_berkas = $model->id_berkas;
                                if(!$modelTersangka1->save()){
                                    var_dump($modelTersangka1->getErrors());echo'Insert Jika Update';exit;
                                }
                           }
                            //End Insert Tersangka yang baru jika pengantar di update;

                        }
					}
                /*
                Akhir Untuk Update Pengantar        
                <------------------------------------------------------------------------------------------------------------------------>
        
                 */
                
                 /*
                Mulai Untuk Insert  Pengantar        
                <------------------------------------------------------------------------------------------------------------------------>
                    Insert Pengantar berjalan ketika ada penambahan baru pengantar .
                 */
                    if(isset($_POST['PengantarBaru'])) // terjadi jika pengantar sudah ada namun di perbaharui
                    {
                        $id_pengantar_baru = $_POST['PengantarBaru']['generate_id'];

                        foreach($id_pengantar_baru AS $key_pengantar_baru => $_id_pengantar_baru )
                        {
                            $modelPengantarSave = new PdmPengantarTahap1();
                            $modelPengantarSave->id_pengantar    = $model->id_berkas.'|'.$_POST['PengantarBaru']['no_pengantar'][$key_pengantar_baru];
                            $modelPengantarSave->id_berkas       = $model->id_berkas;
                            $modelPengantarSave->no_pengantar    = $_POST['PengantarBaru']['no_pengantar'][$key_pengantar_baru];
                            $modelPengantarSave->tgl_pengantar   = date('Y-m-d',strtotime($_POST['PengantarUpdate']['tgl_pengantar'][$key_pengantar_baru]));
                            $modelPengantarSave->tgl_terima      = date('Y-m-d',strtotime($_POST['PengantarUpdate']['tgl_terima'][$key_pengantar_baru]));
                            if(!$modelPengantarSave->save()){
                                    var_dump($modelPengantarSave->getErrors());exit;
                                }
                                   //Insert Undang-Undang Yang baru jika pengantar di update;
                                   $dakwaan_undang_undang_pengantar_baru = $_POST['MsUndang'][$_id_pengantar_baru]['dakwaan'];
                                   foreach($dakwaan_undang_undang_pengantar_baru AS $_key_undang_undang => $_dakwaan_undang_undang)
                                   {
                                       $pdmPasal1 = new PdmUuPasalTahap1 ();
                                        $seqPasal = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_uu_pasal_tahap1', 'id_pasal', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                                        $pdmPasal1->id_pasal        =  $seqPasal['generate_pk'];
                                        $pdmPasal1->id_pengantar    =  $model->id_berkas.'|'.$modelPengantarSave->no_pengantar;
                                        $pdmPasal1->undang          =  $_POST['MsUndang'][$_id_pengantar_baru]['undang'][$_key_undang_undang];
                                        $pdmPasal1->pasal           =  $_POST['MsUndang'][$_id_pengantar_baru]['pasal'][$_key_undang_undang];
                                        $pdmPasal1->dakwaan         =  $_POST['MsUndang'][$_id_pengantar_baru]['dakwaan'][$_key_undang_undang];
                                            if(!$pdmPasal1->save()){
                                                var_dump($pdmPasal1->getErrors());echo "Gagal Simpan Undang - Undang Saat Update Pengantar";exit;
                                            }

                                   }
                                    //End Insert Undang-Undang yang baru jika pengantar di update;
                    
                                    //Insert Tersangka Yang baru jika pengantar di update;
                                   $no_urut_tersangka = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['no_urut'];
                                   foreach ($no_urut_tersangka AS $keyTersangka => $_no_urut_tersangka)
                                   {
                                        $modelTersangka1 = new MsTersangkaBerkas();
                                        $id_tersangka =  $modelPengantarSave->id_pengantar ."|".$_no_urut_tersangka;
                                        $modelTersangka1->id_tersangka = $id_tersangka;
                                        $modelTersangka1->tmpt_lahir = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['tmpt_lahir'][$keyTersangka];
                                        $modelTersangka1->tgl_lahir = date('Y-m-d',strtotime($_POST['MsTersangkaBaru'][$_id_pengantar_baru]['tgl_lahir'][$keyTersangka]));
                                        $modelTersangka1->umur = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['umur'][$keyTersangka];;
                                        $modelTersangka1->alamat = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['alamat'][$keyTersangka];;
                                        $modelTersangka1->no_identitas = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['no_identitas'][$keyTersangka];
                                        $modelTersangka1->no_hp = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['no_hp'][$keyTersangka];
                                        $modelTersangka1->warganegara = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['warganegara'][$keyTersangka];
                                        $modelTersangka1->pekerjaan = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['pekerjaan'][$keyTersangka];
                                        $modelTersangka1->suku = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['suku'][$keyTersangka];
                                        $modelTersangka1->nama = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['nama'][$keyTersangka];
                                        $modelTersangka1->id_jkl = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['id_jkl'][$keyTersangka];
                                        $modelTersangka1->id_identitas = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['id_identitas'][$keyTersangka];
                                        $modelTersangka1->id_agama = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['id_agama'][$keyTersangka];
                                        $modelTersangka1->id_pendidikan = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['id_pendidikan'][$keyTersangka];
                                        $modelTersangka1->no_urut = $_POST['MsTersangkaBaru'][$_id_pengantar_baru]['no_urut'][$keyTersangka];
                                        $modelTersangka1->no_pengantar =  $_POST['PengantarBaru']['no_pengantar'][$key_pengantar_baru];
                                        $modelTersangka1->id_berkas = $model->id_berkas;
                                        if(!$modelTersangka1->save()){
                                            var_dump($modelTersangka1->getErrors());echo 'Insert Baru';exit;
                                        }
                                   }
                                    //End Insert Tersangka yang baru jika pengantar di update;

                        }
                          
                            
                            // echo '<pre>';
                            // print_r($_POST);exit;

                    }
                     /*
                        Akhir Untuk Update Pengantar        
                        <------------------------------------------------------------------------------------------------------------------------>
                
                         */
					// echo '<pre>';

					
					// print_r($_POST);exit;
				$UpdateBerkas = Yii::$app->db->createCommand("UPDATE pidum.pdm_berkas_tahap1 SET no_berkas = '". $_POST['PdmBerkasTahap1']['no_berkas'] . "',tgl_berkas= '" . $_POST['PdmBerkasTahap1']['tgl_berkas'] . "' WHERE id_berkas = '" . $_POST['PdmBerkasTahap1']['id_berkas'] . "' ");
                    $UpdateBerkas->execute();
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
                return $this->redirect(['../pdsold/pdm-berkas-tahap1/update?id='.$model->id_berkas]);
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);

                return $this->render('update', [
                            'model' => $model,
                            'dataProvider' => $dataProvider,
                            'sysMenu' => $sysMenu,
                            'modelSpdp' => $modelSpdp,
                            'modelTersangka' => $modelTersangka,
                            'modelPasal' => $modelPasal,
                            'modelPengantar' => $modelPengantar,
                            'array_uu' => $array_uu
                ]);
            }
            return $this->redirect(['update', 'id' => $model->id_berkas]);
        } else {

            return $this->render('update', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                        'sysMenu' => $sysMenu,
                        'modelSpdp' => $modelSpdp,
                        'modelPengantar' => $modelPengantar,
                        'modelTersangka' => $modelTersangka,
						'array_uu' => $array_uu
            ]);
        }
    }


    public function actionGetPengantarThp1()
    {
        $id_berkas =  $_POST['id_berkas'];
        $query = "select
                        a.id_berkas,
                        a.tgl_berkas,
                        d.id_p24,
                        a.no_berkas,
                        b.nama as nama_tersangka,
                        c.id_pengantar,
                        c.no_pengantar,
                        to_char(c.tgl_pengantar,'DD-MM-YYYY') as tgl_pengantar,
                        to_char(c.tgl_terima,'DD-MM-YYYY') as tgl_terima,
                        case when (e.id_pendapat_jaksa is null or e.id_pendapat_jaksa ='''') THEN '-' else 'Jaksa Sudah Memberikan Pendapat' end as keterangan,
						coalesce(to_char(e.tgl_selesai,'DD-MM-YYYY'),'-') as tgl_selesai,
						coalesce(e.id_ceklist,'0') as id_ceklist
                    FROM
                        pidum.pdm_berkas_tahap1 a
                        INNER JOIN pidum.pdm_pengantar_tahap1 c on a.id_berkas = c.id_berkas
                        INNER JOIN (SELECT id_berkas,STRING_AGG(nama, '<br/>' ORDER BY id_tersangka) as nama FROM pidum.ms_tersangka_berkas GROUP BY id_berkas) b on b.id_berkas = a.id_berkas
                        LEFT JOIN pidum.pdm_p24 d on d.id_pengantar = c.id_pengantar
						LEFT JOIN pidum.pdm_ceklist_tahap1 e on a.id_berkas = e.id_berkas
                    where c.id_berkas  = '".$id_berkas."'
                  ";

        $result = Yii::$app->db->createCommand($query)->queryAll();

        $data = array (
                        'count'     => count($result),
                        'result'    => str_replace("'","\'",trim(json_encode($result)))
                     );
      echo json_encode($data);
    }

    /**
     * Deletes an existing PdmBerkasTahap1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
		$id = $_POST['hapusIndex'];
        $modelPengantar = PdmPengantarTahap1::findOne(['id_berkas' => $id]);
        $idPengantar= $modelPengantar->id_pengantar;
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $connection = \Yii::$app->db;
        if($id == 'all'){
            $connection = \Yii::$app->db;
            $sqlDel = "delete from pidum.pdm_pengantar_tahap1 where id_berkas in (select id_berkas from pidum.pdm_berkas_tahap1 where id_perkara='".$id_perkara."')";
            echo $sqlDel;
            $exec_delete = $connection->createCommand($sqlDel);
            $exec_delete->execute();
            $sqlDelUU = "delete from pidum.pdm_uu_pasal_tahap1 where id_pengantar in (select id_pengantar from pidum.pdm_pengantar_tahap1 where id_berkas ='".$id[$i]."')";
            $exec_deleteUU = $connection->createCommand($sqlDelUU);
            $exec_deleteUU->execute();
            PdmBerkasTahap1::deleteAll(['id_perkara' => $id_perkara]);
            MsTersangkaBerkas::deleteAll(['id_perkara' => $id_perkara]);
            Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='1' WHERE (id_sys_menu = 'P-16' OR id_sys_menu = 'T-4' OR id_sys_menu = 'T-5') AND id_perkara=:id")
                ->bindValue(':id', $id_perkara)
                ->execute();
        }else{
           $count = 0;
           foreach($id AS $key_delete => $delete){
             try{
                    PdmBerkasTahap1::deleteAll(['id_berkas' => $delete]);
                }catch (\yii\db\Exception $e) {
                  $count++;
                }
            }
            if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  $count.' Data Berkas Tidak Dapat Dihapus Karena Sudah Digunakan Di Persuratan Lainnya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }
             
        }
         
		// $modelPengantar = PdmPengantarTahap1::findOne(['id_berkas' => $id]);
		// $idPengantar= $modelPengantar->id_pengantar;
		// $session = new Session();
		// $id_perkara = $session->get('id_perkara');
		// $connection = \Yii::$app->db;
  //       $transaction = $connection->beginTransaction();
  //       try {

		// 	if($id == "all"){

				// $connection = \Yii::$app->db;
				// $sqlDel = "delete from pidum.pdm_pengantar_tahap1 where id_berkas in (select id_berkas from pidum.pdm_berkas_tahap1 where id_perkara='".$id_perkara."')";
				// echo $sqlDel;
				// $exec_delete = $connection->createCommand($sqlDel);
				// $exec_delete->execute();
				// $sqlDelUU = "delete from pidum.pdm_uu_pasal_tahap1 where id_pengantar in (select id_pengantar from pidum.pdm_pengantar_tahap1 where id_berkas ='".$id[$i]."')";
				// $exec_deleteUU = $connection->createCommand($sqlDelUU);
				// $exec_deleteUU->execute();
				// PdmBerkasTahap1::deleteAll(['id_perkara' => $id_perkara]);
				// MsTersangkaBerkas::deleteAll(['id_perkara' => $id_perkara]);
				// Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='1' WHERE (id_sys_menu = 'P-16' OR id_sys_menu = 'T-4' OR id_sys_menu = 'T-5') AND id_perkara=:id")
				// 	->bindValue(':id', $id_perkara)
				// 	->execute();
		// 	}else{

		// 	   for ($i = 0; $i < count($id); $i++) {
		// 		   $cek = Yii::$app->db->createCommand(" SELECT count(*) jml FROM pidum.pdm_berkas_tahap1 a 
		// 		   LEFT join pidum.pdm_p18 b on a.id_berkas = b.id_berkas  
		// 		   LEFT JOIN pidum.pdm_p19 c ON a.id_berkas = c.id_berkas
		// 		   LEFT JOIN pidum.pdm_p20 d ON a.id_berkas = d.id_berkas
		// 		   LEFT JOIN pidum.pdm_p21 e ON a.id_berkas = e.id_berkas
		// 		   LEFT JOIN pidum.pdm_p22 f ON a.id_berkas = f.id_berkas
		// 		   LEFT JOIN pidum.pdm_p23 g ON a.id_berkas = g.id_berkas
		// 		   LEFT JOIN pidum.pdm_p24 h ON a.id_berkas = h.id_berkas
		// 		   LEFT JOIN pidum.pdm_ceklist_tahap1 i ON a.id_berkas = i.id_berkas
		// 		   WHERE a.id_berkas = '".$id[$i]."' AND (b.id_berkas IS NOT NULL OR c.id_berkas IS NOT NULL OR d.id_berkas IS NOT NULL OR e.id_berkas IS NOT NULL OR f.id_berkas IS NOT NULL OR g.id_berkas IS NOT NULL OR h.id_berkas IS NOT NULL )")->queryOne();
				   
		// 		if($cek['jml'] > 0){
		// 				Yii::$app->getSession()->setFlash('success', [
		// 					'type' => 'danger',
		// 					'duration' => 3000,
		// 					'icon' => 'fa fa-users',
		// 					'message' => 'Data Berkas  Sudah Digunakan Di Persuratan Lainnya',
		// 					'title' => 'Error',
		// 					'positonY' => 'top',
		// 					'positonX' => 'center',
		// 					'showProgressbar' => true,
		// 				]);
		// 				return $this->redirect(['index']);
		// 		}else{
					
		// 		$connection = \Yii::$app->db;
		// 		$sqlDel = "delete from pidum.ms_tersangka_berkas where id_berkas ='".$id[$i]."' ";
		// 		$exec_delete = $connection->createCommand($sqlDel);
		// 		$exec_delete->execute();
		// 		$sqlDelUU = "delete from pidum.pdm_uu_pasal_tahap1 where id_pengantar in (select id_pengantar from pidum.pdm_pengantar_tahap1 where id_berkas ='".$id[$i]."')";
		// 		$exec_deleteUU = $connection->createCommand($sqlDelUU);
		// 		$exec_deleteUU->execute();
		// 		   PdmBerkasTahap1::deleteAll(['id_berkas' => $id[$i]]);
		// 		   PdmPengantarTahap1::deleteAll(['id_berkas' => $id[$i]]);
		// 		}
		// 		}
		// 	}
		// 	Yii::$app->getSession()->setFlash('success', [
		// 	 'type' => 'success',
		// 	 'duration' => 3000,
		// 	 'icon' => 'fa fa-users',
		// 	 'message' => 'Data Berhasil di Hapus',
		// 	 'title' => 'Hapus Data',
		// 	 'positonY' => 'top',
		// 	 'positonX' => 'center',
		// 	 'showProgressbar' => true,
		// 	 ]);
		// 	$transaction->commit();
		// } catch(Exception $e) {

		// 	$transaction->rollback();
		// }
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
    }

    public function actionShowPasal(){
        $uu             = $_GET['uu'];
        $queryParams    = array_merge(array(),Yii::$app->request->queryParams);
        $queryParams["MsPasal"]["uu"] = $uu ;
        $searchPasal = new MsPasalSearch();
        $dataPasal = $searchPasal->search($queryParams);
        
        return $this->renderAjax('_pasal', [
            'searchPasal'   => $searchPasal,
            'dataPasal'     => $dataPasal,
            'id_uu'         => $uu
//            'nama'          => $nama,
        ]);
    }
    
    public function actionShowPengantarSimpan($idPengantar){
//        echo $idPengantar;exit();
      //echo '<pre>';print_r($_POST);exit;
        $ex_pengantar   = explode("|", $idPengantar);
        $no_pengantar   = $ex_pengantar[1];
        $no_berkas      = $ex_pengantar[0];
//        echo '<pre>';print_r(explode("|", $idPengantar));exit();
        
        $session        = new Session();
        $id             = $session->get('id_perkara');
        $modelSpdp      = PdmSpdp::findOne(['id_perkara' => $id]);
//        $idPengantar    = $_GET['id_pengantar'];

//        if($idPengantar != null){
//            $model              = PdmPengantarTahap1::findOne(['id_pengantar' => $idPengantar]);
//            $modelTersangka2    = MsTersangkaBerkas::find()
//                                ->where (['no_pengantar' => $no_pengantar])
//                                ->all();
            $modelBerkas        = PdmBerkasTahap1::findOne(['id_berkas' => $no_berkas]);
//            $modelUuTahap1	= PdmUuPasalTahap1::find()
//                                ->where(['id_pengantar' => $idPengantar])
//                                ->all();
////            echo '<pre>';print_r($modelUuTahap1);exit();
//        }else{
            $model              = New PdmPengantarTahap1();
//            $modelTersangka2    = new MsTersangkaBerkas();
            $qry       = "select * from pidum.pdm_pengantar_tahap1 where id_berkas = '".$no_berkas."' order by tgl_pengantar desc limit 1 ";
            $no_tar           = PdmUuPasalTahap1::findBySql($qry)->asArray()->one();
            
            $modelTersangka2    = MsTersangkaBerkas::find()
                                ->where (['no_pengantar' => $no_tar[no_pengantar]])
                                ->all();
//            echo '<pre>';print_r($modelTersangka2);exit();
            $modelUuTahap1	= PdmUuPasalTahap1::find()
                                ->where(['id_pengantar' => $no_berkas."|".$no_tar[no_pengantar]])
                                ->all();
//            echo '<pre>';print_r($modelUuTahap1[0][undang]);exit();
//            echo $modelUuTahap1[0][undang];exit();
//            $modelBerkas        = new PdmBerkasTahap1();
//        }
        $searchUU   = new MsUUndangSearch();
        $dataUU     = $searchUU->search(Yii::$app->request->queryParams);
        if ($model->load(Yii::$app->request->post())) {
        $transaction = Yii::$app->db->beginTransaction();
            try {
                //echo '<pre>';print_r($_POST);exit;
                $model->id_pengantar    = $no_berkas.'|'.$_POST['PdmPengantarTahap1']['no_pengantar'];
                $model->id_berkas       = $no_berkas;
                $model->no_pengantar    = $_POST['PdmPengantarTahap1']['no_pengantar'];
                $model->tgl_pengantar   = $_POST['PdmPengantarTahap1']['tgl_pengantar'];
                $model->tgl_terima      = $_POST['PdmPengantarTahap1']['tgl_terima'];
                if(!$model->save()){
                    var_dump($model->getErrors().' coba');exit;
                }
                
                PdmUuPasalTahap1::deleteAll(['id_pengantar' => $no_berkas.'|'.$_POST['PdmPengantarTahap1']['no_pengantar']]);

                  $dakwaan_undang_undang_pengantar_baru = $_POST['MsUndang']['undang'];
                    //echo '<pre>';print_r($dakwaan_undang_undang_pengantar_baru);exit;
                        $no = 0;
                        foreach($dakwaan_undang_undang_pengantar_baru AS $_key_undang_undang => $_dakwaan_undang_undang){
                          if(!empty($_dakwaan_undang_undang)){
                            $pdmPasal2 = new PdmUuPasalTahap1();
                            $pdmPasal2->id_pasal        =  Yii::$app->globalfunc->getSatker()->inst_satkerkd.date('Y').$no_berkas.'|'.$_POST['PdmPengantarTahap1']['no_pengantar'].$no;
                            $pdmPasal2->id_pengantar    =  $no_berkas.'|'.$_POST['PdmPengantarTahap1']['no_pengantar'];
                            $pdmPasal2->undang          =  $_dakwaan_undang_undang;
                            $pdmPasal2->pasal           =  $_POST['MsUndang']['pasal'][$_key_undang_undang];
                            $pdmPasal2->tentang           =  $_POST['MsUndang']['tentang'][$_key_undang_undang];
                            $pdmPasal2->dakwaan         =  $_POST['MsUndang']['dakwaan'][$_key_undang_undang];
                            if(!$pdmPasal2->save()){
                                var_dump($pdmPasal2->getErrors());echo "Gagal Simpan Undang - Undang Saat Update Pengantar";exit;
                            }
                            $no++;
                          }
                        }
                        
                /*$no_urut_tersangka = $_POST['MsTersangkaBaru'][$id_pengantar]['no_urut'];
                           foreach ($no_urut_tersangka AS $keyTersangka => $_no_urut_tersangka)
                           {
                                $modelTersangka1 = new MsTersangkaBerkas();
                                $id_tersangka =  $id_pengantar."|".$_no_urut_tersangka;
                                $modelTersangka1->id_tersangka = $id_tersangka;
                                $modelTersangka1->tmpt_lahir = $_POST['MsTersangkaBaru'][$id_pengantar]['tmpt_lahir'][$keyTersangka];
                                $modelTersangka1->tgl_lahir = date('Y-m-d',strtotime($_POST['MsTersangkaBaru'][$id_pengantar]['tgl_lahir'][$keyTersangka]));
                                $modelTersangka1->umur = $_POST['MsTersangkaBaru'][$id_pengantar]['umur'][$keyTersangka];;
                                $modelTersangka1->alamat = $_POST['MsTersangkaBaru'][$id_pengantar]['alamat'][$keyTersangka];;
                                $modelTersangka1->no_identitas = $_POST['MsTersangkaBaru'][$id_pengantar]['no_identitas'][$keyTersangka];
                                $modelTersangka1->no_hp = $_POST['MsTersangkaBaru'][$id_pengantar]['no_hp'][$keyTersangka];
                                $modelTersangka1->warganegara = $_POST['MsTersangkaBaru'][$id_pengantar]['warganegara'][$keyTersangka];
                                $modelTersangka1->pekerjaan = $_POST['MsTersangkaBaru'][$id_pengantar]['pekerjaan'][$keyTersangka];
                                $modelTersangka1->suku = $_POST['MsTersangkaBaru'][$id_pengantar]['suku'][$keyTersangka];
                                $modelTersangka1->nama = $_POST['MsTersangkaBaru'][$id_pengantar]['nama'][$keyTersangka];
                                $modelTersangka1->id_jkl = $_POST['MsTersangkaBaru'][$id_pengantar]['id_jkl'][$keyTersangka];
                                $modelTersangka1->id_identitas = $_POST['MsTersangkaBaru'][$id_pengantar]['id_identitas'][$keyTersangka];
                                $modelTersangka1->id_agama = $_POST['MsTersangkaBaru'][$id_pengantar]['id_agama'][$keyTersangka];
                                $modelTersangka1->id_pendidikan = $_POST['MsTersangkaBaru'][$id_pengantar]['id_pendidikan'][$keyTersangka];
                                $modelTersangka1->no_urut = $_POST['MsTersangkaBaru'][$id_pengantar]['no_urut'][$keyTersangka];
                                $modelTersangka1->no_pengantar =  $no_pengantar ;
                                $modelTersangka1->id_berkas = $model->id_berkas;
                                if(!$modelTersangka1->save()){
                                    var_dump($modelTersangka1->getErrors());echo'Insert Jika Update';exit;
                                }
                           }*/
                    foreach ($_POST['MsTersangkaBaru'] as $key => $value) {
                      //echo '<pre>';print_r($value['nama'][0]);
                      $modelTersangka1 = new MsTersangkaBerkas();
                      $modelTersangka1->tmpt_lahir = $value['tmpt_lahir'][0];
                      $modelTersangka1->id_tersangka = $no_berkas.'|'.$_POST['PdmPengantarTahap1']['no_pengantar'].'|'.$value['no_urut'][0];
                      $modelTersangka1->tgl_lahir = date('Y-m-d',strtotime($value['tgl_lahir'][0]));
                      $modelTersangka1->umur = $value['umur'][0];
                      $modelTersangka1->alamat = $value['alamat'][0];
                      $modelTersangka1->no_identitas = $value['no_identitas'][0];
                      $modelTersangka1->no_hp = $value['no_hp'][0];
                      $modelTersangka1->warganegara = $value['warganegara'][0];
                      $modelTersangka1->pekerjaan = $value['pekerjaan'][0];
                      $modelTersangka1->suku = $value['suku'][0];
                      $modelTersangka1->nama = $value['nama'][0];
                      $modelTersangka1->id_jkl = $value['id_jkl'][0];
                      $modelTersangka1->id_identitas = $value['id_identitas'][0];
                      $modelTersangka1->id_agama = $value['id_agama'][0];
                      $modelTersangka1->id_pendidikan = $value['id_pendidikan'][0];
                      $modelTersangka1->no_urut = $value['no_urut'][0];
                      $modelTersangka1->no_pengantar =  $model->no_pengantar ;
                      $modelTersangka1->id_berkas = $no_berkas;
                      
                      if(!$modelTersangka1->save()){
                          var_dump($modelTersangka1->getErrors());echo'Insert Jika Update';exit;
                      }
                    }
                    $transaction->commit();
//                    return $this->render(['update', 'id' => $no_berkas]);    
                    return $this->redirect(['../pdsold/pdm-berkas-tahap1/update?id='.$no_berkas]);
                
                
            } catch (Exception $exc) {
            $transaction->rollBack();
                echo $exc->getTraceAsString();
            }
        }else {
            return $this->render('_popPengantar', [
            'model'             => $model,
            'modelSpdp'         => $modelSpdp,
            'modelTersangka2'   => $modelTersangka2,
            'modelPasal'        => $modelPasal,
            'searchUU'          => $searchUU,
            'dataUU'            => $dataUU,
            'modelUuTahap1'     => $modelUuTahap1,
            'modelBerkas'       => $modelBerkas,
        ]);
        }
    }
    
    public function actionShowPengantar($idPengantar){
        
        $ex_pengantar   = explode("|", $idPengantar);
        $no_pengantar   = $ex_pengantar[1];
        $no_berkas      = $ex_pengantar[0];
//        echo '<pre>';print_r(explode("|", $idPengantar));exit();
//        echo $idPengantar;exit();
        
        $session        = new Session();
        $session->set('no_pengantar', $no_pengantar);
        $id             = $session->get('id_perkara');
        $modelSpdp      = PdmSpdp::findOne(['id_perkara' => $id]);
//        $idPengantar    = $_GET['id_pengantar'];

        if($idPengantar != null){
            $model              = PdmPengantarTahap1::findOne(['id_pengantar' => $idPengantar]);
            $modelTersangka2    = MsTersangkaBerkas::find()
                                ->where (['no_pengantar' => $no_pengantar])
                                ->all();
            $modelBerkas        = PdmBerkasTahap1::findOne(['id_berkas' => $no_berkas]);
            $modelUuTahap1	= PdmUuPasalTahap1::find()
                                ->where(['id_pengantar' => $idPengantar])
                                ->all();
//            echo '<pre>';print_r($modelUuTahap1);exit();
        }else{
            $model              = New PdmPengantarTahap1();
            $modelTersangka2    = new MsTersangkaBerkas();
        }
        $searchUU   = new MsUUndangSearch();
        $dataUU     = $searchUU->search(Yii::$app->request->queryParams);
        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->id_pengantar    = $no_berkas.'|'.$_POST['PdmPengantarTahap1']['no_pengantar'];
                $model->id_berkas       = $no_berkas;
                $model->no_pengantar    = $_POST['PdmPengantarTahap1']['no_pengantar'];
                $model->tgl_pengantar   = $_POST['PdmPengantarTahap1']['tgl_pengantar'];
                $model->tgl_terima      = $_POST['PdmPengantarTahap1']['tgl_terima'];
                if(!$model->save()){
                    var_dump($model->getErrors());exit;
                }
                
                PdmUuPasalTahap1::deleteAll(['id_pengantar' => $idPengantar]);

                  $dakwaan_undang_undang_pengantar_baru = $_POST['MsUndang']['undang'];
                    //echo '<pre>';print_r($dakwaan_undang_undang_pengantar_baru);exit;
                        $no = 0;
                        foreach($dakwaan_undang_undang_pengantar_baru AS $_key_undang_undang => $_dakwaan_undang_undang){
                          if(!empty($_dakwaan_undang_undang)){
                            $pdmPasal2 = new PdmUuPasalTahap1();
                            $pdmPasal2->id_pasal        =  Yii::$app->globalfunc->getSatker()->inst_satkerkd.date('Y').$no_berkas.'|'.$_POST['PdmPengantarTahap1']['no_pengantar'].$no;
                            $pdmPasal2->id_pengantar    =  $no_berkas.'|'.$_POST['PdmPengantarTahap1']['no_pengantar'];
                            $pdmPasal2->undang          =  $_dakwaan_undang_undang;
                            $pdmPasal2->pasal           =  $_POST['MsUndang']['pasal'][$_key_undang_undang];
                            $pdmPasal2->tentang         =  $_POST['MsUndang']['tentang'][$_key_undang_undang];
                            $pdmPasal2->dakwaan         =  $_POST['MsUndang']['dakwaan'][$_key_undang_undang];
                            if(!$pdmPasal2->save()){
                                var_dump($pdmPasal2->getErrors());echo "Gagal Simpan Undang - Undang Saat Update Pengantar";exit;
                            }
                            $no++;
                          }
                        }
                        
                /*$no_urut_tersangka = $_POST['MsTersangkaBaru'][$id_pengantar]['no_urut'];
                           foreach ($no_urut_tersangka AS $keyTersangka => $_no_urut_tersangka)
                           {
                                $modelTersangka1 = new MsTersangkaBerkas();
                                $id_tersangka =  $id_pengantar."|".$_no_urut_tersangka;
                                $modelTersangka1->id_tersangka = $id_tersangka;
                                $modelTersangka1->tmpt_lahir = $_POST['MsTersangkaBaru'][$id_pengantar]['tmpt_lahir'][$keyTersangka];
                                $modelTersangka1->tgl_lahir = date('Y-m-d',strtotime($_POST['MsTersangkaBaru'][$id_pengantar]['tgl_lahir'][$keyTersangka]));
                                $modelTersangka1->umur = $_POST['MsTersangkaBaru'][$id_pengantar]['umur'][$keyTersangka];;
                                $modelTersangka1->alamat = $_POST['MsTersangkaBaru'][$id_pengantar]['alamat'][$keyTersangka];;
                                $modelTersangka1->no_identitas = $_POST['MsTersangkaBaru'][$id_pengantar]['no_identitas'][$keyTersangka];
                                $modelTersangka1->no_hp = $_POST['MsTersangkaBaru'][$id_pengantar]['no_hp'][$keyTersangka];
                                $modelTersangka1->warganegara = $_POST['MsTersangkaBaru'][$id_pengantar]['warganegara'][$keyTersangka];
                                $modelTersangka1->pekerjaan = $_POST['MsTersangkaBaru'][$id_pengantar]['pekerjaan'][$keyTersangka];
                                $modelTersangka1->suku = $_POST['MsTersangkaBaru'][$id_pengantar]['suku'][$keyTersangka];
                                $modelTersangka1->nama = $_POST['MsTersangkaBaru'][$id_pengantar]['nama'][$keyTersangka];
                                $modelTersangka1->id_jkl = $_POST['MsTersangkaBaru'][$id_pengantar]['id_jkl'][$keyTersangka];
                                $modelTersangka1->id_identitas = $_POST['MsTersangkaBaru'][$id_pengantar]['id_identitas'][$keyTersangka];
                                $modelTersangka1->id_agama = $_POST['MsTersangkaBaru'][$id_pengantar]['id_agama'][$keyTersangka];
                                $modelTersangka1->id_pendidikan = $_POST['MsTersangkaBaru'][$id_pengantar]['id_pendidikan'][$keyTersangka];
                                $modelTersangka1->no_urut = $_POST['MsTersangkaBaru'][$id_pengantar]['no_urut'][$keyTersangka];
                                $modelTersangka1->no_pengantar =  $no_pengantar ;
                                $modelTersangka1->id_berkas = $model->id_berkas;
                                if(!$modelTersangka1->save()){
                                    var_dump($modelTersangka1->getErrors());echo'Insert Jika Update';exit;
                                }
                           }*/
            MsTersangkaBerkas::deleteAll(['no_pengantar'=>$no_pengantar]);
            foreach ($_POST['MsTersangkaBaru'] as $key => $value) {
              //echo '<pre>';print_r($value['nama'][0]);
              $modelTersangka1 = new MsTersangkaBerkas();
              $modelTersangka1->tmpt_lahir = $value['tmpt_lahir'][0];
              $modelTersangka1->id_tersangka = $value['id_tersangka'][0];
              $modelTersangka1->tgl_lahir = date('Y-m-d',strtotime($value['tgl_lahir'][0]));
              $modelTersangka1->umur = $value['umur'][0];
              $modelTersangka1->alamat = $value['alamat'][0];
              $modelTersangka1->no_identitas = $value['no_identitas'][0];
              $modelTersangka1->no_hp = $value['no_hp'][0];
              $modelTersangka1->warganegara = $value['warganegara'][0];
              $modelTersangka1->pekerjaan = $value['pekerjaan'][0];
              $modelTersangka1->suku = $value['suku'][0];
              $modelTersangka1->nama = $value['nama'][0];
              $modelTersangka1->id_jkl = $value['id_jkl'][0];
              $modelTersangka1->id_identitas = $value['id_identitas'][0];
              $modelTersangka1->id_agama = $value['id_agama'][0];
              $modelTersangka1->id_pendidikan = $value['id_pendidikan'][0];
              $modelTersangka1->no_urut = $value['no_urut'][0];
              $modelTersangka1->no_pengantar =  $model->no_pengantar ;
              $modelTersangka1->id_berkas = $no_berkas;
              
              if(!$modelTersangka1->save()){
                  var_dump($modelTersangka1->getErrors());echo'Insert Jika Update';exit;
              }
            }
//                    return $this->render(['update', 'id' => $no_berkas]);
                    $transaction->commit();    
                    return $this->redirect(['../pdsold/pdm-berkas-tahap1/update?id='.$no_berkas]);
                
                
            } catch (Exception $exc) {
                $transaction->rollBack();    
                echo $exc->getTraceAsString();
            }
        }else {
            return $this->render('_popPengantar', [
            'model'             => $model,
            'modelSpdp'         => $modelSpdp,
            'modelTersangka2'   => $modelTersangka2,
            'modelPasal'        => $modelPasal,
            'searchUU'          => $searchUU,
            'dataUU'            => $dataUU,
            'modelUuTahap1'     => $modelUuTahap1,
            'modelBerkas'       => $modelBerkas,
        ]);
        }
    }
    

    public function actionShowPengantar1()
	{

		$session = new Session();
        $id = $session->get('id_perkara');
		$modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);
		$idPengantar=$_GET['id_pengantar'];

		if($idPengantar != null){
		$model = PdmPengantarTahap1::findOne(['id_pengantar' => $idPengantar]);
		//$model = new PdmPengantarTahap1();
		$modelTersangka2 = MsTersangkaBerkas::find()
						  ->where (['id_pengantar' => $idPengantar])
						  ->all();
		$modelUuTahap1	  = PdmUuPasalTahap1::find()
						  ->where(['id_pengantar' => $idPengantar])
						  ->all();
						  }else{
		$model = New PdmPengantarTahap1();
		$modelTersangka2 = new MsTersangkaBerkas();
							   }
        $searchUU = new MsUUndangSearch();
        $dataUU = $searchUU->search(Yii::$app->request->queryParams);
		return $this->renderAjax('_popPengantar', [
                    'model'             => $model,
                    'modelSpdp'         => $modelSpdp,
                    'modelTersangka2'   => $modelTersangka2,
                    'modelPasal'        => $modelPasal,
                    'searchUU'          => $searchUU,
                    'dataUU'            => $dataUU,
                    'modelUuTahap1'     => $modelUuTahap1,
				]);
	}

	public function actionShowTersangka()
    {
	$idTersangka=$_GET['id_tersangka'];
        if($idTersangka !=""){
            $modelTersangka = MsTersangkaBerkas::findOne(['id_tersangka' => $_GET['id_tersangka']]);
        }else{
            $modelTersangka = new MsTersangkaBerkas();
			$id_tersangka = '';
        }

        $identitas = ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama');
        $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
        $pendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
		$maxPendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'umur');
        $JenisKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');
        $warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
        $warganegara_grid = new MsWarganegara();

        return $this->renderAjax('_popTersangka', [
            'modelTersangka'    => $modelTersangka,
            'agama'             => $agama,
            'identitas'         => $identitas,
			'JenisKelamin'		=> $JenisKelamin,
            'pendidikan'        => $pendidikan,
            'warganegara'       => $warganegara,
            'warganegara_grid'  => $warganegara_grid,
            'maxPendidikan'     => $maxPendidikan

        ]);
    }

     public function actionWn() {
        $searchModel = new MsWarganegara();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('_wn',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

     public function actionUpdateTersangka($id)
    {
        $model = MsTersangkaBerkas::findOne(['id_tersangka' => $id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $data   = $_POST['MsTersangka']['new_foto'];
            $id     = $_POST['MsTersangka']['id_tersangka'];
            if($data !='')
            {

                $contents_split = explode(',', $data);
                $encoded = $contents_split[count($contents_split)-1];
                $decoded = "";
                for ($a=0; $a < ceil(strlen($encoded)/256); $a++)
                {
                    $decoded = $decoded . base64_decode(substr($encoded,$a*256,256));
                }
                $name_foto = '../web/image/upload_file/tersangka_pidum/'.$id.'.jpg';
                $fp = fopen($name_foto, 'w');
                      fwrite($fp, $decoded);
                      fclose($fp);
            }

        }
    }


     public function actionReferTersangka() {
        $searchModel = new MsTersangkaSearch();
  //$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
         $dataProvider2 = $searchModel->searchTersangkaUnion('');
//var_dump ($dataProvider2);exit;
//echo $dataProvider['id_tersangka'];exit;
//$dataProvider->pagination->pageSize = 5;
        $dataProvider2->pagination->pageSize = 5;
        return $this->renderAjax('_tersangka', [
                    'searchModel'   => $searchModel,
                    'dataProvider'  => $dataProvider,
                    'dataProvider2' => $dataProvider2,
        ]);
    }

	/**
     * Finds the PdmBerkasTahap1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBerkasTahap1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmBerkasTahap1::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetakDraf(){
        $connection     = \Yii::$app->db;
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_pengantar   = Yii::$app->session->get('no_pengantar');
        $id_pengantar   = Yii::$app->session->get('id_berkas');
        $berkasdanpengantar = $id_pengantar.'|'.$no_pengantar;
        $spdp           = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        $nama_tersangka = Yii::$app->globalfunc->getListTerdakwaBerkas($no_pengantar);
        $pdm_berkas     = Yii::$app->db->createCommand(" select a.no_pengantar,a.tgl_pengantar,a.tgl_terima,b.no_berkas,b.tgl_berkas FROM  pidum.pdm_pengantar_tahap1 a,pidum.pdm_berkas_tahap1 b WHERE a.id_berkas = b.id_berkas AND a.id_pengantar = '".$berkasdanpengantar."' AND b.id_perkara = '".$id_perkara."' ")->queryOne();
//        echo '<pre>';print_r($pdm_berkas);exit();
        return $this->render('cetak',[
            'spdp'              =>$spdp,
            'nama_tersangka'    =>$nama_tersangka,
            'pdm_berkas'        =>$pdm_berkas
                ]);
    }
    
    public function actionCetak($id){
    
    $ex_id = explode('|', $id);
    $kd_berkas = $ex_id[0];
    $kd_pengantar = $ex_id[1];
//    echo '<pre>';print_r($kd_pengantar);exit;
		$connection = \Yii::$app->db;
    $odf = new \Odf(Yii::$app->params['report-path']."web/template/pdsold/checklist.odt");
		$id2 = Yii::$app->session->get('id_perkara');

    $spdp = PdmSpdp::findOne(['id_perkara' => $id2]);
        
    $pdm_berkas=Yii::$app->db->createCommand(" select a.no_pengantar,a.tgl_pengantar,a.tgl_terima,b.no_berkas,b.tgl_berkas FROM  pidum.pdm_pengantar_tahap1 a,pidum.pdm_berkas_tahap1 b WHERE a.id_berkas = b.id_berkas AND a.id_pengantar = '".$id."' AND b.id_perkara = '".$id2."' ")->queryOne();
//     echo '<pre>';print_r($pdm_berkas);exit;
		 


		# jpu peneliti
        $dft_jaksa_saksi ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_jaksa_p16')
                ->where("id_perkara='".$id2."'");
        $data = $query->createCommand();
        $listJaksaSaksi = $data->queryOne();
//        echo '<pre>';print_r($listJaksaSaksi);exit;


		/*$listTersangka = MsTersangkaBerkas::find()->select('tersangka.id_tersangka as id_tersangka, tersangka.nama as nama,berkas.id_perkara,berkas.id_berkas as id_berkas')
                    ->from('pidum.pdm_berkas_tahap1 berkas,pidum.pdm_pengantar_tahap1 tsk,pidum.ms_tersangka_berkas tersangka')
                    ->where("berkas.id_berkas = tsk.id_berkas AND tersangka.id_berkas = berkas.id_berkas AND berkas.id_perkara = '".$id2."' AND tsk.id_pengantar='".$id."' order by tersangka.no_urut asc  ")
                    ->all();
					
        if (count($listTersangka) == 1) {
            foreach ($listTersangka as $key) {
				$nama_tersangka = ucfirst(strtolower($key[nama])) ;
			}
        } else if(count($listTersangka) == 2){
			 $i=1;
			 
			 foreach ($listTersangka as $key) {
				if($i==1){
					$nama_tersangka .= ucfirst(strtolower($key[nama]))." dan " ;
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
		*/
		$nama_tersangka = Yii::$app->globalfunc->getListTerdakwaBerkas($kd_pengantar);
    //echo '<pre>';print_r($nama_tersangka);exit;

		$odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat( $pdm_berkas['tgl_pengantar']));
        $odf->setVars('no_berkas', $pdm_berkas['no_berkas']);
		$odf->setVars('tgl_berkas_perkara', Yii::$app->globalfunc->ViewIndonesianFormat($pdm_berkas['tgl_berkas']));
		$odf->setVars('no_pengantar', $pdm_berkas['no_pengantar']);
		$odf->setVars('tgl_pengantar', Yii::$app->globalfunc->ViewIndonesianFormat($pdm_berkas['tgl_terima']));
		$odf->setVars('jenis_perkara','-');
		$odf->setVars('disangkakan', $spdp->undang_pasal);
		$odf->setVars('masa_penyidik', '-');
		$tgl_pentuntutan = date('Y-m-d',strtotime($spdp->tgl_terima. "+14 days"));
		$odf->setVars('penuntutan',Yii::$app->globalfunc->ViewIndonesianFormat($tgl_pentuntutan));
        $odf->setVars('tgl_penyerahan', Yii::$app->globalfunc->ViewIndonesianFormat($pdm_berkas['tgl_terima']));
		$odf->setVars('jam_penyerahan','-');
		$odf->setVars('jpu_peneliti', '-');
		$odf->setVars('no_rp7', '-');
        $odf->setVars('nama_peneliti', $listJaksaSaksi['nama']);
        $odf->setVars('nama_tersangka', $nama_tersangka);
        $odf->setVars('nip_peneliti', $listJaksaSaksi['nip']);
		$odf->setVars('pangkat_peneliti', preg_replace("/\/ (.*)/", "", $listJaksaSaksi['pangkat']));
		$odf->setVars('waktu_peneliti', Yii::$app->globalfunc->ViewIndonesianFormat($pdm_berkas['tgl_pengantar'] ));

		/*$dft_tersangkaDetail = $odf->setSegment('tersangkaDetail');
		foreach ($modelTersangka as $element) {
			$dft_tersangkaDetail->nama_tersangka(ucfirst(strtolower($element['nama'])));
			$dft_tersangkaDetail->merge();
		}
		$odf->mergeSegment($dft_tersangkaDetail);*/

		$odf->exportAsAttachedFile('checklist.odt');
	}
        
        public function actionReferUndang() {
            $searchModel        = new MsUUndangSearch();
            $jns_tindak_pidana  = $_POST['kode_pidana'];
            if ($jns_tindak_pidana == ''){
                $query = MsUUndang::find();
            }else{
                $query = MsUUndang::find()
                ->where('jns_tindak_pidana = :jns_tindak_pidana', [':jns_tindak_pidana' => $jns_tindak_pidana]);
            }
            
            $dataProvider = new ActiveDataProvider([
               'query' => $query,
            ]);
            $dataProvider->pagination->pageSize = '10';

            return $this->renderAjax('//ms-pasal/_undang', [
                       'searchUU'   => $searchModel,
                       'dataUU'  => $dataProvider
            ]);
        }
        
        public function actionShowPasalDgKodePidana(){
           $uu = $_GET['id_uu'];
           $kode_pidana = $_GET['kode_pidana'];
           $jenis_perkara=$_GET['jenis_perkara'];
           /*if(isset($_GET['jenis_perkara'])){
               $query = MsPasal::find()
               ->where("id = :id and kode_pidana=:kode_pidana and jenis_perkara=:jenis_perkara",[':id'=>$uu,':kode_pidana'=>$kode_pidana,':jenis_perkara'=>$jenis_perkara]);
           }else{
               $query = MsPasal::find()
               ->where("id = :id and kode_pidana=:kode_pidana",[':id'=>$uu,':kode_pidana'=>$kode_pidana]);
           }*/

           $query = MsPasal::find();
           if(isset($_GET['jenis_perkara'])){
                $query->andFilterWhere(['=', 'kode_pidana', $kode_pidana])
                    ->andFilterWhere(['=', 'jenis_perkara', $jenis_perkara]);
           }else{
                $query->andFilterWhere(['=', 'kode_pidana', $kode_pidana]);
           }
           $searchPasal = new MsPasalSearch();

           $dataProvider = new ActiveDataProvider([
               'query' => $query,
           ]);
           $dataProvider->pagination->pageSize = '10';

           return $this->renderAjax('_pasal', [
               'searchPasal' => $searchPasal,
               'dataPasal' => $dataProvider,
               'id_uu'=>$uu,
               'kode_pidana'=>$kode_pidana,
               'jenis_perkara'=>$jenis_perkara,
           ]);
        }


        
}
