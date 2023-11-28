setTimeout(() => {
    const exportBtn = document.querySelector("a.action-exportXml");
    if (exportBtn) {
        // exportBtn.removeAttribute('data-bs-toggle');
        // exportBtn.removeAttribute('data-bs-target');
        // exportBtn.removeAttribute('data-action-name');
        // exportBtn.removeAttribute('data-action-csrf-token');
        // exportBtn.removeAttribute('data-action-batch');
        // exportBtn.removeAttribute('data-entity-fqcn');
        // exportBtn.removeAttribute('data-action-url');
        exportBtn.addEventListener("click", () => {
            document
                .querySelector(".modal-backdrop")
                .remove();
            document
                .querySelector("#modal-batch-action")
                .classList
                .add("d-none");
            document
                .querySelector("button#modal-batch-action-button")
                .click()
        })
    }
}, 50);