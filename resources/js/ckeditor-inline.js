import InlineEditor from "@ckeditor/ckeditor5-build-inline";

cash(".editor").each(function () {
    const el = this;
    InlineEditor.create(el).catch((error) => {
        console.error(error);
    });
});
