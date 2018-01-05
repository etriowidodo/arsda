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
		'modelSpdp' => $modelSpdp,
		'modelJpu' => $modelJpu,
		'sysMenu' => $sysMenu,
		'modelJpu' => $modelJpu,
		'modelBerkas'=>$modelBerkas,
		'modelP16' => $modelP16,
		'modelGridTersangka' => $modelGridTersangka,
		'modelCeklis' => $modelCeklis,
                'id_pengantar'       => $id_pengantar,
                'modelCeklis1'      => $modelCeklis1
    ]) ?>

</div>
