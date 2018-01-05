<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas4a */

$this->title = 'SK WAS 3A';
$this->subtitle = 'Surat Keputusan PHD Penundaan Kenaikan Gaji Berkala Selama 1 (Satu) Tahun Sebagai PNS';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Sk Was3a', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'SURAT KEPUTUSAN PHD PENUNDAAN KENAIKAN GAJI BERKALA SELAMA 1 (SATU) TAHUN SEBAGAI PNS';
?>
<div class="sk-was3a-create">
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
