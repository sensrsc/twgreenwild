var VideoList = function() {

    var handleVideoList = function() {

        $('.del_btn').click(function(){
            btnDisplay($(this), 'del');
        });

        $('#basic_modal').on('hide.bs.modal', function (e) {
            $('#cv_id').val('');
        });

        $('#delete_btn').click(function(){
            var url = '/admin/video/ajaxDelete';

            var formData = new FormData($('#modal_form')[0]);
            Site.ajaxTask("post", true, false, url, formData, formCallback, null, false);
            $('#basic_modal').modal('hide');
        });
    }

    var btnDisplay = function(el, type) {
        var num = $('.del_btn').index(el),
            name = $('tbody tr').eq(num).find('td:eq(0)').text(),
            msg = '你確定要刪除 ' + name + ' 的影片?'
            ids = [];

        $('#cv_id').val(el.data('id'));

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
            handleVideoList();
        }
    };

}();

jQuery(document).ready(function() {
    VideoList.init();        
});