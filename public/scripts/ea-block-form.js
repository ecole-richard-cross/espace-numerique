const blockTypeSelects = document.querySelectorAll('select[id*="block"][id$="type"]');
const mediaSelects = document.querySelectorAll('select[id*="block"][id$="media"]');

setTimeout(() => {
    // Necessary Timeout to let the page building javascript finish before executing this.
    // It was leading to null selectors where elements hadn't been dynamically added yet.
    mediaSelects.forEach((ms, i) => {
        ms
            .parentNode // form-widget
            .parentNode // form-group
            .parentNode // Media div
            .classList.add('d-none');

        showIfMedia(blockTypeSelects[i], i);
        blockTypeSelects[i].addEventListener("change", e => {
            showIfMedia(blockTypeSelects[i], i);
        })
    })
}, 10)

function showIfMedia(bs, i) {
    if (['image', 'audio', 'video', 'file'].includes(bs.value)) {
        // Display media selector if block type selected is a media
        mediaSelects[i]
            .parentNode // form-widget
            .parentNode // form-group
            .parentNode // Media div
            .classList.remove('d-none');

        // Check if selected option matches, if not remove it
        const displayEl = mediaSelects[i].nextElementSibling.querySelector("div.item");
        if (displayEl && !displayEl.textContent.toLowerCase().includes(bs.value.toLowerCase())) {
            clearMediaSelector(i);
        }

        // Media selector toggle
        const listBoxToggle = mediaSelects[i]
            .nextElementSibling
            .querySelector(".ts-control");


        listBoxToggle.addEventListener("click", (e) => {

            setTimeout(() => {

                // Get items and display:none those that don't match the selected block type
                const listBoxItems = mediaSelects[i]
                    .nextElementSibling
                    .querySelectorAll("div.option");
                console.log(listBoxItems)

                listBoxItems.forEach(child => {
                    if (!child.textContent.toLowerCase().includes(bs.value.toLowerCase()))
                        child.classList.add("d-none");
                    else
                        child.classList.remove("d-none");
                })
            }, 10);

        });
    }
    else {
        mediaSelects[i]
            .parentNode // form-widget
            .parentNode // form-group
            .parentNode // Media div
            .classList.add('d-none');
        if (mediaSelects[i].value === "")
            return;

        mediaSelects[i].value = "";

        Array.from(mediaSelects[i].children).forEach((opt, i) => {
            if (i === 0)
                opt.setAttribute("selected", "true")
            else
                opt.removeAttribute("selected");
        })

        clearMediaSelector(i);
    }
}

function clearMediaSelector(i) {
    mediaSelects[i].nextElementSibling.querySelector(".clear-button").click();
}