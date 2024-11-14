<!-- START SLIDER AREA -->
<div class="slider-area plr-185 mb-80 section">
    <div class="container-fluid">
        <div class="slider-content">
            <div class="active-slider-1 slick-arrow-1 slick-dots-1">
                <!-- layer-1 Start -->
                <?php
$lis_slider_new = get_new_slider_home();
foreach ($lis_slider_new as $slider) {
    extract($slider);
    $hinh = "../uploads/" . $img_slider;
    echo '<div class="col-lg-12">
                    <div class="layer-1">
                        <div class="slider-img">
                            <img src="' . $hinh . '" alt="promotion-dummpy-image.png">
                        </div>
                        <div class="slider-info gray-bg">
                            <div class="slider-info-inner">
                                <h1 class="slider-title-1 text-uppercase text-black-1">' . $title_slider . '
                                </h1>
                                <div class="slider-brief text-black-2">
                                    <p>' . $content_slider . '</p>
                                </div>
                                <a href="./index.php?act=shop" class="button extra-small button-black">
                                    <span class="text-uppercase">Shop ngay</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>';
}
?>

            </div>
        </div>
    </div>
</div>
<!-- END SLIDER AREA -->


<!-- Start page content -->
<section id="page-content" class="page-wrapper section">

    <!-- BY BRAND SECTION START-->
    <div class="by-brand-section mb-80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-start mb-40">
                        <h2 class="uppercase">Các thương hiệu</h2>
                        <h6>Các thương hiệu nổi bật tại cửa hàng</h6>
                    </div>
                    <div class="by-brand-product">
                        <div class="active-by-brand slick-arrow-2">
                            <!-- Loop Brand Item here -->
                            <?php
$cate_list = cate_select_all();
// var_dump($cate_list);

$cate_list = array_filter($cate_list, function ($cate_item) {
    return $cate_item['ma_danhmuc'] != 0;
});

foreach ($cate_list as $cate_item) {
    # code...
    echo '
        <!-- single-brand-product start -->
            <div class="brand-item shadow border border-top-1">
                <div class="single-brand-product">
                    <a href="index.php?act=shop&cateid=' . $cate_item['ma_danhmuc'] . '"><img src="../uploads/' . $cate_item['hinh_anh'] . '"
                            alt=""></a>
                    <h3 class="brand-title text-grey fw-bold fs-1">
                        <a href="index.php?act=shop&cateid=' . $cate_item['ma_danhmuc'] . '">' . $cate_item['ten_danhmuc'] . '</a>
                    </h3>
                </div>
            </div>
        <!-- single-brand-product end -->
        ';
}

?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BY BRAND SECTION END -->

    <!-- FEATURED PRODUCT SECTION START -->
    <div class="featured-product-section mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-start mb-40">
                        <h2 class="uppercase">Sản phẩm nổi bật</h2>
                        <h6>Có rất nhiều biến thể của các thương hiệu có sẵn</h6>
                    </div>
                    <div class="featured-product">
                        <div class="active-featured-product slick-arrow-2">
                            <!-- Load Featured products from database -->
                            <?php
$featured_products = product_select_all();
// var_dump($featured_products);
foreach ($featured_products as $item) {

    #Thumbnail Image
    $image_list = explode(',', $item['images']);
    // var_dump(catename_select_by_id($item['ma_danhmuc']));
    $cate_name = catename_select_by_id($item['ma_danhmuc'])['ten_danhmuc'];
    $price_format = number_format($item['don_gia'] * (1 - $item['giam_gia'] / 100));
    $addcartfunc = "handleAddCart('addtocart', 'addcart')";
    $addwishlistfunc = "handleAddCart('addtowishlist', 'addwishlist')";
    // $avg_stars = avg_star_reviews_of_product($item['masanpham']);
    // $result_stars = renderStarRatings(round($avg_stars, 0));
    $avg_stars = avg_star_reviews_of_product($item['masanpham']);
    $avg_stars = $avg_stars !== null ? $avg_stars : 0; // Default to 0 if null
    $result_stars = renderStarRatings(round($avg_stars, 0));
    foreach ($image_list as $image_item) {

        if (substr($image_item, 0, 6) == "thumb-") {
            // echo $image_item;
            $thumbnail = "../uploads/" . $image_item;
            break;
        }

    }
    // echo $item['masanpham'];

    # code...
    echo '
                        <form action="./index.php?act=addtocart" method="post">
                                <div class="product-item position-relative">
                                <span class="ms-2 badge bg-secondary">' . $item['giam_gia'] . '%</span>
                                <span class="product-item__views position-absolute translate-middle badge rounded-pill bg-danger">
                                                ' . $item['so_luot_xem'] . ' views
                                                <span class="visually-hidden">unread messages</span>
                                </span>
                                    <div class="product-img">
                                        <a href="index.php?act=detailproduct&id=' . $item['masanpham'] . '">
                                            <img src="' . $thumbnail . '" alt="' . $thumbnail . '" />
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <h6 class="product-title">
                                            <a href="index.php?act=detailproduct&id=' . $item['masanpham'] . '">' . $item['tensp'] . '</a>
                                        </h6>
                                        <div class="pro-rating">
                                            ' . $result_stars . '
                                        </div>
                                        <h3 class="pro-price"> ' . $price_format . ' VND</h3>
                                            <ul class="action-button">
                                                <li>
                                                    <a onclick="' . $addwishlistfunc . '" class="add-to-wishlist" href="#" title="Wishlist"><i class="zmdi zmdi-favorite"></i></a>
                                                    <input type="submit" class="add-to-wishlist__submit-input d-none" name="addtowishlistbtn" value="Thêm vào sản phẩm yêu thích">
                                                </li>
                                                <li>
                                                    <a product-id="' . $item['masanpham'] . '" class="zoom-detail-product" href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                                        title="Quickview"><i class="zmdi zmdi-zoom-in"></i></a>
                                                </li>
                                                <li>
                                                    <button onclick="' . $addcartfunc . '" class="add-to-cart" title="Add to cart"><i
                                                            class="zmdi zmdi-shopping-cart-plus"></i></button>
                                                    <input type="submit" class="d-none" name="addtocartbtn" value="add to cart">
                                                </li>
                                                <input type="hidden" name="id" value="' . $item['masanpham'] . '"/>
                                                <input type="hidden" name="tensp" value="' . $item['tensp'] . '"/>
                                                <input type="hidden" name="hinh_anh" value="' . $thumbnail . '"/>
                                                <input type="hidden" name="sl" value="1">
                                                <input type="hidden" name="danhmuc" value="' . $cate_name . '"/>
                                                <input type="hidden" name="iddm" value="' . $item['ma_danhmuc'] . '"/>
                                                <input type="hidden" name="don_gia" value="' . $item['don_gia'] . '"/>
                                                <input type="hidden" name="mo_ta" value="' . $item['mo_ta'] . '">
                                                <input type="hidden" name="giam_gia" value="' . $item['giam_gia'] . '">
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                                ';
}
?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FEATURED PRODUCT SECTION END -->

    <!-- UP COMMING PRODUCT SECTION START -->
    <div class="up-comming-product-section mb-80">
        <div class="container">
            <div class="row">
                <!-- up-comming-pro -->
                <?php
$get_new_banner_home = get_new_banner_home();
foreach ($get_new_banner_home as $banner) {
    extract($banner);
    // var_dump($banner);
    $image_list = explode(',', $banner['images']);
    foreach ($image_list as $image_item) {

        if (substr($image_item, 0, 6) == "thumb-") {
            // echo $image_item;
            $thumbnail = "../uploads/" . $image_item;
            $alt = $image_item;
            break;
        }

    }
}
?>
                <div class="col-lg-8">
                    <div class="up-comming-pro gray-bg clearfix banner-element" banner-id="<?=$banner['id']?>">
                        <div class="up-comming-pro-img f-left">
                            <a href="index.php?act=detailproduct&id=<?=$banner['idsp']?>">
                                <img src="<?=$thumbnail?>" alt="<?=$alt?>">
                            </a>
                        </div>
                        <div class="up-comming-pro-info f-left">
                            <h3><a href="index.php?act=detailproduct&id=<?=$banner['idsp']?>"><?=$banner['name']?></a>
                            </h3>
                            <p><?=$banner['noi_dung']?> </p>
                            <div class="up-comming-time">
                                <div data-countdown="2023/05/05"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-block d-md-none d-lg-block">
                    <div class="banner-item banner-1">
                        <div class="banner-img">
                            <a href="#"><img src="../uploads/<?=$image_list[0]?>" alt="I phone Promotion 2.png"></a>
                        </div>
                        <div class="banner-info">
                            <h3><a href="index.php?act=detailproduct&id=<?=$banner['idsp']?>">I phone 14 Pro Max</a>
                            </h3>
                            <span><?=$banner['info']?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- UP COMMING PRODUCT SECTION END -->

    <!-- PRODUCT TAB SECTION START -->
    <div class="product-tab-section mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title text-start mb-40">
                        <h2 class="uppercase">Các sản phẩm tại cửa hàng</h2>
                        <h6>Rất nhiều điện thoại khác nhau đến từ các thương hiệu nổi tiếng (Oppo, Iphone, Samsung,
                            Xiaomi )</h6>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-tab pro-tab-menu text-end">
                        <!-- Nav tabs -->
                        <ul class="nav">
                            <li><a class="active" id="popular-product-tab-btn" href="#popular-product"
                                    data-bs-toggle="tab">Các sản phẩm phổ biến
                                </a></li>
                            <li><a id="new-arrival-tab-btn" href="#new-arrival" data-bs-toggle="tab">Sản phẩm mới về</a>
                            </li>
                            <li><a id="best-seller-tab-btn" href="#best-seller" data-bs-toggle="tab">Bán chạy</a></li>
                            <li><a id="special-offer-tab-btn" href="#special-offer" data-bs-toggle="tab">Ưu đãi đặt
                                    biệt</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- popular-product start -->
                        <div id="popular-product" class="tab-pane active show">
                            <div class="row">
                                <?php
// PHẦN XỬ LÝ PHP
// B1: KET NOI CSDL
$conn = connectdb();

$sql = "SELECT * FROM tbl_sanpham order by so_luot_xem desc"; // Total Product
$_limit = 12;
$pagination = createDataWithPagination($conn, $sql, $_limit);
$product_list = $pagination['datalist'];
// var_dump($productList);
$total_page = $pagination['totalpage'];
$start = $pagination['start'];
$current_page = $pagination['current_page'];
$total_records = $pagination['total_records'];

// $product_list = product_select_12();
// var_dump($product_list);
foreach ($product_list as $item) {

    #Thumbnail Image
    $image_list = explode(',', $item['images']);

    $price_format = number_format($item['don_gia'] * (1 - $item['giam_gia'] / 100));
    $addcartfunc = "handleAddCart('addtocart', 'addcart')";
    $addwishlistfunc = "handleAddCart('addtowishlist', 'addwishlist')";
    $cate_name = catename_select_by_id($item['ma_danhmuc'])['ten_danhmuc'];

    // $avg_stars = avg_star_reviews_of_product($item['masanpham']);
    // $result_stars = renderStarRatings(round($avg_stars, 0));
     $avg_stars = avg_star_reviews_of_product($item['masanpham']);
    $avg_stars = $avg_stars !== null ? $avg_stars : 0; // Default to 0 if null
    $result_stars = renderStarRatings(round($avg_stars, 0));
    foreach ($image_list as $image_item) {

        if (substr($image_item, 0, 6) == "thumb-") {
            // echo $image_item;
            $thumbnail = "../uploads/" . $image_item;
            break;
        }

    }

    # code...
    echo '
                                        <div class="col-lg-3 col-md-4">
                                        <form action="./index.php?act=addtocart" method="post">
                                                <div class="product-item position-relative">
                                                <span class="ms-2 badge bg-secondary">' . $item['giam_gia'] . '%</span>
                                                <span class="product-item__views position-absolute translate-middle badge rounded-pill bg-danger">
                                                ' . $item['so_luot_xem'] . ' views
                                                <span class="visually-hidden">unread messages</span>
                                                </span>
                                                <div class="product-img">
                                                    <a href="index.php?act=detailproduct&id=' . $item['masanpham'] . '">
                                                        <img src="' . $thumbnail . '" alt="' . $thumbnail . '" />
                                                    </a>
                                                </div>
                                                <div class="product-info">
                                                    <h6 class="product-title">
                                                        <a href="index.php?act=detailproduct&id=' . $item['masanpham'] . '">' . $item['tensp'] . '</a>
                                                    </h6>
                                                    <div class="pro-rating">
                                                    ' . $result_stars . '
                                                    </div>
                                                    <h3 class="pro-price"> ' . $price_format . ' VND</h3>
                                                        <ul class="action-button">
                                                        <li>
                                                            <a onclick="' . $addwishlistfunc . '" class="add-to-wishlist" href="#" title="Wishlist"><i class="zmdi zmdi-favorite"></i></a>
                                                            <input type="submit" class="add-to-wishlist__submit-input d-none" name="addtowishlistbtn" value="Thêm vào sản phẩm yêu thích">
                                                        </li>
                                                        <li>
                                                            <a class="zoom-detail-product" href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                                                title="Quickview"><i class="zmdi zmdi-zoom-in"></i></a>
                                                        </li>
                                                        <li>
                                                            <button onclick="' . $addcartfunc . '" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#cartModal" type="submit"  type="submit"  title="Add to cart"><i
                                                                    class="zmdi zmdi-shopping-cart-plus"></i></button>
                                                            <input type="submit" class="d-none add-to-cart__submit-input" name="addtocartbtn" value="Thêm vào giỏ hàng" >
                                                        </li>
                                                    </ul>
                                                    <input type="hidden" name="id" value="' . $item['masanpham'] . '"/>
                                                    <input type="hidden" name="tensp" value="' . $item['tensp'] . '"/>
                                                    <input type="hidden" name="hinh_anh" value="' . $thumbnail . '"/>
                                                    <input type="hidden" name="sl" value="1">
                                                    <input type="hidden" name="danhmuc" value="' . $cate_name . '"/>
                                                    <input type="hidden" name="iddm" value="' . $item['ma_danhmuc'] . '"/>
                                                    <input type="hidden" name="don_gia" value="' . $item['don_gia'] . '"/>
                                                    <input type="hidden" name="mo_ta" value="' . $item['mo_ta'] . '">
                                                    <input type="hidden" name="giam_gia" value="' . $item['giam_gia'] . '">
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        ';
}
?>
                                <!-- shop-pagination start -->
                                <ul class="shop-pagination box-shadow text-center ptblr-10-30">

                                    <?php
// HIỂN THỊ PHÂN TRANG
// nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
if ($current_page > 1 && $total_page > 1) {
    echo '<a class="page-item btn btn-secondary" href="index.php?view=popular-product&page=' . ($current_page - 1) . '">Trước</a> | ';
}

// Lặp khoảng giữa
for ($i = 1; $i <= $total_page; $i++) {
    // Nếu là trang hiện tại thì hiển thị thẻ span
    // ngược lại hiển thị thẻ a
    if ($i == $current_page) {
        echo '<span class="page-item btn btn-primary main-bg-color main-border-color">' . $i . '</span> | ';
    } else {
        echo '<a onclick="setPagination()" class="page-item btn btn-light" href="index.php?view=popular-product&page=' . $i . '">' . $i . '</a> | ';
    }
}

// nếu current_page < $total_page và total_page > 1 mới hiển thị nút Next
if ($current_page < $total_page && $total_page > 1) {
    echo '<a class="page-item btn btn-secondary" href="index.php?view=popular-product&page=' . ($current_page + 1) . '">Sau</a> | ';
}

?>
                                    <!-- <li><a href="#"><i class="zmdi zmdi-chevron-left"></i></a></li>
                                    <li><a href="#">01</a></li>
                                    <li><a href="#">02</a></li>
                                    <li><a href="#">03</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">05</a></li>
                                    <li class="active"><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li> -->
                                </ul>
                                <!-- shop-pagination end -->
                            </div>
                        </div>
                        <!-- popular-product end -->
                        <!-- new-arrival start -->
                        <div id="new-arrival" class="tab-pane" role="tabpanel">
                            <div class="row">
                                <?php

// PHẦN XỬ LÝ PHP
// B1: KET NOI CSDL
$conn = connectdb();

$sql = "SELECT * FROM tbl_sanpham order by ngay_nhap desc"; // Total Product
$_limit = 12;
$pagination = createDataWithPagination($conn, $sql, $_limit);
$product_list = $pagination['datalist'];
// var_dump($productList);

$total_page = $pagination['totalpage'];
$start = $pagination['start'];
$current_page = $pagination['current_page'];
$total_records = $pagination['total_records'];

// $product_list = product_select_all_lastest();
// var_dump($product_list);
foreach ($product_list as $item) {

    #Thumbnail Image
    $image_list = explode(',', $item['images']);
    $cate_name = catename_select_by_id($item['ma_danhmuc'])['ten_danhmuc'];
    $price_format = number_format($item['don_gia'] * (1 - $item['giam_gia'] / 100));
    $addcartfunc = "handleAddCart('addtocart', 'addcart')";
    $addwishlistfunc = "handleAddCart('addtowishlist', 'addwishlist')";
    $avg_stars = avg_star_reviews_of_product($item['masanpham']);
    $result_stars = renderStarRatings(round($avg_stars, 0));
    foreach ($image_list as $image_item) {

        if (substr($image_item, 0, 6) == "thumb-") {
            // echo $image_item;
            $thumbnail = "../uploads/" . $image_item;
            break;
        }

    }

    # code...
    echo '
                                        <div class="col-lg-3 col-md-4">
                                        <form action="./index.php?act=addtocart" method="post">
                                                <div class="product-item position-relative">
                                                <span class="ms-2 badge bg-secondary">' . $item['giam_gia'] . '%</span>
                                                <span class="product-item__views position-absolute translate-middle badge rounded-pill bg-danger">
                                                ' . $item['so_luot_xem'] . ' views
                                                <span class="visually-hidden">unread messages</span>
                                                </span>
                                                <div class="product-img">
                                                    <a href="index.php?act=detailproduct&id=' . $item['masanpham'] . '">
                                                        <img src="' . $thumbnail . '" alt="' . $thumbnail . '" />
                                                    </a>
                                                </div>
                                                <div class="product-info">
                                                    <h6 class="product-title">
                                                        <a href="index.php?act=detailproduct&id=' . $item['masanpham'] . '">' . $item['tensp'] . '</a>
                                                    </h6>
                                                    <div class="pro-rating">
                                                        ' . $result_stars . '
                                                    </div>
                                                    <h3 class="pro-price"> ' . $price_format . ' VND</h3>
                                                        <ul class="action-button">
                                                        <li>
                                                            <a onclick="' . $addwishlistfunc . '" class="add-to-wishlist" href="#" title="Wishlist"><i class="zmdi zmdi-favorite"></i></a>
                                                            <input type="submit" class="add-to-wishlist__submit-input d-none" name="addtowishlistbtn" value="Thêm vào sản phẩm yêu thích">
                                                        </li>
                                                        <li>
                                                            <a class="zoom-detail-product" href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                                                title="Quickview"><i class="zmdi zmdi-zoom-in"></i></a>
                                                        </li>
                                                        <li>
                                                            <button onclick="' . $addcartfunc . '" class="add-to-cart"  type="submit" data-bs-toggle="modal" data-bs-target="#cartModal" title="Add to cart"><i
                                                                    class="zmdi zmdi-shopping-cart-plus"></i></button>
                                                            <input type="submit" class="d-none add-to-cart__submit-input" name="addtocartbtn" value="Thêm vào giỏ hàng" >
                                                        </li>
                                                    </ul>
                                                    <input type="hidden" name="id" value="' . $item['masanpham'] . '"/>
                                                    <input type="hidden" name="tensp" value="' . $item['tensp'] . '"/>
                                                    <input type="hidden" name="hinh_anh" value="' . $thumbnail . '"/>
                                                    <input type="hidden" name="sl" value="1">
                                                    <input type="hidden" name="danhmuc" value="' . $cate_name . '"/>
                                                    <input type="hidden" name="iddm" value="' . $item['ma_danhmuc'] . '"/>
                                                    <input type="hidden" name="don_gia" value="' . $item['don_gia'] . '"/>
                                                    <input type="hidden" name="mo_ta" value="' . $item['mo_ta'] . '">
                                                    <input type="hidden" name="giam_gia" value="' . $item['giam_gia'] . '">
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        ';
}
?>
                                <!-- product-item end -->
                                <!-- shop-pagination start -->
                                <ul class="shop-pagination box-shadow text-center ptblr-10-30">
                                    <!-- <li><a href="#"><i class="zmdi zmdi-chevron-left"></i></a></li>
                                    <li><a href="#">01</a></li>
                                    <li><a href="#">02</a></li>
                                    <li><a href="#">03</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">05</a></li>
                                    <li class="active"><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li> -->
                                    <?php
// HIỂN THỊ PHÂN TRANG
// nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
if ($current_page > 1 && $total_page > 1) {
    echo '<a class="page-item btn btn-secondary" href="index.php?view=new-arrival&page=' . ($current_page - 1) . '">Trước</a> | ';
}

// Lặp khoảng giữa
for ($i = 1; $i <= $total_page; $i++) {
    // Nếu là trang hiện tại thì hiển thị thẻ span
    // ngược lại hiển thị thẻ a
    if ($i == $current_page) {
        echo '<span class="page-item btn btn-primary main-bg-color main-border-color">' . $i . '</span> | ';
    } else {
        echo '<a onclick="setPagination()" class="page-item btn btn-light" href="index.php?view=new-arrival&page=' . $i . '">' . $i . '</a> | ';
    }
}

// nếu current_page < $total_page và total_page > 1 mới hiển thị nút Next
if ($current_page < $total_page && $total_page > 1) {
    echo '<a class="page-item btn btn-secondary" href="index.php?view=new-arrival&page=' . ($current_page + 1) . '">Sau</a> | ';
}

?>
                                </ul>
                                <!-- shop-pagination end -->
                            </div>
                        </div>
                        <!-- new-arrival end -->
                        <!-- best-seller start -->
                        <div id="best-seller" class="tab-pane" role="tabpanel">
                            <div class="row">
                                <?php
// PHẦN XỬ LÝ PHP
// B1: KET NOI CSDL
$conn = connectdb();

$sql = "SELECT masanpham, sp.don_gia as don_gia, ton_kho, giam_gia, sp.tensp as tensp, hinhanh as thumbnail, sum(soluong) as sl_ban, mo_ta, sp.ma_danhmuc as ma_danhmuc from tbl_order od inner join tbl_order_detail detail on od.id = detail.iddonhang inner join tbl_sanpham sp on sp.masanpham = detail.idsanpham where trangthai = 4 group by idsanpham order by sl_ban desc"; // Total Product
$_limit = 12;
$pagination = createDataWithPagination($conn, $sql, $_limit);
$product_list = $pagination['datalist'];
// var_dump($productList);
$total_page = $pagination['totalpage'];
$start = $pagination['start'];
$current_page = $pagination['current_page'];
$total_records = $pagination['total_records'];

$top_sold_products = $product_list;
// var_dump($top_sold_products);
foreach ($top_sold_products as $item) {

    #Thumbnail Image
    // $image_list = explode(',', $item['images']);

    $price_format = number_format($item['don_gia'] * (1 - $item['giam_gia'] / 100));
    $addcartfunc = "handleAddCart('addtocart', 'addcart')";
    $addwishlistfunc = "handleAddCart('addtowishlist', 'addwishlist')";
    $cate_name = catename_select_by_id($item['ma_danhmuc'])['ten_danhmuc'];
    $avg_stars = avg_star_reviews_of_product($item['masanpham']);
    $result_stars = renderStarRatings(round($avg_stars, 0));
    // foreach ($image_list as $image_item) {

    //     if (substr($image_item, 0, 6) == "thumb-") {
    //         // echo $image_item;
    //         $thumbnail = "../uploads/" . $image_item;
    //         break;
    // }

    $thumbnail = $item['thumbnail'];

    // }

    # code...
    echo '
                                                                        <div class="col-lg-3 col-md-4">
                                                                        <form action="./index.php?act=addtocart" method="post">
                                                                                <div class="product-item position-relative">
                                                                                <span class="ms-2 badge bg-secondary">' . $item['giam_gia'] . '%</span>
                                                                                <span class="product-item__views position-absolute translate-middle badge rounded-pill bg-danger">
                                                                                ' . $item['sl_ban'] . ' đã bán
                                                                                <span class="visually-hidden">unread messages</span>
                                                                                </span>
                                                                                <div class="product-img">
                                                                                    <a href="index.php?act=detailproduct&id=' . $item['masanpham'] . '">
                                                                                        <img src="../uploads/' . $thumbnail . '" alt="' . $thumbnail . '" />
                                                                                    </a>
                                                                                </div>
                                                                                <div class="product-info">
                                                                                    <h6 class="product-title">
                                                                                        <a href="index.php?act=detailproduct&id=' . $item['masanpham'] . '">' . $item['tensp'] . '</a>
                                                                                    </h6>
                                                                                    <div class="pro-rating">
                                                                                       ' . $result_stars . '
                                                                                    </div>
                                                                                    <h3 class="pro-price"> ' . $price_format . ' VND</h3>
                                                                                        <ul class="action-button">
                                                                                        <li>
                                                                                            <a onclick="' . $addwishlistfunc . '" class="add-to-wishlist" href="#" title="Wishlist"><i class="zmdi zmdi-favorite"></i></a>
                                                                                            <input type="submit" class="add-to-wishlist__submit-input d-none" name="addtowishlistbtn" value="Thêm vào sản phẩm yêu thích">
                                                                                        </li>
                                                                                        <li>
                                                                                            <a class="zoom-detail-product" href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                                                                                title="Quickview"><i class="zmdi zmdi-zoom-in"></i></a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <button onclick="' . $addcartfunc . '" class="add-to-cart"  type="submit" data-bs-toggle="modal" data-bs-target="#cartModal" title="Add to cart"><i
                                                                                                    class="zmdi zmdi-shopping-cart-plus"></i></button>
                                                                                            <input type="submit" class="d-none add-to-cart__submit-input" name="addtocartbtn" value="Thêm vào giỏ hàng" >
                                                                                        </li>
                                                                                    </ul>
                                                                                    <input type="hidden" name="id" value="' . $item['masanpham'] . '"/>
                                                                                    <input type="hidden" name="tensp" value="' . $item['tensp'] . '"/>
                                                                                    <input type="hidden" name="hinh_anh" value="' . $thumbnail . '"/>
                                                                                    <input type="hidden" name="sl" value="1">
                                                                                    <input type="hidden" name="danhmuc" value="' . $cate_name . '"/>
                                                                                    <input type="hidden" name="iddm" value="' . $item['ma_danhmuc'] . '"/>
                                                                                    <input type="hidden" name="don_gia" value="' . $item['don_gia'] . '"/>
                                                                                    <input type="hidden" name="mo_ta" value="' . $item['mo_ta'] . '">
                                                                                    <input type="hidden" name="giam_gia" value="' . $item['giam_gia'] . '">
                                                                                </div>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                        ';
}
?>

                                <!-- shop-pagination start -->
                                <ul class="shop-pagination box-shadow text-center ptblr-10-30">

                                    <!-- <li><a href="#"><i class="zmdi zmdi-chevron-left"></i></a></li>
                                    <li><a href="#">01</a></li>
                                    <li><a href="#">02</a></li>
                                    <li><a href="#">03</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">05</a></li>
                                    <li class="active"><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li> -->
                                    <?php
// HIỂN THỊ PHÂN TRANG
// nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
if ($current_page > 1 && $total_page > 1) {
    echo '<a class="page-item btn btn-secondary" href="index.php?page=' . ($current_page - 1) . '">Trước</a> | ';
}

// Lặp khoảng giữa
for ($i = 1; $i <= $total_page; $i++) {
    // Nếu là trang hiện tại thì hiển thị thẻ span
    // ngược lại hiển thị thẻ a
    if ($i == $current_page) {
        echo '<span class="page-item btn btn-primary main-bg-color main-border-color">' . $i . '</span> | ';
    } else {
        echo '<a onclick="setPagination()" class="page-item btn btn-light" href="index.php?page=' . $i . '">' . $i . '</a> | ';
    }
}

// nếu current_page < $total_page và total_page > 1 mới hiển thị nút Next
if ($current_page < $total_page && $total_page > 1) {
    echo '<a class="page-item btn btn-secondary" href="index.php?page=' . ($current_page + 1) . '">Sau</a> | ';
}

?>
                                </ul>
                                <!-- shop-pagination end -->
                            </div>
                        </div>
                        <!-- best-seller end -->
                        <!-- special-offer start -->
                        <div id="special-offer" class="tab-pane" role="tabpanel">
                            <div class="row">
                                <?php

// PHẦN XỬ LÝ PHP
// B1: KET NOI CSDL
$conn = connectdb();

$sql = "SELECT * FROM tbl_sanpham WHERE giam_gia > 0 order by giam_gia desc"; // Total Product
$_limit = 12;
$pagination = createDataWithPagination($conn, $sql, $_limit);
$product_list = $pagination['datalist'];
// var_dump($productList);
$total_page = $pagination['totalpage'];
$start = $pagination['start'];
$current_page = $pagination['current_page'];
$total_records = $pagination['total_records'];

// $product_list = product_select_all_discounts();
// var_dump($product_list);
foreach ($product_list as $item) {

    #Thumbnail Image
    $image_list = explode(',', $item['images']);
    $cate_name = catename_select_by_id($item['ma_danhmuc'])['ten_danhmuc'];
    $price_format = number_format($item['don_gia'] * (1 - $item['giam_gia'] / 100));
    $addcartfunc = "handleAddCart('addtocart', 'addcart')";
    $addwishlistfunc = "handleAddCart('addtowishlist', 'addwishlist')";
    $avg_stars = avg_star_reviews_of_product($item['masanpham']);
    $result_stars = renderStarRatings(round($avg_stars, 0));
    foreach ($image_list as $image_item) {

        if (substr($image_item, 0, 6) == "thumb-") {
            // echo $image_item;
            $thumbnail = "../uploads/" . $image_item;
            break;
        }

    }

    # code...
    echo '
                                        <div class="col-lg-3 col-md-4">
                                        <form action="./index.php?act=addtocart" method="post">
                                                <div class="product-item position-relative">
                                                <span class="ms-2 badge bg-secondary">' . $item['giam_gia'] . '%</span>
                                                <span class="product-item__views position-absolute translate-middle badge rounded-pill bg-danger">
                                                ' . $item['so_luot_xem'] . ' views
                                                <span class="visually-hidden">unread messages</span>
                                                </span>
                                                <div class="product-img">
                                                    <a onclick="' . $addwishlistfunc . '" href="index.php?act=detailproduct&id=' . $item['masanpham'] . '">
                                                        <img src="' . $thumbnail . '" alt="' . $thumbnail . '" />
                                                    </a>
                                                </div>
                                                <div class="product-info">
                                                    <h6 class="product-title">
                                                        <a href="index.php?act=detailproduct&id=' . $item['masanpham'] . '">' . $item['tensp'] . '</a>
                                                    </h6>
                                                    <div class="pro-rating">
                                                        ' . $result_stars . '
                                                    </div>
                                                    <h3 class="pro-price"> ' . $price_format . ' VND</h3>
                                                        <ul class="action-button">
                                                        <li>
                                                            <a onclick="' . $addwishlistfunc . '" class="add-to-wishlist" href="#" title="Wishlist"><i class="zmdi zmdi-favorite"></i></a>
                                                            <input type="submit" class="add-to-wishlist__submit-input d-none" name="addtowishlistbtn" value="Thêm vào sản phẩm yêu thích">
                                                        </li>
                                                        <li>
                                                            <a class="zoom-detail-product" href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                                                title="Quickview"><i class="zmdi zmdi-zoom-in"></i></a>
                                                        </li>
                                                        <li>
                                                            <button onclick="' . $addcartfunc . '" class="add-to-cart" type="submit"  type="submit"  title="Add to cart"><i
                                                                    class="zmdi zmdi-shopping-cart-plus"></i></button>
                                                            <input type="submit" class="d-none add-to-cart__submit-input" name="addtocartbtn" value="Thêm vào giỏ hàng" >
                                                        </li>
                                                    </ul>
                                                    <input type="hidden" name="id" value="' . $item['masanpham'] . '"/>
                                                    <input type="hidden" name="tensp" value="' . $item['tensp'] . '"/>
                                                    <input type="hidden" name="hinh_anh" value="' . $thumbnail . '"/>
                                                    <input type="hidden" name="sl" value="1">
                                                    <input type="hidden" name="danhmuc" value="' . $cate_name . '"/>
                                                    <input type="hidden" name="iddm" value="' . $item['ma_danhmuc'] . '"/>
                                                    <input type="hidden" name="don_gia" value="' . $item['don_gia'] . '"/>
                                                    <input type="hidden" name="mo_ta" value="' . $item['mo_ta'] . '">
                                                    <input type="hidden" name="giam_gia" value="' . $item['giam_gia'] . '">
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        ';
}
?>

                                <!-- shop-pagination start -->
                                <ul class="shop-pagination box-shadow text-center ptblr-10-30">

                                    <?php
// HIỂN THỊ PHÂN TRANG
// nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
if ($current_page > 1 && $total_page > 1) {
    echo '<a class="page-item btn btn-secondary" href="index.php?view=special-offer&page=' . ($current_page - 1) . '">Trước</a> | ';
}

// Lặp khoảng giữa
for ($i = 1; $i <= $total_page; $i++) {
    // Nếu là trang hiện tại thì hiển thị thẻ span
    // ngược lại hiển thị thẻ a
    if ($i == $current_page) {
        echo '<span class="page-item btn btn-primary main-bg-color main-border-color">' . $i . '</span> | ';
    } else {
        echo '<a class="page-item btn btn-light" href="index.php?view=special-offer&page=' . $i . '">' . $i . '</a> | ';
    }
}

// nếu current_page < $total_page và total_page > 1 mới hiển thị nút Next
if ($current_page < $total_page && $total_page > 1) {
    echo '<a class="page-item btn btn-secondary" href="index.php?view=special-offer&page=' . ($current_page + 1) . '">Sau</a> | ';
}

?>

                                    <!-- <li><a href="#"><i class="zmdi zmdi-chevron-left"></i></a></li>
                                    <li><a href="#">01</a></li>
                                    <li><a href="#">02</a></li>
                                    <li><a href="#">03</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">05</a></li>
                                    <li class="active"><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li> -->
                                </ul>
                                <!-- shop-pagination end -->
                            </div>
                        </div>
                        <!-- special-offer end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT TAB SECTION END -->

    <!-- BLOG SECTION START -->
    <div class="blog-section mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-start mb-40">
                        <h2 class="uppercase">Các bài viết mới nhất</h2>
                        <h6>Các bài viết về các sản phẩm mới nhất, thủ thuật, hướng dẫn sử dụng điện thoại hay</h6>
                    </div>
                    <div class="blog">
                        <div class="active-blog slick-arrow-1">
                            <?php
$list_newblog_home = get_all_new_blog_home();
foreach ($list_newblog_home as $newblog) {
    extract($newblog);
    $image_list = explode(',', $newblog['images']);
    foreach ($image_list as $image_item) {

        if (substr($image_item, 0, 6) == "thumb-") {
            // echo $image_item;
            $thumbnail = "../uploads/" . $image_item;
            break;
        }
    }
    $conten = mb_substr($newblog['noi_dung'], 0, 100);
    echo '<div class="blog-item">
                                    <img style="width: 365px; height: 265px;" src="' . $thumbnail . '" alt="lastest-blog-1.jpg">
                                    <div class="blog-desc">
                                        <h5 class="blog-title"><a href="./index.php?act=blogdetail&id=' . $blog_id . '">' . $blog_title . '</a></h5>
                                        <p>' . $conten . '...</p>
                                        <div class="read-more">
                                            <a href="./index.php?act=blogdetail&id=' . $blog_id . '">Read more</a>
                                        </div>
                                        <ul class="blog-meta">
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-favorite"></i>89 Like</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-comments"></i>59 Comments</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-share"></i>29 Share</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>';
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BLOG SECTION END -->
</section>
<!-- End page content -->


</div>
<!-- Body main wrapper end -->