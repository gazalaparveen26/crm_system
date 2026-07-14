// ==============================
// INIT
// ==============================

function initNotifications()
{
    bindNotificationFilters();
}

// ==============================
// FILTERS
// ==============================

function bindNotificationFilters()
{
    const type =
    document.getElementById('notificationTypeFilter');

    const status =
    document.getElementById('notificationStatusFilter');

    if(type)
    {
        type.addEventListener('change',filterNotifications);
    }

    if(status)
    {
        status.addEventListener('change',filterNotifications);
    }
}

function filterNotifications()
{
    let type =
    document.getElementById('notificationTypeFilter').value.toLowerCase();

    let status =
    document.getElementById('notificationStatusFilter').value;

    let rows =
    document.querySelectorAll('#notificationTable tbody tr');

    rows.forEach(function(row){

        let rowType =
        row.querySelector('[data-type]').dataset.type;

        let rowStatus =
        row.querySelector('[data-status]').dataset.status;

        let show = true;

        if(type !== '')
        {
            show =
            show &&
            rowType === type;
        }

        if(status !== '')
        {
            show =
            show &&
            rowStatus === status;
        }

        row.style.display =
        show ? '' : 'none';

    });

}

function resetNotificationFilters()
{
    document.getElementById(
    'notificationTypeFilter'
    ).value='';

    document.getElementById(
    'notificationStatusFilter'
    ).value='';

    filterNotifications();
}

// ==============================
// DELETE
// ==============================

function deleteNotification(id)
{
    Swal.fire({

        title:'Delete Notification?',

        icon:'warning',

        showCancelButton:true,

        confirmButtonText:'Delete'

    }).then((result)=>{

        if(result.isConfirmed)
        {
            window.location=
            'modules/notifications/delete.php?id='+id;
        }

    });
}

// ==============================
// MARK READ
// ==============================

function markNotificationRead(id)
{
    window.location=
    'modules/notifications/mark_read.php?id='+id;
}