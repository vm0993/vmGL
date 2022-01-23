// Load plugins
import cash from "cash-dom";
import axios from "axios";
import helper from "./helper";
import Velocity from "velocity-animate";
import * as Popper from "@popperjs/core";

// Set plugins globally
window.cash = cash;
window.axios = axios;
window.helper = helper;
window.Velocity = Velocity;
window.Popper = Popper;

// CSRF token
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}
