<div id="edit_job" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Sửa công việc</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" enctype="multipart/form-data" id="form-edit">
					<div class="row">
						<input type="hidden" name="id" class="edit_id">
						<div class="col-md-6">
							<div class="form-group">
								<label>Tên chức vụ</label>
								<input class="form-control edit_title" name="title" type="text">
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
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Địa chỉ</label>
								<input class="form-control edit_location" name="location" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Số nhân viên cần tuyển</label>
								<input class="form-control edit_vacancies" name="vacancies" type="text">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Kinh nghiệm</label>
								<input class="form-control edit_experience" name="experience" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Tuổi</label>
								<input class="form-control edit_age" name="age" type="text">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Lương từ</label>
								<input type="text" name="salary_from" class="form-control edit_salary_from">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Đến lương</label>
								<input type="text" name="salary_to" class="form-control edit_salary_to">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Loại việc làm</label>
								<select name="type" class="select edit_type">
								<option value="">Chọn loại việc làm</option>

									<option>Full Time</option>
									<option>Part Time</option>
									<option>Internship</option>
									<option>Temporary</option>
									<option>Remote</option>
									<option>Others</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Trạng thái</label>
								<select name="status" class="select edit_status">
								<option value="">Chọn trạng thái</option>

									<option>Open</option>
									<option>Closed</option>
									<option>Cancelled</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày bắt đầu</label>
								<input type="date" name="start_date" class="form-control datetimepicker edit_start_date">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày hết hạn</label>
								<input type="date" name="expire_date" class="form-control datetimepicker edit_expire_date">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Mô tả</label>
								<textarea id="e_description" class="form-control edit_description" name="description"></textarea>
							</div>
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" name="update_job">Lưu</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>