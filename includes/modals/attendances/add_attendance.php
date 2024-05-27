<div class="modal custom-modal fade" id="add_attendance" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm chấm công</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  method="post" id="form-add">

                        <div class="form-group">
                            <label>Nhân viên</label>
                            <select name="employee_id" class="select">
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
                            <input type="time" name="checkin" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Thời gian tan làm <span class="text-danger">*</span></label>
                            <input name="checkout" class="form-control" type="time">
                        </div>
                        <div class="submit-section">
                            <button type="submit" name="add_attendance" class="btn btn-primary submit-btn">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>