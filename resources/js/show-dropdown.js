(function (cash) {
    "use strict";

    // Show dropdown
    cash("#programmatically-show-dropdown").on("click", function () {
        cash("#programmatically-dropdown").dropdown("show");
    });

    // Hide dropdown
    cash("#programmatically-hide-dropdown").on("click", function () {
        cash("#programmatically-dropdown").dropdown("hide");
    });

    // Toggle dropdown
    cash("#programmatically-toggle-dropdown").on("click", function () {
        cash("#programmatically-dropdown").dropdown("toggle");
    });
})(cash);
