(function() {
  var _ref,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  window.App || (window.App = {});

  App.UserModel = (function(_super) {
    __extends(UserModel, _super);

    function UserModel() {
      _ref = UserModel.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    UserModel.configure('UserModel', 'id', 'email', 'name', 'login_name', 'passwd', 'password_confirm', 'sex', 'status');

    return UserModel;

  })(Spine.Model);

}).call(this);
