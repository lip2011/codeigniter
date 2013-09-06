(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  window.App || (window.App = {});

  $(document).ready(function() {
    App.user_popWindow_ctrl = new App.UserPopWindowCtrl({
      el: $('#user_pop_model')
    });
    return App.user_index_ctrl = new App.UserIndexCtrl({
      el: $('div#usersDiv'),
      popModalCtrl: App.user_popWindow_ctrl
    });
  });

  App.UserIndexCtrl = (function(_super) {
    var UserModle;

    __extends(UserIndexCtrl, _super);

    UserModle = App.User;

    function UserIndexCtrl() {
      this.userRefresh = __bind(this.userRefresh, this);
      this.popModalCtrl = null;
      UserIndexCtrl.__super__.constructor.apply(this, arguments);
      UserModle.bind('refresh create', this.userRefresh);
      UserModle.refresh(window.userList, {
        clear: true
      });
    }

    UserIndexCtrl.prototype.elements = {
      '#user_list_script': 'user_list_script',
      '#userlist_pager_script': 'userlist_pager_script'
    };

    UserIndexCtrl.prototype.events = {
      'click #add_user_link': 'showPopWindow',
      'click div#pagination a': 'getNextOrPreUsers'
    };

    UserIndexCtrl.prototype.userRefresh = function() {
      var html, records, template;
      records = UserModle.all();
      template = Handlebars.compile(this.user_list_script.html());
      html = template({
        collection: records
      });
      $('#user_tbody').html(html);
      template = Handlebars.compile(this.userlist_pager_script.html());
      html = template(window.pager);
      return $('#pagerDiv').html(html);
    };

    UserIndexCtrl.prototype.showPopWindow = function(event) {
      return this.popModalCtrl.showPopWindow(event);
    };

    UserIndexCtrl.prototype.getNextOrPreUsers = function(e) {
      var page;
      this.log($(e.target));
      this.log($(e.target).parents('li').data('page'));
      $.isLoading({
        text: "Loading"
      });
      page = $(e.target).parents('li').data('page');
      return $.ajax({
        type: 'post',
        dataType: 'json',
        url: UrlConfig.adminBaseUrl + '/user/getNextOrPrePageUsers',
        data: {
          page: page
        },
        success: function(response, textStatus, xhr) {
          window.userList = response.userList;
          window.pager = response.pager;
          UserModle.refresh(window.userList, {
            clear: true
          });
          return setTimeout((function() {
            return $.isLoading("hide");
          }), 2000);
        }
      });
    };

    return UserIndexCtrl;

  })(Spine.Controller);

  App.UserPopWindowCtrl = (function(_super) {
    var UserModle;

    __extends(UserPopWindowCtrl, _super);

    UserModle = App.User;

    function UserPopWindowCtrl() {
      UserPopWindowCtrl.__super__.constructor.apply(this, arguments);
      this.user = null;
      this.setFormValidationRules();
    }

    UserPopWindowCtrl.prototype.elements = {
      '#user_form': 'user_form',
      'button#submitButton': 'submitButton'
    };

    UserPopWindowCtrl.prototype.events = {
      'hide': 'hidePopWindow',
      'click button#submitButton': 'formSubmit'
    };

    UserPopWindowCtrl.prototype.showPopWindow = function(event) {
      var $node, dataOperation, id;
      this.log("UserPopWindowCtrl showPopWindow");
      console.log($._data($(event.target)[0], 'events'));
      $node = $(event.target);
      dataOperation = $node.data('operation');
      id = $node.data('gid');
      if (dataOperation === 'add_user') {
        $('#pop_title').html('添加用户');
        this.user_form.attr('action', UrlConfig.adminBaseUrl + '/user/create');
        this.user = new UserModle;
        this.user.sex = 'b';
      } else {
        $('#pop_title').html('修改用户信息');
        this.user_form.attr('action', UrlConfig.adminBaseUrl + '/user/update');
        this.user = UserModle.findByAttribute('id', id);
      }
      rivets.bind(this.user_form, {
        recode: this.user
      });
      return this.el.modal('show');
    };

    UserPopWindowCtrl.prototype.hidePopWindow = function() {
      this.log("  hide pop window");
      this.user_form.data('validator').resetForm();
      return $('#messageDiv').hide();
    };

    UserPopWindowCtrl.prototype.setFormValidationRules = function() {
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

    UserPopWindowCtrl.prototype.formSubmit = function(e) {
      var url;
      console.log("formSubmit formSubmitformSubmit");
      console.log($(e.target));
      url = $(e.target).parents('form').attr('action');
      if (this.user_form.valid()) {
        return $.ajax({
          type: 'post',
          dataType: 'json',
          url: url,
          data: this.user.attributes(),
          success: function(response, textStatus, xhr) {
            console.log('----------');
            console.log(response);
            console.log(textStatus);
            console.log(xhr);
            return window.location.reload();
          },
          error: function() {
            return $('#messageDiv').show();
          }
        });
      }
    };

    return UserPopWindowCtrl;

  })(Spine.Controller);

}).call(this);
