
<div class="card shadow border-0">

    <div class="card-header bg-primary text-white">

        <h4 class="mb-0">
            Add New Customer
        </h4>

    </div>

    <div class="card-body">

        <form
            action="modules/customers/store.php"
            method="POST">

            <div class="row">

                <!-- Customer Name -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Customer Name *
                    </label>

                    <input
                        type="text"
                        name="customer_name"
                        class="form-control"
                        required>

                </div>

                <!-- Company Name -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Company Name
                    </label>

                    <input
                        type="text"
                        name="company_name"
                        class="form-control">

                </div>

                <!-- Email -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control">

                </div>

                <!-- Phone -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Phone
                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control">

                </div>

                <!-- Alternate Phone -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Alternate Phone
                    </label>

                    <input
                        type="text"
                        name="alternate_phone"
                        class="form-control">

                </div>

                <!-- Website -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Website
                    </label>

                    <input
                        type="text"
                        name="website"
                        class="form-control">

                </div>

                <!-- GST -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        GST Number
                    </label>

                    <input
                        type="text"
                        name="gst_number"
                        class="form-control">

                </div>

                <!-- Customer Type -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Customer Type
                    </label>

                    <select
                        name="customer_type"
                        class="form-select">

                        <option value="individual">
                            Individual
                        </option>

                        <option value="business">
                            Business
                        </option>

                    </select>

                </div>

                <!-- Status -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="active">
                            Active
                        </option>

                        <option value="inactive">
                            Inactive
                        </option>

                    </select>

                </div>

                <!-- Address -->

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Address
                    </label>

                    <textarea
                        name="address"
                        class="form-control"
                        rows="3"></textarea>

                </div>

                <!-- City -->

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        City
                    </label>

                    <input
                        type="text"
                        name="city"
                        class="form-control">

                </div>

                <!-- State -->

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        State
                    </label>

                    <input
                        type="text"
                        name="state"
                        class="form-control">

                </div>

                <!-- Country -->

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Country
                    </label>

                    <input
                        type="text"
                        name="country"
                        class="form-control">

                </div>

                <!-- Postal Code -->

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Postal Code
                    </label>

                    <input
                        type="text"
                        name="postal_code"
                        class="form-control">

                </div>

                <!-- Notes -->

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Notes
                    </label>

                    <textarea
                        name="notes"
                        class="form-control"
                        rows="4"></textarea>

                </div>

            </div>

            <button
                type="submit"
                class="btn btn-success">

                Save Customer

            </button>

            <button
                type="button"
                class="btn btn-secondary"
                onclick="loadPage('modules/customers/index.php')">

                Cancel

            </button>

        </form>

    </div>

</div>