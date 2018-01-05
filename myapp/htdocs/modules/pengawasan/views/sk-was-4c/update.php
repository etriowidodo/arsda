<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas4d */

//$this->title = 'Update Sk Was4d: ' . ' ' . $model->id_sk_was_4d;
$this->title = 'Daftar SK-WAS-4C';
$this->params['breadcrumbs'][] = ['label' => 'Sk Was4c', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_sk_was_4c, 'url' => ['view', 'id' => $model->id_sk_was_4c]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="sk-was4c-update">

    

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
