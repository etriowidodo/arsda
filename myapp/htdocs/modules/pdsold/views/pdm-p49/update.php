<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP49 */

$this->title = 'P-49';
$this->subtitle = 'Surat Ketetapan Gugurnya / Hapusnya Wewenang Mengeksekusi';
?>
<div class="pdm-p49-update">



    <?= $this->render('_form', [
        'model'         => $model,
        'no_register'   => $no_register,
        'modeltsk'      => $modeltsk,
        'mengingat'     => $mengingat,
    ]) ?>

</div>
