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

const autoNbValues = () => {
   const nbInputs = document.querySelectorAll('input[name$="[number]"]');
   const groups = {};
   nbInputs.forEach((nbInput, i) => {
      nbInput.value = nbInput.value === "" ? i : nbInput.value;

      const nameNbRemoved = (nbInput.name).slice(0, (nbInput.name.length - 11));
      groups[nameNbRemoved] = groups[nameNbRemoved] ? [...groups[nameNbRemoved], nbInput] : [nbInput];


      for (let nameNbRemoved in groups) {
         groups[nameNbRemoved].sort((a, b) => a.value - b.value);
         groups[nameNbRemoved].forEach((nbInput, i) => {
            nbInput.value = i + 1;
         })
      };
   });
};

function allowDrop(event) {
   event.preventDefault();
}

function drag(event) {
   event.dataTransfer.setData("text", event.target.id);
}

function drop(event) {
   event.preventDefault();
   const data = event.dataTransfer.getData("text");
   const fromContainer = document.getElementById(data).parentNode;
   const toContainer = event.currentTarget;
   if (getDraggableGroup(document.getElementById(data)) === getDraggableGroup(toContainer.firstElementChild)) {
      fromContainer.appendChild(toContainer.firstElementChild);
      toContainer.appendChild(document.getElementById(data));
      autoNbValues();
   }
}

function initDragNDrop() {
   setTimeout(() => {
      const dropPoints = document.querySelectorAll('.field-collection-item');
      dropPoints.forEach((dropPoint) => {
         dropPoint.setAttribute("ondrop", "drop(event)");
         dropPoint.setAttribute("ondragover", "allowDrop(event)");
      });
      const draggables = document.querySelectorAll('.field-collection-item > .accordion-item');
      draggables.forEach((draggable, i) => {
         draggable.setAttribute("id", "drag" + i);
         draggable.setAttribute("draggable", "true");
         draggable.setAttribute("ondragstart", "drag(event)");
      });
   }, 200);
}

function getDraggableGroup(draggable) {
   const nearestNbInput = draggable.querySelector('input[name$="[number]');
   return (nearestNbInput.name).slice(0, (nearestNbInput.name.length - 11));
}


document.addEventListener("click", e => {
   if (e.target.matches(".field-collection-add-button, .field-collection-delete-button")) {
      // console.log(e);
      setTimeout(() => {
         document.querySelectorAll("trix-editor").length > 0 && loadTextEditorJs();

         initDragNDrop();
         autoNbValues();

      }, 200);
   }
});

document.querySelectorAll("trix-editor").length > 0 && loadTextEditorJs();
initDragNDrop();