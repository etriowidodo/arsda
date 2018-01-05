<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\LWas1 */

$this->title = 'L.WAS-1';
$this->subtitle = 'Laporan Hasil Klarifikasi';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
$this->params['breadcrumbs'][] = ['label' => 'Lwas1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lwas1-create">

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
  //       'modelPegawaiterlapor' => $modelPegawaiterlapor,
		// 'spwas1' => $spwas1,
    ]) ?>

</div>
