<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'P2 - Surat Perintah Penyelidikan';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Dilanjutkan ke Penyelidikan setelah penelitian', 'url' => ['index?id='.$modelLid->id_pds_lid]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
        'model' => $model,
        'modelLid' => $modelLid,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,
    	'modelSuratDetail'=>$modelSuratDetail,
		'modelKpPegawai' =>$modelKpPegawai,
    	'modelJaksa'=>$modelJaksa,		
    	'typeSurat' => 'p2',
    	'titleForm' => 'Surat Perintah Penyelidikan',
    	'readOnly' => false,	
    ]) ?>

</div>
