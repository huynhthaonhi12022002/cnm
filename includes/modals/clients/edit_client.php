<div id="edit_client" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form-edit">
                    <div class="row">
						<input type="hidden" name="id" id="edit_id">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="edit_firstname">Họ đệm<span class="text-danger">*</span></label>
                                <input class="form-control" id="edit_firstname" name="firstname" value="" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="edit_lastname">Tên</label>
                                <input class="form-control" id="edit_lastname" name="lastname" value="" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="edit_address">Địa chỉ <span class="text-danger">*</span></label>
                                <input class="form-control" id="edit_address" name="address" value="" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="edit_email">Email <span class="text-danger">*</span></label>
                                <input class="form-control floating" id="edit_email" name="email" value="" type="email">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="edit_phone">Số điện thoại </label>
                                <input class="form-control" id="edit_phone" name="phone" value="" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="edit_company">Công ty</label>
                                <input class="form-control" id="edit_company" name="company" type="text" value="">
                            </div>
                        </div>
						<div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label" for="edit_avatar">Ảnh khách hàng</label>
                                <input class="form-control" id="edit_avatar1" name="avatar" type="file" value="">
								<input type="hidden" id="edit_avatar" name="old_avatar" value="">
                            </div>
                        </div>
                    </div>
                    
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" name="update_client">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
