const selector = new TomSelect('#hashtags-select', {
    plugins: ['remove_button', 'input_autogrow'],
    placeholder: 'Filtrer par thème',
    selectOnTab: true,
    hidePlaceholder: true,
    render: {
        dropdown: () => {
            return '<div class="border-1 border-secondary-subtle"></div>'
        },
        item: (data, escape) => {
            return '<div class="badge legend tall">' + escape(data.text.trim()) + '</div>'
        }
    },
    onChange: (filters) => {
        const selects = document.querySelectorAll("ul.seminar-list")
        selects.forEach(select => {

            select.querySelectorAll("li").forEach(option => {
                try {
                    const optionTags = option.dataset.seminarTags.split(',');
                    if (filters.length > 0 &&
                        optionTags.filter(value => filters.includes(value)).length < filters.length)
                        option.classList.add('d-none');
                    else
                        option.classList.remove('d-none')
                }
                catch (e) { }
            })

            if (select.querySelectorAll("li:not(.d-none)").length < 1) {
                select.parentElement.parentElement.classList.add('d-none')
            }
            else {
                select.parentElement.parentElement.classList.remove('d-none')
            }
        })
    }
})