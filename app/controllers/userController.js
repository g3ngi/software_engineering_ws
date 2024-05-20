const User = require("../models/User.js");
const JWT = require("../util/jwt.js");

async function loginHandler(username, password, res) {
  if (username != null || password != null) {
    const user = new User(username, password);
    const resp = await user.login();
    if (resp) {
      user_data = resp[0];
      obj = new JWT();
      token = obj.sign(user_data["user"]);
      res.cookie("token", token);
      res.redirect("/kanban");
    } else {
      res.send(
        "invalid credentials\n<meta http-equiv='refresh' content='2; url=\"/users\"'>"
      );
    }
  }
}

module.exports = { loginHandler };
