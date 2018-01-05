<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP13 */

$this->title = 'Usul Penghentian Penyidikan / Penuntutan: ' . ' ' . $model->id_p13;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P13s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_p13, 'url' => ['view', 'id' => $model->id_p13]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-p13-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
