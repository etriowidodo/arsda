<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidsus\models\PdsDikTersangka */

$this->title = 'Ubah Data Tersangka';
?>
<div class="pds-dik-tersangka-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
