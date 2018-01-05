<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB10 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b10-update">

    <?= $this->render('_form', [
        'model' => $model,
        'no_register_perkara'=> $no_register_perkara,
        'listTersangka' => $listTersangka,
        'ba5' => $ba5,
        'listBarbuk' => $listBarbuk,
        'sysMenu' => $sysMenu,
        'modelBarbuk' => $modelBarbuk,
    ]) ?>

</div>
