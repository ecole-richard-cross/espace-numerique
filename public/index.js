const basicRoot = document.querySelector('.lieux-activite');
formCollection(basicRoot, {
	btn_add_selector:     '.collection-elem-add',
	btn_delete_selector:  '.collection-elem-remove',
	btn_up_selector:  '.collection-elem-up',
	btn_down_selector:  '.collection-elem-down',
});
formCollection(basicRoot, 'add'); 