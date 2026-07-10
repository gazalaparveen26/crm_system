
<?php

require_once __DIR__ . '/../../config/database.php';

$total_leads =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total FROM leads"
)
)['total'];

$new_leads =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total
FROM leads
WHERE status='new'"
)
)['total'];

$contacted_leads =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total
FROM leads
WHERE status='contacted'"
)
)['total'];

$qualified_leads =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total
FROM leads
WHERE status='qualified'"
)
)['total'];

$won_leads =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total
FROM leads
WHERE status='won'"
)
)['total'];

$lost_leads =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total
FROM leads
WHERE status='lost'"
)
)['total'];

$conversion_rate =
$total_leads > 0
?
round(
($won_leads / $total_leads) * 100,
2
)
:
0;

$recent_sql = "
SELECT
lead_name,
company_name,
source,
status,
created_at
FROM leads
ORDER BY id DESC
LIMIT 10
";

$recent_result =
mysqli_query(
$conn,
$recent_sql
);

?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h3>
Lead Report
</h3>

<button
class="btn btn-secondary"
onclick="loadPage('modules/reports/index.php')">

Back

</button>

</div>

<div class="row g-3 mb-4">

<div class="col-md-2">
<div class="card shadow border-0">
<div class="card-body text-center">
<h6>Total</h6>
<h2><?= $total_leads; ?></h2>
</div>
</div>
</div>

<div class="col-md-2">
<div class="card shadow border-0">
<div class="card-body text-center">
<h6>New</h6>
<h2><?= $new_leads; ?></h2>
</div>
</div>
</div>

<div class="col-md-2">
<div class="card shadow border-0">
<div class="card-body text-center">
<h6>Contacted</h6>
<h2><?= $contacted_leads; ?></h2>
</div>
</div>
</div>

<div class="col-md-2">
<div class="card shadow border-0">
<div class="card-body text-center">
<h6>Qualified</h6>
<h2><?= $qualified_leads; ?></h2>
</div>
</div>
</div>

<div class="col-md-2">
<div class="card shadow border-0">
<div class="card-body text-center">
<h6>Won</h6>
<h2><?= $won_leads; ?></h2>
</div>
</div>
</div>

<div class="col-md-2">
<div class="card shadow border-0">
<div class="card-body text-center">
<h6>Lost</h6>
<h2><?= $lost_leads; ?></h2>
</div>
</div>
</div>

</div>

<div class="row mb-4">

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body text-center">

<h5>
Lead Conversion Rate
</h5>

<h1 class="text-success">

<?= $conversion_rate; ?>%

</h1>

</div>

</div>

</div>

<div class="col-md-8">
<div class="card shadow border-0">

   <canvas id="leadReportChart"></canvas>
</div>
</div>
</div>

<div class="card shadow border-0">

<div class="card-header">

<h5 class="mb-0">

Recent Leads

</h5>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover">

<thead>

<tr>

<th>Name</th>
<th>Company</th>
<th>Source</th>
<th>Status</th>
<th>Date</th>

</tr>

</thead>

<tbody>

<?php

while(
$row =
mysqli_fetch_assoc(
$recent_result
))
{

?>

<tr>

<td>
<?= htmlspecialchars($row['lead_name']); ?>
</td>

<td>
<?= htmlspecialchars($row['company_name']); ?>
</td>

<td>
<?= ucfirst($row['source']); ?>
</td>

<td>
<?= ucfirst($row['status']); ?>
</td>

<td>
<?= date(
'd M Y',
strtotime($row['created_at'])
); ?>
</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</div>
<script>

setTimeout(function(){

    const canvas =
    document.getElementById(
    'leadReportChart'
    );

    if(!canvas)
    {
        console.log(
        'Lead Report Chart Not Found'
        );
        return;
    }

    const ctx =
    canvas.getContext('2d');

    new Chart(ctx,{

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

                    <?= $new_leads; ?>,
                    <?= $contacted_leads; ?>,
                    <?= $qualified_leads; ?>,
                    <?= $won_leads; ?>,
                    <?= $lost_leads; ?>

                ],

                borderWidth:2

            }]

        },

        options:{
            responsive:true,
            maintainAspectRatio:false,
            scales:{
                y:{
                    beginAtZero:true
                }
            }
        }

    });

},500);

</script>
