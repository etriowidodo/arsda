<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'LB-2 : Laporan Penyelesaian Barang Bukti ';
$this->subtitle=$satker;
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/viewlaporandik?id='.$model->id_pds_dik]];
//$this->params['breadcrumbs'][] = 'LP1';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
    	'titleForm' => $this->title,
    	'readOnly' => false,	
    ]) ?>

</div>
