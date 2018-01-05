<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas4d */

//$this->title = 'Update Sk Was4d: ' . ' ' . $model->id_sk_was_4d;
$this->title = 'Daftar SK-WAS-3A';
$this->params['breadcrumbs'][] = ['label' => 'Sk Was3a', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_sk_was_3a, 'url' => ['view', 'id' => $model->id_sk_was_3a]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="sk-was3a-update">

    

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
        'modelPemeriksa'   => $modelPemeriksa,
        'dataPelapor'   => $dataPelapor,
        'modelSpWas2'   => $modelSpWas2,
        'dataPemeriksa'   => $dataPemeriksa,
        'dataLapdu'   => $dataLapdu,
        'modelUraian'   => $modelUraian,
     //   'dataPelapor'   => $dataPelapor,
        'dataTerlapor'   => $dataTerlapor,
        'dataPeraturan'   => $dataPeraturan,
    ]) ?>

</div>
