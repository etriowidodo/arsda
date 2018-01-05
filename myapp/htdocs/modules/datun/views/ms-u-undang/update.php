<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsUUndang */

$this->title = 'Daftar Undang-Undang';
/*$this->params['breadcrumbs'][] = ['label' => 'Undang-Undang', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="ms-uundang-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
