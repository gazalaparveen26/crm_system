<div class="card shadow border-0">

    <div class="card-header bg-primary text-white">

        <h4 class="mb-0">
            Add New Lead
        </h4>

    </div>

    <div class="card-body">

        <form
        action="modules/leads/store.php"
        method="POST">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Lead Name *
                    </label>

                    <input
                    type="text"
                    name="lead_name"
                    class="form-control"
                    required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Company Name
                    </label>

                    <input
                    type="text"
                    name="company_name"
                    class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                    type="email"
                    name="email"
                    class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Phone
                    </label>

                    <input
                    type="text"
                    name="phone"
                    class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Source
                    </label>

                    <select
                    name="source"
                    class="form-select">

                        <option value="website">Website</option>
                        <option value="facebook">Facebook</option>
                        <option value="instagram">Instagram</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="referral">Referral</option>
                        <option value="google">Google</option>
                        <option value="other">Other</option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                    name="status"
                    class="form-select">

                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="qualified">Qualified</option>
                        <option value="proposal_sent">Proposal Sent</option>
                        <option value="won">Won</option>
                        <option value="lost">Lost</option>

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
                    class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Follow Up Date
                    </label>

                    <input
                    type="date"
                    name="followup_date"
                    class="form-control">

                </div>

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Remarks
                    </label>

                    <textarea
                    name="remarks"
                    class="form-control"
                    rows="4"></textarea>

                </div>

            </div>

            <button
            type="submit"
            class="btn btn-success">

                Save Lead

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