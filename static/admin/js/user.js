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
        var id = parseInt($(this).attr('data-gid'));

        if (dataOperation == 'add_user') {
            $('#pop_title').html('添加用户');
            $('#user_form').attr('action', UrlConfig.adminBaseUrl + '/user/create');

            var user = {name: '', login_name: '', email: ''};
            rivets.bind($('#user_form'), {recode: user});
        } else {
            $('#pop_title').html('修改用户信息');
            $('#user_form').attr('action', UrlConfig.adminBaseUrl + '/user/update');

            var user = userList[id];
            console.log(user);
            rivets.bind($('#user_form'), {recode: user});
        }

        $('#user_pop_model').modal('toggle');

   
        $('#user_form').validate({
            debug: true,
            rules: {
                name: {
                   required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                login_name: {
                   required: true,
                }
            },
            submitHandler: function(form) { 
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: UrlConfig.adminBaseUrl + '/user/create',
                    data: {},
                    success: function(){
                        $.user.showSuccess();
                        $('#user_pop_model').modal('hide');
                    },
                    error: function(){
                        alert("error");
                    }
                });
            }
        });

        $('#user_pop_model').on('hide', function(){
            $('#user_form').data('validator').resetForm();
        })
    });
})

// $.user = {

//     showSuccess: function() {
//         alert("success");
//     }
// }



//  http://stackoverflow.com/questions/122102/most-efficient-way-to-clone-an-object
// window.App = {}

// App.User = Spine.Model.sub();
// App.User.configure("User", "name", "age");

// App.User.refresh([{id: 1, name: 'a', age: '1'}, {id: 2, name: 'b', age: '2'}], {clear: true})

// App.User.first()
// App.User.findByAttribute('id', 1)
//  window.App || (window.App = {});

// App.User = Spine.Model.sub();
// App.User.configure("User", "name", "age");


// App.User.refresh([{id: 1, name: 'a', age: '1'}, {id: 2, name: 'b', age: '2'}], {clear: true})

// App.User.first()
// App.User.findByAttribute('id', 1)
