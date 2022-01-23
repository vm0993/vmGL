import Toastify from "toastify-js";

(function (cash) {
    "use strict";

    // Basic non sticky notification
    cash("#basic-non-sticky-notification-toggle").on("click", function () {
        Toastify({
            node: cash("#basic-non-sticky-notification-content")
                .clone()
                .removeClass("hidden")[0],
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });

    // Basic sticky notification
    cash("#basic-sticky-notification-toggle").on("click", function () {
        Toastify({
            node: cash("#basic-non-sticky-notification-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });

    // Success notification
    cash("#success-notification-toggle").on("click", function () {
        Toastify({
            node: cash("#success-notification-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });

    // Notification with actions
    cash("#notification-with-actions-toggle").on("click", function () {
        Toastify({
            node: cash("#notification-with-actions-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });

    // Notification with avatar
    cash("#notification-with-avatar-toggle").on("click", function () {
        // Init toastify
        let avatarNotification = Toastify({
            node: cash("#notification-with-avatar-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: false,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();

        // Close notification event
        cash(avatarNotification.toastElement)
            .find('[data-dismiss="notification"]')
            .on("click", function () {
                avatarNotification.hideToast();
            });
    });

    // Notification with split buttons
    cash("#notification-with-split-buttons-toggle").on("click", function () {
        // Init toastify
        let splitButtonsNotification = Toastify({
            node: cash("#notification-with-split-buttons-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: false,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();

        // Close notification event
        cash(splitButtonsNotification.toastElement)
            .find('[data-dismiss="notification"]')
            .on("click", function () {
                splitButtonsNotification.hideToast();
            });
    });

    // Notification with buttons below
    cash("#notification-with-buttons-below-toggle").on("click", function () {
        // Init toastify
        Toastify({
            node: cash("#notification-with-buttons-below-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });
})(cash);
