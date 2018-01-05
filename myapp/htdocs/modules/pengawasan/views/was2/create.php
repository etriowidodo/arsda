<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Was2 */

$this->title = 'WAS2' ;
$this->subtitle = 'NOTA DINAS LAPDU';
$this->params['breadcrumbs'][] = ['label' => 'Was2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 $session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="was2-create">

   

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusanMaster' => $modelTembusanMaster,
		'modelLapdu' => $modelLapdu,
    ]) ?>

</div>
