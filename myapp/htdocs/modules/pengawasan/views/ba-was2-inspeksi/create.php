<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas1 */

$this->title = 'Tambah BA.WAS-2';
$this->params['breadcrumbs'][] = ['label' => 'Ba Was2', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="sp-was1-create">
<?//php print_r($model);

//  echo $form->field($model, 'nip_penandatangan')->textInput(['readonly'=>'readonly']);
// exit();
 ?>
    <?= $this->render('_form', [
        'model' => $model,
		'modelPemeriksa' => $modelPemeriksa,
		'modelSaksiEk' => $modelSaksiEk,
		'modelSaksiIn' =>  $modelSaksiIn,
		'modelSpWas2' =>  $modelSpWas2,
    ]) ?>

</div>
