<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT12 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;

?>
<div class="pdm-t12-update">

      <?= $this->render('_form', [
        'model' => $model,
		'tahanan' => $tahanan,
        'modelt8' => $modelt8,
        'modelRp9' => $modelRp9,
        'modelRt3' => $modelRt3,
        'modelTersangka' => $modelTersangka,
        'modeljaksiChoosen' => $modeljaksiChoosen,
        'modeljaksi' => $modeljaksi,
        'searchTersangka' => $searchTersangka,
        'dataTersangka' => $dataTersangka,
        'sysMenu' => $sysMenu
    ]) ?>

</div>


