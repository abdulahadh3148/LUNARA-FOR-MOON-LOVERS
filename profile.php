<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

if (!isset($_GET['user_id']) && !$isLoggedIn) {
    header("Location: signup.php");
    exit;
}
$user_id = $_GET['user_id'] ?? $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LUNARA - Profile</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#7f13ec",
            "background-light": "#f7f6f8",
            "background-dark": "#191022",
          },
          fontFamily: {
            "display": ["Plus Jakarta Sans", "sans-serif"]
          },
        },
      },
    }
  </script>
  <style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .icon-filled { font-variation-settings: 'FILL' 1 !important; }
    body { min-height: max(884px, 100dvh); }
  </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-zinc-900 dark:text-zinc-100">
<div class="relative flex min-h-screen w-full flex-col md:flex-row mx-auto max-w-5xl md:px-4 lg:px-8">

  <!-- Mobile Top Nav -->
  <header class="md:hidden flex items-center bg-white/80 dark:bg-[#120b18]/80 backdrop-blur-md p-4 pb-3 justify-between sticky top-0 z-50 border-b border-zinc-200/50 dark:border-white/10">
    <a href="index.php"><span class="material-symbols-outlined text-[28px]">arrow_back</span></a>
    <h1 class="text-xl font-extrabold tracking-tight text-primary">PROFILE</h1>
    <div class="w-[28px]"></div>
  </header>

  <!-- Sidebar Nav -->
  <nav class="fixed bottom-0 left-0 w-full bg-white dark:bg-[#120b18] border-t border-zinc-200/50 dark:border-white/10 z-50 pb-safe
              md:relative md:w-20 lg:w-64 md:border-t-0 md:border-r md:h-screen md:bg-transparent md:dark:bg-transparent md:pt-8 md:pb-8 md:px-2 lg:px-4 flex md:flex-col md:justify-start">
    <div class="hidden md:flex mb-8 items-center justify-center lg:justify-start px-2">
       <h1 class="hidden lg:block text-2xl font-extrabold tracking-tight text-primary">LUNARA</h1>
       <span class="lg:hidden material-symbols-outlined text-primary text-4xl icon-filled">nightlight</span>
    </div>
    <div class="flex justify-around items-center h-14 md:h-auto md:flex-col md:gap-2 md:items-start w-full">
      <a href="index.php" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">home</span>
        <span class="hidden lg:block text-lg">Home</span>
      </a>

      <a href="search.php" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">search</span>
        <span class="hidden lg:block text-lg">Search</span>
      </a>
      
      <?php if ($isLoggedIn): ?>
      <a href="profile.php?user_id=<?= $_SESSION['user_id'] ?>" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-900 dark:text-white font-bold group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform icon-filled">person</span>
        <span class="hidden lg:block text-lg">Profile</span>
      </a>
      <!-- Add Post -->
      <a href="index.php" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white group">
        <div class="md:hidden bg-primary text-white p-2 rounded-xl shadow-lg shadow-primary/30"><span class="material-symbols-outlined text-2xl font-bold">add</span></div>
        <span class="hidden md:block material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">add_box</span>
        <span class="hidden lg:block text-lg">Create</span>
      </a>
      <a href="php/logout.php" class="hidden md:flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white md:mt-auto group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">logout</span>
        <span class="hidden lg:block text-lg">Logout</span>
      </a>
      <?php else: ?>
      <a href="signup.php" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white md:mt-auto group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">login</span>
        <span class="hidden lg:block text-lg">Log In / Sign Up</span>
      </a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Profile Content -->
  <main class="w-full grow pb-20 md:pb-0 flex justify-center">
    <div class="w-full max-w-2xl md:mt-8 md:mb-8 bg-transparent">
      
      <!-- Profile Header -->
      <div id="profile-header" class="p-6 md:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6 border-b border-zinc-200/50 dark:border-white/10">
         <!-- Will be populated by JS -->
         <div class="text-center w-full"><span class="material-symbols-outlined text-4xl animate-spin text-zinc-500">sync</span></div>
      </div>

      <!-- Post Grid -->
      <div id="post-grid" class="grid grid-cols-3 gap-1 md:gap-4 p-1 md:p-0 md:mt-8">
         <!-- Will be populated by JS -->
      </div>

    </div>
  </main>
</div>

<script>
  const targetUserId = <?= json_encode($user_id) ?>;
  const currentSessionUserId = <?= json_encode($_SESSION['user_id'] ?? null) ?>;
  
  async function loadProfile() {
    try {
      const res = await fetch(`php/get_user_profile.php?user_id=${targetUserId}`);
      const data = await res.json();
      
      if (data.success) {
        let actionButton = '';
        if (currentSessionUserId) {
            if (currentSessionUserId == targetUserId) {
                actionButton = `<a href="edit_profile.php" class="px-4 py-1.5 bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg text-sm font-bold transition-colors">Edit Profile</a>`;
            } else {
                const followText = data.user.is_following > 0 ? 'Unfollow' : 'Follow';
                const btnClass = data.user.is_following > 0 ? 'bg-white/10 hover:bg-white/20 text-white' : 'bg-primary hover:bg-purple-600 text-white';
                actionButton = `<button onclick="toggleFollow(${targetUserId})" class="px-6 py-1.5 rounded-lg text-sm font-bold transition-colors ${btnClass}">${followText}</button>`;
            }
        }

        // Render Header
        document.getElementById('profile-header').innerHTML = `
          <div class="w-24 h-24 md:w-32 md:h-32 shrink-0 rounded-full bg-gradient-to-tr from-primary to-pink-500 p-[2px]">
             <div class="w-full h-full rounded-full bg-white dark:bg-[#120b18] overflow-hidden">
                <img src="${data.user.avatar_url}" class="w-full h-full object-cover">
             </div>
          </div>
          <div class="flex flex-col gap-3 items-center sm:items-start w-full">
             <div class="flex items-center gap-4 flex-wrap justify-center sm:justify-start">
                <h2 class="text-2xl font-bold">${data.user.username}</h2>
                ${actionButton}
             </div>
             <div class="flex gap-6 text-sm">
                <span><span class="font-bold">${data.posts.length}</span> posts</span>
                <span><span class="font-bold">${data.user.followers || 0}</span> followers</span>
                <span><span class="font-bold">${data.user.following || 0}</span> following</span>
             </div>
             <p class="text-sm text-zinc-800 dark:text-zinc-300 mt-2 max-w-md text-center sm:text-left">${data.user.bio ? data.user.bio.replace(/</g, "&lt;").replace(/>/g, "&gt;") : 'Just a moon lover exploring the cosmos. ✨'}</p>
          </div>
        `;

        // Render Grid
        const grid = document.getElementById('post-grid');
        grid.innerHTML = '';
        if (data.posts.length === 0) {
           grid.innerHTML = '<div class="col-span-3 p-12 text-center text-zinc-500 border border-dashed border-zinc-300 dark:border-zinc-700 rounded-xl m-4">No posts yet.</div>';
        } else {
           data.posts.forEach(post => {
              let mediaInner = '';
              if (post.type === 'photo' && post.media_url) {
                 mediaInner = `<img src="${post.media_url}" class="w-full h-full object-cover">`;
              } else {
                 mediaInner = `
                    <div class="w-full h-full bg-gradient-to-br from-primary to-indigo-900 flex items-center justify-center p-2 text-center">
                       <span class="text-white font-bold text-xs md:text-sm line-clamp-3">"${post.content}"</span>
                    </div>
                 `;
              }
              
              grid.innerHTML += `
                 <div class="aspect-square bg-zinc-200 dark:bg-zinc-800 relative group cursor-pointer overflow-hidden md:rounded-lg">
                    ${mediaInner}
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4 text-white font-bold">
                       <div class="flex items-center gap-1"><span class="material-symbols-outlined icon-filled">favorite</span> ${post.like_count}</div>
                       <div class="flex items-center gap-1"><span class="material-symbols-outlined icon-filled">mode_comment</span> ${post.comment_count}</div>
                    </div>
                 </div>
              `;
           });
        }
      } else {
        document.getElementById('profile-header').innerHTML = `<div class="text-red-500 p-8">${data.message}</div>`;
      }
    } catch(err) {
      document.getElementById('profile-header').innerHTML = `<div class="text-red-500 p-8">Failed to load profile.</div>`;
    }
  }

  async function toggleFollow(followingId) {
    try {
        const formData = new FormData();
        formData.append('following_id', followingId);
        
        const res = await fetch('php/toggle_follow.php', { method: 'POST', body: formData });
        const data = await res.json();
        
        if (data.success) {
            loadProfile(); // Reload the profile to update counts and button text
        } else {
            if (data.message === 'Unauthorized') {
                window.location.href = 'signup.php';
            } else {
                alert(data.message);
            }
        }
    } catch(err) {
        alert('Connection error');
    }
  }

  loadProfile();
</script>
</body>
</html>
