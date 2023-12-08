const replyBtns = document.querySelectorAll("[aria-controls='reply']")
const replyBox = document.querySelector("#reply_box")
const replyContent = replyBox.querySelector("#content")
const replyTo = document.querySelector("#comment_replyingTo")

replyBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        const accordionBtn = document.querySelector(".accordion-button.collapsed")

        setTimeout(() => {
            if (accordionBtn)
                accordionBtn.click()
            document.querySelector("trix-editor").focus();
        }, 1)
        setTimeout(() => {
            document.querySelector("trix-editor").focus();
        }, 100)

        replyTo.value = Number(btn.dataset.replyTo)
        replyContent.replaceChildren(btn.dataset.replyToComment)
        replyBox.classList.remove('d-none')
    })
})

const closeReplyBtn = document.querySelector("#reply_box button.btn-close");
closeReplyBtn.addEventListener("click", () => {
    replyTo.value = ""
    replyContent.replaceChildren()
    replyBox.classList.add('d-none')
})