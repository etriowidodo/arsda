<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was13 */

$this->title = 'WAS-13';
$this->subtitle = 'Tanda Terima';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Was13s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was13-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelWas9' => $modelWas9,
        'modelWas10' => $modelWas10,
        'modelWas11' => $modelWas11,
        'modelWas12' => $modelWas12,
    ]) ?>

</div>
