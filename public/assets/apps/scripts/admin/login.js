var Login = function() {

    var handleLogin = function() {

        $('#login_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                account: {
                    required: true
                },
                password: {
                    required: true
                },
                check_code: {
                    required: true,
                    minlength: 6
                }
            },

            messages: {
                account: {
                    required: '請輸入帳號'
                },
                password: {
                    required: '請輸入密碼'
                },
                check_code: {
                    required: '請輸入驗證碼',
                    minlength: '請輸入6個字元',
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                // if (validator.errorList.length > 0){
                //     var error_msg = '';
                //     $.each(validator.errorList, function(index, data){
                //         error_msg += data.message+"<br>";
                //     });
                //     $('#personal_login_form .alert-danger span').html(error_msg);
                // }
                // $('.alert-danger', $('#login_form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                // error.insertAfter(element.closest('.input-icon'));
                error.insertAfter(element);
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('#login_form input').keypress(function(e) {
            if (e.which == 13 && $('#login_form').attr('disabled') !== 'disabled') {
                if ($('#login_form').validate().form()) {
                    $('#login_form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });

        $('#new_captcha').click(function(){
            var timestamp = new Date().getTime()
            $('#captcha_img').attr('src', '/admin/login/captcha' + '?' + timestamp);
            return false;
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleLogin();
        }

    };

}();

jQuery(document).ready(function() {
    Login.init();        
});