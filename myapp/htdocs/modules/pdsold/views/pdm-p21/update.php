<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP21 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p21-update">

    <?= $this->render('_form', [
        'model' => $model,
		'modelBerkas'=>$modelBerkas,
		'modelPengantar'=>$modelPengantar,
		'dataProvider' => $dataProvider,
		'modelP24'=>$modelP24,
		'sysMenu' => $sysMenu,
    ]) ?>

</div>
