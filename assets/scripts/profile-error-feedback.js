const form = document.querySelector('form');
const inputs = document.querySelectorAll('input');
const adresses = document.querySelectorAll('fieldset > [id^="profile_lieuxActivite"], #profile_adressePostale');

inputs.forEach(input => {
   if (!input.validity.valid) {
      const errorMessage = input.parentElement.querySelector('.invalid-feedback');
      input.addEventListener("input", (e) => {
         if (input.validity.valid) {
            input.classList.remove('is-invalid');
            errorMessage && errorMessage.classList.add('d-none');
         } else {
            input.classList.add('is-invalid');
            errorMessage && errorMessage.classList.remove('d-none');
         }
      })
   }
})

adresses.forEach(adresse => {
   const codePostal = adresse.querySelector("input[name$='[codePostal]']");
   const ville = adresse.querySelector("input[name$='[ville]']");
   const pays = adresse.querySelector("input[name$='[pays]']");
   const inputsToValidate = [codePostal, ville, pays];

   if (!codePostal.validity.valid && (!ville.validity.valid || !pays.validity.valid)) {
      inputsToValidate.forEach(input => {
         !input.validity.valid && input.classList.add('is-invalid');
      });
   }


   const errorMessage = adresse == document.getElementById('profile_adressePostale') ?
      adresse.parentElement.querySelector('.invalid-feedback') :
      adresse.closest('ul').parentElement.querySelector('.invalid-feedback');

   const deleteButton = adresse != document.getElementById('profile_adressePostale') ? adresse.closest('li').querySelector('button') : null;
   deleteButton && deleteButton.addEventListener('click', (e) => {
      if (!codePostal.validity.valid || (!ville.validity.valid && !pays.validity.valid)) {
         errorMessage.classList.add("d-none");
      }
   })

   inputsToValidate.forEach(input => {
      input.addEventListener('input', (e) => {
         if (codePostal.validity.valid || (ville.validity.valid && pays.validity.valid)) {
            inputsToValidate.forEach(input => input.classList.remove('is-invalid'));
            errorMessage && errorMessage.classList.add("d-none");
         } else {
            inputsToValidate.forEach(input => {
               input.validity.valid && input.classList.remove('is-invalid');
               if (!input.validity.valid) {
                  input.classList.add('is-invalid');
                  errorMessage.classList.remove("d-none");
               }
            });
         }
      })
   });
})