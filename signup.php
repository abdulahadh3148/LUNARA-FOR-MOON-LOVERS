<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LUNARA - Join the Cosmos</title>
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
<body class="bg-background-dark font-display text-white min-h-screen flex items-center justify-center p-4 bg-[url('https://images.unsplash.com/photo-1522030299830-16b8d3d049fe?q=80&w=1000&auto=format&fit=crop')] bg-cover bg-center">
  <!-- Overlay -->
  <div class="absolute inset-0 bg-[#120b18]/80 backdrop-blur-sm z-0"></div>

  <div class="relative z-10 w-full max-w-md bg-white/10 p-8 rounded-2xl border border-white/20 backdrop-blur-md shadow-2xl">
    
    <div class="text-center mb-8">
      <span class="material-symbols-outlined text-primary text-5xl" style="font-variation-settings: 'FILL' 1;">nightlight</span>
      <h1 class="text-3xl font-extrabold tracking-tight mt-2">LUNARA</h1>
      <p class="text-zinc-300 mt-2">Join the ultimate community for moon lovers.</p>
    </div>

    <!-- Error/Success Message Box -->
    <div id="msgBox" class="hidden mb-4 p-3 rounded-lg text-sm text-center"></div>

    <!-- Login Form -->
    <form id="loginForm" class="flex flex-col gap-4">
      <div>
        <label class="block text-sm font-bold mb-1 text-zinc-300">Username or Email</label>
        <input type="text" name="username_or_email" required class="w-full bg-black/30 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
      </div>
      <div>
        <label class="block text-sm font-bold mb-1 text-zinc-300">Password</label>
        <input type="password" name="password" required class="w-full bg-black/30 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
      </div>
      <button type="submit" class="w-full bg-primary hover:bg-purple-600 text-white font-bold py-3 px-4 rounded-xl transition-colors mt-2 shadow-lg shadow-primary/30">
        Log In
      </button>
      <p class="text-center text-sm text-zinc-400 mt-4">
        Don't have an account? <a href="#" id="showRegister" class="text-primary hover:underline font-bold">Sign Up</a>
      </p>
    </form>

    <!-- Register Form (Hidden initially) -->
    <form id="registerForm" class="hidden flex flex-col gap-4">
      <div>
        <label class="block text-sm font-bold mb-1 text-zinc-300">Username</label>
        <input type="text" name="username" required class="w-full bg-black/30 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
      </div>
      <div>
        <label class="block text-sm font-bold mb-1 text-zinc-300">Email</label>
        <input type="email" name="email" required class="w-full bg-black/30 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
      </div>
      <div>
        <label class="block text-sm font-bold mb-1 text-zinc-300">Password</label>
        <input type="password" name="password" required class="w-full bg-black/30 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
      </div>
      <button type="submit" class="w-full bg-white hover:bg-zinc-200 text-black font-bold py-3 px-4 rounded-xl transition-colors mt-2">
        Create Account
      </button>
      <p class="text-center text-sm text-zinc-400 mt-4">
        Already have an account? <a href="#" id="showLogin" class="text-primary hover:underline font-bold">Log In</a>
      </p>
    </form>

  </div>

  <script>
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const msgBox = document.getElementById('msgBox');

    // Toggle Forms
    document.getElementById('showRegister').addEventListener('click', (e) => {
        e.preventDefault();
        loginForm.classList.add('hidden');
        registerForm.classList.remove('hidden');
        msgBox.classList.add('hidden');
    });

    document.getElementById('showLogin').addEventListener('click', (e) => {
        e.preventDefault();
        registerForm.classList.add('hidden');
        loginForm.classList.remove('hidden');
        msgBox.classList.add('hidden');
    });

    function showMessage(msg, isSuccess) {
        msgBox.textContent = msg;
        msgBox.className = `mb-4 p-3 rounded-lg text-sm text-center ${isSuccess ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30'}`;
        msgBox.classList.remove('hidden');
    }

    // Handle Login
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(loginForm);
        try {
            const res = await fetch('php/login.php', { method: 'POST', body: formData });
            const data = await res.json();
            if(data.success) {
                if (data.onboarding_completed === 0) {
                    window.location.href = 'onboarding.php';
                } else {
                    window.location.href = 'index.php';
                }
            } else {
                showMessage(data.message, false);
            }
        } catch(err) { showMessage('Connection error.', false); }
    });

    // Handle Register
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(registerForm);
        try {
            const res = await fetch('php/register.php', { method: 'POST', body: formData });
            const data = await res.json();
            if(data.success) {
                showMessage(data.message, true);
                // Switch to login tab
                setTimeout(() => {
                    document.getElementById('showLogin').click();
                }, 1500);
            } else {
                showMessage(data.message, false);
            }
        } catch(err) { showMessage('Connection error.', false); }
    });
  </script>
</body>
</html>
