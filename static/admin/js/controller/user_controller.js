User = App.User

$(document).ready(function(){
    new UserController();
})

var UserController = Spine.Controller.sub({
    init: function(){
        User.bind("refresh", this.user_refresh);
        App.User.refresh(userList, {clear: true});
    },

    user_refresh: function() {
        var records = User.all()
        var template = Handlebars.compile($('#user_list_script').html());
        var html = template({collection: records});
        $('#user_tbody').html(html);

        template = Handlebars.compile($('#userlist_pager_script').html());
        html = template({pager: pager, pageIndexArray: pageIndexArray});
        $('#pagerDiv').html(html);
    },
});