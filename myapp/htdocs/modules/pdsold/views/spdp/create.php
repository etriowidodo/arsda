<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdp */

$this->title = 'Tambah SPDP';
$this->subtitle = 'Surat Pemberitahuan Dimulainya Penyidikan';

?>
<?php if(Yii::$app->session->getFlash('message') != null): ?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>	<i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('message'); ?></h4>
</div>
<?php endif ?>
<?= Yii::$app->session->getFlash('message'); ?>
<div class="pidum-pdm-spdp-create">

    <?php /*?><h1><?= Html::encode($this->title) ?></h1><?php */?>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTersangka' => $modelTersangka,
        'modelPasal' => $modelPasal,
    ]) ?>

</div>
