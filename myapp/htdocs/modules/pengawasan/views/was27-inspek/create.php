<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was27Inspek */

$this->title = 'WAS 27';
$this->subtitle ='NOTA DINAS USUL PENGHENTIAN PEMERIKSAAN';
$this->params['breadcrumbs'][] = ['label' => 'Was27 Inspeks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 $session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="was27-inspek-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
