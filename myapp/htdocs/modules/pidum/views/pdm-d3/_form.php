<?php

use yii\helpers\Html;
use app\components\GlobalConstMenuComponent;
use app\components\ConstDataComponent;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

use yii\widgets\MaskedInput;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmD3 */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    input.currency {
        text-align: right;
        padding-right: 15px;
    }
    .input-group .form-control {
        float: none;
    }
    .input-group .input-buttons {
        position: relative;
        z-index: 3;
    }
</style>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
	<?php
        $form = ActiveForm::begin([
                    'id' => 'pdm-d3-form',
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
            <div class="box-header with-border">
		    <h3 class="box-title">PIHAK YANG MEMBAYAR</h3>
            </div>
			<br>      
          <div class="form-group" style="margin:left=5px">
            <label class="control-label col-md-2">Nama</label>
            <div class="col-md-4">
                 <?= $form->field($tersangka, 'nama')->textInput(['disabled'=>true])?>
        </div>
        </div>
                        
         <div class="form-group">
            <label class="control-label col-md-2">Alamat</label>
            <div class="col-md-4">
                 <?= $form->field($tersangka, 'alamat')->textarea(['disabled'=>true]) ?>
        </div>
        </div>                 
                        
</div>
        
                     
    <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="box-header with-border">
            <h3 class="box-title">Detail Anggaran</h3>
        </div>  
       <br> 

       <div class="form-group" style="margin:left=5px">
            <label class="control-label col-md-2">Yang Diangsur</label>
           <div class="col-md-1">
           <?= MaskedInput::widget([
                            'name' => 'PdmD3[kali_angsur]',
                            'value' => $model->kali_angsur,
                            'clientOptions' => [
                                'alias' =>  'decimal',
                                'groupSeparator' => ',',
                                'autoGroup' => true],
                                ]); 
          ?>
           </div>
           <label class="control-label col-md-1">Kali</label>
       </div>

        <div class="form-group" style="margin:left=5px">
             <label class="control-label col-md-2">Tgl Terakhir Angsuran</label>
            <div class="col-md-3">
            <?= $form->field($model, 'tgl_limit_angsuran')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'disabled' => $disabled,
                            'ajaxConversion' => false, 
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'endDate' => '+1y',
                                ],
                        ]
           ]);
           ?>
            </div>
            
        </div>
                        
    </div>      
        
 <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
           <div class="box-header with-border">
		    <h3 class="box-title">KEPERLUAN</h3>
           </div>  
       <br>   
  
        <div class="form-group" style="margin:left=5px">
            <label class="control-label col-md-2">Rincian Biaya Perkara</label>
            <div class="col-md-2">
                  <?= MaskedInput::widget([
                         'name' => 'PdmPutusanPnTerdakwa[biaya_perkara]',
                         'value' => $putusan->biaya_perkara,
                         'options' => [
                             'disabled' => true,
                             'class' => 'form-control' ],
                         'clientOptions' => [
                                 'alias' =>  'decimal',
                                 'groupSeparator' => '.',
                                 'autoGroup' => true,

                             ],
                 ]);?>
        </div>
        </div>       
         
        <div class="form-group" style="margin:left=5px">
            <label class="control-label col-md-2">Denda(Jumlah)</label>
            <div class="col-md-2">
                  <?= MaskedInput::widget([
                         'name' => 'PdmPutusanPnTerdakwa[denda]',
                         'value' => $putusan->denda,
                         'options' => [
                             'disabled' => true,
                             'class' => 'form-control' ],
                         'clientOptions' => [
                                 'alias' =>  'decimal',
                                 'groupSeparator' => '.',
                                 'autoGroup' => true,

                             ],
                 ]);?>
        </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-10">       
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
                    <a class="btn btn-primary" id="tambahAngsuran">
                        <i class="glyphicon glyphicon-plus"></i> Angsuran
                    </a>
                </h3>
            </div>

            <!-- <div class="col-md-10 hide">
                <div class="form-group">
                    <label class="control-label col-md-2">No.Reg.Bukti</label>
                    <div class="col-md-4">
                        <?php //$form->field($model, 'no_reg_bukti')->textInput(['maxlength' => true]) 
                        ?>
                    </div>
                </div>
            </div> -->

            <table id="table_angsuran" class="table table-bordered">
                <thead>
                <tr>
                    <th width="3%"
                        style="text-align: center;"><?= Html::buttonInput('Hapus', ['class' => 'btn btn-warning', 'id' => 'tmblhapusAngsuran']) ?></th>
                    <th width="5%" style="text-align: center;vertical-align: middle;">Ke</th>
                    <th width="15%" style="text-align: center;vertical-align: middle;">Jumlah Angsuran</th>
                    <th width="15%" style="text-align: center;vertical-align: middle;">Tanggal</th>
                    <th width="15%" style="text-align: center;vertical-align: middle;">No Kwitansi</th>
                    <th width="30%" style="text-align: center;vertical-align: middle;">Yang Menerima</th>
                    <th width="5%" style="text-align: center;vertical-align: middle;">Aksi</th>
                </tr>
                </thead>
                <tbody id="tbody_angsuran">

                <?php
                if (!$model->isNewRecord) {
                    $det_angsuran = json_decode($model->det_angsuran);
                    if(count($det_angsuran)>0){
                    //echo '<pre>';print_r($det_angsuran->ke[$i]);exit;
                    //echo '<pre>';print_r($model->det_angsuran);exit;
                        for ($i=0; $i < count($det_angsuran->ke); $i++) { 
                ?>
                    <tr id="row-<?=$det_angsuran->ke[$i]?>">
                        <td style="text-align: center">
                            <input type="checkbox" name="chkHapusangsuran" class="chkHapusangsuran">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="PdmD3[angsuran][ke][]" readonly="true" value="<?=$det_angsuran->ke[$i]?>">
                        </td>
                        <td>
                            <input type="text" class="form-control" min="0" name="PdmD3[angsuran][nilai][]"  value="<?=$det_angsuran->nilai[$i]?>">
                        </td>
                        <td>
                            <input type="text" name="PdmD3[angsuran][tgl_angsuran][]" class="form-control test" value="<?=$det_angsuran->tgl_angsuran[$i]?>" />
                        </td>
                        <td>
                            <input type="text" class="form-control" name="PdmD3[angsuran][no_kwitansi][]" value="<?=$det_angsuran->no_kwitansi[$i]?>">
                        </td>
                        <td>
                            <input type="text" class="form-control col-md-8" style="width:65%;float:left;margin-right:10px" name="PdmD3[angsuran][nama_ttd][]" id="txt-nama-<?=$det_angsuran->ke[$i]?>" value="<?=$det_angsuran->nama_ttd[$i]?>">
                            <a class="btn btn-primary cari_penerima" id="<?=$det_angsuran->ke[$i]?>">Penerima</a>
                            <input type="hidden" class="form-control" name="PdmD3[angsuran][nip_ttd][]" id="txt-nip-<?=$det_angsuran->ke[$i]?>" value="<?=$det_angsuran->nip_ttd[$i]?>">
                            <input type="hidden" class="form-control" name="PdmD3[angsuran][pangkat_ttd][]" id="txt-pangkat-<?=$det_angsuran->ke[$i]?>" value="<?=$det_angsuran->pangkat_ttd[$i]?>">
                            <input type="hidden" class="form-control" name="PdmD3[angsuran][jabatan_ttd][]" id="txt-jabatan-<?=$det_angsuran->ke[$i]?>" value="<?=$det_angsuran->jabatan_ttd[$i]?>">
                        </td>
                        <td>
                            <a class="btn btn-primary" id="cetak_angsuran" data-no_urut="<?= $det_angsuran->ke[$i]?>"
                                <i class="glyphicon glyphicon-plus"></i> Cetak D3
                            </a>
                        </td>
                    </tr>
                <?php
                    

                


                        }
                    }
                }

                ?>

                </tbody>
            </table>
    </div>        
    </div>
 </div>
        
    <div class="form-group" style="margin-left:0px">
		<label class="control-label col-md-2">Dikeluarkan & Tanggal</label>
	    <div class="col-md-4">
	        <?php echo $form->field($model, 'dikeluarkan')->input('text', ['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst])?>
	    </div>
	            <div class="col-md-3">
	              	<?= $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(),[
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>false,
                    'options' => [
                        'options' => ['placeholder' => 'Tanggal Dikeluarkan'],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]); ?>
	            </div>
	        </div>
			    
        
        
      <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        </div>

    <?php ActiveForm::end(); ?>


</div>
</section>

<?php
Modal::begin([
    'id' => '_ttd',
    'header' => 'Data SPDP',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<div class="modalContent">

<?=
    GridView::widget([
        'id' => 'gridttd',
        'dataProvider' => $dataJPU,
        'filterModel' => $searchJPU,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'NIP',
                'attribute' => 'peg_nip_baru',
            ],
            ['label' => 'Nama',
                'attribute' => 'peg_nama',
            ],
            ['label' => 'Pangkat',
                'attribute' => 'pangkat',
            ],
            ['label' => 'Jabatan',
                'attribute' => 'jabatan',
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => "buttonPilihJPU", "class" => "btn btn-warning",
                                    "nik" => $model['peg_nip_baru'],
                                    "peg_nip_baru" => $model['peg_nip_baru'],
                                    "nama" => $model['peg_nama'],
                                    "jabatan" => $model['jabatan'],
                                    "pangkat" => $model['pangkat'],
                                    "onClick" => "pilihJPU($(this).attr('nik'),$(this).attr('peg_nip_baru'),$(this).attr('nama'),$(this).attr('jabatan'),$(this).attr('pangkat'))"]);
                    }
                        ],
                    ]
                ],
                'export' => false,
                'pjax' => true,
                'responsive' => true,
                'hover' => true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
                ],
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ]
            ]);
            ?>
    
</div>

<?php
Modal::end();
?>  



<?php

/*
$wew = '<div class="form-group field-pdmd3-tgl_dikeluarkan">
<div class="col-sm-12"><input type="text" id="pdmd3-tgl_dikeluarkan-disp" class="form-control" name="tgl_dikeluarkan-pdmd3-tgl_dikeluarkan" value="" placeholder="Tanggal Dikeluarkan" data-krajee-datecontrol="datecontrol_d4ae7a60" data-datepicker-source="pdmd3-tgl_dikeluarkan-disp" data-datepicker-type="1" data-krajee-kvdatepicker="kvDatepicker_dfcd57c4"><input type="hidden" id="pdmd3-tgl_dikeluarkan" name="PdmD3[tgl_dikeluarkan]"></div>
<div class="col-sm-12"></div>
<div class="col-sm-12"><div class="help-block"></div></div>
</div>';
*/

$lel = DateControl::widget(
    ['name'=>'PdmD3[angsuran][tanggal][]', 
    'value'=>'', 
    'type'=>DateControl::FORMAT_DATE, 
    'options' => ['pluginOptions' => ['autoclose' => true]]]);
$lel = '<input type="text" name="PdmD3[angsuran][tgl_angsuran][]" class="form-control test" />';

$angsur =  MaskedInput::widget([
                            'name' => 'input-33',
                            'clientOptions' => [
                                'alias' =>  'decimal',
                                'groupSeparator' => ',',
                                'autoGroup' => true],
                                ]); 
//$angsur = '<input type="text" id="w2" class="form-control" name="input-33" data-plugin-inputmask="inputmask_698630a0" style="text-align: right;">';
//echo $lel;=
$script = <<< JS


$(document).ready(function(){
        $("#tambahAngsuran").on("click", function() {
            var len = $('#tbody_angsuran tr').length;
            len++;
            console.log(len);
            var m = '<tr id="row-'+len+'">'+
                            '<td style="text-align: center">'+
                                '<input type="checkbox" name="chkHapusangsuran" class="chkHapusangsuran">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" name="PdmD3[angsuran][ke][]" readonly="true" value="'+len+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="number" style="text-align:right" min="0" class="form-control" name="PdmD3[angsuran][nilai][]">'+
                            '</td>'+
                            '<td>$lel</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" name="PdmD3[angsuran][no_kwitansi][]" >'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control col-md-8" style="width:65%;float:left;margin-right:10px" name="PdmD3[angsuran][nama_ttd][]" id="txt-nama-'+len+'" >'+
                            '<a class="btn btn-primary cari_penerima" id="'+len+'">Penerima</a>'+
                            '<input type="hidden" class="form-control" name="PdmD3[angsuran][nip_ttd][]" id="txt-nip-'+len+'">'+
                            '<input type="hidden" class="form-control" name="PdmD3[angsuran][pangkat_ttd][]" id="txt-pangkat-'+len+'" >'+
                            '<input type="hidden" class="form-control" name="PdmD3[angsuran][jabatan_ttd][]" id="txt-jabatan-'+len+'" >'+
                            '</td>'+
                        '</tr>';
            $('#tbody_angsuran').append(m);
                var date =  new Date();

                var endate =  new Date(date);
                var finaldate =    endate.setDate(date.getDate()+7);

                var startdate =  new Date(date);
                var resultdate =    startdate.setDate(startdate.getDate()-7);
               
                    var startdateFormated =  startdate.toISOString().substr(0,10);
                    var startresultDate   =  startdateFormated.split('-');
                    var finalstartDate    =  startresultDate[2]+'-'+startresultDate[1]+'-'+startresultDate[0];
                
                    var enddateFormated     = endate.toISOString().substr(0,10);
                    var endresultDate       = enddateFormated.split('-');
                    finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
    



                    var kvDatepicker_001 = {'autoclose':true,'startDate':finalstartDate,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
            var datecontrol_001 = {'idSave':'pdmspdp-tgl_terima','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('.test').kvDatepicker(kvDatepicker_001);
          $('.test').datecontrol(datecontrol_001);
        });


            $('a#cetak_angsuran').click(function(){
                var kd = $(this).attr('data-no_urut');
                console.log(kd);
                    var url    = '/pidum/pdm-d3/cetak?no_urut='+kd;  
                    window.open(url, '_blank');
                    window.focus();
            });


});

$('body').on('click', '.cari_penerima', function(){
    kode = $(this).attr('id');
    localStorage.setItem('kode', kode);
    $('#_ttd').modal('show');
});


        

JS;


$this->registerJs($script);
?>
<script>
    function pilihJPU(nik, peg_nip_baru, nama, jabatan, pangkat) {
        var target = localStorage.getItem('kode');
        console.log(target);
        $("#txt-nip-"+target).val(peg_nip_baru);
        $("#txt-nama-"+target).val(nama);
        $("#txt-jabatan-"+target).val(jabatan);
        $("#txt-pangkat-"+target).val(pangkat);
        $('#_ttd').modal('hide');
    }
</script>