var Category = function() {

    var handleCategory = function() {
        var finder_config = {
            baseFloatZIndex:30000,
            filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '/js/ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        };

        CKEDITOR.replace('c_fee_body', finder_config);
        CKEDITOR.replace('c_issue_body', finder_config);
        CKEDITOR.replace('c_notice_body', finder_config);
        CKEDITOR.replace('c_cancel_body', finder_config);
    	
        $('#data-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
            	
            },

            messages: {
            	
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
            	var url = '/admin/category/';
                if (parseInt($('[name=c_id]').val()) > 0){
                    url += 'ajaxUpdate/' + $('[name=c_id]').val();
                }else {
                    url += 'ajaxAdd'
                }

                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                var formData = new FormData($('form')[0]);
                Site.ajaxTask("post", true, false, url, formData, formCallback, null, false);
               
                return false;
            }
        });

        $('[name=num]').change(function(){
            var num = $('#description_block .form-group').length,
                val = parseInt($(this).val()),
                total = val - num;
            descriptionProcess(total);
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

    var descriptionProcess = function(num) {
        var type = 'add';
        if (num < 0) {
            type = 'sub';
        }
        for (i = 0; i < Math.abs(num); i ++) {
            if (type == 'add') {
                addDescripton();
            } else {
                subDescription();
            }
        }
    }
    var addDescripton = function () {
        var temp = $('#description_temp').html();
        $('#description_block').append(temp);
    }
    var subDescription = function () {
        $('#description_block .form-group').last().remove();
    }
    
    var formCallback = function(response) {
   	    // console.log(response);
    	if (response.status) {
            Site.showAlert(true, 'success', '成功', response.message, "success", "/admin/category");
    	} else {
    		$("#data-form-btn").removeAttr("disabled");
    		Site.showAlert(true, 'error', '失敗', response.message);
    	}
    };

    return {
        //main function to initiate the module
        init: function() {
            handleCategory();
        }
    };

}();

jQuery(document).ready(function() {
    Category.init();        
});