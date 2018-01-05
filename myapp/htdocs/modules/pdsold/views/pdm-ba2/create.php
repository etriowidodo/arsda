<?php

use yii\helpers\Html;


$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba2-create">

    <h1><?= Html::encode($this->title) ?></h1>

      <?= $this->render('_form', [
        'model' => $model,
		'modeljaksi' => $modeljaksi,
		'modelpenyidik' =>$modelpenyidik,
		'searchJPU' => $searchJPU,
		'dataJPU' => $dataJPU,
		'modelTersangka' => $modelTersangka,
		'modelSpdp' => $modelSpdp,
		'modelMsSaksi'=>$modelMsSaksi,
		'searchTerdakwa' => $searchTerdakwa,
        'dataTerdakwa' => $dataTerdakwa,
		'id' => $id,
	]) ?>

</div>
