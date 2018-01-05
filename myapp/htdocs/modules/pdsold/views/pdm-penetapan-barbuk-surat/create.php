<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenetapanBarbukSurat */

$this->title = 'Create Pdm Penetapan Barbuk Surat';
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penetapan Barbuk Surats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penetapan-barbuk-surat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
