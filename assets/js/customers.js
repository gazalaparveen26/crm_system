
// search customer by name ,email ,phone number and status active or inactive 
document.addEventListener("keyup", function(e)
{
    if(e.target.id === "customerSearch")
    {
        let search =e.target.value.toLowerCase().trim();

        let rows =  document.querySelectorAll( "#customerTable tbody tr"  );

        rows.forEach(function(row)
        {
            let rowText =row.innerText.toLowerCase();

            let statusElement = row.querySelector(".customer-status");

            let status = statusElement ? statusElement.innerText.toLowerCase().trim() : "";

            if(search === "active")
            {
                row.style.display = (status === "active")  ? "" : "none";
            }
            else if(search === "inactive")
            {
                row.style.display = (status === "inactive") ? "" : "none";
            }
            else
            {
                row.style.display = rowText.includes(search) ? ""  : "none";
            }
        });
    }
});


// delete customer
function deleteCustomer(id)
{
    Swal.fire({
        title: 'Delete Customer?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then((result) => {

        if(result.isConfirmed)
        { fetch('modules/customers/delete.php?id=' + id)
            .then(response=>response.text())
            .then(data=>{

                Swal.fire(
                    'Deleted!',
                    data,
                    'success'
                );

                loadPage('modules/customers/index.php');
        });
    }
    });
}
// // serach customer
// document.addEventListener('keyup',function(e)
// {
//     if(e.target.id === 'customerSearch')
//     {
//         let value =e.target.value.toLowerCase();

//         let rows =document.querySelectorAll('#customerTable tbody tr');
//         rows.forEach(row => {
//             let text =row.innerText.toLowerCase();
//             row.style.display = text.includes(value) ? '' : 'none';
//         });
//     }
// });
// document.addEventListener('keyup',function(e)
// {
//     if(e.target.id === 'customerSearch')
//     {
//         let value =e.target.value.toLowerCase();

//         let rows =document.querySelectorAll('#customerTable tbody tr');
//         rows.forEach(row => {
//             let text =row.innerText.toLowerCase();
//             row.style.display = text.includes(value) ? '' : 'none';
//         });
//     }
// });
