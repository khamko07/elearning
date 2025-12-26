<?php 
require_once("include/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome - eLearning Portal</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Custom CSS -->
  <link href="<?php echo web_root; ?>css/main.css" rel="stylesheet">
  
  <style>
    .landing-page {
      min-height: 100vh;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%),
                  url('<?php echo web_root; ?>assets/ued.jpg') no-repeat center center fixed;
      background-size: cover;
      background-blend-mode: overlay;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: var(--space-6);
      position: relative;
      overflow: hidden;
    }
    
    .landing-page::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.2);
      z-index: 1;
    }
    
    .landing-card {
      position: relative;
      z-index: 2;
      background: rgba(255, 255, 255, 0.98);
      border-radius: var(--radius-2xl);
      padding: var(--space-10);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      max-width: 600px;
      width: 100%;
      backdrop-filter: blur(10px);
      animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .landing-logo {
      max-width: 100%;
      height: auto;
      margin-bottom: var(--space-6);
      display: block;
      margin-left: auto;
      margin-right: auto;
      filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
    }
    
    .landing-title {
      font-size: var(--text-3xl);
      font-weight: var(--font-bold);
      color: var(--text-primary);
      margin-bottom: var(--space-2);
      text-align: center;
      background: linear-gradient(135deg, var(--secondary-indigo) 0%, var(--secondary-purple) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .landing-subtitle {
      font-size: var(--text-lg);
      color: var(--text-muted);
      text-align: center;
      margin-bottom: var(--space-8);
      line-height: var(--leading-relaxed);
    }
    
    .landing-buttons {
      display: grid;
      grid-template-columns: 1fr;
      gap: var(--space-4);
      margin-top: var(--space-6);
    }
    
    @media (min-width: 576px) {
      .landing-buttons {
        grid-template-columns: repeat(3, 1fr);
      }
    }
    
    .landing-btn {
      padding: var(--space-4) var(--space-6);
      font-size: var(--text-base);
      font-weight: var(--font-semibold);
      border-radius: var(--radius-lg);
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--space-2);
      transition: all var(--transition-base);
      border: 2px solid transparent;
      position: relative;
      overflow: hidden;
    }
    
    .landing-btn::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }
    
    .landing-btn:hover::before {
      width: 300px;
      height: 300px;
    }
    
    .landing-btn:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-xl);
      text-decoration: none;
    }
    
    .landing-btn:active {
      transform: translateY(-1px);
    }
    
    .landing-btn-primary {
      background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-light) 100%);
      color: var(--text-white);
      border-color: var(--primary-blue);
    }
    
    .landing-btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-blue-dark) 0%, var(--primary-blue) 100%);
      color: var(--text-white);
    }
    
    .landing-btn-secondary {
      background: var(--gray-700);
      color: var(--text-white);
      border-color: var(--gray-700);
    }
    
    .landing-btn-secondary:hover {
      background: var(--gray-800);
      color: var(--text-white);
    }
    
    .landing-btn-success {
      background: linear-gradient(135deg, var(--success) 0%, #34ce57 100%);
      color: var(--text-white);
      border-color: var(--success);
    }
    
    .landing-btn-success:hover {
      background: linear-gradient(135deg, #218838 0%, var(--success) 100%);
      color: var(--text-white);
    }
    
    .landing-btn i {
      position: relative;
      z-index: 1;
    }
    
    .landing-btn span {
      position: relative;
      z-index: 1;
    }
    
    @media (max-width: 575px) {
      .landing-card {
        padding: var(--space-6);
      }
      
      .landing-title {
        font-size: var(--text-2xl);
      }
      
      .landing-subtitle {
        font-size: var(--text-base);
      }
    }
  </style>
</head>
<body>
  <div class="landing-page">
    <div class="landing-card">
      <img src="<?php echo web_root; ?>images/text-ued-1.png" alt="University Logo" class="landing-logo">
      
      <h1 class="landing-title">
        <i class="fas fa-graduation-cap me-2"></i>
        Welcome to eLearning Portal
      </h1>
      
      <p class="landing-subtitle">
        Your gateway to online learning and knowledge. Start your educational journey today.
      </p>
      
      <div class="landing-buttons">
        <a href="login.php" class="landing-btn landing-btn-primary">
          <i class="fas fa-user-graduate"></i>
          <span>Student Login</span>
        </a>
        
        <a href="admin/login.php" class="landing-btn landing-btn-secondary">
          <i class="fas fa-user-shield"></i>
          <span>Admin Login</span>
        </a>
        
        <a href="register.php" class="landing-btn landing-btn-success">
          <i class="fas fa-user-plus"></i>
          <span>Register</span>
        </a>
      </div>
    </div>
  </div>
  
  <!-- Scripts -->
  <script src="<?php echo web_root; ?>js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
