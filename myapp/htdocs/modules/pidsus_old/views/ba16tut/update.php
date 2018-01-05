<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'BA 16 - Berita Acara Penggeledahan/Penyitaan';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/viewlaporandik?id='.$model->id_pds_dik]];
//$this->params['breadcrumbs'][] = 'B12';
$this->params['idtitle']=$_SESSION['noSpdpTut'];
?>
<div class="pds-tut-update">

   
    <?= $this->render('_form', [
        'model' => $model,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,
		'modelSuratDetail'=>$modelSuratDetail,
    	'typeSurat' => $model->id_jenis_surat,
		'modelJaksa' =>$modelJaksa,
		//  'modelJaksaAll' =>$modelJaksaAll,
		'modelSuratJaksa'=>$modelSuratJaksa,
		//'modelSuratJaksaSaksi'=>$modelSuratJaksaSaksi,

		'titleForm' => $this->title,
    	'readOnly' => false,	
    ]) ?>

</div>