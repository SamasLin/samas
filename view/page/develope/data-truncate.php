<form id="truncate-data-form" class="form-horizontal">
    <div class="control-group">
        <label class="control-label" for="table-list">Truncate Data</label>
        <div class="controls">
            <div class="span2" style="margin-left: 0;">
                <input type="hidden" id="table-list" name="table_list" value="" />
                <table class="table table-bordered table-condensed">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" id="table-checkbox-all" /></td>
                            <td class="span2"><strong>Table Name</strong></td>
                        </tr>
                        <tr><td colspan="2"></td></tr>
                        <?php
                        $db_obj = new DatabaseAccess();
                        $exist_table_array = $db_obj->getAllTables();

                        foreach ($exist_table_array as $table_name) {
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="table-checkbox" value="<?php echo $table_name; ?>" />
                            </td>
                            <td class="input-medium">&nbsp;&nbsp;&nbsp;<?php echo $table_name; ?></td>
                        </tr>
                        <?php
                        }// end foreach ($exist_table_array as $table_name)
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">Truncate</button>
        </div>
    </div>
</form>
<hr>
<div class="alert alert-info">
    <strong>Note：</strong>
    <ul>
        <li>將會把勾選的資料表<strong><span class="text-warning">所有資料</span><span class="text-error">清空</span></strong>並且將資料表<strong><span class="text-warning">取號機</span><span class="text-error">歸零</span></strong></li>
    </ul>
</div>
<script>
$(document).ready(function() {

    $(document.body).off('change', '#table-checkbox-all');
    $(document.body).on('change', '#table-checkbox-all', function() {

        if ($(this).is(':checked')) {

            $('.table-checkbox:not(:checked)').trigger("click");

        } else {

            $('.table-checkbox:checked').trigger("click");

        }

    });

    $(document.body).off('change', '.table-checkbox');
    $(document.body).on('change', '.table-checkbox', function() {

        var table_list = "";
        $.each($('.table-checkbox:checked'), function() {

            if (table_list.length > 0) {

                table_list += ',';

            }
            table_list += $(this).val();

        });
        $('#table-list').val(table_list);

    });

    function truncateDataValidate(formData, jqForm, options) {

        var validate = true;

        if ($('.table-checkbox:checked').length == 0) {

            validate = false;

        }

        if (validate) {

            $('#system-message').html('處理中');
            $('#system-message').show();

        }

        return validate;

    }

    function truncateDataResponse(response, statusText, xhr, $form) {

        if (response.status.code == 0) {

            $('#system-message').html(response.message);
            $('#system-message').fadeOut(2000);
            setTimeout(function() {
                window.location.reload();
            }, 1500);

        } else if (response.status.code == 2) {

            window.location.href = '/index';

        } else {

            $('#system-message').html('失敗');
            $('#system-message').fadeOut(2000);
        }

    }

    $('#truncate-data-form').ajaxForm({

        beforeSubmit: truncateDataValidate,
        success:      truncateDataResponse,
        url: '/action/develope/truncate-data',
        type: 'post',
        dataType: 'json'

    });

});
</script>