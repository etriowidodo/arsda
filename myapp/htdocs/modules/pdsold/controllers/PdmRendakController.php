<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmRendak;
use app\modules\pdsold\models\PdmTembusanRendak;
use app\modules\pdsold\models\PdmP21;
use app\modules\pdsold\models\PdmRendakSearch;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmP16;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmPengantarTahap1;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use app\modules\pdsold\models\PdmSysMenu;
use app\components\GlobalConstMenuComponent;
use yii\web\UploadedFile;
use yii\db\Query;
/**
 * PdmRendakController implements the CRUD actions for PdmRendak model.
 */
class PdmRendakController extends Controller
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
     * Lists all PdmRendak models.
     * @return mixed
     */
    public function actionIndex(){
        $berkas  = Yii::$app->session->get('perilaku_berkas');
        //echo '<pre>';print_r($berkas);exit;
        if($berkas == ''){
            $session        = new Session();
            $id_perkara     = $session->get('id_perkara');
            $searchModel    = new PdmRendakSearch();
            $dataProvider   = $searchModel->search($id_perkara);
            $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::RencanaDakwaan]);
            return $this->render('index', [
                'dataProvider'  => $dataProvider,
                'sysMenu'       => $sysMenu
            ]);
        }else{
            $session = new Session();
            $id_berkas = $session->get('id_berkas');
            //echo '<pre>';print_r($id_berkas);exit;
            $query ="select d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') as berkas,a.id_pengantar,coalesce(b.id_rendak,'0') as id_rendak ,string_agg(f.nama,', ') as nama
                    ,coalesce(to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),'-')  as tgl_rendak,d.id_berkas
                              from 
                              pidum.pdm_berkas_tahap1 d 
                              INNER JOIN (
                                            select x.* from 
                                            pidum.pdm_pengantar_tahap1 x inner join (
                                                    select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
                                            )y on x.id_pengantar = y.id_pengantar
                                        ) e on d.id_berkas = e.id_berkas
                              INNER JOIN pidum.ms_tersangka_berkas f on e.id_berkas = f.id_berkas
                              INNER JOIN pidum.pdm_p24 a on e.id_pengantar = a.id_pengantar
                              left join pidum.pdm_rendak b on d.id_berkas = b.id_berkas
                                    where d.id_berkas='".$berkas."' 
                                    GROUP BY d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') ,a.id_pengantar,coalesce(b.id_rendak,'0')
                              ,to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),d.id_berkas";

            $command  = Yii::$app->db->createCommand($query);
            $rows = $command->queryAll();
            $id_rendak = $rows[0]['id_rendak'];
            if($id_rendak==''){
                $id_rendak = '0';
            }
            return $this->redirect(['update','id'=>$id_rendak,'id_berkas'=>$berkas]);
        }
    }

    /**
     * Displays a single PdmRendak model.
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
     * Creates a new PdmRendak model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmRendak();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_rendak]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdmRendak model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id,$id_berkas)
    {
		$id_perkara = Yii::$app->session->get('id_perkara');
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::RencanaDakwaan]);
        $p21     = PdmP21::findOne(['id_berkas'=>$id_berkas]);
		$model = PdmRendak::findOne(['id_rendak' => $id]);
		
		if($model == null){
			$model = new PdmRendak();
			$file_lama = '';
		}else{
			$file_lama = $model->getOldAttributes()['file_upload'];
		}
                
//                $modelPengantar = PdmPengantarTahap1::findOne(['id_pengantar' => $id_pengantar]);
                $modelBerkas    = PdmBerkasTahap1::findOne(['id_berkas' =>  $id_berkas]);
                
        if ($model->load(Yii::$app->request->post()) ) {
			$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_rendak WHERE id_perkara='".$id_perkara."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
			$files = UploadedFile::getInstance($model, 'file_upload');
			
			if ($files != false && !empty($files) ) {
				if($file_lama !=''){
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/rendak_'.$file_lama.'.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/rendak_'.$file_lama.'.'.$files->extension;
					$files->saveAs($path);
				}else{
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/rendak_'.$jml_pt['jml'].'.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/rendak_'.$jml_pt['jml'].'.'.$files->extension;
					$files->saveAs($path);
				}
			}else{
				$model->file_upload = $file_lama;
			}
			
			if($id=='0'){
				
				$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_rendak', 'id_rendak', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
				$model->id_rendak = $seq['generate_pk'];
				$model->id_perkara = $id_perkara;
				$model->id_berkas = $id_berkas;
				
			}
			
			if($_POST['hdn_nama_penandatangan'] != ''){
				$model->nama = $_POST['hdn_nama_penandatangan'];
				$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
				$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
			}
			
			if(!$model->save()){
				var_dump($model->getErrors());exit;
			}
			
			
			
			PdmTembusanRendak::deleteAll(['id_rendak' => $model->id_rendak]);
            if (isset($_POST['new_tembusan'])) {
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanRendak();
                    $modelNewTembusan->id_rendak = $model->id_rendak;
                    $modelNewTembusan->id_tembusan = $model->id_rendak."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                    if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
					
                }
            }
			
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelBerkas' => $modelBerkas,
                'p21' => $p21,
                'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmRendak model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
		
		$id=$_POST['hapusIndex'];
		if($id=='all'){
			$id_perkara = Yii::$app->session->get('id_perkara');
			PdmRendak::deleteAll(['id_perkara'=>$id_perkara]);
		}else{
			$this->findModel($id)->delete();
		}
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmRendak model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmRendak the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmRendak::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionCetakblanko($id_berkas) {
		$connection = \Yii::$app->db;
		$odf = new \Odf(Yii::$app->params['report-path'] . "web/template/pdsold/rendak.odt");
		$id = Yii::$app->session->get('id_perkara');
        $spdp = PdmSpdp::findOne(['id_perkara' => $id]);
		$model = PdmRendak::findOne(['id_berkas'=>$id_berkas]);
		
		$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);	
		$odf->setVars('dakwaan', $model->dakwaan);	
		$odf->setVars('dikeluarkan', $model->dikeluarkan);	
		$odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));

		$odf->setVars('nama_jpu', $model->nama);
        $odf->setVars('pangkat_jpu', $model->pangkat);
        $odf->setVars('nip_jpu', $model->id_penandatangan);
		
		# tersangkadugaan-pelanggaran
        $sql_tersangka = " select a.*,b.nama as warganegara,c.nama as is_agama, d.nama as is_pendidikan FROM pidum.ms_tersangka_berkas a INNER JOIN public.ms_warganegara b on a.warganegara=b.id INNER JOIN public.ms_agama c ON a.id_agama = c.id_agama INNER JOIN public.ms_pendidikan d on a.id_pendidikan = d.id_pendidikan WHERE a.id_berkas='".$id_berkas."' ORDER BY a.no_urut asc ";
        $model_tersangka = $connection->createCommand($sql_tersangka);
        $tersangka = $model_tersangka->queryAll();

       
        $dft_tersangkaDetail = $odf->setSegment('tersangkaDetail');
		
        $j = 1;
        foreach ($tersangka as $element) {
            if ($element['tgl_lahir']) {
                $umur = Yii::$app->globalfunc->datediff($tersangka[($j - 1)]['tgl_lahir'], date("Y-m-d"));
                $tgl_lahir = $umur['years'] . ' tahun / ' . Yii::$app->globalfunc->ViewIndonesianFormat($tersangka[($j - 1)]['tgl_lahir']);
            } else {
                $tgl_lahir = '-';
            }
            if (count($tersangka) > 1) {
                $dft_tersangkaDetail->urutan($j . '.');
				
            } else {
                $dft_tersangkaDetail->urutan('');
            }
			//CMS_PIDUM004_35 03 juni 2016 #bowo #menambahkan kondisi default ( - ) jika data null
			if ($element['tmpt_lahir'] != '') {
				$tempat_lahir = strtolower($element['tmpt_lahir']);
			} else {
				$tempat_lahir = '-';
			}
			
			if ($element['id_jkl'] != '') {
				if($element['id_jkl']=='1'){
					$jns_kelamin = 'Laki-Laki';
				}else{
					$jns_kelamin = 'Perempuan';
				}
			} else {
				$jns_kelamin = '-';
			}
			
			if ($element['warganegara'] != '') {
				$warganegara = strtolower($element['warganegara']);
			} else {
				$warganegara = '-';
			}
			if ($element['alamat'] != '') {
				$tmpt_tinggal = $element['alamat'];
			} else {
				$tmpt_tinggal = '-';
			}
			if ($element['is_agama'] != '') {
				$agama = strtolower($element['is_agama']);
			} else {
				$agama = '-';
			}
			if ($element['pekerjaan'] != '') {
				$pekerjaan = strtolower($element['pekerjaan']);
			} else {
				$pekerjaan = '-';
			}	
			if ($element['is_pendidikan'] != '') {
				$pendidikan = $element['is_pendidikan'];
			} else {
				$pendidikan = '-';
			}
			//end
			
            $dft_tersangkaDetail->nama_lengkap($element['nama']);
			$dft_tersangkaDetail->tempat_lahir($tempat_lahir);
            $dft_tersangkaDetail->tgl_lahir(ucfirst(strtolower($tgl_lahir)));
            $dft_tersangkaDetail->jns_kelamin(ucfirst(strtolower($jns_kelamin)));
            $dft_tersangkaDetail->warganegara(ucfirst(strtolower($warganegara)));
            $dft_tersangkaDetail->tmpt_tinggal($tmpt_tinggal);
            $dft_tersangkaDetail->agama(ucfirst(strtolower($agama)));
            $dft_tersangkaDetail->pekerjaan($pekerjaan);
            $dft_tersangkaDetail->pendidikan($pendidikan);
            $dft_tersangkaDetail->lain_lain('-');
            $dft_tersangkaDetail->merge();
			//print_r($dft_tersangkaDetail);exit;
            $j++;
        }
        $odf->mergeSegment($dft_tersangkaDetail);
		
		#tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_rendak')
                ->where(" id_rendak ='".$model->id_rendak."' ")
                ->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
		$i=1;
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($i);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
			$i++;
        }
        $odf->mergeSegment($dft_tembusan);
		
		$odf->exportAsAttachedFile('rendak.odt');
	}
}
