<?php
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];

if(isset($_POST['add'])){

    $skill = trim($_POST['skill']);
    $type = $_POST['type'];

    // insert skill
    $stmt1 = $conn->prepare("INSERT INTO skills(skill_name) VALUES(?)");
    $stmt1->bind_param("s", $skill);
    $stmt1->execute();

    $sid = $conn->insert_id;

    // insert user skill
    $stmt2 = $conn->prepare("INSERT INTO user_skills(user_id,skill_id,type) VALUES(?,?,?)");
    $stmt2->bind_param("iis", $uid, $sid, $type);
    $stmt2->execute();

    $success = "Skill added successfully!";
}
?>

<!doctype html>
<html lang="en" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Skills - SwapSkill</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { height: 100%; width: 100%; }
    
    body {
      font-family: 'Geist Mono', system-ui, sans-serif;
      background: linear-gradient(135deg, #fdf8f3 0%, #f5e6d3 100%);
      color: #2d1810;
      overflow-x: hidden;
    }

    .app-wrapper {
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      position: relative;
      padding: 0;
    }

    .animated-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
      pointer-events: none;
      background: 
        radial-gradient(circle at 20% 30%, rgba(251, 146, 60, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 80% 70%, rgba(217, 119, 6, 0.08) 0%, transparent 40%);
    }

    /* NAVBAR */
    .navbar {
      position: relative;
      z-index: 40;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(217, 119, 6, 0.15);
      padding: 20px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 24px rgba(45, 24, 16, 0.06);
    }

    .logo {
      font-size: 22px;
      font-weight: 700;
      background: linear-gradient(135deg, #ea580c 0%, #d97706 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: 2px;
    }

    .menu {
      display: flex;
      gap: 32px;
      align-items: center;
    }

    .menu a {
      color: #92400e;
      text-decoration: none;
      font-size: 15px;
      font-weight: 600;
      transition: all 0.3s ease;
      position: relative;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .menu a::before {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, #ea580c, #d97706);
      transition: width 0.3s ease;
    }

    .menu a:hover {
      color: #ea580c;
    }

    .menu a:hover::before {
      width: 100%;
    }

    /* MAIN CONTENT */
    .container {
      position: relative;
      z-index: 10;
      padding: 40px 32px;
      max-width: 800px;
      width: 100%;
      margin: 0 auto;
      flex: 1;
      overflow-y: auto;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* SKILL CARD */
    .skill-card {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(254, 243, 230, 0.85) 100%);
      backdrop-filter: blur(10px);
      border: 2px solid rgba(217, 119, 6, 0.2);
      border-radius: 24px;
      padding: 48px 40px;
      width: 100%;
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
      overflow: hidden;
      animation: slideUp 0.6s ease-out;
      box-shadow: 0 12px 48px rgba(217, 119, 6, 0.08);
    }

    .skill-card::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(251, 146, 60, 0.15) 0%, transparent 70%);
      animation: float 6s ease-in-out infinite;
    }

    .skill-card::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, transparent 0%, rgba(217, 119, 6, 0.03) 100%);
      pointer-events: none;
    }

    .skill-card:hover {
      border-color: rgba(217, 119, 6, 0.4);
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(254, 240, 220, 0.9) 100%);
      box-shadow: 0 24px 64px rgba(217, 119, 6, 0.15);
      transform: translateY(-8px);
    }

    .skill-card h2 {
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 8px;
      color: #2d1810;
      letter-spacing: 1px;
      position: relative;
      z-index: 1;
    }

    .skill-card .subtitle {
      font-size: 13px;
      color: #92400e;
      font-weight: 600;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 32px;
      position: relative;
      z-index: 1;
      opacity: 0.8;
    }

    /* FORM */
    .form-group {
      margin-bottom: 24px;
      position: relative;
      z-index: 1;
    }

    .form-group label {
      display: block;
      font-size: 12px;
      font-weight: 700;
      color: #92400e;
      margin-bottom: 10px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 14px 16px;
      background: rgba(255, 255, 255, 0.6);
      border: 1px solid rgba(217, 119, 6, 0.25);
      border-radius: 10px;
      color: #2d1810;
      font-family: 'Geist Mono', system-ui, sans-serif;
      font-size: 13px;
      transition: all 0.3s ease;
      backdrop-filter: blur(8px);
    }

    .form-group input::placeholder {
      color: #b5733a;
    }

    .form-group input:focus,
    .form-group select:focus {
      outline: none;
      border-color: #ea580c;
      background: rgba(255, 255, 255, 0.85);
      box-shadow: 0 0 20px rgba(234, 88, 12, 0.15), inset 0 0 10px rgba(234, 88, 12, 0.08);
    }

    .form-group select {
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ea580c' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      padding-right: 40px;
    }

    .form-group select option {
      background: #fdf8f3;
      color: #2d1810;
    }

    /* SUBMIT BUTTON */
    .submit-btn {
      width: 100%;
      padding: 16px 24px;
      background: linear-gradient(135deg, #ea580c 0%, #d97706 100%);
      color: #ffffff;
      border: none;
      border-radius: 10px;
      font-weight: 700;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 1px;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
      z-index: 1;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(234, 88, 12, 0.2);
    }

    .submit-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.2);
      transition: left 0.4s ease;
    }

    .submit-btn:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 40px rgba(234, 88, 12, 0.35);
    }

    .submit-btn:hover::before {
      left: 100%;
    }

    .submit-btn:active {
      transform: translateY(-2px);
    }

    /* NOTIFICATION */
    .notification {
      position: fixed;
      bottom: 32px;
      right: 32px;
      z-index: 50;
        background: linear-gradient(135deg,#22c55e,#16a34a);
  color:white;
      padding: 16px 24px;
      border-radius: 12px;
      border: 1px solid rgba(217, 119, 6, 0.3);
      backdrop-filter: blur(10px);
      font-size: 13px;
      font-weight: 600;
      display: none;
      animation: slideUp 0.3s ease-out;
      box-shadow: 0 12px 32px rgba(217, 119, 6, 0.15);
    }

    /* ANIMATIONS */
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .navbar {
        padding: 16px 20px;
        flex-direction: column;
        gap: 16px;
      }

      .menu {
        gap: 16px;
        font-size: 12px;
      }

      .container {
        padding: 24px 16px;
      }

      .skill-card {
        padding: 32px 24px;
      }

      .skill-card h2 {
        font-size: 24px;
      }

      .skill-card .subtitle {
        margin-bottom: 24px;
      }
    }
  </style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body>
  <div class="animated-bg"></div>
  <div class="app-wrapper">
   <!-- NAVBAR -->
   <div class="navbar">
    <div class="logo">
     ⇄ SwapSkill
    </div>
    <div class="menu">
<a href="index.php">Home</a>
<a href="dashboard.php">Dashboard</a>
<a href="profile.php">Manage Skills</a>
<a href="logout.php">Logout</a>
</div>
   </div><!-- MAIN CONTENT -->
   <div class="container">
    <div class="skill-card">
     <h2 id="form-title">Add Your Skill</h2>
     <p class="subtitle">Share your expertise or find new skills to learn</p>
    <form method="POST">
      <div class="form-group">
       <label for="skill-input">Skill Name</label> <input type="text" id="skill-input" name="skill" placeholder="Ex: Guitar, Web Design, Python, Photography" required>
      </div>
      <div class="form-group">
       <label for="skill-type">Skill Type</label> <select id="skill-type" name="type" required> <option value="teach">🎓 I Can Teach This</option> <option value="learn">📚 I Want To Learn This</option> </select>
      </div><button type="submit" name="add" class="submit-btn" id="submit-btn">Add Skill</button>
     </form>
    </div>
   </div>
  </div><!-- NOTIFICATION -->
  <div class="notification" id="notification"></div>
<?php if(isset($success)){ ?>
<script>
window.onload = function(){
    showNotification("<?php echo $success; ?>");
};
</script>
<?php } ?>
  <script>
    function showNotification(msg) {
      const notif = document.getElementById('notification');
      notif.textContent = msg;
      notif.style.display = 'block';
      setTimeout(() => {
        notif.style.opacity = '0';
        notif.style.transition = 'opacity 0.3s ease';
        setTimeout(() => {
          notif.style.display = 'none';
          notif.style.opacity = '1';
        }, 300);
      }, 3000);
    }

   
    const defaultConfig = {
      form_title: 'Add Your Skill',
      submit_text: 'Add Skill'
    };

    window.elementSdk.init({
      defaultConfig,
      onConfigChange: async (config) => {
        const c = { ...defaultConfig, ...config };
        document.getElementById('form-title').textContent = c.form_title;
        document.getElementById('submit-btn').textContent = c.submit_text;
      },
      mapToCapabilities: (config) => ({
        recolorables: [],
        borderables: [],
        fontEditable: undefined,
        fontSizeable: undefined
      }),
      mapToEditPanelValues: (config) => {
        const c = { ...defaultConfig, ...config };
        return new Map([
          ['form_title', c.form_title],
          ['submit_text', c.submit_text]
        ]);
      }
    });

    lucide.createIcons();
  </script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9dfdca03c137850d',t:'MTc3NDEwNDgzOC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>