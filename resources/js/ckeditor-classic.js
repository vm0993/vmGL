import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

cash(".editor").each(function () {
    const el = this;
    ClassicEditor.create(el).catch((error) => {
        console.error(error);
    });
});
