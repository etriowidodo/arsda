<!-- <script src="js/jquery-1.3.2.js"></script>
<script src="js/jquery.iframe-post-form.js"></script>
<script src="js/jquery.simplemodal.js"></script> -->
<!-- <script src="js/mgupload.js"></script>
 -->
 <style>
#mstersangkapt-warganegara {
 background-color: #FFF;
  cursor: text;
}


    /* Start by setting display:none to make this hidden.
       Then we position it in relation to the viewport window
       with position:fixed. Width, height, top and left speak
       for themselves. Background we set to 80% white with
       our animation centered, and no-repeating */
    .modal-loading-new {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 )
                    url(<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/image/loading.gif'; ?>)
                    50% 50%
                    no-repeat;
    }

    /* When the body has the loading class, we turn
       the scrollbar off with overflow:hidden */
    body.loading {
        overflow: hidden;
    }

    /* Anytime the body has the loading class, our
       modal element will be visible */
    body.loading .modal-loading-new {
        display: block;
    }

</style>
<?php

/**
 * Created by PhpStorm.
 * User: rio
 * Date: 25/06/15
 * Time: 16:03
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use app\modules\pidum\models\MsLoktahanan;

//jaka | 25 Mei 2016/CMS_PIDUM001_10 #setfocus
use app\assets\AppAsset;
AppAsset::register($this);
$this->registerJs(

  "

  $('#tersangka-form,#tersangka-form').on('afterValidate', function (event, messages) {

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
  });



  "
  );
//END <-- CMS_PIDUM001 -->

$form = ActiveForm::begin([
            'id' => 'tersangka-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showLabels' => false
            ],
            'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
        ]);
?>
<div class="modal-loading-new"></div>
<div class="modal-content" style="width:75%;margin: 2% auto;">
    <div class="modal-header">
        <!--CMS_PIDIUM001_5-->
        Data Tersangka
		<a style="margin-left:70%;" class="btn btn-primary tambah_calon_tersangka tambah-tersangka" id="tersangkaFromSpdp">Tersangka</a>
    </div>

    <div class="modal-body">

        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Nama Tersangka</label>

                        <div class="col-md-10">
                            <?php echo $form->field($modelTersangka, 'nama'); ?>
                        </div>



                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <!-- CMS_PIDUM003_28|jaka|03-06-2016|ganti label TTL menjadi tempat lahir -->
                        <label class="control-label col-md-4">Tempat Lahir</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'tmpt_lahir'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Lahir</label><!-- jaka|03-06-2016|tambah label tanggal lahir -->
                        <div class="col-md-2" style="width:27%">
                            <?php
                            echo $form->field($modelTersangka, 'tgl_lahir')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => [
                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                    ],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'startDate' => '-101y',
                                    ],
                                    'pluginEvents' => [
                                        "changeDate" => "function(e) {


                                        }",
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                        <label class="control-label col-md-1" style="width:15%;padding-left:30px;">Umur</label><!-- CMS_PIDUM003_28|jaka|03-06-2016|tambah label Umur -->
                         <div class="col-md-2 control-label-inline" style="width:22%">
                         <!-- BEGIN CMS_PIDUM001_03 ETRIO WIDODO -->
                             <?php echo $form->field($modelTersangka, 'umur')->Input('number',
                        ['max'      =>99,
                         'min'      =>0,
                         'maxlength'=>2,
                         'oninput'  =>'
                                        var number =  /^[0-9]+$/;
                                        if(this.value.length>2)
                                        {
                                          this.value = this.value.substr(0,2);
                                        }
                                        if(this.value<0)
                                        {
                                           this.value =null
                                        }
                                        if(!this.value.match(number))
                                        {
                                            this.value =null
                                        }
                                        ',
                        'onchange'=>'maxpendidikan()']); ?>
                       <!-- END CMS_PIDUM001_03 ETRIO WIDODO -->
                    </div>

                    <label class="control-label label-inline col-md-1" style="padding-left:0px;">Tahun</label><!-- CMS_PIDUM003_28|jaka|03-06-2016|tambah label tahun untuk usia-->
                </div>
            </div>
 </div>
 <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kewarganegaraan</label>
                        <div class="col-md-8">

                            <?php

                            //<!-- BEGIN CMS_PIDUM001_13 ETRIO WIDODO -->

                                function search_wn($strorage,$id=null)
                                {
                                    foreach($strorage AS $index=>$value )
                                    {
                                        if($id!=null)
                                        {
                                            if($id==$index)
                                            {
                                                return $value;
                                            }
                                        }

                                    }
                                }

                                $i_wn = $modelTersangka->warganegara;

                                echo $form->field($modelTersangka, 'warganegara')->textInput(['type'=>'text','value'=>search_wn($warganegara,$i_wn) ,'readonly'=>'readonly','placeholder'=>'--Pilih Kewarganegaraan--','data-id'=>$i_wn]);

                            //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->

                            // echo $form->field($modelTersangka, 'warganegara')->dropDownList( $warganegara,
                            //                         ['prompt' => '---Pilih---'],
                            //                         ['label'=>'']
                            //)

                             ?>

                        </div>
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Suku</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelTersangka, 'suku') ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Identitas</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($modelTersangka, 'id_identitas')->dropDownList(
                                    $identitas,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>'']
                            )
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                    <!-- jaka | tambahan label dan filter number-->
                    <label class="control-label col-md-3" style="">No Identitas</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelTersangka, 'no_identitas')->input('text',
                                [
                                'maxlength'=> '24',
                                'oninput'  =>'
                                        var onchange = document.getElementById("mstersangkapt-id_identitas").value;
                                        var number =  /^[0-9-]+$/;
                                        if(onchange != 3)
                                        {
                                           if(this.value.length>24)
                                            {
                                              this.value = this.value.substr(0,24);
                                            }
                                            if(this.value<0)
                                            {
                                               this.value =null
                                            }
                                            var str   = "";
                                            var slice = "";
                                            var b   = 0;
                                            for(var a =1;a<=this.value.length;a++)
                                            {
                                                slice = this.value.substr(b,1);
                                                if(slice.match(number))
                                                {
                                                    str+=slice;
                                                }

                                                b++
                                            }
                                            this.value=str;
                                        }


                                        ']) ?>
                        <!-- END -->
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
									<label class="control-label col-md-4">Jenis Kelamin</label>
                        <div class="col-md-8">
                        <!--
                        <div class="btn-group" data-toggle="button-radio">
                            <button type="button" class="btn btn-primary">Laki</button>
                            <button type="button" class="btn btn-primary">Perempuan</button>
                        </div>
                        <!-- BEGIN CMS_PIDUM001_12 ETRIO WIDODO -->



								<?php

								echo $form->field($modelTersangka, 'id_jkl')->radioList($JenisKelamin);

								//echo $form->field($modelTersangka, 'id_jkl')->inline()->radioList($JnsKelamin);
                                //echo $form->field($modelTersangka, 'id_jkl');
                              //echo $form->radioButtonList($modelTersangka,'id_jkl',(1=>'Laki-laki',2=>'Perempuan'),array('separator'=>'&nbsp;','labelOptions'=>array('style'=>'display:inline'),));
                                //echo $form->error($modelTersangka,'id_jkl');
                                //echo  $form->radioButtonList($model,'radio',array('m'=>'male','f'=>'female'),array('separator'=>'', 'labelOptions'=>array('style'=>'display:inline')));
                                                    // ->dropDownList($JnsKelamin,
                                                    // ['prompt' => '---Pilih---'],
                                                    // ['label'=>'']) ?>
							<!-- BEGIN CMS_PIDUM001_12 ETRIO WIDODO -->

						</div>
                  </div>
               </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" style="">Agama</label>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($modelTersangka, 'id_agama')->dropDownList( $agama,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>''])
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Alamat</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'alamat')->textarea() ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" style="">No HP</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelTersangka, 'no_hp')->input('text',
                                ['oninput'  =>'var number =  /^[0-9]+$/;
                                        if(this.value.length>24)
                                        {
                                          this.value = this.value.substr(0,24);
                                        }
                                        if(this.value<0)
                                        {
                                           this.value =null
                                        }
                                        var str   = "";
                                        var slice = "";
                                        var b   = 0;
                                        for(var a =1;a<=this.value.length;a++)
                                        {
                                            slice = this.value.substr(b,1);
                                            if(slice.match(number))
                                            {
                                                str+=slice;
                                            }

                                            b++
                                        }
                                        this.value=str;
                                        ']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pendidikan</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($modelTersangka, 'id_pendidikan')->dropDownList( $pendidikan,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>'']
                            )
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" style="">Pekerjaan</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelTersangka, 'pekerjaan') ?>
                        </div>
                    </div>
                </div>

            </div>

            <?= $form->field($modelTersangka, 'id_tersangka')->hiddenInput() ?>


             <!-- END CMS_PIDUM001_07 EtrioWidodo 08-06-2016-->
        </div>

        <div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 style="margin:0px;">Riwayat Penahanan
            </div>
            <div class="box-header with-border">
                <div class="col-md-12" style="padding:0px;">
                    <div class="well well-sm col-md-12 " style="background-color:#fcbd3e">
                        <div class="form-inline col-md-10" style="padding:0;">
                            <div class="col-md-3" style="font-size:16px;padding-left:0;">
                                Jenis Penahanan
                            </div>
                            <div class="col-md-5" style="font-size:16px;padding-left:130px; width:50%;">
                                Masa Penahanan
                            </div>
                            <div class="col-md-3" style="font-size:16px; width:23%;padding-left:160px;">
                                Lokasi
                            </div>
                        </div>
                    </div>
                    <div class="well well-sm col-md-12 ">
                        <div class="form-inline col-md-12" style="padding:0;">
                            <div class="col-md-2" style="font-size:16px;padding-left:0;">
                                <?php
                                echo $form->field($modelPerpanjanganTahanan, 'id_msloktahanan')->dropDownList( $lok_tahanan,
                                ['prompt' => '---Pilih---'],
                                ['label'=>''])
                                ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div id='tgl_mulai_penahanan' class="col-md-4" style="font-size:16px;">
                                        <?php
                                        echo $form->field($modelPerpanjanganTahanan, 'tgl_mulai')->widget(DateControl::className(), [
                                            'type' => DateControl::FORMAT_DATE,
                                            'ajaxConversion' => false,
                                            'options' => [
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'endDate' => date('d-m-Y'),
                                                ],
                                                'options' => [
                                                    'placeholder' => 'Tanggal Mulai',
                                                    'style' => 'width:120px;',
                                                ]
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                    <label class="control-label col-md-1"> s/d</label>
                                    <div class="col-md-3" id='tgl_diterima_tersangka' style="font-size:16px;">
                                        <?php
                                        echo $form->field($modelPerpanjanganTahanan, 'tgl_selesai')->widget(DateControl::className(), [
                                            'type' => DateControl::FORMAT_DATE,
                                            'ajaxConversion' => false,
                                            'options' => [
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'endDate' => date('d-m-Y'),
                                                ],
                                                'options' => [
                                                    'placeholder' => 'Tanggal Selesai',
                                                    'style' => 'width:120px;',
                                                ]
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="font-size:16px;">
                                <?php echo $form->field($modelPerpanjanganTahanan, 'lokasi_penahanan')->textInput(['style'=>"width:250px"]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-header with-border">
                <div class="col-md-12" style="padding:0px;">
                    <div class="well well-sm col-md-12 " style="background-color:#fcbd3e">
                        <div class="form-inline col-md-10" style="padding:0;">
                            <div class="col-md-3" style="font-size:16px;padding-left:0;">
                                Jumlah Persetujuan
                            </div>
                            <div class="col-md-5" style="font-size:16px;padding-left:130px; width:50%;">
                                Masa Permintaan Perpanjangan
                            </div>
                        </div>
                    </div>
                    <div class="well well-sm col-md-12 ">
                        <div class="form-inline col-md-12" style="padding:0;">
                            <div class="col-md-2" style="font-size:16px;padding-left:0;">
                                <?php echo $form->field($modelPerpanjanganTahanan, 'persetujuan')->textInput(['style'=>"width:100px"]); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div id='tgl_mulai_penahanan' class="col-md-4" style="font-size:16px;">
                                        <?php
                                        echo $form->field($modelPerpanjanganTahanan, 'tgl_mulai_permintaan')->widget(DateControl::className(), [
                                            'type' => DateControl::FORMAT_DATE,
                                            'ajaxConversion' => false,
                                            'options' => [
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'endDate' => date('d-m-Y'),
                                                ],
                                                'options' => [
                                                    'placeholder' => 'Tanggal Mulai',
                                                    'style' => 'width:120px;',
                                                    'onChange' => 'hitung()',
                                                ]
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                    <label class="control-label col-md-1"> s/d</label>
                                    <div class="col-md-3" id='tgl_diterima_tersangka' style="font-size:16px;">
                                        <?php
                                        echo $form->field($modelPerpanjanganTahanan, 'tgl_selesai_permintaan')->widget(DateControl::className(), [
                                            'type' => DateControl::FORMAT_DATE,
                                            'ajaxConversion' => false,
                                            'options' => [
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'endDate' => date('d-m-Y'),
                                                ],
                                                'options' => [
                                                    'placeholder' => 'Tanggal Selesai',
                                                    'style' => 'width:120px;',
                                                ]
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
        //echo $modelPdmSpdp->tgl_surat;
        $tgl_kejadian_split = explode('-', $modelPdmSpdp->tgl_kejadian_perkara);

        if($tgl_kejadian_split[4]!='0000')
        {
           if($tgl_kejadian_split[2]=='00')
           {
              $tgl_kejadian_split[2]='01';
           }
           if($tgl_kejadian_split[3]=='00')
           {
              $tgl_kejadian_split[3]='01';
           }
            $tgl_kejadian = $tgl_kejadian_split[4].'-'.$tgl_kejadian_split[3].'-'.$tgl_kejadian_split[2];
        }
        else
        {
            $tgl_kejadian = '';
        }

        if($tgl_kejadian!='')
        {
            $compare = $tgl_kejadian;
        }
        else
        {
            $compare = $modelPdmSpdp->tgl_surat;
        }

        ?>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
            <?php if($modelTersangka->isNewRecord): ?>
                <a class="btn btn-warning" id="simpan-tersangka">Simpan</a>
            <?php else: ?>
                <a class="btn btn-warning" id="ubah-tersangka">Ubah</a>
            <?php endif; ?>
            <!-- jaka 25 mei 2016/CMS_PIDUM001_8 #tambah tombol batal -->
            <a class="btn btn-danger" data-dismiss="modal">Batal</a>
            <!--END CMS_PIDUM001_8 -->
        </div>
    </div>
</div>


<script language='javascript'>
function validAngka(a)
{
    if(!/^[0-9.]+$/.test(a.value))
    {
    a.value = a.value.substring(0,a.value.length-1000);
    }

}
</script>


   <?php


   ActiveForm::end();
   $maxpendidikan = json_encode($maxPendidikan);
Modal::begin([
    'id' => 'm_tersangka2',
    'header' => '<h7>Data Tersangka</h7>'
]);
Modal::end();
?>
<?php
$now =  date('Y-m-d');
$script = <<< JS
        
        function hitung(){
            var range = $('#pdmperpanjangantahanan-persetujuan').val()
            if(range>0)
            {
                count_date(range);
            }else{
                alert('hari belum terisi');


                  $('#pdmperpanjangantahanan-tgl_selesai_permintaan-disp').removeAttr('disabled');
                  // $('#pdmt4-tgl_selesai-disp').attr('readonly',true);
            }
        }
        
        
        function count_date(range)
      {
         var range = parseInt(range);
         var start_date = $('#pdmperpanjangantahanan-tgl_mulai_permintaan-disp').val().split('-');
            var start_date = start_date[2]+"-"+start_date[1]+"-"+start_date[0];
                function pad(number){
                        return (number < 10) ? '0' + number : number;
                    }
                var targetDate = new Date(start_date);
                targetDate.setDate(targetDate.getDate()+range-1);
                var dd      = pad(targetDate.getDate());
                var mm      = pad(targetDate.getMonth()+1);
                var yyyy    = targetDate.getFullYear();
                $('#pdmperpanjangantahanan-tgl_selesai_permintaan-disp').val(dd+'-'+mm+'-'+yyyy);
                $('#pdmt4-tgl_selesai').val(yyyy+'-'+mm+'-'+dd);
      }
        
//        $('body').on('change','#pdmperpanjangantahanan-tgl_mulai_permintaan-disp',function(){
//            var range = $('#pdmperpanjangantahanan-persetujuan').val()
//            if(range>0)
//            {
//                count_date(range);
//            }else{
//                alert('hari belum terisi');
//
//
//                  $('#pdmperpanjangantahanan-tgl_selesai_permintaan-disp').removeAttr(''readonly',true');
//                  // $('#pdmt4-tgl_selesai-disp').attr('readonly',true);
//            }
//         });  
        
        

$('#pdmperpanjangantahanan-id_msloktahanan,#pdmperpanjangantahanan-tgl_mulai-disp').on('click hover',function(){
    console.log($('#pdmperpanjangantahanan-tgl_surat_penahanan-disp').val());
    var date        = $('#pdmperpanjangantahanan-tgl_surat_penahanan-disp').val().split('-');
    date            = date[2]+'-'+date[1]+'-'+date[0];
    console.log(date);
    var someDate    = new Date(date);
    var endDate     = new Date('$now');
    console.log(date);
    //someDate.setDate(someDate.getDate()+7);
    someDate.setDate(someDate.getDate());
    endDate.setDate(endDate.getDate());
    var dateFormated        = someDate.toISOString().substr(0,10);
    var enddateFormated     = endDate.toISOString().substr(0,10);
    var resultDate          = dateFormated.split('-');
    var endresultDate       = enddateFormated.split('-');
    finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
    date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
    var input               = $('#tgl_mulai_penahanan').html();
    var datecontrol         = $('#pdmperpanjangantahanan-tgl_mulai-disp').attr('data-krajee-datecontrol');
    $('#tgl_mulai_penahanan').html(input);
    var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
    var datecontrol_001 = {'idSave':'pdmperpanjangantahanan-tgl_mulai','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}};
      $('#pdmperpanjangantahanan-tgl_mulai-disp').kvDatepicker(kvDatepicker_001);
      $('#pdmperpanjangantahanan-tgl_mulai-disp').datecontrol(datecontrol_001);
      $('.field-pdmperpanjangantahanan-tgl_mulai').removeClass('.has-error');
      $('#pdmperpanjangantahanan-tgl_mulai-disp').removeAttr('disabled');
});



 $('body').on('change','#pdmperpanjangantahanan-tgl_mulai-disp',function(){

    var date        = $(this).val().split('-');
    date            = date[2]+'-'+date[1]+'-'+date[0];
    var someDate    = new Date(date);
    var endDate     = new Date('$now')

    //someDate.setDate(someDate.getDate()+7);
    someDate.setDate(someDate.getDate());
    endDate.setDate(endDate.getDate());
    var dateFormated        = someDate.toISOString().substr(0,10);
    var enddateFormated     = endDate.toISOString().substr(0,10);
    var resultDate          = dateFormated.split('-');
    var endresultDate       = enddateFormated.split('-');
    finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
    date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
    var input               = $('#tgl_diterima_tersangka').html();
    var datecontrol         = $('#pdmperpanjangantahanan-tgl_selesai-disp').attr('data-krajee-datecontrol');
    $('#tgl_diterima_tersangka').html(input);

    var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
    var datecontrol_001 = {'idSave':'pdmperpanjangantahanan-tgl_selesai','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}};
      $('#pdmperpanjangantahanan-tgl_selesai-disp').kvDatepicker(kvDatepicker_001);
      $('#pdmperpanjangantahanan-tgl_selesai-disp').datecontrol(datecontrol_001);
      $('.field-pdmperpanjangantahanan-tgl_selesai').removeClass('.has-error');
  });

$("#mstersangkapt-id_identitas").change(function(){
    var change = $(this).val();
    $("#mstersangkapt-no_identitas").val("");
	if(change=='4'){
		$("#mstersangkapt-no_identitas").val("-");
		$("#mstersangkapt-no_identitas").attr('readonly',true);

	}else{
		$("#mstersangkapt-no_identitas").attr('readonly',false);
		$("#mstersangkapt-no_identitas").val('');
	}
});

   $('#m_tersangka').on('hidden.bs.modal', function () {
            $("body").css('overflow-y','scroll');
            localStorage.clear();

        });

$('#m_tersangka').on('show.bs.modal', function () {
       $("#m_tersangka").css('overflow','scroll');
            $("body").css('overflow-y','hidden');
        });

$('#tersangkaFromSpdp').click(function(){
    $('#m_tersangka2').html('');
    $('#m_tersangka2').load('/pidum/pdm-perpanjangan-tahanan/tersangka');
    $('#m_tersangka2').modal('show');
});

//Etrio Widodo

var tmppath = '';
var myImage = '';
$('#foto').on('change',function(e){

       if(this.files[0].size>=3072000)
       {
            alert('Besar File tidak boleh melebihi : 3 Mb');
            $('.file-preview').hide();
            $('.fileinput-remove-button,.fileinput-remove').trigger('click');
            $('.fileinput-remove-button').hide();
       }
        var fileExtension = ['jpeg', 'jpg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1)
        {
             if($(this).val()=='')
             {
                myImage = '';
                $('#new_foto').val("");
             }
             else
             {
                alert("Format yang di izinkan hanya : "+fileExtension.join(', '));
                $('.file-preview').hide();
                $('.fileinput-remove-button,.fileinput-remove').trigger('click');
                $('.fileinput-remove-button').hide();
             }
        }else
        {
             $('.file-preview').show();
             $('.fileinput-remove-button').show();
             tmppath = URL.createObjectURL(e.target.files[0]);
             var url = tmppath;
             var canvas = document.getElementById("MyCanvas");

                if (canvas.getContext)
                {
                    var ctx = canvas.getContext("2d");
                    var img = new Image();
                    img.src = url;
                        img.onload = function ()
                        {
                        var hRatio = canvas.width / img.width    ;
                        var vRatio = canvas.height / img.height  ;
                        var ratio  = Math.min ( hRatio, vRatio );
                        ctx.drawImage(img, 0,0, img.width, img.height, 0,0,img.width*ratio, img.height*ratio);
                        myImage = canvas.toDataURL("image/jpeg");
                        $('#new_foto').val(myImage);
                        }
                }
                $('#show_image_tersangka').remove();
        }


});



$('.fileinput-remove-button,.fileinput-remove').click(function(){
    myImage = '';
    $('#new_foto').val("");
});
$('.radio').css('display','inline-block');
//BEGIN CMS_PIDUM_SPDP_001
 //<!-- BEGIN CMS_PIDUM001_13 ETRIO WIDODO -->
    $('#mstersangkapt-warganegara').click(function(){

        $('#m_kewarganegaraan').html('');
        $('#m_kewarganegaraan').load('/pidum/pdm-perpanjangan-tahanan/wn');
        $('#m_kewarganegaraan').modal('show');
    });
 //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->
     $('#m_kewarganegaraan div div div button.close').hide();
    //<!-- CMS_PIDIUM001_4 bowo 25 mei 2016 -->
    $('#mstersangkapt-nama').attr('placeholder','Nama');
    $('#mstersangkapt-no_identitas').attr('placeholder','No. Identitas');
    $('#mstersangkapt-tmpt_lahir').attr('placeholder','Tempat Lahir');
    $('#mstersangkapt-umur').attr('placeholder','Umur');
    var mydate       = new Date();
    var unix         = mydate.getYear()+''+mydate.getUTCHours()+''+mydate.getUTCMinutes()+''+mydate.getUTCSeconds();
    var currentValue = unix;
    var isi_table = '';
    var wn = '';
	var jekel='';
    function edit_tersangka(id)
    {
        var id = id;
        localStorage.nama_tersangka       = $('#tr_id'+id+' td:eq(1) input:eq(0)').val();
        localStorage.tmpt_lahir_tersangka = $('#tr_id'+id+' td:eq(1) input:eq(2)').val();
        localStorage.tgl_lahir_tersangka  = $('#tr_id'+id+' td:eq(1) input:eq(3)').val();
        localStorage.umur_tersangka       = $('#tr_id'+id+' td:eq(1) input:eq(4)').val();
        localStorage.jk_tersangka         = $('#tr_id'+id+' td:eq(1) input:eq(5)').val();
        localStorage.alamat_tersangka     = $('#tr_id'+id+' td:eq(1) input:eq(6)').val();
        localStorage.id_tersangka         = $('#tr_id'+id+' td:eq(1) input:eq(7)').val();
        localStorage.no_id_tersangka      = $('#tr_id'+id+' td:eq(1) input:eq(8)').val();
        localStorage.no_hp_tersangka      = $('#tr_id'+id+' td:eq(1) input:eq(9)').val();
        localStorage.agama_tersangka      = $('#tr_id'+id+' td:eq(1) input:eq(10)').val();
        localStorage.id_wn_tersangka      = $('#tr_id'+id+' td:eq(1) input:eq(11)').val();
        localStorage.nm_wn_tersangka      = $('#tr_id'+id+' td:eq(1) input:eq(11)').attr('attr-id');
        localStorage.kerja_tersangka      = $('#tr_id'+id+' td:eq(1) input:eq(12)').val();
        localStorage.suku_tersangka       = $('#tr_id'+id+' td:eq(1) input:eq(13)').val();
        localStorage.pendidikan_tersangka = $('#tr_id'+id+' td:eq(1) input:eq(14)').val();
        localStorage.jenispenahanan_tersangka = $('#tr_id'+id+' td:eq(1) input:eq(15)').val();
        localStorage.tglpenahananawal_tersangka = $('#tr_id'+id+' td:eq(1) input:eq(16)').val();
        localStorage.tglpenahananakhir_tersangka = $('#tr_id'+id+' td:eq(1) input:eq(17)').val();
        localStorage.lokasipenahanan_tersangka = $('#tr_id'+id+' td:eq(1) input:eq(18)').val();
        localStorage.tr_tersangka         = id;
        localStorage.nourut_tersangka       = $('#tr_id'+id+' td:eq(1) input:eq(19)').val();
		var href = $(this).attr('href');
		if(href != null){
			var id_tersangka = href.substring(1, href.length);
		}else{
			var id_tersangka = '';
		}


		$('#m_tersangka').html('');
		$('#m_tersangka').load('/pidum/pdm-perpanjangan-tahanan/show-tersangka?id_tersangka='+id_tersangka);
		$('#m_tersangka').modal('show');
    }


    if(typeof(localStorage.nama_tersangka) != 'undefined')
    {

        $('#simpan-tersangka').text('Ubah');
        $('#mstersangkapt-nama').val(localStorage.nama_tersangka);
        $('#mstersangkapt-tmpt_lahir').val(localStorage.tmpt_lahir_tersangka);
        if(localStorage.tgl_lahir_tersangka !='')
        {
          $('#mstersangkapt-tgl_lahir-disp').val(localStorage.tgl_lahir_tersangka);

          $('#mstersangkapt-tgl_lahir').val(localStorage.tgl_lahir_tersangka);
        }

        $('#mstersangkapt-umur').val(localStorage.umur_tersangka);
        $('#mstersangkapt-warganegara').val(localStorage.nm_wn_tersangka);
        $('#mstersangkapt-warganegara').attr('data-id',localStorage.id_wn_tersangka);
        $('#mstersangkapt-id_identitas').val(localStorage.id_tersangka);
        $('#mstersangkapt-no_identitas').val(localStorage.no_id_tersangka);
        $('#mstersangkapt-id_agama').val(localStorage.agama_tersangka);
        $('#mstersangkapt-alamat').val(localStorage.alamat_tersangka);
        $('#mstersangkapt-no_hp').val(localStorage.no_hp_tersangka);
        $('#mstersangkapt-id_pendidikan').val(localStorage.pendidikan_tersangka);
        $('#mstersangkapt-pekerjaan').val(localStorage.kerja_tersangka);
        $('#mstersangkapt-suku').val(localStorage.suku_tersangka);
		$('#mstersangkapt-no_urut').val(localStorage.nourut_tersangka);


        $('#pdmperpanjangantahanan-id_msloktahanan').val(localStorage.jenispenahanan_tersangka);
        $('#pdmperpanjangantahanan-tgl_mulai-disp').val(localStorage.tglpenahananawal_tersangka);
         $('#pdmperpanjangantahanan-tgl_mulai').val(localStorage.tglpenahananawal_tersangka);
        $('#pdmperpanjangantahanan-tgl_selesai-disp').val(localStorage.tglpenahananakhir_tersangka);
        $('#pdmperpanjangantahanan-tgl_selesai').val(localStorage.tglpenahananakhir_tersangka);
        $('#pdmperpanjangantahanan-lokasi_penahanan').val(localStorage.lokasipenahanan_tersangka);


        $.each($('input[type="radio"]'),function(x,y)
        {
            if(localStorage.jk_tersangka==$(this).val())
            {
               $(this).prop('checked',true);
            }
        });

      $('#simpan-tersangka').on('click',function(){
        var num = localStorage.tr_tersangka;
        removeAfterEdit(num);
        });
        function removeAfterEdit(id)
        {
            if(id!='')
            {
             $('#tr_id'+id).remove();
             localStorage.clear();
            }
        }

    }

    $('#simpan-tersangka').click(function(){
        prosesSimpantersangka('0');
    });

    $('#ubah-tersangka').click(function(){
		prosesSimpantersangka('1');
    });

    $('input[type="radio"][name="MsTersangkaPt[id_jkl]"]').on('click',function(){
       $('input[type="hidden" ][name="MsTersangkaPt[id_jkl]"]').val($(this).val());
    });
	function prosesSimpantersangka(flag){


        if(typeof($('#mstersangkapt-warganegara').attr('data-id')) === 'undefined')
        {
           wn = '';
        }
        else
        {
          wn = $('#mstersangkapt-warganegara').attr('data-id');

        }
        if (($('input[type="radio"]:checked').val()) ==1)
		{
		jekel=$('input[type="radio"]:checked').val();
        $('input[name=\'MsTersangkaPt[id_jkl]\']').val('1');
		}
		else if(($('input[type="radio"]:checked').val()) ==2)
		{
		jekel=$('input[type="radio"]:checked').val();
        $('input[name=\'MsTersangkaPt[id_jkl]\']').val('2');
		}
        else
        {
            $('input[type="hidden" ][name="MsTersangkaPt[id_jkl]"]').val('');
        }

        var umur = 0;
        if($('#mstersangkapt-umur').val()!='')
        {
            umur = $('#mstersangkapt-umur').val();
        }
        var nama = $('#mstersangkapt-nama').val().trim();
        var countEmptyValue =0;
        //$('#tersangka-form').find('input').each(function(idx, elem){
			if($("#mstersangkapt-nama").val()!=''){
                countEmptyValue +=1;
			}

			if($("#mstersangkapt-tmpt_lahir").val()!=''){
                countEmptyValue +=1;
			}

			if($("#mstersangkapt-tgl_lahir-disp").val()!=''){
                countEmptyValue +=1;
			}

			if($("#mstersangkapt-umur").val()!=''){
                countEmptyValue +=1;
			}

			if($("#mstersangkapt-warganegara").val()!=''){
                countEmptyValue +=1;
			}

			if($.trim($("#mstersangkapt-id_identitas").val())!=''){
                countEmptyValue +=1;
			}

			if($("#mstersangkapt-suku").val()!=''){
                countEmptyValue +=1;
			}

			if($("#mstersangkapt-no_identitas").val()!=''){
                countEmptyValue +=1;
			}

			if($.trim($("#mstersangkapt-id_agama").val())!=''){
                countEmptyValue +=1;
			}

			if($("#tersangka-form input[type='radio']:checked").val()!='' && typeof($("#tersangka-form input[type='radio']:checked").val())!='undefined'){
                countEmptyValue +=1;
			}



			if($("#mstersangkapt-alamat").val()!=''){
                countEmptyValue +=1;
			}

			if($.trim($("#mstersangkapt-id_pendidikan").val())!=''){
                countEmptyValue +=1;
			}

			if($("#mstersangkapt-pekerjaan").val()!=''){
                countEmptyValue +=1;
			}

			if($("#pdmperpanjangantahanan-id_msloktahanan").val()!=''){
				countEmptyValue +=1;
			}

			if($("#pdmperpanjangantahanan-tgl_mulai-disp").val()!=''){
				countEmptyValue +=1;
			}

			if($("#pdmperpanjangantahanan-tgl_selesai-disp").val()!=''){
				countEmptyValue +=1;
			}

			if($("#pdmperpanjangantahanan-lokasi_penahanan").val()!=''){
				countEmptyValue +=1;
			}
       // });

         if(countEmptyValue >= 17)
        {
            isi_table = '<tr id="tr_id'+currentValue+'">'+
                '<td width="20px"><input type="checkbox" name="tersangka[]" class="hapusTersangka" value="'+currentValue+'"></td>' +
                '<td>' +
                    '<a href="javascript:void(0);" onclick="edit_tersangka('+currentValue+')">'+nama+'</a>'+
                    '<input type="hidden" name="MsTersangkaBaru[nama][]" value="'+nama+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_tersangka][]" value="$id_tersangka" class="form-control tersangka'+ currentValue +'">' +

                    '<input type="hidden" name="MsTersangkaBaru[tmpt_lahir][]" value="'+$('#mstersangkapt-tmpt_lahir').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[tgl_lahir][]" value="'+$('#mstersangkapt-tgl_lahir-disp').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[umur][]" value="'+parseInt(umur)+'" class="form-control tersangka'+ currentValue +'">' +
					'<input type="hidden" name="MsTersangkaBaru[id_jkl][]" value="'+jekel+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[alamat][]" value="'+$('#mstersangkapt-alamat').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_identitas][]" value="'+$('#mstersangkapt-id_identitas').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[no_identitas][]" value="'+$('#mstersangkapt-no_identitas').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[no_hp][]" value="'+$('#mstersangkapt-no_hp').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_agama][]" value="'+$('#mstersangkapt-id_agama').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[warganegara][]" attr-id="'+$('#mstersangkapt-warganegara').val()+'" value="'+wn+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[pekerjaan][]" value="'+$('#mstersangkapt-pekerjaan').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[suku][]" value="'+$('#mstersangkapt-suku').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_pendidikan][]" value="'+$('#mstersangkapt-id_pendidikan').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_jenispenahanan][]" value="'+$('#pdmperpanjangantahanan-id_msloktahanan').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_tglawal_penahanan][]" value="'+$('#pdmperpanjangantahanan-tgl_mulai-disp').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_tglakhir_penahanan][]" value="'+$('#pdmperpanjangantahanan-tgl_selesai-disp').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_lokasipenahanan][]" value="'+$('#pdmperpanjangantahanan-lokasi_penahanan').val()+'" class="form-control tersangka'+ currentValue +'">' +
        
                    '<input type="hidden" name="MsTersangkaBaru[id_tglawal_permintaan][]" value="'+$('#pdmperpanjangantahanan-tgl_mulai_permintaan-disp').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_tglakhir_permintaan][]" value="'+$('#pdmperpanjangantahanan-tgl_selesai_permintaan-disp').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[persetujuan][]" value="'+$('#pdmperpanjangantahanan-persetujuan').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    
                    '<input type="hidden" name="MsTersangkaBaru[no_urut][]" value="'+$('#mstersangkapt-no_urut').val()+'" class="form-control tersangka'+ currentValue +'">' +
                '</td>' +
				'<td>' +
					$('#mstersangkapt-tmpt_lahir').val()  +', '+ $('#mstersangkapt-tgl_lahir-disp').val() +
				'</td>' +
            '</tr>'
			if(flag=='0'){
             $('#tbody_tersangka').append(isi_table);
			}else{
				$('#tbody_tersangka').html(isi_table);
			}
        $('#m_tersangka').modal('hide');

        // currentValue ++;
        }
        else
        {
            //CMS_PIDUM001_ Nama di popup tersangka tidak boleh kosong.
            $('#mstersangkapt-nama').focus();
            $('#tersangka-form').submit();
            $('.field-mstersangka-id_tersangka').hide();

        }
	}
    $('#mstersangkapt-tgl_lahir-disp').on('change',function(){
    var tgl = $('#mstersangkapt-tgl_lahir-disp').val();
    if(tgl != ''){
        var str = tgl.split('-');
        var firstdate=new Date(str[2],str[1],str[0]);
        var tglKejadian ='$compare';

        var start = tglKejadian.split('-');
        var Endate=new Date(tglKejadian);
        var today = new Date(Endate);
        var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
        var age = parseInt(dayDiff);
        $('#mstersangkapt-umur').val(age);
        maxpendidikan();
    }
 });
    function maxpendidikan()
      {
        var compare     = $('#mstersangkapt-umur').val();
        var jsonMaxUsia = $maxpendidikan;
        $('#mstersangkapt-id_pendidikan option:eq(0)').prop('disabled','true');
        $.each(jsonMaxUsia,function(x,y){
            if(compare<y)
            {
              $('#mstersangkapt-id_pendidikan option:eq('+(x)+')').prop('disabled','true');
              $('#mstersangkapt-id_pendidikan option:eq('+(x)+')').css('color','red');
            }
            else
            {
              $('#mstersangkapt-id_pendidikan option:eq('+(x)+')').removeAttr('disabled');
              $('#mstersangkapt-id_pendidikan option:eq('+(x)+')').css('color','black');
            }

        });
      }





JS;
$this->registerJs($script);


?>
