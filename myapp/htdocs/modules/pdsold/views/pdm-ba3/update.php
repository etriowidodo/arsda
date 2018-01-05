<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA3 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan
?>
<div class="pdm-ba3-update">

    
    <?= $this->render('_form', [
        'model' => $model,
		'modeljaksi' => $modeljaksi,
		'modelpenyidik' =>$modelpenyidik,
		'searchJPU' => $searchJPU,
		'dataJPU' => $dataJPU,
		'modelTersangka' => $modelTersangka,
		'modelSpdp' => $modelSpdp,
		'modelMsSaksi'=>$modelMsSaksi,
		'sysMenu' => $sysMenu,
		'id' => $id,
	]) ?>

</div>
