    <div class="card shadow border-0">


    <div class="card-header d-flex justify-content-between">
        <h4 class="mb-0">Add New Task</h4>
        <button class="btn btn-secondary" onclick="loadPage('modules/tasks/index.php')">Back</button>
    </div>

    <div class="card-body">

        <form action="modules/tasks/store.php" method="POST">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Task Title *</label>
                    <input
                    type="text"
                    name="task_title"
                    class="form-control"
                    required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Priority</label>

                    <select
                    name="priority"
                    class="form-select">

                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>

                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>

                    <select
                    name="status"
                    class="form-select">

                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>

                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Date</label>

                    <input
                    type="date"
                    name="start_date"
                    class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Due Date</label>

                    <input
                    type="date"
                    name="due_date"
                    class="form-control">
                </div>

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                    name="description"
                    class="form-control"
                    rows="4"></textarea>

                </div>

            </div>

            <button
            type="submit"
            class="btn btn-success">
                Save Task
            </button>

            <button
            type="button"
            class="btn btn-secondary"
            onclick="loadPage('modules/tasks/index.php')">
                Cancel
            </button>

        </form>

    </div>


    </div>
