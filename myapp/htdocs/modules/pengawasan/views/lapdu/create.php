<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Lapdu */

$this->title = 'Laporan Pengaduan (LAPDU)';
$this->params['breadcrumbs'][] = ['label' => 'Lapdus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lapdu-create">
<h1><?php //= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelPelapor' => $modelPelapor,
        'modelTerlapor' =>  $modelTerlapor,
        'modelBidang' =>  $modelBidang,
		'dataProvider' => $dataProvider,
         'dataProviderKejati' => $dataProviderKejati,
         'dataProviderKejari' => $dataProviderKejari,
         'dataProviderCabjari' => $dataProviderCabjari,
        'tgl' => $tgl,
        'bln' => $bln,
        'thn' => $thn,
		'warganegara'       => $warganegara,
    
        //'thn2' =>  'ddd'
    ]) ?>

</div>
