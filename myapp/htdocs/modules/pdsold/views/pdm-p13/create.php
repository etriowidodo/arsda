<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP13 */

$this->title = 'Usul Penghentian Penyidikan / Penuntutan';
$this->params['breadcrumbs'][] = ['label' => 'Pdm P13s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p13-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'             => $model,
        'modelTersangka'    => $modelTersangka,
    ]) ?>

</div>
