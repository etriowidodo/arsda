<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP23 */
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p23-create">

    <?= $this->render('_form', [
		'p22' => $p22,
         'model' => $model,
         'sysMenu' => $sysMenu,
         'modelSpdp' => $modelSpdp,
		 'dataProvider' => $dataProvider,
    ]) ?>

</div>
