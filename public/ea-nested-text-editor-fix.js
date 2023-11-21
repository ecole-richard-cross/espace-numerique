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

const allowDrop = (event) => {
   event.preventDefault();
}

const drag = (event) => {
   event.dataTransfer.setData("text", event.target.id);
}

const drop = (event) => {
   event.preventDefault();
   const data = event.dataTransfer.getData("text");
   const fromContainer = document.getElementById(data).parentNode;
   const toContainer = event.currentTarget;
   if (getDraggableGroup(document.getElementById(data)) === getDraggableGroup(toContainer.firstElementChild)) {
      const elNb = (document.getElementById(data)).querySelector('input[name$="[number]"]').value;
      const targetNb = (toContainer.firstElementChild).querySelector('input[name$="[number]"]').value;
      elNb < targetNb ? toContainer.after(fromContainer) : fromContainer.parentNode.insertBefore(fromContainer, toContainer);
      autoNbValues();
      fillAccordionLabels();
   }
}

const getDraggableGroup = (draggable) => {
   const nearestNbInput = draggable.querySelector('input[name$="[number]"]');
   return (nearestNbInput.name).slice(0, (nearestNbInput.name.length - 11));
}

const initDragNDrop = () => {
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
      // const trixEditors = document.querySelectorAll('trix-editor');
      // trixEditors.forEach((trixEditor) => {
      //    trixEditor.setAttribute("onfocus", 'disableDrag(this)');
      //    trixEditor.setAttribute("onblur", 'enableDrag(this)');
      // })
   }, 200);
}

// function disableDrag(e) { 
//    e.closest(".field-collection-item > .accordion-item").setAttribute("draggable", false);
// }
// function enableDrag(e) { 
//    e.closest(".field-collection-item > .accordion-item").setAttribute("draggable", true) 
// }


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

const fillAccordionLabels = () => {
   const draggables = document.querySelectorAll('.field-collection-item > .accordion-item');
   draggables.forEach((draggable) => {
      const label = draggable.querySelector('.accordion-button');
      const titleInput = draggable.querySelector('input[name$="[title]"]') ?? null;
      const nbInput = draggable.querySelector('input[name$="[number]"]');
      if (titleInput) {
         const chapterNb = titleInput.name.includes('section') ? (draggable.closest('.row')).querySelector('input[name$="[number]"]').value : nbInput.value;
         const sectionNb = titleInput.name.includes('section') ? nbInput.value : null;
         label.textContent = chapterNb + '.' + (sectionNb ? sectionNb + '. ' : ' ') + titleInput.value;
      } else {
         label.textContent = '[' + draggable.querySelector('select[name$="[type]"]').value + '] ' +
            (draggable.querySelector('textarea[name$="[content]"]')).value.slice(5,
               ((draggable.querySelector('textarea[name$="[content]"]')).value).lastIndexOf('<'));
      }

   });
}


document.addEventListener("click", e => {
   if (e.target.matches(".field-collection-add-button, .field-collection-delete-button")) {
      // console.log(e);
      setTimeout(() => {
         document.querySelectorAll("trix-editor").length > 0 && loadTextEditorJs();

         initDragNDrop();
         autoNbValues();
         fillAccordionLabels();

      }, 200);
   }
});

document.addEventListener("change", e => {
   if (e.target.matches('input[name$="[title]"], input[name$="[number]"]')) {
      fillAccordionLabels();
   }
});

document.querySelectorAll("trix-editor").length > 0 && loadTextEditorJs();
initDragNDrop();