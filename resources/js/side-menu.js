import Velocity from "velocity-animate";

(function (cash) {
    "use strict";

    // Side Menu
    cash(".side-menu").on("click", function () {
        if (cash(this).parent().find("ul").length) {
            if (
                cash(this).parent().find("ul").first()[0].offsetParent !== null
            ) {
                cash(this)
                    .find(".side-menu__sub-icon")
                    .removeClass("transform rotate-180");
                cash(this).removeClass("side-menu--open");
                Velocity(cash(this).parent().find("ul").first(), "slideUp", {
                    duration: 300,
                    complete: function (el) {
                        cash(el).removeClass("side-menu__sub-open");
                    },
                });
            } else {
                cash(this)
                    .find(".side-menu__sub-icon")
                    .addClass("transform rotate-180");
                cash(this).addClass("side-menu--open");
                Velocity(cash(this).parent().find("ul").first(), "slideDown", {
                    duration: 300,
                    complete: function (el) {
                        cash(el).addClass("side-menu__sub-open");
                    },
                });
            }
        }
    });
})(cash);
