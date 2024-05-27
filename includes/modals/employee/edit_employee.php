<div id="edit_employee" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Sửa nhân viên</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" enctype="multipart/form-data" id="form-edit">
								<div class="row">
									<input type="hidden" name="id" class="edit_id">
										<div class="col-sm-6">
											<div class="form-group">
												<label class="col-form-label">Họ đệm <span class="text-danger">*</span></label>
												<input name="firstname"  class="edit_firstname form-control" type="text">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="col-form-label">Tên</label>
												<input name="lastname"  class="edit_lastname form-control" type="text">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="col-form-label">Email <span class="text-danger">*</span></label>
												<input name="email"  class="edit_email form-control" type="email">
											</div>
										</div>
										<div class="col-sm-6">  
											<div class="form-group">
												<label class="col-form-label">Mã nhân viên <span class="text-danger">*</span></label>
												<input name="uuid" readonly type="text" value="" class="form-control edit_uuid ">
											</div>
										</div>
										
										<div class="col-sm-6">
											<div class="form-group">
												<label class="col-form-label">Số điện thoại </label>
												<input name="phone"  class="form-control edit_phone" type="text">
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
												<label>Phòng ban <span class="text-danger">*</span></label>
												<select  name="department_id" class="select form-control edit_department">
													<option value="">Chọn phòng ban</option>
													<?php
													$sql2 = "SELECT * from departments";
													$query2 = $dbh->prepare($sql2);
													$query2->execute();
													$result2 = $query2->fetchAll(PDO::FETCH_OBJ);
													foreach ($result2 as $row) {
														?>  
												<option value="<?php echo htmlentities($row->id); ?>">
												<?php echo htmlentities($row->name); ?></option>
											<?php } ?> 
												</select>
											</div>
										</div>
										<div class="col-sm-6">  
											<div class="form-group">
												<label class="col-form-label">Lương cơ bản<span class="text-danger">*</span></label>
												<input name="basic_salary"  type="text" value="" class="form-control edit_basic_salary">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Chức vụ <span class="text-danger">*</span></label>
												<select  name="designation_id" class="select form-control edit_designation">
													<option value="">Chọn chức vụ</option>
													<?php
													$sql2 = "SELECT * from designations";
													$query2 = $dbh->prepare($sql2);
													$query2->execute();
													$result2 = $query2->fetchAll(PDO::FETCH_OBJ);
													foreach ($result2 as $row) {
														?>  
												<option value="<?php echo htmlentities($row->id); ?>">
												<?php echo htmlentities($row->name); ?></option>
											<?php } ?> 
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="col-form-label">Ảnh nhân viên</label>
												<input class="form-control"  name="avatar" type="file">
												<input class="form-control edit_avatar"  name="old_avatar" type="hidden">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="col-form-label">Ngày tham gia<span class="text-danger">*</span></label>
												<input name="join_date"  class="form-control datepicker edit_join_date" type="date">
											</div>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" name="update_employee">Lưu</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>