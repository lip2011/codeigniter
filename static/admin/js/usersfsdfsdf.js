// window.App = {};
// App.User = Spine.Model.sub();
// App.User.configure('User', 'id', 'email', 'name', 'login_name', 'passwd', 'password_confirm', 'sex', 'status');


// App.User.bind('refresh', function(){
//     var records = App.User.all()
//     var template = Handlebars.compile($('#user_list_script').html());
//     var html = template({collection: records});
//     $('#user_tbody').html(html);
// })

var oldPage = '1';

$().ready(function(){

    //设置验证规则,根据“name”属性来验证
    $('#login_form').validate({
        errorClass: "error error-line",
        rules: {
            password: {
               required: true,
            },
            email: {
                required: true,
                email: true
            },
        },
        //配置错误提示信息
        messages: {
            email: {
                required: "邮件地址不能为空",
                email: "邮件地址无效"
            },
            password: {
                required: "密码不能为空"
            }
        },
    });


    /* *******************  使用handlebars *******************/
    // $('#add_user_link, #user_table a').on('click', function(){
    //     var dataOperation = $(this).attr('data-operation');
    //     var id = $(this).attr('data-gid');
    //     var name = $(this).attr('data-gname');
    //     var email = $(this).attr('data-gemail');
    //     var loginname = $(this).attr('data-gloginname');
    //     var status = $(this).attr('data-gstatus');

        
    //     var source = $('#pop_user_script').html();
    //     var template = Handlebars.compile(source);
    //     var collection = {
    //                         id: id,
    //                         name: name,
    //                         email: email,
    //                         loginname: loginname,
    //                         status: status,
    //                         dataOperation: dataOperation
    //                     }
    //     var html = template(collection);
    //     $('#modal_body').html(html);

    //     if (dataOperation == 'add_user') {
    //         $('#myModalLabel').html('添加用户');
    //         $('#user_form').attr('action', UrlConfig.adminBaseUrl + '/user/addUser');
    //     } else {
    //         $('#myModalLabel').html('修改用户信息');
    //         $('#user_form').attr('action', UrlConfig.adminBaseUrl + '/user/editUser');
    //     }

    //     $('#user_pop_model').modal('toggle');

        
    //     $('#user_form').validate({
    //         rules: {
    //             name: {
    //                required: true,
    //             },
    //             email: {
    //                 required: true,
    //                 email: true
    //             },
    //             login_name: {
    //                required: true,
    //             }
    //         },
    //         //配置错误提示信息
    //         messages: {
    //             email: {
    //                 required: "邮件地址不能为空",
    //                 email: "邮件地址无效"
    //             },
    //             name: {
    //                 required: "姓名不能为空"
    //             },
    //             login_name: {
    //                 required: "登陆名不能为空"
    //             }
    //         }
    //     });
    // });

    // $('#user_pop_model').on('hide', function(){
    //     $('#modal_body').html('');
    //     $('#myModalLabel').html('');
    // });


    /************  使用databind  *******************/

    $('#add_user_link, #user_table a').on('click', function(){
        var dataOperation = $(this).attr('data-operation');
        var id = $(this).attr('data-gid');
        var user = null;

        if (dataOperation == 'add_user') {
            $('#pop_title').html('添加用户');
            $('#user_form').attr('action', UrlConfig.adminBaseUrl + '/user/create');

            user = new App.User;
            user.sex = 'b';
        } else {
            $('#pop_title').html('修改用户信息');
            $('#user_form').attr('action', UrlConfig.adminBaseUrl + '/user/update');

            user = App.User.findByAttribute('id', id);
        }
        console.log(user);
        rivets.bind($('#user_form'), {recode: user});

        $('#user_pop_model').modal('toggle');

        $('#user_form').validate({
            rules: {
                name: {
                   required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                passwd: {
                   required: true,
                },
                password_confirm: {
                   required: true,
                   //Password is a id
                   equalTo: '#Password'
                }
            },
            submitHandler: function(form) { 
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: UrlConfig.adminBaseUrl + '/user/create',
                    data: user.attributes(),
                    success: function(){
                        //$.user.showSuccess();
                        $('#user_pop_model').modal('hide');
                        window.location.reload();
                    },
                    error: function(){
                        alert("error");
                    }
                });
            }
        });

        $('#user_pop_model').on('hide', function(){
            $('#user_form').data('validator').resetForm();
        });
    });

    $('#pagerDiv li a').on('click', function(){
        var page = $(this).parent('li').data('page');

        $.user.getUserListByPage(page);
    });
    
    //App.User.refresh(userList, {clear: true});
   
})

$.user = {

    getUserListByPage: function(page) {
        //oldPage = page;
        alert(oldPage);
                $("#pagerDiv li[data-page='"+page+"']").addClass('active disabled');
                $("#pagerDiv li[data-page='"+oldPage+"']").removeClass('active disabled');

        // $.ajax({
        //     type: 'post',
        //     dataType: 'json',
        //     url: UrlConfig.adminBaseUrl + '/user/getUserListByPage',
        //     data: {page: page},
        //     success: function(response){
        //         alert("get success");
                
        //         App.User.refresh(response, {clear: true})

        //         //$('#user_table').html(html);
        //     },
        //     error: function(){
        //         alert("get error");
        //     }
        // });
    },
}