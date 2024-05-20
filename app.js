const express = require("express");
const app = express();
const cookieParser = require("cookie-parser");

const userRoute = require("./app/routes/userRoute");
const kanbanRoute = require("./app/routes/kanbanRoute.js");
// const authRoute = require("./app/routes/authRoute");

// Set up middleware
app.use("/public", express.static("public"));
app.use(express.urlencoded({ extended: true }));
app.use(cookieParser());

// Set up routes
app.use("/users", userRoute);
app.use("/kanban", kanbanRoute);

// link domain /users

// app.use("/auth", authRoute);

// Start the server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
