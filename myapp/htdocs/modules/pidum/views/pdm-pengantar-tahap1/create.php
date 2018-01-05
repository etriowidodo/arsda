<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPengantarTahap1 */
//$this->title = $sysMenu->kd_berkas;
//$this->subtitle = $sysMenu->keterangan;

$this->title = 'Pengantar Berkas Tahap 1';
$this->subtitle = 'Tambah Pengantar';

?>
<div class="pdm-pengantar-tahap1-create">

    <?= $this->render('_form', [
        'model' => $model,
		'searchModel' => $searchModel,
		'dataProvider' => $dataProvider,
		'sysMenu'=>$sysMenu,
		'modelSpdp' => $modelSpdp,
		'modelTersangka' => $modelTersangka,
		'modelPasal' => $modelPasal,
		
    ]) ?>

</div>
