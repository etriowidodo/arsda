<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was20b */

$this->title = 'Was20b';
$this->params['breadcrumbs'][] = ['label' => 'Was20b', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_was_20b, 'url' => ['view', 'id' => $model->id_was_20b]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was20b-update">


    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan'   => $modelTembusan,
        'modelPertanyaan' => $modelPertanyaan,
    ]) ?>

</div>
