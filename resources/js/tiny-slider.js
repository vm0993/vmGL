import { tns } from "tiny-slider/src/tiny-slider";

(function (cash) {
    "use strict";

    // Tiny Slider
    if (cash(".tiny-slider").length) {
        cash(".tiny-slider").each(function () {
            this.tns = tns({
                container: this,
                slideBy: "page",
                mouseDrag: true,
                autoplay: true,
                controls: false,
                nav: false,
                speed: 500,
            });
        });
    }

    if (cash(".tiny-slider-navigator").length) {
        cash(".tiny-slider-navigator").each(function () {
            cash(this).on("click", function () {
                if (cash(this).data("target") == "prev") {
                    cash("#" + cash(this).data("carousel"))[0].tns.goTo("prev");
                } else {
                    cash("#" + cash(this).data("carousel"))[0].tns.goTo("next");
                }
            });
        });
    }

    // Slider widget page
    if (cash(".single-item").length) {
        cash(".single-item").each(function () {
            tns({
                container: this,
                slideBy: "page",
                mouseDrag: true,
                autoplay: false,
                controls: true,
                nav: false,
                speed: 500,
            });
        });
    }

    if (cash(".multiple-items").length) {
        cash(".multiple-items").each(function () {
            tns({
                container: this,
                slideBy: "page",
                mouseDrag: true,
                autoplay: false,
                controls: true,
                items: 1,
                nav: false,
                speed: 500,
                responsive: {
                    600: {
                        items: 3,
                    },
                    480: {
                        items: 2,
                    },
                },
            });
        });
    }

    if (cash(".responsive-mode").length) {
        cash(".responsive-mode").each(function () {
            tns({
                container: this,
                slideBy: "page",
                mouseDrag: true,
                autoplay: false,
                controls: true,
                items: 1,
                nav: true,
                speed: 500,
                responsive: {
                    600: {
                        items: 3,
                    },
                    480: {
                        items: 2,
                    },
                },
            });
        });
    }

    if (cash(".center-mode").length) {
        cash(".center-mode").each(function () {
            tns({
                container: this,
                mouseDrag: true,
                autoplay: false,
                controls: true,
                center: true,
                items: 1,
                nav: false,
                speed: 500,
                responsive: {
                    600: {
                        items: 2,
                    },
                },
            });
        });
    }

    if (cash(".fade-mode").length) {
        cash(".fade-mode").each(function () {
            tns({
                mode: "gallery",
                container: this,
                slideBy: "page",
                mouseDrag: true,
                autoplay: true,
                controls: true,
                nav: true,
                speed: 500,
            });
        });
    }
})(cash);
