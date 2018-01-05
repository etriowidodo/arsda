<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\VLaporanP6 */

$this->title = 'Create Vlaporan P6';
$this->params['breadcrumbs'][] = ['label' => 'Vlaporan P6s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vlaporan-p6-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
