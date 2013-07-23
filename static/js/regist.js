$().ready(function(){
    $("#registForm").validationEngine("attach", {
        //"topRight", "bottomLeft", "centerRight", "bottomRight"
        promptPosition: "topRight",
        scroll: true,
        ajaxFormValidation: true,
        onAjaxFormComplete: ajaxValidationCallback,
    });


    function ajaxValidationCallback(status, form, json, options){
    // if (window.console) 
    //     console.log(status);
    
    // if (status === true) {
    //     alert("Ajax 验证通过");
    //     // uncomment these lines to submit the form to form.action
    //     // form.validationEngine('detach');
    //     // form.submit();
    //     // or you may use AJAX again to submit the data
    // }
    alert("valadate finish");
    }
});

(function($) {
    $.register = {
        regist: function() {
            $('#registForm').validationEngine('validate');
        }
    };
})(jQuery);

