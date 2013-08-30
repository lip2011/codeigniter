window.App = {};
App.User = Spine.Model.sub();
App.User.configure('User', 'id', 'email', 'name', 'login_name', 'passwd', 'password_confirm', 'sex', 'status');
