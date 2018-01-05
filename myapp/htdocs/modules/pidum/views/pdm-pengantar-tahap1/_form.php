<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\typeahead\TypeaheadAsset;
use app\modules\pidum\models\PdmPengantarTahap1;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
use kartik\builder\Form;
use app\components\GlobalConstMenuComponent;
use kartik\grid\GridView;

AppAsset::register($this);
//AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPengantarTahap1 */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$this->registerJs(" 
    $('#pdmspdp-tgl_kejadian_perkara').on('change',function(){
      var today = new Date();
      var getYear = today.getFullYear();
      var minute    = $('span.combodate .minute option:selected').text();     
      var hour      = $('span.combodate .hour option:selected').text();
      var day       = $('span.combodate .day option:selected').text();
      var month     = $('span.combodate .month option:selected').text();
      var year      = $('span.combodate .year option:selected').val();
      if(year=='')
      {
        year = '0000';
      }
      if(minute=='minute')
      {
        minute = '00';
      }
      if(hour=='hour')
      {
        hour = '00';
      }
      if(day=='day')
      {
        day = '00';
      }
      if(month=='month')
      {
        month = '00';
      }
      var full_date = hour+'-'+minute+'-'+day+'-'+month+'-'+year;
      $(this).val(full_date);
    });
   
  ");
?>
<?php $form = ActiveForm::begin([            
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [        
                'labelSpan' => 1,
                'showLabels' => false
            ],
  ]); ?>
<div class="pdm-pengantar-tahap1-form">

    <div class="box box-primary"  style="border-color: #f39c12;">
    <div class="box-header"></div>
	
	<div class="col-md-12" style="padding:0">
            <div class="col-md-6" style="width:30%;">
                <div class="form-group">
                    <label class="control-label col-md-4"  style="width:40%;">Asal Surat</label>

                    <div class="col-md-8" style="width:60%;">
                        <input class="form-control" value="<?= $modelSpdp->idAsalsurat->nama ?>" readOnly="true">
                    </div>

                </div>
            </div>
            <div class="col-md-6" style="width:33%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:43%;">Instansi Penyidik</label>

                    <div class="col-md-8" style="width:57%;">
                        <input class="form-control" value="<?= $modelSpdp->idPenyidik->nama ?>" readOnly="true">
                    </div>

                </div>
            </div>
			<div class="col-md-6" style="width:36.7%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:40%;">Nomor Berkas</label>

                    <div class="col-md-8" style="width:60%;">
                        <input class="form-control" value="<?php echo $_GET['kd']; // echo $this->params['customParam']; ?>" readOnly="true">
                    </div>

                </div>
            </div>
			
        </div>
        <div class="clearfix" style="margin-bottom:14px;"></div>
	
	<div class="col-md-6" style="width:30%;">
                <div class="form-group">
                    <label class="control-label col-md-4" style="width:40%;">Nomor Pengantar</label>

                   <div class="col-md-8" style="width:60%;">
             <?=  $form->field($model, 'no_pengantar') ?>			
		
            </div>
				</div>
					</div>
	<div class="col-md-6" style="width:26%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:56%;">Tanggal Surat Pengantar</label>

                    <div class="col-md-8"  style="width:42%;">
                                 <?php                                   
                                  $trim   = explode('-',date('Y-m-d',strtotime("+1 days",strtotime($modelSpdp->tgl_surat))));
                                  $tgl_spdp = $trim[2].'-'.$trim[1].'-'.$trim[0];
                                  ?>
                                <?=
                                    $form->field($model, 'tgl_pengantar')->widget(DateControl::className(), [
                                        'type' => DateControl::FORMAT_DATE,
                                        'ajaxConversion' => false,
                                        'options' => [
                                            'options'=>[
                                                'placeholder'=>'DD-MM-YYYY',
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'startDate'=>  $tgl_spdp,
                                                //'endDate'  =>  $tgl_spdp_end
                                            ]
                                        ]
                                    ]);   
                                ?>
                            </div>
                        </div>    
                    </div>
	<div class="col-md-6" style="width:23%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:48%;">Tanggal Diterima</label>

                    <div class="col-md-9"  style="width:47%;">

                                <?=
                                    $form->field($model, 'tgl_terima')->widget(DateControl::className(), [
                                        'type' => DateControl::FORMAT_DATE,
                                        'ajaxConversion' => false,
                                        'options' => [
                                            'options'=>[
                                                'placeholder'=>'DD-MM-YYYY',
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'startDate'=>  $tgl_spdp,
                                                //'endDate'  =>  $tgl_spdp_end
                                            ]
                                        ]
                                    ]);   
                                ?>
                            </div>
                        </div>    
                    </div>
	<div class="col-md-6" style="width:21%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:50%;">Tanggal Berkas</label>

                    <div class="col-md-9"  style="width:49%;">
                             <input class="form-control" value="<?php echo $_GET['date'];?>" readOnly="true">
							 
                            </div>
                        </div>    
                    </div>	
	</div>			
	<div class="box box-primary"  style="border-color: #f39c12;margin-top: 70px;">		
	
				  <div class="box-header with-border" style="border-color: #c7c7c7;">
                 <h3 class="box-title">
                    <a class="btn btn-danger delete hapus"></a>&nbsp;<a class="btn btn-primary addJPU2" id="popUpTersangka" >Tersangka</a>
                </h3>
            </div>
				
				<div class="box-header with-border">
			
			   <table id="table_tersangka" class="table table-bordered">
                    <thead>
                        <tr>
							
                            <th style="text-align:center;" width="45px">#</th>
                            <th style="text-align:center;">Nama</th>
                            <th>Tempat, Tgl Lahir</th>
							<th>Umur</th>
							
                        </tr>
                    </thead>
                    <tbody id="tbody_tersangka">
                        <?php if (!$model->isNewRecord): ?>
					
                            <?php foreach ($modelTersangka as $key => $value): ?>
                                <tr data-id="<?= $value['id_tersangka'] ?>">
									<td id="tdTRS" width="20px"><input type='checkbox' name='tersangka[]' class='hapusTersangka' id='hapusTersangka' value="<?= $value['id_tersangka'] ?>"></td>
                                    <input type="text" name="no_urut[]" class="form-control" value="<?= ($value['no_urut'] != null) ? $key+1:$value['no_urut'] ?>" style="width: 50px;">
                                    <td><input type="text" name="nama_tersangka[]" class="form-control" readonly="true" value="<?= $value->nama ?>"><input type="hidden" name="id_tersangka[]" class="form-control" readonly="true" value="<?= $value->id_tersangka ?>"></td>
									<td><input type="text" name="tmpt_lahir_tersangka[]" class="form-control" readonly="true" value="<?= $value->tmpt_lahir ?>"></td>
                               
                                    
                                </tr>
                            <?php endforeach; ?>
			
                        <?php endif; ?>
                    </tbody>
                </table>
				<div id="hiddenId"></div>
				</div>
	 </div>
			
            <div class="box box-primary"  style="border-color: #f39c12;">
			<div class="box-header with-border">
                <div class="col-md-6">
                    <h5 class="box-title"> Undang-Undang & Pasal <a class="btn btn-small btn-warning" id="tambah-undang-pasal">+</a></h5>&nbsp;
                </div>
                <div class="col-md-6">

                    <span class="pull-right hide"><a class="btn btn-primary" id="tambah-pasal">+</a></span>
                            <span class="pull-right hide">
                                <select class="form-control" id="jenis-pasal">
                                    <option value="tunggal">Tunggal</option>
                                </select>

                            </span>
                </div>
				</div>
            </div>
            <div class="box-body" id="undang-pasal">

                
                    <div class="col-sm-8">
                        <div class="pull-right"><a class="btn btn-warning hide" id="tambah-undang-pasal">+</a></div>
                    </div>
                    <div class="col-sm-8">
                            <div class="undang-pasal-append"></div>
						<?php if(!$model->isNewRecord){?>
                        <?php foreach ($modelPasal as $key => $value): ?>
                        <div class="hapus<?php echo $key+1 ?>">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label>Undang-undang</label>
                                </div>
                                <div class="col-sm-8">
                                	<div class="col-sm-8">
                                    	<input type="text" name="undang1[]" class="form-control" readonly="true" value="<?= $value['undang'] ?>" placeholder="undang - undang">
                                    </div>
                                    <div class="col-sm-3"><a class='btn btn-danger delete' onclick="hapusPasal(<?php echo $key+1 ?>,'<?php echo $value['id_pasal'] ?>')"></a></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label>Pasal</label>
                                </div>
                                <div class="col-sm-8">
                                	<div class="col-sm-8">
                                    	<input type="text" name="pasal1[]" class="form-control" readonly="true" value="<?= $value['pasal'] ?>" placeholder="pasal - pasal">
                                    </div>
                                </div>
                            </div>
                         </div>
                        <?php endforeach; ?>
						<?php } ?>
                    </div>
		
            </div>
      
		
		<div class="box box-primary"  style="border-color: #f39c12;">
            <div class="box-header">
		
            <div class="col-md-8" style="padding-left:0px; width:60%;">
                <div class="form-group">
                    <label class="control-label col-md-2" style="padding-left:0px; width:25%;">Waktu Kejadian Perkara</label>
                    <?php
                       if(!($modelSpdp->isNewRecord)):
                       $date = explode('-', $modelSpdp->tgl_kejadian_perkara); 
                        $minute =   $date[1];
                        $hour   =   $date[0];
                        $day    =   $date[2];
                        $month  =   $date[3];
                        $year   =   $date[4];

                        if($minute=='')
                        {
                          $minute='00' ; 
                        }
                        if($hour=='')
                        {
                          $hour='00' ; 
                        }
                        if($day=='00'||$day=='')
                        {
                            $day = '01';
                        }

                        if($month=='00'||$month=='')
                        {
                            $month = '01';
                        }
                         if($year =='0000'||$year=='')
                        {
                            $year  = date('Y');
                        }
                       endif;?>
                    <div class="col-md-7"><!--CMS_PIDUM004 | jaka | rubah lebar kolom-->
                      <input   type="text" id="pdmspdp-tgl_kejadian_perkara" data-format="HH-mm-DD-MM-YYYY" data-template="HH  :  mm   DD - MM - YYYY "name="PdmSpdp[tgl_kejadian_perkara]" 
                      value="<?php echo trim($hour.'-'.$minute.'-'.$day.'-'.$month.'-'.$year); ?>">
                    </div>
                </div>
            </div>
			
			<div class="col-md-6" style="width:40%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:30%;">Tempat Kejadian</label>

                    <div class="col-md-9"  style="width:70%;">
                             <input class="form-control" value="<?= $modelSpdp->tempat_kejadian ?> ">
                            </div>
                        </div>    
                    </div>	
               
					
            
			</div>
        </div>	
		
           
      
	
    
<hr style="border-color: #c7c7c7;margin: 10px 0;">
    
    <div class="box-footer" style="text-align: center;"> 
        <?= Html::SubmitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?= Html::a('Batal', $model->isNewRecord ? ['../pidum/pdm-berkas-tahap1/create']: ['../pidum/pdm-berkas-tahap1/create'], ['class' => 'btn btn-danger']) ?>
       
    </div>



<?php ActiveForm::end(); ?>
<?php
$script = <<< JS
$(document).ready(function(){
    var today = new Date();
    var year = today.getFullYear();
    $('#pdmspdp-tgl_kejadian_perkara').combodate({
            firstItem: 'name',
            minYear: year-15,
            maxYear: year,
            minuteStep: 1,
            smartDays:true
    });
  var tgl_kejadian_perkara_db         = '$modelSpdp->tgl_kejadian_perkara';
  var split_tgl_kejadian_perkara_db   =  tgl_kejadian_perkara_db.split('-');
  var hour      = split_tgl_kejadian_perkara_db[0];     
  var minute    = split_tgl_kejadian_perkara_db[1];
  var day       = split_tgl_kejadian_perkara_db[2];
  var month     = split_tgl_kejadian_perkara_db[3];
  var year      = split_tgl_kejadian_perkara_db[4];
   if(minute =='00')
  {
    $('.minute option:eq(0)').prop('selected',true);
  }
  if(hour =='00')
  {
    $('.hour option:eq(0)').prop('selected',true);
  }
  if(day =='00')
  {
    $('.day option:eq(0)').prop('selected',true);
  }
   if(month =='00')
  {
    $('.month option:eq(0)').prop('selected',true);
  }
  if(year =='0000')
  {
    $('.year option:eq(0)').prop('selected',true);
  }


$('.combodate .hour').before('<span>Jam </span>');
$('.combodate .minute').before('<span>Menit </span>');
});


$('#popUpTersangka').click(function(){
 var href = $(this).attr('href');
            if(href != null){
                var id_tersangka = href.substring(1, href.length);
            }else{
                var id_tersangka = '';
            }
            
		$('#m_tersangka').html('');
        $('#m_tersangka').load('/pidum/pdm-pengantar-tahap1/show-tersangka?id_tersangka='+id_tersangka);
        $('#m_tersangka').modal('show');
	});
	
	 $(".hapus").click(function()
        {
             $.each($('input[type="checkbox"]'),function(x)
                {
                    var input = $(this);
                    if(input.prop('checked')==true)
                    {   var id = input.parent().parent();
                        id.remove();
                        $('#hiddenId').append(
                            '<input type="hidden" name="MsTersangka[nama_update][]" value='+input.val()+'>'
                            );
                    }
                }
             )
        });
	
	var currentValue = 1;
        $('#tambah-pasal').click(function(){
            if($('#jenis-pasal').val() == 'tunggal'){
                $('#tunggal').show();
            }

            if($('#jenis-pasal').val() == 'berlapis'){
                $('#tunggal').hide();
                $('#berlapis').show();
            }

        });


        // var undangPasal = new Bloodhound({
            // datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            // queryTokenizer: Bloodhound.tokenizers.whitespace,
            // remote: {
                // url: '/pidum/default/undang?q=%QUERY',
                // wildcard: '%QUERY'
            // }
        // });

		var i =1;
        $('#tambah-undang-pasal').click(function(){
			
                $('.undang-pasal-append').append(
					'<div class="hapus_pasal_awal'+i+'">'+
                    	'<div class="form-group">'+
                        	'<div class="col-sm-3">'+
                            	'<label>Undang-undang</label>'+
                        	'</div>'+
                        	'<div class="col-sm-8">'+
								'<div class="col-sm-8">'+
        	                    	'<input type="text" name="undang[]" class="form-control typeahead" placeholder="undang - undang">'+
								'</div>'+
								'<div class="col-sm-3">'+
									'<a class="btn btn-danger delete" onclick=hapusPasalAwal("'+i+'")></a>'+
								'</div>'+
                        	'</div>'+
                    	'</div>'+
                    	'<div class="form-group">'+
                        	'<div class="col-sm-3">'+
                            	'<label>Pasal</label>'+
                        	'</div>'+
							'<div class="col-sm-8">'+
								'<div class="col-sm-8">'+
        	                    	'<input type="text" name="pasal[]" class="form-control" placeholder="pasal - pasal">'+
								'</div>'+	
							'</div>'+
                        '</div>'+    
                    '</div>'
                    
					
                );
                $('.typeahead').typeahead('destroy');
                $('.typeahead').typeahead(null, {
                    name: 'undang',
                    displayKey: 'value',
                    source: undangPasal,
                });
				i++;
            });
JS;

$this->registerJs($script);
Modal::begin([
    'id' => 'm_tersangka',
    'header' => '<h7>Tambah Tersangka</h7>'
]);
Modal::end();

Modal::begin([
    'id'     => 'm_kewarganegaraan',
    'header' => '<h7>Pilih Kewarganegaraan<button type="button" id="contoh">klik</button></h7>'

]);
Modal::end();
?>
<script>
	function hapusPasalAwal(key)
	{
		$('.hapus_pasal_awal'+key).remove();
	}
	
	function hapusPasal(key, id_pasal)
	{
		$('.hapus'+key).remove();
		$('.hapus_undang_pasal').append(
			'<input type="hidden" name="hapus_undang_pasal[]" value="'+id_pasal+'">'
		);
	}
</script>
<script>
    function hapusTersangka(id)
    {
        //$("#tr_id"+id).remove();
        var arr = [id];
        jQuery.each(arr, function( i, val ) {
                    console.log(val);
                });
        //console.log(id);
    }
    function hapusTersangkaOld(id, value)
    {
        $("#tr_id_old"+id).remove();
        $('#hiddenId').append(
            '<input type="hidden" name="id_tersangka_remove[]" value='+value+'>'
        )
    }
</script>