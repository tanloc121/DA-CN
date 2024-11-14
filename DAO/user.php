<?php

function user_insert($mat_khau, $ho_ten, $diachi, $sodienthoai, $hinh_anh, $email, $vai_tro, $kich_hoat = 1)
{
    $sql = "INSERT INTO tbl_nguoidung(mat_khau, ho_ten, diachi, sodienthoai, email, hinh_anh, kich_hoat, vai_tro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $mat_khau, $ho_ten, $diachi, $sodienthoai, $email, $hinh_anh, $kich_hoat, $vai_tro);
    return true;
}

function user_register($ho_ten, $email, $mat_khau)
{
    $sql = "INSERT INTO tbl_nguoidung(ho_ten, email, mat_khau) VALUES (?, ?, ?)";
    pdo_execute($sql, $ho_ten, $email, $mat_khau);
    return true;
}

function user_update($iduser, $tai_khoan, $mat_khau, $ho_ten, $diachi, $sodienthoai, $hinh_anh, $email, $vai_tro, $kich_hoat = 1)
{
    $sql = "UPDATE tbl_nguoidung SET tai_khoan=?, mat_khau=?, ho_ten=?, diachi=?, sodienthoai=?, email=?,hinh_anh=?,kich_hoat=?,vai_tro=? WHERE id=?";
    pdo_execute($sql, $tai_khoan, $mat_khau, $ho_ten, $diachi, $sodienthoai, $email, $hinh_anh, $kich_hoat == 1, $vai_tro, $iduser);
    return true;
}

function user_update_2($iduser, $mat_khau, $ho_ten, $diachi, $sodienthoai, $hinh_anh, $email, $vai_tro, $kich_hoat = 1)
{
    if ($hinh_anh != "") {
        $sql = "UPDATE tbl_nguoidung SET mat_khau=?, ho_ten=?, diachi=?, sodienthoai=?, email=?,hinh_anh=?,kich_hoat=?,vai_tro=? WHERE id=?";
        pdo_execute($sql, $mat_khau, $ho_ten, $diachi, $sodienthoai, $email, $hinh_anh, $kich_hoat == 1, $vai_tro, $iduser);
        return true;
    } else {
        $sql = "UPDATE tbl_nguoidung SET mat_khau=?, ho_ten=?, diachi=?, sodienthoai=?, email=?,kich_hoat=?,vai_tro=? WHERE id=?";
        pdo_execute($sql, $mat_khau, $ho_ten, $diachi, $sodienthoai, $email, $kich_hoat == 1, $vai_tro, $iduser);
        return true;
    }
}

function update_profile_admin($idadmin, $ho_ten, $diachi, $sodienthoai, $hinh_anh, $email, $congty, $about_me)
{
    if ($hinh_anh != "") {
        $sql = "UPDATE tbl_nguoidung SET ho_ten=?, diachi=?, sodienthoai=?, email=?,hinh_anh=?, congty = ?, about_me = ? WHERE id=?";
        pdo_execute($sql, $ho_ten, $diachi, $sodienthoai, $email, $hinh_anh, $congty, $about_me, $idadmin);
        return true;
    } else {
        $sql = "UPDATE tbl_nguoidung SET ho_ten=?, diachi=?, sodienthoai=?, email=?, congty = ?, about_me = ? WHERE id=?";
        pdo_execute($sql, $ho_ten, $diachi, $sodienthoai, $email, $congty, $about_me, $idadmin);
        return true;
    }
}

function user_update_info($iduser, $ho_ten, $diachi, $sodienthoai, $hinh_anh, $congty, $kich_hoat = 1)
{
    $sql = "UPDATE tbl_nguoidung SET ho_ten=?, diachi=?, sodienthoai=?, hinh_anh=?,kich_hoat=?,congty=? WHERE id=?";
    pdo_execute($sql, $ho_ten, $diachi, $sodienthoai, $hinh_anh, $kich_hoat == 1, $congty, $iduser);
    return true;
}

function user_delete($iduser)
{
    $sql = "DELETE FROM tbl_nguoidung  WHERE id=?";
    if (is_array($iduser)) {
        foreach ($iduser as $ma) {
            pdo_execute($sql, $ma);
        }
    } else {
        pdo_execute($sql, $iduser);
    }
    return true;
}

function user_select_all()
{
    $sql = "SELECT * FROM tbl_nguoidung";
    return pdo_query($sql);

}

function user_select_by_id($iduser)
{
    $sql = "SELECT * FROM tbl_nguoidung WHERE id=?";
    return pdo_query_one($sql, $iduser);

}

function user_exist($iduser)
{
    $sql = "SELECT count(*) FROM tbl_nguoidung WHERE id=?";
    return pdo_query_value($sql, $iduser) > 0;

}

function user_exist_by_username($username)
{
    $sql = "SELECT count(*) FROM tbl_nguoidung WHERE tai_khoan=?";
    return pdo_query_value($sql, $username) > 0;
}

function email_exist_by_username($email, $username)
{
    $sql = "SELECT count(*) FROM tbl_nguoidung WHERE email=? and tai_khoan=?";
    return pdo_query_value($sql, $email, $username) > 0;
}

function email_exist($email)
{
    $sql = "SELECT count(*) FROM tbl_nguoidung WHERE email=?";
    return pdo_query_value($sql, $email) > 0;
}

function admin_select($vai_tro1, $vai_tro2)
{

    $sql = "SELECT * FROM tbl_nguoidung WHERE vai_tro=? or vai_tro = ? order by id desc";
    return pdo_query($sql, $vai_tro1, $vai_tro2);
}
function user_select($vai_tro1)
{

    $sql = "SELECT * FROM tbl_nguoidung WHERE vai_tro=? order by id desc";
    return pdo_query($sql, $vai_tro1);
}

function user_change_password($iduser, $newpass)
{
    $sql = "UPDATE tbl_nguoidung SET mat_khau=? WHERE id=?";
    pdo_execute($sql, $newpass, $iduser);
}

function user_change_pass_by_username($username, $newpass)
{
    $sql = "UPDATE tbl_nguoidung SET mat_khau=? WHERE tai_khoan=?";
    pdo_execute($sql, $newpass, $username);
}

function user_change_pass_by_email($email, $newpass)
{
    $sql = "UPDATE tbl_nguoidung SET mat_khau=? WHERE email=?";
    pdo_execute($sql, $newpass, $email);
}

function user_update_payment_method($iduser, $payment_method)
{
    $sql = "UPDATE tbl_nguoidung SET default_payment=? WHERE id=?";
    pdo_execute($sql, $payment_method, $iduser);
    return true;
}

function shipping_select_by_iduser($iduser)
{
    $sql = "SELECT * FROM tbl_shipping WHERE id_user=?";
    return pdo_query_one($sql, $iduser);
}
