<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsInstPenyidik */

$this->title = 'Instansi Penyidik';
/*
$this->params['breadcrumbs'][] = ['label' => 'Instansi Penyidik', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
*/
?>
<div class="ms-inst-penyidik-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
