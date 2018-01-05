<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa18 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba18-create">

    <!--<h1><?php //echo Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
		'id_perkara' => $id_perkara,
		'searchJPU' => $searchJPU,
		'dataJPU' => $dataJPU,
    ]) ?>

</div>
