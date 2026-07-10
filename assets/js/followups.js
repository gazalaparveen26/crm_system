// ==============================
// INIT
// ==============================

function initFollowups()
{
    bindFollowupSearch();
    bindFollowupFilters();
}

// ==============================
// SAFE BIND SEARCH
// ==============================

function bindFollowupSearch()
{
    const search = document.getElementById('followupSearch');

    if(!search) return;

    search.removeEventListener('keyup', filterFollowups);
    search.addEventListener('keyup', filterFollowups);
}

// ==============================
// SAFE BIND FILTERS
// ==============================

function bindFollowupFilters()
{
    const moduleFilter =
        document.getElementById('followupModuleFilter');

    const actionFilter =
        document.getElementById('followupActionFilter');

    if(moduleFilter)
    {
        moduleFilter.removeEventListener('change', filterFollowups);
        moduleFilter.addEventListener('change', filterFollowups);
    }

    if(actionFilter)
    {
        actionFilter.removeEventListener('change', filterFollowups);
        actionFilter.addEventListener('change', filterFollowups);
    }
}

// ==============================
// MAIN FILTER ENGINE (FIXED)
// ==============================

      function filterFollowups()
{
    
    let keyword =
        document.getElementById('followupSearch')?.value.toLowerCase() || '';

    let status =
        document.getElementById('followupStatusFilter')?.value || '';

    let date =
        document.getElementById('followupDateFilter')?.value || '';

    let rows =
        document.querySelectorAll('#followupTable tbody tr');

    let today = new Date();

    rows.forEach(function(row){

        let text = row.innerText.toLowerCase();

        let statusCell = row.querySelector('[data-status]');
        let rowStatus = statusCell ? statusCell.dataset.status : '';

        let dateCell = row.querySelector('[data-date]');
        let rowDate = dateCell ? new Date(dateCell.dataset.date) : null;

        let show = text.includes(keyword);

        // STATUS FILTER
        if(status !== '')
        {
            show = show && rowStatus === status;
        }

        // DATE FILTER
        if(date === 'today' && rowDate)
        {
            show = show &&
            rowDate.toDateString() === today.toDateString();
        }

        else if(date === 'week' && rowDate)
        {
            let weekStart = new Date(today);
            weekStart.setDate(today.getDate() - 7);

            show = show &&
            rowDate >= weekStart &&
            rowDate <= today;
        }

        else if(date === 'month' && rowDate)
        {
            show = show &&
            rowDate.getMonth() === today.getMonth() &&
            rowDate.getFullYear() === today.getFullYear();
        }

        row.style.display = show ? '' : 'none';

    });
}
function resetFollowupFilters() {

    document.getElementById("followupSearch").value = "";

    document.getElementById("followupStatusFilter").value = "";

    document.getElementById("followupDateFilter").value = "";

    filterFollowups();

}
function deleteFollowup(id)
{
    Swal.fire({
        title:'Delete Followup?',
        text:'This action cannot be undone.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonText:'Delete'
    }).then((result)=>{

        if(result.isConfirmed)
        {
            fetch('modules/followups/delete.php?id=' + id)
            .then(response=>response.text())
            .then(data=>{

                Swal.fire(
                    'Deleted!',
                    data,
                    'success'
                );

                loadPage('modules/followups/index.php');

            });
        }

    });
}