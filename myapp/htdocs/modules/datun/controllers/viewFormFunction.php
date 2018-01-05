ew<?php 


use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use \kartik\time\TimePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\pidsus\models\Satker;
use app\modules\pidsus\models\TemplateSuratIsi;
use app\modules\pidsus\models\KpInstSatker;
use yii\helpers\Html;
use app\modules\pidum\models\PdmTemplateTembusan;

	class ViewFormFunction{
		function openConnection(){
			$connection = new \yii\db\Connection([
			// 'dsn' => 'pgsql:host=localhost;dbname=simkari_cms',
			'dsn' => 'pgsql:host=192.168.11.11;dbname=simkari_cms;port=5432',
			'username' => 'postgres',
			'password' => 'password',
			]);
			$connection->open();
			return $connection;
		}
		function getRows($query,$connection, $type){
			if ($type=="all"){
				$rows = $connection->createCommand($query)->queryAll();//return all rows
			}
			else if ($type="one"){
				$rows = $connection->createCommand($query)->queryOne();//return only one ro
			}
			return $rows;
		}


		function closeConnection($connection){
			$connection->close();
		}
		function returnTembusanDynamicpidum ($form,$kd_berkas,$thisForm){
			// $modelTembusan=PdmTemplateTembusan::find(['kd_berkas' => 'p-16'])->all();
			$modelTembusan=PdmTemplateTembusan::findBySql('select * from pidum.pdm_template_tembusan where kd_berkas =\''.$kd_berkas.'\' order by no_urut asc')->all();
			$fieldHtml='';
			foreach ($modelTembusan as $index => $modelTembusanRow) {
				$fieldHtml =$fieldHtml.'
				<div id="rowtembusan'. $modelTembusanRow->id_tmp_tembusan .'" class="form-group">
					<div class="col-md-1"><a id="btn-hapus-tembusan" class="btn btn-danger" onclick="hapusTembusan(\''. $modelTembusanRow->id_tmp_tembusan .'\')">Hapus</a></div>
					<div class="col-md-1">'.$form->field($modelTembusanRow, "[$index]no_urut")->textInput(['readonly' => false]).'</div>
					<div class="col-md-7">'. $form->field($modelTembusanRow, "[$index]tembusan")->textInput(['readonly' => false]) .'</div>

				</div>  ';
			}
			$fieldHtml =$fieldHtml.'
						<div id="new_tembusan"></div>
						<a id="tambah-tembusan" class="btn btn-success">Tambah tembusan</a>';
			$fieldHtml =$fieldHtml."<script>
							function hapusTembusan(id)
							{
							   $('#new_tembusan').append(
							       '<input type=\"hidden\" name=\"hapus_tembusan[]\" value=\"'+id+'\">'
							   );
							
							   $('#rowtembusan'+id).remove();
							};
							function hapusTembusanPop(id)
							{
							   $('#new'+id).remove();
							};
					</script>";
			
			$thisForm->registerJs("$(document).ready(function(){
							var x=1;
					        $('#tambah-tembusan').click(function(){			
					                $('#new_tembusan').append(
					                    '". preg_replace("/\s+/"," ","	<div id=\"new'+x+'\" class=\"form-group\"><div class=\"col-md-1\"><a id=\"hapus-tembusan\" onclick=\"hapusTembusanPop('+x+')\" class=\"btn btn-danger\">Hapus</a></div><div class=\"col-md-1\"><input type=\"text\" class=\"form-control\" name=\"new_no_urut[]\"></input></div><div class=\"col-md-7\"><input type=\"text\" class=\"form-control\" name=\"new_tembusan[]\"></input></div></div>")."'
					                );
									x++;
					            });
					
							
					        });
								
					");
			return $fieldHtml;
		}
		
		function returnDropDownList($form,$model,$query,$value,$label,$field,$disabled=false){
			$connection=$this->openConnection();
			try{	
				$rows= $this->getRows($query,$connection, "all");
				//return $form->field($model, 'id')->dropDownList(ArrayHelper::map($rows,'id','nama'),['prompt'=>'---pilih---'],['label'=>'']);
				$list = ArrayHelper::map($rows,$value,$label);
				return $form->field($model, $field)->dropDownList($list, 
						[$value => $label,'disabled'=>$disabled]);
			}
			catch(Exception $e){
				
			}
			$connection->close();
		}
		
				
		}
?>
