import tippy, { roundArrow } from "tippy.js";

(function (cash) {
    "use strict";

    // Side menu tooltips
    let initTooltips = (function tooltips() {
        cash(".side-menu").each(function () {
            if (this._tippy == undefined) {
                let content = cash(this)
                    .find(".side-menu__title")
                    .html()
                    .replace(/<[^>]*>?/gm, "")
                    .trim();
                tippy(this, {
                    content: content,
                    arrow: roundArrow,
                    animation: "shift-away",
                    placement: "right",
                });
            }

            if (
                cash(window).width() <= 1260 ||
                cash(this).closest(".side-nav").hasClass("side-nav--simple")
            ) {
                this._tippy.enable();
            } else {
                this._tippy.disable();
            }
        });

        return tooltips;
    })();

    window.addEventListener("resize", () => {
        initTooltips();
    });
})(cash);
