<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\LWas2 */

$this->title = 'L-WAS 2';
$this->subtitle = 'LAPORAN HASIL INSPEKSI KASUS';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
$this->params['breadcrumbs'][] = ['label' => 'Lwas2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 $session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="lwas2-create">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
