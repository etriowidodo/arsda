<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP24 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;

?>

<div class="row">

    <?= $this->render('_form', [
        'model' => $model,
		'listTersangka' => $listTersangka,
        'modelSpdp' => $modelSpdp,
        'modelTersangka' => $modelTersangka,
    	'modelJpu' => $modelJpu,
		 'modelJpu2' => $modelJpu2,
		 'modelJpu3' => $modelJpu3,
		'sysMenu'=>$sysMenu,
		'modelBerkas'=>$modelBerkas,
		'modelP16' => $modelP16,
		'modelGridTersangka' => $modelGridTersangka,
        'modelCeklis'       => $modelCeklis
    ]) ?>
</div>
