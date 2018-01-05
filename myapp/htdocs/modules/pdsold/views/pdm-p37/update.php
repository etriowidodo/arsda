<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP37 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p37-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelSaksi' => $modelSaksi,
        'modelJaksa' => $modelJaksa,
        'modelTersangka' => $modelTersangka,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
        'vw_saksi' => $vw_saksi,
        'vw_ahli' => $vw_ahli,
    ]) ?>

</div>
