<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DisposisiInspektur */

$this->title = 'Disposisi IRMUD';
$this->params['ringkasan_perkara'] = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'Disposisi Inspekturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disposisi-inspektur-create">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
              'pelapor' => $pelapor,
              'terlapor' => $terlapor,
              'modelTerlapor' => $modelTerlapor,
              'modelDisposisi' => $modelDisposisi,
              'modelDisposisi_ins' => $modelDisposisi_ins,
    ]) ?>

</div>
