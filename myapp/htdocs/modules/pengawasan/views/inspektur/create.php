<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\WasDisposisiInspektur */

$this->title = 'Laporan Pengaduan (LAPDU)';
$this->params['ringkasan_perkara'] = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'lapdu', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="was-disposisi-inspektur-create">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'pelapor' => $pelapor,
        'terlapor' => $terlapor,
        'modelLapdu' => $modelLapdu,
    ]) ?>

</div>
