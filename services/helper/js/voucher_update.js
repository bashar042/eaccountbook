/**
 * Created by A Bashar on 10/12/2017.
 */

function t(t) {
    console.log(t);
}
$(document).ready(function () {
    $(document).on('keyup', '.tAmount', function () {
        var tID = $(this).closest('tbody').attr('id');
        totalAmountEdit(tID);
    });
});
function voucherEntyrListNew(voucherEntyrListNew) {
    var trFr = $('#dd').html();
    var trID = makeUniqueString();
    trFr = trFr.replace(new RegExp("{TRID}", 'g'), trID);
    trFr = trFr.replace(new RegExp("{TBODYID}", 'g'), voucherEntyrListNew);
    $("#" + voucherEntyrListNew).append('<tr id="' + trID + '" class="voucherRow">' + trFr + '</tr>');
    setItemSerial(voucherEntyrListNew);
}
function setItemSerial(tID) {
    var tr_sl_start = 1;
    $('#' + tID + ' .tr_sl_no').each(function () {
        $(this).html(tr_sl_start);
        tr_sl_start++;
    });
}
function totalAmountEdit(tID) {
    var totalAmount = 0;
    var tempAmount = 0;
    var headName = 0;
    var headType;
    $('#' + tID + ' .voucherRow').each(function () {
        // t(tID);
        var rowId = this.id;
        tempAmount = $('#' + rowId + ' .tAmount').val();
        headName = $('#' + rowId + ' .voucher_head').val();
        if (headName == '') {
            t(rowId)
            tempAmount = 0;
            $('#' + rowId + ' .tAmount').val('');
            $('#' + rowId + ' .tAmount').attr("placeholder", "0.00");

            $('#' + rowId + ' .hType').attr('readonly', true);
            $('#' + rowId + ' .pDesc').attr('readonly', true);
            $('#' + rowId + ' .tcal').attr('readonly', true);
            $('#' + rowId + ' .tAmount').attr('readonly', true);
        }
        if (isNaN(tempAmount) == true) {
            tempAmount = 0;
            $('#' + rowId + ' .tAmount').val('');
            $('#' + rowId + ' .tAmount').attr("placeholder", "0.00");
        }
        headType = $('#' + rowId + ' .hType').val();
        if (headType == 'Dr') {
            totalAmount = Number(totalAmount) - Number(tempAmount);
        }
        if (headType == 'Cr') {
            totalAmount = Number(totalAmount) + Number(tempAmount);
        }
    });
    var grantTotalAmount = roundToTwo(totalAmount);
    t(totalAmount)
    if (isNaN(grantTotalAmount) == true) {
        $('.' + tID).val('0.00');
    }
    else {
        $('.' + tID).val(grantTotalAmount);
    }

}
function totalAmount() {
    var totalAmount = 0;
    var tempAmount = 0;
    var headName = 0;
    var headType;
    $('.voucherRow').each(function () {
        var rowId = this.id;
        tempAmount = $('#' + rowId + ' .tAmount').val();
        headName = $('#' + rowId + ' .voucher_head').val();
        if (headName == '') {
            tempAmount = 0;
            $('#' + rowId + ' .tAmount').val('');
            $('#' + rowId + ' .tAmount').attr("placeholder", "0.00");

            $('#' + rowId + ' .hType').attr('readonly', true);
            $('#' + rowId + ' .pDesc').attr('readonly', true);
            $('#' + rowId + ' .tcal').attr('readonly', true);
            $('#' + rowId + ' .tAmount').attr('readonly', true);
        }
        if (isNaN(tempAmount) == true) {
            tempAmount = 0;
            $('#' + rowId + ' .tAmount').val('');
            $('#' + rowId + ' .tAmount').attr("placeholder", "0.00");
        }
        headType = $('#' + rowId + ' .hType').val();
        if (headType == 'Dr') {
            totalAmount = Number(totalAmount) - Number(tempAmount);
        }
        if (headType == 'Cr') {
            totalAmount = Number(totalAmount) + Number(tempAmount);
        }
    });
    var grantTotalAmount = roundToTwo(totalAmount);

    if (isNaN(grantTotalAmount) == true) {
        $('#txtTotalAmount').val('0.00');
    }
    else {
        $('#txtTotalAmount').val(grantTotalAmount);
    }

}

function roundToTwo(num) {
    return num.toFixed(2);
}

function makeUniqueString() {
    var text = "";
    var possible = "abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < 7; i++)text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}
function removeThisTrFromVoucherList(trID, commonId) {
    var con = confirm("Are you sure to remove this item ?");
    if (con == false) {
        return false;
    }
    var voucher_id = $('#' + trID + ' .voucher_id').val();
    var del_ids = $('#del_ids_' + commonId).val();
    voucher_id = Number(voucher_id);
    if (voucher_id > 0) {
        if (del_ids != '') {
            del_ids = del_ids + ',' + voucher_id;
        }
        else {
            del_ids = voucher_id;
        }
    }
    $('#del_ids_' + commonId).val(del_ids);
    $('#' + trID).remove();
}
function loadVoucherHead(headType, setTr) { //
    $('#' + setTr + ' .voucher_head').html('<option value="">Loading...</option>');//alert('mm');
    $.ajax({
        type: "POST",
        url: "services/helper/library/ajax_handle.php",
        data: 'ajax_request=get_voucher_head&head_type=' + headType,
        success: function (data) {
            if (data.status == 1) {
                var s = data.result;

                var htmlString = '';
                htmlString += '<option value="">' + '-Select-' + '</option>';
                var i = 0;
                $.each(s, function (key, val) {
                    var arr = val.split("/");
                    var id = arr[0];
                    var hName = arr[1];

                    htmlString += '<option value="' + id + '">' + (i + 1) + '. ' + hName + '</option>';
                    i++;
                });
                $('#' + setTr + ' .voucher_head').html(htmlString);
            }
        }
    });
}
function toggleInputFields(headId) {
    if (headId > 0) {
        $('.voucherRow').each(function () {

            var rowId = this.id;	 //alert(rowId)
            $('#' + rowId + ' .tAmount').attr('readonly', false);
            $('#' + rowId + ' .hType').attr('readonly', false);
            $('#' + rowId + ' .pDesc').attr('readonly', false);
            $('#' + rowId + ' .tcal').attr('readonly', false);

        });
    }
    /*else
     {
     $('.voucherRow').each(function()
     {

     var rowId = this.id;	 alert(rowId)
     //$('#'+rowId+' .tAmount').attr('readonly', true);
     //$('#'+rowId+' .hType').attr('readonly', true);

     }
     } */
}
