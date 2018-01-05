<?php

use kartik\typeahead\Typeahead;
use yii\helpers\Url;

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\widgets\ActiveForm 		$form
 * @var dektrium\user\models\User 	$user
 */
?>

<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput() ?>

<?= $form->field($user, 'peg_nip')->widget(Typeahead::className(),[
    		'options' => ['placeholder' => 'Nip Pegawai', 'id' => 'peg_nip',  'value' => ($user->peg_nip != null) ? $user->peg_nip.' - '.(app\models\KpPegawai::findOne(['peg_nik' => $user->peg_nik])->peg_nama != null ? app\models\KpPegawai::findOne(['peg_nik' => $user->peg_nik])->peg_nama : '') : ''],
    		'pluginOptions' => ['highlight'=>true],
    		'dataset' => [
    				[
    						'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('id')",
    						'display' => 'value',
    						'remote' => [
    								'url' => Url::to(['/site/pegawainik']) . '?q=%QUERY',
    								'wildcard' => '%QUERY'
    						]
    				]
    		],
    		'pluginEvents' => [
    			"typeahead:selected" => "function(obj, datum, name) {  var data1 = (datum.id).split('#'); \$(peg_nip2).val(data1[1]);\$(peg_nik2).val(data1[0]); }",
    		]
    ]) ?>
	<input type="hidden" name="id_pegnip" id="peg_nip2" value="<?= $user->peg_nip ?>" />        
      
	<input type="hidden" name="id_pegnik" id="peg_nik2" value="<?= $user->peg_nik ?>" />
