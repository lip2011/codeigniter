window.App ||= {}

$(document).ready ->
    App.UserCon = new App.UserController
        el: $('div#usersDiv')

class App.UserController extends Spine.Controller

    User = App.UserModel
    
    constructor: ->
        super
        User.bind('refresh create', @userRefresh)
        User.refresh(window.userList, {clear: true})
        @setFormValidationRules()
        @user = null

    elements:
        '#user_list_script': 'user_list_script'
        '#userlist_pager_script': 'userlist_pager_script'
        '#user_pop_model': 'user_pop_model'
        '#user_form': 'user_form'

    events:
        'click #add_user_link': 'showPopWindow'
        'hidden div#user_pop_model': 'hidePopWindow'
        'click #submitButton': 'formSubmit'

    userRefresh: =>
        records = User.all()
        console.log records     
        template = Handlebars.compile(@user_list_script.html())
        html = template({collection: records})
        $('#user_tbody').html(html)

        template = Handlebars.compile(@userlist_pager_script.html())
        html = template(window.pager)
        $('#pagerDiv').html(html)

    showPopWindow: (e)->
        @log "  show pop window"
        @user_form.data('validator').resetForm()

        $node = $(e.target)
        dataOperation = $node.data('operation')
        id = $node.data('gid')

        if dataOperation == 'add_user'
            $('#pop_title').html('添加用户')
            @user_form.attr('action', UrlConfig.adminBaseUrl + '/user/create')

            @user = new User
            @user.sex = 'b'
        else 
            $('#pop_title').html('修改用户信息')
            @user_form.attr('action', UrlConfig.adminBaseUrl + '/user/update')

            @user = User.findByAttribute('id', id)

        rivets.bind(@user_form, {recode: @user})
        @user_pop_model.modal('show')

    hidePopWindow: (e)->
        @log "  hide pop window"
        @user_form.data('validator').resetForm()
        #@validation.resetForm()

    setFormValidationRules: ->
        @validation = @user_form.validate
            rules:
                name:
                    required: true
                email:
                    required: true
                    email: true
                passwd:
                    required: true
                password_confirm:
                    required: true
                    #Password is a id
                    equalTo: '#Password'

    formSubmit: (e) ->

        if @user_form.valid()
            $.ajax
                type: 'post'
                dataType: 'json'
                url: $(e.target).attr()
                data: @user.attributes('action')
                success: (response) ->
                    @user_pop_model.modal('hide')
                    
                    #User.create(response)
                error: ->
                    alert 'error'