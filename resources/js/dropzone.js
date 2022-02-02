import Dropzone from "dropzone";

(function (cash) {
    "use strict";

    // Dropzone
    Dropzone.autoDiscover = false;
    cash(".dropzone").each(function () {
        let options = {
            accept: (file, done) => {
                console.log("Uploaded");
                done();
            },
        };

        if (cash(this).data("single")) {
            options.maxFiles = 1;
        }

        if (cash(this).data("file-types")) {
            options.accept = (file, done) => {
                if (
                    cash(this)
                        .data("file-types")
                        .split("|")
                        .indexOf(file.type) === -1
                ) {
                    alert("Error! Files of this type are not accepted");
                    done("Error! Files of this type are not accepted");
                } else {
                    console.log("Uploaded");
                    done();
                }
            };
        }

        let dz = new Dropzone(this, options);

        dz.on("maxfilesexceeded", (file) => {
            alert("No more files please!");
        });
    });
})(cash);
