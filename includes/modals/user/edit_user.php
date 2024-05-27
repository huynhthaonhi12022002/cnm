<div id="edit_user" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Sửa người dùng</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="POST" enctype="multipart/form-data" id="form-edit">
									<div class="row">
									<div class="col-sm-6">
											<div class="form-group">
												<label>Tên <span class="text-danger">*</span></label>
												<input class="form-control edit_name"  name="name" type="text">
											</div>
										</div>
								
										<div class="col-sm-6">
											<div class="form-group">
												<label>Email <span class="text-danger">*</span></label>
												<input class="form-control edit_email"  name="email" type="email">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Mật khẩu</label>
												<input class="form-control" name="password"  type="password">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Nhập lại mật khẩu</label>
												<input class="form-control" name="confirm_password"  type="password">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Trạng thái </label>
												<select name="status" id="" class="select form-control edit_status">
													<option value="">Chọn trạng thái</option>
													<option value="1">Active</option>
													<option value="0">InActive</option>
													
												</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Vai trò </label>
												<select name="role" id="" class="select form-control edit_role">
													<option value="">Chọn vai trò</option>
													<option value="1">Admin</option>
													<option value="0">Employee</option>
												</select>
											</div>
										</div>
										
										<div class="col-sm-12">
										<div class="form-group">
												<label>Avatar <span class="text-danger">*</span></label>
												<input class="form-control"  name="avatar" type="file">
												<input class="form-control edit_avatar"  name="old_avatar" type="hidden">

											</div>
										</div>
									
										<div class="col-sm-12">
											<div class="submit-section">
												<button type="submit" name="update_user" class="btn btn-primary submit-btn">Lưu</button>
											</div>
										</div>
								</form>
							</div>
						</div>
					</div>
				</div>