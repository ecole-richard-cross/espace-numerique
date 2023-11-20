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


const addButtonsListener = () => {
   let addButtons = document.querySelectorAll('.field-collection-add-button');
   addButtons.forEach((addButton) => {
      addButton.addEventListener("click", (event) => {
         setTimeout(() => {
            // console.log(event);
            
            document.querySelectorAll("trix-editor").length > 0 && loadTextEditorJs();
            
            // console.log(addButtons.length, (document.querySelectorAll('.field-collection-add-button')).length);

            if (addButtons.length !== (document.querySelectorAll('.field-collection-add-button')).length) {
               addButtons = document.querySelectorAll('.field-collection-add-button');
               addButtonsListener();
            }

         }, 200);
      });
   });
}

document.querySelectorAll("trix-editor").length > 0 && loadTextEditorJs();
addButtonsListener();