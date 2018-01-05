<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was20a */

$this->title = 'Was20a';
$this->params['breadcrumbs'][] = ['label' => 'Was20as', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_was_20a, 'url' => ['view', 'id' => $model->id_was_20a]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was20a-update">


    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan'   => $modelTembusan,
        'modelPertanyaan' => $modelPertanyaan,
    ]) ?>

</div>
