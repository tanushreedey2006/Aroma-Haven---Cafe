﻿<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="coffee.css" />
    <link rel="stylesheet" type="text/css" href="mobile-responsive.css" />
    <link rel="icon" type="image/png" href="weblogo.png">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-5.3.7-dist/css/bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
        @media (max-width:750px) {

            .share-container {
                gap: 7px;
            }
        }


        .foo-main {
            position: relative;
        }

        .subscribe-card {
            display: none;
            position: absolute;
            z-index: 1000;

            width: 320px;
            padding: 30px 25px;

            background: #ffffff;
            border-radius: 18px;
            text-align: center;

            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);

            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .subscribe-card.show {
            display: block;
            animation: cardShow 0.3s ease;
        }

        .subscribe-success-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #e8f5e9;
            color: #28a745;

            font-size: 28px;
        }

        .subscribe-card h3 {
            color: #30261c;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subscribe-card p {
            color: #666;
            margin-bottom: 0;
        }

        @keyframes cardShow {
            from {
                opacity: 0;
                transform: translate(-50%, -45%) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }


        .subscribe-card {
            display: none;
            position: absolute;
            z-index: 1000;

            width: 320px;
            padding: 30px 25px;

            background: #ffffff;
            border-radius: 18px;
            text-align: center;

            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);

            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .close-card {
            position: absolute;
            top: 12px;
            right: 15px;

            width: 32px;
            height: 32px;

            border: none;
            background: transparent;

            color: #30261c;
            font-size: 28px;
            cursor: pointer;
            line-height: 1;
        }

        .close-card:hover {
            color: #c17530;
            transform: scale(1.1);
        }

        .continue-btn {
            margin-top: 18px;
            padding: 10px 0px;
            border: none;
            border-radius: 25px;
            width: 40% !important;
            background: #30261c;
            color: #fff;

            cursor: pointer;
            transition: 0.3s;
        }

        .continue-btn:hover {
            background: #c17530;
        }




/* ==========================================
   FINAL MOBILE FOOTER - 2 ITEMS PER ROW
========================================== */

@media (max-width: 750px) {

    .foolast {
        width: 100% !important;
        overflow: hidden !important;
    }

    .foolast .org {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;

        width: 100% !important;
        padding: 25px 18px !important;
        margin: 0 !important;

        gap: 22px 18px !important;

        box-sizing: border-box !important;
    }

    /* Aroma Haven */
    .foolast .aro {
        grid-column: 1 / 3 !important;

        width: 100% !important;
        text-align: center !important;

        margin: 0 !important;
        padding: 0 !important;
    }

    .foolast .aro h1 {
        font-size: 25px !important;
        margin: 0 !important;
    }

    .foolast .share-container {
        padding-top: 15px !important;

        display: flex !important;
        justify-content: center !important;
        align-items: center !important;

        gap: 7px !important;
    }

    /* FOUR FOOTER BLOCKS */
    .foolast .check {
        width: auto !important;
        min-width: 0 !important;

        margin: 0 !important;
        padding: 0 !important;

        text-align: left !important;
    }

    .foolast .check h4 {
        font-size: 16px !important;

        margin: 0 0 8px 0 !important;
        padding: 0 !important;
    }

    .foolast .check p {
        font-size: 13px !important;

        line-height: 1.55 !important;

        margin: 0 !important;
        padding: 0 !important;
    }

    /* COPYRIGHT */
    .foolast .copylast {
        width: 100% !important;

        margin: 0 !important;
        padding: 12px 15px 18px !important;

        text-align: center !important;

        box-sizing: border-box !important;
    }

    .foolast .copylast p {
        font-size: 12px !important;
        line-height: 1.4 !important;

        margin: 0 !important;
    }
}


/* ==========================================
   SMALL PHONES
========================================== */

@media (max-width: 400px) {

    .foolast .org {
        grid-template-columns: 1fr 1fr !important;

        padding: 22px 14px !important;

        gap: 18px 12px !important;
    }

    .foolast .check h4 {
        font-size: 15px !important;
    }

    .foolast .check p {
        font-size: 12px !important;
        line-height: 1.5 !important;
    }

    .foolast .aro h1 {
        font-size: 23px !important;
    }
}


/* =========================================================
   FINAL FORCE MOBILE FOOTER
   PRIVACY + SERVICES
   ABOUT US + INFORMATION
========================================================= */

@media screen and (max-width: 750px) {

    /* FOOTER BACKGROUND */
    .foolast {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }

    /* MAIN FOOTER GRID */
    .foolast .org {
        width: 100% !important;
        max-width: 100% !important;

        display: grid !important;

        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;

        grid-template-rows: auto auto auto !important;

        grid-template-areas:
            "logo logo"
            "privacy services"
            "about information" !important;

        gap: 22px 14px !important;

        margin: 0 !important;
        padding: 25px 18px !important;

        box-sizing: border-box !important;

        justify-content: stretch !important;
        align-items: start !important;
    }

    /* =========================
       AROMA HAVEN
    ========================= */

    .foolast .org > .aro {
        grid-area: logo !important;

        width: 100% !important;
        max-width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;

        display: block !important;

        text-align: center !important;
    }

    .foolast .org > .aro h1 {
        margin: 0 !important;
        padding: 0 !important;

        font-size: 24px !important;
        line-height: 1.2 !important;
    }

    .foolast .org > .aro .share-container {
        width: 100% !important;

        display: flex !important;
        flex-direction: row !important;

        justify-content: center !important;
        align-items: center !important;

        flex-wrap: nowrap !important;

        gap: 7px !important;

        margin: 0 !important;
        padding: 15px 0 0 !important;
    }


    /* =========================
       ALL FOUR SECTIONS
    ========================= */

    .foolast .org > .check {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;

        display: block !important;

        margin: 0 !important;
        padding: 0 !important;

        flex: none !important;

        text-align: left !important;

        box-sizing: border-box !important;
    }


    /* =========================
       EXPLICIT POSITIONS
    ========================= */

    /* PRIVACY */
    .foolast .org > .check:nth-child(2) {
        grid-area: privacy !important;
    }

    /* SERVICES */
    .foolast .org > .check:nth-child(3) {
        grid-area: services !important;
    }

    /* ABOUT US */
    .foolast .org > .check:nth-child(4) {
        grid-area: about !important;
    }

    /* INFORMATION */
    .foolast .org > .check:nth-child(5) {
        grid-area: information !important;
    }


    /* =========================
       HEADINGS
    ========================= */

    .foolast .check h4 {
        margin: 0 0 8px 0 !important;
        padding: 0 !important;

        font-size: 15px !important;
        line-height: 1.2 !important;

        white-space: nowrap !important;
    }


    /* =========================
       PARAGRAPHS
    ========================= */

    .foolast .check p {
        margin: 0 !important;
        padding: 0 !important;

        font-size: 12px !important;
        line-height: 1.6 !important;

        white-space: normal !important;
    }


    /* =========================
       COPYRIGHT
    ========================= */

    .foolast .copylast {
        width: 100% !important;

        margin: 0 !important;
        padding: 10px 15px 18px !important;

        box-sizing: border-box !important;

        text-align: center !important;
    }

    .foolast .copylast p {
        margin: 0 !important;
        padding: 0 !important;

        font-size: 11px !important;
        line-height: 1.5 !important;
    }
}


/* =========================================================
   SMALL PHONES
========================================================= */

@media screen and (max-width: 400px) {

    .foolast .org {
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;

        gap: 20px 12px !important;

        padding: 22px 14px !important;
    }

    .foolast .org > .aro h1 {
        font-size: 22px !important;
    }

    .foolast .check h4 {
        font-size: 14px !important;
    }

    .foolast .check p {
        font-size: 11px !important;
        line-height: 1.55 !important;
    }
}



/* ============================================
   FOOTER MOBILE - FORCE 2 ITEMS PER ROW
============================================ */

.footer-grid{
    display:flex;
    justify-content:space-evenly;
    align-items:flex-start;
}


/* ============================================
   MOBILE
============================================ */

@media screen and (max-width:750px){

    .foolast{
        width:100% !important;
        margin:0 !important;
        padding:0 !important;
        overflow:hidden !important;
    }

    .footer-grid{
        width:100% !important;

        display:grid !important;

        grid-template-columns:50% 50% !important;

        grid-template-rows:auto auto auto !important;

        margin:0 !important;

        padding:25px 10px !important;

        box-sizing:border-box !important;

        gap:0 !important;

        justify-content:initial !important;
        align-items:start !important;
    }


    /* =====================================
       AROMA HAVEN
    ===================================== */

    .footer-grid .aro{

        grid-column:1 / 3 !important;
        grid-row:1 !important;

        width:100% !important;

        margin:0 !important;
        padding:0 0 25px 0 !important;

        text-align:center !important;

        box-sizing:border-box !important;
    }

    .footer-grid .aro h1{

        margin:0 !important;
        padding:0 !important;

        font-size:23px !important;
    }

    .footer-grid .aro .share-container{

        width:100% !important;

        display:flex !important;

        justify-content:center !important;
        align-items:center !important;

        flex-wrap:nowrap !important;

        gap:8px !important;

        margin:0 !important;
        padding:15px 0 0 0 !important;
    }


    /* =====================================
       PRIVACY
    ===================================== */

    .footer-grid .check:nth-child(2){

        grid-column:1 !important;
        grid-row:2 !important;

        width:100% !important;

        margin:0 !important;
        padding:0 5px !important;

        box-sizing:border-box !important;

        text-align:left !important;
    }


    /* =====================================
       SERVICES
    ===================================== */

    .footer-grid .check:nth-child(3){

        grid-column:2 !important;
        grid-row:2 !important;

        width:100% !important;

        margin:0 !important;
        padding:0 5px !important;

        box-sizing:border-box !important;

        text-align:left !important;
    }


    /* =====================================
       ABOUT US
    ===================================== */

    .footer-grid .check:nth-child(4){

        grid-column:1 !important;
        grid-row:3 !important;

        width:100% !important;

        margin:20px 0 0 0 !important;
        padding:0 5px !important;

        box-sizing:border-box !important;

        text-align:left !important;
    }


    /* =====================================
       INFORMATION
    ===================================== */

    .footer-grid .check:nth-child(5){

        grid-column:2 !important;
        grid-row:3 !important;

        width:100% !important;

        margin:20px 0 0 0 !important;
        padding:0 5px !important;

        box-sizing:border-box !important;

        text-align:left !important;
    }


    /* =====================================
       HEADINGS
    ===================================== */

    .footer-grid .check h4{

        margin:0 0 8px 0 !important;
        padding:0 !important;

        font-size:14px !important;

        line-height:1.2 !important;

        white-space:nowrap !important;
    }


    /* =====================================
       TEXT
    ===================================== */

    .footer-grid .check p{

        display:block !important;

        width:100% !important;

        margin:0 !important;
        padding:0 !important;

        font-size:11px !important;

        line-height:1.6 !important;

        white-space:normal !important;
    }


    /* =====================================
       COPYRIGHT
    ===================================== */

    .foolast .copylast{

        width:100% !important;

        margin:0 !important;

        padding:12px 10px 18px !important;

        text-align:center !important;

        box-sizing:border-box !important;
    }

    .foolast .copylast p{

        margin:0 !important;
        padding:0 !important;

        font-size:10px !important;

        line-height:1.4 !important;
    }

}


/* ============================================
   VERY SMALL MOBILE
============================================ */

@media screen and (max-width:400px){

    .footer-grid{

        grid-template-columns:50% 50% !important;

        padding:22px 8px !important;
    }

    .footer-grid .check:nth-child(4),
    .footer-grid .check:nth-child(5){

        margin-top:18px !important;
    }

    .footer-grid .check h4{

        font-size:13px !important;
    }

    .footer-grid .check p{

        font-size:10px !important;
    }

    .footer-grid .aro h1{

        font-size:21px !important;
    }
}


/* =========================================================
   FINAL MOBILE FOOTER FIX
   NO HTML CHANGE REQUIRED
   AROMA HAVEN = FULL ROW
   PRIVACY | SERVICES
   ABOUT US | INFORMATION
   ========================================================= */

@media screen and (max-width: 750px) {

    /* FOOTER */
    .foolast {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }

    /* MAIN FOOTER CONTAINER */
    .foolast .org {
        width: 100% !important;
        max-width: 100% !important;

        display: flex !important;

        flex-direction: row !important;
        flex-wrap: wrap !important;

        justify-content: flex-start !important;
        align-items: flex-start !important;

        gap: 0 !important;

        margin: 0 !important;
        padding: 25px 18px !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       AROMA HAVEN
       FULL WIDTH FIRST ROW
       ===================================================== */

    .foolast .org > .aro {
        display: block !important;

        width: 100% !important;
        max-width: 100% !important;

        flex: 0 0 100% !important;
        flex-basis: 100% !important;

        margin: 0 0 25px 0 !important;
        padding: 0 !important;

        text-align: center !important;

        box-sizing: border-box !important;
    }

    .foolast .org > .aro h1 {
        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;

        font-size: 24px !important;
        line-height: 1.2 !important;

        text-align: center !important;
    }


    /* SOCIAL ICONS */

    .foolast .org > .aro .share-container {
        width: 100% !important;

        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;

        justify-content: center !important;
        align-items: center !important;

        gap: 8px !important;

        margin: 0 !important;
        padding: 12px 0 0 0 !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       ALL FOUR SECTIONS
       EACH = EXACTLY 50%
       ===================================================== */

    .foolast .org > .check {

        display: block !important;

        width: 50% !important;
        max-width: 50% !important;
        min-width: 0 !important;

        flex: 0 0 50% !important;
        flex-basis: 50% !important;

        margin: 0 !important;
        padding: 0 8px !important;

        box-sizing: border-box !important;

        text-align: left !important;

        float: none !important;
    }


    /* =====================================================
       PRIVACY
       ===================================================== */

    .foolast .org > .check:nth-child(2) {
        width: 50% !important;
        max-width: 50% !important;
        flex: 0 0 50% !important;
        flex-basis: 50% !important;

        margin: 0 !important;
        padding: 0 8px !important;
    }


    /* =====================================================
       SERVICES
       ===================================================== */

    .foolast .org > .check:nth-child(3) {
        width: 50% !important;
        max-width: 50% !important;
        flex: 0 0 50% !important;
        flex-basis: 50% !important;

        margin: 0 !important;
        padding: 0 8px !important;
    }


    /* =====================================================
       ABOUT US
       ===================================================== */

    .foolast .org > .check:nth-child(4) {
        width: 50% !important;
        max-width: 50% !important;
        flex: 0 0 50% !important;
        flex-basis: 50% !important;

        margin: 25px 0 0 0 !important;
        padding: 0 8px !important;
    }


    /* =====================================================
       INFORMATION
       ===================================================== */

    .foolast .org > .check:nth-child(5) {
        width: 50% !important;
        max-width: 50% !important;
        flex: 0 0 50% !important;
        flex-basis: 50% !important;

        margin: 25px 0 0 0 !important;
        padding: 0 8px !important;
    }


    /* =====================================================
       HEADINGS
       ===================================================== */

    .foolast .org > .check h4 {
        display: block !important;

        width: 100% !important;

        margin: 0 0 8px 0 !important;
        padding: 0 !important;

        font-size: 14px !important;
        line-height: 1.2 !important;

        white-space: nowrap !important;
    }


    /* =====================================================
       TEXT
       ===================================================== */

    .foolast .org > .check p {
        display: block !important;

        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;

        font-size: 11px !important;
        line-height: 1.6 !important;

        white-space: normal !important;
    }


    /* =====================================================
       COPYRIGHT
       ===================================================== */

    .foolast .copylast {
        display: block !important;

        width: 100% !important;
        max-width: 100% !important;

        margin: 0 !important;
        padding: 12px 15px 18px !important;

        box-sizing: border-box !important;

        text-align: center !important;
    }

    .foolast .copylast p {
        display: block !important;

        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;

        font-size: 10px !important;
        line-height: 1.5 !important;
    }
}


/* =========================================================
   VERY SMALL PHONE
   ========================================================= */

@media screen and (max-width: 400px) {

    .foolast .org {
        padding: 22px 12px !important;
    }

    .foolast .org > .aro h1 {
        font-size: 21px !important;
    }

    .foolast .org > .check {
        padding: 0 6px !important;
    }

    .foolast .org > .check h4 {
        font-size: 13px !important;
    }

    .foolast .org > .check p {
        font-size: 10px !important;
        line-height: 1.5 !important;
    }
}

/* =========================================================
   ABSOLUTE FINAL MOBILE FOOTER
   HTML CHANGE NOT REQUIRED
   PRIVACY | SERVICES
   ABOUT US | INFORMATION
   ========================================================= */

@media screen and (max-width: 750px) {

    /* FOOTER AREA */
    .foolast {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        background: #30261c !important;
    }

    /* MAIN .org CONTAINER */
    .foolast > .org {
        position: relative !important;

        display: block !important;

        width: 100% !important;
        max-width: 100% !important;

        height: 430px !important;
        min-height: 430px !important;

        margin: 0 !important;
        padding: 20px 15px !important;

        box-sizing: border-box !important;

        overflow: hidden !important;
    }

    /* =====================================================
       AROMA HAVEN
       ===================================================== */

    .foolast > .org > .aro {
        position: absolute !important;

        top: 18px !important;
        left: 0 !important;

        width: 100% !important;
        height: 115px !important;

        margin: 0 !important;
        padding: 0 !important;

        display: block !important;

        text-align: center !important;
        box-sizing: border-box !important;

        z-index: 10 !important;
    }

    .foolast > .org > .aro h1 {
        display: block !important;

        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;

        font-size: 24px !important;
        line-height: 1.2 !important;

        text-align: center !important;
    }

    /* SOCIAL ICONS */
    .foolast > .org > .aro .share-container {
        position: static !important;

        width: 100% !important;

        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;

        justify-content: center !important;
        align-items: center !important;

        gap: 8px !important;

        margin: 0 !important;
        padding: 12px 0 0 !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       ALL FOUR CHECK SECTIONS
       ===================================================== */

    .foolast > .org > .check {

        position: absolute !important;

        display: block !important;

        width: 45% !important;
        max-width: 45% !important;
        min-width: 0 !important;

        margin: 0 !important;
        padding: 0 !important;

        box-sizing: border-box !important;

        text-align: left !important;

        transform: none !important;
        float: none !important;
        flex: none !important;

        z-index: 5 !important;
    }


    /* =====================================================
       PRIVACY — LEFT TOP
       ===================================================== */

    .foolast > .org > .check:nth-child(2) {
        top: 145px !important;
        left: 15px !important;
        right: auto !important;
        bottom: auto !important;
    }


    /* =====================================================
       SERVICES — RIGHT TOP
       ===================================================== */

    .foolast > .org > .check:nth-child(3) {
        top: 145px !important;
        left: 55% !important;
        right: auto !important;
        bottom: auto !important;
    }


    /* =====================================================
       ABOUT US — LEFT BOTTOM
       ===================================================== */

    .foolast > .org > .check:nth-child(4) {
        top: 285px !important;
        left: 15px !important;
        right: auto !important;
        bottom: auto !important;
    }


    /* =====================================================
       INFORMATION — RIGHT BOTTOM
       ===================================================== */

    .foolast > .org > .check:nth-child(5) {
        top: 285px !important;
        left: 55% !important;
        right: auto !important;
        bottom: auto !important;
    }


    /* =====================================================
       HEADINGS
       ===================================================== */

    .foolast > .org > .check h4 {
        display: block !important;

        width: 100% !important;

        margin: 0 0 8px 0 !important;
        padding: 0 !important;

        font-size: 15px !important;
        line-height: 1.2 !important;

        white-space: nowrap !important;
    }


    /* =====================================================
       FOOTER TEXT
       ===================================================== */

    .foolast > .org > .check p {
        display: block !important;

        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;

        font-size: 11px !important;
        line-height: 1.6 !important;

        white-space: normal !important;
    }


    /* =====================================================
       COPYRIGHT
       ===================================================== */

    .foolast > .copylast {
        position: relative !important;

        width: 100% !important;

        margin: 0 !important;
        padding: 12px 15px 20px !important;

        text-align: center !important;

        box-sizing: border-box !important;

        background: #30261c !important;
    }

    .foolast > .copylast p {
        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;

        font-size: 10px !important;
        line-height: 1.5 !important;

        text-align: center !important;
    }
}


/* =========================================================
   SMALL PHONES
   ========================================================= */

@media screen and (max-width: 400px) {

    .foolast > .org {
        height: 410px !important;
        min-height: 410px !important;
        padding: 18px 12px !important;
    }

    .foolast > .org > .aro {
        top: 15px !important;
        height: 105px !important;
    }

    .foolast > .org > .aro h1 {
        font-size: 21px !important;
    }

    .foolast > .org > .check {
        width: 45% !important;
        max-width: 45% !important;
    }

    .foolast > .org > .check:nth-child(2) {
        top: 130px !important;
        left: 12px !important;
    }

    .foolast > .org > .check:nth-child(3) {
        top: 130px !important;
        left: 55% !important;
    }

    .foolast > .org > .check:nth-child(4) {
        top: 265px !important;
        left: 12px !important;
    }

    .foolast > .org > .check:nth-child(5) {
        top: 265px !important;
        left: 55% !important;
    }

    .foolast > .org > .check h4 {
        font-size: 13px !important;
    }

    .foolast > .org > .check p {
        font-size: 10px !important;
 
    }
}


/* =====================================================
   FINAL COMPACT MOBILE FOOTER
   শুধু GAP কমানো
===================================================== */

@media screen and (max-width: 750px) {

    .foolast > .org {
        height: 350px !important;
        min-height: 350px !important;

        padding: 15px 15px !important;
    }

    /* Aroma Haven */
    .foolast > .org > .aro {
        top: 12px !important;
        height: 105px !important;
    }

    .foolast > .org > .aro h1 {
        font-size: 24px !important;
    }

    .foolast > .org > .aro .share-container {
        padding-top: 10px !important;
        gap: 7px !important;
    }

    /* PRIVACY */
    .foolast > .org > .check:nth-child(2) {
        top: 125px !important;
        left: 15px !important;
    }

    /* SERVICES */
    .foolast > .org > .check:nth-child(3) {
        top: 125px !important;
        left: 55% !important;
    }

    /* ABOUT US */
    .foolast > .org > .check:nth-child(4) {
        top: 235px !important;
        left: 15px !important;
    }

    /* INFORMATION */
    .foolast > .org > .check:nth-child(5) {
        top: 235px !important;
        left: 55% !important;
    }

    /* Heading */
    .foolast > .org > .check h4 {
        font-size: 14px !important;
        margin-bottom: 6px !important;
    }

    /* Text */
    .foolast > .org > .check p {
        font-size: 11px !important;
        line-height: 1.45 !important;
    }

    /* Copyright */
    .foolast > .copylast {
        padding: 8px 12px 15px !important;
    }

    .foolast > .copylast p {
        font-size: 10px !important;
        line-height: 1.4 !important;
    }
}


/* SMALL PHONE */
@media screen and (max-width: 400px) {

    .foolast > .org {
        height: 335px !important;
        min-height: 335px !important;
        padding: 12px !important;
    }

    .foolast > .org > .aro {
        top: 10px !important;
    }

    .foolast > .org > .check:nth-child(2) {
        top: 118px !important;
        left: 12px !important;
    }

    .foolast > .org > .check:nth-child(3) {
        top: 118px !important;
        left: 55% !important;
    }

    .foolast > .org > .check:nth-child(4) {
        top: 220px !important;
        left: 12px !important;
    }

    .foolast > .org > .check:nth-child(5) {
        top: 220px !important;
        left: 55% !important;
    }

    .foolast > .org > .check h4 {
        font-size: 13px !important;
    }

    .foolast > .org > .check p {
        font-size: 10px !important;
        line-height: 1.4 !important;
    }
}
    </style>
</head>

<body>

    <div class="foo-main" id="foo-main">
        <div class="footer">
            <h1 class=" fw-bold m-0 p-0">Join in and get </h1>
            <h1 class=" fw-bold m-0 p-0">15% Off</h1>
            <p class=" fw-bold fs-5">Subscribe us and get 15% Off discount</p>
            <div class="d-flex gap-3 respon flex-wrap">
                <input type="text" placeholder=" Mail Message" style="border: none; background-color: #fff; height: 6vh;" class="rounded-5">


                <button class="btn text-light rounded-5" type="submit" style="height: 6vh; background-color: #30261c; border: none;"
                    onclick="abc()" id="a1">Subscribe</button>


                <div class="subscribe-card" id="subscribeCard">

                    <button type="button" class="close-card" onclick="closeCard()">
                        &times;
                    </button>

                    <div class="subscribe-success-icon">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <h3>Thank You!</h3>

                    <p>Thanks for subscribing to Aroma Haven! 🎉</p>

                    <button type="button" class="continue-btn" onclick="closeCard()">
                        Continue
                    </button>

                </div>

                <script>
                    function abc() {
                        document.getElementById("subscribeCard").classList.add("show");
                    }

                    function closeCard() {
                        document.getElementById("subscribeCard").classList.remove("show");
                    }
                </script>


            </div>
        </div>
    </div>
    <div class="foolast" style="background-color: #30261c; ">
        <div class="d-flex text-light justify-content-evenly org">
            <div class="fw-bold aro">
                <h1 style="color: #c17530;"><i><b>Aroma Haven</b></i></h1>
                <div class="share-container" style="padding-top: 30px;">

                    <a href="#" class="share-btn" data-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="share-btn" data-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="share-btn" data-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="share-btn" data-label="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="share-btn" data-label="Linkedin">
                        <i class="fab fa-linkedin-in "></i>
                    </a>
                </div>
            </div>

            <div class="check">
                <h4><b>PRIVACY</b></h4>
                <p class="m-0 p-0">Terms of use</p>
                <p class="m-0 p-0">Privacy policy</p>
                <p class="m-0 p-0">Cookies</p>
            </div>
            <div class="check">
                <h4><b>SERVICES</b></h4>
                <p class="m-0 p-0">Shop</p>
                <p class="m-0 p-0">Order ahead</p>
                <p class="m-0 p-0">Menu</p>
            </div>
            <div class="check">
                <h4><b>ABOUT US</b></h4>
                <p class="m-0 p-0">Find a location</p>
                <p class="m-0 p-0">About us</p>
                <p class="m-0 p-0">Our story</p>
                <p class="m-0 p-0">Contact</p>
            </div>
            <div class="check">
                <h4><b>INFORMATION</b></h4>
                <p class="m-0 p-0">Plans & pricing</p>
                <p class="m-0 p-0">Sell your products</p>
                <p class="m-0 p-0">Jobs</p>
            </div>
        </div>
        <div class="copylast">

            <p style="color: #fff;">&copy; Awesome Coffee, All rights reserved by Tanushree Dey</p>
        </div>
    </div>

    </div>

    <script src="assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>