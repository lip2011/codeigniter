(function() {
  var UserCtrl, a, _ref,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  alert("aaaaaa");

  a = 1;

  $().ready(function() {
    return alert("hahahaha");
  });

  UserCtrl = (function(_super) {
    __extends(UserCtrl, _super);

    function UserCtrl() {
      _ref = UserCtrl.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    return UserCtrl;

  })(Spine.Controller);

}).call(this);
