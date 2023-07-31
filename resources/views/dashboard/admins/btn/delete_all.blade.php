<div class="modal fade" id="multipleDelete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="multipleDelete">
             <div class="mb-30">
              <h6>Delete {{ $title }}</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
            <div class="alert alert-danger">
                <div class="empty_record d-none">
                    <h3>Please Check Some {{ ' ' . $title . ' ' }} To Delete </h3>
                </div>
                <div class="not_empty_record d-none">
                    <h3>Are You Sure To Delete <span class="record_count"></span> {{ ' ' . $title . ' ?' }}</h3>
                </div>
            </div>

            <div class="modal-footer">
                <div class="empty_record d-none">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <div class="not_empty_record d-none">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                    <input type="submit" class="btn btn-danger del_all" value="Yes" name="del_all">
                </div>
            </div>
        </div>
        
      </div>
    </div>
</div>
