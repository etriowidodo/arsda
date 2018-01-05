<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was27Inspek */

$this->title = 'WAS 27';
$this->subtitle ='NOTA DINAS USUL PENGHENTIAN PEMERIKSAAN';
$this->params['ringkasan_perkara'] = $model->id_register;
$this->params['breadcrumbs'][] = ['label' => 'Was27 Inspeks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was_27_inspek, 'url' => ['view', 'id' => $model->id_was_27_inspek]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was27-inspek-update">

   

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
    ]) ?>

</div>
