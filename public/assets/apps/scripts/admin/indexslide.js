var Indexslide = function() {

    var handleSlide = function() {
    	
        $('#data-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                is_title: {
                    required: true
                },
                is_status: {
                	required: true,
                	number: true
                }
            },

            messages: {
                is_title: {
                    required: '請入名稱'
                },
                is_status: {
                	required: '請選擇狀態'             
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
                // form.submit(); // form validation success, call ajax form submit
            	var url = '/admin/indexslide/';
                if (parseInt($('[name=is_id]').val()) > 0){
                    url += 'update_indexslide';
                }else {
                    url += 'add_indexslide';
                }
                // $('[name=n_body]').val(body.getData());

                // var formData = new FormData($('form')[0]);
                Common.fromSubmit("post", url, $('#data-form'), formCallback, null);
               
                return false;
            }
        });

        $('#data-form input').keypress(function(e) {
            if (e.which == 13 && $('#data-form #peronsal_login').attr('disabled') !== 'disabled') {
                if ($('#data-form').validate().form()) {
                    $('#data-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });      

    }
    
    


    return {
        //main function to initiate the module
        init: function() {
            handleSlide();
        }

    };

}();

var formCallback = function(response) {
        console.log(response);
        if (response.Status) {
            Common.showAlert(true, 'success', '成功', response.Message, "success", "/admin/indexslide");
        } else {
            $("#data-form-btn").removeAttr("disabled");
            Common.showAlert(true, 'error', '失敗', response.Message);
        }
    };

jQuery(document).ready(function() {
    Indexslide.init();     
});