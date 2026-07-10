function bindUserSearch()
{
    const search = document.getElementById('userSearch');

    if(!search) return;

    search.addEventListener('keyup', filterUsers);
}

function bindUserFilters()
{
    const role = document.getElementById('userRoleFilter');
    const status = document.getElementById('userStatusFilter');

    if(role)
    {
        role.addEventListener('change', filterUsers);
    }

    if(status)
    {
        status.addEventListener('change', filterUsers);
    }
}

function filterUsers()
{
    let keyword =
    document.getElementById('userSearch').value.toLowerCase();

    let role =
    document.getElementById('userRoleFilter').value;

    let status =
    document.getElementById('userStatusFilter').value;

    let rows =
    document.querySelectorAll('#userTable tbody tr');

    rows.forEach(function(row){

        let text =
        row.innerText.toLowerCase();

        let roleCell =
        row.querySelector('[data-role]');

        let statusCell =
        row.querySelector('[data-status]');

        let rowRole =
        roleCell ? roleCell.dataset.role.toLowerCase() : '';

        let rowStatus =
        statusCell ? statusCell.dataset.status.toLowerCase() : '';

        let show =
        text.includes(keyword);

        if(role !== '')
        {
            show = show && rowRole === role.toLowerCase();
        }

        if(status !== '')
        {
            show = show && rowStatus === status.toLowerCase();
        }

        row.style.display =
        show ? '' : 'none';

    });

}

function resetUserFilters()
{
    document.getElementById('userSearch').value = '';

    document.getElementById('userRoleFilter').value = '';

    document.getElementById('userStatusFilter').value = '';

    filterUsers();
}

function initUsers()
{
    bindUserSearch();

    bindUserFilters();
}

function deleteUser(id)
{
    Swal.fire({
        title:'Delete User?',
        text:'This action cannot be undone.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonText:'Delete'
    }).then((result)=>{

        if(result.isConfirmed)
        {
            fetch('modules/users/delete.php?id=' + id)
            .then(response=>response.text())
            .then(data=>{

                Swal.fire(
                    'Deleted!',
                    data,
                    'success'
                );

                loadPage('modules/users/index.php');

            });
        }

    });
}