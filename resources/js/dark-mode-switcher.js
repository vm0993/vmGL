(function (cash) {
    "use strict";

    // Copy original code
    cash(".dark-mode-switcher").on("click", function () {
        let switcher = cash(this).find(".dark-mode-switcher__toggle");
        if (cash(switcher).hasClass("dark-mode-switcher__toggle--active")) {
            cash(switcher).removeClass("dark-mode-switcher__toggle--active");
        } else {
            cash(switcher).addClass("dark-mode-switcher__toggle--active");
        }

        setTimeout(() => {
            let link = cash(".dark-mode-switcher").data("url");
            window.location.href = link;
        }, 500);
    });
})(cash);
