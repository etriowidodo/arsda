<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */

$this->title = 'Dugaan Pelanggaran';
$this->params['ringkasan_perkara'] = $model->id_register;
$this->params['breadcrumbs'][] = ['label' => 'Dugaan Pelanggaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="dugaan-pelanggaran-create">

    <?= $this->render('_form', [
        'model' => $model,
		'searchPegawai' => $searchPegawai,
		'dataProviderPegawai' => $dataProviderPegawai,
		'searchSatker' => $searchSatker,
		'dataProviderSatker' => $dataProviderSatker,
		'pelapor'=>$pelapor,
		'terlapor'=>$terlapor,
		'tembusan'=>$tembusan,
    ]) ?>

</div>
