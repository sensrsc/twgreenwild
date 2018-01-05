var Admin = function() {
    var handleAdmin = function() {
    	$.validator.methods.account_format = function( value, element ) {
            return this.optional( element ) || (!/\W/.test( value ))? true : false;
        }
    	
        $('form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                // a_account: {
                //     required: true,
                //     minlength: 3,
                //     account_format: true
                // },               
                // a_email: {
                //     required: true,
                //     email: true
                // },
                // a_displayname: {
                // 	required: true
                // },
                // re_password: {
                //     equalTo: "#a_password"
                // },
                // a_status: {
                // 	required: true
                // }
            },

            messages: {
            	// a_account: {
             //        required: '請輸入帳號',
             //        minlength: '最少需要輸入3個字元',
             //        account_format: '帳號格式錯誤'
             //    },                
             //    a_email: {
             //        required: '請輸入Email',
             //        email: '請確認Email格式'
             //    },
             //    a_displayname: {
             //    	required: '請輸入暱稱'	
             //    },
             //    re_password: {
             //        equalTo: '確認密碼要與密碼相同'
             //    },
             //    a_status: {
             //    	required: '請選擇狀態'
             //    }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit                   
                // $('.alert-danger', $('form')).show();
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
                var url = "/admin/admin/";
                if (parseInt($('[name=a_id]').val()) > 0){
                    url += 'ajaxUpdate/' + $('[name=a_id]').val();
                }else {
                    url += 'ajaxAdd'
                }
                
                var formData = new FormData($('form')[0]);
                $("#data-form-btn").attr("disabled", "disabled");
				Site.ajaxTask("post", true, false, url, formData, formSubmitCallback, null, false);
				return false;
            }
        });
        
        //新增需要輸入帳號 
     //    if (parseInt($('[name=a_id]').val()) == 0){
     //    	$( "#a_password" ).rules( "add", {
     //    		required: true,
     //    		minlength: 4,
     //    		maxlength: 12,
     //    		messages: {
     //    			required: '請輸入密碼',
					// minlength: '最少需要輸入4個字元',
					// maxlength: '最多只能輸入12個字元'
    	// 	  	}
    	// 	});              
     //    }

        $('form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('form').validate().form()) {
                    $('form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }
    
    return {
        //main function to initiate the module
        init: function() {
            handleAdmin();
        }
    };
}();

var formSubmitCallback = function(response) {
	// console.log("Company.FormSubmitCallback", response);
	if (response.status) {
        Site.showAlert(true, 'success', '成功', response.message, "success", "/admin/admin");
	} else {
		$("#data-form-btn").removeAttr("disabled");
		Site.showAlert(true, 'error', '失敗', response.message);
	}
};

$(function() {	
	Admin.init(); 
});