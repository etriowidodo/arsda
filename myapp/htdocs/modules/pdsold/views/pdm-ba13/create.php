<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA13 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba13-create">

    <?= $this->render('_form', [
        'model' => $model,
        // 'searchJPU' => $searchJPU,
        // 'dataJPU' => $dataJPU,
        'modeljaksi' => $modeljaksi,
        // 'id' => $id,
        'modelRp9' => $modelRp9,
        'modelSpdp' => $modelSpdp,
		'sysMenu' => $sysMenu,
        'modelLokTahanan' => $modelLokTahanan,
    ]) ?>

</div>
