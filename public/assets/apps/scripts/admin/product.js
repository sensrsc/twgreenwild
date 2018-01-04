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
            	pm_category: {
                    required: true
                },
                pm_name_tw: {
                    required: true
                },
                pm_name_en: {
                    required: true
                },  
                // pm_description_short: {
                //     required: true
                // },   
                pm_model_no: {
                    required: true
                },
                // pm_bar_code: {
                //     required: true
                // },  
                // pm_material_description: {
                //     required: true
                // },
                // pm_package: {
                //     required: true
                // },    
                // pm_description_full: {
                //     required: true
                // },  
                pm_image_01: {
                    required: true
                },
                // pm_color_01: {
                //     required: true
                // },     
                pm_price: {
                	required: true,
                	number: true,
                	min: 0
                }, 
                // pm_use_scenario_01: {
                //     required: true
                // },
                // pm_material_01: {
                //     required: true
                // },
                // pm_style: {
                //     required: true
                // },
                // pm_size: {
                //     required: true
                // },
                pm_inventory: {
                	required: true,
                	number: true,
                	min: 0
                },
                pm_status: {
                	required: true,
                	number: true
                }
            },

            messages: {
            	pm_category: {
                    required: '請輸入品項'
                },
                pm_name_tw: {
                    required: '請輸入中文品名'
                },
                pm_name_en: {
                    required: '請輸入英文品名'
                },  
                // pm_description_short: {
                //     required: '請輸入商口簡述'
                // },   
                pm_model_no: {
                    required: '請入商品型號'
                },
                // pm_bar_code: {
                //     required: '請輸入條碼'
                // },  
                // pm_material_description: {
                //     required: '請輸入材質'
                // },
                // pm_package: {
                //     required: '請輸入包裝'
                // },    
                // pm_description_full: {
                //     required: '請輸入商品說明'
                // },  
                pm_image_01: {
                    required: '請選擇商品圖1'
                },
                // pm_color_01: {
                //     required: '請輸入顏色1'
                // },               
                pm_price: {
                	required: '請輸入售價',
                	number: '請輸入數字',
                	min: '最小只能輸入0'
                }, 
                // pm_use_scenario_01: {
                //     required: '請輸入使用情境1'
                // },
                // pm_material_01: {
                //     required: '請輸入材質1'
                // },
                // pm_style: {
                //     required: '請輸入特色風格'
                // },
                // pm_size: {
                //     required: '請輸入大小'
                // },               
                pm_inventory: {
                	required: '請輸入庫存量',
                	number: '請輸入數字',
                	min: '最少只能輸入0'
                },
                pm_status: {
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
            	var url = '/admin/product/';
                if (parseInt($('[name=pm_id]').val()) > 0){
                    url += 'update_product';
                }else {
                    url += 'add_product'
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
            handleItem();
        }

    };

}();

var formCallback = function(response) {
        console.log(response);
        if (response.Status) {
            Common.showAlert(true, 'success', '成功', response.Message, "success", "/admin/product");
        } else {
            $("#data-form-btn").removeAttr("disabled");
            Common.showAlert(true, 'error', '失敗', response.Message);
        }
    };

jQuery(document).ready(function() {
    Item.init();     
});