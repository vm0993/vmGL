import Velocity from "velocity-animate";

(function (cash) {
    "use strict";

    cash(".chat__chat-list")
        .children()
        .each(function () {
            cash(this).on("click", function () {
                Velocity(
                    cash(".chat__box").children("div:nth-child(2)"),
                    "fadeOut",
                    {
                        duration: 300,
                        complete: function (el) {
                            Velocity(
                                cash(".chat__box").children("div:nth-child(1)"),
                                "fadeIn",
                                {
                                    duration: 300,
                                    complete: function (el) {
                                        cash(el)
                                            .removeClass("hidden")
                                            .removeAttr("style");
                                    },
                                }
                            );
                        },
                    }
                );
            });
        });
})(cash);
