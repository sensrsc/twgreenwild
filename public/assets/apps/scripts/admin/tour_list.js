var TourList = function() {

    var handleTourList = function() {
        $('[name=tour_set]').multiselect({
            nonSelectedText: '請選擇',
            onChange: function(option, checked) {
                var url = '/admin/tour/ajaxRecommend/' + this.$select.data('id');

                var formData = new FormData();
                formData.append('_token', $('[name=_token]').val());
                formData.append('checked', checked);
                formData.append('type', $(option).val());

                Site.ajaxTask('post', true, false, url, formData, formCallback, null, false);
            }
        });  
    }
    
    var formCallback = function(response) {
   	    // console.log(response);
    	if (response.status) {
            if (typeof(response.season) != 'undefined') {
                $('#season_num').text(response.season);
            } else {
                $('#hot_num').text(response.hot);
            }
            // Site.showAlert(true, 'success', '成功', response.message);
    	} else {
    		$("#data-form-btn").removeAttr("disabled");
    		Site.showAlert(true, 'error', '失敗', response.message);
    	}
    };

    return {
        //main function to initiate the module
        init: function() {
            handleTourList();
        }
    };

}();

jQuery(document).ready(function() {
    TourList.init();  
});