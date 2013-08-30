User = App.User

$(document).ready(function(){
    new UserController();
})

var UserController = Spine.Controller.sub({
    init: function(){
        User.bind("refresh", this.user_refresh);
    },

    user_refresh: function() {
        var records = User.all()
        var template = Handlebars.compile($('#user_list_script').html());
        var html = template({collection: records});
        $('#user_tbody').html(html);
    },
});