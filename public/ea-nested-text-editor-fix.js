const addButtons = document.querySelectorAll('.field-collection-add-button');

function loadTextEditorJs() {

   const existingFieldTextEditor = document.getElementById('field-text-editor-js');

   if (existingFieldTextEditor === null) {
      const head = document.querySelector('head');
      const script = document.createElement('script');
      script.src = 'bundles\\easyadmin\\field-text-editor.722b7f0e.js';
      script.setAttribute('id', 'field-text-editor-js')
      const css = document.createElement('link');
      css.rel = 'stylesheet';
      css.href = 'bundles\\easyadmin\\field-text-editor.7f2b8426.css';
      head.appendChild(css);
      head.appendChild(script);
   }
}

addButtons.forEach((addButton) => {
   addButton.addEventListener("click", () => {
      setTimeout(() => {
         const trixEditors = document.querySelectorAll("trix-editor");
         console.log(trixEditors);

         trixEditors.forEach((trixEditor, i) => {
            trixEditor.setAttribute('id', 'trix-editor-' + (i + 1))
         });

         loadTextEditorJs();
      }, 200);
   });
});