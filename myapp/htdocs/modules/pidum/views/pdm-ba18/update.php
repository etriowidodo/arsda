<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa18 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba18-update">
    <?= $this->render('_form', [
        'model' => $model,
		'id_perkara' => $id_perkara,
		'modelJPenerima' => $modelJPenerima,
		'modelJSaksi' => $modelJSaksi,
		'modelBarbuk' => $modelBarbuk,
		'searchJPU' => $searchJPU,
		'dataJPU' => $dataJPU,
		'no_reg_tahanan' => $no_reg_tahanan,
    ]) ?>

</div>
