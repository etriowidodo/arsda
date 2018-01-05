<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsAsalsurat */

$this->title = 'Asal Surat';
$this->params['breadcrumbs'][] = ['label' => 'Ms Asalsurats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-asalsurat-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
