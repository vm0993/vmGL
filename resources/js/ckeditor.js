import ClassicEditor from "@ckeditor/ckeditor5-editor-classic/src/classiceditor";
import InlineEditor from "@ckeditor/ckeditor5-editor-inline/src/inlineeditor";
import BalloonEditor from "@ckeditor/ckeditor5-editor-balloon/src/ballooneditor";
import DocumentEditor from "@ckeditor/ckeditor5-editor-decoupled/src/decouplededitor";
import EssentialsPlugin from "@ckeditor/ckeditor5-essentials/src/essentials";
import BoldPlugin from "@ckeditor/ckeditor5-basic-styles/src/bold";
import ItalicPlugin from "@ckeditor/ckeditor5-basic-styles/src/italic";
import UnderlinePlugin from "@ckeditor/ckeditor5-basic-styles/src/underline";
import StrikethroughPlugin from "@ckeditor/ckeditor5-basic-styles/src/strikethrough";
import CodePlugin from "@ckeditor/ckeditor5-basic-styles/src/code";
import SubscriptPlugin from "@ckeditor/ckeditor5-basic-styles/src/subscript";
import SuperscriptPlugin from "@ckeditor/ckeditor5-basic-styles/src/superscript";
import LinkPlugin from "@ckeditor/ckeditor5-link/src/link";
import ParagraphPlugin from "@ckeditor/ckeditor5-paragraph/src/paragraph";
import EasyImagePlugin from "@ckeditor/ckeditor5-easy-image/src/easyimage";
import ImagePlugin from "@ckeditor/ckeditor5-image/src/image";
import ImageUploadPlugin from "@ckeditor/ckeditor5-image/src/imageupload";
import CloudServicesPlugin from "@ckeditor/ckeditor5-cloud-services/src/cloudservices";
import Font from "@ckeditor/ckeditor5-font/src/font";
import Heading from "@ckeditor/ckeditor5-heading/src/heading";
import HeadingButtonsUI from "@ckeditor/ckeditor5-heading/src/headingbuttonsui";
import Highlight from "@ckeditor/ckeditor5-highlight/src/highlight";

let simpleEditorConfig = {
    plugins: [
        ParagraphPlugin,
        BoldPlugin,
        UnderlinePlugin,
        ItalicPlugin,
        LinkPlugin,
    ],
    toolbar: {
        items: ["bold", "italic", "underline", "link"],
    },
};

let editorConfig = {
    cloudServices: {
        tokenUrl: "",
        uploadUrl: "",
    },
    plugins: [
        Font,
        EssentialsPlugin,
        BoldPlugin,
        UnderlinePlugin,
        StrikethroughPlugin,
        ItalicPlugin,
        LinkPlugin,
        ParagraphPlugin,
        CodePlugin,
        SubscriptPlugin,
        SuperscriptPlugin,
        EasyImagePlugin,
        ImagePlugin,
        ImageUploadPlugin,
        CloudServicesPlugin,
        Heading,
        HeadingButtonsUI,
        Highlight,
    ],
    toolbar: {
        items: [
            "fontSize",
            "fontFamily",
            "fontColor",
            "fontBackgroundColor",
            "bold",
            "italic",
            "underline",
            "strikethrough",
            "code",
            "subscript",
            "superscript",
            "link",
            "undo",
            "redo",
            "imageUpload",
            "highlight",
        ],
    },
};

cash(".editor").each(function () {
    let editor = ClassicEditor;
    let options = editorConfig;
    let el = this;

    if (cash(el).data("simple-toolbar")) {
        options = simpleEditorConfig;
    }

    if (cash(el).data("editor") == "inline") {
        editor = InlineEditor;
    } else if (cash(el).data("editor") == "balloon") {
        editor = BalloonEditor;
    } else if (cash(el).data("editor") == "document") {
        editor = DocumentEditor;
        el = cash(el).find(".document-editor__editable")[0];
    }

    editor
        .create(el, options)
        .then((editor) => {
            if (cash(el).closest(".editor").data("editor") == "document") {
                cash(el)
                    .closest(".editor")
                    .find(".document-editor__toolbar")
                    .append(editor.ui.view.toolbar.element);
            }

            if (cash(el).attr("name")) {
                window[cash(el).attr("name")] = editor;
            }
        })
        .catch((error) => {
            console.error(error.stack);
        });
});
