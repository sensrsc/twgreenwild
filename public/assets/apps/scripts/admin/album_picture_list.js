var AlbumPictureList = function() {

    var handleAlbumPictureList = function() {

        $('.cover_btn').click(function(){
            $('#delete_btn').hide();
            $('#default_btn').show();
            btnDisplay($(this), 'cover');
        });

        $('.del_btn').click(function(){
            $('#delete_btn').show();
            $('#default_btn').hide();
            btnDisplay($(this), 'del');
        });

        $('.multi_del_btn').click(function(){
            console.log($('tbody input:checkbox:checked').length);
            if ($('tbody input:checkbox:checked').length == 0) {
                alert('請選擇要刪除的相簿!');
            } else {
                btnDisplay($(this), 'multi_del');
            }

            return false;
        });

        $('#basic_modal').on('hide.bs.modal', function (e) {
            $('#ap_id').val('');
        });

        $('#delete_btn, #default_btn').click(function(){
            var url;
            if ($(this).prop('id') == 'default_btn') {
                url = '/admin/album/ajaxCover/';
            } else {
                url = '/admin/picture/ajaxDelete/';
            }
            url += $('[name=a_id]').val() ;

            var formData = new FormData($('#modal_form')[0]);
            Site.ajaxTask("post", true, false, url, formData, formCallback, null, false);
            $('#basic_modal').modal('hide');
        });

        $('#all_checkbox').change(function(){
            if ($(this).prop('checked')) {
                $('tbody .checker').find('span').addClass('checked');
                $('tbody input:checkbox').prop('checked', true);
            } else {
                $('tbody .checker').find('span').removeClass('checked');
                $('tbody input:checkbox').prop('checked', false);
            }
        });
    }

    var btnDisplay = function(el, type) {
        var num = $('.cover_btn').index(el),
            name = $('tbody tr').eq(num).find('td:eq(1)').text(),
            msg = '你確定要刪除 ' + name + ' 的相片?',
            ap_ids = [];;
        if (type == 'cover') {
            msg = '你確認要將 ' + name + ' 設為封面?';
        }
        $('#ap_id').val(el.data('id'));

        if (type == 'multi_del') {
            msg = '你確定要刪除 ';
            $.each ($('tbody input:checkbox:checked'), function(index, e){
                num = $('tbody input:checkbox').index(e);
                name = $('tbody tr').eq(num).find('td:eq(1)').text();
                if (index > 0) {
                    msg += ', ';
                }
                msg += name;
                ap_ids.push($(this).val());
            });
            msg += ' 的相簿?';
            $('#ap_id').val(ap_ids);
        }

        $('#modal_body').text(msg);
        $('#basic_modal').modal('show');
    }
    
    var formCallback = function(response) {
   	    // console.log(response);
    	if (response.status) {
            Site.showAlert(true, 'success', '成功', response.message, 'reload', '');
    	} else {
    		$("#data-form-btn").removeAttr("disabled");
    		Site.showAlert(true, 'error', '失敗', response.message);
    	}
    };

    return {
        //main function to initiate the module
        init: function() {
            handleAlbumPictureList();
        }
    };

}();

jQuery(document).ready(function() {
    AlbumPictureList.init();        
});