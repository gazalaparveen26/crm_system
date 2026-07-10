
// delete task
function deleteTask(id)
{
    Swal.fire({
        title: 'Delete Task?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then((result) => {

        if(result.isConfirmed)
        {
            window.location =
            'modules/tasks/delete.php?id=' + id;
        }

    });
}

// Search Tasks
document.addEventListener('keyup', function(e)
{
    if(e.target.id === 'taskSearch')
    {
        let value = e.target.value.toLowerCase();

        let rows = document.querySelectorAll('#taskTable tbody tr');

        rows.forEach(row => {

            let text = row.innerText.toLowerCase();

            row.style.display =
            text.includes(value)
            ? ''
            : 'none';

        });
    }
});