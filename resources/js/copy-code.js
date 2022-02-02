import Toastify from "toastify-js";

(function (cash) {
    "use strict";

    // Copy original code
    cash("body").on("click", ".copy-code", function () {
        let elementId = cash(this).data("target");
        cash(elementId).find("textarea")[0].select();
        cash(elementId).find("textarea")[0].setSelectionRange(0, 99999);
        document.execCommand("copy");

        Toastify({
            text: "Copied!",
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            className: "toastify-content",
        }).showToast();
    });
})(cash);
