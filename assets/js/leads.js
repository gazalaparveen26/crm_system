function initLeadReportChart()
{
    const dataBox =
    document.getElementById(
    'lead-chart-data'
    );

    if(!dataBox)
    {
        return;
    }

    const canvas =
    document.getElementById(
    'leadReportChart'
    );

    if(!canvas)
    {
        return;
    }

    new Chart(canvas,{

        type:'bar',

        data:{

            labels:[
                'New',
                'Contacted',
                'Qualified',
                'Won',
                'Lost'
            ],

            datasets:[{

                label:'Lead Count',

                data:[

                    dataBox.dataset.new,
                    dataBox.dataset.contacted,
                    dataBox.dataset.qualified,
                    dataBox.dataset.won,
                    dataBox.dataset.lost

                ],

                borderWidth:2

            }]

        },

        options:{
            responsive:true,
            maintainAspectRatio:false
        }

    });

}

// Search Leads
document.addEventListener('keyup', function(e)
{
    if(e.target.id === 'leadSearch')
    {
        let value = e.target.value.toLowerCase();

        let rows = document.querySelectorAll('#leadTable tbody tr');

        rows.forEach(row => {

            let text = row.innerText.toLowerCase();

            row.style.display =
            text.includes(value)
            ? ''
            : 'none';

        });
    }
});


// delete leads
function deleteLead(id)
{
    Swal.fire({
        title: 'Delete Lead?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then((result) => {

        if(result.isConfirmed)
        {
            fetch('modules/leads/delete.php?id=' + id)
            .then(response=>response.text())
            .then(data=>{

                Swal.fire(
                    'Deleted!',
                    data,
                    'success'
                );

                loadPage('modules/leads/index.php');
        });
    }
    });
}