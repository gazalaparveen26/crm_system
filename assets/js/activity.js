
// ==============================
// INIT
// ==============================

function initActivity()
{
    bindActivityFilters();
}

// ==============================
// BIND FILTERS
// ==============================

function bindActivityFilters()
{
    const moduleFilter =
        document.getElementById('activityModuleFilter');

    const actionFilter =
        document.getElementById('activityActionFilter');

    if(moduleFilter)
    {
        moduleFilter.addEventListener('change', filterActivities);
    }

    if(actionFilter)
    {
        actionFilter.addEventListener('change', filterActivities);
    }
}

// ==============================
// MAIN FILTER ENGINE (NO SEARCH)
// ==============================

function filterActivities()
{
    let module =
        document.getElementById('activityModuleFilter')?.value.toLowerCase() || '';

    let action =
        document.getElementById('activityActionFilter')?.value.toLowerCase() || '';

    let rows =
        document.querySelectorAll('#activityTable tbody tr');

    rows.forEach(row => {

        let moduleCell =
            row.querySelector('[data-module]');

        let actionCell =
            row.querySelector('[data-action]');

        let rowModule =
            moduleCell?.dataset?.module?.toLowerCase() || '';

        let rowAction =
            actionCell?.dataset?.action?.toLowerCase() || '';

        let show = true;

        // MODULE FILTER
        if(module !== '')
        {
            show = show && rowModule === module;
        }

        // ACTION FILTER
        if(action !== '')
        {
            show = show && rowAction === action;
        }

        row.style.display = show ? '' : 'none';
    });
}

// ==============================
// RESET FILTERS
// ==============================

function resetActivityFilters()
{
    document.getElementById('activityModuleFilter').value = '';
    document.getElementById('activityActionFilter').value = '';

    filterActivities();
}