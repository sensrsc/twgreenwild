var Tour = function() {
    var editorConfig = {
        baseFloatZIndex:30000,
        filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: '/js/ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    };

    var handleTour = function() {
    	
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
            	var url = '/admin/tour/';
                params = {};
                if (parseInt($('[name=t_id]').val()) > 0){
                    url += 'ajaxUpdate/' + $('[name=t_id]').val();
                    $('[name=c_id]').prop('disabled', false);
                    params.type = 'update';
                }else {
                    url += 'ajaxAdd'
                    params.type = 'add';
                }

                putEditorData();

                var formData = new FormData($('form')[0]);
                Site.ajaxTask("post", true, false, url, formData, formCallback, params, false);
               
                return false;
            }
        });

        $('[name=c_id]').change(function(){
            var cID = $(this).val();
            categoryAlbum(cID);
            categoryLevel(cID);
            categoryDescription(cID);
        });

        $('#data-form input').keypress(function(e) {
            if (e.which == 13 && $('#data-form #peronsal_login').attr('disabled') !== 'disabled') {
                if ($('#data-form').validate().form()) {
                    $('#data-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });  

        var placeholder = "請選擇相簿";
        $( ".select2-single" ).select2( {
            placeholder: placeholder,
            width: null,
            containerCssClass: ':all:'
        });


        checkEditor();
    };

    var categoryAlbum = function (cID) {
        var url = '/admin/album/ajaxAlbum/' + cID,
            params = {el : $('[name=a_id]'), 'type' : 'album'};

        Site.ajaxTask("get", true, false, url, {}, selectCallback, params, false);
    };

    var categoryLevel = function (cID) {
        var url = '/admin/level/ajaxLevel/' + cID,
            params = {el : $('[name=cl_id]'), 'type' : 'level'};
        Site.ajaxTask("get", true, false, url, {}, selectCallback, params, false);
    };

    var categoryDescription = function (cID) {
        var url = '/admin/category/ajaxDescription/' + cID;
        Site.ajaxTask("get", true, false, url, {}, descriptionCallback, null, false);
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

    var descriptionCallback = function (response) {
        // console.log(response);
        if (response.status) {
            $('#description_block').empty();
            if (response.datas) {
                $.each(response.datas, function(index, data){
                    $('#description_block').append(data);
                    var id = $(data).find('textarea.editor').prop('id');
                    if (typeof(id) != 'undefined') {
                        replaceEditor(id);
                    }
                });
            }
        }
    };

    var checkEditor = function () {
        if ($('[name=t_id]').val() > 0) {
            $.each($('textarea.editor'), function(index, el){
                var id = $(this).prop('id');
                replaceEditor(id);
            });
        }
    };

    var replaceEditor = function (id) {
        CKEDITOR.replace(id, editorConfig);
    };

    var putEditorData = function () {
        var instances = CKEDITOR.instances;
        $.each (instances, function (index, e){
            // CKEDITOR.instances[index]
            $('#' + index).val(e.getData());
        });
    };
    
    var formCallback = function (response, params) {
        // console.log(response);
        if (response.status) {
            Site.showAlert(true, 'success', '成功', response.message, 'success', '/admin/tour');
        } else {
            $("#data-form-btn").removeAttr("disabled");
            Site.showAlert(true, 'error', '失敗', response.message);
        }
        if (params.type == 'update') {
            $('[name=c_id]').prop('disabled', true);
        }
    };

    return {
        //main function to initiate the module
        init: function() {
            handleTour();
        }
    };

}();

jQuery(document).ready(function() {
    Tour.init();     
});