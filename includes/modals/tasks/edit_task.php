<div id="edit_task" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Sửa nhiệm vụ</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" enctype="multipart/form-data" id="form-edit">
                    <input class="edit_id" type="hidden" name="id">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Tiêu đề</label>
								<input class="form-control edit_title" name="title" type="text">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày bắt đầu</label>
								<input type="date" name="start_date" class="form-control edit_start_date">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày kết thúc</label>
								<input type="date" name="end_date" class="form-control edit_end_date">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Dự án</label>
								<select name="project_id" id="" class="form-control edit_project select">
								<?php 
											$sql3 = "SELECT * from projects";
											$query3 = $dbh -> prepare($sql3);
											$query3->execute();
											$result3=$query3->fetchAll(PDO::FETCH_OBJ);
											foreach($result3 as $row)
											{          
												?>  
											<option value="<?=htmlentities($row->id)?>">
											<?php echo htmlentities($row->name); ?></option>
											<?php } ?> 
                                </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Nhân viên thực hiện</label>
                                <select name="employee_id" id="" class="form-control edit_employee select">
                                    <option value="">Chọn nhân viên thực hiện</option>
										  <?php 
											$sql2 = "SELECT * from employees";
											$query2 = $dbh -> prepare($sql2);
											$query2->execute();
											$result2=$query2->fetchAll(PDO::FETCH_OBJ);
											foreach($result2 as $row)
											{          
												?>  
											<option value="<?=htmlentities($row->id)?>">
											<?php echo htmlentities($row->firstname)." ".htmlentities($row->lastname); ?></option>
											<?php } ?> 
                                   
                                </select>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Mô tả</label>
                                <textarea name="description" rows="4" class="form-control"  id="edit_description" placeholder="Enter your message here"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Status</label>
                                <select name="status" class="form-control select edit_status" id="">
									<option value="">Chọn trạng thái</option>
									<option value="0">Đang thực hiện</option>
									<option value="1">Đã hoàn thành</option>
									<option value="2">Đã review</option>
								</select>
							</div>
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" name="update_task">Lưu</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>