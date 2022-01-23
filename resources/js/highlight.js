import helper from "./helper";
import hljs from "highlight.js";
import jsBeautify from "js-beautify";

(function (cash) {
    "use strict";

    // Highlight code
    cash(".source-preview").each(function () {
        let source = cash(this).find("code").html();

        // First replace
        let replace = helper.replaceAll(source, "HTMLOpenTag", "<");
        replace = helper.replaceAll(replace, "HTMLCloseTag", ">");

        // Save for copy code function
        let originalSource = cash(
            '<textarea style="margin-left: 1000000px;" class="fixed w-1 h-1"></textarea>'
        ).val(replace);
        cash(this).append(originalSource);

        // Beautify code
        if (cash(this).find("code").hasClass("javascript")) {
            replace = jsBeautify(replace);
        } else {
            replace = jsBeautify.html(replace);
        }

        // Format for highlight.js
        replace = helper.replaceAll(replace, "<", "&lt;");
        replace = helper.replaceAll(replace, ">", "&gt;");
        cash(this).find("code").html(replace);
    });

    hljs.highlightAll();
})(cash);
