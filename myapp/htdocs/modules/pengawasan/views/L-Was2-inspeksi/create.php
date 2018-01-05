<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was27Klari */

$this->title = 'L WAS 2';
$this->subtitle ='LAPORAN HASIL KASUS';
$this->params['breadcrumbs'][] = ['label' => 'Lwas 2', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 $session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="lwas2-inspeksi-create">

   

     <?= $this->render('_form', [
        'model' => $model,
        'modelLapdu' => $modelLapdu,
        'modelHukdis' => $modelHukdis,
        'modelHukdis2' => $modelHukdis2,
       // 'modelTembusanMaster' => $modelTembusanMaster,
        'modelPelapor' => $modelPelapor,
        'modelTerlapor' => $modelTerlapor,
        'modelInternal' => $modelInternal,
        'modelEksternal' => $modelEksternal,
		// 'spwas1' => $spwas1,
    ]) ?>

</div>
