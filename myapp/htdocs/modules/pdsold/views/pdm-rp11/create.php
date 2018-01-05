<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmRP11 */

/*$this->title = 'Create Pdm Rp11';
$this->params['breadcrumbs'][] = ['label' => 'Pdm Rp11s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-rp11-create">
    <?= $this->render('_form', [
        'model' => $model,
        'searchModelBerkas' => $searchModelBerkas,
        'dataProviderBerkas' => $dataProviderBerkas,
        'modelTerdakwa' => $modelTerdakwa,
        'sysMenu' => $sysMenu,
    ]) ?>

</div>
