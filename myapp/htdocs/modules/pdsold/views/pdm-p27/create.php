<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP27 */

$this->title    = 'P-27';
$this->subtitle = 'Surat Ketetapan Pencabutan Penghentian Penuntutan';
//$this->params['breadcrumbs'][] = ['label' => 'Pdm P27s', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p27-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model'         => $model,
        'no_register'   => $no_register,
    ]) ?>

</div>