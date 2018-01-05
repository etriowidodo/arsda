
                <!-- <div class="col-md-9">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Bidang</label>
                      <div class="col-sm-6 kejaksaan"> -->
                <?php
                    $connection = \Yii::$app->db;
                    $query = "select id_wilayah,id_level1,id_level2,\"UNITKERJA_NAMA\" as nama_kejagung_unit from kepegawaian.v_kp_unit_kerja where id_wilayah='1'  and id_level3='0' and id_level4='0' order by id_level1,id_level2";
                    $result = $connection->createCommand($query)->queryAll();


                    $connection = \Yii::$app->db;
                    $query1 = "select B.\"UNITKERJA_NAMA\" as nama_bidang,B.id_level1 as id_bidang,(select A.id_inspektur from was.wilayah_inspektur A where A.id_wilayah::integer = 0 and A.id_kejati::integer = B.id_level1::integer  ) as id_inspektur from kepegawaian.v_kp_unit_kerja B where B.id_wilayah ='1' and length(B.\"UNITKERJA_KD\")=3";
                    $result_bidang = $connection->createCommand($query1)->queryAll();
                ?>
                    <select name="id_bidang_" id="id_bidang_">
                      <?php
                        foreach ($result_bidang as $rowData) {
                      ?>
                      <option value="<?= $id_bidang?>"><?= $rowData['nama_bidang'] ?></option>
                      <?php
                        }
                      ?>
                    </select>

                    

                    <!--   </div>
                    </div>
                </div>  -->
               <div class="col-md-12" id="KejagungToBidang">
                     
                     <table border='1' width="100%" class="table table-bordered" id="tbl_kejagung">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Unit Kerja</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no=1;
                        foreach ($result as $key) {
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $key['nama_kejagung_unit']?></td>
                                <td align="center">
                                    <!-- <a href="#" class="td" rel="<?php echo $key['id_kejagung_bidang']?>" nunit="<?php echo $key['nama_kejagung_bidang']?>"><i class="glyphicon glyphicon-ok"></i></a> -->
                                    <input class="td_kejagung" type="checkbox" name='ck_pilih' rel="<?php  echo $key['id_kejagung_bidang']?>" nmbidang="<?php  echo $key['akronim']?>" idunit="<?php  echo $key['id_kejagung_unit']?>" nmunit="<?php  echo $key['nama_kejagung_unit']?>" idinspektur="<?php  echo $key['id_inspektur'] ?>">
                                </td>
                            </tr>
                         <?php  
                        $no++;
                     } 
                     ?>
                        </tbody>
                    </table> 
               
               </div>
            <!-- </div> -->
              <div class="modal-footer">  
    			<a href="#" class="btn btn-primary" id="add_bidang_tmp">Simpan</a>
                <a href="#" data-dismiss="modal" class="btn btn-primary">Batal</a>

            </div>
        <!-- </div> -->
    <!-- </div> -->
<!-- </div>  -->
<script type="text/javascript">

 $('#tbl_kejagung').dataTable({'aLengthMenu': [[10, 15, 20, -1], [10, 15, 20, 'All']],
'iDisplayLength': 10});

 $('#add_bidang_tmp').click(function(){
  var id_bidang=$('.td_kejagung:checked').attr('rel');
  var nama_bidang=$('.td_kejagung:checked').attr('nmbidang');
  var id_unit=$('.td_kejagung:checked').attr('idunit');
  var nama_unit=$('.td_kejagung:checked').attr('nmunit');
  var id_inspektur=$('.td_kejagung:checked').attr('idinspektur');
  // if(id_kejati==null){
  //   alert('Harap Pilih Kejati');
  //   return false;
  // }
 
  $('#idbidang').val(id_bidang);/*Warning pada saat memilih kejagung id_bidang ini adalah id bidang kejagung tpi pada saat milih kejati id bidang ini adalah id_kejati*/
  $('#bidang').val(nama_bidang);
  $('#idunit').val(id_unit);
  $('#unit_kerja').val(nama_unit);
  $('#idinspektur').val(id_inspektur);
          $("#MyModalPopUp").modal('hide');
 });
 $(document).on('click', '.td_kejagung', function () { 
            var x=$('.td_kejagung:checked').length;
          if(x > 1){
            $(this).prop('checked',false);
          }
        });


// $(document).on('click','#add_bidang_tmp',function(){
//           var id_bidang=$('.td_kejagung:checked').attr('rel');
//           var nama_bidang=$('.td_kejagung:checked').attr('nmbidang');
//           var id_unit=$('.td_kejagung:checked').attr('idunit');
//           var nama_unit=$('.td_kejagung:checked').attr('nmunit');
//           var id_inspektur=$('.td_kejagung:checked').attr('idinspektur');
//           if(id_kejati==null){
//             alert('Harap Pilih Kejati');
//             return false;
//           }
//           alert('asas');
//           $('#idbidang').val(id_bidang);/*Warning pada saat memilih kejagung id_bidang ini adalah id bidang kejagung tpi pada saat milih kejati id bidang ini adalah id_kejati*/
//           $('#bidang').val(nama_bidang);
//           $('#idunit').val('');
//           $('#unit_kerja').val('');
//           $('#idinspektur').val(id_inspektur);
          
//         });
</script>