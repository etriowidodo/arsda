<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP19 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p19-update">

    <?= $this->render('_form', [
        'model'             => $model,
        'dataProvider'      => $dataProvider,
		'modelInsPenyidik'  => $modelInsPenyidik,
        'modelPengantar'    => $modelPengantar,
        'modelTersangka'    => $modelTersangka,
        'modelBerkas'       => $modelBerkas,
        'modelSpdp'         => $modelSpdp,
        'sysMenu'           => $sysMenu,
        'modelP18'          => $modelP18,
        'countP19'          => $countP19 
    ]) ?>

</div>
