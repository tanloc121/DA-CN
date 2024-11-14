<?php
function updateorderstatus($iddh, $trangthai)
{
    $sql = "UPDATE tbl_order set trangthai = ? where id = ?";
    $mess = pdo_execute($sql, $trangthai, $iddh);
    // echo $mess;
    return true;
}

function update_order_reason_destroy($reason_content, $iddh)
{
    $sql = "UPDATE tbl_order set reason_destroy = ? where id = ?";
    pdo_execute($sql, $reason_content, $iddh);
    // echo $mess;
    return true;
}

function updatepaymentstatus($iddh, $thanhtoan)
{
    $sql = "UPDATE tbl_order set thanhtoan = ? where id = ?";
    $mess = pdo_execute($sql, $thanhtoan, $iddh);
    // echo $mess;
    return true;
}

function deleteorderdetailbyid($iddh)
{
    $sql = "DELETE from tbl_order_detail where iddonhang = $iddh;";
    pdo_execute($sql);
    return true;
}

function deleteorderbyid($iddh)
{
    $sql = "DELETE from tbl_order where id = $iddh;";
    pdo_execute($sql);
    return true;
}

function select_orderdetail_by_orderid($iddh)
{
    $sql = "SELECT ma_danhmuc, idsanpham, sp.tensp, soluong, dongia, hinhanh from tbl_order_detail detail inner join tbl_sanpham sp on detail.idsanpham = sp.masanpham where iddonhang = $iddh;";
    return pdo_query($sql);
    // return true;
}
function select_orders_by_iduser($iduser)
{
    $sql = "SELECT od.id, madonhang, tongdonhang, pttt, iduser, name, dienThoai, address, ghichu, timeorder, trangthai, thanhtoan, sum(soluong) as tongsoluong FROM tbl_order od inner join tbl_order_detail de on od.id = de.iddonhang where iduser = '$iduser' group by iddonhang order by timeorder desc";
    return pdo_query($sql);
}

function select_orders_by_status($status_number)
{
    $sql = "SELECT od.id, madonhang, tongdonhang, pttt, iduser, name, dienThoai, address, ghichu, timeorder, trangthai, thanhtoan, sum(soluong) as tongsoluong FROM tbl_order od inner join tbl_order_detail de on od.id = de.iddonhang where trangthai = '$status_number' group by iddonhang order by timeorder desc";
    return pdo_query($sql);
}

// select * from tbl_order od inner join tbl_order_detail detail on od.id = detail.iddonhang inner join tbl_sanpham sp on sp.masanpham = detail.idsanpham having trangthai = 4;

function count_sold_product_by_id($id)
{
    $sql = "SELECT count(*) from tbl_order od inner join tbl_order_detail detail on od.id = detail.iddonhang inner join tbl_sanpham sp on sp.masanpham = detail.idsanpham where trangthai = 4 and idsanpham = '$id'";
    return pdo_query_value($sql);
}

function count_all_sold_products()
{
    $sql = "SELECT count(*) from tbl_order od inner join tbl_order_detail detail on od.id = detail.iddonhang inner join tbl_sanpham sp on sp.masanpham = detail.idsanpham where trangthai = 4";
    return pdo_query_value($sql);
}

function revenue_of_month($year, $month)
{
    $sql = "SELECT sum(tongdonhang) from tbl_order where month(timeorder) = '$month' and year(timeorder) = '$year' and trangthai = 4";
    return pdo_query_value($sql);
}

function revenue_of_week($week, $year)
{
    $sql = "SELECT sum(tongdonhang) from tbl_order where week(timeorder) = '$week' and year(timeorder) = '$year' and trangthai = 4 group by week(timeorder)";
    return pdo_query_value($sql);
}

function revenue_of_weeks()
{
    $sql = "SELECT week(timeorder) as week, trangthai, sum(tongdonhang) as tongdonhang from tbl_order where trangthai = 4 group by week(timeorder)";
    return pdo_query($sql);
}

function revenue_of_day_by_month_year($year, $month, $day)
{
    $sql = "SELECT sum(tongdonhang) from tbl_order where trangthai = 4 and year(timeorder) = '$year' and month(timeorder) = '$month' and day(timeorder) = '$day' group by day(timeorder)";
    return pdo_query_value($sql);
}

// SELECT *, sum(soluong) as sl_ban from tbl_order od inner join tbl_order_detail detail on od.id = detail.iddonhang inner join tbl_sanpham sp on sp.masanpham = detail.idsanpham where trangthai = 4 group by idsanpham order by sl_ban desc;

// function select_top_sold_products()
// {
//     $sql = "SELECT sp.tensp as ten_sp, hinhanh, sum(soluong) as sl_ban from tbl_order od inner join tbl_order_detail detail on od.id = detail.iddonhang inner join tbl_sanpham sp on sp.masanpham = detail.idsanpham where trangthai = 4 group by idsanpham order by sl_ban desc";
//     return pdo_query($sql);
// }

function select_top_sold_products()
{
    $sql = "SELECT sp.tensp as ten_sp, hinhanh, sum(soluong) as sl_ban 
            FROM tbl_order od 
            INNER JOIN tbl_order_detail detail ON od.id = detail.iddonhang 
            INNER JOIN tbl_sanpham sp ON sp.masanpham = detail.idsanpham 
            WHERE trangthai = 4 
            GROUP BY idsanpham, hinhanh 
            ORDER BY sl_ban DESC";
    return pdo_query($sql);
}

function select_top_sold_products_homepage()
{
    // sum(soluong) as sl_ban sp.masanpham as masanpham, sp.tensp as tensp, sp.don_gia as don_gia, ton_kho, images, giam_gia, dac_biet, so_luot_xem, ngay_nhap, date_modified, mo_ta, ma_danhmuc, id_dmphu, information, promote
    $sql = "SELECT masanpham, sp.don_gia as don_gia, ton_kho, giam_gia, sp.tensp as tensp, hinhanh as thumbnail, sum(soluong) as sl_ban, mo_ta, sp.ma_danhmuc as ma_danhmuc from tbl_order od inner join tbl_order_detail detail on od.id = detail.iddonhang inner join tbl_sanpham sp on sp.masanpham = detail.idsanpham where trangthai = 4 group by idsanpham order by sl_ban desc";
    return pdo_query($sql);
}

function select_top_view_products()
{
    $sql = "SELECT * from tbl_sanpham order by so_luot_xem desc";
    return pdo_query($sql);
}

function count_all_customers_at_shop()
{

}

function insert_vnpay($order_id, $amount, $bankcode, $banktransno, $cardtype, $orderinfo, $paydate, $tmncode, $transaction_no)
{
    $sql = "INSERT INTO tbl_vnpay (order_id, amount, bankcode, banktransno, cardtype, orderinfo, paydate, tmncode, transaction_no) VALUES (?,?,?,?,?,?,?,?,?)";
    pdo_execute($sql, $order_id, $amount, $bankcode, $banktransno, $cardtype, $orderinfo, $paydate, $tmncode, $transaction_no);
    return true;
}

function insert_momo()
{

}

function insert_coupon($coupon_code, $discount_percent, $min_value, $maximum_use, $date_start, $date_end)
{
    $sql = "INSERT INTO tbl_coupon (coupon_code, discount_percent, min_value, maximum_use, date_start, date_end) values (?,?,?,?,?,?)";
    pdo_execute($sql, $coupon_code, $discount_percent, $min_value, $maximum_use, $date_start, $date_end);
    return true;
}

function update_coupon($idcoupon, $coupon_code, $discount_percent, $min_value, $maximum_use, $date_start, $date_end)
{
    $sql = "UPDATE tbl_coupon set coupon_code = ?, discount_percent = ?, min_value = ?, maximum_use = ?, date_start = ?, date_end = ? where id_coupon = ?";
    pdo_execute($sql, $coupon_code, $discount_percent, $min_value, $maximum_use, $date_start, $date_end, $idcoupon);
    return true;
}

function select_coupon_by_id($idcoupon)
{
    $sql = "SELECT * from tbl_coupon where id_coupon = '$idcoupon'";
    return pdo_query_one($sql);
}

function delete_coupon_by_id($idcoupon)
{
    $sql = "DELETE from tbl_coupon where id_coupon = $idcoupon";
    pdo_execute($sql);
    return true;
}

function get_discount_percent($coupon)
{
    $sql = "SELECT discount_percent from tbl_coupon where coupon_code = '$coupon'";
    return pdo_query_value($sql);
}

function is_valid_money_for_coupon($coupon, $money)
{
    $sql = "SELECT count(*) from tbl_coupon where coupon_code = '$coupon' and min_value <= '$money'";
    return pdo_query_value($sql);
}

function is_applied_coupon($coupon, $iduser)
{
    $sql = "SELECT count(*) from tbl_order where coupon_code = '$coupon' and iduser ='$iduser'";
    return pdo_query_value($sql);
}

function is_outdated_coupon($coupon, $current_date)
{
    $sql = "SELECT count(*) from tbl_coupon where coupon_code = '$coupon' and date_start <= '$current_date' and date_end >= '$current_date'";
    return pdo_query_value($sql);
}

function is_exist_coupon($coupon)
{
    $sql = "SELECT count(*) from tbl_coupon where coupon_code = '$coupon'";
    return pdo_query_value($sql);
}

function is_enough_money_order_for_coupon($money, $coupon)
{

}

function update_coupon_for_orderid($coupon_code, $orderid)
{
    $sql = "UPDATE tbl_order set coupon_code = ? where id = ?";
    pdo_execute($sql, $coupon_code, $orderid);
    return true;
}

function update_quantity_of_coupon($coupon_code)
{
    $sql = "UPDATE tbl_coupon set maximum_use = maximum_use - 1 where coupon_code = '$coupon_code'";
    pdo_execute($sql);
    return true;
}

function select_all_coupons()
{
    $sql = "SELECT * from tbl_coupon";
    return pdo_query($sql);

}