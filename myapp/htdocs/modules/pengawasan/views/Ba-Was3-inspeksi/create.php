<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Tambah BA-WAS-3 Inspeksi';
$this->params['breadcrumbs'][] = ['label' => 'Tambah BA-WAS-3 Inspeksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php 
    	// print_r($modelSpWas2['tanggal_sp_was2']);
    	// exit();
    ?>
    <?= $this->render('_form', [
        'model' => $model,
        'modelSpWas2' => $modelSpWas2,
    ]) ?>

</div>
