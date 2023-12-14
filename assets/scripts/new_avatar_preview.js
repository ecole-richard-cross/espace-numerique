const previewFallback = document.querySelector('#avatarPreview svg');
const previewImage = document.querySelector('#avatarPreview img');
const imageInput = document.getElementById('avatar_image');

imageInput.addEventListener("change", (e) => {
   previewImage.src = window.URL.createObjectURL(e.target.files[0]);
   previewFallback.classList.add('d-none');
   previewImage.classList.remove('d-none');
})