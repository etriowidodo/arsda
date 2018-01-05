<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmMsSatuan */

$this->title = 'Satuan';
/*$this->params['breadcrumbs'][] = ['label' => 'Pdm Ms Satuans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="pdm-ms-satuan-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
