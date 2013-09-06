window.App ||= {}

class App.User extends Spine.Model
    @configure('UserModel', 'id', 'email', 'name', 'login_name', 'passwd', 'password_confirm', 'sex', 'status')