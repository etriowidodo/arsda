<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas4a */

$this->title = 'SK WAS 3B';
$this->subtitle = 'Surat Keputusan PHD Penundaan Kenaikan Pangkat Selama 1 (Satu) Tahun Sebagai PNS';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Sk Was3b', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'SURAT KEPUTUSAN PHD PENUNDAAN KENAIKAN PANGKAT SELAMA 1 (SATU) TAHUN SEBAGAI PNS';
?>
<div class="sk-was3b-create">
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
