import tippy, { roundArrow } from "tippy.js";

(function (cash) {
    "use strict";

    // Tooltips
    cash(".tooltip").each(function () {
        let options = {
            content: cash(this).attr("title"),
        };

        if (cash(this).data("trigger") !== undefined) {
            options.trigger = cash(this).data("trigger");
        }

        if (cash(this).data("placement") !== undefined) {
            options.placement = cash(this).data("placement");
        }

        if (cash(this).data("theme") !== undefined) {
            options.theme = cash(this).data("theme");
        }

        if (cash(this).data("tooltip-content") !== undefined) {
            options.content = cash(cash(this).data("tooltip-content"))[0];
        }

        cash(this).removeAttr("title");

        tippy(this, {
            arrow: roundArrow,
            animation: "shift-away",
            ...options,
        });
    });
})(cash);
