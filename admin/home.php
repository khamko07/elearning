<style type="text/css">
  .admin-dashboard {
    padding: 20px 0;
  }
  
  .dashboard-header {
    margin-bottom: 40px;
  }
  
  .dashboard-header h3 {
    color: #2c3e50;
    font-size: 28px;
    font-weight: 600;
  }
  
  .dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 30px;
  }
  
  .dashboard-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0,0,0,0.07);
    border: 2px solid transparent;
    text-decoration: none;
    display: block;
  }
  
  .dashboard-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    border-color: #667eea;
    text-decoration: none;
  }
  
  .dashboard-card-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }
  
  .dashboard-card-icon img {
    width: 60px;
    height: 60px;
    object-fit: contain;
    filter: brightness(0) invert(1);
  }
  
  .dashboard-card-label {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    margin-top: 15px;
  }
  
  .dashboard-card:hover .dashboard-card-label {
    color: #667eea;
  }
  
  @media (max-width: 768px) {
    .dashboard-grid {
      grid-template-columns: 1fr;
      gap: 20px;
    }
  }
</style>

<div class="container admin-dashboard">
  <div class="dashboard-header">
    <h3>Administrator Panel: Welcome <?php echo $_SESSION['NAME'];?></h3>
  </div>
 
  <div class="dashboard-grid">
    <!-- Content Management -->
    <a href="<?php echo web_root; ?>admin/modules/content/index.php" class="dashboard-card" title="Learning Content">
      <div class="dashboard-card-icon">
        <img src="<?php echo web_root; ?>admin/adminMenu/images/lesson1.gif" alt="Content"> 
      </div>
      <div class="dashboard-card-label">Learning Content</div>
    </a>
    
    <!-- Exercises -->
    <a href="<?php echo web_root; ?>admin/modules/exercises/index.php" class="dashboard-card" title="Exercises">
      <div class="dashboard-card-icon">
        <img src="<?php echo web_root; ?>admin/adminMenu/images/exercises.jpg" alt="Exercises"> 
      </div>
      <div class="dashboard-card-label">Exercises</div>
    </a>
    
    <!-- Manage Users (Admin only) -->
    <?php if($_SESSION['TYPE']=="Administrator"){ ?>
    <a href="<?php echo web_root; ?>admin/modules/user/index.php" class="dashboard-card" title="Manage Users">
      <div class="dashboard-card-icon">
        <img src="<?php echo web_root; ?>admin/adminMenu/images/user.png" alt="Users"> 
      </div>
      <div class="dashboard-card-label">Manage Users</div>
    </a>
    <?php } ?>
    
    <!-- Students Management -->
    <a href="<?php echo web_root; ?>admin/modules/modstudent/index.php" class="dashboard-card" title="Manage Students">
      <div class="dashboard-card-icon">
        <img src="<?php echo web_root; ?>admin/adminMenu/images/user.png" alt="Students"> 
      </div>
      <div class="dashboard-card-label">Manage Students</div>
    </a>
  </div>
  
</div>