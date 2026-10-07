<div class="form-customer">
    <div class="auth-wrapper">
  <div class="auth-image">
    <h2>Welcome Back!</h2>
    <p>Login or create an account to access exclusive range of Pawar Handloom seamlessly.</p>
  </div>

  <div class="auth-box">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>
    <div class="tabs">
      <button class="tab-btn active" onclick="showForm('login')">Login</button>
      <button class="tab-btn" onclick="showForm('register')">Register</button>
    </div>

    <!-- Login Form -->
    <form id="login" class="active" method="post" action="<?= base_url('CustomerRegister'); ?>">
        
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name='email' placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name='password' placeholder="Enter your password" required>
      </div>
      <button type='submit' class="submit-btn" name="submitLogin" value="1">Login</button>
      <div class="extra">
        <a href="<?= base_url('forgotPassword'); ?>">Forgot Password?</a>
      </div>
    </form>

    <!-- Register Form -->
    <form id="register" method="post" action="<?= base_url('CustomerRegister'); ?>">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name='name' placeholder="Enter your name" required>
      </div>
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name='email' placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name='password' placeholder="Create a password" required>
      </div>
      <button type='submit' class="submit-btn" name="submitRegister" value="1">Create Account</button>
      <div class="extra">
        Already have an account? <a href="#" onclick="showForm('login')">Login</a>
      </div>
    </form>
  </div>
</div>
</div>
    
    <style>

     
    .form-customer{
      min-height:90vh;
      display:flex;
      align-items:center;
      justify-content:center;
      background:bisque;
    }

    .auth-wrapper{
      width:900px;
      max-width:95%;
      background:#fff;
      border-radius:16px;
      box-shadow:0 20px 40px rgba(0,0,0,0.2);
      display:flex;
      overflow:hidden;
    }

    .auth-image{
      flex:1;
      background:linear-gradient(135deg, #ce9589, #c9a9eb);
      color:#fff;
      padding:40px;
      display:flex;
      flex-direction:column;
      justify-content:center;
    }

    .auth-image h2{
      font-size:32px;
      margin-bottom:10px;
    }

    .auth-image p{
      font-size:14px;
      opacity:0.9;
      line-height:1.6;
    }

    .auth-box{
      flex:1;
      padding:40px;
    }

    .tabs{
      display:flex;
      margin-bottom:30px;
    }

    .tabs button{
      flex:1;
      padding:12px;
      border:none;
      background:#f1f1f1;
      cursor:pointer;
      font-weight:500;
      transition:0.3s;
    }

    .tabs button.active{
      background:#ac4024;
      color:#fff;
    }

    form{
      display:none;
      animation:fade 0.4s ease;
    }

    form.active{
      display:block;
    }

    @keyframes fade{
      from{opacity:0;transform:translateY(10px)}
      to{opacity:1;transform:translateY(0)}
    }

    .form-group{
      margin-bottom:18px;
    }

    .form-group label{
      display:block;
      font-size:14px;
      margin-bottom:6px;
    }

    .form-group input{
      width:100%;
      padding:12px 14px;
      border-radius:8px;
      border:1px solid #ddd;
      outline:none;
      transition:0.3s;
    }

    .form-group input:focus{
      border-color:#ac4024;
    }

    .submit-btn{
      width:100%;
      padding:14px;
      border:none;
      border-radius:8px;
      background:#ac4024;
      color:#fff;
      font-size:15px;
      cursor:pointer;
      transition:0.3s;
    }

    .submit-btn:hover{
      background:#1e63d6;
    }

    .extra{
      margin-top:15px;
      text-align:center;
      font-size:13px;
    }

    .extra a{
      color:#ac4024;
      text-decoration:none;
      font-weight:500;
    }

    @media(max-width:768px){
      .auth-wrapper{
        flex-direction:column;
      }
      .auth-image{
        text-align:center;
      }
    }
    </style>
    
    <script>
  function showForm(formId){
    document.querySelectorAll('form').forEach(f=>f.classList.remove('active'));
    document.getElementById(formId).classList.add('active');

    document.querySelectorAll('.tab-btn').forEach(btn=>btn.classList.remove('active'));
    if(formId === 'login'){
      document.querySelectorAll('.tab-btn')[0].classList.add('active');
    }else{
      document.querySelectorAll('.tab-btn')[1].classList.add('active');
    }
  }
</script>