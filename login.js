const firebaseConfig = {
    apiKey: "AIzaSyBicDgvLYUzix2DDs_izbrl5jjw5ze4vQw",
    authDomain: "project-01-49410.firebaseapp.com",
    projectId: "project-01-49410",
    storageBucket: "project-01-49410.appspot.com",
    messagingSenderId: "441485955692",
    appId: "1:441485955692:web:4c133752f7a1575188be49"
  };
firebase.initializeApp(firebaseConfig);
const auth = firebase.auth();

const db = firebase.firestore();
db.settings({ timestampsInSnapshots: true });

document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    var user = document.getElementById("user").value;
    var password = document.getElementById("password").value;

    const query = db.collection('users').where("user", "==", user).where("password", "==", password);
    query.get().then((snapshot) => {
        if(snapshot.empty){
            console.log("invalid credentials");
        } else {
            window.location = "index.html";
        }
    });
});
