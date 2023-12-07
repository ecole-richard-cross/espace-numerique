document
  .querySelectorAll('.add_item_link')
  .forEach(btn => {
    btn.addEventListener("click", (e) => {
      addFormToCollection(e);
    })
  });


document
  .querySelectorAll('.presenceWebs .list-group-item, .lieuxActivite .list-group-item')
  .forEach((el) => {
    addFormDeleteLink(el)
  })


function addFormToCollection(e) {
  const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

  const item = document.createElement('li');
  item.classList = 'list-group-item d-flex flex-column flex-sm-row';

  item.innerHTML = collectionHolder
    .dataset
    .prototype
    .replace(
      /__name__/g,
      collectionHolder.dataset.index
    );

  collectionHolder.appendChild(item);

  collectionHolder.dataset.index++;
  addFormDeleteLink(item);
};

function addFormDeleteLink(item) {
  const removeFormButton = document.createElement('button');
  removeFormButton.classList = 'btn align-self-end align-self-sm-center';
  const deleteIcon = document.createElement('i');
  deleteIcon.classList = 'fa fa-trash mt-3 ms-2';
  removeFormButton.appendChild(deleteIcon);

  item.append(removeFormButton);

  removeFormButton.addEventListener('click', (e) => {
    e.preventDefault();
    item.remove();
  });
}