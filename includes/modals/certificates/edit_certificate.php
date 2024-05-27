<div id="edit_certificate" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Sửa bằng cấp</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="POST" id="form-edit">
									<div class="row">
										<input type="hidden" name="id" class="edit_id">
										<div class="col-sm-12">
											<div class="form-group">
												<label>Tên bằng cấp</label>
												<input name="name" type="text" required class="form-control edit_name">
											</div>
										</div>
									</div>
									<div class="submit-section">
										<button type="submit" name="update_certificate" class="btn btn-primary submit-btn">Lưu</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>