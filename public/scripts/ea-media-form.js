document.addEventListener("DOMContentLoaded", () => {

    const newForm = document.querySelector("#new-Media-form");
    const fileInput = newForm.querySelector("#Media_url_file");
    const fileInputContainer = fileInput
        .parentElement // div.custom-file
        .parentElement // div.input-group
        .parentElement // div.ea-fileupload
        .parentElement // div.form-widget
        .parentElement // div.field-image.form-group
        .parentElement; // form block
    const checkedEl = newForm.querySelector('input:checked');
    if (!checkedEl)
        fileInputContainer.classList.add('d-none');

    newForm
        .querySelector("#Media_type")
        .addEventListener("click", (e) => {
            if (e.target.nodeName !== "INPUT")
                return;
            switch (e.target.value) {
                case "file":
                    fileInput.accept = ".pdf,.doc,.docx,.xml,.txt,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document";
                    break;
                case "image":
                    fileInput.accept = "image/*";
                    break;
                case "audio":
                    fileInput.accept = "audio/*";
                    break;
                case "video":
                    fileInput.accept = "video/*";
                    break;
            }
            fileInputContainer.classList.remove('d-none');
        })
})