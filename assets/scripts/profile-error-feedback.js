const form = document.querySelector('form');
const inputs = document.querySelectorAll('input');
const adresses = document.querySelectorAll('fieldset > [id^="profile_lieuxActivite"], #profile_adressePostale');
const alwaysRequired = document.querySelectorAll('input[name$="[prenom]"], input[name$="[nomNaissance]"], #profile_adressePostale input[required]');

alwaysRequired.forEach(requiredField => {
   requiredField.validity.valid && requiredField.classList.add('border-primary');
})

inputs.forEach(input => {
   const errorMessage = input.parentElement.querySelector('.invalid-feedback');
   input.addEventListener("input", (e) => {
      if (input.validity.valid) {
         input.classList.remove('is-invalid');
         errorMessage && errorMessage.classList.add('d-none');
         Array.from(alwaysRequired).filter(el => el == input).length > 0 && input.classList.add('border-primary');
      } else {
         input.classList.add('is-invalid');
         errorMessage && errorMessage.classList.remove('d-none');
         Array.from(alwaysRequired).filter(el => el == input).length > 0 && input.classList.remove('border-primary');

      }
   })
})

adresses.forEach(adresse => {
   const codePostal = adresse.querySelector("input[name$='[codePostal]']");
   const ville = adresse.querySelector("input[name$='[ville]']");
   const pays = adresse.querySelector("input[name$='[pays]']");
   const inputsToValidate = [codePostal, ville, pays];

   let errorMessage = adresse == document.getElementById('profile_adressePostale') ?
      adresse.parentElement.querySelector('.invalid-feedback') :
      adresse.closest('ul').parentElement.querySelector('.invalid-feedback');

   const deleteButton = adresse != document.getElementById('profile_adressePostale') ? adresse.closest('li').querySelector('button') : null;
   deleteButton && deleteButton.addEventListener('click', (e) => {
      if (!codePostal.validity.valid || (!ville.validity.valid && !pays.validity.valid)) {
         errorMessage && errorMessage.classList.add("d-none");
      }
   })

   if (!codePostal.validity.valid && (!ville.validity.valid || !pays.validity.valid)) {
      inputsToValidate.forEach(input => {
         !input.validity.valid && input.classList.add('is-invalid');
      });
   }

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

                  if (errorMessage) {
                     errorMessage.classList.remove("d-none");
                  } else {
                     errorMessage = document.createElement('div');
                     errorMessage.classList = 'invalid-feedback d-block';
                     errorMessage.textContent = 'Une addresse en France doit comporter au moins un code postal. Une adresse à l\'étranger, une ville et un pays.'
                     adresse == document.getElementById('profile_adressePostale') ?
                        adresse.parentElement.appendChild(errorMessage) :
                        adresse.closest('ul').parentElement.appendChild(errorMessage);
                  }
               }
            });
         }
      })
   });
})
