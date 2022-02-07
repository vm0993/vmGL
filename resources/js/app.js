import "./bootstrap";
import "./tw-starter";
import "./chart";
import "./highlight";
import "./feather";
import "./tiny-slider";
import "./tippy";
import "./datepicker";
import "./tom-select";
import "./dropzone";
import "./ckeditor";
import "./validation";
import "./zoom";
import "./notification";
import "./tabulator";
import "./calendar";

/*
 |--------------------------------------------------------------------------
 | Components
 |--------------------------------------------------------------------------
 |
 | Import JS components.
 |
 */
import "./show-modal";
import "./show-slide-over";
import "./show-dropdown";
import "./search";
import "./side-menu";
import "./mobile-menu";
import "./side-menu-tooltip";
import "./dark-mode-switcher";

import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyCnafLoP6CL88SvkLgJgJbUml5neqw8nZ8",
    authDomain: "vima-bd211.firebaseapp.com",
    projectId: "vima-bd211",
    storageBucket: "vima-bd211.appspot.com",
    messagingSenderId: "222590297930",
    appId: "1:222590297930:web:f0d9c061b5d193b1d583b3",
    measurementId: "G-P93LVXNNMM"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

