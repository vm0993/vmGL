// Load plugins
import "./bootstrap";
import "./tw-starter";
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

import cash from "cash-dom";
import axios from "axios";
import helper from "./helper";
import Velocity from "velocity-animate";
import * as Popper from "@popperjs/core";
import Inputmask from "inputmask";
import TomSelect from "tom-select";

// Set plugins globally
window.cash = cash;
window.axios = axios;
window.helper = helper;
window.Velocity = Velocity;
window.Popper = Popper;
window.TomSelect = TomSelect;
window.Inputmask = Inputmask;

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
/* 
window.TomSelect = new TomSelect('#select-mitra',{
    valueField: 'url',
    labelField: 'name',
    searchField: 'name',
    // fetch remote data
    load: function(query, callback) {

        var url = "{{ url('kepesertaan/mitra') }}?code=" + encodeURIComponent(query);
        fetch(url)
            .then(response => response.json())
            .then(json => {
                callback(json.items);
            }).catch(()=>{
                callback();
            });

    },
    // custom rendering functions for options and items
    render: {
        option: function(item, escape) {
            return `<option value="${item.id}"> ${ escape(item.name) }</option>`;
        },
        item: function(item, escape) {
            return `<option value="${item.id}"> ${ escape(item.name) }</option>`;
        }
    },
}); */

window.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
        element.addEventListener('keyup', function(e) {
            let cursorPostion = this.selectionStart;
            let value = parseInt(this.value.replace(/[^,\d]/g, ''));
            let originalLenght = this.value.length;
            console.log(value);
            if (isNaN(value)) {
                this.value = "";
            } else {    
                this.value = value.toLocaleString('id-ID', {
                    currency: 'IDR',
                    style: 'currency',
                    minimumFractionDigits: 0
                });
                cursorPostion = this.value.length - originalLenght + cursorPostion;
                this.setSelectionRange(cursorPostion, cursorPostion);
            }
        });
    });
});

const PUSHER_KEY = process.env.MIX_PUSHER_APP_KEY;

const NOTIFICATION_TYPES = {
    submit: 'App\\Notifications\\\Advance\\RequestSubmitNotification',
};

var notifications = [];

var user_id = '{{ auth()->user()->id }}';
// check if there's a logged in user
//$(document).ready(function() {
    /* if(user_id) {
        // load notifications from database
        $.get(`/notifications`, function (data) {
            addNotifications(data, "#notifications");
        });

        // listen to notifications from pusher
        window.Echo.private(`App.Models.User.${user_id}`)
            .notification((notification) => {
                addNotifications([notification], '#notifications');
            });
    } */
//});

// add new notifications
function addNotifications(newNotifications, target) {
    notifications = _.concat(notifications, newNotifications);
    // show only last 5 notifications
    notifications.slice(0, 5);
    showNotifications(notifications, target);
}

// show notifications
function showNotifications(notifications, target) {
    if(notifications.length) {
        var htmlElements = notifications.map(function (notification) {
            return makeNotification(notification);
        });
        $(target + 'Menu').html(htmlElements.join(''));
        $(target).addClass('has-notifications')
    } /* else {
        $(target + 'Menu').html('<li class="dropdown-header">No notifications</li>');
        $(target).removeClass('has-notifications');
    } */
}

// create a notification li element
function makeNotification(notification) {
    var user = makeNotificationUser(notification);
    var notificationText = makeNotificationText(notification);
    return `<div class="cursor-pointer relative flex items-center ">
                <div class="w-12 h-12 flex-none image-fit mr-1">
                    <img alt="{{ env('APP_NAME') }}" class="rounded-full" src="{{ asset('images/default-avatar.jpg') }}">
                    <div class="w-3 h-3 bg-theme-20 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                </div>
                <div class="ml-2 overflow-hidden">
                    <div class="flex items-center">
                        <a href="javascript:void();" class="font-medium truncate mr-5">${user}</a>
                        <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">01:10 PM</div>
                    </div>
                    <div class="w-full truncate text-gray-600 mt-0.5">${notificationText}</div>
                </div>
            </div>`;
}

// get the notification route based on it's type
function routeNotification(notification) {
    var to = `?read=${notification.id}`;
    if(notification.type === NOTIFICATION_TYPES.submit) {
        to = 'users' + to;
    }
    return '/' + to;
}

// get the notification text based on it's type
function makeNotificationText(notification) {
    var text = '';
    if(notification.type === NOTIFICATION_TYPES.submit) {
        const body = notification.data.body;
        text += `${body}`;
    }
    return text;
}

// get the notification text based on it's type
function makeNotificationUser(notification) {
    var text = '';
    if(notification.type === NOTIFICATION_TYPES.submit) {
        const userName = notification.data.user_name;
        text += `<strong>${userName}</strong>`;
    }
    return text;
}
