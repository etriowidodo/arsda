<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas4a */

$this->title = 'SK WAS 3C';
$this->subtitle = 'Surat Keputusan PHD Penurunan Pangkat Setingkat Lebih Rendah Selama 1 (Satu) Tahun Sebagai PNS';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Sk Was3c', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'SURAT KEPUTUSAN PHD PENURUNAN PANGKAT SETINGKAT LEBIH RENDAH SELAMA 1 (SATU) TAHUN SEBAGAI PNS';
?>
<div class="sk-was3c-create">
<br>
    <?= $this->render('_form', [
        'model' => $model,
        'modelPemeriksa' => $modelPemeriksa,
        'modelPelapor' => $modelPelapor,
        'dataPemeriksa' => $dataPemeriksa,
        'dataPelapor' => $dataPelapor,
        'dataTerlapor' => $dataTerlapor,
        'modelTembusanMaster' => $modelTembusanMaster,
        'dataLapdu' => $dataLapdu,
        'dataPeraturan' => $dataPeraturan,
       
    ]) ?>

</div>
