<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = $titleSurat;
//$this->subtitle=$subTitleSurat;
//$this->params['idtitle']=$_SESSION['noLapLid'];
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/viewlaporan?id='.$model->id_pds_lid]];
//$this->params['breadcrumbs'][] = 'Pidsus 2';
//$this->params['idtitle']=$_SESSION['noLapLid'];
$_SESSION['debug'] = $_SESSION['debug'].", A.".(new \DateTime())->format('H:i:s');
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
        'model' => $model,
        'modelLid' => $modelLid,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,
    	'typeSurat' => $model->id_jenis_surat,
    	'titleForm' => $this->title,
    	'readOnly' => false,	
    ]) ?>

</div>
