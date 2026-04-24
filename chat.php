<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'dbconnect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$me = $_SESSION['user_id'];
$other = isset($_GET['user']) ? intval($_GET['user']) : 0;

/* SEND */
if(isset($_POST['send']) && $other > 0){
    $msg = $conn->real_escape_string($_POST['msg']);
    $conn->query("INSERT INTO messages(sender_id,receiver_id,message)
    VALUES('$me','$other','$msg')");
}

/* USERS */
$users = $conn->query("
SELECT id, name FROM users
WHERE id IN (
    SELECT sender_id FROM requests WHERE receiver_id='$me' AND status='accepted'
    UNION
    SELECT receiver_id FROM requests WHERE sender_id='$me' AND status='accepted'
)
AND id != '$me'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Chat</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>

<style>
body{
    background:#0a0a0f;
    color:white;
    font-family:'DM Sans', sans-serif;
}

/* LEFT */
.users{
    width:280px;
    background:#0e0e16;
    padding:15px;
    height:100vh;
    overflow:auto;
    border-right:1px solid rgba(255,255,255,0.05);
    position:relative;
}

.users a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px;
    border-radius:10px;
    background:#14141e;
    margin-bottom:8px;
    text-decoration:none;
    color:white;
    transition:0.3s;
}

.users a:hover{
    background:#1f1f2e;
    transform:translateX(4px);
}

/* RIGHT */
.chat{
    flex:1;
    display:flex;
    flex-direction:column;
    height:100vh;
}

.chat-title{
    font-family: 'Outfit', sans-serif;
    font-size: 20px;
    font-weight: 600;
    color: #a78bfa; /* soft purple */
    letter-spacing: 0.5px;
}

/* HEADER */
.chat-header{
    padding:15px;
    background:#0e0e16;
    border-bottom:1px solid rgba(255,255,255,0.05);
}

/* MESSAGES */
.messages{
    flex:1;
    overflow:auto;
    padding:20px;
}

/* MESSAGE BASE */
.msg{
    max-width:70%;
    padding:12px 16px;
    border-radius:18px;
    margin-bottom:10px;
    font-family:'Outfit', sans-serif;
    font-size:14px;
    line-height:1.4;
    letter-spacing:0.3px;
}

/* MY MESSAGE */
.me{
    background: linear-gradient(135deg,#e94560,#ff6b81);
    color:white;
    margin-left:auto;
    border-bottom-right-radius:4px;
}

/* OTHER USER MESSAGE */
.other{
    background:#1f1f2e;
    color:#e2e8f0;
    border-bottom-left-radius:4px;
}

/* INPUT */
.chat-input{
    display:flex;
    gap:10px;
    padding:15px;
    background:#0e0e16;
    border-top:1px solid rgba(255,255,255,0.05);
}

.chat-input input{
    flex:1;
    padding:12px;
    border-radius:10px;
    background:#14141e;
    border:1px solid rgba(255,255,255,0.1);
    color:white;
}

.chat-input button{
    background:#e94560;
    padding:10px 15px;
    border-radius:10px;
}

/* BOTTOM NAV */
.nav-bottom{
    position:absolute;
    bottom:20px;
    left:15px;
    width:250px;
}

/* BUTTON STYLE */
.nav-btn{
    display:flex;
    align-items:center;
    gap:8px;
    padding:10px;
    margin-top:8px;
    border-radius:10px;
    background:#14141e;
    color:white;
    text-decoration:none;
    transition:0.3s;
}

.nav-btn:hover{
    background:#1f1f2e;
    transform:translateX(5px);
}

/* BACK BUTTON COLOR */
.nav-btn.back{
    background:#e94560;
}
.nav-btn.back:hover{
    background:#c2185b;
}


.schedule-btn{
    display:inline-block;
    margin:10px;
    padding:10px 15px;
    border-radius:10px;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    color:white;
    text-decoration:none;
    font-size:14px;
    transition:0.3s;
}
.schedule-btn:hover{
    transform:scale(1.05);
}


</style>
</head>

<body class="flex">

<!-- LEFT USERS -->
<div class="users">
<h3 class="chat-title">💬 Conversations</h3>

<div class="nav-bottom">
    <a href="index.php" class="nav-btn">
        <i data-lucide="home"></i> Home
    </a>

    <a href="javascript:history.back()" class="nav-btn back">
        <i data-lucide="arrow-left"></i> Back
    </a>
</div>

<?php 
if($users && $users->num_rows > 0){
while($u = $users->fetch_assoc()){ ?>
<a href="chat.php?user=<?php echo $u['id']; ?>">
<?php echo $u['name']; ?>
</a>
<?php }} else { echo "No chats"; } ?>
</div>

<!-- RIGHT CHAT -->
<div class="chat">

<div class="chat-header">
<h3>Chat</h3>
</div>

<div class="messages">

<?php if($other > 0){

$result = $conn->query("
SELECT * FROM messages 
WHERE (sender_id='$me' AND receiver_id='$other')
OR (sender_id='$other' AND receiver_id='$me')
ORDER BY id ASC
");

if($result && $result->num_rows > 0){
while($row = $result->fetch_assoc()){
if($row['sender_id'] == $me){
echo "<div class='msg me'>".$row['message']."</div>";
}else{
echo "<div class='msg other'>".$row['message']."</div>";
}
}
}else{
echo "No messages yet";
}

}else{
echo "
<div class='flex flex-col items-center justify-center h-full text-center text-gray-400'>

    <div class='mb-4 text-5xl'>💬</div>

    <h2 class='text-xl font-semibold text-white mb-2'>
        Start a Conversation
    </h2>

    <p class='text-sm max-w-xs'>
        Select a user from the left panel and begin your learning journey together 🚀
    </p>

    <div class='mt-6 px-4 py-2 rounded-full text-xs bg-[#1f1f2e] text-gray-300'>
        Learn • Share • Grow
    </div>

</div>
";}
?>

</div>

<?php if($other > 0){ ?>
<form method="POST" class="chat-input">

<a href="schedule_session.php?user=<?php echo $other; ?>" 
class="schedule-btn">
📅 Schedule Session
</a>

<input type="text" name="msg" placeholder="Type a message..." required>
<button name="send">
<i data-lucide="send"></i>
</button>
</form>
<?php } ?>

</div>

<script>
lucide.createIcons();
</script>

</body>
</html>