<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\LWas1 */

$this->title = 'L.WAS-1';
$this->subtitle = 'Laporan Hasil Klarifikasi';
$this->params['ringkasan_perkara'] = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'Lwas1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_l_was_1, 'url' => ['view', 'id' => $model->id_l_was_1]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lwas1-update">

    <?= $this->render('_form', [
        'model' => $model,
		'dataProvider' => $dataProvider,
    ]) ?>

</div>
