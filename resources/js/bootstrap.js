// Load plugins
import cash from "cash-dom";
import axios from "axios";
import helper from "./helper";
import Velocity from "velocity-animate";
import * as Popper from "@popperjs/core";
import IMask from 'imask';
import TomSelect from 'tom-select';

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

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

const PUSHER_KEY = process.env.MIX_PUSHER_APP_KEY;

let momentFormat = 'DD-MM-YYYY';
let element = document.querySelectorAll('.date');
element.forEach(element => {
    let m = new IMask(element, {
        mask: Date,
        pattern: 'd`-m`-00000',
        lazy: false,
    });
});

let currMask = document.querySelectorAll('.amount');
currMask.forEach(currMask => {
    let y = new IMask(currMask, {
        mask: [
            { mask: '' },
            {
                mask: 'num',
                lazy: false,
                blocks: {
                    num: {
                        mask: Number,
                        scale: 2,
                        thousandsSeparator: '.',
                        padFractionalZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                    }
                }
            }
        ]
    });
});

let selectOption = document.querySelectorAll('.tom-select');
selectOption.forEach(element => {
    let opt = new TomSelect(selectOption, {
        allowEmptyOption: false
    });
});