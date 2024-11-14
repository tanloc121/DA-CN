<?php

function product_insert($tensp, $don_gia, $ton_kho, $images, $giam_gia, $ngay_nhap, $mo_ta, $thong_tin, $ma_danhmuc, $id_dmphu, $promote, $dac_biet = 0)
{
    $sql = "INSERT INTO tbl_sanpham (tensp, don_gia, ton_kho, images, giam_gia, dac_biet, ngay_nhap, mo_ta, information, ma_danhmuc, id_dmphu, promote) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    pdo_execute($sql, $tensp, $don_gia, $ton_kho, $images, $giam_gia, $dac_biet, $ngay_nhap, $mo_ta, $thong_tin, $ma_danhmuc, $id_dmphu, $promote);
    return true;
}

function product_delete($ma_sanpham)
{
    $sql = "DELETE FROM tbl_sanpham WHERE  masanpham=?";
    if (is_array($ma_sanpham)) {
        foreach ($ma_sanpham as $ma) {
            pdo_execute($sql, $ma);
        }
    } else {
        pdo_execute($sql, $ma_sanpham);
        return true;
    }

}

function product_update($masanpham, $tensp, $don_gia, $ton_kho, $images, $giam_gia, $date_modified, $mo_ta, $thong_tin, $ma_danhmuc, $id_dmphu, $promote, $dac_biet = 0)
{
    $sql = "UPDATE tbl_sanpham SET  tensp=?, don_gia=?, ton_kho = ?, images=?,giam_gia=?, dac_biet=?, date_modified=?, mo_ta=?, information=?, ma_danhmuc=?, id_dmphu=?, promote=? WHERE masanpham=?";
    pdo_execute($sql, $tensp, $don_gia, $ton_kho, $images, $giam_gia, $dac_biet, $date_modified, $mo_ta, $thong_tin, $ma_danhmuc, $id_dmphu, $promote, $masanpham);
    return true;
}

function product_update_quantity($masanpham, $ton_kho)
{
    $sql = "UPDATE tbl_sanpham SET  ton_kho = ? WHERE masanpham=?";
    pdo_execute($sql, $ton_kho, $masanpham);
    return true;
}

function product_update_remaining_qty($masanpham, $sl)
{
    $sql = "UPDATE tbl_sanpham SET  ton_kho = ton_kho + ? WHERE masanpham=?";
    pdo_execute($sql, $sl, $masanpham);
    return true;
}

function select_products_from_order_id($order_id)
{
    $sql = "SELECT idsanpham, soluong from tbl_order od inner join tbl_order_detail de on od.id = de.iddonhang where od.id = $order_id";
    return pdo_query($sql);
}

function product_select_all()
{
    $sql = "SELECT * FROM tbl_sanpham";
    return pdo_query($sql);
}

function select_all_recommend_products_by_iduser($iduser, $limit)
{
    $sql = "SELECT idsanpham, hinhanh, tensp, dongia,  count(*) as sl_ban from tbl_nguoidung ng inner join tbl_order od on od.iduser = ng.id inner join tbl_order_detail de on de.iddonhang = od.id where iduser = '$iduser' and trangthai = 4   group by idsanpham order by sl_ban desc limit $limit";
    return pdo_query($sql);
}

function product_select_all_inventory_less_than($num)
{
    $sql = "SELECT * from tbl_sanpham where ton_kho <= '$num';";
    return pdo_query($sql);
}

function product_select_12()
{
    $sql = "SELECT * FROM tbl_sanpham LIMIT 0, 12";
    return pdo_query($sql);
}

function product_select_all_lastest()
{
    $sql = "SELECT * FROM tbl_sanpham order by ngay_nhap desc";
    return pdo_query($sql);
}

function product_select_all_discounts()
{
    $sql = "SELECT * FROM tbl_sanpham WHERE giam_gia > 0 order by giam_gia desc";
    return pdo_query($sql);
}

function product_select_all_by_sales()
{
    $sql = "SELECT masanpham, tbl_sanpham.tensp, tbl_sanpham.don_gia, giam_gia, ton_kho, tbl_sanpham.ma_danhmuc,  , count(soluong) from tbl_order inner join tbl_cart on tbl_order.id = tbl_cart.iddonhang inner join tbl_sanpham on masanpham = idsanpham group by idsanpham having trangthai = 5 ORDER by count(soluong);";
    // Trang thai = 5; Đã giao hàng thành công!
    return pdo_query($sql);
}

function product_select_by_id($masanpham)
{
    $sql = "SELECT * FROM tbl_sanpham WHERE masanpham=?";
    return pdo_query_one($sql, $masanpham);

}
function product_select_by_special()
{
    $sql = "SELECT * FROM tbl_sanpham WHERE dac_biet = 1 ";
    return pdo_query($sql);

}

function product_select_by_name($tensp)
{
    $sql = "SELECT * FROM tbl_sanpham WHERE tensp like ?";
    return pdo_query($sql, $tensp);

}

function select_all_reviews_product()
{
    $sql = "SELECT * FROM tbl_danhgiasp";
    return pdo_query($sql);
}

function is_replied_review($id_review)
{
    $sql = "SELECT count(*) from tbl_reply_reviews where id_review = ?";
    return pdo_query_value($sql, $id_review);
}

function select_id_replied_review($id_review)
{
    $sql = "select id_reply from tbl_reply_reviews where id_review = ?";
    return pdo_query_one($sql, $id_review);
}

function insert_reply_review($id_user, $id_review, $content, $date_modified)
{
    $sql = "INSERT INTO tbl_reply_reviews (id_user, id_review, content, date_modified) values(?,?,?,?)";
    pdo_execute($sql, $id_user, $id_review, $content, $date_modified);
    return true;
}

function select_reply_review_by_id($id_reply)
{

    $sql = "SELECT * from tbl_reply_reviews where id_reply = ?";
    return pdo_query_one($sql, $id_reply);
}

function update_reply_review($id_reply, $id_user, $id_review, $content, $date_modified)
{
    $sql = "UPDATE tbl_reply_reviews SET id_user = ?, id_review = ?, content = ?, date_modified = ? where id_reply = ?";
    pdo_execute($sql, $id_user, $id_review, $content, $date_modified, $id_reply);
    return true;
}

function reply_review_select_by_idreview($id_review)
{
    $sql = "SELECT * from tbl_reply_reviews rep inner join tbl_nguoidung ng where rep.id_user = ng.id and id_review = ?";
    return pdo_query_one($sql, $id_review);
}

// function product_select_by_date($date_value)
// {
//     $sql = "SELECT *, CAST(ngay_nhap AS DATE) from tbl_sanpham where CAST(ngay_nhap AS DATE) = '?'";
//     echo $sql;
//     return pdo_query($sql, $date_value);
// }

function product_exist($masanpham)
{
    $sql = "SELECT count(*) FROM tbl_sanpham WHERE masanpham=?";
    return pdo_query_value($sql, $masanpham) > 0;

}

function product_increase_view($masanpham)
{
    $sql = "UPDATE tbl_sanpham SET so_luot_xem = so_luot_xem + 1 WHERE masanpham=?";
    pdo_execute($sql, $masanpham);
}

// How many tops depend on $number. If $numbers is 10 -> top: 10.
function product_select_top($number)
{
    $sql = "SELECT * FROM tbl_sanpham WHERE so_luot_xem > 0 ORDER BY so_luot_xem DESC LIMIT 0, $number";
    return pdo_query($sql);

}

function product_select_special()
{
    $sql = "SELECT * FROM tbl_sanpham WHERE dac_biet=1";
    return pdo_query($sql);

}

function product_select_by_cate($ma_danhmuc)
{
    $sql = "SELECT * FROM tbl_sanpham WHERE ma_danhmuc=?";
    return pdo_query($sql, $ma_danhmuc);

}

// select similar products
function product_select_similar_cate($ma_danhmuc, $masanpham)
{
    $sql = "SELECT * FROM tbl_sanpham WHERE ma_danhmuc=? AND NOT masanpham = ? ";
    return pdo_query($sql, $ma_danhmuc, $masanpham);
}

function product_select_keyword($keyword)
{
    $sql = "SELECT * FROM hang_hoa hh "
        . " JOIN loai lo ON lo.ma_loai=hh.ma_loai "
        . " WHERE ten_hh LIKE ? OR ten_loai LIKE ?";
    return pdo_query($sql, '%' . $keyword . '%', '%' . $keyword . '%');

}

function product_select_page()
{
    // if (!isset($_SESSION['page_no'])) {
    //     $_SESSION['page_no'] = 0;
    // }
    // if (!isset($_SESSION['page_count'])) {
    //     $row_count = pdo_query_value("SELECT count(*) FROM hang_hoa");
    //     $_SESSION['page_count'] = ceil($row_count / 10.0);
    // }
    // if (exist_param("page_no")) {
    //     $_SESSION['page_no'] = $_REQUEST['page_no'];
    // }

    // if ($_SESSION['page_no'] < 0) {
    //     $_SESSION['page_no'] = $_SESSION['page_count'] - 1;
    // }

    // if ($_SESSION['page_no'] >= $_SESSION['page_count']) {
    //     $_SESSION['page_no'] = 0;
    // }

    // $sql = "SELECT * FROM hang_hoa ORDER BY ma_hh LIMIT " . $_SESSION['page_no'] . ", 10";

    // return pdo_query($sql);

}

function product_select_by_min_price()
{
    $sql = "SELECT min(don_gia) as min_don_gia FROM tbl_sanpham";
    return pdo_query($sql);
}

function product_select_by_max_price()
{
    $sql = "SELECT max(don_gia) as max_don_gia FROM tbl_sanpham";
    return pdo_query($sql);
}

// function product_
