window.App ||= {}

$(document).ready ->
    App.user_popWindow_ctrl = new App.UserPopWindowCtrl
        el: $('#user_pop_model')

    App.user_index_ctrl = new App.UserIndexCtrl
        el: $('div#usersDiv')
        popModalCtrl: App.user_popWindow_ctrl

class App.UserIndexCtrl extends Spine.Controller

    UserModle = App.User
    
    constructor: ->
        @popModalCtrl = null
        super
        UserModle.bind('refresh create', @userRefresh)
        UserModle.refresh(window.userList, {clear: true})

    elements:
        '#user_list_script': 'user_list_script'
        '#userlist_pager_script': 'userlist_pager_script'
        '#userListDiv': 'userListDiv'

    events:
        'click #add_user_link, #edit_user_link': 'showPopWindow'
        'click div#pagination a': 'getNextOrPreUsers'

    userRefresh: =>
        records = UserModle.all()
        template = Handlebars.compile(@user_list_script.html())
        html = template({collection: records})

        Handlebars.registerHelper "getStatusName", (userStatus) ->
            statusName = ""
            if userStatus is 1
                statusName = "活跃"
            else
                statusName = "冻结"
            statusName
        $('#user_tbody').html(html)

        template = Handlebars.compile(@userlist_pager_script.html())
        html = template(window.pager)
        $('#pagerDiv').html(html)

    showPopWindow: (event) ->
        @popModalCtrl.showPopWindow(event)

    getNextOrPreUsers: (e) ->
        @log $(e.target)
        @log $(e.target).parents('li').data('page')

        @userListDiv.isLoading
            text: 'Loading...'
            position: 'overlay'

        page = $(e.target).parents('li').data('page')
        $.ajax
            type: 'post'
            dataType: 'json'
            url: UrlConfig.adminBaseUrl + '/user/getNextOrPrePageUsers'
            data: {page: page}
            success: (response, textStatus, xhr) ->
                window.userList = response.userList
                window.pager = response.pager
                UserModle.refresh(window.userList, {clear: true})
                setTimeout (->
                    $('#userListDiv').isLoading "hide"
                ), 1000

class App.UserPopWindowCtrl extends Spine.Controller

    UserModle = App.User

    constructor: ->
        super
        @user = null
        @dataOperation = ''
        @userIndex = ''
        @setFormValidationRules()

    elements:
        '#user_form': 'user_form'
        'button#submitButton': 'submitButton'

    events:
        'hide': 'hidePopWindow'
        'click button#submitButton': 'formSubmit'

    showPopWindow: (event) ->
        @log "UserPopWindowCtrl showPopWindow"
        # console.log $._data($(event.target)[0], 'events')

        $node = $(event.target)
        @dataOperation = $node.data('operation')
        @userIndex = $node.data('index')
        id = String($node.data('gid'))

        if @dataOperation == 'add_user'
            $('#pop_title').html('添加用户')
            @user_form.attr('action', UrlConfig.adminBaseUrl + '/user/create')

            @user = new UserModle
            @user.sex = 'b'
        else 
            $('#pop_title').html('修改用户信息')
            @user_form.attr('action', UrlConfig.adminBaseUrl + '/user/update')

            @user = UserModle.findByAttribute('id', id)

        rivets.bind(@user_form, {recode: @user})
        @el.modal('show')

    hidePopWindow: ->
        @log "  hide pop window"
        @user_form.data('validator').resetForm()
        $('#messageDiv').hide()
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
        console.log "formSubmit formSubmitformSubmit"
        console.log $(e.target)

        url = $(e.target).parents('form').attr('action')
        if @user_form.valid()
            $.ajax
                type: 'post'
                dataType: 'json'
                url: url
                data: @user.attributes()
                success: (response, textStatus, xhr) =>
                    console.log '----------'
                    # console.log response
                    # console.log textStatus
                    # console.log xhr
                    if (@dataOperation == 'add_user')
                        alert 'add success'
                        window.location.reload()
                    else
                        @log 'update success'

                        window.userList[@userIndex] = @user
                        UserModle.refresh(window.userList, {clear: true})
                        @el.modal('hide')
                error: ->
                    $('#messageDiv').show()