var Item = function() {

    var handleItem = function() {
//    	baseHref = '';
//        var body = CKEDITOR.replace('n_body',
//        {
//            baseFloatZIndex:30000,
//            filebrowserBrowseUrl : baseHref+'ckfinder/ckfinder.html',
//            filebrowserImageBrowseUrl: baseHref+'ckfinder/ckfinder.html?type=Images',
//            filebrowserFlashBrowseUrl : baseHref+'ckfinder/ckfinder.html?type=Flash',
//            filebrowserUploadUrl : baseHref+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
//            filebrowserImageUploadUrl : baseHref+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
//            filebrowserFlashUploadUrl : baseHref+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
//        });
    	
        $('#data-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
            	im_title_tw: {
                    required: true
                },
                im_title_jp: {
                    required: true
                },
                im_title_en: {
                    required: true
                },
                im_description_tw: {
                    required: true
                },
                im_description_jp: {
                    required: true
                },
                im_description_en: {
                    required: true
                },
                im_price: {
                	required: true,
                	number: true,
                	min: 0
                },
                im_spec_tw: {
                    required: true
                },
                im_spec_jp: {
                    required: true
                },
                im_spec_en: {
                    required: true
                },
                im_copyright_tw: {
                    required: true
                },
                im_copyright_jp: {
                    required: true
                },
                im_copyright_en: {
                    required: true
                },
                im_area_tw: {
                    required: true
                },
                im_area_jp: {
                    required: true
                },
                im_area_en: {
                    required: true
                },
                im_inventory: {
                	required: true,
                	number: true,
                	min: 0
                },
                im_status: {
                	required: true,
                	number: true
                }
            },

            messages: {
            	im_title_tw: {
                    required: '請輸入名稱(繁中)'
                },
                im_title_jp: {
                    required: '請輸入名稱(日文)'
                },
                im_title_en: {
                    required: '請輸入名稱(英文)'
                },
                im_description_tw: {
                    required: '請輸入繁中描述'
                },
                im_description_jp: {
                    required: '請輸入日文描述'
                },
                im_description_en: {
                    required: '請輸入英文描述'
                },
                im_price: {
                	required: '請輸入售價',
                	number: '請輸入數字',
                	min: '最小只能輸入0'
                },
                im_spec_tw: {
                    required: '請輸入規格(繁中)'
                },
                im_spec_jp: {
                    required: '請輸入規格(日文)'
                },
                im_spec_en: {
                    required: '請輸入規格(英文)'
                },
                im_copyright_tw: {
                    required: '請輸入版權(繁中)'
                },
                im_copyright_jp: {
                    required: '請輸入版權(日文)'
                },
                im_copyright_en: {
                    required: '請輸入版權(英文)'
                },
                im_area_tw: {
                    required: '請輸入販售區域(繁中)'
                },
                im_area_jp: {
                    required: '請輸入販售區域(日文)'
                },
                im_area_en: {
                    required: '請輸入販售區域(英文)'
                },
                im_inventory: {
                	required: '請輸入庫存量',
                	number: '請輸入數字',
                	min: '最少只能輸入0'
                },
                im_status: {
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
            	var url = '/admin/item/';
                if (parseInt($('[name=im_id]').val()) > 0){
                    url += 'update_item';
                }else {
                    url += 'add_item'
                }
//                $('[name=n_body]').val(body.getData());

                var formData = new FormData($('form')[0]);
                Common.ajaxTask("post", true, false, url, formData, formCallback, null, false);
               
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
    
    var formCallback = function(response) {
//    	 console.log("Company.FormSubmitCallback", response);
    	if (response.Status) {
    		Common.showAlert(true, 'success', '成功', response.Message, "success", "/admin/item");
    	} else {
    		$("#data-form-btn").removeAttr("disabled");
    		Common.showAlert(true, 'error', '失敗', response.Message);
    	}
    };


    return {
        //main function to initiate the module
        init: function() {
            handleItem();
        }

    };

}();

jQuery(document).ready(function() {
    Item.init();        
});