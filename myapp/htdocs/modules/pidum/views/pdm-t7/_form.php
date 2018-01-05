<?php

use app\components\GlobalConstMenuComponent;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\modules\pidum\models\MsLoktahanan;
use app\modules\pidum\models\PdmT7;
use yii\web\Session;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\pdmt7 */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="panel box box-warning">
    <div class="box-header">
    </div>
    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 't7-form',
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'enableAjaxValidation' => false,
                        'fieldConfig' => [
                            'autoPlaceholder' => false
                        ],
                        'formConfig' => [
                            'deviceSize' => ActiveForm::SIZE_SMALL,
                            'labelSpan' => 1,
                            'showLabels' => false
                        ]
    ]);
    ?>

    <?php
        if(!$model->isNewRecord){
            $ba4 = PdmT7::findOne(['no_register_perkara'=>$model->no_register_perkara, 'no_urut_tersangka'=>$model->no_urut_tersangka])->no_surat_t7;
            if($ba4==NULL){
                $hide = 'hide';
                $val  = $model->no_surat_t7; 
            }else{
                $hide = '';
                $val  = '';
                if(substr($model->no_surat_t7,(strlen($model->no_surat_t7)-1),1)!=='^'){
                    $val = $model->no_surat_t7;
                }
            }
        }else{
            $hide = 'hide';
            $val ='';
        }
    ?>


    <div class="box-body">
        
        
       
         <div class="col-md-6">
                <div class="form-group" >
                        <label for="tindakan_status" class="control-label col-sm-4">Nota Pendapat</label>
                        <div class="col-sm-7">
                            <?php $nota_pendapat = ArrayHelper::map($modelnotaPendapat, 'id_nota_pendapat', function($model) {
                                                    return $model['jenis_nota_pendapat'].' / '.$model['nama_tersangka_ba4'].' / '.Yii::$app->globalfunc->IndonesianFormat($model['tgl_nota']);
                                                }) ?>
                            <?= $form->field($model, 'id_nota_pendapat')->dropDownList($nota_pendapat, ['prompt' => '---Pilih---']) ?>
                        </div>
                    </div>    
        </div>
        <div class="col-md-6">
                 <div class="form-group">
                    <label class="control-label col-md-4">Nomor Surat T7</label>
                    <div class="col-md-7">
                        <?= $form->field($model, 'no_surat_t7')->textInput(['maxlength' => true, 'value'=>$val]) ?>
                    </div>
                </div>    
        </div>
        <div class="col-md-6">
                 <div class="form-group">
                    <label class="control-label col-md-4">No Reg Tahanan Kejaksaan</label>
                    <div class="col-md-7">
                        <?= $form->field($model, 'no_reg_tahanan_jaksa')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>    
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
             <div class="form-group">
                    <label class="control-label col-md-2">Ketentuan Yang dilanggar / Dasar Penahanan</label>
                    <div class="col-md-10"> 
                        <?= $form->field($model, 'undang')->textInput(['maxlength' => true]) ?>
                    </div>
                     <!-- <label class="control-label col-md-1">Tahun</label>
                    <div class="col-md-2"> 
                        <?= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>
                    </div> -->
                </div> 
        </div>
        <!-- <div class="col-md-6">
                 <div class="form-group">
                     <label class="control-label col-md-3">Tentang</label>
                        <div class="col-md-8"> 
                            <?= $form->field($model, 'tentang')->textInput(['maxlength' => true]) ?>
                        </div>
                </div>    
        </div> -->

           <div class="clearfix"></div>

        
       <!-- HIDDEN BOSSQ -->
        <div class="col-md-6 hide">
             <div class="form-group">
                     <label class="control-label col-md-4">Surat Perintah Penahanan Dari</label>
                        <div class="col-md-7"> 
                            <?= $form->field($model, 'penahanan_dari')->textInput(['maxlength' => true, 'value' => $model->isNewRecord ? Yii::$app->globalfunc->getInstansipelaksanapenyidik() : $model->penahanan_dari]) ?>
                        </div>
                </div> 
        </div>
        <div class="col-md-6 hide">
                 <div class="form-group">
                     <label class="control-label col-md-3">No Surat</label>
                        <div class="col-md-4"> 
                            <?= $form->field($model, 'no_surat_perintah')->textInput(['maxlength' => true]) ?>
                        </div>
                        <label class="control-label col-md-1">Tanggal</label>
                        <div class="col-md-3"> 
                            <?=
                            $form->field($model, 'tgl_srt_perintah')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    ]
                                ]
                            ]);
                            ?>
                           
                        </div>
                </div>    
        </div>
        <!-- END HIDDEN BOSSQ -->
           <div class="clearfix"></div>

        <div class="box box-warning"><!-- 
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="glyphicon glyphicon-user"></i> Terdakwa
                </h3>

                
            </div> -->
             <div class="box-body">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nama Terdakwa</label>
                                <div class="col-md-6">
                                 <?= $form->field($model, 'nama_tersangka_ba4')->textInput(['maxlength' => true,'readonly'=>true]) ?>         
                                </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="padding-left: 10px;">
                        <label for="tindakan_status" class="control-label col-sm-3">Tindakan</label>
                        <div class="col-sm-6">
                            <?php $tindakan_status = ArrayHelper::map($modelTindakanStatus, 'id', 'nama') ?>
                            <?= $form->field($model, 'tindakan_status')->dropDownList($tindakan_status, ['prompt' => '---Pilih---']) ?>
                        </div>
                    </div>
                    </div>
                    <div class="clearfix"></div>
                     <div class="col-md-6">
                        <div class="form-group">
                             <label class="control-label col-md-4">Lokasi Tahanan</label>
                                <div class="col-md-3"> 
                                     <?=
                                    $form->field($model, 'id_ms_loktahanan')->dropDownList(
                                            ArrayHelper::map(MsLoktahanan::find()->all(), 'id_loktahanan', 'nama'), ['prompt' => 'Pilih',
                                            ]
                                    )
                                    ?>
                                </div>
                                 <div class="col-md-4"> 
                                    <?= $form->field($model, 'lokasi_tahanan')->textInput(['maxlength' => true]) ?>
                                </div>
                        </div>
                        </div>

                   
                        <div class="col-md-6">
                            <label class="control-label col-md-3">Selama</label>
                                <div class="col-md-2"> 
                                    <?= $form->field($model, 'lama')->textInput(['maxlength' => true]) ?>
                                </div>
                            <label class="control-label col-md-2">Hari - Tanggal</label>
                                <div class="col-md-3"> 
                                    <?=
                                    $form->field($model, 'tgl_mulai')->widget(DateControl::className(), [
                                        'type' => DateControl::FORMAT_DATE,
                                        'ajaxConversion' => false,
                                        'options' => [
                                            'pluginOptions' => [
                                                'autoclose' => true
                                            ]
                                        ]
                                    ]);
                                    ?>
                                </div>
                        </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>

            </div>
            
        </div>


        <div class="box box-warning">
            <div class="box-body">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
                    <a class="btn btn-danger delete hapus"></a>&nbsp;<a class="btn btn-primary addJPU2"  id="popUpJpu">Jaksa</a>
                </h3>
            </div>
            <!-- jaka | rubah grid jaksa -->
                <table id="table_jpu" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="text-align:center;" width="45px"></th>
                            <th style="text-align:center;" width="45px">#</th>
                            <th>Nama<br>NIP</th>
                            <th>Pangkat / Golongan<br>Jabatan</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tbody_jpu">
                        <?php

                            $jpu = json_decode($model['json_jpu']);
                            if($jpu->no_urut!=null){
                            foreach($jpu->no_urut AS $key=>$val)
                            {
                               
                            ?>

                            <tr data-id="<?= $key?>">
                                    <td style="text-align:center;" id="tdJPU"><input type='checkbox' name='jaksa[]' class='hapusJaksa' id='hapusJaksa' value="<? $key ?>"></td>
                                    <td style="text-align:center;"><input type="text" name="no_urut[]" class="form-control hide" value="<?php echo $val ;?>" style="width: 50px;"><?php echo $val ;?></td>
                                    <td class="hide"><input type="text" name="nip_baru[]" class="form-control hide" readonly="true" value="<?= $jpu->nip_baru[$key] ?>">
                                    <input type="hidden" name="nip_jpu[]" class="form-control hide" readonly="true" value="<?= $value['nip'] ?>"></td>
                                    <td>
                                    <input type="text" name="nama_jpu[]" class="form-control hide" readonly="true" value="<?= $jpu->nama_jpu[$key] ?>"><?= $jpu->nama_jpu[$key] ?><br><?= $jpu->nip_baru[$key] ?></td>
                                    <td>
                                    <input type="text" name="gol_jpu[]" class="form-control hide" readonly="true" value="<?= $jpu->gol_jpu[$key]  ?>"><?= $jpu->gol_jpu[$key] ?><br><?= $jpu->gol_jpu[$jabatan_jpu]?>
                                    </td>
                                    <td class="hide">
                                    <input type="text" name="jabatan_jpu[]" class="form-control" readonly="true" value="<?= $jpu->gol_jpu[$jabatan_jpu]?>">
                                    </td>
                                    
                                </tr>

                        <?php 
                            }
                        }
                            
                        ?>

                      
                        
                    </tbody>
                </table>
             <!-- END -->
            </div>
        </div>

 <div class="box box-warning">
             <div class="box-body">
        <div class="form-group">
            <label class="control-label col-md-2">Dikeluarkan Di</label>
            <div class="col-md-3"> 
                <?= $form->field($model, 'dikeluarkan')->textInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst]) ?>
            </div>
            <label class="control-label col-md-1">Tanggal</label>
            <div class="col-md-2"> 
                <?=
                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]);
                ?>
            </div>
             <label class="control-label col-md-1">Upload File</label>

            <div class="col-md-3">
                 <?php 
            // echo '<label class="control-label col-md-4">Upload Document</label>';
                 $preview = "";
                 if($model->upload_file!="")
                 {
                    $preview =  [
                                "<a href='".$model->upload_file."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                 ];
                 }
                 

                    echo FileInput::widget([
                        'name' => 'attachment_3',
                        'id'   =>  'filePicker',
                        'pluginOptions' => [
                                'showPreview' => true,
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => false,
                                 'initialPreview' =>  $preview
                                
                            ],
                        
                    ]);
                    ?>
                <!-- <a href="<?= $model->upload_file?>">Lihat File</a>
                <input id="filePicker" type="file" /> -->
            </div>
        </div>
        </div>
        </div>
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T7, 'id_table' => $model->no_surat_t7]) ?>

        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord): ?>    
                <?= Html::a('Cetak', ['cetak', 'no_register_perkara'=>$model->no_register_perkara,'no_surat_t7' => $model->no_surat_t7], ['class' => 'btn btn-warning']) ?>
            <?php endif ?>
        </div>
    </div>
       <?= $form->field($model, 'tgl_ba4')->hiddenInput() ?>
         <?= $form->field($model, 'no_urut_tersangka')->hiddenInput() ?>
         <?= $form->field($model, 'no_surat_p16a')->hiddenInput() ?>
         <?= $form->field($model, 'upload_file')->hiddenInput() ?>
          <?= $form->field($model, 'no_jaksa_p16a')->hiddenInput()  ?>
          <?= $form->field($model, 'nama')->hiddenInput()  ?>
          <?= $form->field($model, 'pangkat')->hiddenInput()  ?>
          <?= $form->field($model, 'jabatan')->hiddenInput()  ?>
    <?php ActiveForm::end(); ?>

    <?php
    $script = <<< JS
        $('#popUpJpu').click(function(){
            
            $('#m_jpu').html('');
            $('#m_jpu').load('/pidum/pdm-t7/jpu');
            
            $('#m_jpu').modal({backdrop: 'static'});
            $('#m_jpu').modal('show');
        });


            var handleFileSelect = function(evt) {
            var files = evt.target.files;
            var file = files[0];

            if (files && file) {
                var reader = new FileReader();
                // console.log(file);
                reader.onload = function(readerEvt) {
                    var binaryString = readerEvt.target.result;
                    var mime = "data:"+file.type+";base64,";
                    console.log(mime);
                    document.getElementById("pdmt7-upload_file").value = mime+btoa(binaryString);
                    // window.open(mime+btoa(binaryString));
                };

                reader.readAsBinaryString(file);
            }
        };

        if (window.File && window.FileReader && window.FileList && window.Blob) {

            document.getElementById('filePicker').addEventListener('change', handleFileSelect, false);
        } else {
            alert('The File APIs are not fully supported in this browser.');
        }


            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<br /><input type="text" class="form-control" style="margin-left:60px"name="mytext[]">'
                )
            });

             $('#show_tersangka').click(function(){
            $('#m_tersangka').html('');
            $('#m_tersangka').load('/pidum/pdm-t7/refer-tersangka');
            $('#m_tersangka').modal('show');
                    
            });


$('#pdmt7-id_nota_pendapat').change(function(){
    var value = $('#pdmt7-id_nota_pendapat option:selected' ).val();
    if(value==''){
        return false;
    }
    $.ajax({
                type: "POST",
                url: '/pidum/pdm-t7/get-nota-pendapat?id='+value,
                success : function(data){
                    var result = JSON.parse(data);
                    console.log(result);
                    var tgl = result[0].tgl_sp_penyidik;
                    var d = new Date(tgl);
                    var finaldate = '';
                    if(tgl!=null)
                    {
                        var curr_date = d.getDate();
                        var curr_month = d.getMonth();
                        var curr_year = d.getFullYear();
                        finaldate = curr_date + "-" + curr_month + "-" + curr_year;
                    }
                    

                    
                    $('#pdmt7-tgl_ba4').val(result[0].tgl_ba4);
                    $('#pdmt7-no_urut_tersangka').val(result[0].no_urut_tersangka);
                    $('#pdmt7-nama_tersangka_ba4').val(result[0].nama);
                    $('#pdmt7-no_surat_perintah').val(result[0].no_sp_penyidik);
                    $('#pdmt7-tgl_srt_perintah-disp').val(finaldate);
                    $('#pdmt7-tgl_srt_perintah').val(result[0].tgl_sp_penyidik);

                    $('#m_tersangka').modal('hide');
                    if(result[0].ada==0){
                      $('#pdmt7-tindakan_status').val('1');
                      $('#pdmt7-tindakan_status').attr('disabled',true);
                    }else{
                      $('#pdmt7-tindakan_status').attr('disabled',false);
                    }

                    //Jaksa

                    // $("#pdmt7-no_surat_p16a").val(dari_nip_jaksa_p16a);
                    // $("#pdmt7-nama_jaksa").val(dari_nama_jaksa_p16a);
                    // $("#pdmt7-no_jaksa_p16a").val(no_urut);

                }
            })

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

JS;

if($model->isNewRecord){
    $script .= " $('#pdmt7-tindakan_status').attr('disabled',true); ";
}
    $this->registerJs($script);
    ?>

</div>


<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data JPU',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?php 
/*$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataProviderJPU' => $dataProviderJPU,
])*/
?>

<?php
Modal::end();
?>

<?php
Modal::begin([
    'id' => 'm_tersangka',
    'header' => '<h7>Data Tersangka</h7>'
]);
?> 

<?php
Modal::end();
?> 
<?php 