<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsJenisPerkara */

$this->title = 'Jenis Perkara';
//$this->params['breadcrumbs'][] = ['label' => 'Jenis Perkara', 'url' => ['index']];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-jenis-perkara-update">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
