<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa16 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba16-create">

 

    <?= $this->render('_form', [
        'model' => $model,
		'wilayah' => $wilayah,
		'modelJpu' => $modelJpu,
		'listTersangka' => $listTersangka,
		'data_barbuk' => $data_barbuk,
    ]) ?>

</div>
