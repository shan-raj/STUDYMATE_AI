<?php
// Start the session
session_start();

$name = $_SESSION['name'] ?? 'Student';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>StudyMate AI - Dashboard</title>
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen flex flex-col items-center relative overflow-x-hidden" style="overflow-y:auto;">
  <div class="absolute inset-0 z-0">
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-300 rounded-full opacity-30 blur-2xl animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-300 rounded-full opacity-30 blur-2xl animate-pulse"></div>
  </div>
  <nav class="fixed top-0 left-0 w-full bg-white bg-opacity-90 backdrop-filter backdrop-blur-lg z-50 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 flex justify-between h-16 items-center">
      <div class="flex items-center">
        <img class="h-10 w-10 rounded-full" src="logo.png" alt="StudyMate AI Logo">
        <span class="ml-3 text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">StudyMate AI</span>
      </div>
      <div class="flex items-center space-x-4">
        <a href="index.php" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">Home</a>
        <a href="session_history.php" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">History</a>
        <a href="login.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-200">Logout</a>
      </div>
    </div>
  </nav>
  <div class="relative z-10 flex flex-col items-center justify-center w-full max-w-lg p-8 bg-white bg-opacity-90 rounded-2xl shadow-2xl mt-24">
    <div class="mb-6">
      <img src="logo.png" alt="StudyMate AI Logo" class="w-20 h-20 mx-auto rounded-full shadow-lg border-4 border-blue-200">
    </div>
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-2">Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
    <p class="text-gray-600 text-center mb-6">Track your focus and session progress below.</p>
    <div class="w-full mb-6">
      <div class="bg-blue-50 rounded-xl p-6 shadow-inner text-center">
        <h5 class="text-xl font-semibold text-blue-800 mb-2">Live Session Status</h5>
        <p class="mb-2">Status: <span id="statusText" class="font-bold text-green-600">Not Started</span></p>
        <p class="mb-2">Current Session: <span id="sessionTime" class="font-mono">00:00</span></p>
        <div class="flex justify-center gap-4 mt-4">
          <button onclick="window.location.href='focus_session.php';" 
  class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition duration-200 cursor-pointer">
  Start Session
</button>

          <button id="stopSession" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded transition duration-200 cursor-pointer">Stop Session</button>
        </div>
      </div>
    </div>
    <div class="w-full mt-4">
      <h3 class="text-lg font-semibold text-blue-700 mb-2">How it works</h3>
      <ul class="list-disc list-inside text-gray-700 space-y-1 text-left">
        <li>Click <span class="font-semibold">Start Session</span> to begin tracking your focus time.</li>
        <li>Stay active to keep your status as <span class="text-green-600 font-semibold">Focused</span>.</li>
        <li>Distractions and inactivity will be tracked automatically.</li>
        <li>Click <span class="font-semibold">Stop Session</span> to save your session and view your history.</li>
      </ul>
    </div>
  </div>
  <div id="fullscreen-warning" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 hidden">
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm text-center">
      <h3 class="text-xl font-bold text-red-600 mb-4">Focus Mode Active</h3>
      <p class="text-gray-700 mb-4">You cannot exit fullscreen during a focus session.<br>To end your session, click <span class="font-semibold">Stop Session</span>.</p>
      <button id="resumeFullscreen" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded transition duration-200">Resume Focus</button>
    </div>
  </div>
  <footer class="relative z-10 mt-10 text-gray-500 text-sm text-center">
    &copy; 2025 StudyMate AI. All rights reserved.
  </footer>
  <script>
    let sessionStarted = false;
    let seconds = 0;
    let distractionTime = 0;
    let idleTime = 0;
    let timerInterval, idleInterval;

    function formatTime(secs) {
      const mins = Math.floor(secs / 60).toString().padStart(2, '0');
      const secsLeft = (secs % 60).toString().padStart(2, '0');
      return `${mins}:${secsLeft}`;
    }

    function requestNotificationPermission() {
      if (Notification.permission !== "granted") {
        Notification.requestPermission();
      }
    }

    function showNotification(title, body) {
      if (Notification.permission === "granted") {
        new Notification(title, { body });
      }
    }

    function openFullscreen() {
      const elem = document.documentElement;
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.mozRequestFullScreen) { /* Firefox */
        elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
        elem.webkitRequestFullscreen();
      } else if (elem.msRequestFullscreen) { /* IE/Edge */
        elem.msRequestFullscreen();
      }
    }

    function closeFullscreen() {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
    }

    let blockExit = false;
    function preventExit(e) {
      if (blockExit) {
        e.preventDefault();
        e.returnValue = '';
        return '';
      }
    }

    function showFullscreenWarning() {
      document.getElementById('fullscreen-warning').classList.remove('hidden');
    }

    function hideFullscreenWarning() {
      document.getElementById('fullscreen-warning').classList.add('hidden');
    }

    document.getElementById('resumeFullscreen').onclick = function() {
      hideFullscreenWarning();
      openFullscreen();
    };

    document.getElementById('startSession').addEventListener('click', () => {
      if (!sessionStarted) {
        requestNotificationPermission();
        sessionStarted = true;
        document.getElementById('statusText').innerText = "Focused";

        timerInterval = setInterval(() => {
          seconds++;
          document.getElementById('sessionTime').innerText = formatTime(seconds);
        }, 1000);

        idleInterval = setInterval(() => {
          idleTime++;
          if (idleTime > 120) {
            distractionTime++;
            document.getElementById('statusText').innerText = "Distracted";
            showNotification("Stay Focused!", "You've been inactive for a while. Time to refocus!");
          }
        }, 60000);

        document.addEventListener('mousemove', () => {
          idleTime = 0;
          if (sessionStarted) {
            document.getElementById('statusText').innerText = "Focused";
          }
        });

        document.addEventListener('visibilitychange', () => {
          if (document.hidden) {
            distractionTime++;
            document.getElementById('statusText').innerText = "Distracted";
            showNotification("Focus Alert", "You've switched tabs. Stay on track!");
          } else {
            document.getElementById('statusText').innerText = "Focused";
          }
        });

        document.addEventListener('fullscreenchange', function() {
          if (blockExit && !document.fullscreenElement) {
            showFullscreenWarning();
          }
        });

        openFullscreen();
        blockExit = true;
        window.addEventListener('beforeunload', preventExit);
        document.addEventListener('keydown', function(e) {
          if (
            e.key === 'F11' ||
            e.key === 'Escape' ||
            (e.ctrlKey && (e.key === 'w' || e.key === 'W' || e.key === 'Tab')) ||
            (e.altKey && e.key === 'Tab')
          ) {
            e.preventDefault();
            e.stopPropagation();
          }
        }, true);
      }
    });

   document.getElementById('stopSession').addEventListener('click', async () => {
  if (sessionStarted) {
    clearInterval(timerInterval);
    clearInterval(idleInterval);
    sessionStarted = false;

    closeFullscreen();
    blockExit = false;
    window.removeEventListener('beforeunload', preventExit);

    const sessionData = {
      duration: seconds,
      distractions: distractionTime,
      points: 0,
      badges: []
    };

    try {
      const response = await fetch('save_session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(sessionData)
      });
      const result = await response.json();

      if (response.ok && result.status === 'success') {
        window.location.href = 'session_history.php';
      } else {
        alert('Error: Could not save session to the database. ' + (result.message || ''));
      }
    } catch (error) {
      alert('Network error: ' + error.message);
    }
  }
});

  </script>
</body>
</html>
