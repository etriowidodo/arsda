<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Was9 */

$this->title = 'WAS-11 Inspeksi';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
//$this->params['breadcrumbs'][] = ['label' => 'Was9s', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_was9, 'url' => ['view', 'id' => $model->id_was9]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was11-update">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
        'modelSaksiEksternal' => $modelSaksiEksternal,
        'modelSaksiIn_trans' => $modelSaksiIn_trans,
        'LoadSaksiEksternal' => $LoadSaksiEksternal,
        'LoadSaksiInternal' => $LoadSaksiInternal,
        'modelSpwas2' => $modelSpwas2,
		'result_expire' => $result_expire,
    ]) ?>

</div>
