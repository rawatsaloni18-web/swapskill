<?php
session_start();
include 'dbconnect.php';

$uid = $_SESSION['user_id'];

// fetch user
$user = $conn->query("SELECT * FROM users WHERE id='$uid'")->fetch_assoc();

if(isset($_POST['save'])){

$name = $_POST['name'];
$education = $_POST['education'];
$skills = $_POST['skills'];

// upload
$imgName = $_FILES['profile_pic']['name'];
$tmp = $_FILES['profile_pic']['tmp_name'];

if($imgName){

    $imgName = time()."_".$imgName;

    if(!is_dir("uploads")){
        mkdir("uploads");
    }

    move_uploaded_file($tmp,"uploads/".$imgName);

    $conn->query("UPDATE users 
    SET name='$name', education='$education', skills='$skills', profile_pic='$imgName'
    WHERE id='$uid'");

}else{

    $conn->query("UPDATE users 
    SET name='$name', education='$education', skills='$skills'
    WHERE id='$uid'");
}

header("Location: user_profile.php");
exit();
}
?>

<!doctype html>
<html lang="en" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&amp;family=Playfair+Display:wght@600;700&amp;display=swap" rel="stylesheet">
  <style>
    html, body { height: 100%; margin: 0; }
    .app-root { height: 100%; overflow: auto; }
    body { font-family: 'DM Sans', sans-serif; }

    .floating-label { position: relative; margin-bottom: 1.25rem; }
    .floating-label label {
      position: absolute; top: -9px; left: 14px; font-size: 11px; font-weight: 500;
      padding: 0 6px; z-index: 1; letter-spacing: 0.5px; text-transform: uppercase;
      transition: color 0.3s;
    }
    .floating-label input,
    .floating-label textarea {
      width: 100%; border: 2px solid; border-radius: 12px; padding: 14px 16px;
      font-size: 15px; font-family: inherit; outline: none; transition: all 0.3s;
      box-sizing: border-box; resize: none;
    }
    .floating-label input:focus,
    .floating-label textarea:focus { box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }

    .avatar-ring {
      width: 100px; height: 100px; border-radius: 50%; padding: 3px;
      background: conic-gradient(from 0deg, #6366f1, #a855f7, #ec4899, #f59e0b, #6366f1);
      display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;
      cursor: pointer; position: relative; transition: transform 0.3s;
    }
    .avatar-ring:hover { transform: scale(1.05); }
    .avatar-inner {
      width: 100%; height: 100%; border-radius: 50%; display: flex;
      align-items: center; justify-content: center; overflow: hidden;
    }
    .avatar-overlay {
      position: absolute; inset: 3px; border-radius: 50%; display: flex;
      align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s;
      background: rgba(0,0,0,0.4);
    }
    .avatar-ring:hover .avatar-overlay { opacity: 1; }

    .save-btn {
      width: 100%; padding: 14px; border: none; border-radius: 12px;
      font-size: 16px; font-weight: 700; cursor: pointer; font-family: inherit;
      transition: all 0.3s; letter-spacing: 0.3px;
    }
    .save-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(99,102,241,0.35); }
    .save-btn:active { transform: translateY(0); }

    .skill-tag {
      display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px;
      border-radius: 20px; font-size: 12px; font-weight: 500; margin: 3px;
    }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp 0.5s ease forwards; }
    .fade-up-1 { animation-delay: 0.1s; opacity: 0; }
    .fade-up-2 { animation-delay: 0.2s; opacity: 0; }
    .fade-up-3 { animation-delay: 0.3s; opacity: 0; }
    .fade-up-4 { animation-delay: 0.4s; opacity: 0; }
    .fade-up-5 { animation-delay: 0.5s; opacity: 0; }

    .toast {
      position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%) translateY(80px);
      padding: 12px 24px; border-radius: 12px; font-weight: 500; font-size: 14px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.15); transition: transform 0.4s ease; z-index: 50;
    }
    .toast.show { transform: translateX(-50%) translateY(0); }

    .pattern-bg {
      position: absolute; inset: 0; opacity: 0.04;
      background-image: radial-gradient(circle, currentColor 1px, transparent 1px);
      background-size: 24px 24px; pointer-events: none;
    }
  </style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body>
  <div class="app-root flex flex-col lg:flex-row" id="appRoot" style="background:#0f0f1a;"><!-- Left panel -->
   <div class="relative flex-1 flex items-center justify-center p-8 lg:p-12" id="leftPanel" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
    <div class="pattern-bg" style="color: #6366f1;"></div>
    <div class="relative z-10 text-center max-w-md">
     <div class="mb-6 fade-up fade-up-1">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4"
style="background: linear-gradient(135deg,#6366f1,#a855f7);">
    <i data-lucide="user" style="width:28px;height:28px;color:white;"></i>
</div>
     </div>
     <h1 id="pageTitle" class="text-3xl lg:text-4xl font-bold mb-3 fade-up fade-up-2" style="font-family:'Playfair Display',serif; color:#f1f1f6;">Edit Your Profile</h1>
     <p id="subtitle" class="text-base fade-up fade-up-3" style="color:#8888a8;">Update your skills &amp; personality</p>
     <div class="mt-8 flex justify-center gap-3 fade-up fade-up-4">
      <div class="flex items-center gap-2 px-4 py-2 rounded-full text-xs font-medium"
  style="background:rgba(99,102,241,0.1); color:#818cf8;">
    <i data-lucide="users"></i> Skill Sharing
  </div>

  <div class="flex items-center gap-2 px-4 py-2 rounded-full text-xs font-medium"
  style="background:rgba(168,85,247,0.1); color:#c084fc;">
    <i data-lucide="star"></i> Grow Talent
  </div>
     </div>
    </div>
   </div><!-- Right panel -->
   <div class="flex-1 flex items-center justify-center p-6 lg:p-12" id="rightPanel">
    <div class="w-full max-w-sm fade-up fade-up-2"><!-- Avatar -->
     <div class="avatar-ring" onclick="document.getElementById('fileInput').click()">
      <div class="avatar-inner" id="avatarInner" style="background:#1e1e36;">
       <div id="avatarPlaceholder"><i data-lucide="user" style="width:40px; height:40px; color:#555;"></i>
       </div><img id="avatarPreview" src="" alt="" style="display:none; width:100%; height:100%; object-fit:cover;">
      </div>
      <div class="avatar-overlay"><i data-lucide="camera" style="width:20px; height:20px; color:white;"></i>
      </div>
     </div> <!-- Form -->
     <form method="POST" enctype="multipart/form-data">
<input type="file" id="fileInput" name="profile_pic" accept="image/*" style="display:none">
      <div class="floating-label fade-up fade-up-2"><label id="nameLabel" style="background:#0f0f1a; color:#818cf8;">Name</label><input type="text" name="name"
value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>"
placeholder="Your full name"
style="background:transparent; color:#e2e2f0; border-color:#2a2a45;">      </div>
      <div class="floating-label fade-up fade-up-3"><label id="bioLabel" style="background:#0f0f1a; color:#818cf8;">Bio</label> <textarea name="education"
style="background:transparent; color:#e2e2f0; border-color:#2a2a45;"><?php echo htmlspecialchars($user['education'] ?? ''); ?></textarea>
      </div>
      <div class="floating-label fade-up fade-up-4"><label id="skillsLabel" style="background:#0f0f1a; color:#818cf8;">Skills</label> <input type="text" name="skills"
value="<?php echo htmlspecialchars($user['skills'] ?? ''); ?>" placeholder="e.g. painting:80, singing:60" style="background:transparent; color:#e2e2f0; border-color:#2a2a45;">
      </div><!-- Skill tags preview -->
      <div id="skillTags" class="mb-5 flex flex-wrap fade-up fade-up-4"></div><button type="submit" name="save" class="save-btn fade-up fade-up-5" id="saveBtn" style="background:#6366f1; color:white;"> Save Changes </button>
     </form>
    </div>
   </div><!-- Toast -->
   <div class="toast" id="toast" style="background:#1e1e36; color:#a5b4fc;"><span class="flex items-center gap-2"><i data-lucide="check-circle" style="width:18px; height:18px; color:#34d399;"></i> Profile saved!</span>
   </div>
  </div>
  <script>
  const defaultConfig = {
    background_color: '#0f0f1a',
    surface_color: '#1e1e36',
    text_color: '#e2e2f0',
    primary_action_color: '#6366f1',
    secondary_action_color: '#818cf8',
    font_family: 'DM Sans',
    font_size: 15,
    page_title: 'Edit Your Profile',
    subtitle_text: 'Update your skills & personality'
  };

  function applyConfig(c) {
    const bg = c.background_color || defaultConfig.background_color;
    const surface = c.surface_color || defaultConfig.surface_color;
    const text = c.text_color || defaultConfig.text_color;
    const primary = c.primary_action_color || defaultConfig.primary_action_color;
    const secondary = c.secondary_action_color || defaultConfig.secondary_action_color;
    const font = c.font_family || defaultConfig.font_family;
    const size = c.font_size || defaultConfig.font_size;

    const root = document.getElementById('appRoot');
    root.style.background = bg;

    document.getElementById('leftPanel').style.background = `linear-gradient(135deg, ${bg} 0%, ${surface} 100%)`;
    document.getElementById('avatarInner').style.background = surface;
    document.getElementById('toast').style.background = surface;
    document.getElementById('toast').style.color = secondary;
    document.getElementById('iconBox').style.background = primary + '22';

    const title = document.getElementById('pageTitle');
    title.textContent = c.page_title || defaultConfig.page_title;
    title.style.color = text;
    title.style.fontFamily = `'Playfair Display', ${font}, serif`;
    title.style.fontSize = `${size * 2.2}px`;

    const sub = document.getElementById('subtitle');
    sub.textContent = c.subtitle_text || defaultConfig.subtitle_text;
    sub.style.color = secondary;
    sub.style.fontFamily = `${font}, sans-serif`;
    sub.style.fontSize = `${size}px`;

    document.getElementById('saveBtn').style.background = primary;

    document.querySelectorAll('.floating-label label').forEach(l => {
      l.style.background = bg;
      l.style.color = secondary;
    });
    document.querySelectorAll('.floating-label input, .floating-label textarea').forEach(el => {
      el.style.color = text;
      el.style.borderColor = surface;
      el.style.fontSize = `${size}px`;
      el.style.fontFamily = `${font}, sans-serif`;
    });

    document.querySelectorAll('.skill-tag').forEach(tag => {
      tag.style.background = primary + '1a';
      tag.style.color = secondary;
    });
  }

  function mkMutable(key) {
    return {
      get: () => (window.elementSdk?.config?.[key] ?? defaultConfig[key]),
      set: (v) => { window.elementSdk.config[key] = v; window.elementSdk.setConfig({ [key]: v }); }
    };
  }

  window.elementSdk?.init({
    defaultConfig,
    onConfigChange: async (c) => applyConfig(c),
    mapToCapabilities: (c) => ({
      recolorables: [
        mkMutable('background_color'),
        mkMutable('surface_color'),
        mkMutable('text_color'),
        mkMutable('primary_action_color'),
        mkMutable('secondary_action_color')
      ],
      borderables: [],
      fontEditable: mkMutable('font_family'),
      fontSizeable: mkMutable('font_size')
    }),
    mapToEditPanelValues: (c) => new Map([
      ['page_title', c.page_title || defaultConfig.page_title],
      ['subtitle_text', c.subtitle_text || defaultConfig.subtitle_text]
    ])
  });

  // File preview
  document.getElementById('fileInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (ev) => {
      const img = document.getElementById('avatarPreview');
      img.src = ev.target.result;
      img.style.display = 'block';
      document.getElementById('avatarPlaceholder').style.display = 'none';
    };
    reader.readAsDataURL(file);
  });

  // Skill tags
  document.getElementById('skillsInput').addEventListener('input', function() {
    const container = document.getElementById('skillTags');
    container.innerHTML = '';
    const parts = this.value.split(',').map(s => s.trim()).filter(Boolean);
    const cfg = window.elementSdk?.config || defaultConfig;
    const primary = cfg.primary_action_color || defaultConfig.primary_action_color;
    const secondary = cfg.secondary_action_color || defaultConfig.secondary_action_color;
    parts.forEach(p => {
      const [name, val] = p.split(':').map(s => s.trim());
      if (!name) return;
      const tag = document.createElement('span');
      tag.className = 'skill-tag';
      tag.style.background = primary + '1a';
      tag.style.color = secondary;
      tag.textContent = val ? `${name} · ${val}%` : name;
      container.appendChild(tag);
    });
  });

  // Save
 
  
  lucide.createIcons();
</script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9e3f8853c0e64932',t:'MTc3NDc5NDIwNy4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>