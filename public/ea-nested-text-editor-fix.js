const loadTextEditorJs = () => {

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

document.addEventListener("click", e => {
   if (e.target.matches(".field-collection-add-button, .field-collection-delete-button")) {
      console.log(e);
      setTimeout(() => {
         document.querySelectorAll("trix-editor").length > 0 && loadTextEditorJs();
      }, 200);
   }
})

document.querySelectorAll("trix-editor").length > 0 && loadTextEditorJs();