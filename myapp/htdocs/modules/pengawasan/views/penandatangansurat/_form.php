<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\db\Command;
// use yii\widgets\ActiveField;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penandatangan-surat-master-form">
	<?php
    $form = ActiveForm::begin([
                'id' => 'penandatangan-surat-master-form',
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
    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
      
       <!-- <div class="col-md-12 col-sm-6 col-xs-12"> -->
        <div class="col-md-12 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="col-md-2">Kode Persuratan</label>
                <div class="col-md-3">
                    <?php
                        $connection = \yii::$app->db;
                        $query = "select*from was.v_was_menu order by parent,id asc";
                        $menu = $connection->createCommand($query)->queryAll();
                            // echo $form->field($model, 'id_surat')->dropDownList(
                            //     ArrayHelper::map()
                            // );
                    ?>

                    <select class="form-control" id="penandatangansurat-id_surat" name="PenandatanganSurat[id_surat]">
                        <option value="">-- Pilih --</option>
                        <?php
                            foreach ($menu as $key) {
                                echo "<option value='".$key['id_surat']."' ".($model->id_surat==$key['id_surat']?'selected':'').">".$key['nama_menu']."</option>";
                            }
                        ?>
                    </select> 
                    <div class="help-block" style="margin-bottom:15px;"></div>
                </div>
            </div>
        </div>
        <?php
        //print_r($result_alias);
        ?>
        <div class="col-md-12 col-sm-6 col-xs-12">
            <div class="form-group">
                 <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-user fa-1x"></i>&nbsp;Penandatangan Sebenarnya</div>
                        <div class="clearfix" style="padding:10px">
                 <label class="col-md-1">NIP</label>
                <div class="col-md-3">
                    <?php
                            echo $form->field($model, 'nip', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#_mseharusnya']),
                                        'asButton' => true
                                    ],
                                    
                                ],

                            ]);
                            ?> 

                </div>
                <label class="col-md-1">Nama</label>
                <div class="col-md-3">

                    <input class="form-control " type="text" id="nama_ttd"  name="nama_ttd"readonly="readonly" value="<?php echo $model['nama_penandatangan'];?>">
                    <input class="form-control " type="hidden" id="seharusnya" readonly="readonly" value="<?php if(!$model->isNewRecord){ echo $_GET['idjab']; }?>" name="seharusnya">
                    <input class="form-control " type="hidden" id="unitkerja_kd" value="<?php if(!$model->isNewRecord){ echo $model['unitkerja_kd']; }?>" name="unitkerja_kd">
                    <input class="form-control " type="hidden" id="an" value="<?php if(!$model->isNewRecord){ echo $_GET['jbtn1']; }?>" name="jabatan2[]">
                    <input class="form-control " type="hidden" id="plt" value="<?php if(!$model->isNewRecord){ echo $_GET['jbtn2']; }?>" name="jabatan2[]">
                    <input class="form-control " type="hidden" id="plh" value="<?php if(!$model->isNewRecord){ echo $_GET['jbtn3']; }?>" name="jabatan2[]">
                </div>
                <label class="col-md-1">Jabatan</label>
                <div class="col-md-3">
                    <input class="form-control " type="text" id="jabatan_asli" readonly="readonly" value="<?php echo $model['jabatan_penandatangan'];?>" name="jabatan_asli">
                 </div> 
                    
                    </div>
                </div>
            </div>
        </div>
        <?php
         $connection = \Yii::$app->db;
        ?>
        <div class="col-md-12 col-sm-6 col-xs-12">
            <div class="form-group">
                 <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-user fa-1x"></i>&nbsp;Penandatangan Alias</div>
                        <div class="clearfix" style="padding:10px">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle= "modal" data-target ="#_mjpu5"><i class="fa fa-plus">  </i> Tambah</button>
                            <table class="table table-striped table-bordered" style="margin-top:20px;">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Nip</th>
                                        <th style="text-align:center;">Nama Penandatangan</th>
                                        <th style="text-align:center;">Jabtan</th>
                                        <th style="text-align:center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="pd_alias">
                                    <?php
                                        if(!$model->isNewRecord){
                                            $no=1;
                                            foreach ($result_alias as $key) {
                                                // $sql="select string_agg(id_jabatan,',') from (select id_jabatan from was.penandatangan_surat where nip='".$key['nip']."' and substring(id_jabatan,1,1)<>'0' and id_surat='".$model['id_surat']."' order by id_jabatan)a"; 
                                                //         $result_sql=$connection->createCommand($sql)->queryOne();
                                                        // $id_jabatan_str=split(',', $result_sql['string_agg']);
                                                echo "<tr class=".$key['nip']." rel=".$key['nip'].">
                                                        <td>".$no."
                                                        <input type='hidden' name='nip_alias[]' value='".$key['nip']."'></td>
                                                        <input type='hidden' name='jabatan_alias[]' value='".$key['jabatan_asli']."'>
                                                        <input type='hidden' name='unitkerja_kd_alias[]' value='".$key['unitkerja_kd']."'>
                                                        </td>
                                                        <td>".$key['nip']."</td>
                                                        <td>".$key['nama_penandatangan']."</td>
                                                        <td>".$key['jabatan_asli']."</td>
                                                         <td style='text-align:center;'><button type='button' class='btn btn-primary btn-xs btn_hapus' rel='".$key['nip']."'><i class='fa fa-trash'> Hapus </i></button></td>
                                                </tr>";
                                                $no++;
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
           
            <div class="col-md-10">
            </div>
    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
    </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

<!-- </div> -->
</div>
<script type="text/javascript">
 

$(document).ready(function(){
    $(".control-label").hide();
$('#penandatangansurat-nip').attr('readonly', true);
$('#penandatangansurat-nip').attr('placeholder', 'NIP');
$('#nama_ttd').attr('placeholder', 'Nama Penandatangan');
$('#penandatangansurat-id_jabatan').attr('readonly', true); 
$('#penandatangansurat-id_jabatan').attr('placeholder', 'Kode Jabatan');
$('#jabatan').attr('placeholder', 'Nama Jabatan');     
    
$('body').on('click','.pilih-ttd_seharusnya',function(){

    var data = JSON.parse($(this).attr('json'));
    // var pecah=$(this).attr('query').split(',');
    
    $('#penandatangansurat-nip').val(data.nip);
    $('#nama_ttd').val(data.nama_penandatangan);
    $('#unitkerja_kd').val(data.unitkerja_kd);
    $('#jabatan_asli').val(data.jabatan_penandatangan);
    // $('#seharusnya').val(pecah[0]);
    // $('#an').val(pecah[1]);
    // $('#plt').val(pecah[2]);
    // $('#plh').val(pecah[3]);

    $('#_mseharusnya').modal('hide');
});

$('body').on('click','.pilih-ttd',function(){

    var data = JSON.parse($(this).attr('json'));
    var cek=$('.pd_alias').find('.'+data.nip).attr('rel');
    var nip_seharusnya=$('#penandatangansurat-nip').val();

    // var $('#seharusnya').val(pecah[0]);
    var an=$('#an').val();
    var plt=$('#plt').val();
    var plh=$('#plh').val();
     // alert(nip_seharusnya+' - '+cek);
     if( nip_seharusnya==''){
        alert('Harap Pilih Penadatangan Sebenarnaya')
     }else{
     if(cek==data.nip || data.nip==nip_seharusnya){
        alert('data sudah ada, harap pilih data lain')
     }else{
        $('.pd_alias').append('<tr class="'+data.nip+'" rel="'+data.nip+'">'+
        '<td></td>'+
        '<td><input type="hidden" name="nip_alias[]" value="'+data.nip+'">'+data.nip+'</td>'+
        '<td><input type="hidden" name="nama_penandatangan_alias[]" value="'+data.nama_penandatangan+'">'+data.nama_penandatangan+'</td>'+
        '<td><input type="hidden" name="unitkerja_kd_alias[]" value="'+data.unitkerja_kd+'">'+
        '<input type="hidden" name="jabatan_alias[]" value="'+data.jabatan_penandatangan+'">'+data.jabatan_penandatangan+
        '</td>'+
        '<td style="text-align:center;"><button type="button" class="btn btn-primary btn-xs btn_hapus" rel="'+data.nip+'"><i class="fa fa-trash"> Hapus </i></button></td>'+
        '</tr>');
     }
 }
    
    // $('#penandatangansurat-nip').val(data.nip);
    // $('#nama_ttd').val(data.nama_penandatangan);
    // $('#penandatangansurat-unitkerja_kd').val(data.unitkerja_kd);
    $('#_mjpu5').modal('hide');
});

$('body').on('click','.pilih-jbtn',function(){

    var data1 = JSON.parse($(this).attr('json'));
    $('#penandatangansurat-id_jabatan').val(data1.id_jabatan);
    $('#jabatan').val(data1.nama);
    $('#_mjabatan').modal('hide');
});
});

window.onload = function () {
    $(document).on('click','.btn_hapus',function(){
    var x=$(this).attr('rel');
    $('.pd_alias').find('.'+x).remove();
    });
}
  

</script>
<?php
Modal::begin([
    'id' => '_mjpu5',
    'header' => 'Pilih Penandatangan Surat',
    'options' => [
        'data-url' => '',
        'style' =>'width:100%',
    ],
]);
?> 

<?=
$this->render('_mjpu5', [
    'model' => $model,
    'parameter'=>'seharusnya',
])
?>

<?php
Modal::end();
?>

<?php
Modal::begin([
    'id' => '_mseharusnya',
    'header' => 'Pilih Penandatangan Surat',
    'options' => [
        'data-url' => '',
        'style' =>'width:100%',
    ],
]);
?> 

<?=
$this->render('_mseharusnya', [
    'model' => $model,
    'parameter'=>'seharusnya',
])
?>

<?php
Modal::end();
?>


<?php
Modal::begin([
    'id' => '_mjabatan',
    'header' => 'Pilih Jabatan',
    'options' => [
        'data-url' => '',
        'style' =>'width:100%',
    ],
]);
?> 

<?=
$this->render('_mjabatan', [
    'model' => $model,
])
?>

<?php
Modal::end();
?>

