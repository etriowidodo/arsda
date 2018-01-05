<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP21A */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p21-a-update">

    <?= $this->render('_form', [
				'model' => $model,
				'modelPengantar'=>$modelPengantar,
				'dataProvider' => $dataProvider,
				'modelP21'=>$modelP21,
				'sysMenu' => $sysMenu,
    ]) ?>

</div>
