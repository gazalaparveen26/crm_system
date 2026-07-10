
// invoice search

document.addEventListener('keyup', function(e)
{
    if(e.target.id === 'invoiceSearch')
    {
        let search =
        e.target.value.toLowerCase();

        let rows =
        document.querySelectorAll(
        '#invoiceTable tbody tr'
        );

        rows.forEach(function(row)
        {
            let text =
            row.innerText.toLowerCase();

            row.style.display =
            text.includes(search)
            ? ''
            : 'none';
        });
    }
});
function deleteInvoice(id)
{
    Swal.fire({
        title: 'Delete Invoice?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then((result) => {

        if(result.isConfirmed) {
            fetch('modules/invoices/delete.php?id=' + id)
            .then(response=>response.text())
            .then(data=>{

                Swal.fire(
                    'Deleted!',
                    data,
                    'success'
                );

                loadPage('modules/invoices/index.php');
        });
        }

    });
}
