<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\datun\models\MsWilayah */

$this->title = 'Hapus Wilayah Kabupaten' ;
/*
$this->params['breadcrumbs'][] = ['label' => 'Instansi Penyidik', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="ms-wilayah-kabupaten-delete">

    <?= $this->render('_form', [
        'model' => $model,
		'kode'      => $kode,
		//'idprop'      => $idprop,
    ]) ?>

</div>
