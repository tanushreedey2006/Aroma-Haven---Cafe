<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");

/** @var mysqli $conn */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="coffee.css">
    <link rel="icon" type="image/png" href="weblogo.png">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-5.3.7-dist/css/bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
        .logicon {
            margin-top: 7px;
            margin-left: 20px;
            font-size: 27px;
            color: red;
        }

        .cart {
            margin-top: 7px;
            margin-left: 10px;
            color: #fff;
            font-size: 27px;
        }

        .category-section {
            padding: 40px 40px 70px;
            background: #fffaf4;
        }

        .category-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .category-head h1 {
            margin: 0;
            font-size: 3rem;
            font-weight: 800;
            color: #58260f;
            letter-spacing: 1px;
        }

        .category-products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 26px;
            align-items: stretch;
        }

        .product-card {
            background: linear-gradient(180deg, #f1c98d 0%, #efc07e 100%);
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(88, 38, 15, 0.16);
            transition: transform 0.28s ease, box-shadow 0.28s ease;
            border: 1px solid rgba(88, 38, 15, 0.08);
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 36px rgba(88, 38, 15, 0.22);
        }

        .product-top {
            padding: 16px 18px 10px;
            min-height: 70px;
            display: flex;
            align-items: flex-start;
        }

        .product-name {
            margin: 0;
            font-size: 1.1rem;
            line-height: 1.35;
            font-weight: 800;
            color: #7a1f06;
        }

        .product-image-box {
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            background: #fff;
        }

        .product-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px 18px;
        }

        .product-price {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
            background: rgba(88, 38, 15, 0.22);
            padding: 8px 14px;
            border-radius: 999px;
            backdrop-filter: blur(6px);
        }

        .product-heart {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            cursor: pointer;
            transition: 0.25s ease;
        }

        .product-heart:hover {
            color: #7a1f06;
            transform: scale(1.12);
        }

        html {
            scroll-behavior: smooth;
        }

        #newcollection {
            scroll-margin-top: 120px;
        }

        .view-btn {
            border: none;
            background: #58260f;
            color: #fff;
            padding: 8px 18px;
            border-radius: 30px;
            font-weight: bold;
            transition: 0.3s;
        }

        .view-btn:hover {
            background: #7a1f06;
            transform: scale(1.05);
            color: #fff;
        }

        .category-products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e5e5;
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .product-image-box {
            position: relative;
            width: 100%;
            height: 320px;
            overflow: hidden;
            background: #f7f7f7;
        }

        .product-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* .wishlist-icon{
    position:absolute;
    top:15px;
    right:15px;
    background:#fff;
    width:40px;
    height:40px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    color:#c40000;
    cursor:pointer;
} */

        .product-content {
            padding: 20px;
        }

        .product-title {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .price-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .old-price {
            color: #999;
            text-decoration: line-through;
            font-size: 18px;
        }

        .new-price {
            color: #111;
            font-size: 28px;
            font-weight: bold;
        }

        .size-flex {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .size-btn {
            border: 1px solid #58260f;
            background: #fff;
            color: #58260f;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 14px;
        }

        .action-flex {
            display: flex;
            gap: 12px;

        }

        /* .cart-btn{
      flex:1;
    border:none;
    background:#58260f;
    color:#fff;
    height:48px;
    border-radius:8px;
    font-weight:bold;
} */


        /* 
.cart-btn:hover{
    background:#7a1f06;
} */

        .cart-btn {
            flex: 1;
            border: none;
            background: linear-gradient(135deg, #58260f, #7a1f06);
            color: #fff;
            height: 50px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 15px;
            transition: 0.3s;
            cursor: pointer;
        }

        .cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(88, 38, 15, 0.25);
        }

        .cart-icon-area {
            position: relative;
            padding-left: 10px;
        }

        .cart-icon-box {
            position: relative;
            cursor: pointer;
            font-size: 24px;
            color: #fff;
        }

        .cart-count {
            position: absolute;
            top: -10px;
            right: -12px;

            background: red;
            color: #fff;

            width: 22px;
            height: 22px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 12px;
            font-weight: bold;
        }

       

        .cart-sidebar {

            position: fixed;
            top: 0;
            right: -450px;

            width: 420px;
            height: 100vh;

            background: #fffaf5;

            z-index: 999999;

            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.18);

            transition: 0.4s ease;

            overflow-y: auto;

            border-left: 4px solid #58260f;

        }

        .cart-sidebar.active {
            right: 0;
        }

        /* HEADER */

        .cart-header {

            position: sticky;
            top: 0;

            background: #fffaf5;

            padding: 22px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            border-bottom: 1px solid #ead7c5;

            z-index: 99;
        }

        .cart-header h2 {

            margin: 0;

            color: #58260f;

            font-size: 28px;
            font-weight: 800;

        }

        .cart-header button {

            width: 38px;
            height: 38px;

            border: none;

            background: #58260f;
            color: #fff;

            border-radius: 50%;

            cursor: pointer;

            font-size: 16px;

            transition: 0.3s;
        }

        .cart-header button:hover {

            background: #7a1f06;
            transform: rotate(90deg);

        }

        /* EMPTY CART */

        .empty-cart {

            text-align: center;

            padding: 90px 20px;

            color: #777;
        }

        .empty-cart i {

            font-size: 60px;

            color: #d5b8a0;

            margin-bottom: 18px;
        }

        /* CART ITEM */

        .sidebar-item {

            display: flex;
            gap: 15px;

            margin: 18px;

            padding: 16px;

            background: #fff;

            border-radius: 20px;

            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);

            transition: 0.3s;

            border: 1px solid #f0e3d7;

        }

        .sidebar-item:hover {

            transform: translateY(-3px);

            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);

        }

        /* IMAGE */

        .sidebar-item img {

            width: 95px;
            height: 95px;

            border-radius: 18px;

            object-fit: cover;

        }

        /* INFO */

        .sidebar-info {

            flex: 1;

        }

        .sidebar-info h4 {

            margin: 0;

            color: #2b2b2b;

            font-size: 18px;

            font-weight: 700;
        }

        .sidebar-info p {

            margin: 10px 0;

            color: #58260f;

            font-size: 20px;

            font-weight: bold;

        }

        /* QUANTITY */

        .qty-flex {

            display: flex;
            align-items: center;

            gap: 12px;

            margin-top: 8px;
        }

        .qty-btn {

            width: 34px;
            height: 34px;

            border: none;

            border-radius: 50%;

            background: linear-gradient(135deg, #58260f, #7a1f06);

            color: #fff;

            font-size: 18px;
            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .qty-btn:hover {

            transform: scale(1.1);

        }

        .cart-icon {

            position: relative;

            text-decoration: none;

            color: #fff;

            font-size: 24px;

            margin-left: 20px;
        }

        .cart-count {

            position: absolute;

            top: -10px;
            right: -12px;

            background: #ff355e;

            color: #fff;

            min-width: 22px;
            height: 22px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 12px;

            font-weight: bold;

            padding: 2px 6px;

            box-shadow:
                0 4px 12px rgba(255, 53, 94, 0.4);
        }

        /* REMOVE BUTTON */

        .remove-btn {

            margin-top: 14px;

            border: none;

            background: #ffeded;

            color: #c40000;

            padding: 9px 16px;

            border-radius: 10px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .remove-btn:hover {

            background: #c40000;
            color: #fff;

        }

        /* FOOTER */

        .cart-footer {

            position: sticky;
            bottom: 0;

            background: #fffaf5;

            padding: 20px;

            border-top: 1px solid #ead7c5;
        }

        /* TOTAL */

        .cart-total {

            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 16px;

            font-size: 22px;
            font-weight: 800;

            color: #58260f;
        }

        /* CHECKOUT */

        .checkout-btn {

            width: 100%;
            height: 55px;

            border: none;

            border-radius: 16px;

            background: linear-gradient(135deg, #58260f, #7a1f06);

            color: #fff;

            font-size: 17px;
            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .checkout-btn:hover {

            transform: translateY(-2px);

            box-shadow: 0 10px 24px rgba(88, 38, 15, 0.25);

        }

        .remove-btn {

            border: none;

            background: red;
            color: #fff;

            padding: 7px 14px;

            border-radius: 8px;

            cursor: pointer;
        }

        .toast {

            position: fixed;

            bottom: 30px;
            right: 30px;

            background: #1f1f1f;
            color: #fff;

            padding: 14px 22px;

            border-radius: 12px;

            z-index: 999999;

            font-weight: bold;

            animation: fade 0.3s ease;
        }



        @keyframes fade {

            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        .view-btn {
            width: 90px;
            border: 1px solid #58260f;
            background: #fff;
            color: #58260f;
            border-radius: 8px;
            font-weight: bold;
        }


        @keyframes toastFade {

            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        /* NAVBAR WISHLIST */

        .wishlist-area {

            position: relative;
            padding-left: 15px;
            cursor: pointer;
        }

        .wishlist-nav-icon {

            color: #fff;
            font-size: 24px;
        }

        .wishlist-count {

            position: absolute;
            top: -10px;
            right: -12px;

            width: 22px;
            height: 22px;

            border-radius: 50%;

            background: #ff1e56;

            color: #fff;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 11px;
            font-weight: bold;

            box-shadow: 0 5px 12px rgba(255, 30, 86, 0.4);
        }



        /* PRODUCT HEART */

        .wishlist-icon {

            position: absolute;
            top: 25px;
            right: 15px;

            width: 44px;
            height: 44px;
            padding: 4%;
            border-radius: 50%;

            background: rgba(255, 255, 255, 0.95);

            display: flex;
            align-items: center;
            justify-content: center;

            color: #ff2d55;

            font-size: 18px;

            cursor: pointer;

            transition: 0.35s ease;

            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }

        .wishlist-icon:hover {

            transform: scale(1.12);
        }

        .wishlist-active {

            background: linear-gradient(135deg, #ff2d55, #ff4f81);

            color: #fff;

            transform: scale(1.08);

            box-shadow: 0 12px 22px rgba(255, 45, 85, 0.35);
        }

        /*==============================
PREMIUM PROFILE DROPDOWN
==============================*/

.profile-dropdown{

    position:relative;

    display:flex;

    align-items:center;

}

.profile-btn{
    width:52px;
    height:52px;
    margin-top: -8% !important;
    display:flex;
    align-items:center;
    justify-content:center;

    cursor:pointer;

    border-radius:50%;

    transition:.35s;
}

.profile-btn:hover{

    transform:translateY(-3px);

    box-shadow:0 18px 40px rgba(0,0,0,.25);

}

.profile-avatar{

    width:46px;

    height:46px;

    border-radius:50%;

    background:linear-gradient(135deg,#f6d365,#fda085);

    color:#4b250f;

    font-weight:800;

    font-size:20px;

    display:flex;

    justify-content:center;

    align-items:center;

    box-shadow:0 8px 20px rgba(0,0,0,.15);

}




.profile-menu{

    position:absolute;

    top:75px;

    right:0;

    width:270px;

    background:rgba(255,255,255,.98);

    backdrop-filter:blur(18px);

    border-radius:22px;

    overflow:hidden;

    box-shadow:

    0 25px 60px rgba(0,0,0,.20);

    opacity:0;

    visibility:hidden;

    transform:translateY(20px);

    transition:.35s;

    z-index:99999;

}

.profile-menu.show{

    opacity:1;

    visibility:visible;

    transform:translateY(0);

}

.profile-menu a{

    display:flex;

    align-items:center;

    gap:15px;

    text-decoration:none;

    padding:18px 22px;

    color:#444;

    font-size:16px;

    font-weight:600;

    transition:.30s;

}

.profile-menu a:hover{

    background:linear-gradient(90deg,#f7efe6,#fff);

    color:#8b4513;

    padding-left:28px;

}

.profile-menu a i{
    /* margin-top: -3em; */
    width:22px;
    font-size:18px;
    color:#8b4513;
}

.menu-divider{

    height:1px;

    background:#eee;

    margin:6px 18px;

}

.logout-link{

    color:#d62c2c !important;

}

.logout-link i{

    color: #d62c2c !important;

}

.logout-link:hover{

    background:#fff1f1 !important;

}

.profile-menu::before{

    content:"";

    position:absolute;

    top:-8px;

    right:28px;

    width:18px;

    height:18px;

    background:white;

    transform:rotate(45deg);

}


/*====================================================
        MOBILE RESPONSIVE (750px)
====================================================*/

@media (max-width:750px){

.head{

    flex:1;

    margin-left:12px;

}

.profile-btn{
    
    margin-top: -2.5em;

}

.head img{

    width:48px !important;

    height:48px !important;

}

.head h1{

    font-size:25px !important;
    margin-top: -15%;
    margin-right: 7em;
    
}

/* .button{

    margin-left:auto;

} */

}

.close-menu,
.mobile-overlay{
    display:none;
}

@media (max-width:750px){

    body{
        overflow-x:hidden;
    }

   .nav{

    /* display:flex; */
    display: relative;
    flex-wrap:wrap;

    justify-content:space-between;
    align-items:center;

    padding:12px 15px 15px;
    margin-right: 15px;

}


.wishlist-area {
    margin-top:-1.3em;
}
    /* Logo */

    .head{
        width:auto;
        /* gap:10px; */
        align-items:center;
    }

    .head .img{
        width:55px;
        height:55px;
        margin-bottom: 15%;
    }

  

    /* Hamburger */

    .menu-toggle{
        display:flex;
        justify-content:center;
        align-items:center;
        width:45px;
        height:45px;
        border:none;
        border-radius:10px;
        background:#58260f;
        color:#fff;
        font-size:20px;
        cursor:pointer;
    }

    /* Navigation */

.cart-icon-area{

            margin-top: -1.5em;
}

   

    /* Search */

   .search-bar-container{

    order:10;

    width:70% !important;

    margin:-11% 0 0 !important;

    display:flex;

    align-items:center;

    background:#fff;

    border-radius:50px;

    padding:6px 12px;

    box-shadow:0 10px 25px rgba(0,0,0,.12);

}


.search-bar-container .input{

    width:100%;

    border:none;

    background:transparent;

    padding:10px;

    font-size:15px;

}

.search-bar-container .input:focus{

    outline:none;

}


.magnifier{

    width:32px !important;

    height:32px !important;

}

.mic-icon{

    width:20px !important;

    height:20px !important;

}

    .input{
        width:100%;
    }

    /* Right Side */

    /* .button{
        width:auto;
        padding:0;
    } */

    .profile-avatar{
        width:42px;
        height:42px;
        font-size:18px;
    }

    .cart-icon-box,
    .wishlist-nav-icon{
        font-size:20px;
    }

    .cart-count,
    .wishlist-count{
        width:20px;
        height:20px;
        font-size:10px;
    }

    /* Cart Sidebar */

    .cart-sidebar{
        width:100%;
    }

    /* Products */

    .category-section{
        padding:20px 15px 40px;
    }

    .category-head{
        flex-direction:column;
        gap:15px;
        align-items:flex-start;
    }

    .category-head h1{
        font-size:32px;
    }

    .category-products{
        grid-template-columns:1fr;
        gap:20px;
    }

    .product-image-box{
        height:260px;
    }

}


.menu-btn{
    display:none;
}

@media (max-width:750px){

.menu-btn{

    display:flex;
    margin-top: -14%;
    margin-left: 2%;
    justify-content:center;
    align-items:center;

    width:48px;
    height:48px;

    background:#7a1f06;
    color:#fff;

    border:none;
    border-radius:12px;

    font-size:22px;
    cursor:pointer;

    z-index:999999;
}

}

@media (min-width:751px){

.menu-btn,
.close-menu,
.mobile-overlay{

    display:none !important;

}



}

/*==========================
 PREMIUM MOBILE MENU
===========================*/

@media (max-width:750px){

/* Premium Navbar */


/* Mobile Menu */




/* Premium Close Button */

.close-menu{

    position:absolute;

    top:20px;
    right:20px;

    width:45px;
    height:45px;

    border-radius:50%;

    background:rgba(255,255,255,.15);

    color:#fff;

    display:flex;
    justify-content:center;
    align-items:center;

    cursor:pointer;

    font-size:22px;

    transition:.35s;

}

.close-menu:hover{

    transform:rotate(180deg);

    background:#ff4b4b;

}

/* Menu Links */


.Alllink a:hover{

    padding-left:40px;
    color: #fff;

    background:rgba(255,255,255,.08);

    border-left:4px solid #ffb86c;

}

/* Hamburger */


/* @media (max-width: 750px) {
    .Alllink {
        display: none !important;
    }
} */



/* Overlay */

.mobile-overlay{

    position:fixed;

    inset:0;

    background:rgba(0,0,0,.55);

    backdrop-filter:blur(5px);

    opacity:0;

    visibility:hidden;

    transition:.35s;

    z-index:999998;

}

.mobile-overlay.show{

    opacity:1;

    visibility:visible;

}

/* Search */



/* Logo */



.head img{

    width:55px!important;

    height:55px!important;

}

}

@media (max-width:750px){

.Alllink{

    position:fixed;

    top:0;
    left:-320px;

    width:300px;
    height:100vh;

    background:#3d210f;

    display:flex;
    flex-direction:column;

    padding-top:90px;

    transition:.45s;

    z-index:999999;

    box-shadow:20px 0 40px rgba(0,0,0,.35);

}

.Alllink.active{

    left:0;

}

.Alllink a{

    color: #fff;
    padding:18px 30px;
    text-decoration:none;
    font-size:18px;
    border-bottom:1px solid rgba(255,255,255,.08);

}

.Alllink a:hover{

    background:#6b3b22;
    padding-left:40px;
    color: #fff;


}





}

/*=========================================
        PROFILE DROPDOWN RESPONSIVE
=========================================*/

@media (max-width:750px){

.profile-dropdown{

    position:relative;
    margin-top: 2%;
    /* padding: 10%; */

    /* width: 20%; */
    /* width: 20px;; */

}

.profile-btn{

    width:44px;
    height:44px;

}

.profile-avatar{

    width:40px;
    height:40px;

    font-size:17px;

}

/* Premium Mobile Dropdown */

.profile-menu{

    position:fixed;

    top:60px;

    right:15px;

    left:6em;

    width:60%;

    border-radius:20px;

    background:rgba(255,255,255,.98);

    backdrop-filter:blur(25px);

    box-shadow:
        0 20px 45px rgba(0,0,0,.20);

    overflow:hidden;

    z-index:999999;

}

.profile-menu::before{

    display:none;

}

.profile-menu a{

    padding:18px 20px;

    font-size:16px;

    gap:15px;

}

.profile-menu a i{

    width:25px;

    font-size:18px;

}

.profile-menu a:hover{

    padding-left:20px;

    background:#f8f3ee;

}

.menu-divider{

    margin:0;

}

.logout-link{

    color:#d32f2f !important;

}

.logout-link:hover{

    background:#fff0f0 !important;

}

}




@media (max-width:750px){

.button{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    position:absolute;
    top:18px;
    right:18px;
    padding:0;
    margin:0;
}

.sign{
    /* margin:0; */
    margin-top:-2.4em !important;

    width:95px;
    height:40px;
    font-size:15px;
    transform:none;
}

}



a.buttons,
a.buttons:hover,
a.buttons:focus,
a.buttons:active{
    text-decoration: none !important;
}






/* ================================
   MOBILE MENU - FINAL
================================ */

.close-menu,
.mobile-overlay {
    display: none;
}

@media (max-width: 750px) {

    .menu-btn {
        display: flex !important;
        justify-content: center;
        align-items: center;
        width: 45px;
        height: 45px;
        border: none;
        border-radius: 10px;
        background: #58260f;
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        z-index: 1000000;
    }

    .Alllink {
        position: fixed;
        top: 0;
        left: -320px;

        width: 300px;
        height: 100vh;

        background: #3d210f;

        display: flex !important;
        flex-direction: column;

        padding-top: 90px;

        transition: left 0.45s ease;

        z-index: 1000001;

        box-shadow: 20px 0 40px rgba(0,0,0,.35);
    }

    .Alllink.active {
        left: 0;
    }

    .Alllink a {
        display: block;

        color: #fff !important;
        text-decoration: none;

        padding: 18px 30px;

        font-size: 18px;

        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .Alllink a:hover {
        background: #6b3b22;
        color: #fff !important;
    }

    .close-menu {
        display: flex;

        position: absolute;

        top: 20px;
        right: 20px;

        width: 45px;
        height: 45px;

        justify-content: center;
        align-items: center;

        border-radius: 50%;

        background: rgba(255,255,255,.15);
        color: #fff;

        font-size: 22px;

        cursor: pointer;

        z-index: 1000002;
    }

    .mobile-overlay {
        display: block;

        position: fixed;
        inset: 0;

        background: rgba(0,0,0,.55);
        backdrop-filter: blur(5px);

        opacity: 0;
        visibility: hidden;

        transition: .3s;

        z-index: 1000000;
    }

    .mobile-overlay.show {
        opacity: 1;
        visibility: visible;
    }
}

@media (min-width: 751px) {

    .menu-btn,
    .Alllink,
    .close-menu,
    .mobile-overlay {
        display: none !important;
    }

}


/* =========================================================
   SEARCH WRAPPER
========================================================= */

.search-wrapper {
    position: relative;

    width: 330px;
    min-width: 330px;

    z-index: 1000000;
}


/* =========================================================
   SEARCH BAR
========================================================= */

.search-wrapper .search-bar-container {
    position: relative;

    width: 100%;
    height: 52px;
margin-top: 3% ;
    display: flex;
    align-items: center;

    background: #ffffff;

    border-radius: 40px;

    padding: 4px 10px;

    box-sizing: border-box;

    /* THIS IS THE SHADOW FROM YOUR OLD LOOK */
    box-shadow:
        0 8px 12px rgba(255, 255, 255, 0.65),
        0 0 18px rgba(0, 0, 0, 0.18);

    z-index: 1000001;
}


/* =========================================================
   SEARCH ICON
========================================================= */

.search-wrapper .magnifier {
    width: 35px !important;
    height: 35px !important;

    object-fit: contain;

    flex-shrink: 0;

    margin-right: 8px;
}


/* =========================================================
   INPUT
========================================================= */

.search-wrapper .input {

    flex: 1;

    width: auto !important;

    height: 100%;

    border: none !important;

    outline: none !important;

    background: transparent !important;

    box-shadow: none !important;

    font-size: 17px;

    color: #444;

    padding: 0 8px;
}

.search-wrapper .input::placeholder {
    color: #777;
}


/* =========================================================
   CLEAR BUTTON
========================================================= */

.search-wrapper .clear-search {

    width: 28px;
    height: 28px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    color: #777;

    font-size: 21px;

    cursor: pointer;

    border-radius: 50%;
}

.search-wrapper .clear-search:hover {
    background: #f1e5dc;
    color: #58260f;
}


/* =========================================================
   SEARCH DROPDOWN
========================================================= */

.search-wrapper .search-suggestions {

    position: absolute;

    top: calc(100% + 8px);

    left: 0;

    width: 100%;

    max-height: 360px;

    overflow-y: auto;

    overflow-x: hidden;

    display: none;

    box-sizing: border-box;

    background: #ffffff;

    border-radius: 15px;

    border: 1px solid #ead7c5;

    box-shadow:
        0 12px 30px rgba(0, 0, 0, 0.18);

    z-index: 1000002;
}


/* SHOW */

.search-wrapper .search-suggestions.show {
    display: block;
}


/* =========================================================
   SUGGESTION ITEM
========================================================= */

.search-wrapper .search-suggestion {

    width: 100%;

    min-height: 68px;

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 10px 13px;

    box-sizing: border-box;

    text-decoration: none;

    background: #fff;

    border-bottom: 1px solid #eee2d8;

    color: #333;

    transition: .2s ease;
}

.search-wrapper .search-suggestion:last-child {
    border-bottom: none;
}

.search-wrapper .search-suggestion:hover {

    background: #fff7ef;

    padding-left: 17px;
}


/* =========================================================
   SUGGESTION IMAGE
========================================================= */

.search-wrapper .suggestion-image {

    width: 48px;
    height: 48px;

    flex: 0 0 48px;

    object-fit: cover;

    border-radius: 10px;

    background: #f5e8dc;
}


/* =========================================================
   SUGGESTION ICON
========================================================= */

.search-wrapper .suggestion-icon {

    width: 48px;
    height: 48px;

    flex: 0 0 48px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f5e8dc;

    color: #58260f;

    font-size: 18px;
}


/* =========================================================
   SUGGESTION TEXT
========================================================= */

.search-wrapper .suggestion-info {

    flex: 1;

    min-width: 0;
}

.search-wrapper .suggestion-title {

    color: #58260f;

    font-size: 14px;

    font-weight: 700;

    line-height: 1.3;

    margin-bottom: 3px;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;
}

.search-wrapper .suggestion-type {

    color: #999;

    font-size: 11px;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;
}


/* =========================================================
   PRICE
========================================================= */

.search-wrapper .suggestion-price {

    flex-shrink: 0;

    color: #58260f;

    font-size: 13px;

    font-weight: 700;

    white-space: nowrap;
}


/* =========================================================
   LOADING / NO RESULT
========================================================= */

.search-wrapper .search-loading,
.search-wrapper .search-no-result {

    padding: 16px;

    text-align: center;

    font-size: 13px;

    color: #777;

    background: #fff;
}


/* =========================================================
   DROPDOWN SCROLLBAR
========================================================= */

.search-wrapper .search-suggestions::-webkit-scrollbar {
    width: 5px;
}

.search-wrapper .search-suggestions::-webkit-scrollbar-track {
    background: transparent;
}

.search-wrapper .search-suggestions::-webkit-scrollbar-thumb {
    background: #cdb09a;
    border-radius: 10px;
}


/* =========================================================
   MOBILE - 750px
========================================================= */

@media (max-width: 750px) {

    .search-wrapper {

        order: 10;

        width: 70% !important;

        min-width: 0;

        margin: -11% 0 0 !important;
    }


    .search-wrapper .search-bar-container {

        width: 100%;

        height: 48px;

        padding: 4px 10px;

        border-radius: 30px;

        /* SAME SHADOW ON MOBILE */

        box-shadow:
            0 8px 12px rgba(0, 0, 0, 0.18),
            0 0 16px rgba(255, 255, 255, 0.65);
    }


    .search-wrapper .magnifier {

        width: 28px !important;
        height: 28px !important;

        margin-right: 5px;
    }


    .search-wrapper .input {

        font-size: 14px;

        padding: 0 5px;
    }


    .search-wrapper .search-suggestions {

        top: calc(100% + 7px);

        width: 100%;

        max-height: 320px;

        border-radius: 13px;
    }


    .search-wrapper .search-suggestion {

        min-height: 60px;

        padding: 8px 10px;

        gap: 9px;
    }


    .search-wrapper .suggestion-image,
    .search-wrapper .suggestion-icon {

        width: 42px;
        height: 42px;

        flex: 0 0 42px;
    }


    .search-wrapper .suggestion-title {
        font-size: 13px;
    }

    .search-wrapper .suggestion-type {
        font-size: 10px;
    }

    .search-wrapper .suggestion-price {
        font-size: 12px;
    }
}



    </style>

    <?php




    $cart_count = 0;

    if (isset($_SESSION['user_email'])) {

        $email = $_SESSION['user_email'];

        $userQuery = mysqli_query(
            $conn,

            "SELECT * FROM clients
    WHERE email='$email'"
        );

        $userData = mysqli_fetch_assoc($userQuery);

        if ($userData) {

            $user_id = $userData['id'];

            $cartQuery = mysqli_query(
                $conn,

                "SELECT SUM(quantity) AS total_cart

        FROM addtocart

        WHERE user_id='$user_id'
        AND status='active'"
            );

            $cartRow = mysqli_fetch_assoc($cartQuery);

            $cart_count =
                $cartRow['total_cart'] ?? 0;
        }
    }

    ?>
</head>

<body> 
    <div class="nav d-flex justify-content-evenly fixed-top">


    <button class="menu-btn" onclick="openMenu()">
    <i class="fas fa-bars"></i>
</button>
    


        <div class="head d-flex justify-content-between gap-3">
            <img src="./images/weblogo.png" class="img" style="border-radius:50%;" />
            <h1 class="fs-3 py-3 text-light"><i>Aroma Haven</i></h1>
        </div>
        <div class=" d-flex Alllink fs-5" id="mobileMenu">
            <div class="close-menu" onclick="closeMenu()">
    <i class="fas fa-times"></i>
</div>

            <a href="index.php" class="border-0 p-3" id="a">Home</a>
            <a href="about.php" class="p-3" id="a">About</a>
            <a href="catalogue.php" class="p-3" id="a">Catalogue</a>
            <a href="service.php" class="p-3" id="a">Service</a>
            <a href="gallery.php" class="p-3" id="a">Gallery</a>

        </div>
   

        <?php

        $search = $_GET['search'] ?? '';

        $current_page = basename($_SERVER['PHP_SELF']);

        $placeholder = "Search...";


        if ($current_page == "about.php") {
            $placeholder = "Search About...";
        } elseif ($current_page == "catalouge.php") {
            $placeholder = "Search Categories...";
        } elseif ($current_page == "gallery.php") {
            $placeholder = "Search Products...";
        } elseif ($current_page == "page4.php") {
            $placeholder = "Search Orders...";
        } elseif ($current_page == "page5.php") {
            $placeholder = "Search Payments...";
        }
        ?>

<div class="search-wrapper">

    <form
        class="search-bar-container active"
        method="GET"
        action="search.php"
    >

        <img
            class="magnifier"
            src="./images/magnifying1.png"
        >

        <input
            type="text"
            id="searchInput"
            name="search"
            class="input"
            placeholder="<?php echo $placeholder; ?>"
            value="<?php echo htmlspecialchars($search); ?>"
            autocomplete="off"
        >

        <?php if (!empty($search)) { ?>

            <span id="clearSearch" class="clear-search">
                &times;
            </span>

        <?php } ?>

    </form>

    <!-- MUST BE INSIDE search-wrapper -->
    <div id="searchSuggestions" class="search-suggestions"></div>

</div>


        <div class="button p-3" >

            <?php
            if (isset($_SESSION['user_email'])) {
            ?>

                <div style="margin-left:-15%; justify-content:space-around; display:flex; width:100%; align-items:center;">

                 

                    <div class="profile-dropdown">

<div class="profile-btn" onclick="toggleProfileMenu()">

    <div class="profile-avatar">
        <?php echo strtoupper(substr($_SESSION['user_name'],0,1)); ?>
    </div>

</div>

    <div class="profile-menu" id="profileMenu">

        <a href="userprofile.php">
            <i class="fa-solid fa-user"></i>
            <span>My Profile</span>
        </a>

        <a href="userorder.php">
            <i class="fa-solid fa-box"></i>
            <span>My Orders</span>
        </a>

        <a href="userwishlist.php">
            <i class="fa-solid fa-heart"></i>
            <span>Wishlist</span>
        </a>

        <div class="menu-divider"></div>

        <a href="logout.php" class="logout-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>

    </div>

</div>

                    <a href="usercart.php"
                        style="text-decoration:none;">

                        <div class="cart-icon-area">

                            <div class="cart-icon-box">

                                <i class="fa-solid fa-cart-shopping"></i>

                                <span id="cartCount" class="cart-count">

                                    <?php echo $cart_count; ?>

                                </span>

                            </div>

                        </div>

                    </a>



                    <a href="userwishlist.php"
                        style="text-decoration:none;">

                        <div class="wishlist-area">

                            <i class="fa-solid fa-heart wishlist-nav-icon"></i>

                            <span id="wishlistCount"
                                class="wishlist-count">

                                <?php echo $wishlist_count ?? 0; ?>

                            </span>

                        </div>

                    </a>

                </div>

            <?php
            } else {
            ?>

                <a class="buttons" href="register.php">
                    <button class="btn  sign" type="submit" id="button1">Sign In</button>
                </a>

            <?php } ?>

        </div>
    </div>
    
 <!-- <div class="mobile-overlay" id="overlay" onclick="closeMenu()"></div> -->

<!-- <div class="Alllink" id="mobileMenu">

    <div class="close-menu" onclick="closeMenu()">
        <i class="fas fa-times"></i>
    </div>

    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="catalogue.php">Catalogue</a>
    <a href="service.php">Service</a>
    <a href="gallery.php">Gallery</a>

</div> -->



    <script src="script.js"></script>
    <script src="search.js"></script>

    <script src="assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function redirectPage(select) {

            let page = select.value;

            if (page != "") {

                window.location.href = page;
            }

            select.selectedIndex = 0;
        }



        const clearBtn = document.getElementById("clearSearch");

        if (clearBtn) {

            clearBtn.addEventListener("click", function() {

                document.getElementById("searchInput").value = "";

                window.location.href = window.location.pathname;

            });

        }

        function toggleProfileMenu(){

    document.getElementById("profileMenu").classList.toggle("show");

}

window.onclick = function(e){

    const menu = document.getElementById("profileMenu");

    if(menu && !e.target.closest(".profile-dropdown")){

        menu.classList.remove("show");

    }

}


// function toggleMenu(){

//     document.querySelector(".Alllink").classList.toggle("active");

// }

const mobileMenu = document.getElementById("mobileMenu");
const overlay = document.getElementById("overlay");
const menuBtn = document.querySelector(".menu-btn");

function openMenu() {

    if(window.innerWidth > 750) return;

    mobileMenu.classList.add("active");
    overlay.classList.add("show");

    document.body.style.overflow = "hidden";
}

function closeMenu() {

    mobileMenu.classList.remove("active");
    overlay.classList.remove("show");

    document.body.style.overflow = "auto";
}

window.addEventListener("resize", function(){

    if(window.innerWidth > 750){

        closeMenu();

    }

});

const searchForm = document.querySelector(".search-bar-container");

if (searchForm) {

    searchForm.addEventListener("submit", function(e) {

        const input = document.getElementById("searchInput");

        if (!input || input.value.trim() === "") {

            e.preventDefault();

            input.focus();

            return;
        }

    });

}


const searchInput = document.getElementById("searchInput");
const searchSuggestions =
    document.getElementById("searchSuggestions");

let searchTimer = null;

if (searchInput && searchSuggestions) {

    searchInput.addEventListener("input", function () {

        const value = this.value.trim();

        clearTimeout(searchTimer);

        if (value.length < 1) {

            searchSuggestions.innerHTML = "";

            searchSuggestions.classList.remove("show");

            return;
        }

        searchSuggestions.innerHTML = `
            <div class="search-loading">
                Searching...
            </div>
        `;

        searchSuggestions.classList.add("show");

        searchTimer = setTimeout(function () {

            fetch(
                "search_suggestions.php?search=" +
                encodeURIComponent(value)
            )

            .then(response => response.json())

            .then(data => {

                searchSuggestions.innerHTML = "";

                if (!data || data.length === 0) {

                    searchSuggestions.innerHTML = `
                        <div class="search-no-result">
                            No matching results found
                        </div>
                    `;

                    searchSuggestions.classList.add("show");

                    return;
                }

                data.forEach(item => {

                    const link =
                        document.createElement("a");

                    link.href = item.url;

                    link.className =
                        "search-suggestion";

                    if (item.image) {

                        link.innerHTML = `

                            <img
                                src="images/${escapeHtml(item.image)}"
                                class="suggestion-image"
                                alt=""
                            >

                            <div class="suggestion-info">

                                <div class="suggestion-title">
                                    ${escapeHtml(item.title)}
                                </div>

                                <div class="suggestion-type">
                                    ${escapeHtml(item.type)}
                                </div>

                            </div>

                            ${
                                item.price
                                ? `
                                    <div class="suggestion-price">
                                        ₹${escapeHtml(item.price)}
                                    </div>
                                  `
                                : ""
                            }

                        `;

                    } else {

                        link.innerHTML = `

                            <div class="suggestion-icon">

                                <i class="fa-solid fa-layer-group"></i>

                            </div>

                            <div class="suggestion-info">

                                <div class="suggestion-title">
                                    ${escapeHtml(item.title)}
                                </div>

                                <div class="suggestion-type">
                                    ${escapeHtml(item.type)}
                                </div>

                            </div>

                        `;
                    }

                    searchSuggestions.appendChild(link);

                });

                searchSuggestions.classList.add("show");

            })

            .catch(error => {

                console.error(
                    "Search error:",
                    error
                );

                searchSuggestions.innerHTML = `
                    <div class="search-no-result">
                        Unable to load suggestions
                    </div>
                `;

            });

        }, 250);

    });


    // =========================================
    // CLOSE DROPDOWN WHEN CLICKING OUTSIDE
    // =========================================

    document.addEventListener("click", function (event) {

        if (
            !event.target.closest(
                ".search-bar-container"
            ) &&
            !event.target.closest(
                ".search-suggestions"
            )
        ) {

            searchSuggestions.classList.remove("show");

        }

    });


    // =========================================
    // ESCAPE KEY
    // =========================================

    searchInput.addEventListener("keydown", function (event) {

        if (event.key === "Escape") {

            searchSuggestions.classList.remove("show");

        }

    });

}


// =========================================
// HTML ESCAPE
// =========================================

function escapeHtml(value) {

    const div = document.createElement("div");

    div.textContent = value ?? "";

    return div.innerHTML;
}


    </script>



</body>

</html>