<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas1 */

$this->title = 'Tambah BA.WAS-8';
$this->params['breadcrumbs'][] = ['label' => 'Ba Was8', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="ba-was2-create">
<?//php print_r($model);

//  echo $form->field($model, 'nip_penandatangan')->textInput(['readonly'=>'readonly']);
// exit();
 ?>
    <?= $this->render('_form', [
        'model' => $model,
		
    ]) ?>

</div>
