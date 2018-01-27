var AlbumPictureList = function() {

    var handleAlbumPictureList = function() {

        $('.del_btn').click(function(){
            var num = $('.del_btn').index($(this)),
                name = $('tbody tr').eq(num).find('td:eq(0)').text();

            $('#modal_body').text('你確定要刪除' + name + '的相片?');
            $('#ap_id').val($(this).data('id'));
            $('#basic_modal').modal('show');
        });

        $('#basic_modal').on('hide.bs.modal', function (e) {
            $('#ap_id').val('');
        });

        $('#delete_btn').click(function(){
            var url = '/admin/picture/ajaxDelete/' + $('[name=a_id]').val() ;

            var formData = new FormData($('#modal_form')[0]);
            Site.ajaxTask("post", true, false, url, formData, formCallback, null, false);
            $('#basic_modal').modal('hide');
        });

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
            handleAlbumPictureList();
        }
    };

}();

jQuery(document).ready(function() {
    AlbumPictureList.init();        
});