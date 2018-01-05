<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was18 */

$this->title = 'WAS-18';
$this->subtitle = 'Nota Dinas Permohonan Penerbitan SK PHD';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
$this->params['breadcrumbs'][] = ['label' => 'Was18s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was18-create"> 
    <?= $this->render('_form', [
        'model' => $model,  
        'modelTembusanMaster' => $modelTembusanMaster,
    ]) ?>

</div>
