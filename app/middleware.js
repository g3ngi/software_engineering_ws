const JWT = require("./util/jwt");

function AuthMiddleware(req, res, next) {
  token = req.cookies["token"];
  if (token == null) {
    res.redirect("/users");
  } else {
    jwt = new JWT();
    const resp = jwt.verify(token);
    if (resp == null) {
      res.redirect("/users");
    }
    next();
  }
}

function GuestMiddleware(req, res, next) {
  token = req.cookies["token"];
  if (token != null) {
    jwt = new JWT();
    const resp = jwt.verify(token);
    if (resp != null) {
      res.redirect("/kanban");
    }
    next();
  } else {
    next();
  }
}

module.exports = { AuthMiddleware, GuestMiddleware };
