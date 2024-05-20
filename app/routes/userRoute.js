const express = require("express");
const app = express();
const admin = require("firebase-admin");
const path = require("path");
const { GuestMiddleware } = require("../middleware");
const { loginHandler } = require(path.join(
  __dirname,
  "../controllers/userController"
));

// Redirect root URL to login.html
// link domain /users
app.use(GuestMiddleware);

app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "../../public/views/login.html"));
});

app.post("/login", async (req, res) => {
  const { user, password } = req.body;
  await loginHandler(user, password, res);
});

module.exports = app;
