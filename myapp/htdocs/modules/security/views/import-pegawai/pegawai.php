<?php
use app\components\GlobalConstMenuComponent;
use kartik\form\ActiveForm;
use app\modules\security\models\ConfigSatker;
use app\modules\security\models\ConfigSatkerSearch;

$this->title = 'Import data pegawai';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" type="text/css" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/js/datatable/media/css/jquery.dataTables.css'?>">
<script type="text/javascript"  src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/js/datatable/media/js/jquery.dataTables.js'; ?>"></script>
 
 

<?php //$form = ActiveForm::begin(); ?>

    <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading single-project-nav">
                <ul class="nav nav-tabs"> 
                    <li class="active"><a href="#tab-1" data-toggle="tab">Import Pegawai Berdasarkan Instansi</a></li>
                    <li><a href="#tab-2" data-toggle="tab">Import Pegawai Berdasarkan NIP</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab-1">
                        <button class="btn btn-primary import">Import Pegawai</button>
                                <br>
                                <br>
                                <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="20%">NIP</th>
                                        <th width="20%">NAMA</th>
                                        <th width="30%">JABATAN</th>
                                        <th width="30%">GOLONGAN</th>
                                        <th class='all' style="display: none" width="5%"><button class="more" >Sync Semua</button></th>
                                        <!-- <th>Office</th>
                                        <th>Extn.</th>
                                        <th>Start date</th>
                                        <th>Salary</th> -->
                                    </tr>
                                </thead>
                               <!--  <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Extn.</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </tfoot> -->
                                <!-- --c88a31893b8b2a1f69c303e5263767f52bd9cd11783dc28ea3e3d903eddfd166 -->
                            </table>
                    </div>
                    <div class="tab-pane fade" id="tab-2">
                         <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="nip" id="nip" class="form-control">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button>
                                    </div>
                                </div>
                            </div>
                                <br>
                                <br>
                                <table id="example1" class="display dt-head-left" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="20%" >NIP</th>
                                        <th width="20%">NAMA</th>
                                        <th width="30%">JABATAN</th>
                                        <th width="10%">GOLONGAN</th>
                                        <th width="15%" >INSTANSI</th>
                                        <th class='all' width="5%">AKSI</th>
                                        <!-- <th>Office</th>
                                        <th>Extn.</th>
                                        <th>Start date</th>
                                        <th>Salary</th> -->
                                    </tr>
                                </thead>
                               <!--  <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Extn.</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </tfoot> -->
                                <!-- --c88a31893b8b2a1f69c303e5263767f52bd9cd11783dc28ea3e3d903eddfd166 -->
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
<?php //ActiveForm::end(); ?>
<?php
// print_r($_SESSION);
$ConfigSatker = new ConfigSatkerSearch(); 
$sql = "select a.* from pidum.pdm_config a limit 1";
        $model  = ConfigSatkerSearch::findBySql($sql)->asArray()->one();
$id = 'id='.$model['kd_satker'];    
$ip = GlobalConstMenuComponent::ipwebservice;
$gif = 'http://'.$_SERVER['HTTP_HOST'].'/image/loading.gif';
$js = <<< JS
                    var selector = !0;
                    function returnData(selected) {
                            return $.ajax({
                                url: "$ip/migrasi_cms/index.php?$id",
                                data: {
                                    issession: 1,
                                    selector: selector
                                },
                                // dataType: "json",
                                async: false,
                                error: function () {
                                    alert("Error occured")
                                }
                            });

                        }

                       
   var table =  $('#example').DataTable( {
        "processing": true,
        "language": {
            processing:  "<img src='$gif'>"},
        "ajax": "$ip/migrasi_cms/index.php?id=''",
        "columns": [
            // { "data": "IS_VERIFIED" },
            { "data": "PEG_NIP_BARU" },
            { "data": "NAMA" },
            { "data": "JABATAN" },
            { "data": "GOL_KD" },
            { "data": function( row, data, index,display){
                                return '<button class="child" data-id=\''+JSON.stringify(row)+'\'>Sync</button>';
                                // console.log(row);
                        }},
            // { "data": "TANGGAL_LP2P" },
            // { "data": "CPNS_TMT" },
            // { "data": "PNS_TMT" }
        ]
    } );

    var table1 =  $('#example1').DataTable( {
        "processing": true,
        "ordering": false,
        "info"   :     false,
        "bLengthChange": false,
        "scrollX": true,
        "bFilter": false, 
        "bInfo"  : false,
        "paging" : false,
        "language": {
            processing:  "<img src='$gif'>"},
        "ajax": "$ip/migrasi_cms/index.php?nip=''",
        "columns": [
            // { "data": "IS_VERIFIED" },
            { "data": "PEG_NIP_BARU" },
            { "data": "NAMA" },
            { "data": "JABATAN" },
            { "data": "GOL_KD" },
            { "data": "INSTANSI" },
            { "data": function( row, data, index,display){
                                return '<button class="child" data-id=\''+JSON.stringify(row)+'\'>Sync</button>';
                                // console.log(row);
                        }},
            // { "data": "TANGGAL_LP2P" },
            // { "data": "CPNS_TMT" },
            // { "data": "PNS_TMT" }
        ]
    } );

    $('.import').click(function(e){
    	var t = table.ajax.url("$ip/migrasi_cms/index.php?$id").load();        
        var ajaxObj = returnData(selector);
        var data = JSON.parse(ajaxObj.responseText);
       if(data.data.length>0){
        $('.all').show();
        $('.more').attr('data-id',JSON.stringify(data));
       }
    });

$('#btnSearch').click(function(e){
    var nip = $('#nip').val();
    var nip = 'nip='+nip;
    // console.log(nip);return false;
        var t = table1.ajax.url("$ip/migrasi_cms/index.php?"+nip).load();        
       //  var ajaxObj = returnData(selector);
       //  var data = JSON.parse(ajaxObj.responseText);
       // if(data.data.length>0){
       //  $('.all').show();
       //  $('.more').attr('data-id',JSON.stringify(data));
       // }
    });


$('body').on('click','.child',function(){
    var val = $(this).attr('data-id');
    // var array[];
    var data1 = {data:val};
    var button =  $(this);
    button.off();
    button.css('background','red');
    $.ajax({
            type: "POST",
            url: "/autentikasi/import-pegawai/orang/",
            //headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
            data: data1,
            success: function (result) {
             button.attr('disabled',true);
             button.css('background','green');
             button.css('color','white');
             button.text('Succes Sync');
            },
            error: function (result) {

            }
        });
});

$('.more').on('click',function(){
    var val = $(this).attr('data-id');
    var data1 = {data:val};
    var button =  $(this);
    button.off();
    button.css('background','red');
    $.ajax({
            type: "POST",
            url: "/autentikasi/import-pegawai/instansi/",
            //headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
            data: data1,
            success: function (result) {
                console.log(result);
             button.attr('disabled',true);
             button.css('background','green');
             button.css('color','white');
             button.text('All Succes Sync');
             },
            error: function (result) {

            }
        });
})
JS;
$this->registerJs($js);