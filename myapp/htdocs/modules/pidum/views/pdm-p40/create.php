<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP40 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p40-create">


    <?= $this->render('_form', [
        'model' => $model,
		'sysMenu' => $sysMenu,
				'wilayah' => $wilayah,
				'dataJPU' => $dataJPU,
            	'searchJPU' => $searchJPU,
				'listTersangka' => $listTersangka,
    ]) ?>

</div>
