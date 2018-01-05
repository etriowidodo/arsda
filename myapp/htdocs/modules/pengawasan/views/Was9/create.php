<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Was9 */

$this->title = 'WAS-9 (Surat Permintaan Keterangan Saksi)';
//$this->params['breadcrumbs'][] = ['label' => 'Was9s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was9-create">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'spWas1' => $spWas1,
        'modelTembusanMaster' => $modelTembusanMaster,
        //'modelSaksiEksternal' => $modelSaksiEksternal,
        // 'LoadSaksiEksternal' => $LoadSaksiEksternal,
        // 'LoadSaksiInternal' => $LoadSaksiInternal,
		'result_expire' => $result_expire,
    ]) ?>

</div>
