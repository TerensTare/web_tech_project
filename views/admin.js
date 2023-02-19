
document.querySelectorAll('.user-data').forEach(tr => {
    const edit = tr.querySelector('.edit');

    edit.addEventListener('click', () => {
        for (const td of tr.children) {
            if (!td.classList.contains('actions')) {
                td.contentEditable = true;
            }
        }
        
        edit.find('i').toggleClass('fa-edit fa-tick');
    });

    for (const td of tr.children) {
        if (!td.classList.contains('actions')) {
            td.contentEditable = true;
        }

        td.addEventListener('blur', async () => {
            const data = {
                id: tr.dataset.id,
                [td.dataset.name]: td.textContent
            };

            const response = await fetch('/admin/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            console.log(result);
        });
    }
});