<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signup.php");
    exit;
}

require_once 'php/db.php';
$stmt = $pdo->prepare("SELECT onboarding_completed FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($user && $user['onboarding_completed'] == 1) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome to LUNARA</title>
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
  <div class="absolute inset-0 bg-[#120b18]/90 backdrop-blur-sm z-0"></div>

  <div class="relative z-10 w-full max-w-md bg-white/10 p-8 rounded-2xl border border-white/20 backdrop-blur-md shadow-2xl overflow-hidden">
    
    <div id="msgBox" class="hidden mb-4 p-3 rounded-lg text-sm text-center"></div>

    <form id="onboardingForm" class="flex flex-col">
      <!-- Step 1: Avatar -->
      <div id="step1" class="flex flex-col items-center animate-fade-in-up">
        <h2 class="text-3xl font-extrabold tracking-tight mt-2 mb-2 text-center">Add a Profile Photo</h2>
        <p class="text-zinc-400 text-center mb-8 text-sm">Add a profile photo so your friends know it's you.</p>
        
        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-primary relative group cursor-pointer mb-8 shadow-lg shadow-primary/30">
          <img id="avatarPreview" src="https://ui-avatars.com/api/?name=User&background=random" class="w-full h-full object-cover">
          <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
             <span class="material-symbols-outlined text-white text-3xl">add_a_photo</span>
          </div>
          <input type="file" name="avatar" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this)">
        </div>

        <div class="w-full space-y-3">
          <button type="button" onclick="nextStep()" class="w-full bg-primary hover:bg-purple-600 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-lg shadow-primary/30">
            Next
          </button>
          <button type="button" onclick="nextStep()" class="w-full bg-transparent text-white font-bold py-3 px-4 rounded-xl hover:bg-white/5 transition-colors">
            Skip
          </button>
        </div>
      </div>

      <!-- Step 2: Bio -->
      <div id="step2" class="hidden flex-col animate-fade-in-up w-full">
        <div class="flex items-center gap-2 mb-6 cursor-pointer text-zinc-400 hover:text-white" onclick="prevStep()">
            <span class="material-symbols-outlined text-xl">arrow_back</span> Back
        </div>
        
        <h2 class="text-3xl font-extrabold tracking-tight mt-2 mb-2">Write your Bio</h2>
        <p class="text-zinc-400 mb-6 text-sm">Tell the cosmos a little bit about yourself.</p>
        
        <textarea name="bio" rows="4" placeholder="Just a moon lover exploring the cosmos. ✨" class="w-full bg-black/30 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors resize-none mb-8"></textarea>

        <div class="w-full space-y-3">
          <button type="submit" id="submitBtn" class="w-full bg-primary hover:bg-purple-600 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-lg shadow-primary/30">
            Finish Setup
          </button>
          <button type="submit" id="skipBtn" class="w-full bg-transparent text-white font-bold py-3 px-4 rounded-xl hover:bg-white/5 transition-colors">
            Skip
          </button>
        </div>
      </div>
    </form>
  </div>

  <style>
    .animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>

  <script>
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');

    function previewImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    function nextStep() {
        step1.classList.add('hidden');
        step1.classList.remove('flex');
        step2.classList.remove('hidden');
        step2.classList.add('flex');
    }

    function prevStep() {
        step2.classList.add('hidden');
        step2.classList.remove('flex');
        step1.classList.remove('hidden');
        step1.classList.add('flex');
    }

    const form = document.getElementById('onboardingForm');
    const msgBox = document.getElementById('msgBox');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        btn.innerText = 'Finishing...';
        btn.disabled = true;

        const formData = new FormData(form);
        try {
            const res = await fetch('php/complete_onboarding.php', { method: 'POST', body: formData });
            const data = await res.json();
            
            if (data.success) {
                window.location.href = 'index.php';
            } else {
                msgBox.textContent = data.message;
                msgBox.className = 'mb-4 p-3 rounded-lg text-sm text-center bg-red-500/20 text-red-400 border border-red-500/30';
                msgBox.classList.remove('hidden');
            }
        } catch(err) { 
            msgBox.textContent = 'Connection error.';
            msgBox.className = 'mb-4 p-3 rounded-lg text-sm text-center bg-red-500/20 text-red-400 border border-red-500/30';
            msgBox.classList.remove('hidden');
        } finally {
            btn.innerText = 'Finish Setup';
            btn.disabled = false;
        }
    });
  </script>
</body>
</html>
