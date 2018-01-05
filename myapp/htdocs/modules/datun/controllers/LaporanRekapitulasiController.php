<?php

namespace app\modules\datun\controllers;
use app\modules\datun\models\HarianSidang;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Jaspersoft\Client\Client;
use yii\web\Session;
use yii\helpers\ArrayHelper;
use app\components\ConstSysMenuComponent;
use app\models\Images;
use yii\web\UploadedFile;;

/**
 * WilayahController implements the CRUD actions for MsWilayah model.
 */
class LaporanRekapitulasiController extends Controller
{


    /**
     * Lists all MsWilayah models.
     * @return mixed
     */
    public function actionIndex(){
     return $this->render('index');
    }

    public function actionCetak(){
		$tahun= Yii::$app->request->post('thn');
		$b= Yii::$app->request->post('bln');
		$bulan= $b+1;
		
		if(($bulan+1)=='13'){
			$tahun = $tahun+1;
		}
		
		$lima = HarianSidang::findBySql("select count(no_register_perkara) as bln_lalu from datun.permohonan
		where no_register_perkara is not null and 
		upper(status) like upper('%S-22%') 
		and tanggal_permohonan<'$tahun-$bulan-01'")->asArray()->one();
		
		$enam = HarianSidang::findBySql("select count(no_register_perkara) as jml_masuk from datun.permohonan
				where no_register_perkara is not null
				and tanggal_permohonan>='$tahun-$bulan-01' 
				and tanggal_permohonan<='$tahun-$bulan-01'")->asArray()->one();
		
		$delapan = HarianSidang::findBySql("select count(a.no_register_perkara) as luar_pengadilan from datun.mediasi a
					join datun.s11 b on a.no_register_perkara=b.no_register_perkara
					and a.no_register_skk=b.no_register_skk 
					and a.tanggal_skk=b.tanggal_skk 
					and a.no_surat=b.no_surat
					where a.no_register_perkara is not null
					and b.no_sidang='1'
					and b.tanggal_s11>='$tahun-$bulan-01' 
					and b.tanggal_s11<='$tahun-$bulan-01'
					and a.proses_mediasi='Berhasil'")->asArray()->one();
		
		$sembilan = HarianSidang::findBySql("select count(no_register_perkara) as penetapan_pengadilan from datun.permohonan
		where no_register_perkara is not null and 
		upper(status) like upper('%S-22%') 
		and tanggal_permohonan<'$tahun-$bulan-01'")->asArray()->one();
		
	  return $this->render('cetak', [
	   'lima' 			=> $lima,
	   'enam' 			=> $enam,
	   'delapan' 		=> $delapan,
	   'sembilan'		=> $sembilan,
	   'tahun' 			=> $tahun,
	   'bulan'  		=> $bulan,
	   ]);
	   
	} 
		
	public function actionGet_ttd(){				
		 
	$searchModel = new HarianSidang;
		$dataProvider = $searchModel->searchTtd(Yii::$app->request->get());
		return $this->renderAjax('_ttd', ['dataProvider' => $dataProvider]);
	
	} 
		
}


