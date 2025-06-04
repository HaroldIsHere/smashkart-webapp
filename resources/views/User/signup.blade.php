<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SmashKart Create</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      display: flex;
      height: 100vh;
    }

    .left {
      width: 50%;
      background: #FFDE59;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .logo {
      font-size: 40px;
      font-style: italic;
      font-weight: 900;
      color: #000;
      margin: 20px;
      letter-spacing: 1px;
    }

    .left img {
      width: 100%;
      height: calc(100% - 60px);
      object-fit: cover;
    }

    .right {
      width: 50%;
      padding: 60px 80px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #fff;
      margin-top: -8%;
    }

    .header-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 40px;
    }

    .header-row h2 {
      font-size: 30px;
      font-weight: 900;
      color: #000;
    }

    .header-row .back {
      font-size: 16px;
      color: #000;
      text-decoration: none;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      font-size: 12px;
      font-weight: 600;
      color: #000;
      margin-top: 16px;
      margin-bottom: 6px;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 16px;
      border: 1px solid #f2f2f2;
      background-color: #f2f2f2;
      border-radius: 15px;
      font-size: 14px;
    }

    .submit-btn {
      background: #3C2EFF;
      color: #fff;
      font-weight: 600;
      padding: 12px;
      border: none;
      width: 100%;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      margin-top: 24px;
    }

    .links {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      margin-top: 20px;
    }

    .links a {
      color: #3C2EFF;
      text-decoration: none;
      font-weight: 600;
    }

    .social-login {
      margin-top: 60px;
      text-align: center;
    }

    .social-login p {
      font-size: 12px;
      color: #444;
      margin-bottom: 10px;
    }

    .social-icons img {
      width: 30px;
      height: 30px;
      margin: 0 10px;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="left">
    <div class="logo">SMASHKART</div>
    <img src="/img/extra/Picture1.png" alt="Badminton Image" />
  </div>

  <div class="right">
    <div class="header-row">
      <h2>CREATE AN ACCOUNT</h2>
      <a class="back" href="#">← Back</a>
    </div>

    <form>
      <label for="email">ENTER YOUR EMAIL ADDRESS</label>
      <input type="email" id="email" placeholder="EMAIL" required />

      <label for="password">ENTER YOUR PASSWORD</label>
      <input type="password" id="password" placeholder="PASSWORD" required />

      <label for="confirmpassword">CONFIRM PASSWORD</label>
      <input type="password" id="confirmpassword" placeholder="CONFIRM PASSWORD" required />

      <button class="submit-btn">SUBMIT</button>
    </form>

    <div class="links">
      <div>Don't have an account? <a href="#">Sign Up</a></div>
      <div><a href="#">Forgot your password?</a></div>
    </div>

    <div class="social-login">
      <p>TRY OTHER METHOD</p>
      <div class="social-icons">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg"
          alt="Facebook Login">
        <img src="/img/extra/Google Icon.jpg" alt="Google Login">
      </div>
    </div>
  </div>
</body>

</html>