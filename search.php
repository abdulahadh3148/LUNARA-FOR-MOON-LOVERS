<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LUNARA - Search</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
    body { min-height: max(884px, 100dvh); }
  </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-zinc-900 dark:text-zinc-100">
<div class="relative flex min-h-screen w-full flex-col md:flex-row mx-auto max-w-5xl md:px-4 lg:px-8">

  <!-- Sidebar Nav -->
  <nav class="fixed bottom-0 left-0 w-full bg-white dark:bg-[#120b18] border-t border-zinc-200/50 dark:border-white/10 z-50 pb-safe
              md:relative md:w-20 lg:w-64 md:border-t-0 md:border-r md:h-screen md:bg-transparent md:dark:bg-transparent md:pt-8 md:pb-8 md:px-2 lg:px-4 flex md:flex-col md:justify-start">
    <div class="hidden md:flex mb-8 items-center justify-center lg:justify-start px-2">
       <h1 class="hidden lg:block text-2xl font-extrabold tracking-tight text-primary">LUNARA</h1>
       <span class="lg:hidden material-symbols-outlined text-primary text-4xl" style="font-variation-settings: 'FILL' 1;">nightlight</span>
    </div>
    <div class="flex justify-around items-center h-14 md:h-auto md:flex-col md:gap-2 md:items-start w-full">
      <a href="index.php" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">home</span>
        <span class="hidden lg:block text-lg">Home</span>
      </a>
      
      <a href="search.php" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-900 dark:text-white font-bold group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform text-primary font-bold">search</span>
        <span class="hidden lg:block text-lg">Search</span>
      </a>
      
      <?php if ($isLoggedIn): ?>
      <a href="profile.php" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">person</span>
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

  <!-- Search Content -->
  <main class="w-full grow pb-20 md:pb-0 flex flex-col items-center">
    <div class="w-full max-w-xl md:mt-8 md:mb-8 bg-transparent">
      
      <!-- Search Bar -->
      <div class="p-4 md:p-6 sticky top-0 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md z-40 border-b border-zinc-200/50 dark:border-white/10">
         <div class="relative w-full">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-400">
               <span class="material-symbols-outlined">search</span>
            </span>
            <input type="text" id="searchInput" placeholder="Search for moon lovers..." class="w-full bg-white dark:bg-[#120b18] border border-zinc-300 dark:border-white/20 rounded-full pl-12 pr-4 py-3 text-zinc-900 dark:text-white placeholder-zinc-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors shadow-sm">
         </div>
      </div>

      <!-- Search Results -->
      <div id="searchResults" class="p-4 flex flex-col gap-4">
         <div class="p-12 text-center text-zinc-500">Type a username to start searching.</div>
      </div>

    </div>
  </main>
</div>

<script>
  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');
  const isLoggedIn = <?= json_encode($isLoggedIn) ?>;

  let debounceTimer;

  searchInput.addEventListener('input', () => {
      clearTimeout(debounceTimer);
      const query = searchInput.value.trim();
      
      if (query.length === 0) {
          searchResults.innerHTML = '<div class="p-12 text-center text-zinc-500">Type a username to start searching.</div>';
          return;
      }
      
      searchResults.innerHTML = '<div class="p-12 text-center"><span class="material-symbols-outlined animate-spin text-zinc-500 text-3xl">sync</span></div>';
      
      debounceTimer = setTimeout(() => {
          performSearch(query);
      }, 300); // 300ms debounce
  });

  async function performSearch(query) {
      try {
          const res = await fetch(`php/search_users.php?q=${encodeURIComponent(query)}`);
          const data = await res.json();
          
          if (data.success) {
              if (data.users.length === 0) {
                  searchResults.innerHTML = '<div class="p-12 text-center text-zinc-500">No users found.</div>';
              } else {
                  searchResults.innerHTML = '';
                  data.users.forEach(user => {
                      // Only show Follow button if logged in and not viewing yourself
                      // The is_following is returned by the API
                      let followBtn = '';
                      if (isLoggedIn) {
                          if (user.is_following > 0) {
                              followBtn = `<button onclick="toggleFollow(${user.id}, this)" class="px-4 py-1.5 rounded-lg text-sm font-bold transition-colors bg-black/10 dark:bg-white/10 hover:bg-black/20 dark:hover:bg-white/20 text-zinc-900 dark:text-white">Unfollow</button>`;
                          } else {
                              followBtn = `<button onclick="toggleFollow(${user.id}, this)" class="px-4 py-1.5 rounded-lg text-sm font-bold transition-colors bg-primary hover:bg-purple-600 text-white">Follow</button>`;
                          }
                      }

                      searchResults.innerHTML += `
                          <div class="flex items-center justify-between p-4 bg-white dark:bg-[#120b18] rounded-xl border border-zinc-200 dark:border-white/10 shadow-sm hover:shadow-md transition-shadow">
                              <a href="profile.php?user_id=${user.id}" class="flex items-center gap-4 grow">
                                  <div class="w-12 h-12 rounded-full overflow-hidden shrink-0">
                                      <img src="${user.avatar_url}" class="w-full h-full object-cover">
                                  </div>
                                  <div class="flex flex-col">
                                      <span class="font-bold text-zinc-900 dark:text-white text-lg leading-tight">${user.username}</span>
                                      <span class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-1">${user.bio || 'Just a moon lover exploring the cosmos. ✨'}</span>
                                  </div>
                              </a>
                              <div class="shrink-0 ml-4">
                                  ${followBtn}
                              </div>
                          </div>
                      `;
                  });
              }
          }
      } catch (err) {
          searchResults.innerHTML = '<div class="p-12 text-center text-red-500">Connection error.</div>';
      }
  }

  async function toggleFollow(followingId, btn) {
      if (!isLoggedIn) {
          window.location.href = 'signup.php';
          return;
      }
      try {
          const formData = new FormData();
          formData.append('following_id', followingId);
          
          btn.disabled = true;
          const res = await fetch('php/toggle_follow.php', { method: 'POST', body: formData });
          const data = await res.json();
          
          if (data.success) {
              if (data.action === 'followed') {
                  btn.className = "px-4 py-1.5 rounded-lg text-sm font-bold transition-colors bg-black/10 dark:bg-white/10 hover:bg-black/20 dark:hover:bg-white/20 text-zinc-900 dark:text-white";
                  btn.innerText = "Unfollow";
              } else {
                  btn.className = "px-4 py-1.5 rounded-lg text-sm font-bold transition-colors bg-primary hover:bg-purple-600 text-white";
                  btn.innerText = "Follow";
              }
          } else {
              if (data.message === 'Unauthorized') {
                  window.location.href = 'signup.php';
              } else {
                  alert(data.message);
              }
          }
      } catch(err) {
          alert('Connection error');
      } finally {
          btn.disabled = false;
      }
  }
</script>
</body>
</html>
