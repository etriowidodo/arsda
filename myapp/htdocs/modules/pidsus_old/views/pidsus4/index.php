<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'Pidsus 4 - Usul untuk pemanggilan, permintaan data, dan tindakan lain' ;

//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = $titleForm;

$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
        'model' => $model,
        'modelLid' => $modelLid,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,
		//'modelKpPegawai' =>$modelKpPegawai,
		'modelPermintaanData'=>$modelPermintaanData,
    	'modelJaksa'=>$modelJaksa,		
    	'typeSurat' => '1',
    	'titleForm' => $titleForm,
    	'readOnly' => $readOnly,	
    ]) ?>

</div>
