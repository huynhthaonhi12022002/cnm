<div id="add_project" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm dự án</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" id="form-add">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tên dự án</label>
                                    <input class="form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Khách hàng</label>
                                    
                                    <select class="select" name="client_id">
                                    <option value="">Chọn khách hàng</option>
                                    <?php 
											$sql2 = "SELECT * from clients";
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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ngày bắt đầu</label>
                                    
                                        <input class="form-control " type="date" name="start_date" id="start">
                                    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ngày kết thúc</label>
                                  
                                        <input class="form-control  " name="end_date" type="date" id="end">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Chi phí</label>
                                    <input placeholder="" name="rate" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ưu tiên</label>
                                    <select class="select" name="priority">
                                        <option value="">Chọn ưu tiên</option>
                                        <option>High</option>
                                        <option>Medium</option>
                                        <option>Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Lãnh đạo dự án</label>
                                    <select class="select" name="leader">
                                        <option value="">Chọn lãnh đạo dự án</option>
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
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Thêm thành viên</label>
                                    <select class="select" multiple name="team[]">
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
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" rows="4" class="form-control" placeholder="Enter your message here"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Upload Files</label>
                            <input class="form-control" name="files[]" accept=".pdf,.docx,.xls,.csv,.png,.jpg" multiple type="file">
                       
                        </div>
                        
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn" name="add_project">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>