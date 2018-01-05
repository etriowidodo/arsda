<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was27Klari */

$this->title = 'WAS 27';
$this->subtitle ='NOTA DINAS USUL PENGHENTIAN KLARIFIKASI';
$this->params['ringkasan_perkara'] = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'Was27 Klaris', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was_27_klari, 'url' => ['view', 'id' => $model->id_was_27_klari]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was27-klari-update">

  

   <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
        'modelTerlapor' => $modelTerlapor,
        'modelPelapor' => $modelPelapor,
		'modelWas27Detail' => $modelWas27Detail,
    ]) ?>

</div>
