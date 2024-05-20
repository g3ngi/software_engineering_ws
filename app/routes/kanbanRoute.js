const express = require("express");
const app = express();
const path = require("path");
const { AuthMiddleware } = require("../middleware.js");

app.use(AuthMiddleware);

app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "../../public/views/kanban.html"));
});

module.exports = app;
