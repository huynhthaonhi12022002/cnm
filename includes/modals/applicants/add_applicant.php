<div class="modal custom-modal fade" id="apply_job" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đơn xin ứng tuyển</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form-add">
                    <input type="hidden" name="job_id" value="1">
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input class="form-control" name="name" type="text">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" name="email" type="text">
                    </div>
                    <div class="form-group">
                        <label>Lời nhắn</label>
                        <textarea class="form-control" name="message"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Upload your CV</label>
                        <input type="file" name="cv" class="form-control" id="cv_upload">
                       
                    </div>
                    <input type="hidden" name="status" value="New">

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" name="add_applicant">Gửi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>