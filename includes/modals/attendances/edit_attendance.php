<div class="modal custom-modal fade" id="edit_attendance" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa chấm công</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form-edit">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label>Nhân viên</label>
                            <select name="employee_id" id="edit_employee" class="select">
                                <option value="">Select Employee</option>
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
                        <div class="form-group">
                            <label>Thời gian vào <span class="text-danger">*</span></label>
                            <input type="time" name="checkin" id="edit_checkin" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Thời gian tan làm <span class="text-danger">*</span></label>
                            <input name="checkout" id="edit_checkout" class="form-control" type="time">
                        </div>
                        <div class="form-group">
                            <label>Trạng thái <span class="text-danger">*</span></label>
                            <input name="old_status" id="edit_status" class="form-control" type="text" readonly>
                            <input name="status" class="form-control" type="hidden">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn" name="update_attendance">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>