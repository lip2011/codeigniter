(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  window.App || (window.App = {});

  $(document).ready(function() {
    return new App.UserController({
      el: $('div#usersDiv')
    });
  });

  App.UserController = (function(_super) {
    var User;

    __extends(UserController, _super);

    User = App.UserModel;

    function UserController() {
      this.userRefresh = __bind(this.userRefresh, this);
      UserController.__super__.constructor.apply(this, arguments);
      User.bind('refresh create', this.userRefresh);
      User.refresh(window.userList, {
        clear: true
      });
      this.setFormValidationRules();
      this.user = null;
    }

    UserController.prototype.elements = {
      '#user_list_script': 'user_list_script',
      '#userlist_pager_script': 'userlist_pager_script',
      '#user_pop_model': 'user_pop_model',
      '#user_form': 'user_form',
      'div#user_pop_model button#submitButton': 'submitButton'
    };

    UserController.prototype.events = {
      'click #add_user_link': 'showPopWindow'
    };

    UserController.prototype.userRefresh = function() {
      var html, records, template;
      records = User.all();
      template = Handlebars.compile(this.user_list_script.html());
      html = template({
        collection: records
      });
      $('#user_tbody').html(html);
      template = Handlebars.compile(this.userlist_pager_script.html());
      html = template(window.pager);
      return $('#pagerDiv').html(html);
    };

    UserController.prototype.showPopWindow = function(e) {
      var $node, dataOperation, id;
      this.user_form.data('validator').resetForm();
      $node = $(e.target);
      dataOperation = $node.data('operation');
      id = $node.data('gid');
      if (dataOperation === 'add_user') {
        $('#pop_title').html('添加用户');
        this.user_form.attr('action', UrlConfig.adminBaseUrl + '/user/create');
        this.user = new User;
        this.user.sex = 'b';
      } else {
        $('#pop_title').html('修改用户信息');
        this.user_form.attr('action', UrlConfig.adminBaseUrl + '/user/update');
        this.user = User.findByAttribute('id', id);
      }
      rivets.bind(this.user_form, {
        recode: this.user
      });
      this.user_pop_model.modal('show');
      return this.submitButton.bind('click', this.formSubmit);
    };

    UserController.prototype.hidePopWindow = function(e) {
      this.log("  hide pop window");
      return this.user_form.data('validator').resetForm();
    };

    UserController.prototype.setFormValidationRules = function() {
      return this.validation = this.user_form.validate({
        rules: {
          name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          passwd: {
            required: true
          },
          password_confirm: {
            required: true,
            equalTo: '#Password'
          }
        }
      });
    };

    UserController.prototype.formSubmit = function(e) {
      var user_form;
      console.log("formSubmit formSubmitformSubmit");
      console.log(this.user);
      user_form = $('#user_form');
      if (user_form.valid()) {
        return $.ajax({
          type: 'post',
          dataType: 'json',
          url: $(e.target).attr('action'),
          data: this.user.attributes(),
          success: function(response) {
            return window.loction.reload();
          },
          error: function() {
            alert('error');
            return this.user_pop_model.modal('hide');
          }
        });
      }
    };

    return UserController;

  })(Spine.Controller);

}).call(this);
