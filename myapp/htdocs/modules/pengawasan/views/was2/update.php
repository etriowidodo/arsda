<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Was2 */

$this->title = 'WAS2' ;
$this->subtitle = 'NOTA DINAS LAPDU';
$this->params['ringkasan_perkara'] = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'Was2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was2, 'url' => ['view', 'id' => $model->id_was2]];
$this->params['breadcrumbs'][] = 'Update';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="was2-update">

   

    <?= $this->render('_form', [
        'model' => $model,
          'modelTembusan' => $modelTembusan,
    ]) ?>

</div>
