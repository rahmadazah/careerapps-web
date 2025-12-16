// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyBbcpR7BoAJjfVqTMdppHKnrzClUpg53HQ",
  authDomain: "career-apps.firebaseapp.com",
  databaseURL: "https://career-apps-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "career-apps",
  storageBucket: "career-apps.firebasestorage.app",
  messagingSenderId: "454132317752",
  appId: "1:454132317752:web:0a983397a6b5231c0770cd",
  measurementId: "G-LH6RPT8G8P"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);