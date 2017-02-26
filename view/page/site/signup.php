<?php
if (WebService::isLogin()) {
    WebService::showError(0);
}
?>
<div class="ceil"></div>
<form id="signup-form" class="signup-form">
    <h3 class="signup-form-heading fwb">
        請輸入帳號資料
    </h3>
    <input id="name" name="name" class="form-control input-xlarge" type="text" autofocus="" required="" placeholder="請輸入姓名" />
    <input id="account" name="account" class="form-control input-xlarge" type="text" required="" placeholder="請輸入帳號" />
    <input id="email" name="email" class="form-control input-xlarge" type="text" required="" placeholder="請輸入 Email" />
    <input id="password" name="password" class="form-control input-xlarge" type="password" required="" placeholder="請輸入密碼" />
    <input id="password-chk" class="form-control input-xlarge" type="password" required="" placeholder="請確認密碼" />
    <h4>&nbsp;</h4>
    <button id="signup-btn" class="btn btn-lg btn-primary btn-block fwb" type="submit">
        <h4>註冊</h4>
    </button>
</form>
<script>
$(document).ready(function() {

    function signupValidate(formData, jqForm, options) {

        var validate = true;

        if (   !$('#name').val()
            || !$('#account').val()
            || !$('#email').val()
            || !$('#password').val()
            || !$('#password-chk').val()
        ) {
            $('#system-message').html('請輸入所有欄位');
            $('#system-message').show();
            $('#system-message').fadeOut(2000);
            validata = false;
        } else if ($('#password').val() != $('#password-chk').val()) {
            $('#system-message').html('兩次密碼輸入不同');
            $('#system-message').show();
            $('#system-message').fadeOut(2000);
            validata = false;
        }

        if (validate) {

            $('#system-message').html('處理中');
            $('#system-message').show();

        }

        return validate;

    }

    function signupResponse(response, statusText, xhr, $form) {

        if (response.status.code == 0) {

            $.pjax({
                url: '<?php echo WebService::getRedirectTarget(); ?>',
                container: '#main-section'
            });

        } else {

            $('#system-message').html(response.message);
            $('#system-message').fadeOut(2000);

        }

    }

    $('#signup-form').ajaxForm({

        beforeSubmit: signupValidate,
        success:      signupResponse,
        url: '/action/site/signup',
        type: 'post',
        dataType: 'json'

    });

});
</script>