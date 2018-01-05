<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB4 */

/*$this->title = 'Update Pdm B4: ' . ' ' . $model->id_b4;
$this->params['breadcrumbs'][] = ['label' => 'Pdm B4s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_b4, 'url' => ['view', 'id' => $model->id_b4]];
$this->params['breadcrumbs'][] = 'Update';*/

$this->title = 'B4';
$this->subtitle = 'Surat Perintah Penggeledahan/Penyegelan/Penyitaan/Penitipan';

?>
<div class="pdm-b4-update">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'wilayah' => $wilayah,
        //'tersangka' => $tersangka,
        'list_tersangka' => $list_tersangka,
        'tindak_pidana' => $tindak_pidana,
        'dataProvider' => $dataProvider,
        'tabelbarbuk' => $tabelbarbuk,
    ]) ?>

</div>
