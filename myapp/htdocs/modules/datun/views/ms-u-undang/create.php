<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsUUndang */

$this->title = 'Master Undang-Undang';
/*$this->params['breadcrumbs'][] = ['label' => 'Undang-Undang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="ms-uundang-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
