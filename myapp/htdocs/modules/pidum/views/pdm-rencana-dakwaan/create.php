<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT8 */

$this->title = "Rencana Dakwaan";
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-rencana-dakwaan-create">

    <?= $this->render('_form', [
        'model' => $model,
		'id_berkas' =>$id_berkas,
		'modelJPU' => $modelJPU,
		 'modelJpu2' => $modelJpu2,
						  'modelJpu3' => $modelJpu3,
		'modelUu' => $modelUu,
        'modelRp9' => $modelRp9,
        'modelSpdp' => $modelSpdp,
		'modelPasal' => $modelPasal,
        'modelAmarPutusan' => $modelAmarPutusan,
    ]) ?>

</div>
