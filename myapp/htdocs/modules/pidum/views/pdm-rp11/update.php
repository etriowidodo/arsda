<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmRP11 */

/*$this->title = 'Update Pdm Rp11: ' . ' ' . $model->no_register_perkara;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Rp11s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->no_register_perkara, 'url' => ['view', 'no_register_perkara' => $model->no_register_perkara, 'no_akta' => $model->no_akta, 'no_reg_tahanan' => $model->no_reg_tahanan]];
$this->params['breadcrumbs'][] = 'Update';*/
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-rp11-update">
    <?= $this->render('_form', [
        'model' => $model,
        'searchModelBerkas' => $searchModelBerkas,
        'dataProviderBerkas' => $dataProviderBerkas,
        'sysMenu' => $sysMenu,
    ]) ?>

</div>
