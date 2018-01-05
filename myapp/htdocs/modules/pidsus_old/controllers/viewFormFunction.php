<?php 


use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use \kartik\time\TimePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\pidsus\models\Satker;
use app\modules\pidsus\models\TemplateSuratIsi;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsTut;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsTutSurat;
use app\modules\pidsus\models\KpInstSatker;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use \kartik\money\MaskMoney;
	class ViewFormFunction{
					
		
		function returnSuratIsi ($thisForm, $form,$modelSuratIsi,$readOnly=false){
			$fieldHtml='';
			$modelName=get_class($modelSuratIsi[0]);
			$type=explode('\\',$modelName);
			$i=0;
			foreach ($modelSuratIsi as $index => $modelSuratIsiRow) {
				if($modelSuratIsiRow->jenis_field=='label'){
					$fieldHtml=$fieldHtml. '
					                                <div class="form-group">
					                                    <label for="label" class="col-md-3" style="font-weight: bold; text-align: left;">'.$modelSuratIsiRow->label_isi_surat.'</label>
					                                    <label for="perihal" class="col-md-6" style="font-weight: normal; text-align: left;">'.$modelSuratIsiRow->isi_surat.'</label>
					                                <input id="'.strtolower($type[count($type)-1]).'-'.$i.'-isi_surat" class="form-control" type="hidden" value="'.$modelSuratIsiRow->isi_surat.'" name="'.$type[count($type)-1].'['.$i.'][isi_surat]"></div>  ';
				}
				//else if($modelSuratIsiRow->jenis_field=='textbox')
				else if (strpos(($modelSuratIsiRow->jenis_field),'textbox') !==false)
				{
					$fieldHtml =$fieldHtml.'
					                                <div class="form-group">
					                                    <label for="'.$modelSuratIsiRow->label_isi_surat.'" class="control-label col-md-3">'.$modelSuratIsiRow->label_isi_surat.'</label>
					                                    <div class="col-md-6">'. $form->field($modelSuratIsiRow, "[$index]isi_surat")->textInput(['readonly' => $readOnly]) .'</div>
					                                </div>  ';
				}
				else if($modelSuratIsiRow->jenis_field=='money')
				{
					$fieldHtml =$fieldHtml.'
					                                <div class="form-group">
					                                    <label for="'.$modelSuratIsiRow->label_isi_surat.'" class="control-label col-md-3">'.$modelSuratIsiRow->label_isi_surat.'</label>

 														 <div class="col-md-6">'. $form->field($modelSuratIsiRow, "[$index]isi_surat")->widget(MaskMoney::classname(), [
							'pluginOptions' => [
								'prefix' => 'Rp.  ',
								'thousands' => '.',
								'decimal' => ',',
								'precision' => 0,
								'integerOnly' => true,
								'allowZero' => false,
								'allowNegative' => false,

							]
						]) .'</div>
					                                </div>  ';
				}
				else if($modelSuratIsiRow->jenis_field=='textarea'){
					$fieldHtml =$fieldHtml.'
					                                <div class="form-group">
					                                    <label for="'.$modelSuratIsiRow->label_isi_surat.'" class="control-label col-md-3">'.$modelSuratIsiRow->label_isi_surat.'</label>
					                                     <div class="col-md-6">'.$form->field($modelSuratIsiRow, "[$index]isi_surat")->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) .'</div>
													 </div>  ';
				}
				else if($modelSuratIsiRow->jenis_field=='dropdownlist2'||$modelSuratIsiRow->jenis_field=='dropdownlist'){
				//else if(strpos(($modelSuratIsiRow->jenis_field),'dropdownlist') !==false){
					$fieldHtml =$fieldHtml.'<div class="form-group">
					<label for="'.$modelSuratIsiRow->label_isi_surat.'" class="control-label col-md-3">'.$modelSuratIsiRow->label_isi_surat.'</label>
					<div class="col-md-6">'.$this->returnSelect2($modelSuratIsiRow->sql_ddl,$form,$modelSuratIsiRow,"[$index]isi_surat",'','value','text','','').'</div>
							
																	</div>  ';
				}
				else if($modelSuratIsiRow->jenis_field=='dropdownlistdisable'){
					//else if(strpos(($modelSuratIsiRow->jenis_field),'dropdownlist') !==false){
					$fieldHtml =$fieldHtml.'<div class="form-group">
					<label for="'.$modelSuratIsiRow->label_isi_surat.'" class="control-label col-md-3">'.$modelSuratIsiRow->label_isi_surat.'</label>
					<div class="col-md-6">'.$this->returnSelectDisable($modelSuratIsiRow->sql_ddl,$form,$modelSuratIsiRow,"[$index]isi_surat",'','value','text','','').'</div>
				
																	</div>  ';
				}

				/*else if($modelSuratIsiRow->jenis_field=='dropdownlist'){
						$fieldHtml =$fieldHtml.'<div class="form-group">
					<label for="'.$modelSuratIsiRow->label_isi_surat.'" class="control-label col-md-3">'.$modelSuratIsiRow->label_isi_surat.'</label>
					<div class="col-md-6">'. $this->returnDropDownList($form,$modelSuratIsiRow,$modelSuratIsiRow->sql_ddl,"value","text","[$index]isi_surat") .'</div>
																	</div>  ';
					}*/
			  //else if($modelSuratIsiRow->jenis_field=="date"){
				//(strpos($a,'date%') !== false)
				else if(strpos(($modelSuratIsiRow->jenis_field),'date') !==false){
					if(empty($modelSuratIsiRow->start_date)){
						$startDate=null;
					}
					else $startDate = date('d m Y',strtotime($modelSuratIsiRow->start_date));
					if(empty($modelSuratIsiRow->end_date)){
						$endDate=null;
					}
					else $endDate = date('d m Y',strtotime($modelSuratIsiRow->end_date));
					$fieldHtml =$fieldHtml.'<div class="form-group">
					<label for="'.$modelSuratIsiRow->label_isi_surat.'" class="control-label col-md-3">'.$modelSuratIsiRow->label_isi_surat.'</label>
					<div class="col-md-6">'.$form->field($modelSuratIsiRow, "[$index]isi_surat")->widget(DateControl::classname(), [
							'type'=>DateControl::FORMAT_DATE,
							'ajaxConversion'=>false,
							'options' => [
									'pluginOptions' => [
											'autoclose' => true,
											'startDate' => $startDate ,
											'endDate' => $endDate
									]
							]
					]).'</div></div>';
				} 
				else if($modelSuratIsiRow->jenis_field=='time'){

					$fieldHtml =$fieldHtml.'<div class="form-group">
					<label for="'.$modelSuratIsiRow->label_isi_surat.'" class="control-label col-md-3">'.$modelSuratIsiRow->label_isi_surat.'</label>
					<div class="col-md-6">'. $form->field($modelSuratIsiRow, "[$index]isi_surat")->widget(TimePicker::classname(), [
							'pluginOptions' => [

								'showMeridian' => false,
								'minuteStep' => 1,

							]
						]) .'</div>
																	</div>  ';
				}
				else if($modelSuratIsiRow->jenis_field=='hidden'){
					$dummy=1;
				}
				/*else if($modelSuratIsiRow->jenis_field=='time'){

					$fieldHtml =$fieldHtml.'<div class="form-group">
					<label for="'.$modelSuratIsiRow->label_isi_surat.'" class="control-label col-md-3">'.$modelSuratIsiRow->label_isi_surat.'</label>
					<div class="col-md-6">'. $this->returnDropDownList($form,$modelSuratIsiRow,$modelSuratIsiRow->sql_ddl,"value","text","[$index]isi_surat") .'</div>
																	</div>  ';
				}*/			
				else{
					$fieldHtml=$fieldHtml. '
					                                <div class="form-group">
					                                    <label for="perihal" class="col-md-3" style="font-weight: bold; text-align: right;">'.$modelSuratIsiRow->label_isi_surat.'</label>
					                                    <label for="perihal" class="col-md-6" style="font-weight: normal; text-align: left;">'.$modelSuratIsiRow->isi_surat.'</label>
					                                </div>  ';
				}
				$i++;
			}
			return $fieldHtml;
		}

		function returnTembusan ($form,$modelTembusan){
			$fieldHtml='';
			foreach ($modelTembusan as $index => $modelTembusanRow) {
					$fieldHtml=$fieldHtml. '<div class="form-group">
					                                    <label for="perihal" class="control-label col-md-2" style="font-weight: normal;">'.$modelTembusanRow->no_urut.'. </label>
					                                    <label for="perihal" class="control-label col-md-8" style="text-align: left; font-weight: normal;">'.$modelTembusanRow->tembusan.'</label>
					                                </div>  ';
			}
			return $fieldHtml;
		}
		
		function returnDetail ($form, $modelDetail){
			$fieldHtml='';
			foreach ($modelDetail as $index => $modelDetailRow) {
				$fieldHtml =$fieldHtml.'
					                                <div class="form-group">
					                                    <label class="control-label col-md-3">'.$modelDetailRow->sub_no_urut.'. &nbsp</label>
					                                    <div class="col-md-6">'. $form->field($modelDetailRow, "[$index]isi_surat_detail")->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => false)) .'</div>					                                   
					                                </div>  ';
			}
			return $fieldHtml;
		}
	function returnDetailFull ($form, $modelDetail, $thisForm, $typeSurat){
			$fieldHtml='';
			$noUrut=0;
			$lastTipeSurat='';
			$listDetail=Yii::$app->db->createCommand("select distinct tipe_surat_detail, no_urut from pidsus.template_surat_detail where id_jenis_surat='$typeSurat' order by no_urut")->queryAll();;
			$iDetail=0;
			//echo($listDetail[0]['tipe_surat_detail']);
			//die();
			foreach ($modelDetail as $index => $modelDetailRow) {
		
				if ($modelDetailRow->no_urut<>$noUrut){
					if($modelDetailRow->no_urut<>($noUrut+1)){
						$fieldHtml =$fieldHtml.'</div>
							<div id="new_'.$listDetail[$iDetail-1]['tipe_surat_detail'].'"></div>
							</br>
							<div>
							</div>
							</div>
							</div></div>';
						$thisForm->registerJs("$(document).ready(function(){
										var x =1;
						        $('#tambah-".$listDetail[$iDetail-1]['tipe_surat_detail']."').click(function(){
						                $('#new_".$listDetail[$iDetail-1]['tipe_surat_detail']."').append(
						                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input class='form-control' type='text' name='new_no_urut".$listDetail[$iDetail-1]['tipe_surat_detail']."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$listDetail[$iDetail-1]['tipe_surat_detail']."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$lastTipeSurat."' value='@+x+@' /></div></div></div>"))))."'
						                );
										x++;
						            });
		
							$('#hapus-detail-check-".$listDetail[$iDetail-1]['tipe_surat_detail']."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$listDetail[$iDetail-1]['tipe_surat_detail']." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$listDetail[$iDetail-1]['tipe_surat_detail']."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$listDetail[$iDetail-1]['tipe_surat_detail']."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$listDetail[$iDetail-1]['tipe_surat_detail']."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
						        });");
						$fieldHtml =$fieldHtml.'<div class="box box-solid">
								<div class="box-header with-border">
		
								<div class="col-md-5"><h3 class="box-title">'.$listDetail[$iDetail]['tipe_surat_detail'].':</h3>
								</div>
								<div class="col-md-2"><a id="tambah-'.$listDetail[$iDetail]['tipe_surat_detail'].'" class="btn btn-success">Tambah '.$listDetail[$iDetail]['tipe_surat_detail'].'</a></div>
								<div class="col-md-2"><a id="hapus-detail-check-'.$listDetail[$iDetail]['tipe_surat_detail'].'" class="btn btn-danger">Hapus '.$listDetail[$iDetail]['tipe_surat_detail'].'</a></div>
								
								</div>
								<div class="box-body">
								<div>
								<div>';
						$fieldHtml =$fieldHtml.'</div>
							<div id="new_'.$listDetail[$iDetail]['tipe_surat_detail'].'"></div>
							</br>
							<div>
							</div>
							</div>
							</div></div>';
						$fieldHtml =$fieldHtml.'<div class="box box-solid">
								<div class="box-header with-border">
		
								<div class="col-md-5"><h3 class="box-title">'.$modelDetailRow->tipe_surat_detail.':</h3>
								</div>
								<div class="col-md-2"><a id="tambah-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-success">Tambah '.$modelDetailRow->tipe_surat_detail.'</a></div>
								<div class="col-md-2"><a id="hapus-detail-check-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-danger">Hapus '.$modelDetailRow->tipe_surat_detail.'</a></div>
								
								</div>
								<div class="box-body">
								<div>
								<div>';
						$thisForm->registerJs("$(document).ready(function(){
										var x =1;
						        $('#tambah-".$listDetail[$iDetail]['tipe_surat_detail']."').click(function(){
						                $('#new_".$listDetail[$iDetail]['tipe_surat_detail']."').append(
						                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input class='form-control' type='text' name='new_no_urut".$listDetail[$iDetail]['tipe_surat_detail']."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$listDetail[$iDetail]['tipe_surat_detail']."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$listDetail[$iDetail]['tipe_surat_detail']."' value='@+x+@' /></div></div></div>"))))."'
						                );
										x++;
						            });
			
							$('#hapus-detail-check-".$listDetail[$iDetail]['tipe_surat_detail']."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$listDetail[$iDetail]['tipe_surat_detail']." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$listDetail[$iDetail]['tipe_surat_detail']."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$listDetail[$iDetail]['tipe_surat_detail']."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
		
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$listDetail[$iDetail]['tipe_surat_detail']."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
						        });");
						$iDetail++;
					}
					else {
						if($noUrut<>0){
							$fieldHtml =$fieldHtml.'</div>
							<div id="new_'.$lastTipeSurat.'"></div>
							</br>
							<div>
							</div>
							</div>
							</div></div>';
							$thisForm->registerJs("$(document).ready(function(){
										var x =1;
						        $('#tambah-".$lastTipeSurat."').click(function(){
						                $('#new_".$lastTipeSurat."').append(
						                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input class='form-control' type='text' name='new_no_urut".$lastTipeSurat."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$lastTipeSurat."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$lastTipeSurat."' value='@+x+@' /></div></div></div>"))))."'
						                );
										x++;
						            });
			
							$('#hapus-detail-check-".$lastTipeSurat."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$lastTipeSurat." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$lastTipeSurat."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$lastTipeSurat."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
		
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$lastTipeSurat."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
						        });");
						}
						$fieldHtml =$fieldHtml.'<div class="box box-solid">
								<div class="box-header with-border">
		
								<div class="col-md-5"><h3 class="box-title">'.$modelDetailRow->tipe_surat_detail.':</h3>
								</div>
								<div class="col-md-2"><a id="tambah-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-success">Tambah '.$modelDetailRow->tipe_surat_detail.'</a></div>
								<div class="col-md-2"><a id="hapus-detail-check-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-danger">Hapus '.$modelDetailRow->tipe_surat_detail.'</a></div>
								
								</div>
								<div class="box-body">
								<div>
								<div>';
							
							
						$iDetail++;
					}
					$noUrut=$modelDetailRow->no_urut;
				}
				$fieldHtml =$fieldHtml.'
					                                <div class="form-group" id="rowDetail'.$modelDetailRow->id_pds_lid_surat_detail.'">
					                                    <div class="col-md-1">'. $form->field($modelDetailRow, "[$index]sub_no_urut")->textInput(['readonly' => $readOnly]) .'</div>
					                                    <div class="col-md-7">'. $form->field($modelDetailRow, "[$index]isi_surat_detail")->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => false)) .'</div>
					                                    <div class="col-md-1"><input type="checkbox" name="hapusDetailCheck'.$modelDetailRow->tipe_surat_detail.'" value="'. $modelDetailRow->id_pds_lid_surat_detail .'" /></div>
					                                </div>  ';
				$lastTipeSurat=$modelDetailRow->tipe_surat_detail;
		
		
			}
			$fieldHtml =$fieldHtml.'</div>
						<div id="new_'.$modelDetailRow->tipe_surat_detail.'"></div>
						</div></div>';
			$thisForm->registerJs("$(document).ready(function(){
					        $('#tambah-".$modelDetailRow->tipe_surat_detail."').click(function(){
									var x=1;
					                $('#new_".$modelDetailRow->tipe_surat_detail."').append(
					                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input type='text' class='form-control' name='new_no_urut".$lastTipeSurat."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$lastTipeSurat."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$lastTipeSurat."' value='@+x+@' /></div></div></div>"))))."'
		
									);
									x++;
					            });
		
							$('#hapus-detail-check-".$lastTipeSurat."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$lastTipeSurat." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$lastTipeSurat."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$lastTipeSurat."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
		
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$lastTipeSurat."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
					        });");
			$fieldHtml =$fieldHtml."<script>
							function hapusDetail(id)
							{
							   $('#new_".$modelDetailRow->tipe_surat_detail."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+id+'\">'
							   );
		
							   $('#rowDetail'+id).remove();
							};
							function hapusDetailPop(id)
							{
							   $('#newDetail'+id).remove();
							};
					</script>";
			return $fieldHtml;
		}
		
		
	
		function returnDetailFullDik3 ($form, $modelDetail, $thisForm, $typeSurat){
				$fieldHtml='';
			$noUrut=0;
			$lastTipeSurat='';
			$listDetail=Yii::$app->db->createCommand("select distinct tipe_surat_detail, no_urut from pidsus.template_surat_detail where id_jenis_surat='$typeSurat' order by no_urut")->queryAll();;
			$iDetail=0;
			//echo($listDetail[0]['tipe_surat_detail']);
			//die();
			foreach ($modelDetail as $index => $modelDetailRow) {
		
				if ($modelDetailRow->no_urut<>$noUrut){
					if($modelDetailRow->no_urut<>($noUrut+1)){
						$fieldHtml =$fieldHtml.'</div>
							<div id="new_'.$listDetail[$iDetail-1]['tipe_surat_detail'].'"></div>
							</br>
							<div>
							</div>
							</div>
							</div></div>';
						$thisForm->registerJs("$(document).ready(function(){
										var x =1;
						        $('#tambah-".$listDetail[$iDetail-1]['tipe_surat_detail']."').click(function(){
						                $('#new_".$listDetail[$iDetail-1]['tipe_surat_detail']."').append(
						                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input class='form-control' type='text' name='new_no_urut".$listDetail[$iDetail-1]['tipe_surat_detail']."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$listDetail[$iDetail-1]['tipe_surat_detail']."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$lastTipeSurat."' value='@+x+@' /></div></div></div>"))))."'
						                );
										x++;
						            });
		
							$('#hapus-detail-check-".$listDetail[$iDetail-1]['tipe_surat_detail']."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$listDetail[$iDetail-1]['tipe_surat_detail']." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$listDetail[$iDetail-1]['tipe_surat_detail']."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$listDetail[$iDetail-1]['tipe_surat_detail']."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$listDetail[$iDetail-1]['tipe_surat_detail']."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
						        });");
						$fieldHtml =$fieldHtml.'<div class="box box-solid">
								<div class="box-header with-border">
		
								<div class="col-md-5"><h3 class="box-title">'.$listDetail[$iDetail]['tipe_surat_detail'].':</h3>
								</div>
								<div class="col-md-2"><a id="tambah-'.$listDetail[$iDetail]['tipe_surat_detail'].'" class="btn btn-success">Tambah '.$listDetail[$iDetail]['tipe_surat_detail'].'</a></div>
								<div class="col-md-2"><a id="hapus-detail-check-'.$listDetail[$iDetail]['tipe_surat_detail'].'" class="btn btn-danger">Hapus '.$listDetail[$iDetail]['tipe_surat_detail'].'</a></div>
								
								</div>
								<div class="box-body">
								<div>
								<div>';
						$fieldHtml =$fieldHtml.'</div>
							<div id="new_'.$listDetail[$iDetail]['tipe_surat_detail'].'"></div>
							</br>
							<div>
							</div>
							</div>
							</div></div>';
						$fieldHtml =$fieldHtml.'<div class="box box-solid">
								<div class="box-header with-border">
		
								<div class="col-md-5"><h3 class="box-title">'.$modelDetailRow->tipe_surat_detail.':</h3>
								</div>
								<div class="col-md-2"><a id="tambah-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-success">Tambah '.$modelDetailRow->tipe_surat_detail.'</a></div>
								<div class="col-md-2"><a id="hapus-detail-check-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-danger">Hapus '.$modelDetailRow->tipe_surat_detail.'</a></div>
								
								</div>
								<div class="box-body">
								<div>
								<div>';
						$thisForm->registerJs("$(document).ready(function(){
										var x =1;
						        $('#tambah-".$listDetail[$iDetail]['tipe_surat_detail']."').click(function(){
						                $('#new_".$listDetail[$iDetail]['tipe_surat_detail']."').append(
						                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input class='form-control' type='text' name='new_no_urut".$listDetail[$iDetail]['tipe_surat_detail']."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$listDetail[$iDetail]['tipe_surat_detail']."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$listDetail[$iDetail]['tipe_surat_detail']."' value='@+x+@' /></div></div></div>"))))."'
						                );
										x++;
						            });
			
							$('#hapus-detail-check-".$listDetail[$iDetail]['tipe_surat_detail']."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$listDetail[$iDetail]['tipe_surat_detail']." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$listDetail[$iDetail]['tipe_surat_detail']."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$listDetail[$iDetail]['tipe_surat_detail']."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
		
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$listDetail[$iDetail]['tipe_surat_detail']."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
						        });");
						$iDetail++;
					}
					else {
						if($noUrut<>0){
							$fieldHtml =$fieldHtml.'</div>
							<div id="new_'.$lastTipeSurat.'"></div>
							</br>
							<div>
							</div>
							</div>
							</div></div>';
							$thisForm->registerJs("$(document).ready(function(){
										var x =1;
						        $('#tambah-".$lastTipeSurat."').click(function(){
						                $('#new_".$lastTipeSurat."').append(
						                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input class='form-control' type='text' name='new_no_urut".$lastTipeSurat."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$lastTipeSurat."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$lastTipeSurat."' value='@+x+@' /></div></div></div>"))))."'
						                );
										x++;
						            });
			
							$('#hapus-detail-check-".$lastTipeSurat."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$lastTipeSurat." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$lastTipeSurat."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$lastTipeSurat."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
		
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$lastTipeSurat."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
						        });");
						}
						$fieldHtml =$fieldHtml.'<div class="box box-solid">
								<div class="box-header with-border">
		
								<div class="col-md-5"><h3 class="box-title">'.$modelDetailRow->tipe_surat_detail.':</h3>
								</div>
								<div class="col-md-2"><a id="tambah-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-success">Tambah '.$modelDetailRow->tipe_surat_detail.'</a></div>
								<div class="col-md-2"><a id="hapus-detail-check-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-danger">Hapus '.$modelDetailRow->tipe_surat_detail.'</a></div>
								
								</div>
								<div class="box-body">
								<div>
								<div>';
							
							
						$iDetail++;
					}
					$noUrut=$modelDetailRow->no_urut;
				}
				$fieldHtml =$fieldHtml.'
					                                <div class="form-group" id="rowDetail'.$modelDetailRow->id_pds_dik_surat_detail.'">
					                                    <div class="col-md-1">'. $form->field($modelDetailRow, "[$index]sub_no_urut")->textInput(['readonly' => $readOnly]) .'</div>
					                                    <div class="col-md-7">'. $form->field($modelDetailRow, "[$index]isi_surat_detail")->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => false)) .'</div>
					                                    <div class="col-md-1"><input type="checkbox" name="hapusDetailCheck'.$modelDetailRow->tipe_surat_detail.'" value="'. $modelDetailRow->id_pds_dik_surat_detail .'" /></div>
					                                </div>  ';
				$lastTipeSurat=$modelDetailRow->tipe_surat_detail;
		
		
			}
			$fieldHtml =$fieldHtml.'</div>
						<div id="new_'.$modelDetailRow->tipe_surat_detail.'"></div>
						</div></div>';
			$thisForm->registerJs("$(document).ready(function(){
					        $('#tambah-".$modelDetailRow->tipe_surat_detail."').click(function(){
									var x=1;
					                $('#new_".$modelDetailRow->tipe_surat_detail."').append(
					                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input type='text' class='form-control' name='new_no_urut".$lastTipeSurat."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$lastTipeSurat."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$lastTipeSurat."' value='@+x+@' /></div></div></div>"))))."'
		
									);
									x++;
					            });
		
							$('#hapus-detail-check-".$lastTipeSurat."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$lastTipeSurat." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$lastTipeSurat."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$lastTipeSurat."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
		
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$lastTipeSurat."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
					        });");
			$fieldHtml =$fieldHtml."<script>
							function hapusDetail(id)
							{
							   $('#new_".$modelDetailRow->tipe_surat_detail."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+id+'\">'
							   );
		
							   $('#rowDetail'+id).remove();
							};
							function hapusDetailPop(id)
							{
							   $('#newDetail'+id).remove();
							};
					</script>";
			return $fieldHtml;
		}
		
		
	
		function returnDetailFullDikDisable ($form, $modelDetail, $thisForm){
			$fieldHtml='';
			$noUrut=0;
			$lastTipeSurat='';
			foreach ($modelDetail as $index => $modelDetailRow) {
				if ($modelDetailRow->no_urut<>$noUrut){
					if($noUrut<>0){
						$fieldHtml =$fieldHtml.'</div>

						</div>
						</div></div>';

					}
					$fieldHtml =$fieldHtml.'<div class="box box-solid">
							<div class="box-header with-border">

							<h3 class="box-title">'.$modelDetailRow->tipe_surat_detail.':</h3>
							</div>
							<div class="box-body">
							<div>
							<div>';



					$noUrut=$modelDetailRow->no_urut;
				}
				$fieldHtml =$fieldHtml.'
					                                <div class="form-group" id="rowDetail'.$modelDetailRow->id_pds_dik_surat_detail.'">
					                                    <label class="control-label col-md-2">'.$modelDetailRow->sub_no_urut.'. &nbsp</label>
					                                    <div class="col-md-6">'. $form->field($modelDetailRow, "[$index]isi_surat_detail")->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => true)) .'</div>

					                                </div>  ';
				$lastTipeSurat=$modelDetailRow->tipe_surat_detail;


			}
			$fieldHtml =$fieldHtml.'</div>
							</div>
						</div></div>';


			return $fieldHtml;
		}
		function returnDetailFullTut ($form, $modelDetail, $thisForm){
				$fieldHtml='';
			$noUrut=0;
			$lastTipeSurat='';
			$listDetail=Yii::$app->db->createCommand("select distinct tipe_surat_detail, no_urut from pidsus.template_surat_detail where id_jenis_surat='$typeSurat' order by no_urut")->queryAll();;
			$iDetail=0;
			//echo($listDetail[0]['tipe_surat_detail']);
			//die();
			foreach ($modelDetail as $index => $modelDetailRow) {
		
				if ($modelDetailRow->no_urut<>$noUrut){
					if($modelDetailRow->no_urut<>($noUrut+1)){
						$fieldHtml =$fieldHtml.'</div>
							<div id="new_'.$listDetail[$iDetail-1]['tipe_surat_detail'].'"></div>
							</br>
							<div>
							</div>
							</div>
							</div></div>';
						$thisForm->registerJs("$(document).ready(function(){
										var x =1;
						        $('#tambah-".$listDetail[$iDetail-1]['tipe_surat_detail']."').click(function(){
						                $('#new_".$listDetail[$iDetail-1]['tipe_surat_detail']."').append(
						                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input class='form-control' type='text' name='new_no_urut".$listDetail[$iDetail-1]['tipe_surat_detail']."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$listDetail[$iDetail-1]['tipe_surat_detail']."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$lastTipeSurat."' value='@+x+@' /></div></div></div>"))))."'
						                );
										x++;
						            });
		
							$('#hapus-detail-check-".$listDetail[$iDetail-1]['tipe_surat_detail']."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$listDetail[$iDetail-1]['tipe_surat_detail']." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$listDetail[$iDetail-1]['tipe_surat_detail']."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$listDetail[$iDetail-1]['tipe_surat_detail']."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$listDetail[$iDetail-1]['tipe_surat_detail']."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
						        });");
						$fieldHtml =$fieldHtml.'<div class="box box-solid">
								<div class="box-header with-border">
		
								<div class="col-md-5"><h3 class="box-title">'.$listDetail[$iDetail]['tipe_surat_detail'].':</h3>
								</div>
								<div class="col-md-2"><a id="tambah-'.$listDetail[$iDetail]['tipe_surat_detail'].'" class="btn btn-success">Tambah '.$listDetail[$iDetail]['tipe_surat_detail'].'</a></div>
								<div class="col-md-2"><a id="hapus-detail-check-'.$listDetail[$iDetail]['tipe_surat_detail'].'" class="btn btn-danger">Hapus '.$listDetail[$iDetail]['tipe_surat_detail'].'</a></div>
								
								</div>
								<div class="box-body">
								<div>
								<div>';
						$fieldHtml =$fieldHtml.'</div>
							<div id="new_'.$listDetail[$iDetail]['tipe_surat_detail'].'"></div>
							</br>
							<div>
							</div>
							</div>
							</div></div>';
						$fieldHtml =$fieldHtml.'<div class="box box-solid">
								<div class="box-header with-border">
		
								<div class="col-md-5"><h3 class="box-title">'.$modelDetailRow->tipe_surat_detail.':</h3>
								</div>
								<div class="col-md-2"><a id="tambah-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-success">Tambah '.$modelDetailRow->tipe_surat_detail.'</a></div>
								<div class="col-md-2"><a id="hapus-detail-check-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-danger">Hapus '.$modelDetailRow->tipe_surat_detail.'</a></div>
								
								</div>
								<div class="box-body">
								<div>
								<div>';
						$thisForm->registerJs("$(document).ready(function(){
										var x =1;
						        $('#tambah-".$listDetail[$iDetail]['tipe_surat_detail']."').click(function(){
						                $('#new_".$listDetail[$iDetail]['tipe_surat_detail']."').append(
						                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input class='form-control' type='text' name='new_no_urut".$listDetail[$iDetail]['tipe_surat_detail']."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$listDetail[$iDetail]['tipe_surat_detail']."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$listDetail[$iDetail]['tipe_surat_detail']."' value='@+x+@' /></div></div></div>"))))."'
						                );
										x++;
						            });
			
							$('#hapus-detail-check-".$listDetail[$iDetail]['tipe_surat_detail']."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$listDetail[$iDetail]['tipe_surat_detail']." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$listDetail[$iDetail]['tipe_surat_detail']."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$listDetail[$iDetail]['tipe_surat_detail']."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
		
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$listDetail[$iDetail]['tipe_surat_detail']."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
						        });");
						$iDetail++;
					}
					else {
						if($noUrut<>0){
							$fieldHtml =$fieldHtml.'</div>
							<div id="new_'.$lastTipeSurat.'"></div>
							</br>
							<div>
							</div>
							</div>
							</div></div>';
							$thisForm->registerJs("$(document).ready(function(){
										var x =1;
						        $('#tambah-".$lastTipeSurat."').click(function(){
						                $('#new_".$lastTipeSurat."').append(
						                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input class='form-control' type='text' name='new_no_urut".$lastTipeSurat."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$lastTipeSurat."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$lastTipeSurat."' value='@+x+@' /></div></div></div>"))))."'
						                );
										x++;
						            });
			
							$('#hapus-detail-check-".$lastTipeSurat."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$lastTipeSurat." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$lastTipeSurat."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$lastTipeSurat."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
		
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$lastTipeSurat."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
						        });");
						}
						$fieldHtml =$fieldHtml.'<div class="box box-solid">
								<div class="box-header with-border">
		
								<div class="col-md-5"><h3 class="box-title">'.$modelDetailRow->tipe_surat_detail.':</h3>
								</div>
								<div class="col-md-2"><a id="tambah-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-success">Tambah '.$modelDetailRow->tipe_surat_detail.'</a></div>
								<div class="col-md-2"><a id="hapus-detail-check-'.$modelDetailRow->tipe_surat_detail.'" class="btn btn-danger">Hapus '.$modelDetailRow->tipe_surat_detail.'</a></div>
								
								</div>
								<div class="box-body">
								<div>
								<div>';
							
							
						$iDetail++;
					}
					$noUrut=$modelDetailRow->no_urut;
				}
				$fieldHtml =$fieldHtml.'
					                                <div class="form-group" id="rowDetail'.$modelDetailRow->id_pds_tut_surat_detail.'">
					                                    <div class="col-md-1">'. $form->field($modelDetailRow, "[$index]sub_no_urut")->textInput(['readonly' => $readOnly]) .'</div>
					                                    <div class="col-md-7">'. $form->field($modelDetailRow, "[$index]isi_surat_detail")->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => false)) .'</div>
					                                    <div class="col-md-1"><input type="checkbox" name="hapusDetailCheck'.$modelDetailRow->tipe_surat_detail.'" value="'. $modelDetailRow->id_pds_tut_surat_detail .'" /></div>
					                                </div>  ';
				$lastTipeSurat=$modelDetailRow->tipe_surat_detail;
		
		
			}
			$fieldHtml =$fieldHtml.'</div>
						<div id="new_'.$modelDetailRow->tipe_surat_detail.'"></div>
						</div></div>';
			$thisForm->registerJs("$(document).ready(function(){
					        $('#tambah-".$modelDetailRow->tipe_surat_detail."').click(function(){
									var x=1;
					                $('#new_".$modelDetailRow->tipe_surat_detail."').append(
					                    '". str_replace("@","'",(str_replace("'","\"",preg_replace("/\s+/"," ","<div class='row' id='newDetail@+x+@'><div class='form-group'><div class='col-md-1'><input type='text' class='form-control' name='new_no_urut".$lastTipeSurat."[]'></input></div><div class='col-md-7'><textarea name='modelDetail".$lastTipeSurat."[]' cols='50' rows='3'  maxlength='4000'  value='' class='form-control'></textarea></div><div class=\"col-md-1\"><input type='checkbox' name='hapusNewDetailCheck".$lastTipeSurat."' value='@+x+@' /></div></div></div>"))))."'
		
									);
									x++;
					            });
		
							$('#hapus-detail-check-".$lastTipeSurat."').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus ".$lastTipeSurat." yang dipilih?');
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusDetailCheck".$lastTipeSurat."');
								var deleteDetailList =[];
								var deleteNewDetailList=[];						
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked)
								  {
									$('#new_".$lastTipeSurat."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+checkboxes[i].value+'\">'
									   );
		
									deleteDetailList.push(checkboxes[i].value);
									
								  }
								}
								for (var i=0; i<deleteDetailList.length;i++){
									$('#rowDetail'+deleteDetailList[i]).remove()
								}
								var newcheckboxes = document.getElementsByName('hapusNewDetailCheck".$lastTipeSurat."');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked)
								  {
										deleteNewDetailList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0; i<deleteNewDetailList.length;i++){
									$('#newDetail'+deleteNewDetailList[i]).remove();
								}
							}});
					        });");
			$fieldHtml =$fieldHtml."<script>
							function hapusDetail(id)
							{
							   $('#new_".$modelDetailRow->tipe_surat_detail."').append(
							       '<input type=\"hidden\" name=\"hapus_detail[]\" value=\"'+id+'\">'
							   );
		
							   $('#rowDetail'+id).remove();
							};
							function hapusDetailPop(id)
							{
							   $('#newDetail'+id).remove();
							};
					</script>";
			return $fieldHtml;
		}

		function returnDetailFullTutDisable ($form, $modelDetail, $thisForm){
			$fieldHtml='';
			$noUrut=0;
			$lastTipeSurat='';
			foreach ($modelDetail as $index => $modelDetailRow) {
				if ($modelDetailRow->no_urut<>$noUrut){
					if($noUrut<>0){
						$fieldHtml =$fieldHtml.'</div>

						</div>
						</div></div>';

					}
					$fieldHtml =$fieldHtml.'<div class="box box-solid">
							<div class="box-header with-border">

							<h3 class="box-title">'.$modelDetailRow->tipe_surat_detail.':</h3>
							</div>
							<div class="box-body">
							<div>
							<div>';



					$noUrut=$modelDetailRow->no_urut;
				}
				$fieldHtml =$fieldHtml.'
					                                <div class="form-group" id="rowDetail'.$modelDetailRow->id_pds_tut_surat_detail.'">
					                                    <label class="control-label col-md-2">'.$modelDetailRow->sub_no_urut.'. &nbsp</label>
					                                    <div class="col-md-6">'. $form->field($modelDetailRow, "[$index]isi_surat_detail")->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => true)) .'</div>

					                                </div>  ';
				$lastTipeSurat=$modelDetailRow->tipe_surat_detail;


			}
			$fieldHtml =$fieldHtml.'</div>
							</div>
						</div></div>';


			return $fieldHtml;
		}
		function setJs($this2,$form,$model,$modelLid){
			$this2->registerJs("$(document).ready(function(){
		        $('#tambah-pertimbangan').click(function(){
		      
		                $('#new_pertimbangan').append(
		                    '". str_replace("'","\"",preg_replace("/\s+/"," ",$this->returnDropDownListStatus($form,$model,$modelLid->id_status)))."'
		                );
					
		            });
		        });");
		}
		function returnDynamicFormOld($titleForm,$formType,$form,$model,$modelSurat){
			
			$fieldHtml='<div>
							    <div>
							        <div class="box box-solid">
							            <div class="box-body">
							                <div>
							                	<div class="col-md-6">';
			
			/*Field untuk form dari table pds_lid
			$modelTemplateIsi=TemplateSuratIsi::find()->where(['id_jenis_surat'=>$formType,'source_table'=>"pdsLid"])->orderBy('no_urut')->all();
			$jumlahFieldSurat=(count($modelTemplateIsi)/2)+(count($modelTemplateIsi)%2);
			$i=1;
			foreach($modelTemplateIsi as $fieldTemplate){
				$fieldHtml=$fieldHtml.$this->returnHtml($form,$model,$i,$fieldTemplate,$jumlahFieldSurat);
				$i++;
			}

			$fieldHtml=$fieldHtml.'</div></div><div>
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
		
		function returnDropDownList($form,$model,$query,$value,$label,$field,$disabled=false){
			
			try{	
				$rows=Yii::$app->db->createCommand($query)->queryAll();
				return $form->field($model, $field)-> dropDownList(ArrayHelper::map($rows,$value,$label),[$value=>$label,'disabled'=>$disabled]);
			}
			catch(Exception $e){
				
			}	
		}

		function returnDropDownListSuratIsi($form,$model,$query,$value,$label,$field,$disabled=false){

			try{
				$rows=Yii::$app->db->createCommand($query)->queryAll();
				return $form->field($model, $field)-> dropDownList(ArrayHelper::map($rows,$value,$label),[$value=>$label,'disabled'=>$disabled]);
			}
			catch(Exception $e){

			}
		}

		function returnDropDownListNoFormModel($query,$value,$label,$field,$disabled=false){
				$rows=Yii::$app->db->createCommand($query)->queryAll();
			return Html::dropDownList($field,null,ArrayHelper::map($rows,$value,$label));
		
			$connection->close();
		}
		
		function returnDropDownListStatus($form,$model,$idStatus=1,$disabled=false){
			return $this->returnDropDownList($form,$model,'select nama_status,id_status from pidsus.get_next_status('.$idStatus.') order by id_status','id_status','nama_status','id_status');
		}
		
		

function returnTembusanDynamic ($form,$modelTembusan,$thisForm,$type='lid'){
			$fieldHtml='
						<div class="form-group">
							<div class="col-md-5"></div>
							<div class="col-md-2"><a id="tambah-tembusan" class="btn btn-success">Tambah Tembusan</a></div>							
							<div class="col-md-2"><a id="hapus-tembusan-check" class="btn btn-danger">Hapus Tembusan</a></div>		
						</div>
						</br>';
			$i=1;			
			if($type=='lid'){
				foreach ($modelTembusan as $index => $modelTembusanRow) {
					$fieldHtml =$fieldHtml.'
						                                <div id="rowtembusan'. $modelTembusanRow->id_pds_lid_tembusan .'" class="form-group">
						                                    <div class="col-md-1"><input name="noUrutTembusan" type="text" value="'.$i.'" class="form-control" readonly></div>
						                                    <div class="col-md-7">'. $form->field($modelTembusanRow, "[$index]tembusan")->textInput(['readonly' => false]) .'</div>	
						                                   	<div class="col-md-1"><input type="checkbox" name="hapusTembusanCheck" value="'. $modelTembusanRow->id_pds_lid_tembusan .'" /></div>				                                   
						                                </div>  ';
					$i++;									
				}
			}
			else if ($type=='dik'){
				foreach ($modelTembusan as $index => $modelTembusanRow) {
					$fieldHtml =$fieldHtml.'
						                                <div id="rowtembusan'. $modelTembusanRow->id_pds_dik_tembusan .'" class="form-group">
						                                    <div class="col-md-1"><input name="noUrutTembusan" type="text" value="'.$i.'" class="form-control" readonly></div>
						                                    <div class="col-md-7">'. $form->field($modelTembusanRow, "[$index]tembusan")->textInput(['readonly' => false]) .'</div>
						                                   	<div class="col-md-1"><input type="checkbox" name="hapusTembusanCheck" value="'. $modelTembusanRow->id_pds_dik_tembusan .'" /></div>	
						                                </div>  ';
					$i++;
				}
			}
			else if ($type=='tut'){
				foreach ($modelTembusan as $index => $modelTembusanRow) {
					$fieldHtml =$fieldHtml.'
						                                <div id="rowtembusan'. $modelTembusanRow->id_pds_tut_tembusan .'" class="form-group">
						                                    <div class="col-md-1"><input name="noUrutTembusan" type="text" value="'.$i.'" class="form-control" readonly></div>
						                                    <div class="col-md-7">'. $form->field($modelTembusanRow, "[$index]tembusan")->textInput(['readonly' => false]) .'</div>
						                                   	<div class="col-md-1"><input type="checkbox" name="hapusTembusanCheck" value="'. $modelTembusanRow->id_pds_tut_tembusan .'" /></div>	
						                                </div>  ';
					$i++;
				}
			}
			$fieldHtml =$fieldHtml.'
						<div id="new_tembusan"></div>
						<div  class="form-group">
						                                    <div class="col-md-1"><input name="noUrutTembusan" type="text" value="'.$i.'" class="form-control" readonly></div>
						                                    <div class="col-md-7"><input type="text" value="Arsip." class="form-control" readonly></div>
						                                    <div class="col-md-1" ></div>		
						                                </div> 
						</br>';
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
							function reOrder(){
								var noUrutTembusan = document.getElementsByName('noUrutTembusan');
									var noUrut=1;	
									for (var i=0, n=noUrutTembusan.length;i<n;i++) {
									  noUrutTembusan[i].value=noUrut;					
									  noUrut++;
									}
							}
					</script>";
			
			$thisForm->registerJs("$(document).ready(function(){
							var x=1;
							
					        $('#tambah-tembusan').click(function(){		
					                $('#new_tembusan').append(
					                    '". preg_replace("/\s+/"," ","	<div id=\"new'+x+'\" class=\"form-group\"><div class=\"col-md-1\"><input type=\"text\" class=\"form-control\" name=\"noUrutTembusan\" value=\"\" readonly \"></input></div><div class=\"col-md-7\"><input type=\"text\" class=\"form-control\" name=\"new_tembusan[]\"></input></div><div class=\"col-md-1\"><input type=\"checkbox\" name=\"hapusNewTembusanCheck\" value=\"'+x+'\" /></div></div><br>")."'
					                );
									//tembusanNo++;
									//$('#arsipno').val(tembusanNo);
									reOrder();
									x++;
					            });
					
							$('#hapus-tembusan-check').click(function(){
								var r = confirm('Apakah anda yakin akan menghapus tembusan yang dipilih?');
								var deleteTembusanList=[];
								var deleteNewTembusanList=[];
							    if (r == true) {
								var checkboxes = document.getElementsByName('hapusTembusanCheck');	
								for (var i=0, n=checkboxes.length;i<n;i++) {
								  if (checkboxes[i].checked) 
								  {
									$('#new_tembusan').append(
							       '<input type=\"hidden\" name=\"hapus_tembusan[]\" value=\"'+checkboxes[i].value+'\">'
									   );
									deleteTembusanList.push(checkboxes[i].value);
								  }
								}
								for(var i=0;i<deleteTembusanList.length;i++){
									   $('#rowtembusan'+deleteTembusanList[i]).remove();
									   //tembusanNo--;
									   //$('#arsipno').val(tembusanNo);
								}
								var newcheckboxes = document.getElementsByName('hapusNewTembusanCheck');
								for (var i=0, n=newcheckboxes.length;i<n;i++) {
								  if (newcheckboxes[i].checked) 
								  {		
										deleteNewTembusanList.push(newcheckboxes[i].value);
								  }
								}
								for (var i=0;i<deleteNewTembusanList.length;i++){
										$('#new'+deleteNewTembusanList[i]).remove();
									   //tembusanNo--;
									   //$('#arsipno').val(tembusanNo);
								}
								reOrder();
							}});
					        });
								
					");
			return $fieldHtml;
		}
		
		function returnTembusanDynamicBackUp ($form,$modelTembusan,$thisForm,$type='lid'){
			$fieldHtml='';
			if($type=='lid'){
				foreach ($modelTembusan as $index => $modelTembusanRow) {
					$fieldHtml =$fieldHtml.'
						                                <div id="rowtembusan'. $modelTembusanRow->id_pds_lid_tembusan .'" class="form-group">
						                                    <div class="col-md-1">'.$form->field($modelTembusanRow, "[$index]no_urut")->textInput(['readonly' => false]).'</div>
						                                    <div class="col-md-7">'. $form->field($modelTembusanRow, "[$index]tembusan")->textInput(['readonly' => false]) .'</div>
						                                   	<div class="col-md-1"><a id="btn-hapus-tembusan" class="btn btn-danger" onclick="hapusTembusan(\''. $modelTembusanRow->id_pds_lid_tembusan .'\')">Hapus</a></div>
						                                </div>  ';
				}
			}
			else if ($type=='dik'){
				foreach ($modelTembusan as $index => $modelTembusanRow) {
					$fieldHtml =$fieldHtml.'
						                                <div id="rowtembusan'. $modelTembusanRow->id_pds_dik_tembusan .'" class="form-group">
						                                    <div class="col-md-1">'.$form->field($modelTembusanRow, "[$index]no_urut")->textInput(['readonly' => false]).'</div>
						                                    <div class="col-md-7">'. $form->field($modelTembusanRow, "[$index]tembusan")->textInput(['readonly' => false]) .'</div>
						                                   	<div class="col-md-1"><a id="btn-hapus-tembusan" class="btn btn-danger" onclick="hapusTembusan(\''. $modelTembusanRow->id_pds_dik_tembusan .'\')">Hapus</a></div>
						                                </div>  ';
				}
			}
			else if ($type=='tut'){
				foreach ($modelTembusan as $index => $modelTembusanRow) {
					$fieldHtml =$fieldHtml.'
						                                <div id="rowtembusan'. $modelTembusanRow->id_pds_tut_tembusan .'" class="form-group">
						                                    <div class="col-md-1">'.$form->field($modelTembusanRow, "[$index]no_urut")->textInput(['readonly' => false]).'</div>
						                                    <div class="col-md-7">'. $form->field($modelTembusanRow, "[$index]tembusan")->textInput(['readonly' => false]) .'</div>
						                                   	<div class="col-md-1"><a id="btn-hapus-tembusan" class="btn btn-danger" onclick="hapusTembusan(\''. $modelTembusanRow->id_pds_tut_tembusan .'\')">Hapus</a></div>
						                                </div>  ';
				}
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
					                    '". preg_replace("/\s+/"," ","	<div id=\"new'+x+'\" class=\"form-group\"><div class=\"col-md-1\"><input type=\"text\" class=\"form-control\" name=\"new_no_urut[]\"></input></div><div class=\"col-md-7\"><input type=\"text\" class=\"form-control\" name=\"new_tembusan[]\"></input></div><div clas=\"col-md-1\"><a id=\"hapus-tembusan\" onclick=\"hapusTembusanPop('+x+')\" class=\"btn btn-danger\">Hapus</a></div></div>")."'
					                );
									x++;
					            });
			
				
					        });
		
					");
			return $fieldHtml;
		}
		
	function returnDetailDynamicEmpty ($form,$modelDetail,$thisForm,$typeDetail,$type='lid'){
			$fieldHtml='';
			if($type=='lid'){
				foreach ($modelDetail as $index => $modelDetailRow) {
					$fieldHtml =$fieldHtml.'
						                                <div id="rowDetail'. $modelDetailRow->id_pds_lid_surat_detail .'" class="form-group">
						                                    <div class="col-md-1">'.$form->field($modelDetailRow, "[$index]no_urut")->textInput(['readonly' => false]).'</div>
						                                    <div class="col-md-7">'. $form->field($modelDetailRow, "[$index]isi_surat_detail")->textInput(['readonly' => false]) .'</div>
						                                   	<div class="col-md-1"><a id="btn-hapus-Detail" class="btn btn-danger" onclick="hapusDetail(\''. $modelDetailRow->id_pds_lid_Detail .'\')">Hapus</a></div>
						                                </div>  ';
				}
			}
			else {
				foreach ($modelDetail as $index => $modelDetailRow) {
					$fieldHtml =$fieldHtml.'
						                                <div id="rowDetail'. $modelDetailRow->id_pds_dik_surat_detail .'" class="form-group">
						                                    <div class="col-md-1">'.$form->field($modelDetailRow, "[$index]no_urut")->textInput(['readonly' => false]).'</div>
						                                    <div class="col-md-7">'. $form->field($modelDetailRow, "[$index]isi_surat_detail")->textInput(['readonly' => false]) .'</div>
						                                   	<div class="col-md-1"><a id="btn-hapus-Detail" class="btn btn-danger" onclick="hapusDetail(\''. $modelDetailRow->id_pds_dik_Detail .'\')">Hapus</a></div>
						                                </div>  ';
				}
			}
			$fieldHtml =$fieldHtml.'
						<div id="new_Detail_'.$typeDetail.'"></div>
						<a id="tambah-Detail-'.$typeDetail.'" class="btn btn-success">Tambah '.$typeDetail.'</a>';
			$fieldHtml =$fieldHtml."<script>
							function hapusDetail(id)
							{
							   $('#new_Detail_".$typeDetail."').append(
							       '<input type=\"hidden\" name=\"hapus_Detail[]\" value=\"'+id+'\">'
							   );
				
							   $('#rowDetail'+id).remove();
							};
							function hapusDetailPop(id)
							{
							   $('#newDetail'+id).remove();
							};
					</script>";
				
			$thisForm->registerJs("$(document).ready(function(){
							var x=1;
					        $('#tambah-Detail-".$typeDetail."').click(function(){
					                $('#new_Detail_".$typeDetail."').append(
					                    '". preg_replace("/\s+/"," ","	<div id=\"newDetail'+x+'\" class=\"form-group\"><div class=\"col-md-1\"><input type=\"text\" class=\"form-control\" name=\"new_no_urut_".$typeDetail."[]\"></input></div><div class=\"col-md-7\"><input type=\"text\" class=\"form-control\" name=\"new_isi_detail_".$typeDetail."[]\"></input></div><div clas=\"col-md-1\"><a id=\"hapus-Detail\" onclick=\"hapusDetailPop('+x+')\" class=\"btn btn-danger\">Hapus</a></div></div>")."'
					                );
									x++;
					            });
			
				
					        });
		
					");
			return $fieldHtml;
		}
		

		function returnSelect2($sql,$form,$model,$field,$label,$selectvalue,$selecttext,$placeholder,$for,$type='',$firstwidth='3',$secondwidth='6'){
			$data=Yii::$app->db->createCommand($sql)->queryAll();
			if($type=='full'){
				return '<div class="form-group">
			               <label for="'.$for.'" class="control-label col-md-'.$firstwidth.'">'.$label.'</label>
			               <div class="col-md-'.$secondwidth.'">'.$form->field($model, $field)->widget(Select2::classname(), [
					               		'data' => ArrayHelper::map($data,$selectvalue,$selecttext),
					               		'options' => ['placeholder' => $placeholder],
					               		'pluginOptions' => [
					               				'allowClear' => true
					               		],
					               ])
					               .'</div></div>  ';
			}
			else{
				return $form->field($model, $field)->widget(Select2::classname(), [
						'data' => ArrayHelper::map($data,$selectvalue,$selecttext),
						'options' => ['placeholder' => $placeholder],
						'pluginOptions' => [
								'allowClear' => true
						],
				])  ;
			}
		}


		function returnSelectDisable($sql,$form,$model,$field,$label,$selectvalue,$selecttext,$placeholder,$for,$type=''){
			$data=Yii::$app->db->createCommand($sql)->queryAll();
			if($type=='full'){
				return '<div class="form-group">
			               <label for="'.$for.'" class="control-label col-md-3">'.$label.'</label>
			               <div class="col-md-6">'.$form->field($model, $field)->widget(Select2::classname(), [
					'data' => ArrayHelper::map($data,$selectvalue,$selecttext),
					'options' => ['placeholder' => $placeholder],
					'pluginOptions' => [
						'allowClear' => true
					],
					'disabled' => true,
				])
				.'</div></div>  ';
			}
			else{
				return $form->field($model, $field)->widget(Select2::classname(), [
					'data' => ArrayHelper::map($data,$selectvalue,$selecttext),
					'options' => ['placeholder' => $placeholder],
					'pluginOptions' => [
						'allowClear' => true
					],
					'disabled' => true,
				])  ;
			}
		}


		function returnSelect2withoutmodel($sql,$form,$selectvalue,$selecttext,$placeholder,$for){
			$data=Yii::$app->db->createCommand($sql)->queryAll();
			return Select2::widget([
					'name' => $for,
					'id' => $for,
					'data' => ArrayHelper::map($data,$selectvalue,$selecttext),
					'options' => ['placeholder' => $placeholder],
					'pluginOptions' => [
							'allowClear' => true
					],
			]);
		}
		function returnSelect2ParameterDetail($form,$model,$for,$label,$idHeader,$type='full'){
			$sqlParameterDetail='select id_detail, nama_detail from pidsus.parameter_detail where id_header='.$idHeader.' order by no_urut';
			return $this->returnSelect2($sqlParameterDetail,$form,$model,$for,$label,'id_detail','nama_detail','Pilih '.$label.' ...',$for,$type);
								                                
		}

		function returnSelect2ParameterDetailWithoutModel($form,$for,$label,$idHeader,$fieldValue='id_detail',$fieldText='nama_detail'){
			$sqlParameterDetail='select * from pidsus.parameter_detail where id_header='.$idHeader.' order by no_urut';
			return $this->returnSelect2withoutmodel($sqlParameterDetail,$form,$fieldValue,$fieldText,'Pilih '.$label.' ...',$for);
			
		}
		
		function getPreviousSuratDate($model){
			if(empty($model->tgl_last_surat)){
				return null;
			}
			else {
				return  date('d m Y',strtotime($model->tgl_last_surat));
			}
		}
		
		function setInfoHeaderLaporan(){
			if(!empty($_SESSION['idPdsLid'])){
				$model=PdsLid::find()->where(['id_pds_lid'=>$_SESSION['idPdsLid']])->one();
				$_SESSION['noLapLid']='</br>Nomor Surat Laporan : '.$model->no_surat_lap.'    Surat Terakhir : '.$model->id_jenis_surat.'    Asal Surat : '.$model->pelapor;				
			}
			
			if(!empty($_SESSION['idPdsDik'])){
				$model=PdsDik::find()->where(['id_pds_dik'=>$_SESSION['idPdsDik']])->one();
				$_SESSION['noSpdpDik']='</br>Nomor Surat Laporan : '.$model->no_spdp.'    Surat Terakhir : '.$model->id_jenis_surat;	
			}
			
			if(!empty($_SESSION['idPdsTut'])){
				$model=PdsTut::find()->where(['id_pds_tut'=>$_SESSION['idPdsTut']])->one();
				$_SESSION['noSpdpTut']='</br>Nomor Surat Laporan : '.$model->no_spdp.'    Surat Terakhir : '.$model->id_jenis_surat;
			}
		}
		

		function checkActiveLid(){
			if(empty($_SESSION['idPdsLid'])){
				if (!empty($_SESSION['idPdsDik'])){
					$modelPdsDik=PdsDik::find()->where(['id_pds_dik'=>$_SESSION['idPdsDik']])->one();
					$_SESSION['idPdsLid']=$modelPdsDik->id_pds_lid_parent;
				}
				if (!empty($_SESSION['idPdsTut'])){
					$modelPdsDik=PdsTut::find()->where(['id_pds_tut'=>$_SESSION['idPdsTut']])->one();
					$_SESSION['idPdsLid']=$modelPdsTut->id_pds_lid_parent;
				}
				else{
					return $this->redirect(['../pidsus/default/index']);
				}
			}
		}
		
	}
?>
