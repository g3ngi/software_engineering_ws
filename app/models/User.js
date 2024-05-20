const admin = require("firebase-admin");
admin.initializeApp({
  credential: admin.credential.cert("serviceAccountKey.json"),
  databaseURL: "https://project-01-494k10.firebaseio.com",
});

const db = admin.firestore();

db.settings({ timestampsInSnapshots: true });

class User {
  constructor(username, password) {
    this.username = username;
    this.password = password;
  }

  // async = real time, await = nunggu respond
  async login() {
    // belum tau ini komunikasi ke firestore secure atau engga
    const query = db
      .collection("users")
      .where("user", "==", this.username)
      .where("password", "==", this.password);
    const snapshot = await query.get();
    if (snapshot.empty) {
      return null;
    } else {
      return snapshot.docs.map((doc) => doc.data());
    }

    // db.collection("users")
    //   .get()
    //   .then((querySnapshot) => {
    //     console.log(querySnapshot);
    //     console.log(querySnapshot.empty);
    //     querySnapshot.forEach((doc) => {
    //       console.log(doc);
    //       // doc.data() is never undefined for query doc snapshots
    //       console.log(doc.id, " => ", doc.data());
    //     });
    //   });
  }
}

module.exports = User;
