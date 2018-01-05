<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was15 */

$this->title = 'WAS-15';
$this->subtitle = 'Nota Dinas Pertimbangan Terhadap Hukuman Disiplin Yang Akan Dijatuhkan Kepada Terlapor ';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
$this->params['breadcrumbs'][] = ['label' => 'Was15s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="was15-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'no_register' => $no_register,
        'was_register' => $was_register,
    ]) ?>

</div>
