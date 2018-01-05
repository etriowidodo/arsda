<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT13 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t13-update">


    <?=
    $this->render('_form', [
        'model' => $model,
        'id' => $id,
        't8' => $t8,
        'modelSpdp' => $modelSpdp,
    ])
    ?>

</div>
