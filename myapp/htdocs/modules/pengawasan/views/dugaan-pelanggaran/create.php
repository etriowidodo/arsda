<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */

$this->title = 'Dugaan Pelanggaran';
$this->params['breadcrumbs'][] = ['label' => 'Dugaan Pelanggaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Tambah';
?>
<div class="dugaan-pelanggaran-create">

    <?php /*?><h1><?= Html::encode($this->title) ?></h1><?php */?>

    <?= $this->render('_form', [
        'model' => $model,
		'searchPegawai' => $searchPegawai,
		'dataProviderPegawai' => $dataProviderPegawai,
		'searchSatker' => $searchSatker,
		'dataProviderSatker' => $dataProviderSatker,
    ]) ?>

</div>
