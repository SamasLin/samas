<form id="create-router-form" class="form-horizontal">
    <div class="control-group">
        <label class="control-label" for="router-name">Router Name</label>
        <div class="controls">
            <input type="text" id="router-name" name="router_name" placeholder="Router Name" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="create-controller">Controller</label>
        <div class="controls">
            <select class="span1" id="create-controller" name="create_controller">
                <option value="0">no</option>
                <option value="1">yes</option>
            </select>
            <div id="controller-name" class="help-inline" style="display: none;"> => <?php echo str_replace(SITE_ROOT, '', CONTROLLER_ROOT).DIRECTORY_SEPARATOR; ?><span class="router-name"></span>Controller.php</div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="create-action">Action</label>
        <div class="controls">
            <select class="span1" id="create-action" name="create_action">
                <option value="0">no</option>
                <option value="1">yes</option>
            </select>
            <div id="action-name" class="help-inline" style="display: none;"> => <?php echo str_replace(SITE_ROOT, '', ACTION_ROOT).DIRECTORY_SEPARATOR; ?><span class="router-name"></span>Action.php</div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="create-api">API</label>
        <div class="controls">
            <select class="span1" id="create-api" name="create_api">
                <option value="0">no</option>
                <option value="1">yes</option>
            </select>
            <div id="api-name" class="help-inline" style="display: none;"> => <?php echo str_replace(SITE_ROOT, '', API_ROOT).DIRECTORY_SEPARATOR; ?><span class="router-name"></span>API.php</div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="router-type-error"></label>
        <div class="controls">
            <span id="router-type-error" class="error-help"></span>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </div>
</form>
<hr>
<div class="alert alert-info">
    <strong>Note：</strong>
    <ul>
        <li>如果有選 yes，將會產生相對應的 controller 接口檔案，若已經有<strong>相同名稱</strong>的檔案則會<strong><span class="text-error">略過此步驟</span></strong></li>
        <li>如果有選 yes，將會產生相對應的 action 接口檔案，若已經有<strong>相同名稱</strong>的檔案則會<strong><span class="text-error">略過此步驟</span></strong></li>
        <li>如果有選 yes，將會產生相對應的 api 接口檔案，若已經有<strong>相同名稱</strong>的檔案則會<strong><span class="text-error">略過此步驟</span></strong></li>
    </ul>
</div>
<script>
$(document).ready(function() {

    $(document.body).off('input', '#router-name');
    $(document.body).on('input', '#router-name', function() {
        $('.router-name').text($(this).val());
        if ($(this).val()) {
            if ($('#create-controller').val() == 1) {
                $('#controller-name').show();
            }
            if ($('#create-action').val() == 1) {
                $('#action-name').show();
            }
            if ($('#create-api').val() == 1) {
                $('#api-name').show();
            }
        } else {
            $('#controller-name').hide();
            $('#action-name').hide();
            $('#api-name').hide();
        }
    });

    $(document.body).off('change', '#create-controller');
    $(document.body).on('change', '#create-controller', function() {
        $('#controller-name').hide();
        if ($(this).val() == 1 && $('#router-name').val()) {
            $('#controller-name').show();
        }
    });

    $(document.body).off('change', '#create-action');
    $(document.body).on('change', '#create-action', function() {
        $('#action-name').hide();
        if ($(this).val() == 1 && $('#router-name').val()) {
            $('#action-name').show();
        }
    });

    $(document.body).off('change', '#create-api');
    $(document.body).on('change', '#create-api', function() {
        $('#api-name').hide();
        if ($(this).val() == 1 && $('#router-name').val()) {
            $('#api-name').show();
        }
    });

    function createRouterValidate(formData, jqForm, options) {

        var validate = true;

        if (!$('#router-name').val()) {

            validate = false;

        }

        if (   $('#create-controller').val() == 0
            && $('#create-action').val() == 0
            && $('#create-api').val() == 0
        ) {

            $('#router-type-error').html('未選擇要建立的接口類型');
            $('#router-type-error').show();
            validate = false;

        } else {

            $('#router-type-error').hide();

        }

        if (validate) {

            $('#system-message').html('處理中');
            $('#system-message').show();

        }

        return validate;

    }

    function createRouterResponse(response, statusText, xhr, $form) {

        if (response.status.code == 0) {

            $('#system-message').html(response.message);
            $('#system-message').fadeOut(2000);

        } else if (response.status.code == 2) {

            window.location.href = '/index';

        } else {

            $('#system-message').html('失敗');
            $('#system-message').fadeOut(2000);

        }

    }

    $('#create-router-form').ajaxForm({

        beforeSubmit: createRouterValidate,
        success:      createRouterResponse,
        url: '/action/develope/create-router',
        type: 'post',
        dataType: 'json'

    });

});
</script>