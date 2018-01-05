    <?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\typeahead\TypeaheadAsset;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
use kartik\builder\Form;
use kartik\grid\GridView;
use yii\web\Session;
use app\modules\pidum\models\PdmPerpanjanganTahanan;
use yii\widgets\ActiveForm as ActiveForm2;
use kartik\widgets\FileInput;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapatT4 */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="content-wrapper-1">
<?php
$form = ActiveForm::begin(
                [
                    'id' => 'nota-pendapat-t4-form',
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

<div class="pdm-nota-pendapat-t4-form">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"  style="border-color: #f39c12;">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Surat Permintaan Perpanjangan</label>
                                <div class="col-md-8">
                                    <!--<input class="form-control" value="<? //$model->id_perpanjangan?>" readOnly="true">-->
                                    <?php
                                        $session    = new Session();
                                        $id         = $session->get("id_perkara");
                                        $connection = \Yii::$app->db;
                                        $query      = $connection->createCommand("select a.no_surat || ' | ' || a.no_surat_penahanan || ' | ' || b.nama as no_sur, a.* 
                                                    from pidum.pdm_perpanjangan_tahanan as a, pidum.ms_tersangka_pt as b
                                                    where a.id_perpanjangan = b.id_perpanjangan and id_perkara = '".$id."' ")->queryAll();
                                        echo $form->field($model, 'id_perpanjangan')->dropDownList(
                                        ArrayHelper::map($query, 'id_perpanjangan', 'no_sur'), ['prompt' => 'Pilih Perpanjangan', 'class' => 'cmb_no_surat']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label col-md-4">Tgl Nota</label>
                            <div class="col-md-4">
                                <?=$form->field($model, 'tgl_nota')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options' => ['placeholder' => 'Tgl Nota'],
                                        'pluginOptions' => [
                                            'autoclose' => true
                                        ]
                                    ]
                                ]);
                                ?>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label col-md-4">Tgl Penahanan Oleh Penyidik</label>
                            <div class="col-md-3">
                                <?=$form->field($model, 'tgl_awal_penahanan_oleh_penyidik')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options' => ['placeholder' => 'Tgl Awal'],
                                        'pluginOptions' => [
                                            'autoclose' => true
                                        ]
                                    ]
                                ]);
                                ?>
                            </div>
                            <label class="control-label col-md-1">s/d</label>
                            <div class="col-md-3">
                                <?=$form->field($model, 'tgl_akhir_penahanan_oleh_penyidik')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options' => ['placeholder' => 'Tgl Akhir'],
                                        'pluginOptions' => [
                                            'autoclose' => true
                                        ]
                                    ]
                                ]);
                                ?>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Persetujuan</label>
                                <div class="col-md-3">
                                    <?// $form->field($model, 'persetujuan')->radio(['label' => 'T-4 Surat Perpanjangan Tahanan', 'value' => 1, 'uncheck' => null])?>
                                    <?// $form->field($model, 'persetujuan')->radio(['label' => 'T-5 Penolakan Permintaan Perpanjangan Penahanan', 'value' => 2, 'uncheck' => null])?>
                                    <?= $form->field($model, 'persetujuan')->textInput(['placeholder' => 'Persetujuan']); ?>
                                </div>
                                <label class="control-label col-md-4">Hari</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label col-md-4">Tgl Permintaan Perpanjangan</label>
                            <div class="col-md-3">
                                <?=$form->field($model, 'tgl_awal_permintaan_perpanjangan')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options' => ['placeholder' => 'Tgl Awal'],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'startDate' => '-1m',
                                            'endDate' => '+4m'
                                        ]
                                    ]
                                ]);
                                ?>
                            </div>
                            <label class="control-label col-md-1">s/d</label>
                            <div class="col-md-3">
                                <?=$form->field($model, 'tgl_akhir_permintaan_perpanjangan')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options' => ['placeholder' => 'Tgl Akhir'],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'startDate' => '-1m',
                                            'endDate' => '+4m'
                                        ]
                                    ]
                                ]);
                                ?>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Lokasi</label>
                                <div class="col-md-4">
                                    <?// $form->field($model, 'persetujuan')->radio(['label' => 'T-4 Surat Perpanjangan Tahanan', 'value' => 1, 'uncheck' => null])?>
                                    <?// $form->field($model, 'persetujuan')->radio(['label' => 'T-5 Penolakan Permintaan Perpanjangan Penahanan', 'value' => 2, 'uncheck' => null])?>
                                    <?= $form->field($model, 'kota')->textInput(['placeholder' => 'Kota']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-primary"  style="border-color: #f39c12;">
                <div class="box-body">
                    <h3 class="box-title">
                        <a class="btn btn-danger delete hapus"></a>&nbsp;<a class="btn btn-primary addJPU2"  id="popUpJpu">Jaksa</a>
                    </h3>
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
                            <?php  $numRows= 1;?>
                            <?php foreach ($modelJp16 as $key => $value): ?>
                                <tr data-id="<?= $value['id_jaksa'] ?>">
                                    <td style="text-align:center;" id="tdJPU"><input type='checkbox' name='jaksa[]' class='hapusJaksa' id='hapusJaksa' value="<?= $value['id_jaksa'] ?>"></td>
                                    <td style="text-align:center;"><input type="text" name="no_urut[]" class="form-control hide" value="" style="width: 50px;"><?php echo $numRows++ ;?></td>
                                    <td class="hide"><input type="text" name="nip_baru[]" class="form-control hide" readonly="true" value="<?= $value['nip_jaksa_p16'] ?>"><input type="hidden" name="nip_jpu[]" class="form-control hide" readonly="true" value="<?= $value['nip_jaksa_p16'] ?>"></td>
                                    <td><input type="text" name="nama_jpu[]" class="form-control hide" readonly="true" value="<?= $value->nama_jaksa_p16 ?>"><?= $value->nama_jaksa_p16 ?><br><?= $value['nip_jaksa_p16'] ?></td>
                                    <td><input type="text" name="gol_jpu[]" class="form-control hide" readonly="true" value="<?= $value->pangkat_jaksa_p16 ?>"><?= $value->pangkat_jaksa_p16 ?><br><?= $value->jabatan_jaksa_p16 ?></td>
                                    <td class="hide"><input type="text" name="jabatan_jpu[]" class="form-control" readonly="true" value="<?= $value->jabatan_jaksa_p16 ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if (!$model->isNewRecord): ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-nota-pendapat-t4/cetak?id=' . $model->id_nota_pendapat]) ?>">Cetak</a>
        <?php endif ?>	
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

<?php
$script1 = <<< JS
        
        $('.cmb_no_surat').change(function(){
//                var id_perpanjangan = $('input[name="PdmNotaPendapatT4[id_perpanjangan]"]:checked').val();
                //console.log(wewe);
                var id_perpanjangan = $(this).val();
//        alert(id_perpanjangan);
                if(id_perpanjangan!==''){
                    $.ajax({
                        type: "POST",
                        url: '/pidum/pdm-nota-pendapat-t4/detail',
                        data: 'id_perpanjangan='+id_perpanjangan,
                        dataType: 'json',
                        success:function(data){
                            console.log(data);
//        alert(data);
                            $("#pdmnotapendapatt4-tgl_awal_permintaan_perpanjangan-disp").val(data.tgl_awal_permintaan_perpanjangan_disp);
                            $("#pdmnotapendapatt4-tgl_awal_permintaan_perpanjangan").val(data.tgl_awal_permintaan_perpanjangan);
                            $("#pdmnotapendapatt4-tgl_akhir_permintaan_perpanjangan-disp").val(data.tgl_akhir_permintaan_perpanjangan_disp);
                            $("#pdmnotapendapatt4-tgl_akhir_permintaan_perpanjangan").val(data.tgl_akhir_permintaan_perpanjangan);
                            $("#pdmnotapendapatt4-tgl_awal_penahanan_oleh_penyidik-disp").val(data.tgl_awal_penahanan_oleh_penyidik_disp);
                            $("#pdmnotapendapatt4-tgl_awal_penahanan_oleh_penyidik").val(data.tgl_awal_penahanan_oleh_penyidik);
                            $("#pdmnotapendapatt4-tgl_akhir_penahanan_oleh_penyidik-disp").val(data.tgl_akhir_penahanan_oleh_penyidik_disp);
                            $("#pdmnotapendapatt4-tgl_akhir_penahanan_oleh_penyidik").val(data.tgl_akhir_penahanan_oleh_penyidik);
                            $("#pdmnotapendapatt4-persetujuan").val(data.persetujuan);
                            $("#pdmnotapendapatt4-kota").val(data.kota);
                        }   
                    });
                }
            });
        
        
        
        
        
        
        $('#popUpJpu').click(function(){
        $('#m_jpu').html('');
        $('#m_jpu').load('/pidum/pdm-nota-pendapat-t4/jpu');
        $('#m_jpu').modal({backdrop: 'static'});
        $('#m_jpu').modal('show');
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
$this->registerJs($script1);
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Tambah JPU</h7>',
	'clientOptions' => ['backdrop' => 'static', 'keyboard' => false] 
]);
Modal::end();
?>