<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP43 */

// $this->params['breadcrumbs'][] = ['label' => 'Pdm P43s', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_p43, 'url' => ['view', 'id' => $model->id_p43]];
// $this->params['breadcrumbs'][] = 'Update';
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p43-update">

       <?= $this->render('_form', [
        'model'     => $model,
        'modelSpdp' =>$modelSpdp,
        'petunjuk'  =>$petunjuk,
        'ket_amar'  =>$ket_amar,
    ]) ?>

</div>
