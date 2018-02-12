var AlbumList = function() {

    var handleAlbumList = function() {

        $('.del_btn').click(function(){
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
            $('#a_id').val('');
        });

        $('#delete_btn').click(function(){
            var url = '/admin/album/ajaxDelete';

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
        var num = $('.del_btn').index(el),
            name = $('tbody tr').eq(num).find('td:eq(1)').text(),
            msg = '你確定要刪除 ' + name + ' 的相簿?'
            a_ids = [];

        $('#a_id').val(el.data('id'));

        if (type == 'multi_del') {
            msg = '你確定要刪除 ';
            $.each ($('tbody input:checkbox:checked'), function(index, e){
                num = $('tbody input:checkbox').index(e);
                name = $('tbody tr').eq(num).find('td:eq(1)').text();
                if (index > 0) {
                    msg += ', ';
                }
                msg += name;
                a_ids.push($(this).val());
            });
            msg += ' 的相簿?';
            $('#a_id').val(a_ids);
        }

        $('#modal_body').text(msg);
        $('#basic_modal').modal('show');
    }
    
    var formCallback = function(response) {
   	    // console.log(response);
    	if (response.status) {
            Site.showAlert(true, 'success', '成功', response.message, "reload", "");
    	} else {
    		$("#data-form-btn").removeAttr("disabled");
    		Site.showAlert(true, 'error', '失敗', response.message);
    	}
    };

    return {
        //main function to initiate the module
        init: function() {
            handleAlbumList();
        }
    };

}();

jQuery(document).ready(function() {
    AlbumList.init();        
});