<?php

require_once __DIR__ . '/../../config/database.php';

$id = (int)($_GET['id'] ?? 0);

if($id == 0 && isset($_GET['page']))
{
    parse_str(
        parse_url($_GET['page'], PHP_URL_QUERY),
        $params
    );

    $id = (int)($params['id'] ?? 0);
}

$sql = "SELECT * FROM leads WHERE id = ?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"i",
$id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$lead = mysqli_fetch_assoc($result);

if(!$lead)
{
    die("Lead Not Found");
}

?>

<div class="card shadow border-0">

<div class="card-header d-flex justify-content-between align-items-center">

    <h4 class="mb-0">
        Edit Lead
    </h4>
   <button class="btn btn-secondary" onclick="loadPage('modules/leads/index.php')">Back</button>
</div>

<div class="card-body">

    <form
    action="modules/leads/update.php"
    method="POST">

        <input
        type="hidden"
        name="id"
        value="<?= $lead['id']; ?>">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Lead Name
                </label>

                <input
                type="text"
                name="lead_name"
                class="form-control"
                value="<?= htmlspecialchars($lead['lead_name']); ?>"
                required>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Company Name
                </label>

                <input
                type="text"
                name="company_name"
                class="form-control"
                value="<?= htmlspecialchars($lead['company_name']); ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Email
                </label>

                <input
                type="email"
                name="email"
                class="form-control"
                value="<?= htmlspecialchars($lead['email']); ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Phone
                </label>

                <input
                type="text"
                name="phone"
                class="form-control"
                value="<?= htmlspecialchars($lead['phone']); ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Source
                </label>

                <select
                name="source"
                class="form-select">

                    <option value="website" <?= $lead['source']=='website'?'selected':''; ?>>Website</option>
                    <option value="facebook" <?= $lead['source']=='facebook'?'selected':''; ?>>Facebook</option>
                    <option value="instagram" <?= $lead['source']=='instagram'?'selected':''; ?>>Instagram</option>
                    <option value="whatsapp" <?= $lead['source']=='whatsapp'?'selected':''; ?>>WhatsApp</option>
                    <option value="referral" <?= $lead['source']=='referral'?'selected':''; ?>>Referral</option>
                    <option value="google" <?= $lead['source']=='google'?'selected':''; ?>>Google</option>
                    <option value="other" <?= $lead['source']=='other'?'selected':''; ?>>Other</option>

                </select>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Status
                </label>

                <select
                name="status"
                class="form-select">

                    <option value="new" <?= $lead['status']=='new'?'selected':''; ?>>New</option>
                    <option value="contacted" <?= $lead['status']=='contacted'?'selected':''; ?>>Contacted</option>
                    <option value="qualified" <?= $lead['status']=='qualified'?'selected':''; ?>>Qualified</option>
                    <option value="proposal_sent" <?= $lead['status']=='proposal_sent'?'selected':''; ?>>Proposal Sent</option>
                    <option value="won" <?= $lead['status']=='won'?'selected':''; ?>>Won</option>
                    <option value="lost" <?= $lead['status']=='lost'?'selected':''; ?>>Lost</option>

                </select>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Estimated Value
                </label>

                <input
                type="number"
                step="0.01"
                name="estimated_value"
                class="form-control"
                value="<?= $lead['estimated_value']; ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Follow Up Date
                </label>

                <input
                type="date"
                name="followup_date"
                class="form-control"
                value="<?= $lead['followup_date']; ?>">

            </div>

            <div class="col-12 mb-3">

                <label class="form-label">
                    Remarks
                </label>

                <textarea
                name="remarks"
                class="form-control"
                rows="4"><?= htmlspecialchars($lead['remarks']); ?></textarea>

            </div>

        </div>

        <button
        type="submit"
        class="btn btn-success">

            Update Lead

        </button>

        <button
        type="button"
        class="btn btn-secondary"
        onclick="loadPage('modules/leads/index.php')">

            Cancel

        </button>

    </form>

</div>


</div>
