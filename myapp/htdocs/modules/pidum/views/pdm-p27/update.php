<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP27 */

$this->title    = 'P-27';
$this->subtitle = 'Surat Ketetapan Pencabutan Penghentian Penuntutan';
//$this->params['breadcrumbs'][] = ['label' => 'Pdm P27s', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->no_register_perkara, 'url' => ['view', 'no_register_perkara' => $model->no_register_perkara, 'no_surat_p27' => $model->no_surat_p27]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-p27-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model'         => $model,
        'no_register'   => $no_register,
    ]) ?>

</div>