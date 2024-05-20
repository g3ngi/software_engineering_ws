const jwt = require("jsonwebtoken");

const SECRET = "hello_world";

class JWT {
  sign(id) {
    const token = jwt.sign({ username: id }, SECRET);
    console.log(token);
    return token;
  }

  verify(token) {
    try {
      const resp = jwt.verify(token, SECRET);
      return resp;
    } catch (error) {
      return null;
    }
  }
}

module.exports = JWT;
