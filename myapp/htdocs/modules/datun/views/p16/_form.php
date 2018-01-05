<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmP16;
use app\modules\pidum\models\PdmPenandatangan;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this View */
/* @var $model PdmP16 */
/* @var $form ActiveForm2 */

//jaka | 27 Mei 2016/CMS_PIDUM001_10 #setfocus
$this->registerJs(
  "$('#p16-form').on('afterValidate', function (event, messages) {
     
    if(typeof $('.has-error').first().offset() !== 'undefined') {
      var scroll     = $('.has-error').first().closest(':visible').offset().top;
      var minscroll  = (86.6/100)*scroll;
        $('html, body').animate({
            scrollTop: ($('.has-error').first().closest(':visible').offset().top)-minscroll
        }, 1500);
        var lenghInput = $('.has-error div input[type=text]').length;
        var lenghSearch = $('.has-error div input[type=search]').length;
         $('.has-error div input').first().focus();  
        if(lenghInput==0)
        {
          var minscrollText = (39/100)*($(document).height()-$(window).height());
          $('html, body').animate({
            scrollTop: ($(document).height()-$(window).height())-minscrollText
        }, 1500);
           $('.has-error div textarea').first().focus();
        }
        
      }
  });"
  );
//END <-- CMS_PIDUM001 -->
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">


        <?php
        $form = ActiveForm::begin([
                    'id' => 'p16-form',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'autoPlaceholder' => false
                    ],
                    'formConfig' => [
                        'deviceSize' => ActiveForm::SIZE_SMALL,
                        'showLabels' => false
                    ]
        ]);
        ?>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6 hide">
                    <div class="form-group">
                        <label class="control-label col-md-4">Wilayah Kerja</label>
                        <div class="col-md-8">
                            <input class="form-control" value="<?php echo Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'no_surat')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		

        <div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
                   Tersangka
                </h3>
            </div>
            <div class="box-header with-border">
                <?php
                        if ($modelTersangka != null) {                            
                            $layout = <<< HTML
                                
                                <div class="clearfix"></div>
                                {items}
                                <div class="col-sm-5">&nbsp;</div><div class="col-sm-2">{pager}</div><div class="col-sm-5">&nbsp;</div>
HTML;
                            echo kartik\grid\GridView::widget([
                               'id' => 'tersangka',
                                'dataProvider' => $dataProviderTersangka,
                                'layout'=>$layout,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:3.38%;']],
                                    'nama'
                                    
                                ],
                                
                                'export' => false,
                                'pjax' => true,
                                'responsive'=>true,
                                'hover'=>true,
                            ]);
                            
                                    
                        }
                        ?>
            </div>
        </div>
        <div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
                    <a class="btn btn-danger delete hapus"></a>&nbsp;<a class="btn btn-primary addJPU2" id="popUpJpu">Jaksa</a>
                </h3>
            </div>
            <div class="box-header with-border">

            <!-- jaka | rubah grid jaksa -->
                <table id="table_jpu" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="text-align:center;" width="45px"></th>
                            <th style="text-align:center;" width="45px">#</th>
                            <th>NAMA<br>NIP</th>
                            <th>PANGKAT / GOLONGAN<br>JABATAN</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tbody_jpu">
						<!-- DANAR 16-06-2016 -->
                        <?php if (!$model->isNewRecord):  $numRows= 1; ?>
                            <?php foreach ($modelJpu as $key => $value): ?>
                                <tr data-id="<?= $value['id_jpp'] ?>">
                                    <td style="text-align:center;" id="tdJPU"><input type='checkbox' name='jaksa[]' class='hapusJaksa' id='hapusJaksa' value="<?= $value['id_jpp'] ?>"></td>
                                    <td style="text-align:center;"><input type="text" name="no_urut[]" class="form-control hide" value="" style="width: 50px;"><?php echo $numRows++ ;?></td>
                                    <td class="hide"><input type="text" name="nip_baru[]" class="form-control hide" readonly="true" value="<?= $value['peg_nip_baru'] ?>"><input type="hidden" name="nip_jpu[]" class="form-control hide" readonly="true" value="<?= $value['nip'] ?>"></td>
                                    <td><input type="text" name="nama_jpu[]" class="form-control hide" readonly="true" value="<?= $value->nama ?>"><?= $value->nama ?><br><?= $value['peg_nip_baru'] ?></td>
                                    <td><input type="text" name="gol_jpu[]" class="form-control hide" readonly="true" value="<?= $value->pangkat ?>"><?= $value->pangkat ?><br><?= $value->jabatan ?></td>
                                    <td class="hide"><input type="text" name="jabatan_jpu[]" class="form-control" readonly="true" value="<?= $value->jabatan ?>"></td>
                                    
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
             <!-- END -->
            </div>
        </div>
            <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
                <div class="col-md-12">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="control-label col-md-4">Dikeluarkan</label>
                            <div class="col-md-8">
                                <?php 
                                if ($model->isNewRecord){
                                    echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]) ;
                                }else{
                                    echo $form->field($model, 'dikeluarkan'); 
                                } 
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tanggal Ditandatangani</label>
                            <div class="col-md-4" style="width:32%">
                            <?php 
                                  //BEGIN Etrio Widodo CMS_PIDUM037
                                  $trim         = explode('-',$modelSpdp->tgl_terima);
                                  //END Etrio Widodo CMS_PIDUM037
                                  $tgl_spdp     = $trim[2].'-'.$trim[1].'-'.$trim[0];
                                  $trim_end     = explode('-',date('Y-m-d', strtotime("+7 days")));
                                  $tgl_spdp_end = $trim_end[2].'-'.$trim_end[1].'-'.$trim_end[0];
                                  
                             ?>
                                <?=

                                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options'=>[
                                            'placeholder'=>'DD-MM-YYYY',//jaka | tambah placeholder format tanggal
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            //BEgin CMS_PIDUM-P16_7 Etrio Widodo;
                                            'startDate'=>  $tgl_spdp,
                                            'endDate'  =>  $tgl_spdp_end
                                            //End CMS_PIDUM-P16_7 Etrio Widodo;
                                        ]
                                    ]
                                ]);                                
                                ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <div class="box box-primary" style="border-color: #f39c12">
            <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P16, 'id_table' => $model->id_p16]) ?>
        </div>

      <div class="box-footer" style="text-align: center;">
            <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
          <?php if(!$model->isNewRecord): ?>  
            <a href="javascript:void(0)" class="btn btn-warning" id="printToChange">Cetak</a>
          <?php endif ?> 
          <?php if($model->isNewRecord): ?> 
          <a href="javascript:void(0)" class="btn btn-warning" id="printToSave">Cetak</a>
           <?php endif ?> 
          <!-- jaka | 27 mei 2016| CMS_PIDUM001_16 #tambah tombol batal -->
        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pidum/p16/index'], ['class' => 'btn btn-danger']) ?>
        <!-- END CMS_PIDUM001_16 --> 
        </div>
        <div id="hiddenId">
            
        </div>
        <input type="hidden" name="printToSave">
       
    </div>
</section>
<div id='m_alert'>
 
</div>
<?php
 

$script1 = <<< JS
// $('#m_alert').load('/pidum/p16/alert-sukses');
// $('#m_alert div').insertAfter($('body'));

    /*$(document).on('click', 'a#btn_hapus', function () {
        $(this).parent().parent().remove();
        return false;
    });*/
 $('#m_tanda_tangan').on('show.bs.modal', function () {
           $('.help-block').remove();
        });
  $('#m_jpu').on('hidden.bs.modal', function () {
            $("#m_jpu").css('overflow','hidden');
            $("body").css('overflow-y','scroll');
            
        });
        $('#m_jpu').on('show.bs.modal', function () {            
            $("#m_jpu").css('overflow','scroll');
            $("body").css('overflow-y','hidden');            
        });
    $('#printToSave').click(function(){
        var print       = $('#pdmp16-no_surat').val();
        var tempat      = $('#pdmp16-dikeluarkan').val();
        var tgl         = $('#pdmp16-tgl_dikeluarkan-disp').val();        
        var tandaTangan = $('#pdmp16-id_penandatangan').val(); 
        var jumlahJaksa = $('#tbody_jpu tr').length;       
        if(print!=''&&tempat!=''&&tgl!=''&&tandaTangan!='')
        {
            if(jumlahJaksa<1)
        {
           bootbox.dialog({
                message: "Jaksa Belum Terisi",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",
                        callback: function(){
                          $('#popUpJpu').click();
                        }
                    }
                }
            });
        }
        else
        {
             $.ajax({
                type        : 'POST',
                url         :'/pidum/p16/cek-no-surat-p16',
                data        : 'no_surat='+print,                                
                success     : function(data)
                                {
                                  if(data>0)
                                  {
                                    alert('No P-16 : Telah Tersedia Silahkan Input No Lain');
                                    
                                  }
                                  else
                                  {
                                    $('input[name="printToSave"]').val('1');
                                         $.ajax({
                                            type: "POST",
                                            async:    false,
                                            url: '/pidum/p16/create',
                                            data: $("form").serialize(),
                                            success:function(data){ 
                                            $('.box-footer').hide(); 
                                            var cetak   = '/pidum/p16/cetak?id='+data;  
                                            var update  =  'update?id='+data;
                                                window.location.href = cetak;
                                                setTimeout(function(){ window.location = update; }, 3000);
                                        
                                            },
                                        });
                                  }
                              }
                });
        }
             
            
        }
        else
        {
            $('form').submit();
        }
        

    });

    $('#printToChange').click(function(){
        var jumlahJaksa = $('#tbody_jpu tr').length;  
        if(jumlahJaksa<1)
        {
           bootbox.dialog({
                message: "Jaksa Belum Terisi",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",
                        callback: function(){
                          $('#popUpJpu').click();
                        }
                    }
                }
            });
        }
        else
        {      
         
        $('input[name="printToSave"]').val('2');
             $.ajax({
                type: "POST",
                async:    false,
                url: '/pidum/p16/update?id='+'$model->id_p16',
                data: $("form").serialize(),
                success:function(data){
                    
                    $('.box-footer').hide();
                var cetak   = 'cetak?id='+data;  
                var update  =  'update?id='+data;
                window.location.href = cetak;

                setTimeout(function(){ window.location = update; }, 3000);
                },
            });
        }
    });
    //main untuk pemanggilan dari seluruh checkbox jaksa ketika ajax sucsess dijalankan.
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

	$('#popUpJpu').click(function(){
		$('#m_jpu').html('');
        $('#m_jpu').load('/pidum/p16/jpu');
        $('#m_jpu').modal('show');
	});

  

     //BEGIN CMS_PIDUM001_   CREATED BY ETRIO WIDODO
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
    //END CMS_PIDUM001_   CREATED BY ETRIO WIDODO 

/*
      $( document ).on('click', '.hapusJaksa', function(e) {
        var input = $( this );
            $(".hapus").click(function(event){
                event.preventDefault();
                if(input.prop( "checked" ) == true){
                    bootbox.dialog({
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){
                                    $("#trjpu"+e.target.value).remove();
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });

                }else if(input.prop( "checked" ) == false){
                    $(".hapus").off("click");
                }
            });


    });*/
	
	//validasi simpan no p16 yg sama #bowo

   if($('.btn-warning:eq(0)').text()=='Simpan')
    {
     $('.btn-warning').attr('type','button');
     $('.btn-warning:eq(0)').attr('id','simpan');
    }else
    {
     $('.btn-warning').attr('type','button');
     $('.btn-warning:eq(0)').attr('id','ubah');
    } 

  
// $("#pdmspdp-no_surat").change(function(){

// });
// Get the input box
var textInput = document.getElementById('pdmp16-no_surat');

// Init a timeout variable to be used below
var timeout = null;

// Listen for keystroke events
textInput.onkeyup = function (e) {

    // Clear the timeout if it has already been set.
    // This will prevent the previous task from executing
    // if it has been less than <MILLISECONDS>
    clearTimeout(timeout);
	   timeout = setTimeout(function () {
            $.ajax({
                        type        : 'POST',
                        url         :'/pidum/p16/cek-no-surat-p16',
                        data        : 'no_surat='+textInput.value, 
                        beforeSend  : function()
                                        {
                                           // $('#loading').modal('show');
                                        },                  
                        success     : function(data)
                                        {
                                          // $('#loading').modal('hide');
                                          if(data>0)
                                          {
                                            alert('No P-16 : Telah Tersedia Silahkan Input No Lain');
											
                                          }else
                                          {
                                            $('body').removeClass("loading")
                                          }
                                      }
                });
    }, 500);
};

    $('#ubah').click(function(){
         var jumlahJaksa = $('#tbody_jpu tr').length;
        if(jumlahJaksa<1)
        {
           bootbox.dialog({
                message: "Jaksa Belum Terisi",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",
                        callback: function(){
                        $('#popUpJpu').click();
                        }
                    }
                }
            });
        }
        else
        {
            $('form').submit();
        }
        });
	$('#simpan').click(function(){
    var no_surat = $('#pdmp16-no_surat').val();
    var jumlahJaksa = $('#tbody_jpu tr').length;
    if(no_surat!='')
    {
        if(jumlahJaksa<1)
        {
           bootbox.dialog({
                message: "Jaksa Belum Terisi",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",
                        callback: function(){
                        $('#popUpJpu').click();
                        }
                    }
                }
            });
        }
        else
        {
             $.ajax({
                type    : 'POST',
                url     :'/pidum/p16/cek-no-surat-p16',
                data    : 'no_surat='+no_surat,                      
                success : function(data)
                            {
                              if(data>0)
                              {
                                alert('No P-16 : Telah Tersedia Silahkan Input No Lain');
                                $('#pdmp16-no_surat').val("");
                                $('#p16-form').submit();
                              }
                              else
                              {
                                $('#p16-form').submit();
                              }
                            }
                });  
        }
           
    }else
    {
        $('#p16-form').submit();
    }
   
});

JS;
$this->registerJs($script1);
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Tambah JPU</h7>'
]);
Modal::end();

?>
<!--?php
ActiveForm::end(); 
Modal::begin([
    'id' => 'm_tanda_tangan',
    'header' => '<h7>Data Tersangka</h7>'
]);
Modal::end();
?>-->