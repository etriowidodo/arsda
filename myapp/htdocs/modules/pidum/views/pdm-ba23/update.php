<?php

use app\modules\pidum\models\PdmBa23;
use yii\web\View;

/* @var $this View */
/* @var $model PdmBa23 */

$this->title = "BA-23";
$this->subtitle = "Berita Acara Pemusnahan Barang Bukti";
?>
<div class="pdm-ba23-update">


    <?=
    $this->render('_form', [
        'model'         => $model,
        'no_eksekusi'   => $no_eksekusi,
        'modelJpu'      => $modelJpu,
        'modeljaksi'    => $modeljaksi,
        'searchJPU'     => $searchJPU,
        'dataJPU'       => $dataJPU,
        'no_reg_tahanan'       => $no_reg_tahanan,
    ])
    ?>

</div>
