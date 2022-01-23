import BalloonEditor from "@ckeditor/ckeditor5-build-balloon";

cash(".editor").each(function () {
    const el = this;
    BalloonEditor.create(el).catch((error) => {
        console.error(error);
    });
});
