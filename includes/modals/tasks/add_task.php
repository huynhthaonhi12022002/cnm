<div id="add_task" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Thêm nhiệm vụ</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="form-add">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Tiêu đề</label>
								<input class="form-control" name="title" type="text">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày bắt đầu</label>
								<input type="date" name="start_date" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày kết thúc</label>
								<input type="date" name="end_date" class="form-control">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Dự án</label>
								<select name="project_id" id="" class="form-control select">
                                    <option value="">Chọn dự án</option>
									<?php 
										$sql1 = "SELECT * from projects";
										$query1 = $dbh -> prepare($sql1);
										$query1->execute();
										$result1=$query1->fetchAll(PDO::FETCH_OBJ);
										foreach($result1 as $row)
										{          
										?>  
									<option value="<?php echo htmlentities($row->id);?>">
									<?php echo htmlentities($row->name);?>
									</option>
									<?php } ?> 

                                </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Nhân viên thực hiện</label>
                                <select name="employee_id" id="" class="form-control select">
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
                                <textarea name="description" rows="4" class="form-control" placeholder="Enter your message here"></textarea>

							</div>
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" name="add_task">Lưu</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>