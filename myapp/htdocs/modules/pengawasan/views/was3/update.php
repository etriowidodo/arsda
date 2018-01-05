<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Was3 */

$this->title = 'WAS 3';
$this->subtitle = 'SURAT PERMINTAAN KLARIFIKASI TERHADAP LAPDU';
$this->params['ringkasan_perkara'] = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'Was3s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was3, 'url' => ['view', 'id' => $model->id_was3]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was3-update">

    

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
    ]) ?>

</div>
