// version 1
// const express = require('express');
// const app = express();
// const admin = require('firebase-admin');

// admin.initializeApp({
//   credential: admin.credential.cert('key/serviceAccountKey.json'),
//   databaseURL: 'https://project-01-49410.firebaseio.com'
// });

// async function verifyToken(token) {
//   try {
//     const decodedToken = await admin.auth().verifyIdToken(token);
//     return decodedToken.uid;
//   } catch (error) {
//     console.error('Error verifying token:', error);
//     return null;
//   }
// }

// // Route handler for '/login.html'
// app.get('/login.html', async (req, res) => {
//   const token = req.headers.authorization.split(' ')[1]; 
//   if (!token) {
//     return res.status(401).json({ message: 'Unauthorized' });
//   }

//   const userId = await verifyToken(token);
//   if (userId) {
//     res.redirect('/index.html');
//   } else {
//     res.status(401).json({ message: 'Unauthorized' });
//   }
// });

// app.get('/', (req, res) => {
//   res.redirect('/login.html');
// });

// // Start the Express app
// const PORT = process.env.PORT || 3001;
// app.listen(PORT, () => {
//   console.log(`Server is running on port ${PORT}`);
// });

// version 2
// const express = require('express');
// const app = express();
// const admin = require('firebase-admin');

// admin.initializeApp({
//   credential: admin.credential.cert('key/serviceAccountKey.json'),
//   databaseURL: 'https://project-01-49410.firebaseio.com'
// });

// // Serve static files from the public directory
// app.use(express.static('public'));

// // Handle form submission
// app.post('/login', async (req, res) => {
//   const { email, password } = req.body;

//   try {
//     // Sign in the user with Firebase Authentication
//     const userCredential = await admin.auth().signInWithEmailAndPassword(email, password);
//     const user = userCredential.user;
    
//     // Redirect to the dashboard or any other authenticated route
//     res.redirect('/index.html');
//   } catch (error) {
//     // Handle authentication errors
//     console.error('Error signing in:', error);
//     res.redirect('/login.html');
//   }
// });

// // Start the Express app
// const PORT = process.env.PORT || 3000;
// app.listen(PORT, () => {
//   console.log(`Server is running on port ${PORT}`);
// });


// version 3
// const express = require('express');
// const app = express();
// const admin = require('firebase-admin');
// const path = require('path');

// // Initialize Firebase Admin SDK
// admin.initializeApp({
//   credential: admin.credential.cert('key/serviceAccountKey.json'),
//   databaseURL: 'https://project-01-49410.firebaseio.com'
// });

// app.use(express.static(path.join(__dirname, 'public')));

// // Redirect root URL to login.html
// app.get('/', (req, res) => {
//   res.redirect('/login.html');
// });

// // Start the Express app
// const PORT = process.env.PORT || 3001;
// app.listen(PORT, () => {
//   console.log(`Server is running on port ${PORT}`);
// });

const express = require('express');
const app = express();
const admin = require('firebase-admin');
const path = require('path');

// Initialize Firebase Admin SDK
admin.initializeApp({
  credential: admin.credential.cert('serviceAccountKey.json'),
  databaseURL: 'https://project-01-494k10.firebaseio.com'
});

const db = admin.firestore();
db.settings({ timestampsInSnapshots: true });

app.use(express.static(path.join(__dirname, 'public')));
app.use('/node_modules', express.static(path.join(__dirname, 'node_modules')));
app.use(express.urlencoded())

// Redirect root URL to login.html
app.get('/', (req, res) => {
  res.sendFile(__dirname + '/frontend/login.html');
});

app.post('/login', async (req, res) => {
    const { user, password } = req.body;

    const query = db.collection('users').where("user", "==", user).where("password", "==", password);
    query.get().then((snapshot) => {
        if(snapshot.empty){
            res.send("invalid credentials\n<meta http-equiv='refresh' content='2; url=\"/\"'>");
            res.sendFile(__dirname + '/frontend/login.html');
        } else {
          res.sendFile(__dirname + '/frontend/test.html');
        }
    });
});

// Start the Express app
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
