<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<!-- 📝 Ithu HTML5 structure start -->

<html class="dark" lang="en">
<head>
  <!-- 🔤 Character encoding and screen size set -->
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <!-- 🌕 Page title -->
  <title>LUNARA - Your Guide to the Cosmos</title>
  
  <!-- 🎨 Tailwind CSS link -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  
  <!-- 🪶 Google fonts connect -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet"/>
  
  <!-- 💫 Google icons for symbols -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

  <!-- ⚙️ Tailwind config customize -->
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#7f13ec",             // main theme color
            "background-light": "#f7f6f8",    // light mode bg
            "background-dark": "#191022",     // dark mode bg
          },
          fontFamily: {
            "display": ["Plus Jakarta Sans", "sans-serif"] // default font
          },
          borderRadius: {
            "DEFAULT": "0.5rem",
            "lg": "1rem",
            "xl": "1.5rem",
            "full": "9999px"
          },
        },
      },
    }
  </script>

  <!-- 🧿 Icon style -->
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .icon-filled {
      font-variation-settings: 'FILL' 1 !important;
    }
  </style>

  <!-- 📏 Page height fix -->
  <style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-zinc-900 dark:text-zinc-100">
<!-- Layout Container -->
<div class="relative flex min-h-screen w-full flex-col md:flex-row mx-auto max-w-5xl md:px-4 lg:px-8">

  <!-- 📱 Mobile Top Navigation Bar (Hidden on md+) -->
  <header class="md:hidden flex items-center bg-white/80 dark:bg-[#120b18]/80 backdrop-blur-md p-4 pb-3 justify-between sticky top-0 z-50 border-b border-zinc-200/50 dark:border-white/10">
    <h1 class="text-xl font-extrabold tracking-tight text-primary">LUNARA</h1>
    <div class="flex items-center justify-end gap-4">
      <button class="flex items-center justify-center"><span class="material-symbols-outlined text-[28px]">notifications</span></button>
      <button class="flex items-center justify-center"><span class="material-symbols-outlined text-[28px]">chat</span></button>
    </div>
  </header>

  <!-- 💻 PC Side Navigation (Hidden on mobile) & 📱 Mobile Bottom Nav -->
  <nav class="fixed bottom-0 left-0 w-full bg-white dark:bg-[#120b18] border-t border-zinc-200/50 dark:border-white/10 z-50 pb-safe
              md:relative md:w-20 lg:w-64 md:border-t-0 md:border-r md:h-screen md:bg-transparent md:dark:bg-transparent md:pt-8 md:pb-8 md:px-2 lg:px-4 flex md:flex-col md:justify-start">
    
    <!-- Logo for PC -->
    <div class="hidden md:flex mb-8 items-center justify-center lg:justify-start px-2">
       <h1 class="hidden lg:block text-2xl font-extrabold tracking-tight text-primary">LUNARA</h1>
       <span class="lg:hidden material-symbols-outlined text-primary text-4xl icon-filled">nightlight</span>
    </div>

    <!-- Nav Links Container -->
    <div class="flex justify-around items-center h-14 md:h-auto md:flex-col md:gap-2 md:items-start w-full">
      
      <!-- Home (Active) -->
      <a href="#" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-900 dark:text-white font-bold group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform icon-filled">home</span>
        <span class="hidden lg:block text-lg">Home</span>
      </a>

      <!-- Search -->
      <a href="search.php" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">search</span>
        <span class="hidden lg:block text-lg">Search</span>
      </a>

      <!-- Create Post (+) -->
      <button onclick="<?= $isLoggedIn ? "document.getElementById('createModal').classList.remove('hidden')" : "window.location.href='signup.php'" ?>" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white group">
        <!-- Mobile styled Add button -->
        <div class="md:hidden bg-primary text-white p-2 rounded-xl shadow-lg shadow-primary/30 transform hover:scale-105 transition-transform">
          <span class="material-symbols-outlined text-2xl font-bold">add</span>
        </div>
        <!-- PC styled Add button -->
        <span class="hidden md:block material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">add_box</span>
        <span class="hidden lg:block text-lg">Create</span>
      </button>

      <!-- Notifications -->
      <a href="#" class="hidden md:flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">favorite</span>
        <span class="hidden lg:block text-lg">Notifications</span>
      </a>

      <!-- Direct Messages -->
      <a href="#" class="hidden md:flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">chat</span>
        <span class="hidden lg:block text-lg">Messages</span>
      </a>

      <!-- Mobile Activity (Heart) -->
      <a href="#" class="md:hidden flex flex-col items-center justify-center w-full h-full text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
        <span class="material-symbols-outlined text-3xl">favorite</span>
      </a>

      <?php if ($isLoggedIn): ?>
      <!-- Profile & Logout-->
      <a href="profile.php?user_id=<?= $_SESSION['user_id'] ?>" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white md:mt-auto group">
        <div class="w-8 h-8 rounded-full bg-zinc-200 overflow-hidden border border-zinc-300 dark:border-zinc-700 group-hover:scale-110 transition-transform">
          <img src="https://i.pravatar.cc/150?img=68" alt="My Profile" class="w-full h-full object-cover">
        </div>
        <span class="hidden lg:block text-lg">Profile</span>
      </a>
      <a href="php/logout.php" class="hidden md:flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">logout</span>
        <span class="hidden lg:block text-lg">Logout</span>
      </a>
      <?php else: ?>
      <!-- Login -->
      <a href="signup.php" class="flex flex-col md:flex-row items-center md:justify-start lg:gap-4 w-full h-full md:p-3 rounded-xl md:hover:bg-zinc-100 md:dark:hover:bg-white/5 transition-colors text-zinc-500 hover:text-zinc-900 dark:hover:text-white md:mt-auto group">
        <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">login</span>
        <span class="hidden lg:block text-lg">Log In / Sign Up</span>
      </a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- 🪐 Main Feed Content (Dynamic) -->
  <main class="w-full grow pb-20 md:pb-0 flex justify-center">
    <div id="feed-container" class="w-full max-w-md lg:max-w-[470px] md:mt-8 md:mb-8 sm:border-x md:border-x-0 border-zinc-200/50 dark:border-white/10 bg-white dark:bg-[#120b18] md:bg-transparent shadow-xl md:shadow-none min-h-screen">
      <!-- Loading state -->
      <div class="p-8 text-center text-zinc-500">
         <span class="material-symbols-outlined text-4xl animate-spin">sync</span>
         <p>Loading posts...</p>
      </div>
    </div>
  </main>

  <!-- ✍️ Create Post Modal -->
  <div id="createModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-[#191022] w-full max-w-md rounded-2xl overflow-hidden shadow-2xl transform transition-all">
      <div class="flex justify-between items-center p-4 border-b border-zinc-200 dark:border-zinc-800">
        <h3 class="font-bold text-lg">Create Post</h3>
        <button onclick="document.getElementById('createModal').classList.add('hidden')" class="text-zinc-500 hover:text-zinc-800 dark:hover:text-white"><span class="material-symbols-outlined">close</span></button>
      </div>
      
      <form id="createPostForm" class="p-4 flex flex-col gap-4">
        <!-- Type Selection -->
        <div class="flex gap-4">
          <label class="flex-1 text-center cursor-pointer">
            <input type="radio" name="type" value="photo" class="hidden peer" checked onchange="togglePostType()">
            <div class="p-3 border border-zinc-200 dark:border-zinc-700 rounded-xl peer-checked:border-primary peer-checked:bg-primary/10 transition-colors">
              <span class="material-symbols-outlined">image</span>
              <p class="font-bold text-sm mt-1">Photo</p>
            </div>
          </label>
          <label class="flex-1 text-center cursor-pointer">
            <input type="radio" name="type" value="quote" class="hidden peer" onchange="togglePostType()">
            <div class="p-3 border border-zinc-200 dark:border-zinc-700 rounded-xl peer-checked:border-primary peer-checked:bg-primary/10 transition-colors">
              <span class="material-symbols-outlined">format_quote</span>
              <p class="font-bold text-sm mt-1">Quote</p>
            </div>
          </label>
        </div>

        <!-- File Upload (Visible if Photo) -->
        <div id="imageUploadGroup" class="flex flex-col gap-2">
          <label class="block text-sm font-bold text-zinc-600 dark:text-zinc-300">Upload Image</label>
          <input type="file" name="image" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
        </div>

        <!-- Caption/Quote Content -->
        <div class="flex flex-col gap-2">
          <label id="contentLabel" class="block text-sm font-bold text-zinc-600 dark:text-zinc-300">Caption</label>
          <textarea name="content" rows="4" placeholder="Write something..." class="w-full bg-zinc-100 dark:bg-black/30 border border-zinc-200 dark:border-white/20 rounded-xl px-4 py-3 text-zinc-900 dark:text-white placeholder-zinc-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors resize-none"></textarea>
        </div>

        <button type="submit" class="w-full bg-primary hover:bg-purple-600 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-lg shadow-primary/30 mt-2">
          Post
        </button>
      </form>
    </div>
  </div>

</div>

<!-- JavaScript for Dynamic Feed and Forms -->
<script>
  const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

  // Toggle form fields based on post type
  function togglePostType() {
    const type = document.querySelector('input[name="type"]:checked').value;
    const imgGroup = document.getElementById('imageUploadGroup');
    const contentLabel = document.getElementById('contentLabel');
    
    if (type === 'photo') {
      imgGroup.classList.remove('hidden');
      contentLabel.innerText = 'Caption';
    } else {
      imgGroup.classList.add('hidden');
      contentLabel.innerText = 'Quote Text';
    }
  }

  // Handle Post Creation
  document.getElementById('createPostForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    submitBtn.innerText = 'Posting...';
    submitBtn.disabled = true;

    try {
      const res = await fetch('php/create_post.php', { method: 'POST', body: formData });
      const data = await res.json();
      
      if (data.success) {
        document.getElementById('createModal').classList.add('hidden');
        e.target.reset();
        togglePostType();
        fetchPosts(); // Reload feed
      } else {
        alert(data.message);
      }
    } catch(err) {
      alert('Error uploading post.');
    } finally {
      submitBtn.innerText = 'Post';
      submitBtn.disabled = false;
    }
  });

  // Handle Like Toggle
  async function toggleLike(postId, btn) {
    if (!isLoggedIn) {
      window.location.href = 'signup.php';
      return;
    }

    const icon = btn.querySelector('span');
    const countSpan = document.getElementById(`like-count-${postId}`);
    let currentCount = parseInt(countSpan.innerText);
    
    const formData = new FormData();
    formData.append('post_id', postId);

    try {
      const res = await fetch('php/toggle_like.php', { method: 'POST', body: formData });
      const data = await res.json();
      
      if (data.success) {
        if (data.action === 'liked') {
          icon.classList.add('icon-filled');
          icon.classList.add('text-red-500');
          countSpan.innerText = currentCount + 1 + ' likes';
        } else {
          icon.classList.remove('icon-filled');
          icon.classList.remove('text-red-500');
          countSpan.innerText = currentCount - 1 + ' likes';
        }
      }
    } catch(err) {
      console.error('Like failed', err);
    }
  }

  // Toggle Comment Section
  async function toggleComments(postId) {
    if (!isLoggedIn) {
      window.location.href = 'signup.php';
      return;
    }

    const section = document.getElementById(`comments-${postId}`);
    const list = document.getElementById(`comment-list-${postId}`);
    
    if (section.classList.contains('hidden')) {
      section.classList.remove('hidden');
      
      // Fetch comments
      list.innerHTML = '<p class="text-xs text-zinc-500 text-center">Loading comments...</p>';
      try {
        const res = await fetch(`php/get_comments.php?post_id=${postId}`);
        const data = await res.json();
        
        if (data.success) {
          list.innerHTML = '';
          if (data.comments.length === 0) {
            list.innerHTML = '<p class="text-xs text-zinc-500 text-center">No comments yet.</p>';
          } else {
            data.comments.forEach(c => {
              list.innerHTML += `
                <div class="flex gap-2 mb-2">
                  <img src="${c.avatar_url}" class="w-6 h-6 rounded-full object-cover">
                  <div class="bg-zinc-100 dark:bg-black/30 rounded-xl px-3 py-2 text-sm">
                    <span class="font-bold mr-1">${c.username}</span>${c.comment_text}
                  </div>
                </div>
              `;
            });
          }
        }
      } catch(err) {
        list.innerHTML = '<p class="text-xs text-red-500 text-center">Failed to load comments.</p>';
      }
    } else {
      section.classList.add('hidden');
    }
  }

  // Handle Comment Submission
  async function submitComment(e, postId) {
    e.preventDefault();
    const form = e.target;
    const input = form.querySelector('input');
    const text = input.value.trim();
    if (!text) return;

    const formData = new FormData();
    formData.append('post_id', postId);
    formData.append('comment_text', text);

    try {
      const res = await fetch('php/add_comment.php', { method: 'POST', body: formData });
      const data = await res.json();
      
      if (data.success) {
        input.value = '';
        
        // Update count
        const countSpan = document.getElementById(`comment-count-${postId}`);
        if(countSpan) countSpan.innerText = parseInt(countSpan.innerText) + 1 + ' comments';
        
        // Reload comments
        const section = document.getElementById(`comments-${postId}`);
        section.classList.add('hidden');
        toggleComments(postId);
      }
    } catch(err) {
      console.error('Comment failed', err);
    }
  }

  // Fetch and Render Posts
  async function fetchPosts() {
    const container = document.getElementById('feed-container');
    try {
      const res = await fetch('php/get_posts.php');
      const data = await res.json();
      
      if (data.success) {
        container.innerHTML = ''; // Clear loading
        if (data.posts.length === 0) {
           container.innerHTML = '<div class="p-8 text-center text-zinc-500">No posts yet. Be the first!</div>';
           return;
        }

        data.posts.forEach(post => {
          let mediaHtml = '';
          let textHtml = '';

          // Format time
          const date = new Date(post.created_at);
          const now = new Date();
          const diffHrs = Math.round((now - date) / 3600000);
          const timeStr = diffHrs < 24 ? `${diffHrs}h ago` : `${Math.round(diffHrs/24)}d ago`;

          // Like status styling
          const likeClass = post.user_liked > 0 ? "text-red-500 icon-filled" : "hover:text-red-500";

          if (post.type === 'photo' && post.media_url) {
            mediaHtml = `
              <div class="w-full aspect-square bg-zinc-200 dark:bg-zinc-800">
                <img src="${post.media_url}" alt="Post image" class="w-full h-full object-cover">
              </div>
            `;
            textHtml = `
              <div class="px-3 text-sm pb-1">
                <p><span class="font-bold mr-1">${post.username}</span>${post.content}</p>
              </div>
            `;
          } else if (post.type === 'quote') {
            mediaHtml = `
              <div class="w-full aspect-square bg-gradient-to-br from-primary to-indigo-900 flex items-center justify-center p-8 text-center shadow-inner md:rounded-sm">
                <h2 class="text-white text-3xl font-display font-bold leading-tight">"${post.content}"</h2>
              </div>
            `;
            textHtml = `
              <div class="px-3 text-sm pb-1">
                <p><span class="font-bold mr-1">${post.username}</span>Shared a quote ✨</p>
              </div>
            `;
          }

          const article = document.createElement('article');
          article.className = 'border-b border-zinc-200/50 dark:border-white/10 pb-4 mb-4 md:bg-white md:dark:bg-[#120b18] md:rounded-xl md:border md:shadow-sm';
          article.innerHTML = `
            <!-- Post Header -->
            <div class="flex items-center justify-between p-3">
              <div class="flex items-center gap-3">
                <a href="profile.php?user_id=${post.user_id}" class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary to-pink-500 p-[2px] block cursor-pointer">
                  <div class="w-full h-full rounded-full bg-white dark:bg-[#120b18] border border-white dark:border-zinc-800 overflow-hidden">
                     <img src="${post.avatar_url}" alt="User avatar" class="w-full h-full object-cover">
                  </div>
                </a>
                <div>
                  <a href="profile.php?user_id=${post.user_id}" class="font-bold text-sm hover:underline block cursor-pointer">${post.username}</a>
                  <p class="text-xs text-zinc-500">${timeStr}</p>
                </div>
              </div>
              <button><span class="material-symbols-outlined text-zinc-500">more_horiz</span></button>
            </div>
            
            ${mediaHtml}

            <!-- Post Actions -->
            <div class="flex items-center justify-between px-3 pt-3 pb-2">
              <div class="flex items-center gap-4">
                <button onclick="toggleLike(${post.id}, this)">
                  <span class="material-symbols-outlined text-[28px] transition-colors ${likeClass}">favorite</span>
                </button>
                <button onclick="toggleComments(${post.id})">
                  <span class="material-symbols-outlined text-[28px]">mode_comment</span>
                </button>
              </div>
              <button><span class="material-symbols-outlined text-[28px]">bookmark</span></button>
            </div>

            <!-- Stats -->
            <div class="px-3 text-sm font-bold mb-1 flex gap-3">
              <span id="like-count-${post.id}">${post.like_count} likes</span>
              <span id="comment-count-${post.id}" class="text-zinc-500 font-normal cursor-pointer" onclick="toggleComments(${post.id})">${post.comment_count} comments</span>
            </div>

            ${textHtml}

            <!-- Comments Section (Hidden by default) -->
            <div id="comments-${post.id}" class="hidden px-3 pt-2 mt-2 border-t border-zinc-200/50 dark:border-white/10">
               <div id="comment-list-${post.id}" class="max-h-40 overflow-y-auto mb-2 flex flex-col gap-2"></div>
               <form onsubmit="submitComment(event, ${post.id})" class="flex gap-2">
                 <input type="text" placeholder="Add a comment..." required class="flex-1 bg-zinc-100 dark:bg-black/30 border border-zinc-200 dark:border-white/20 rounded-full px-3 py-1.5 text-sm text-zinc-900 dark:text-white placeholder-zinc-500 focus:outline-none focus:border-primary">
                 <button type="submit" class="text-primary font-bold text-sm">Post</button>
               </form>
            </div>
          `;
          container.appendChild(article);
        });
      }
    } catch(err) {
      container.innerHTML = '<div class="p-8 text-center text-red-500">Failed to load feed.</div>';
    }
  }

  // Load feed on startup
  fetchPosts();
</script>
</body>
