<?php $set = '1234567890';
$id = substr(str_shuffle($set), 0, 6); ?>
<div id="edit_asset" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-md" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Sửa tài sản</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="POST" id="form-edit">
								<div class="row">
									<input type="hidden" name="id" class="edit_id">
										<div class="col-md-6">
											<div class="form-group">
												<label>Tên tài sản</label>
												<input name="name" class="form-control edit_name" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Mã tài sản</label>
												<input readonly name="uuid" class="form-control edit_uuid" type="text">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Ngày mua</label>
												<input name="purchase_date"  class="form-control datetimepicker edit_purchase_date" type="date">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Mua từ</label>
												<input name="purchase_from" class="form-control edit_purchase_from" type="text">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Nhà sản xuất</label>
												<input name="manufacturer" class="form-control edit_manufacturer" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Model</label>
												<input name="model" class="form-control edit_model" type="text">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Trạng thái</label>
												<select name="status" class="select edit_status">
													<option value="">Chọn trạng thái</option>
													<option value="0">Pending</option>
													<option value="1">Approved</option>
													<option value="2">Deployed</option>
													<option value="3">Damaged</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Nhà cung cấp</label>
												<input name="supplier" class="form-control edit_supplier" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Tình trạng</label>
												<input name="condition" class="form-control edit_condition" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Bảo hành</label>
												<input name="warranty" class="form-control edit_warranty" type="text" placeholder="In Months">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Giá</label>
												<input placeholder="1800" name="value"  class="form-control edit_value" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Serial number</label>
												<input name="serial_number" class="form-control edit_serial_number" type="text">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label>Mô tả</label>
												<textarea name="description" class="form-control edit_description"></textarea>
											</div>
										</div>
										
									</div>
									
									<div class="submit-section">
										<button type="submit" name="update_asset" class="btn btn-primary submit-btn">Lưu</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
