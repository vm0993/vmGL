import xlsx from "xlsx";
import feather from "feather-icons";
import Tabulator from "tabulator-tables";

(function (cash) {
    "use strict";

    // Tabulator
    if (cash("#tabulator").length) {
        // Setup Tabulator
        let table = new Tabulator("#tabulator", {
            ajaxURL: "https://dummy-data.left4code.com",
            ajaxFiltering: true,
            ajaxSorting: true,
            printAsHtml: true,
            printStyled: true,
            pagination: "remote",
            paginationSize: 10,
            paginationSizeSelector: [10, 20, 30, 40],
            layout: "fitColumns",
            responsiveLayout: "collapse",
            placeholder: "No matching records found",
            columns: [
                {
                    formatter: "responsiveCollapse",
                    width: 40,
                    minWidth: 30,
                    align: "center",
                    resizable: false,
                    headerSort: false,
                },

                // For HTML table
                {
                    title: "PRODUCT NAME",
                    minWidth: 200,
                    responsive: 0,
                    field: "name",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().name
                            }</div>
                            <div class="text-gray-600 text-xs whitespace-nowrap">${
                                cell.getData().category
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "IMAGES",
                    minWidth: 200,
                    field: "images",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex lg:justify-center">
                            <div class="intro-x w-10 h-10 image-fit">
                                <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="/dist/images/${
                                    cell.getData().images[0]
                                }">
                            </div>
                            <div class="intro-x w-10 h-10 image-fit -ml-5">
                                <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="/dist/images/${
                                    cell.getData().images[1]
                                }">
                            </div>
                            <div class="intro-x w-10 h-10 image-fit -ml-5">
                                <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="/dist/images/${
                                    cell.getData().images[2]
                                }">
                            </div>
                        </div>`;
                    },
                },
                {
                    title: "REMAINING STOCK",
                    minWidth: 200,
                    field: "remaining_stock",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                },
                {
                    title: "STATUS",
                    minWidth: 200,
                    field: "status",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div class="flex items-center lg:justify-center ${
                            cell.getData().status
                                ? "text-theme-9"
                                : "text-theme-6"
                        }">
                            <i data-feather="check-square" class="w-4 h-4 mr-2"></i> ${
                                cell.getData().status ? "Active" : "Inactive"
                            }
                        </div>`;
                    },
                },
                {
                    title: "ACTIONS",
                    minWidth: 200,
                    field: "actions",
                    responsive: 1,
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        let a = cash(`<div class="flex lg:justify-center items-center">
                            <a class="edit flex items-center mr-3" href="javascript:;">
                                <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                            </a>
                            <a class="delete flex items-center text-theme-6" href="javascript:;">
                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                            </a>
                        </div>`);
                        cash(a)
                            .find(".edit")
                            .on("click", function () {
                                alert("EDIT");
                            });

                        cash(a)
                            .find(".delete")
                            .on("click", function () {
                                alert("DELETE");
                            });

                        return a[0];
                    },
                },

                // For print format
                {
                    title: "PRODUCT NAME",
                    field: "name",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "CATEGORY",
                    field: "category",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "REMAINING STOCK",
                    field: "remaining_stock",
                    visible: false,
                    print: true,
                    download: true,
                },
                {
                    title: "STATUS",
                    field: "status",
                    visible: false,
                    print: true,
                    download: true,
                    formatterPrint(cell) {
                        return cell.getValue() ? "Active" : "Inactive";
                    },
                },
                {
                    title: "IMAGE 1",
                    field: "images",
                    visible: false,
                    print: true,
                    download: true,
                    formatterPrint(cell) {
                        return cell.getValue()[0];
                    },
                },
                {
                    title: "IMAGE 2",
                    field: "images",
                    visible: false,
                    print: true,
                    download: true,
                    formatterPrint(cell) {
                        return cell.getValue()[1];
                    },
                },
                {
                    title: "IMAGE 3",
                    field: "images",
                    visible: false,
                    print: true,
                    download: true,
                    formatterPrint(cell) {
                        return cell.getValue()[2];
                    },
                },
            ],
            renderComplete() {
                feather.replace({
                    "stroke-width": 1.5,
                });
            },
        });

        // Redraw table onresize
        window.addEventListener("resize", () => {
            table.redraw();
            feather.replace({
                "stroke-width": 1.5,
            });
        });

        // Filter function
        function filterHTMLForm() {
            let field = cash("#tabulator-html-filter-field").val();
            let type = cash("#tabulator-html-filter-type").val();
            let value = cash("#tabulator-html-filter-value").val();
            table.setFilter(field, type, value);
        }

        // On submit filter form
        cash("#tabulator-html-filter-form")[0].addEventListener(
            "keypress",
            function (event) {
                let keycode = event.keyCode ? event.keyCode : event.which;
                if (keycode == "13") {
                    event.preventDefault();
                    filterHTMLForm();
                }
            }
        );

        // On click go button
        cash("#tabulator-html-filter-go").on("click", function (event) {
            filterHTMLForm();
        });

        // On reset filter form
        cash("#tabulator-html-filter-reset").on("click", function (event) {
            cash("#tabulator-html-filter-field").val("name");
            cash("#tabulator-html-filter-type").val("like");
            cash("#tabulator-html-filter-value").val("");
            filterHTMLForm();
        });

        // Export
        cash("#tabulator-export-csv").on("click", function (event) {
            table.download("csv", "data.csv");
        });

        cash("#tabulator-export-json").on("click", function (event) {
            table.download("json", "data.json");
        });

        cash("#tabulator-export-xlsx").on("click", function (event) {
            window.XLSX = xlsx;
            table.download("xlsx", "data.xlsx", {
                sheetName: "Products",
            });
        });

        cash("#tabulator-export-html").on("click", function (event) {
            table.download("html", "data.html", {
                style: true,
            });
        });

        // Print
        cash("#tabulator-print").on("click", function (event) {
            table.print();
        });
    }
})(cash);
