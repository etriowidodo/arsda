<?php 

use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use app\models\Satker;
use app\models\TemplateSuratIsi;
use yii\helpers\Html;


	class viewFormFunction{
		function openConnection(){
			$connection = new \yii\db\Connection([
			'dsn' => 'pgsql:host=localhost;dbname=simkari_cms',
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
		
		function returnField ($type,$name){
			$type=trim($type);//type of field
			$name=trim($name);//name of field
			$fieldHtml="";
			if ($type=="text"){
				$fieldHtml="<tr><td>".$name."</td><td><input type='text' name='".$name."'> </td></tr>";
			}
			else if($type=="multiline"){
				$fieldHtml ='<tr><td>'.$name.'</td><td><textarea name="'.$name.'" cols="40" rows="5" ></textarea></td></tr>';
			}
			
			return $fieldHtml;
		}
		
		
		function generateForm($formSetupId,$connection){
			$query="Select * from public.form_setup where form_setup_id=".$formSetupId;//query to get form's basic setup 
			$row= $this->getRows($query,$connection, "one");//get form's setup 
			$function = trim($row["function"]);//function used for changing the data
			echo "<input type='hidden' name='mainfunction' value='".$function."'>";
			$query="Select * from public.form_setup_detail where parent_id=".$formSetupId." and level=1 order by order_no";//query to get all fields used in the form
			$rows= $this->getRows($query,$connection, "all");//get all field used in the form
			foreach($rows as $currentRow) {
				if (trim($currentRow["field_type"])!="dynamic"){
					echo $this->returnField(trim($currentRow["field_type"]),trim($currentRow["field_name"]));
				}
				else {
					echo $this->getDynamicFormRow($currentRow["form_setup_detail_id"],trim($currentRow["field_name"]),trim($currentRow['alternative_function']),$connection);
				}
			}
		}
		
		function getDynamicFormRow($parentId,$parentname,$alternatefunction, $connection){
			$query="Select * from public.form_setup_detail where parent_id=".$parentId." and level=2 order by order_no";//query used to get field used in form's dynamic field
			$rows= $this->getRows($query,$connection, "all");
			$rowdata="";
			$rowadditionaldata="";
			$fieldcount=0;
			foreach($rows as $currentRow) {
				$rowdata=$rowdata.'<input type="'.trim($currentRow["field_type"]).'" name="'.$parentname.'[]" placeholder="'.trim($currentRow["field_name"]).'">';
				$fieldcount++;
			}
			$fieldHtml='<tr><td>'.$parentname.'</td><td>
							<input type="hidden" name="hdnstartdynamic'.$parentname.$parentId.'" value="'.$alternatefunction.'" >
							<input type="hidden" name="hdnfieldcount'.$parentname.$parentId.'" value="'.$fieldcount.'" >
							<div class="input_fields_wrap">
								<div>'.$rowdata.'</div>
							</div>
							<button class="add_field_button">Add More Fields</button>
							
							</td></tr>
							<input type="hidden" name="hdnenddynamic'.$parentname.'[]" >
						<script type="text/javascript">
						$(document).ready(function() {
							var max_fields      = 10; //maximum input boxes allowed
							var wrapper         = $(".input_fields_wrap"); //Fields wrapper
							var add_button      = $(".add_field_button"); //Add button ID
						   
							var x = 1; //initlal text box count
							$(add_button).click(function(e){ //on add input button click
								e.preventDefault();
								if(x < max_fields){ //max input box allowed
									
									x++; //text box increment
									$(wrapper).append(\'<div> 	'.$rowdata.'<a href="#" class="remove_field">Remove</a></div>\'); //add input box
									
								}
							});
						   
							$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
								e.preventDefault(); $(this).parent(\'div\').remove(); x--;
							})
						});
						</script>';
			return $fieldHtml;
		}
		
		function closeConnection($connection){
			$connection->close();
		}
		
		
		function getchildquery($dataarray,$fieldcount,$childfunction){
			$i=1;
			$query='';
			foreach($dataarray as $value){
				if($i%$fieldcount==1){
					$query=$query.'Select * from '.$childfunction.'(\''.$value.'\'';
				}
				else if($i%$fieldcount==0){
					$query=$query.', \''.$value.'\')'.'|||';
					//echo $query;
				}
				else {
					$query=$query.', \''.$value.'\'';
				}
				$i++;
			}
			return $query;
		}

		function insertupdatedata($DATAPOST){
			$isdynamic=false;
			$mainquery='Select * from ';
			$childqueries='';
			$mainqueryparameter='';
			$childfunction='';
			$dynamicfieldcount=0;
			$lastcount=0;
			foreach ($DATAPOST as $key => $value) {
				if (strpos($key,'hdnenddynamic')!==false){
					$isdynamic=false;
					$childfunction='';
					$dynamicfieldcount=0;
				}
				
				if($isdynamic){
					$childqueries=$childqueries.'|||'.$this->getchildquery($DATAPOST[$key],$dynamicfieldcount,$childfunction); 
				}
				else if(!is_array($DATAPOST[$key]) && !strstr($key,'mainfunction') && !strstr($key,'hdnstartdynamic') && !strstr($key,'hdnfieldcount')){
					$mainquery=$mainquery.'\''.$value.'\', ';
				}
				/*if(!is_array($DATAPOST[$key])){
					echo $key . ' has the value of ' . $value.'</br>';
				}
				else {
					$i=1;
					foreach ($DATAPOST[$key] as $value){
						echo $key . $i . ' has the value of ' . $value.'</br>';
						$i++;
					}
				}*/
				if(strpos($key,'hdnstartdynamic')!==false){
					$childfunction=$value;
				}
				else if (strpos($key,'hdnfieldcount')!==false){
					$isdynamic=true;
					$dynamicfieldcount=$value;
				}
				else if (strpos($key,'mainfunction')!==false){
					$mainquery=$mainquery.$value.' (';
				}

			}
				
				echo rtrim($mainquery,', ').')';
				//echo $childqueries;
				$childquery=explode('|||',$childqueries);
				foreach($childquery as $value){
					echo $value.'</br>';
				}
		}

		
		function generateFormUpdate($formSetupId,$connection,$filterparameter){
			$query="Select * from public.form_setup where form_setup_id=".$formSetupId;
			$row= $this->getRows($query,$connection, "one");
			$function = trim($row['function']);
			$query= trim ($row['data_source']);
			$filterdata= explode('|||',$filterparameter);
			$nfilter=1;
			
			foreach($filterdata as $data){
				$query=str_replace('filter_placeholder'.$nfilter,$data,$query);
				$nfilter++;
			}
			
			$datarow= $this->getRows($query,$connection, "one");
			
			$query="Select * from public.form_setup where form_setup_id=".$formSetupId;
			$row= $this->getRows($query,$connection, "one");
			$function = trim($row["function"]);
			
			echo "<input type='hidden' name='mainfunction' value='".$function."'>";
			$query="Select * from public.form_setup_detail where parent_id=".$formSetupId." and level=1 order by order_no";
			$rows= $this->getRows($query,$connection, "all");
			foreach($rows as $currentRow) {
				if (trim($currentRow["field_type"])!="dynamic"){
					echo $this->returnFieldUpdate(trim($currentRow["field_type"]),trim($currentRow["html_start"]),trim($currentRow["html_end"]),trim($currentRow["field_name"]),trim($datarow[trim($currentRow["field_name"])]));
				}
				else {
					echo $this->getDynamicFormRowUpdate($currentRow["form_setup_detail_id"],trim($currentRow["field_name"]),trim($currentRow['data_source']), trim($currentRow['alternative_function']), $filterparameter, $connection);
				}
			}
		}
		
		function returnFieldUpdate ($type, $htmlstart, $htmlend, $name, $datavalue){
			$type=trim($type);
			$name=trim($name);
			$fieldHtml="";
			if ($type=="text"){
				$fieldHtml=" ".$htmlstart."<input type='text' name='".$name."' value='".$datavalue."'>".$htmlend." ";
			}
			else if($type=="multiline"){
				$fieldHtml =' '.$htmlstart.' <textarea name="'.$name.'" cols="40" rows="5" value="'.$datavalue.'"></textarea>'.$htmlend." ";
			}
			
			return $fieldHtml;
		}
		
		function getDynamicFormRowUpdate($parentId,$parentname, $query_data, $alternatefunction, $filterparameter, $connection){
			$query="Select * from public.form_setup_detail where parent_id=".$parentId." and level=2 order by order_no";
			$rows= $this->getRows($query,$connection, "all");
			$rowdata="";
			$existing_data_rows="";
			$fieldcount=0;
			
			foreach($rows as $currentRow) {
				$rowdata=$rowdata.'<input type="'.trim($currentRow["field_type"]).'" name="'.$parentname.'[]" placeholder="'.trim($currentRow["field_name"]).'">';
				$fieldcount++;
			}
			$query_data=str_replace('filter_placeholder',$filterparameter,$query_data);
			$data_rows =$this->getRows($query_data,$connection, "all");
			
			foreach($data_rows as $current_data_row){
				$existing_data_rows=$existing_data_rows.'<div>';
				foreach($rows as $currentRow){
					$existing_data_rows=$existing_data_rows.'<input type="'.trim($currentRow["field_type"]).'" name="'.$parentname.'[]" placeholder="'.trim($currentRow["field_name"]).'" value="'.trim($current_data_row[trim($currentRow["field_name"])]).'">';
				}
				$existing_data_rows=$existing_data_rows.'<a href="#" class="remove_field">Remove</a></div>';
			}
			
			$fieldHtml='<tr><td>'.$parentname.'</td><td>
							<input type="hidden" name="hdnstartdynamic'.$parentname.$parentId.'" value="'.$alternatefunction.'" >
							<input type="hidden" name="hdnfieldcount'.$parentname.$parentId.'" value="'.$fieldcount.'" >
							<div class="input_fields_wrap">
								'.$existing_data_rows.'
							</div>
							<button class="add_field_button">Add More Fields</button>
							
							</td></tr>
							<input type="hidden" name="hdnenddynamic'.$parentname.'[]" >
						<script type="text/javascript">
						$(document).ready(function() {
							var wrapper         = $(".input_fields_wrap"); //Fields wrapper
							var add_button      = $(".add_field_button"); //Add button ID
						   
							var x = 1; //initlal text box count
							$(add_button).click(function(e){ //on add input button click
								e.preventDefault();
									
									x++; //text box increment
									$(wrapper).append(\'<div> 	'.$rowdata.'<a href="#" class="remove_field">Remove</a></div>\'); //add input box
								
							});
						   
							$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
								e.preventDefault(); $(this).parent(\'div\').remove(); x--;
							})
						});
						</script>';
			return $fieldHtml;
		}
		
		function returnHeadForm($formType,$form,$model,$modelSurat){
			$fieldHtml='';
			if($formType=="p1"){
				$fieldHtml='<div class="row">
							    <div class="col-md-12">
							        <div class="box box-solid">
										<div class="box-header with-border">
							                <h3 class="box-title">Kepala Surat</h3>
							            </div><!-- /.box-header -->
							            <div class="box-body">
							                <div class="row">
							                    <div class="col-md-6">
							                    	<div class="form-group">
					                                    <label for="satker" class="control-label col-md-4">Satker </label>
					                                    <div class="col-md-6">'. Html::activeDropDownList($model, 'id_satker', ArrayHelper::map(Satker::find()->all(), 'id_satker', 'nama'))  .'</div>
					                                </div>  
							                    	<div class="form-group">
					                                    <label for="lokasi_surat" class="control-label col-md-4">Asal Surat </label>
					                                    <div class="col-md-6">'. $form->field($modelSurat, 'lokasi_surat') .'</div>
					                                </div>  
					                                <div class="form-group">
					                                    <label for="no_surat" class="control-label col-md-4">Nomor Surat </label>
					                                    <div class="col-md-6">'. $form->field($modelSurat, 'no_surat') .'</div>
					                                </div>            
							                    </div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="tgl_surat" class="control-label col-md-4">Tanggal</label>
														<div class="col-md-6">'.
					                                             $form->field($modelSurat, 'tgl_surat')->widget(DateControl::classname(), [
					                                                'type'=>DateControl::FORMAT_DATE,
					                                                'ajaxConversion'=>false,
					                                                'options' => [
					                                                    'pluginOptions' => [
					                                                        'autoclose' => true
					                                                    ]
					                                                ]
					                                            ]).'
					                                    </div>
													</div>
					                                <div class="form-group">
					                                    <label for="perihal" class="control-label col-md-4">Perihal</label>
					                                    <div class="col-md-6">'. $form->field($modelSurat, 'perihal_lap') .'</div>
					                                </div>               		
												</div>
							                </div>
							            </div>
							        </div>
							    </div>    
							</div>
									';
			}
			echo $fieldHtml;
		}
		function returnDynamicForm($titleForm,$formType,$form,$model,$modelSurat){
				
			$fieldHtml='<div class="row">
							    <div class="col-md-12">
							        <div class="box box-solid">
										<div class="box-header with-border">
							                <h3 class="box-title">'.$titleForm.'</h3>
							            </div><!-- /.box-header -->
							            <div class="box-body">
							                <div class="row">
							                	<div class="col-md-6">';
			
			/*Field untuk form dari table pds_lid
			$modelTemplateIsi=TemplateSuratIsi::find()->where(['id_jenis_surat'=>$formType,'source_table'=>"pdsLid"])->orderBy('no_urut')->all();
			$jumlahFieldSurat=(count($modelTemplateIsi)/2)+(count($modelTemplateIsi)%2);
			$i=1;
			foreach($modelTemplateIsi as $fieldTemplate){
				$fieldHtml=$fieldHtml.$this->returnHtml($form,$model,$i,$fieldTemplate,$jumlahFieldSurat);
				$i++;
			}

			$fieldHtml=$fieldHtml.'</div></div><div class="row">
							                	<div class="col-md-6">';
							                	*/
			//Field untuk form dari table pds_lid_surat
			$modelTemplateIsi=TemplateSuratIsi::find()->where(['id_jenis_surat'=>$formType])->orderBy('no_urut')->all();
			$jumlahFieldSurat=(count($modelTemplateIsi)/2)+(count($modelTemplateIsi)%2);
			$i=1;
				
			foreach($modelTemplateIsi as $fieldTemplate){
				if(trim($fieldTemplate->source_table)=='pdsLid'){
					$fieldHtml=$fieldHtml.$this->returnHtml($form,$model,$i,$fieldTemplate,$jumlahFieldSurat);
				}
				else if (trim($fieldTemplate->source_table)=='pdsLidSurat') {
					$fieldHtml=$fieldHtml.$this->returnHtml($form,$modelSurat,$i,$fieldTemplate,$jumlahFieldSurat);
				}
				$i++;
			}
			
			$fieldHtml=$fieldHtml.'</div></div></div></div></div></div>';
			echo $fieldHtml;
		}
		
		function returnHtml($form,$model,$i,$fieldTemplate,$jumlahFieldSurat){
			$fieldHtml='';
			
			if(trim($fieldTemplate->jenis_field)=='text' || trim($fieldTemplate->jenis_field)=='multiline'){
				$fieldHtml=$fieldHtml.'<div class="form-group">
					                                    <label for="'.$fieldTemplate->source_field.'" class="control-label col-md-4">'.$fieldTemplate->label_isi_surat.'</label>
					                                    <div class="col-md-6">'. $form->field($model, trim($fieldTemplate->source_field)) .'</div>
					                                </div> ';
			}
			else if(trim($fieldTemplate->jenis_field)=='date'){
				$fieldHtml=$fieldHtml.'<div class="form-group">
														<label for="'.$fieldTemplate->source_field.'" class="control-label col-md-4">'.$fieldTemplate->label_isi_surat.'</label>
														<div class="col-md-6">'.
																$form->field($model, trim($fieldTemplate->source_field))->widget(DateControl::classname(), [
																		'type'=>DateControl::FORMAT_DATE,
																		'ajaxConversion'=>false,
																		'options' => [
																				'pluginOptions' => [
																						'autoclose' => true
																				]
																		]
																]).'
					                                    </div>
													</div>';
			}
			else if(trim($fieldTemplate->jenis_field)=='dropdown'){
				$fieldHtml=$fieldHtml.'<div class="form-group">
				<label for="'.trim($fieldTemplate->source_field).'" class="control-label col-md-4">'.trim($fieldTemplate->label_isi_surat).'</label>
				<div class="col-md-6"></div>
				</div>';
				//'. Html::activeDropDownList($model, trim($fieldTemplate->source_field), ArrayHelper::map(Satker::find()->all(), 'id_satker', 'nama'))  .'
			}
			return $fieldHtml;
		}
		
		
		
		}
?>
