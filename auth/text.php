<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form method="POST" class="register-form" id="register-form" action="config/register_parent.php">
    <div class="form-group">
      <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
      <input type="text" name="username" id="username" required placeholder="Username" />
    </div>
    <div class="form-group">
      <label for="email"><i class="zmdi zmdi-email"></i></label>
      <input type="email" name="email" id="email" required placeholder="Your Email" />
    </div>
    <div class="form-group">
      <label for="pass"><i class="zmdi zmdi-lock"></i></label>
      <input type="password" name="password" id="pass" required placeholder="Password" />
    </div>
    <div class="form-group">
      <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
      <input type="password" name="re_pass" id="re_pass" required placeholder="Repeat your password" />
    </div>
    <div class="form-group">
      <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required />
      <label for="agree-term" class="label-agree-term">I agree to the <a href="#" class="term-service">Terms of Service</a></label>
    </div>
    <div class="form-group form-button">
      <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
    </div>
  </form>
</body>

</html>