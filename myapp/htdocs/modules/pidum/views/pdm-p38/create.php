<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP38 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p38-create">

    <?= $this->render('_form', [
        'model'         => $model,
        'sysMenu'       => $sysMenu,
        'no_register'   => $no_register,
        'vw_saksi'      => $vw_saksi,
        'vw_ahli'       => $vw_ahli,
        'vw_terdakwa'   => $vw_terdakwa,
    ]) ?>

</div>
