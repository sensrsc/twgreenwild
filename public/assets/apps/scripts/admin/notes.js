var Notes = function() {

    var handleNotes = function() {

        var body = CKEDITOR.replace('an_body',
        {
            baseFloatZIndex:30000,
            filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '/js/ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    	
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
            	var url = '/admin/notes/';
                if (parseInt($('[name=an_id]').val()) > 0){
                    url += 'ajaxUpdate/' + $('[name=an_id]').val();
                }else {
                    url += 'ajaxAdd'
                }

                $('[name=an_body]').val(body.getData());

                var formData = new FormData($('form')[0]);
                Site.ajaxTask('post', true, false, url, formData, formCallback, null, false);
               
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

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                format: 'yyyy-mm-dd',
                rtl: App.isRTL(),
                orientation: "left",
                autoclose: true
            });
        }

        $('#image-picker').imagepicker();
        if ($('[name=c_id]').val() > 0) {
            categoryAlbum($('[name=c_id]').val());
            albumPicture($('[name=a_id]').data('aid'));
        }

        $('[name=c_id]').change(function(){
            var cID = $(this).val();
            categoryAlbum(cID);
        });

        $('[name=a_id]').change(function(){
            var aID = $(this).val();
            albumPicture(aID);
        });
    };
    
    var formCallback = function(response) {
   	    // console.log(response);
    	if (response.status) {
            Site.showAlert(true, 'success', '成功', response.message, "success", "/admin/notes");
    	} else {
    		$("#data-form-btn").removeAttr("disabled");
    		Site.showAlert(true, 'error', '失敗', response.message);
    	}
    };

    var categoryAlbum = function (cID) {
        var url = '/admin/album/ajaxAlbum/' + cID,
            params = {el : $('[name=a_id]'), 'type' : 'album'};

        Site.ajaxTask("get", true, false, url, {}, selectCallback, params, false);
    };

    var albumPicture = function (aID) {
        var url = '/admin/picture/ajaxAlbumPicture/' + aID,
            params = {el : $('[name=an_cover]'), 'type' : 'picture', 'aID' : aID};

        Site.ajaxTask("get", true, false, url, {}, pictureCallback, params, false);
    };

    var selectCallback = function (response, params) {
        // console.log(response);
        if (params) {
            $.each(params.el.find('option'), function(index, e){
                if ($(e).val() != '') {
                    $(e).remove();
                }
            });
            if (response.status) {
                if (response.datas) {
                    var options = '';
                    $.each(response.datas, function(index, data){
                        options += '<option value="' + data.id + '">' + data.title + '</option>';
                    });
                    params.el.append(options);
                }
            }    
        }
        
    };

    var pictureCallback = function (response, params) {
        // console.log(response);
        if (params) {
            $.each(params.el.find('option'), function(index, e){
                if ($(e).val() != '') {
                    $(e).remove();
                }
            });
            if (response.status) {
                if (response.datas) {
                    var options = '',
                        apID = params.el.data('apid');
                    $.each(response.datas, function(index, data){
                        var selected = '';
                        if (apID == data.id) {
                            selected = 'selected';
                        }
                        options += '<option '+ selected +' value="' + data.id + '" data-img-src="/upload/picture/'+ params.aID +'/'+ data.title +'" data-img-class="img-picker">' + data.title + '</option>';
                    });
                    params.el.append(options);
                    $('#image-picker').imagepicker();
                }
            }    
        }
        
    };

    return {
        //main function to initiate the module
        init: function() {
            handleNotes();
        }
    };

}();

jQuery(document).ready(function() {
    Notes.init();        
});