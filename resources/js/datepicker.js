import dayjs from "dayjs";
import Litepicker from "litepicker";

(function (cash) {
    "use strict";

    // Litepicker
    cash(".datepicker").each(function () {
        let options = {
            autoApply: false,
            singleMode: false,
            numberOfColumns: 2,
            numberOfMonths: 2,
            showWeekNumbers: true,
            format: "D MMM, YYYY",
            dropdowns: {
                minYear: 1990,
                maxYear: null,
                months: true,
                years: true,
            },
        };

        if (cash(this).data("single-mode")) {
            options.singleMode = true;
            options.numberOfColumns = 1;
            options.numberOfMonths = 1;
        }

        if (cash(this).data("format")) {
            options.format = cash(this).data("format");
        }

        if (!cash(this).val()) {
            let date = dayjs().format(options.format);
            date += !options.singleMode
                ? " - " + dayjs().add(1, "month").format(options.format)
                : "";
            cash(this).val(date);
        }

        new Litepicker({
            element: this,
            ...options,
        });
    });
})(cash);
