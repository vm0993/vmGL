(function (cash) {
    "use strict";

    // Show slide over
    cash("#programmatically-show-slide-over").on("click", function () {
        cash("#programmatically-slide-over").modal("show");
    });

    // Hide slide over
    cash("#programmatically-hide-slide-over").on("click", function () {
        cash("#programmatically-slide-over").modal("hide");
    });

    // Toggle slide over
    cash("#programmatically-toggle-slide-over").on("click", function () {
        cash("#programmatically-slide-over").modal("toggle");
    });
})(cash);
