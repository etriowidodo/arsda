<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsInstPenyidik */

$this->title = 'Tambah Wilayah Kabupaten';
/*
$this->params['breadcrumbs'][] = ['label' => 'Instansi Penyidik', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
*/
?>
<div class="ms-wilayah-kabupaten-create">
    <?= $this->render('_form', [
        'model' 	=> $model,
		'kode'      => $kode,
		//'idprop'      => $idprop,,
		//'idp' 		=> $model->id_prop
    ]) ?>

</div>
