<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="POST">
        <h3>Register Now</h3>
        <input type="text" name="name" required placeholder="Enter your name">
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="text" name="mobile" required placeholder="Enter your mobile">
        <input type="password" name="password" required placeholder="Enter your password">
        <input type="password" name="cpassword" required placeholder="Confirm your password">
        <input type="text" name="referralcode" required placeholder="Refeer Code">
        <input type="text" name="referralpoint">

        <input type="submit" value="Register Now" class="form-btn">
        <p>Already have an account? <a href="login_form.php">Login Now</a></p>
        </form>
    </div>
</body>
</html>