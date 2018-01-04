jQuery.i18n.properties({
    name: 'Messages', 
    path:'/lang/',
    language: Cookies.get('language')
});
// 整個網站通用物件
var Site = {    

    /**
     *  透過 ajax 拿資料做處理
     *
     *  @param {string} type POST or GET
     *  @param {Boolean} loading 是否需要 loading
     *  @param {Boolean} async 是否需要 async
     *  @param {string} url 網址
     *  @param {string} data 送出資料
     *  @param {string} callback 資料取得執行
     *  @param {string} parameter 執行所需參數
     */
    ajaxTask : function(type, loading, async, url, data, callback, parameter, process) {
        if (loading == 'undefined') {
            loading = false;
        }
        if (async == 'undefined') {
            async = true;
        }
        if (process == false) {
            process = false;
            content_type = false;
        }else {
            content_type = 'application/x-www-form-urlencoded';
        }
        $.ajax({
            url : url,
            data : data,
            type : type,
            dataType : 'json',
            cache : false,
            global : true,
            async : async,
            contentType: content_type,
            processData: process,
            beforeSend : function() {
                if (loading == true) {
                    $.fancybox.showLoading();
                }
            },
            complete : function() {
                if (loading == true) {
                    $.fancybox.hideLoading();
                }
            },
            success : function(response) {
                if (loading == true) {
                    $.fancybox.hideLoading();
                }
                if (response.ToLogin === undefined) {
                    if (typeof (callback) === 'function') {
                        callback(response, parameter);
                    } else {
                        Site.showAlert(true, "error", error, ajax_callback_error);
                    }
                } else if (response.ToLogin === true) {
                    location.href = "/login";
                }
            },
            error : function(xhr, ajaxOptions, thrownError) {
                $("#data-form-btn").removeAttr("disabled");
                Site.showAlert(true, "error", error, ajax_error);
            }
        });
    },

    /**
     *  取得丟近來參數的格式
     *
     *  @param {any} obj
     *  @returns {string}
     */
    getType : function(obj) {
        return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
    },

    /**
     *  錯誤顯示 fancybox
     *
     *  @param {Boolean} block true：點擊框外可以關閉，false：lock
     *  @param {string} type (success | info | warning | error)
     *  @param {string} title 錯誤標題
     *  @param {string} str 錯誤訊息
     *  @param {obj || string} obj 如果是物件，close 之後 focus，如果是 string，則處理相對應事情
     *  @param {string} url
     */
    showAlert : function(block, type, title, str, obj, url) {

        // console.log("WeCan : showAlert", arguments);

        // ele = str.split("<br>");
        // maxLength = Math.max.apply(Math, $.map(ele, function(el) {return el.length}));
        // width = maxLength * 14;
        if (type === "warning") {
            color = "#c29d0b";
        } else if (type === "success") {
            color = "#27A4AC";
        } else if (type === "info") {
            color = "#327ad5";
        } else if (type === "error") {
            color = "#e73d4a";
        }

        box = '<div class="modal-dialog" style="margin:0px auto;"><div class="modal-content"><div class="modal-header"><button type="button" class="close" aria-hidden="true" onclick="$.fancybox.close(true);"></button><h4 class="modal-title">' + title + '</h4></div><div class="modal-body" style="color:' + color + ';">' + str + '</div><div class="modal-footer"><button type="button" class="btn dark btn-outline" onclick="$.fancybox.close(true);">' + close + '</button></div></div></div>';
        // box = '<div class="error_box" style="color:#ff0000;text-align:center;font-size:14px;font-family:微軟正黑體;margin:35px auto;width:' + width + 'px;">' + str + '</div>';
        $.fancybox(box, {
            closeBtn : false,
            beforeShow : function(){
                $(".fancybox-skin").css({
                    "backgroundColor" : "transparent",
                    "box-shadow" : "none"
                });
                $.fancybox.update();
            },
            helpers : {
                overlay : {closeClick : block}
            },
            afterClose : function(){
                // ToDo
                if(Site.getType(obj) === 'object'){
                    obj.focus();
                }else if(Site.getType(obj) === 'string'){
                    if(obj === 'success'){
                        top.location.href = url;
                    }else if(obj === 'reload'){
                        location.reload();
                    }
                }
            }
        });
    }
};

