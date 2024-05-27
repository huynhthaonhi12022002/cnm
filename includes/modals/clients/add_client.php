<?php $set = '1234567890';
$id = substr(str_shuffle($set), 0, 6); ?>
<div id="add_client" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Thêm khách hàng</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="POST" enctype="multipart/form-data" id="form-add">
									<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-form-label" >Họ đệm <span class="text-danger">*</span></label>
											<input class="form-control"  name="firstname" value="" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-form-label" >Tên</label>
											<input class="form-control" name="lastname" value="" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-form-label" >Địa chỉ <span class="text-danger">*</span></label>
											<input class="form-control"  name="address" value="" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-form-label" >Email <span class="text-danger">*</span></label>
											<input class="form-control floating" name="email" value="" type="email">
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-form-label" >Số điện thoại </label>
											<input class="form-control"name="phone" value="" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-form-label">Công ty</label>
											<input class="form-control" name="company" type="text" value="">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="col-form-label" >Ảnh khách hàng</label>
											<input class="form-control"  name="avatar" type="file" value="">
										</div>
									</div>
										
									</div>
									<div class="submit-section">
										<button type="submit" name="add_client" class="btn btn-primary submit-btn">Lưu</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
