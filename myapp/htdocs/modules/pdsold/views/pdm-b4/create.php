<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB4 */

$this->title = 'B4';
$this->subtitle = 'Surat Perintah Penggeledahan/Penyegelan/Penyitaan/Penitipan';
/*$this->params['breadcrumbs'][] = ['label' => 'Pdm B4s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="pdm-b4-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'wilayah' => $wilayah,
        'tindak_pidana' => $tindak_pidana,
        'dataProvider' => $dataProvider,
        'list_tersangka' => $list_tersangka,
    ]) ?>

</div>
