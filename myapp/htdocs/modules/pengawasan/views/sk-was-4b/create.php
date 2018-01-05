<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas4a */

$this->title = 'SK WAS 4B';
$this->subtitle = 'Surat Keputusan PHD Pemindahan Dalam Rangka Penurunan Jabatan Setingkat Lebih Rendah Sebagai PNS';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Sk Was4b', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'SURAT KEPUTUSAN PHD PEMINDAHAN DALAM RANGKA PENURUNAN JABATAN SETINGKAT LEBIH RENDAH SEBAGAI PNS';
?>
<div class="sk-was4b-create">
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
