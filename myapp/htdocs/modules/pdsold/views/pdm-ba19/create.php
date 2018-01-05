<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa19 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba19-create">


    <?= $this->render('_form', [
        'model' => $model,
		'sysMenu' => $sysMenu,
				'wilayah' => $wilayah,
				'dataJPU' => $dataJPU,
            	'searchJPU' => $searchJPU,
            	'data_barbuk' => $data_barbuk,
    ]) ?>

</div>
