<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Was3 */

$this->title = 'WAS 3';
$this->subtitle = 'SURAT PERMINTAAN KLARIFIKASI TERHADAP LAPDU';
$this->params['breadcrumbs'][] = ['label' => 'Was3', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 $session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="was3-create">

     

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
		'modelLapdu' => $modelLapdu, 
    ]) ?>

</div>
