
function deletePayment(id)
{
    Swal.fire({
        title: 'Delete Payment?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then((result) => {

        if(result.isConfirmed)
        {
           fetch('modules/payments/delete.php?id=' + id)
            .then(response=>response.text())
            .then(data=>{

                Swal.fire(
                    'Deleted!',
                    data,
                    'success'
                );

                loadPage('modules/payments/index.php');
        });
    }

    });
}
