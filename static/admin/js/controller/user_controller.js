User = App.User

$(document).ready(function(){
    new UserController({
        el: $('div#usersDiv')
    });
})


var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

var UserController = Spine.Controller.sub({

    elements: {"#user_list_script": "user_list_script"},


    events: {"click #add_user_link": "clickEvent"},

    init: function(){
        this.user_refresh = __bind(this.user_refresh, this);

        User.bind("refresh", this.user_refresh);
        App.User.refresh(userList, {clear: true});

        
    },

    user_refresh: function(){
        console.log(this.user_list_script)

        var records = User.all()
        var template = Handlebars.compile(this.user_list_script.html());
        var html = template({collection: records});
        $('#user_tbody').html(html);

        template = Handlebars.compile($('#userlist_pager_script').html());
        html = template(pager);
        $('#pagerDiv').html(html);
    },

    clickEvent: function(){
        alert("aaaaaaaa");
    },
});