<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was23b */

$this->title = 'Was23b';
$this->params['breadcrumbs'][] = ['label' => 'Was23b', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_was_23b, 'url' => ['view', 'id' => $model->id_was_23b]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was23b-update">


    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan'   => $modelTembusan,
    ]) ?>

</div>
