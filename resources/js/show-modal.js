(function (cash) {
    "use strict";

    // Show modal
    cash("#programmatically-show-modal").on("click", function () {
        cash("#programmatically-modal").modal("show");
    });

    // Hide modal
    cash("#programmatically-hide-modal").on("click", function () {
        cash("#programmatically-modal").modal("hide");
    });

    // Toggle modal
    cash("#programmatically-toggle-modal").on("click", function () {
        cash("#programmatically-modal").modal("toggle");
    });
})(cash);
