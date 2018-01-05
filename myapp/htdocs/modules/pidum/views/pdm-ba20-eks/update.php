<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB16 */


$this->title = "BA-20";
$this->subtitle = "Berita Acara Pengembalian Barang Bukti";
?>
<div class="pdm-ba8-update">

  

    <?= $this->render('_form', [
        'model'         => $model,
        'sysMenu'       => $sysMenu,
        'no_register'   => $no_register,
        'modelJpu'      => $modelJpu,
        'modeljaksi'    => $modeljaksi,
        'searchJPU'     => $searchJPU,
        'dataJPU'       => $dataJPU,
        'dekot'         => $dekot,
        'no_reg_tahanan'         => $no_reg_tahanan,
        'no_eksekusi'       => $no_eksekusi,
    ]) ?>

</div>
