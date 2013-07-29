// $().ready(function(){
//     $("#registForm").validationEngine("attach", {
//         //"topRight", "bottomLeft", "centerRight", "bottomRight"
//         promptPosition: "topRight",
//         scroll: true,
//         ajaxFormValidation: true,
//         onAjaxFormComplete: ajaxValidationCallback,
//     });


$(document).ready(function(){

    $.validator.addMethod("phonecheck", function(value, element) {
        var string = value.match(/0(\d{2,2})-(\d{7,7})/ig);
        if(string != null){
            return true;
        }else{
            return false;
        }
    }, "telphone number like 021-1234567");


    $.validator.addMethod("phonesame", function(value, element) {
        var flag = 1;
        $.ajax({
            type: "POST",
            url: UrlConfig.baseUrl + "user/ajaxCheckPhone",
            dataType: "json",
            async: false,
            data: {phone: $('#inputPhoneNum').val()},
            success: function(response){
                if(response) {
                    flag = 0;
                }
            }
        });

        if(flag == 0) {
            return false;
        }
        else {
            return true;
        }
    }, "sorry number have been exist");


    //设置验证规则,根据“name”属性来验证
    $('#registForm').validate({
        //debug: true,

        rules: {
            password: {
               required: true,
            },
            email: {
                required: true,
                email: true,

                //自带ajax验证存在的方法,远程地址只能输出 "true" 或 "false"，不能有其它输出
                remote:{
                    url: UrlConfig.baseUrl + "user/ajaxCheckEmail",
                    type: "post",
                    dataType: "json",
                    //data里面可以自定义需要传递的参数
                    // data:{
                    //     flag:function(){return "aaa";}
                    // },
                }
            },
            phone: {
                required: true,
                phonecheck: true,
                phonesame: true
            },
            sex: {
                required: true
            },
            'hobby[]': {
                required: true
            },
            course: {
                required: true,
                rangelength: [2,5]
            }
        },
        //配置错误提示信息，可以加样式
        messages: {
            email: {
                required: "邮件地址不能为空",
                email: "邮件地址无效",
                remote: "此名称已被其他人使用"
            },
            password: {
                required: "密码不能为空",
            },
            phone: {
                required: "电话号码不能为空",
                phonecheck: "电话号码的格式应该例如021-1234567",
                phonesame: "电话号码已经存在"
            }
        },
        errorPlacement: function(error, element) {
            if ( element.is(":radio") ) {
                error.appendTo( element.parent() );
            }
            else if ( element.is(":checkbox") ) {
                error.appendTo ( element.parent() );
            }
            else {
                error.appendTo( element.parent());
            }
        }
    });

    /*********************************************** Handlebars **********************************************/
    //helper function
    Handlebars.registerHelper('fullName', function(person) {
        return person.firstName + " " + person.lastName;
    });

    //use "this"
    Handlebars.registerHelper('agree_button', function() {
        return "<button>I agree. I enjoy" + this.author.firstName + " and " + this.author.lastName + "</button>";
    });

    var source = $("#helperTest").html();
    var template = Handlebars.compile(source);
    var collection = {
                        author: {firstName: "Alan", lastName: "Johnson"},
                        body: "I Love Handlebars",
                        comments: [{
                            author: {firstName: "Yehuda", lastName: "Katz"},
                            body: "Me too!"
                        }]
                    }
    var html = template(collection);
    $('#userList').html(html);
});



(function($) {
    $.register = {
        getUserList: function() {
            $.ajax({
                method: "post",
                dataType: "json",
                url: UrlConfig.baseUrl + "user/ajaxGetUserList",
                success: function(response) {

                    var source = $("#entry-template").html();
                    var template = Handlebars.compile(source);

                    var html = template({collection: response});
                    $('#userList').html(html);
                }
            });
        }
    };
})(jQuery);