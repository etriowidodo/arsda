<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsJenisPidana */

$this->title = 'Jenis Pidana';
/*
$this->params['breadcrumbs'][] = ['label' => 'Jenis Pidana', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="ms-jenis-pidana-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
