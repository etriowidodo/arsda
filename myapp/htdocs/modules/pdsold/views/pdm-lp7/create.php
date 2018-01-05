<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\VLaporanP7 */

$this->title = 'Create Vlaporan P7';
$this->params['breadcrumbs'][] = ['label' => 'Vlaporan P7s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vlaporan-p7-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
