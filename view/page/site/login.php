<?php
if (WebService::isLogin()) {
    WebService::showError(0);
}
?>
<div class="jumbotron"></div>
<form id="login-form" class="signup-form">
    <h3 class="login-form-heading fwb">
        請輸入帳號密碼
    </h3>
    <input id="account" name="account" class="form-control input-xlarge" type="text" autofocus="" required="" placeholder="請輸入帳號或 Email" style="margin-bottom: 0;" />
    <input id="password" name="password" class="form-control input-xlarge" type="password" required="" placeholder="請輸入密碼" />
    <h4>&nbsp;</h4>
    <button id="login-btn" class="btn btn-lg btn-primary btn-block fwb" type="submit">
        <h4>登入</h4>
    </button>
    <p class="text-right">
        <u><a href="/site/signup<?php echo WebService::getRedirectQuery(); ?>" class="main-pjax">註冊</a></u>
    </p>
</form>
<script>
$(document).ready(function() {

    function loginValidate(formData, jqForm, options) {

        var validate = true;

        if (   !$('#account').val()
            || !$('#password').val()
        ) {
            validate = false;
        }

        if (validate) {

            $('#system-message').html('處理中');
            $('#system-message').show();

        }

        return validate;

    }

    function loginResponse(response, statusText, xhr, $form) {

        if (response.status.code == 0) {

            $('#system-message').html('成功');
            $('#system-message').fadeOut(2000);
            setTimeout(function() {
                window.location.href = '<?php echo WebService::getRedirectTarget(); ?>';
            }, 1500);

        } else {

            $('#system-message').html(response.message);
            $('#system-message').fadeOut(2000);

        }

    }

    $('#login-form').ajaxForm({

        beforeSubmit: loginValidate,
        success:      loginResponse,
        url: '/action/site/login',
        type: 'post',
        dataType: 'json'

    });

});
</script>