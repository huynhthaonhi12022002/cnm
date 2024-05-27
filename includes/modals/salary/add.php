<div id="add_salary" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Thêm bảng lương</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" id="form-add">
									<div class="row"> 
										<div class="col-sm-6"> 
											<div class="form-group">
												<label>Nhân viên</label>
												<select name="employee_id" id="" class="form-control select">
												<option value="">Chọn nhân viên tính lương</option>
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
											<input type="hidden" name="basic_salary" id="basic_salary" value="">
										</div>
										<div class="col-sm-6"> 
											<div class="form-group">
												<label>Hình thức thanh toán</label>
												<select name="paid_type" class="form-control select" id="">
													<option value="">Chọn hình thức thanh toán</option>
													<option value="1">Tiền mặt</option>
													<option value="2">Bank</option>
													<option value="3">Ví điện tử</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row"> 
										<div class="col-sm-6"> 
											<div class="form-group">
												<label>Số ngày công</label>
												<input type="number" name="work_day" id="" class="form-control">
											</div>
										</div>
										<div class="col-sm-6"> 
											<div class="form-group">
												<label>Lương tháng</label>
												<input type="month" name="month_salary" id="" class="form-control">
											</div>
										</div>
									</div>
									<div class="row"> 
										<div class="col-sm-6"> 
											<div class="form-group">
												<label>Phụ cấp (xăng xe, ăn uống,...)</label>
												<input type="number" name="allowance" id="" class="form-control" value="0">
											</div>
										</div>
										<div class="col-sm-6"> 
											<div class="form-group">
												<label>Khoản khấu trừ</label>
												<input type="number" name="deduction" id="" class="form-control" value="0">
											</div>
										</div>
									</div>
									<div class="row"> 
										<div class="col-sm-6"> 
											<div class="form-group">
												<label>Trạng thái</label>
												<select name="status" class="form-control select" id="">
													<option value="">Chọn trạng thái</option>
													<option value="1">Đã thanh toán</option>
													<option value="0">Chưa thanh toán</option>
												</select>
											</div>
										</div>
										<div class="col-sm-6"> 
											<div class="form-group">
												<label>Ngày thanh toán</label>
												<input type="date" name="paid_date" id="" class="form-control">
											</div>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" name="add_payroll">Lưu</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>