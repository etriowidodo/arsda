<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP37 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p37-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'modelSaksi' => $modelSaksi,
    	'modelJaksa' => $modelJaksa,
    	'searchJPU' => $searchJPU,
    	'dataJPU' => $dataJPU,
    	'modelTersangka' => $modelTersangka,
        'vw_ahli'       => $vw_ahli,
        'vw_saksi'      => $vw_saksi,
    ]) ?>

</div>
