<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas4a */

$this->title = 'SK WAS 2B';
$this->subtitle = 'Surat Keputusan PHD Teguran Tertulis Sebagai PNS';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Sk Was2b', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'SURAT KEPUTUSAN PHD TEGURAN TERTULIS SEBAGAI PNS';
?>
<div class="sk-was2b-create">
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
