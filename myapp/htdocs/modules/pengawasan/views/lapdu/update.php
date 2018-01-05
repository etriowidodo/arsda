<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lapdu */

// $this->title = 'Update Lapdu: ' . ' ' . $model->no_register;
// $this->params['breadcrumbs'][] = ['label' => 'Lapdus', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->no_register, 'url' => ['view', 'id' => $model->no_register]];
// $this->params['breadcrumbs'][] = 'Update';
$this->title = 'Laporan Pengaduan (LAPDU)';
$this->params['ringkasan_perkara'] = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'lapdu', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="lapdu-update">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?
    echo $this->render('_form', [
        'model' => $model,
        'modelPelapor' => $modelPelapor,
        'modelTerlapor' => $modelTerlapor,
        'pelapor' => $pelapor,
        'terlapor' => $terlapor,
        'dataProvider' => $dataProvider,
        'dataProviderKejati' => $dataProviderKejati,
        'dataProviderKejari' => $dataProviderKejari,
        'dataProviderCabjari' => $dataProviderCabjari,
        'tgl' => $tgl,
        'bln' => $bln,
        'thn' => $thn,
        'modelBidang' => $modelBidang,
        'modelUnit' => $modelUnit,
		'warganegara'       => $warganegara,
    ]) ?>

</div>
