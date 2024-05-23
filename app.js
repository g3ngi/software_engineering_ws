const express = require("express");
const app = express();
const cookieParser = require("cookie-parser");
const path = require("path");

const userRoute = require("./app/routes/userRoute");
const kanbanRoute = require("./app/routes/kanbanRoute.js");
// const authRoute = require("./app/routes/authRoute");

// serve static files
app.use("/public", express.static("public"));

app.set('views', path.join(__dirname, '../../public/views'));
app.set('view engine', 'ejs');

// Set up middleware
app.use(express.urlencoded({ extended: true }));
app.use(cookieParser());

// Set up routes
app.use("/users", userRoute);
app.use("/kanban", kanbanRoute);


// Start the server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
