import Velocity from "velocity-animate";

(function (cash) {
    "use strict";

    // Show code or preview
    cash("body").on("change", ".show-code", function () {
        let elementId = cash(this).data("target");
        if (cash(this).is(":checked")) {
            cash(elementId).find(".preview").hide();
            Velocity(cash(elementId).find(".source-code"), "fadeIn");
        } else {
            Velocity(cash(elementId).find(".preview"), "fadeIn");
            cash(elementId).find(".source-code").hide();
        }
    });
})(cash);
