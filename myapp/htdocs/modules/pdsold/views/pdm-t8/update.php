<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT8 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;

?>
<div class="pdm-t8-update">

    <?= $this->render('_form', [
        'model' => $model,
        'no_register_perkara' => $no_register_perkara,
        'modelRp9' => $modelRp9,
        'modelSpdp' => $modelSpdp,
        'modeljaksi' => $modeljaksi,
        'searchJPU' => $searchJPU,
		'sysMenu' => $sysMenu,
        'dataJPU' => $dataJPU,
    ]) ?>

</div>
