<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPasal */

$this->title = 'Daftar Pasal ';
/*$this->params['breadcrumbs'][] = ['label' => 'Ms Pasals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uu, 'url' => ['view', 'uu' => $model->uu, 'pasal' => $model->pasal]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="ms-pasal-update">
    <?= $this->render('_form', [
        'model' => $model,
		'searchUU' => $searchUU,
        'dataUU' => $dataUU,
    ]) ?>

</div>
