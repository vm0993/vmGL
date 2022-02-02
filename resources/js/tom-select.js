import TomSelect from "tom-select";

(function (cash) {
    "use strict";

    // Tom Select
    cash(".tom-select").each(function () {
        let options = {
            plugins: {
                dropdown_input: {},
            },
        };

        if (cash(this).data("placeholder")) {
            options.placeholder = cash(this).data("placeholder");
        }

        if (cash(this).attr("multiple") !== undefined) {
            options = {
                ...options,
                plugins: {
                    ...options.plugins,
                    remove_button: {
                        title: "Remove this item",
                    },
                },
                persist: false,
                create: true,
                onDelete: function (values) {
                    return confirm(
                        values.length > 1
                            ? "Are you sure you want to remove these " +
                                  values.length +
                                  " items?"
                            : 'Are you sure you want to remove "' +
                                  values[0] +
                                  '"?'
                    );
                },
            };
        }

        if (cash(this).data("header")) {
            options = {
                ...options,
                plugins: {
                    ...options.plugins,
                    dropdown_header: {
                        title: cash(this).data("header"),
                    },
                },
            };
        }

        new TomSelect(this, options);
    });
})(cash);
