<script src="<?= $base_url ?>helper/js/jquery-2.1.4.js"></script>
<script src="<?= $base_url ?>helper/js/voucher_update.js"></script>
<div class="panel panel-default input_form_inner_content">
    <div class="panel-heading">
        <h3 class="panel-title page_title"><?= $reqPage['page_title'] ?>
            <ol class="breadcrumb">
                <li><?= $reqPage['module_title'] ?></li>
                <li class="active"><a
                            href="?module=<?= $reqPage['module_value'] ?>&page=<?= $reqPage['page_value'] ?>"><?= $reqPage['page_title'] ?></a>
                </li>
            </ol>
        </h3>
    </div>
    <div class="panel-body">
        <div class="input_field_content">
            <div class="row">
                <?php
                $userId = $_SESSION['user_srl_id'];
                $arr = array();
                $dt1 = date('Y-m-d');
                $dt2 = date('Y-m-d');
                if (isset($_POST['btnShowCrReport'])) {
                    $dt1 = $_POST['from_dt'];
                    $dt2 = $_POST['to_dt'];
                    $step = 1;
                    header("Location:?module=accounts&page=voucher_update&from_dt=$dt1&to_dt=$dt2&step=$step");
                    exit;
                }
                if (isset($_GET['from_dt']) && isset($_GET['to_dt'])) {
                    $dt1 = $_GET['from_dt'];
                    $dt2 = $_GET['to_dt'];
                    $step = $_GET['step'];
                }

                $fromDt = $dt1 . " 00:00:00";
                $toDt = $dt2 . " 23:59:00";

                if ($fromDt == '' || $toDt == '') {
                    $_SESSION['userMsg'] = "Sorry, you have submitted blank field !";
                    $_SESSION['alert'] = "danger";
                    header("Location:?module=accounts&page=voucher_update&from_dt=$dt1&to_dt=$dt2&step=$step");
                    exit;
                }
                if ($fromDt > $toDt) {
                    $_SESSION['userMsg'] = "Sorry, From-date cann't be greater than To-date !";
                    $_SESSION['alert'] = "danger";
                    //header("Location:?module=accounts&page=voucher_summary&from_dt=$dt1&to_dt=$dt2&step=$step");
                    //exit;
                }
                // start setting for pagination
                $srl = 1;
                $step = $_GET['step'];
                $table = 'tbl_voucher_list';
                $where = "user_id='$userId' AND voucher_dt BETWEEN '$fromDt' AND '$toDt' AND voucher_status=1";
                $dataDisplay = 10;
                $totalRows = 0; // its 0 when table name is pass
                $pagination = getPagination($table, $where, $step, $dataDisplay, $totalRows); //print_r($pagination);
                $offset = $pagination['offset'];
                $limit = $pagination['limit'];
                if ($step > 1) {
                    $srl = 0;
                    $srl = ($step - 1) * $dataDisplay + 1;
                }
                // end setting for pagination

                $sql = "SELECT * FROM `tbl_voucher_list` 
                    WHERE $where ORDER BY voucher_dt DESC LIMIT $offset, $limit";

                //$arr = selectAllRows($sql);
                ?>

                <div class="row" style="padding:15px;">
                    <div class="col-lg-12 rpt_filter" style="text-align:left">
                        <form method="post">
                            <div class="row">
                                <!--<div class="col-lg-4">Voucher Title:<br/><input type="text" name="voucherTitle" class="form-control"></div>-->
                                <div class="col-lg-3">From:<br/><input type="text" name="from_dt"
                                                                       value="<?= ($_GET['from_dt'] != '') ? $_GET['from_dt'] : date('Y-m-d') ?>"
                                                                       class="tcal form-control"></div>
                                <div class="col-lg-3">To:<br/><input type="text" name="to_dt"
                                                                     value="<?= ($_GET['to_dt'] != '') ? $_GET['to_dt'] : date('Y-m-d') ?>"
                                                                     class="tcal form-control"></div>
                                <div class="col-lg-2"><br/><input type="submit" name="btnShowCrReport"
                                                                  class="btn btn-primary" value="Show Report"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                // start updating=====================================================
                if (isset($_POST['updateVoucherBtn'])) {
                    $countUpdate = 0;
                    $countSavedRow = 0;
                    $voucherId = $_POST['voucherId'];

                    if ($_POST['del_ids'] != '')// for previous data
                    {
                        $del_ids = $_POST['del_ids'];
                        mysql_query("DELETE FROM tbl_voucher_details WHERE id IN ($del_ids)");

                    }
                    for ($i = 0; $i < count($_POST['hName']); $i++) {
                        $headType = $_POST['hType'][$i];
                        $hNameId = $_POST['hName'][$i];
                        $desc = trim($_POST['crdrDesc'][$i]);
                        $itemDate = $_POST['itemDate'][$i];
                        $amount = $_POST['itemAmount'][$i];
                        $row_id = $_POST['voucherDetRowId'][$i];

                        if ($headType != '' && $hNameId != '' && $amount != '') {

                            $data = array(
                                'voucher_id' => $voucherId,
                                'head_type' => $_POST['hType'][$i],
                                'head_name_id' => $_POST['hName'][$i],
                                'description' => $_POST['crdrDesc'][$i],
                                'item_dt' => $_POST['itemDate'][$i],
                                'amount' => $_POST['itemAmount'][$i],
                                'user_id' => $userId
                            );

                            if ($row_id == 0) {
                                $isInsert2 = insertData("tbl_voucher_details", $data);
                                if ($isInsert2) {
                                    $countSavedRow++;
                                }
                            } else {
                                $where = array(
                                    'id' => $row_id,
                                );
                                $isUpdate = updateData("tbl_voucher_details", $data, $where);
                                $countUpdate++;
                            }
                        }
                    }
                    if ($countUpdate > 0 || $countSavedRow > 0) {
                        $from = $_POST['fromDt'];
                        $to = $_POST['toDt'];
                        $step = $_POST['step'];

                        $_SESSION['alert'] = "success";
                        if ($countUpdate == 1) {
                            $updateItem = "1 item is updated";
                        }
                        if ($countUpdate > 1) {
                            $updateItem = "$countUpdate items are updated";
                        }
                        if ($countSavedRow == 1) {
                            $item = "1 item is new-inserted";
                        }
                        if ($countSavedRow > 1) {
                            $item = "$countSavedRow items are new-inserted";
                        }

                        if ($updateItem != '' && $item != '') {
                            $_SESSION['userMsg'] = "Total $updateItem and $item successfully !";
                        } else {
                            $_SESSION['userMsg'] = "Total $updateItem  $item successfully !";
                        }

                        header("Location:?module=accounts&page=voucher_update&from_dt=$from&to_dt=$to&step=$step&vId=$voucherId");
                        exit;
                    } else {
                        $from = $_POST['fromDt'];
                        $to = $_POST['toDt'];
                        $step = $_POST['step'];

                        if ($countUpdate == 0) {
                            if ($countSavedRow == 1) {
                                $item = "1 item is new-inserted";
                            }
                            if ($countSavedRow > 1) {
                                $item = "$countSavedRow items are new-inserted";
                            }
                            if ($countSavedRow > 0) {
                                $_SESSION['alert'] = "success";
                                $_SESSION['userMsg'] = "Total $item successfully !";
                            } else {
                                $_SESSION['alert'] = "warning";
                                $_SESSION['userMsg'] = "You have made no change to save !";
                            }
                            header("Location:?module=accounts&page=voucher_update&from_dt=$from&to_dt=$to&step=$step&vId=$voucherId");
                            exit;
                        } else {
                            $_SESSION['alert'] = "danger";
                            $_SESSION['userMsg'] = "Sorry, data not updated properly. Please check the voucher!";
                            header("Location:?module=accounts&page=voucher_update&from_dt=$from&to_dt=$to&step=$step&vId=$voucherId");
                            exit;
                        }

                    }
                }
                // end updating========================================
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php
                                $v = 1;
                                $uniqueRowID = 0;
                                $arr = selectAllRows($sql);
                                if (count($arr) > 0) {
                                    foreach ($arr as $row) {
                                        ?>
                                        <form method="post" style="margin-bottom:3px">

                                            <input type='hidden' name='voucherId' value="<?= $row['id'] ?>">
                                            <input type="hidden" name="fromDt" value="<?= $_GET['from_dt'] ?>">
                                            <input type="hidden" name="toDt" value="<?= $_GET['to_dt'] ?>">
                                            <input type="hidden" name="stepNo" value="<?= $_GET['step'] ?>">

                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading<?= $uniqueRowID ?>">
                                                    <h4 class="panel-title">
                                                        <a style="display:block" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#<?= $uniqueRowID ?>"
                                                           aria-expanded="true" aria-controls="collapseOne">
                                                            <?= $srl++ ?>.&nbsp;<?= $row['voucher_title'] ?>&nbsp;&nbsp;<span
                                                                    style="color:#0FA1DB">[<?= $row['voucher_dt'] ?>
                                                                ]</span>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="<?= $uniqueRowID++ ?>"
                                                     class="panel-collapse <?= ($_GET['vId'] == $row['id']) ? "in" : "collapse" ?>"
                                                     role="tabpanel" aria-labelledby="heading<?= $row['id'] ?>">
                                                    <div class="panel-body table-responsive">
                                                        <?php
                                                        if ($_SESSION['userMsg'] != "" && ($_GET['vId'] == $row['id'])) {
                                                            ?>
                                                            <div class="row" style="padding:0px 15px">
                                                                <div class="alert alert-<?= $_SESSION['alert'] ?>">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="alert"
                                                                            aria-hidden="true">&times;
                                                                    </button>
                                                                    <?php
                                                                    echo "\t" . $_SESSION['userMsg'];

                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>

                                                        <div style="margin-bottom:2px;padding:5px">
                                                            <b>Voucher No. :</b> <i><?= $row['voucher_nr'] ?></i><br/>
                                                            <b>Created Date :</b>
                                                            <i><?= getFormatedDt("Y-m-d H:i", $row['voucher_dt']) ?></i>
                                                        </div>
                                                        <table class="table table-bordered">
                                                            <thead class="rpt_thead">
                                                            <tr style="text-align: center;">
                                                                <th style="width:20px;text-align:center">#</th>
                                                                <th style="width:80px;text-align:center;width:200px">
                                                                    Head Name
                                                                </th>
                                                                <th style="width:150px;text-align:center;width:80px">
                                                                    Head Type
                                                                </th>
                                                                <th style="width:150px;text-align:center;width:220px">
                                                                    Cr/Dr Description
                                                                </th>
                                                                <th style="width:120px;text-align:center;width:140px">
                                                                    Date
                                                                </th>
                                                                <th style="width:90px;text-align:center">Amount (Tk)
                                                                </th>
                                                                <th style="text-align:center">#</th>
                                                            </tr>
                                                            </thead>
                                                            <?php
                                                            $tID = 'as' . $uniqueRowID++;
                                                            ?>
                                                            <tbody id="<?= $tID ?>">
                                                            <?php
                                                            $i = 1;
                                                            $total = 0;
                                                            $id = $row['id'];
                                                            $commonId = $id;
                                                            $sql2 = "SELECT * FROM `tbl_voucher_details` where voucher_id=$id";
                                                            $arr2 = selectAllRows($sql2);
                                                            if (is_array($arr2))
                                                            {
                                                            foreach ($arr2 as $row2) {
                                                                if ($row2['head_type'] == 'Cr') {
                                                                    $amount = sprintf("%.2f", $row2['amount']);
                                                                    $itemAmount = $amount;
                                                                    $total += $amount;
                                                                }
                                                                if ($row2['head_type'] == 'Dr') {
                                                                    $amount = sprintf("%.2f", $row2['amount']);
                                                                    $itemAmount = "-" . $amount;
                                                                    $total += (-1 * $amount);
                                                                }
                                                                $voucher_id = $row2['id'];
                                                                $trID = 'tr' . $uniqueRowID++;
                                                                ?>
                                                                <tr id="<?= $trID ?>" class="voucherRow">
                                                                    <td style='text-align:center' class="tr_sl_no">
                                                                        <?= $i++ ?>
                                                                    </td>
                                                                    <td style='text-align:center'>
                                                                        <select name="hName[]" style="width:200px"
                                                                                class="form-control voucher_head"
                                                                                onchange="toggleInputFields(this.value);totalAmountEdit('<?= $tID ?>');">
                                                                            <option value=''>-Select-</option>
                                                                            <?php
                                                                            $sl = 1;
                                                                            $sql = "SELECT * FROM `tbl_account_heads` 
                                                                                    WHERE user_id='$userId' AND head_status=1 ORDER BY name";
                                                                            //echo "<option>$sql</option>";
                                                                            $run = mysql_query($sql);
                                                                            echo $num = mysql_num_rows($run);
                                                                            if ($num > 0) {
                                                                                while ($row = mysql_fetch_array($run)) {
                                                                                    ?>
                                                                                    <option value="<?= $row['id'] ?>" <?= ($row2['head_name_id'] == $row['id']) ? "selected = 'selected'" : "" ?>><?= $sl++ . ". " . $row['name'] ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <input type='hidden'
                                                                               value="<?= ($row2['id'] != '') ? $row2['id'] : "0" ?>"
                                                                               name='voucherDetRowId[]'>
                                                                        <input type="hidden" value="<?= $voucher_id ?>"
                                                                               class="voucher_id">
                                                                    </td>
                                                                    <td style='text-align:center'>
                                                                        <select name="hType[]" style="width:100px"
                                                                                class="form-control hType"
                                                                                onchange="totalAmountEdit('<?= $tID ?>');">
                                                                            <option value="Cr" <?= ($row2['head_type'] == 'Cr') ? "selected = 'selected'" : "" ?>>
                                                                                Income
                                                                            </option>
                                                                            <option value="Dr" <?= ($row2['head_type'] == 'Dr') ? "selected = 'selected'" : "" ?>>
                                                                                Cost
                                                                            </option>
                                                                        </select>
                                                                    </td>
                                                                    <td style='text-align:center'><input type="text"
                                                                                                         name="crdrDesc[]"
                                                                                                         value="<?= $row2['description'] ?>"
                                                                                                         class="form-control pDesc">
                                                                    </td>
                                                                    <td style='text-align:center'><input type="text"
                                                                                                         name="itemDate[]"
                                                                                                         value="<?= date('Y-m-d H:i', strtotime($row2['item_dt'])); ?>"
                                                                                                         class="form-control">
                                                                    </td>
                                                                    <td style='text-align:right'><input type="text"
                                                                                                        name="itemAmount[]"
                                                                                                        value="<?= $amount; ?>"
                                                                                                        class="form-control tAmount"
                                                                                                        onkeyup="totalAmountEdit('<?= $tID ?>');"
                                                                                                        style="text-align:right">&nbsp;
                                                                    </td>
                                                                    <td style="width:40px;text-align:center">
                                                                        <a href="javascript:removeThisTrFromVoucherList('<?= $trID ?>','<?= $commonId ?>');totalAmountEdit('<?= $tID ?>');setItemSerial('<?= $tID ?>');"
                                                                           id="remCF">
                                                                            <i class="fa fa-minus-circle"
                                                                               style="color:#D32826;font-size:22px;vertical-align:middle;"
                                                                               title="Remove"></i>
                                                                        </a>

                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            $total = sprintf("%.2f", $total);
                                                            ?>

                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <td colspan="5">Total</td>
                                                                <td style="text-align:right"><input type="text"
                                                                                                    name="txtTotalAmount"
                                                                                                    value="<?= $total ?>"
                                                                                                    class="form-control <?= $tID ?>"
                                                                                                    style="width:90px;text-align:right"
                                                                                                    readonly></td>
                                                                <td style="width:40px;text-align:center">
                                                                    <a href="javascript:voucherEntyrListNew('<?= $tID ?>');">
                                                                        <i class="fa fa-plus-circle"
                                                                           style="color:#47B8D9;font-size:26px;vertical-align:middle;"
                                                                           title="+ Add New Item"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            </tfoot>
                                                        <?php
                                                        }
                                                        ?>
                                                        </table>
                                                    </div>
                                                    <div class="row"
                                                         style="text-align:right;margin:-10px 0px 13px 0px;">
                                                        <div class="col-lg-12">
                                                            <input type="hidden" value=""
                                                                   name="del_ids" id="del_ids_<?= $commonId ?>">
                                                            <input type="submit" name="updateVoucherBtn"
                                                                   value="Update Now" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                    unset($_SESSION['userMsg']);
                                } else {
                                    echo "<div style='text-align:center;color:#D32826;padding:10px;text-align:center;border:1px solid #ddd'>Data not found !</div>";
                                }
                                ?>
                            </div>
                            <div style="padding:10px 1px 5px 1px">
                                <?php
                                $redirect = "?module=accounts&page=voucher_update&from_dt=" . $_GET[from_dt] . "&to_dt=" . $_GET[to_dt] . "&vId=" . $_GET['vId'] . "&step";
                                echo paginationOfThePage($pagination, $redirect);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--It's add when click Add+ btn-->
            <div style="display: none;">
                <table>
                    <tr valign="top" id="dd">
                        <td style="text-align:center" class="tr_sl_no"></td>
                        <td>
                            <select name="hName[]" style="width:200px" class="form-control voucher_head"
                                    onchange="toggleInputFields(this.value);totalAmountEdit('{TBODYID}');">
                                <option value="">-Select-</option>
                                <?php
                                $n = 1;
                                $sql_head = "SELECT * FROM `tbl_account_heads` 
										WHERE user_id='$userId' AND head_status=1 ORDER BY name";
                                $run_head = mysql_query($sql_head);
                                $headNum = mysql_num_rows($run_head);
                                if ($headNum > 0) {
                                    while ($headArr = mysql_fetch_array($run_head)) {
                                        ?>
                                        <option value="<?= $headArr['id'] ?>"><?= $n++ . ". " . $headArr['name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <input type='hidden'
                                   value="0"
                                   name='voucherDetRowId[]'>
                            <input type="hidden" value="0" class="voucher_id">
                        </td>
                        <td>
                            <select name="hType[]" style="width:120px" readonly="readonly" class="form-control hType"
                                    onchange="totalAmountEdit('{TBODYID}');">
                                <option value="Dr">Cost</option>
                                <option value="Cr">Income</option>
                            </select>
                        </td>
                        <td><input type="text" name="crdrDesc[]" style="width:220px;" class="form-control pDesc"
                                   readonly="readonly"></td>
                        <td><input type="text" name="itemDate[]" style="width:150px" class="tcal form-control"
                                   value="<?= date('Y-m-d H:i') ?>" readonly="readonly"></td>
                        <td style="text-align:center">
                            <input type="text" name="itemAmount[]" style="width:90px;text-align:right"
                                   class="form-control tAmount" readonly="readonly" placeholder="0.00"
                                   onkeyup="totalAmountEdit('{TBODYID}');">
                        </td>
                        <td style="width:40px;text-align:center">
                            <a href="javascript:removeThisTrFromVoucherList('{TRID}');totalAmountEdit('{TBODYID}');setItemSerial('{TBODYID}');">
                                <i class="fa fa-minus-circle"
                                   style="color:#D32826;font-size:22px;vertical-align:middle;" title="Remove"></i>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
            <!--End Add row-->

        </div>
    </div>
</div>