var Order = function() {

    var handleOrder = function() {
    	
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
            	var url = '/admin/order/';
                if (parseInt($('[name=o_id]').val()) > 0){
                    url += 'ajaxUpdate/' + $('[name=o_id]').val();
                }else {
                    url += 'ajaxAdd'
                }

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

        $('[name=adult_num], [name=child_num]').change(function(){
            personalCheck();
        });

        personalCheck();

        $('[name=t_id]').select2({
            width: "off",
            ajax: {
                url: "/admin/tour/ajaxSearch",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.t_title,
                                id: item.t_id,
                                price: item.t_price,
                                dayprice: item.t_weekday_price,
                                discountprice: item.t_discount_price,
                            }
                        })
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatState,
        }).on('select2:select', function (e) {
            var data = e.params.data;
        });


        $('[name=adult_num], [name=child_num], [name=t_id], [name=apply_date]').change(function(){
            var num = parseInt($('[name=adult_num]').val()) + parseInt($('[name=child_num]').val());
            calculatePrice(num);
        });
        
    }

    var formatState = function(data) {
        if (data.loading) return data.text;
        var $div = $('<div class="select2-result-repository clearfix" data-price="'+ data.price +'" data-dayprice="'+ data.dayprice +'" data-discountprice="'+ data.discountprice +'">' + data.text + '</div>');
        return $div;
    }
    
    var formCallback = function(response) {
   	    // console.log(response);
    	if (response.status) {
            Site.showAlert(true, 'success', '成功', response.message, 'success', '/admin/order');
    	} else {
    		$('#data-form-btn').removeAttr('disabled');
    		Site.showAlert(true, 'error', '失敗', response.message);
    	}
    };

    var personalCheck = function () {
        var total_num = 0;
        total_num = parseInt($('[name=adult_num]').val()) + parseInt($('[name=child_num]').val());
        if (total_num == 1) {
            $('#personal').removeClass('hide');
        } else {
            $('#personal').addClass('hide');         
        }
    };

    var calculatePrice = function (num) {
        var date = new Date($('[name=apply_date]').val()),
            utc_day = date.getUTCDay(),
            price = 0,
            dayprice = 0,
            discountprice = 0,
            total_price = 0;;

        
        if (typeof($('[name=t_id] :selected').data('price')) != 'undefined') {
            price = parseInt($('[name=t_id] :selected').data('price'));
            dayprice = parseInt($('[name=t_id] :selected').data('dayprice'));
            discountprice = parseInt($('[name=t_id] :selected').data('discountprice'));
        } else {
            $('[name=t_id]').select2('data')[0].price;
            price = parseInt($('[name=t_id]').select2('data')[0].price);
            dayprice = parseInt($('[name=t_id]').select2('data')[0].dayprice);
            discountprice = parseInt($('[name=t_id]').select2('data')[0].discountprice);
        }

        if (utc_day >= 1 && utc_day <= 5) {
            total_price = num * dayprice;
        } else {
            total_price = num * price;
            if (num >= 10) {
                total_price = num * discountprice;
            }
        }
        $('[name=total_price]').val(total_price);
    };

    return {
        //main function to initiate the module
        init: function() {
            handleOrder();
        }
    };

}();

jQuery(document).ready(function() {
    Order.init();        
});