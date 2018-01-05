<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmMsRentut */

$this->title = 'Rentuts';

/*$this->params['breadcrumbs'][] = ['label' => 'Pdm Ms Rentuts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="pdm-ms-rentut-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
