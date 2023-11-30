removeDuplicateOptions('seminarConsultations');
document.addEventListener("click", e => {
   if (e.target.matches(".field-collection-add-button, .field-collection-delete-button")) {
      removeDuplicateOptions('seminarConsultations');
   }
});

function removeDuplicateOptions(selectName) {
   const selects = document.querySelectorAll('select[name*="' + selectName + '"]');
   selects.forEach(select => {
      if (select !== selects[0]) {
         const otherSelects = (Array.from(document.querySelectorAll('select[name*="' + selectName + '"]'))).filter(el => el.name !== select.name);
         otherSelects.forEach(otherSelect => {
            select.querySelectorAll('option').forEach(option => {
               option.value == otherSelect.value && option.remove();
            })
         })
      }
   })
};
