<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signup.php");
    exit;
}

require_once 'php/db.php';
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, bio, avatar_url FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user['avatar_url']) {
    $user['avatar_url'] = 'https://i.pravatar.cc/150?u=' . md5($user['username']);
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Profile - LUNARA</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#7f13ec",
            "background-dark": "#120b18",
          },
          fontFamily: {
            "display": ["Plus Jakarta Sans", "sans-serif"]
          }
        },
      },
    }
  </script>
</head>
<body class="bg-background-dark font-display text-white min-h-screen p-4 flex flex-col items-center">
  
  <header class="w-full max-w-md flex items-center justify-between py-4 mb-4 border-b border-white/10">
    <a href="profile.php?user_id=<?= $user_id ?>" class="text-zinc-400 hover:text-white"><span class="material-symbols-outlined text-3xl">arrow_back</span></a>
    <h1 class="text-xl font-bold">Edit Profile</h1>
    <div class="w-8"></div>
  </header>

  <div class="w-full max-w-md bg-white/5 p-6 rounded-2xl border border-white/10">
    <div id="msgBox" class="hidden mb-4 p-3 rounded-lg text-sm text-center"></div>

    <form id="editProfileForm" class="flex flex-col gap-6">
      
      <div class="flex flex-col items-center gap-3">
        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-primary relative group cursor-pointer">
          <img id="avatarPreview" src="<?= htmlspecialchars($user['avatar_url']) ?>" class="w-full h-full object-cover">
          <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
             <span class="material-symbols-outlined text-white">photo_camera</span>
          </div>
          <input type="file" name="avatar" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this)">
        </div>
        <p class="text-sm text-zinc-400">Change Profile Photo</p>
      </div>

      <div>
        <label class="block text-sm font-bold mb-1 text-zinc-300">Bio</label>
        <textarea name="bio" rows="4" placeholder="Write something about yourself..." class="w-full bg-black/30 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors resize-none"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
      </div>

      <button type="submit" class="w-full bg-primary hover:bg-purple-600 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-lg shadow-primary/30 mt-2">
        Save Changes
      </button>
    </form>
  </div>

  <script>
    function previewImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    const form = document.getElementById('editProfileForm');
    const msgBox = document.getElementById('msgBox');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = form.querySelector('button');
        btn.innerText = 'Saving...';
        btn.disabled = true;

        const formData = new FormData(form);
        try {
            const res = await fetch('php/update_profile.php', { method: 'POST', body: formData });
            const data = await res.json();
            
            msgBox.textContent = data.message;
            msgBox.className = `mb-4 p-3 rounded-lg text-sm text-center ${data.success ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30'}`;
            msgBox.classList.remove('hidden');

            if (data.success) {
                setTimeout(() => {
                   window.location.href = 'profile.php?user_id=<?= $user_id ?>';
                }, 1000);
            }
        } catch(err) { 
            msgBox.textContent = 'Connection error.';
            msgBox.className = 'mb-4 p-3 rounded-lg text-sm text-center bg-red-500/20 text-red-400 border border-red-500/30';
            msgBox.classList.remove('hidden');
        } finally {
            btn.innerText = 'Save Changes';
            btn.disabled = false;
        }
    });
  </script>
</body>
</html>
