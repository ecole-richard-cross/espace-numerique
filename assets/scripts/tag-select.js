const select = document.querySelector("#hashtags-select");
const selector = new TomSelect('#hashtags-select', {
    plugins: ['remove_button', 'input_autogrow'],
    placeholder: select.dataset.placeholder,
    selectOnTab: true,
    hidePlaceholder: true,
    render: {
        dropdown: () => {
            return '<div class="shadow border-1 border-secondary-subtle mb-3"></div>'
        },
        item: (data, escape) => {
            return '<div class="badge legend tall">' + escape(data.text.trim()) + '</div>'
        }
    }
})