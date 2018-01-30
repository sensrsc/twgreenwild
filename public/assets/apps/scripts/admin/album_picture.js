var AlbumPicture = function() {

    var handleAlbumPicture = function() {
        $('#data-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
            	
            },

            messages: {
            	
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                
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
            	// var url = '/admin/picture/';
             //    if (parseInt($('[name=ap_id]').val()) > 0){
             //        url += 'ajaxUpdate/' + $('[name=ap_id]').val();
             //    }else {
             //        url += 'ajaxAdd'
             //    }

             //    var formData = new FormData($('form')[0]);
             //    Site.ajaxTask("post", true, false, url, formData, formCallback, null, false);

             //    return false;
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
        
    
        $('#data-form').fileupload({
            url: '/admin/picture/ajaxAdd',
            singleFileUploads: false,
            disableImageResize: false,
            autoUpload: false,
            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            done: function (e, data) {
                // console.log('in done');
                // console.log(data.context);
                data.context.find('td:eq(2) .progress').remove();
                data.context.find('td:eq(3)').text('上傳成功');
            },
            fail: function (e, data) {
                data.context.find('td:eq(2) .progress').remove();
                data.context.find('td:eq(3)').text('上傳失敗')
                // $.each(data.files, function (index) {
                    // var error = $('<span class="text-danger"/>').text('File upload failed.');
                    // $(data.context.children()[index])
                    //     .append('<br>')
                    //     .append(error);
                // });
            },
            success: function (result, textStatus, jqXHR) {
                formCallback(result);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown)
            },
            complete: function (result, textStatus, jqXHR) {
                
            }
        });

    }
    
    var formCallback = function(response) {
   	    // console.log(response);
    	if (response.status) {
            url = '/admin/picture/index/';
            if (typeof response.a_id != 'undefind') {
                url += response.a_id
            }
            Site.showAlert(true, 'success', '成功', response.message, "success", url);
    	} else {
    		$("#data-form-btn").removeAttr("disabled");
    		Site.showAlert(true, 'error', '失敗', response.message);
    	}
    };

    return {
        //main function to initiate the module
        init: function() {
            handleAlbumPicture();
        }
    };

}();

jQuery(document).ready(function() {
    AlbumPicture.init();        
});