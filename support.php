
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


include("connect.php");

/** @var mysqli $conn */

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Support | Aroma Haven</title>

    <link rel="icon" href="weblogo.png">

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #f8f2eb;
            padding: 40px 15px;
        }

        /* =========================
           MAIN CONTAINER
        ========================= */

        .support-wrapper {
            max-width: 950px;
            margin: auto;
            background: #ffffff;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
        }

        /* =========================
           HEADER
        ========================= */

        .support-header {
            background: linear-gradient(135deg,
                    #6F4E37,
                    #C08B5C);

            color: #ffffff;
            padding: 35px;
            text-align: center;
        }

        .support-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 15px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.18);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 30px;
        }

        .support-header h2 {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .support-header p {
            margin: 0;
            opacity: 0.9;
        }

        /* =========================
           FORM SECTION
        ========================= */

        .support-body {
            padding: 35px;
        }

        .support-info {
            background: #faf6f1;

            border: 1px solid #eee1d5;

            border-radius: 15px;

            padding: 18px;

            margin-bottom: 25px;
        }

        .support-info strong {
            color: #4d3526;
        }

        .support-info i {
            color: #6F4E37;
            margin-right: 8px;
        }

        .support-info p {
            margin: 5px 0 0;

            color: #777;

            font-size: 14px;
        }

        /* =========================
           FORM LABEL
        ========================= */

        .form-label {
            font-weight: 600;
            color: #4d3526;
            margin-bottom: 7px;
        }

        .required {
            color: #dc3545;
        }

        /* =========================
           INPUTS
        ========================= */

        .form-control,
        .form-select {
            border: 1px solid #ddd0c4;

            border-radius: 12px;

            padding: 12px 15px;

            transition: 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #6F4E37;

            box-shadow:
                0 0 0 3px rgba(111, 78, 55, 0.12);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        /* =========================
           INPUT ICON
        ========================= */

        .input-group-text {
            background: #f8f2eb;

            border: 1px solid #ddd0c4;

            color: #6F4E37;

            border-radius: 12px 0 0 12px;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0;
        }

        /* =========================
           SUBMIT BUTTON
        ========================= */

        .submit-btn {
            width: 100%;

            border: none;

            background: linear-gradient(135deg,
                    #6F4E37,
                    #8B6245);

            color: #ffffff;

            padding: 14px;

            border-radius: 13px;

            font-size: 16px;

            font-weight: 600;

            transition: 0.3s;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg,
                    #4d3526,
                    #6F4E37);

            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(111, 78, 55, 0.25);
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 768px) {

            body {
                padding: 15px;
            }

            .support-header {
                padding: 25px 18px;
            }

            .support-body {
                padding: 22px 18px;
            }

            .support-wrapper{
                width: 90%;
                margin-left: -2%;
            }

        }
    </style>

</head>

<body>

    <div class="support-wrapper">

        <!-- =========================
             HEADER
        ========================= -->

        <div class="support-header">

            <div class="support-icon">

                <i class="fa-solid fa-headset"></i>

            </div>

            <h2>
                Customer Support
            </h2>

            <p>
                Have a question or facing a problem?
                Tell us and our admin will help you.
            </p>

        </div>


        <!-- =========================
             FORM
        ========================= -->

        <div class="support-body">

            <div class="support-info">

                <strong>

                    <i class="fa-solid fa-circle-info"></i>

                    How can we help?

                </strong>

                <p>
                    Please provide the details below so our admin
                    can understand your issue and assist you quickly.
                </p>

            </div>


            <form
                action="submit_support.php"
                method="POST"
                enctype="multipart/form-data">

                <!-- USER ID -->

                <input
                    type="hidden"
                    name="user_id"
                    value="<?php echo $user_id; ?>">


                <div class="row g-4">


                    <!-- =========================
                         NAME
                    ========================= -->

                    <div class="col-md-6">

                        <label class="form-label">

                            Full Name

                            <span class="required">*</span>

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="fa-solid fa-user"></i>

                            </span>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Enter your name"
                                required>

                        </div>

                    </div>


                    <!-- =========================
                         EMAIL
                    ========================= -->

                    <div class="col-md-6">

                        <label class="form-label">

                            Email Address

                            <span class="required">*</span>

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="fa-solid fa-envelope"></i>

                            </span>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter your email"
                                required>

                        </div>

                    </div>


                    <!-- =========================
                         PHONE
                    ========================= -->

                    <div class="col-md-6">

                        <label class="form-label">

                            Phone Number

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="fa-solid fa-phone"></i>

                            </span>

                            <input
                                type="tel"
                                name="phone"
                                class="form-control"
                                placeholder="Enter your phone number">

                        </div>

                    </div>


                    <!-- =========================
                         SUPPORT TYPE
                    ========================= -->

                    <div class="col-md-6">

                        <label class="form-label">

                            What do you need help with?

                            <span class="required">*</span>

                        </label>

                        <select
                            name="support_type"
                            class="form-select"
                            required>

                            <option value="">
                                Select an option
                            </option>

                            <option value="Order Problem">
                                Order Problem
                            </option>

                            <option value="Payment Problem">
                                Payment Problem
                            </option>

                            <option value="Product Problem">
                                Product Problem
                            </option>

                            <option value="Booking Problem">
                                Table Booking Problem
                            </option>

                            <option value="Account Problem">
                                Account Problem
                            </option>

                            <option value="Refund">
                                Refund / Cancellation
                            </option>

                            <option value="Other">
                                Other
                            </option>

                        </select>

                    </div>


                    <!-- =========================
                         ORDER ID
                    ========================= -->

                    <div class="col-md-6">

                        <label class="form-label">

                            Order ID

                            <small class="text-muted">
                                (Optional)
                            </small>

                        </label>

                        <input
                            type="text"
                            name="order_id"
                            class="form-control"
                            placeholder="Example: ORD-1025">

                    </div>


                    <!-- =========================
                         PRIORITY
                    ========================= -->

                    <div class="col-md-6">

                        <label class="form-label">

                            Priority

                        </label>

                        <select
                            name="priority"
                            class="form-select">

                            <option value="Normal">
                                Normal
                            </option>

                            <option value="High">
                                High
                            </option>

                            <option value="Urgent">
                                Urgent
                            </option>

                        </select>

                    </div>


                    <!-- =========================
                         MESSAGE
                    ========================= -->

                    <div class="col-12">

                        <label class="form-label">

                            Message

                            <span class="required">*</span>

                        </label>

                        <textarea
                            name="message"
                            class="form-control"
                            placeholder="Tell us what you want to tell the admin. Please describe your problem or question in detail..."
                            required></textarea>

                    </div>


                    <!-- =========================
                         ATTACHMENT
                    ========================= -->

                    <div class="col-12">

                        <label class="form-label">

                            Attachment

                            <small class="text-muted">
                                (Optional)
                            </small>

                        </label>

                        <input
                            type="file"
                            name="attachment"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.pdf">

                        <small class="text-muted">

                            You can attach a screenshot or document.
                            JPG, PNG and PDF allowed.

                        </small>

                    </div>


                    <!-- =========================
                         SUBMIT
                    ========================= -->

                    <div class="col-12 mt-2">

                        <button
                            type="submit"
                            name="submit_support"
                            class="submit-btn">

                            <i class="fa-solid fa-paper-plane me-2"></i>

                            Send Message to Management

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>