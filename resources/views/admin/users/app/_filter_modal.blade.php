<div class="modal fade" id="filter-modal" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" class="close">×</button>
                    <h4 class="modal-title">Filter Users</h4>
                </div>
                <div class="modal-body">

                    @include('admin.partials._filter_user')

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info" id="add-section">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>