<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP42 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p42-update">

 
    <?= $this->render('_form', [
        'model'         => $model,
        'sysMenu'       => $sysMenu,
        'no_register'   => $no_register,
        'modeltsk'      => $modeltsk,
        'modelhkm'      => $modelhkm,
        'modelbb'       => $modelbb,
        'jaksap16a'     => $jaksap16a,
        'ket_Saksi'     => $ket_Saksi,
        'ket_Ahli'      => $ket_Ahli,
        'ket_Surat'     => $ket_Surat,
        'ket_Petunjuk'  => $ket_Petunjuk,
        'ket_Tersangka' => $ket_Tersangka,
        'ket_Barbuk'    => $ket_Barbuk,
        'ket_UnPas'     => $ket_UnPas,
        'ket_Member'    => $ket_Member,
        'ket_Mering'    => $ket_Mering,
    ]) ?>

</div>
