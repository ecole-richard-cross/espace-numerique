import '../../styles/ea-nested-forms.css';

setTimeout(() => {
   orderCollectionsByNb();
   document.querySelectorAll("trix-editor").length > 0 && loadTextEditorJs();
   initDragNDrop();

   document.addEventListener("click", e => {
      if (e.target.matches(".field-collection-add-button, .field-collection-delete-button")) {
         document.querySelectorAll("trix-editor").length > 0 && loadTextEditorJs();
         initDragNDrop();
         autoNbValues();
         fillAccordionLabels();
      }
   });

   document.addEventListener("input", e => {
      if (e.target.matches('input[name$="[title]"], input[name$="[number]"], select[name$="[type]"], trix-editor')) {
         fillAccordionLabels();
      }
   });

}, 200);



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

const initDragNDrop = () => {
   const dropPoints = document.querySelectorAll('.field-collection-item');
   dropPoints.forEach((dropPoint) => {
      dropPoint.setAttribute("ondrop", "drop(event)");
      dropPoint.setAttribute("ondragover", "allowDrop(event)");
   });
   const initDraggables = () => {
      const draggables = document.querySelectorAll('.field-collection-item > .accordion-item');
      draggables.forEach((draggable, i) => {
         !draggable.id && draggable.setAttribute("id", "drag" + i);
         draggable.setAttribute("draggable", "true");
         !draggable.ondragstart && draggable.setAttribute("ondragstart", "drag(event)");
      });
   }
   const removeDraggables = () => {
      const draggables = document.querySelectorAll('.field-collection-item > .accordion-item');
      draggables.forEach((draggable) => {
         draggable.setAttribute("draggable", "false");
      });
   }
   const inputs = document.querySelectorAll('input, trix-editor');
   inputs.forEach((input) => {
      input.onfocus = () => { removeDraggables(); };
      input.onblur = () => { initDraggables(); };
   })

   initDraggables();
}
window.allowDrop = allowDrop;
function allowDrop(event) {
   event.preventDefault();
}
window.drag = drag;
function drag(event) {
   event.dataTransfer.setData("text", event.target.id);
}
window.drop = drop;
function drop(event) {
   event.preventDefault();

   const data = event.dataTransfer.getData("text");
   const fromContainer = document.getElementById(data).parentNode;
   const toContainer = event.currentTarget;
   if (getGroup(document.getElementById(data)) === getGroup(toContainer.firstElementChild)) {
      const elNb = (document.getElementById(data)).querySelector('input[name$="[number]"]').value;
      const targetNb = (toContainer.firstElementChild).querySelector('input[name$="[number]"]').value;
      elNb < targetNb ? toContainer.after(fromContainer) : fromContainer.parentNode.insertBefore(fromContainer, toContainer);
      autoNbValues();
      fillAccordionLabels();
   }
}

const getGroup = (el) => {
   const nearestNbInput = el.querySelector('input[name$="[number]"]');
   return (nearestNbInput.name).slice(0, (nearestNbInput.name.length - 11));
}

const orderCollectionsByNb = () => {
   const collectionItems = Array.from(document.querySelectorAll('.field-collection-item'))
      .filter(item => item.querySelector('input[name$="[number]"]') != null);
   const groups = {};
   collectionItems.forEach((item) => {
      const groupName = getGroup(item);
      groups[groupName] = groups[groupName] ? [...groups[groupName], item] : [item];
   });
   for (let groupName in groups) {
      groups[groupName].sort((a, b) => a.querySelector('input[name$="[number]"]').value - b.querySelector('input[name$="[number]"]').value);
      groups[groupName][0].parentNode.insertBefore(groups[groupName][0], groups[groupName][1]);
      for (let i = 2; i < groups[groupName].length; i++) {
         groups[groupName][i - 1].after(groups[groupName][i]);
      }
   }
};

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
         label.childNodes[2].textContent = chapterNb + '.' + (sectionNb ? sectionNb + '. ' : ' ') + titleInput.value;
      } else if (draggable.querySelector('select[name$="[type]"]')) {
         const type = draggable.querySelector('select[name$="[type]"]').value;
         const capitalizedType = type.charAt(0).toUpperCase() + type.slice(1);
         const htmlRemovedContent = ((draggable.querySelector('textarea[name$="[content]"]')).value.replace(/<.{0,10}>/gm, '')).replace(/&nbsp;/gm, ' ');
         label.childNodes[2].textContent = capitalizedType + " - " +
            (htmlRemovedContent.length > 80 ? htmlRemovedContent.slice(0, 79) : htmlRemovedContent);
      }

   });
}
