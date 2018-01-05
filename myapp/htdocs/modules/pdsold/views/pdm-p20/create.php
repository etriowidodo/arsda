<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP20 */

$this->title = 'Pemberitahuan bahwa Waktu Penyidikan Telah Habis';
$this->params['breadcrumbs'][] = ['label' => 'Pdm P20s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p20-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
