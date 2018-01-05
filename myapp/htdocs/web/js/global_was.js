/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $(document).ready(function(){
$(".tombolbatal").click(function(){
    $(this).val();
    location='http://'+location.host+'/pengawasan/dugaan-pelanggaran/update?id='+$(this).val();
    //  location.reload(); 
});
 $(document).on('click', 'button.removebutton', function () { 
     //    e.preventDefault();
  var data = $(this).closest('tr');
   
    bootbox.dialog({
        message: "Apakah anda ingin menghapus data ini?",
        buttons:{
            ya : {
                label: "Ya",
                className: "btn-warning",
                callback: function(){
                    data.remove();
    
                }
            },
            tidak : {
                label: "Tidak",
                className: "btn-warning",
                callback: function(result){
                    // $(".btnHapusCheckboxIndex").off("click");
                }
            }
        }
    });
    
 });
 return false;
 });
 
 
$(document).on('click','button.removecheckbutton',function(){

      $("input:checkbox[class=removecheck]").each(function () {
        if($(this).is(':checked')) {
         $(this).closest('tr').remove();
     }
     }); 
 });
 
 
 //$("#btnHapusCheckboxIndex").click(function(e){
$(document).on('click', '.btnHapusCheckboxIndex2', function(e) {
    e.preventDefault();
   var form = $(this).attr('namaform');
   
    bootbox.dialog({
        message: "Apakah anda ingin menghapus data ini?",
        buttons:{
            ya : {
                label: "Ya",
                className: "btn-warning",
                callback: function(){
                    $('#'+form).submit();
                    $(".btnHapusCheckboxIndex2").off("click");
                }
            },
            tidak : {
                label: "Tidak",
                className: "btn-warning",
                callback: function(result){
                    // $(".btnHapusCheckboxIndex").off("click");
                }
            }
        }
    });
});
    function removeRow(id)
    {
         bootbox.dialog({
        message: "Apakah anda ingin menghapus data ini?",
        buttons:{
            ya : {
                label: "Ya",
                className: "btn-warning",
                callback: function(){
                   $("#"+id).remove();
                }
            },
            tidak : {
                label: "Tidak",
                className: "btn-warning",
                callback: function(result){
                    // $(".btnHapusCheckboxIndex").off("click");
                }
            }
        }
    });
      
        

    }
        
        function removeRowUpdate(id)
    {
        var id_2= id.split("-");
        var nilai = $("#delete_tembusan").val()+"#"+id_2[1];
        bootbox.dialog({
        message: "Apakah anda ingin menghapus data ini?",
        buttons:{
            ya : {
                label: "Ya",
                className: "btn-warning",
                callback: function(){
                     $("#delete_tembusan").val(nilai);
      $("#"+id).remove();
                }
            },
            tidak : {
                label: "Tidak",
                className: "btn-warning",
                callback: function(result){
                    // $(".btnHapusCheckboxIndex").off("click");
                }
            }
        }
    });
   
        

    }
//hapus noncheckbox form
$(document).on('click', '.hapuswasform', function(e) {
    e.preventDefault();
   var form = $(this).attr('namaform');
   var actionform = $(this).attr('url');
   $("#"+form).attr("action",actionform);
    bootbox.dialog({
        message: "Apakah anda ingin menghapus data ini?",
        buttons:{
            ya : {
                label: "Ya",
                className: "btn-warning",
                callback: function(){
                    $('#'+form).submit();
                    $(".hapuswasform").off("click");
                }
            },
            tidak : {
                label: "Tidak",
                className: "btn-warning",
                callback: function(result){
                    // $(".btnHapusCheckboxIndex").off("click");
                }
            }
        }
    });
});
 
 
/*
 * untuk hapus checkbox pada grid index
 * gunakan id btnHapusCheckboxIndex pada tombol hapus
 * gunaka class checkHapusIndex pada checkbox tiap grid
 * append data yang mau dihapus ke id temp-hapus
 */
$(document).ready(function(){
    $('#btnHapusCheckboxIndex').attr('disabled',true);
});

$(document).on('click', '.checkHapusIndex', function(e) {

    var input = $( this );
    var total_checked = $(".checkHapusIndex:checkbox:checked").length;

    if(total_checked < 1){
        $("#btnHapusCheckboxIndex").attr("disabled", true);
    }

    if(input.prop( "checked" ) == true){
        $("#btnHapusCheckboxIndex").attr("disabled",false);

        $('#temp-hapus').append(
            "<input type='hidden' id='hapus-"+e.target.value+"' name='hapusIndex[]' value='"+e.target.value+"'>"
        );
    }else{
        $('#hapus').remove();
        $('#hapus-'+e.target.value).remove();
    }

});

//$("input[name='selection_all']").on('change', function(){
$(document).on('change', "input[name='selection_all']", function() {
    var selectAll = $(this);
    if(selectAll.prop("checked") == true){
        $("#btnHapusCheckboxIndex").attr("disabled", false);
        $("input[name='hapusIndex[]']").detach();
        $('#temp-hapus').append(
            "<input type='hidden' id='hapus' name='hapusIndex' value='all'>"
        );
    }else{
        $("#btnHapusCheckboxIndex").attr("disabled", true);
        $("input[name='hapusIndex']").remove();
    }
});

//$("#btnHapusCheckboxIndex").click(function(e){
$(document).on('click', '#btnHapusCheckboxIndex', function(e) {
    e.preventDefault();
    bootbox.dialog({
        message: "Apakah anda ingin menghapus data ini?",
        buttons:{
            ya : {
                label: "Ya",
                className: "btn-warning",
                callback: function(){
                    $('#hapus-index').submit();
                    $("#btnHapusCheckboxIndex").off("click");
                }
            },
            tidak : {
                label: "Tidak",
                className: "btn-warning",
                callback: function(result){
                    // $(".btnHapusCheckboxIndex").off("click");
                }
            }
        }
    });
});