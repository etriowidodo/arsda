<div class="col-md-12">
    <div class="form-group">
        <label class="control-label col-sm-2">Pasal dibuktikan</label>
        <div class="col-md-10">
            <table id="table_pasal_terbukti" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="14%" style="text-align: center;vertical-align: middle;">Undang-undang</th>
                        <th width="14%" style="text-align: center;vertical-align: middle;">Pasal</th>
                        <th width="14%" style="text-align: center;vertical-align: middle;">Dibuktikan</th>
                    </tr>
                </thead>
                <tbody id="tbody_pasal_terbukti">
                <?php
                if (!$model->isNewRecord) {
                    foreach ($modelPasalDakwaan as $value):
                        echo '<tr id="row-'. $value->id_pasal .'">';
                        echo '<td style="text-align: center">' . $value->undang . '</td>';
                        echo '<td style="text-align: center">' . $value->pasal . '</td>';
                        echo '<td style="text-align: center">
                                <input type="checkbox" data-id="' . $value->id_pasal . '" name="chk_bukti_pasal" class="chkBuktiPasal" ' . ($value->is_bukti_pn == 1 ? "checked=checked" : "") . '>
                                ' . ($value->is_bukti_pn == 1 ? "<input type='hidden' id='terbukti-" . $value->id_pasal . "' class='form-control idpasal' name='pasal_terbukti[]' value='" . $value->id_pasal . "'>" : "" ) . '
                            </td>';
                        echo '</tr>';
                    endforeach;
                }else{
                    foreach ($modelPasalDakwaan as $value) {
                        echo '<tr>
                                    <td style="text-align: center">' . $value->undang . ' </td>
                                    <td style="text-align: center">' . $value->pasal . ' </td>
                                    <td style="text-align: center">
                                        <input type="checkbox" data-id="' . $value->id_pasal . '" name="chk_bukti_pasal[]" class="chkBuktiPasal">
                                    </td>
                                </tr>
                                ';
                    }
                }
                ?>
                </tbody>
            </table>
            <div id="pasal_terbukti"></div>
            <div id="pasal_tak_terbukti"></div>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>

<?php
$script = <<< JS
    $('.chkBuktiPasal').click(function(){
        if($(this).prop( "checked" ) == true){

            $('#tak-terbukti-'+$(this).attr('data-id')).remove();
            $('#pasal_terbukti').append(
                "<input type='hidden' id='terbukti-"+$(this).attr('data-id')+"' name='pasal_terbukti[]' value='"+$(this).attr('data-id')+"'>"
            );
        }else{
            $('#terbukti-'+$(this).attr('data-id')).remove();
            $('#pasal_tak_terbukti').append(
                "<input type='hidden' id='tak-terbukti-"+$(this).attr('data-id')+"' name='pasal_tak_terbukti[]' value='"+$(this).attr('data-id')+"'>"
            );
        }
    });
JS;
$this->registerJs($script);
?>