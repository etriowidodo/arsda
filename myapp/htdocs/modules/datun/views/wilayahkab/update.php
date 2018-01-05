<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsInstPenyidik */

$this->title = 'Update Wilayah Kabupaten' ;
/*
$this->params['breadcrumbs'][] = ['label' => 'Instansi Penyidik', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="ms-wilayah-kabupaten-update">

    <?= $this->render('_form_update', [
        'model' 	=> $model,
		'kode'      => $kode,
		'deskrip'    	=> $deskrip,
    ]) ?>

</div>
