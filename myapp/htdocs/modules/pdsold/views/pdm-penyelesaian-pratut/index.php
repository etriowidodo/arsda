<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use yii\bootstrap\Modal;
use app\modules\pdsold\models\MsTersangkaBerkas;
use app\modules\pdsold\models\PdmPengantarTahap1;
use app\modules\pdsold\models\PdmP21;
use app\modules\pdsold\models\PdmP21ASearch;
use app\modules\pdsold\models\PdmP21a;
use app\modules\pdsold\models\PdmBerkasTahap1;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmPenyelesaianPratutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penyelesaian Pra Penuntutan';



$tgl_akhir ='';

$tgl_berkas = PdmBerkasTahap1::findOne(['id_berkas'=>$id_berkas]) ;
if($tgl_berkas->tgl_berkas!='')
{
    $tgl_akhir =$tgl_berkas->tgl_berkas;
}
$tgl_p21 = PdmP21::findOne(['id_berkas'=>$id_berkas]);
if($tgl_p21->tgl_dikeluarkan!='')
{
    $tgl_akhir =$tgl_p21->tgl_dikeluarkan;
}
$tgl_p21a = PdmP21a::findOne(['id_berkas'=>$id_berkas]);
if($tgl_p21a->tgl_dikeluarkan!='')
{
    $tgl_akhir =$tgl_p21a->tgl_dikeluarkan;
}


    $date_akhir = date_create((date('Y-m-d',strtotime($tgl_akhir))));
    date_add($date_akhir, date_interval_create_from_date_string('1 days'));
    $date_akhir = $date_akhir->format('Y-m-d');

?>

<div class="pdm-penyelesaian-pratut-index">
	 <div id="divTambah" class="col-md-11" style="width:74%;">
        
    </div>
	<div  class="col-md-1" style="width:14%;">
        
    </div>
    <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
    
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-penyelesaian-pratut/deleteberkas/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1" style="width:5%; margin-left:0px;">
        <button  class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
   <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_pratut'],'data-idberkas' => $model['id_berkas']];
			
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
     		[
                'attribute'=>'no_berkas',
                'label' => 'Nomor dan Tanggal Berkas',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['berkas'];
					
                },


            ],
             
        [
                'attribute'=>'nama',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $column) {
                        $no_pengantar = PdmPengantarTahap1::find()->where(['id_berkas'=>$model['id_berkas']])->orderBy('tgl_pengantar desc')->limit(1)->one()->no_pengantar;
                        //$TersangkaSS = MsTersangkaBerkas::findAll(['no_pengantar'=>$no_pengantar]);
						//$modelGridTersangka = MsTersangkaBerkas::find()->where(['id_berkas' => $model['id_berkas']])->orderBy(['no_urut'=>sort_asc])->all();
                        $modelGridTersangka = MsTersangkaBerkas::find()->where(['no_pengantar' => $no_pengantar])->orderBy(['no_urut'=>sort_asc])->all();
						$tersangka = '';
						$i=1; 
						foreach ($modelGridTersangka as $key => $value): 
							$tersangka .= $i.". ".$value->nama."<br/>";
							$i++; 
						endforeach;
                        return $tersangka;
                    }


            ],
                        
        [
                'attribute'=>'proses',
                'label' => 'Status',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
					return $model['status'];
                },


            ],        
       
            
              [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_pratut'],'data-id' => $model['id_pratut'],'data-berkas' => $model['id_berkas'], 'class' => 'checkHapusIndex'];
                    }
            ], 
        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>
	
	<?php if(isset($updateBerkas) && $updateBerkas=='1'){ ?>
 <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">

	
	 <?php $form = ActiveForm::begin(
    [
        'id' => 'pdm-penyelesaian-pratut-form',
		'action' => '/pdsold/pdm-penyelesaian-pratut/updateberkas?id_pratut='.$id_pratut.'&id_berkas='.$id_berkas,
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'labelSpan' => 1,
            'showLabels' => false

        ],
		'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
    ]); ?>
	
	<div class="col-md-12">
			<div class="form-group">
				<label class="control-label col-sm-2">Status</label>
				<div class="col-sm-3" >
					<?php echo $form->field($model, 'status')->dropDownList(['1' => 'Lanjut Ke Penuntutan','2' => 'Diversi', '3' => 'SP-3','4' => 'Optimal'],['prompt'=>'Pilih Status']); ?>
				</div>
				<!-- <div class="col-sm-1" id="div_pelimpahan" style="margin-right:4%">
					<a class="btn btn-primary" id="pelimpahan" data-toggle="modal" data-target="#bannerformmodal"  data-backdrop="static" data-keyboard="false"  >Surat Pelimpahan</a>
				</div> -->
				<div id="div_sikapjaksa">
					<label class="control-label col-sm-2">Sikap Jaksa</label>
					<div class="col-sm-3" >
						<?= $form->field($model, 'sikap_jpu')->radioList(['1' => 'Tepat', '2' => 'Tidak Tepat'],['inline'=>true])->label(false) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 " id="div_nomor_tanggal">
			<div class="form-group">
				<label class="control-label col-sm-2">Nomor</label>
				<div class="col-sm-3" >
					<?= $form->field($model, 'nomor')->textInput()  ?>
				</div>
				<div>
					<label class="control-label col-sm-2">Tanggal</label>
					<div class="col-sm-2" style="width:12%" >
						 <?=
							$form->field($model, 'tgl_surat')->widget(DateControl::className(), [
								'type' => DateControl::FORMAT_DATE,
								'ajaxConversion' => false,
								'options' => [
									'options' => [
										'placeholder' => 'DD-MM-YYYY',//dikeluarkan jadi surat
									],
									'pluginOptions' => [
										'autoclose' => true,
                                        'startDate' => date('d-m-Y',strtotime($date_akhir)),
                                        'endDate'   => date('d-m-Y') ,
									]
								]
							]);
						?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12 " id="div_upload" >
        <div class="col-md-6" >
            <div class="form-group form-inline">
        		
				<div class="col-md-2 inline" >
                <?php
						echo $form->field($model, 'file_upload')->widget(FileInput::classname(), [
                            'options' => ['accept'=>'application/pdf'],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showUpload' => false,
                                'showRemove' => false,
								'showClose' => false,
                                'showCaption'=> false,
                                'allowedFileExtension' => ['pdf'],
                                'browseLabel'=>'Unggah...',
                            ]
                        ]);
                        if ($model->file_upload != null || $model->file_upload != '') { 
                            echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pdsold_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                        }
					
                        ?>  
						
                </div>
                
            </div>
        </div>
		</div>
		
	

<div class="box-footer" id="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
    </div>
	

<?php ActiveForm::end(); ?>
</div>

	<!--- Modal -->
<div class="modal"  id="bannerformmodal">
	 <?php /*$this->render('//pdm-penyelesain-pratut/_popupPelimpahan', ['modelLimpah' => $modelLimpah,'modelTersangka'=>$modelTersangka,'modelBerkas'=>$modelBerkas,'modelJaksa'=>$modelJaksa,'dataSatker' => $dataSatker,'searchSatker'=>$searchSatker,'date_akhir'=>$date_akhir])*/ ?>
</div>
<!--- Modal -->
	

	<!--- Modal -->
<div class="modal" id="modalSatker">
	 <?= $this->render('//pdm-penyelesaian-pratut/_satker', ['dataSatker' => $dataSatker,'searchSatker'=>$searchSatker]) ?>
</div>
<!--- Modal -->

<div class="modal" id="modalPenandatangan">

</div>


<?php } ?>



      




<?php
 
    $js = <<< JS
	if($(".empty").text()=='Tidak ada data yang ditemukan.'){
		$(".select-on-check-all").hide();
	}
	var status = '$model->status';
	if(status=='1'){
		//$('#div_pelimpahan').hide();
        $('#div_nomor_tanggal').hide();
        $('#div_upload').hide();
        $('#div_sikapjaksa').hide();
        $('#box-footer').show();
	}
	
	
	$('#idUbah').click (function (e) {
        var count =$('.checkHapusIndex:checked').length;
		if (count != 1 )
		{
		 bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		} else {
		var idpratut =$('.checkHapusIndex:checked').val();
		var idberkas = $('.checkHapusIndex:checked').data('berkas');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-penyelesaian-pratut/updateberkas?id_pratut=" + idpratut+"&id_berkas=" +idberkas;
        $(location).attr('href',url);
		}
    });
	

	
	$('#popUpJpu').click(function(){
		$('#m_jpu_16a').html('');
        $('#m_jpu_16a').load('/pdsold/p16/jpu16a');
        $('#m_jpu_16a').modal('show');
	});
	
	
	
	/*if($('#pdmpenyelesaianpratut-status').val()!='1'){
		$('#div_pelimpahan').hide();
	}else{
		$('#div_pelimpahan').show();
	}*/
	
		if($('#pdmpenyelesaianpratut-status').val()!='3'){
			$('#div_sikapjaksa').hide();
		}else{
			$('#div_sikapjaksa').show();
		}
		
	$('#pdmpenyelesaianpratut-status').on('change', function(){
		if(this.value=='1'){
			//$('#div_pelimpahan').hide();
			$('#div_nomor_tanggal').hide();
			$('#div_upload').hide();
			$('#div_sikapjaksa').hide();
			$('#box-footer').show();
		}
		
		if(this.value=='2'){
			$('#div_sikapjaksa').hide();
			$('#div_nomor_tanggal').show();
			$('#div_upload').show();
			$('#box-footer').show();
		}
		
		if(this.value=='3'){
			$('#div_sikapjaksa').show();
			$('#div_nomor_tanggal').show();
			$('#div_upload').show();
			$('#box-footer').show();
		}
		
		if(this.value=='4'){
			$('#div_sikapjaksa').hide();
			$('#div_nomor_tanggal').show();
			$('#div_upload').show();
			$('#box-footer').show();
		}
		
		
	});	
	if($(".empty").text()=='Tidak ada data yang ditemukan.'){
		$(".select-on-check-all").hide();
	}
	
    $('td').dblclick(function (e) {
        var idpratut = $(this).closest('tr').data('id');
		var idberkas = $(this).closest('tr').data('idberkas');
		
		if (idpratut ==undefined)
		{
		bootbox.dialog({
                message: "Maaf tidak terdapat data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}
		else
        {
		var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-penyelesaian-pratut/updateberkas?id_pratut=" + idpratut+"&id_berkas=" +idberkas;
        $(location).attr('href',url);
		$("input[value='" + idpratut + "']").prop('checked', 'checked');
		}
    });
	
	$('#modal_advance').on('hidden.bs.modal',function(){
		var elem =$(this);
		$('#btn_submit').click();
		
		
	});
	
	$('#m_jpu_16a').on('hidden.bs.modal',function(){
		$('#bannerformmodal').css('overflow-y', 'scroll');  
	});
	
	
	 var nipBaruValue =[];
    $(document).ajaxSuccess(function()
            {       
                    var countJaksa = nipBaruValue.length;
                    if(countJaksa>0)
                    {
                        $.each(nipBaruValue,function(index,value){
                            search_col_jaksa(value);
                        });
                    }
                    pilihJaksaCheckBoxModal();

            });

//Awal CMS_PIDUM_ Etrio Widodo pilihJaksaCheckBoxModal
    function pilihJaksaCheckBoxModal(){
        $('input:checkbox[name=\"pilih\"]').click(function(){

            if($(this).is(':checked'))
            {
                var input = $(this).val().split('#');
                if(clickJaksaBaru.length>0)
                {
                   if(cekClickJaksa($(this).val())<1)
                    {
                     clickJaksaBaru.push($(this).val());
                     nipBaruValue.push(input[4]);
                    }                                   
                }else{
                  clickJaksaBaru=[$(this).val()];
                  nipBaruValue.push(input[4]); 
                }
            }
            else
            {
                remClickJaksa($(this).val());
            }

            function cekClickJaksa(id)
            {
                var dat = clickJaksaBaru;
                var a = 0 ;
                $.each(dat, function(x,y){
                if(id==y)
                {
                    a++;
                }                                           
                });
                return a;
            }
            function remClickJaksa(id)
            {
               
                var dat     = clickJaksaBaru; 
                var dat2    = nipBaruValue;              
                $.each(dat, function(x,y){                                
                    if(id==y)
                    {
                        dat.splice(x,1);                                         
                    }
                });

                var potong  = id.split('#');                
                 $.each(dat2, function(x,y){                                                
                    if(potong[4]==y)
                    {
                        dat2.splice(x,1);                                        
                    }
                }); 
            }
        });
    }
//Akhir pilihJaksaCheckBoxModal;


//AWAL  search_col_jaksa Etrio WIdodo
    function search_col_jaksa(id)
                {
                    var tr = $('tr').last().attr('data-key');
                    for (var trs =0;trs<=tr;trs++)
                    {
                        var result = $('tr[data-key=\"'+trs+'\" ] td[data-col-seq=1]').text();
                        if(id==result)
                        {
                            $('tr[data-key=\"'+trs+'\" ]').addClass('danger');
                            $('tr[data-key=\"'+trs+'\" ] td input:checkbox').attr('checked', true).attr('disabled',false);
                        }
                    }       
                
                }
//akhir search_col_jaksa;


 $(".hapus").click(function()
        {
             $.each($('input[type="checkbox"][name="jaksa[]"]'),function(x)
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
        }
    );
	
	
JS;



Modal::begin([
    'id' => 'm_jpu_16a',
    'header' => '<h7>Tambah JPU</h7>',
	'clientOptions' => ['backdrop' => 'static', 'keyboard' => false] 
]);
Modal::end();

    $this->registerJs($js);
?>



</div>


