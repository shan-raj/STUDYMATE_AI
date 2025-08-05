<?php
require_once 'bot_config.php';
// session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <title>Focus Session - StudyMate AI</title>
  <style>
    /* Dark Mode Toggle Button */
    #darkModeToggle {
      position: fixed;
      top: 15px;
      right: 15px;
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      z-index: 999;
      box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }

    #darkModeToggle:hover {
      background-color: #0056b3;
    }

    /* Default light theme */
    body {
      background-color: white;
      color: black;
      font-family: Arial, sans-serif;
      transition: background-color 0.4s, color 0.4s;
      padding: 20px;
    }

    /* Dark mode */
    html.dark body {
      background-color: #121212;
      color: #e0e0e0;
    }

    html.dark .bg-white {
      background-color: #1e1e1e !important;
      color: #e0e0e0;
    }

    html.dark .bg-blue-50 {
      background-color: #1a365d !important;
    }

    html.dark .bg-yellow-50 {
      background-color: #2d3748 !important;
    }

    html.dark .bg-green-50 {
      background-color: #22543d !important;
    }

    html.dark .bg-purple-50 {
      background-color: #44337a !important;
    }

    html.dark .text-gray-600 {
      color: #cbd5e0 !important;
    }

    html.dark .text-gray-700 {
      color: #e2e8f0 !important;
    }

    html.dark .border-gray-300 {
      border-color: #4a5568 !important;
    }

    /* Chatbot styles */
    #chatbot {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 350px;
      height: 450px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 10px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      z-index: 1000;
    }

    html.dark #chatbot {
      background-color: #1e1e1e;
      color: #e0e0e0;
    }

    #chatbotHeader {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
      padding-bottom: 5px;
      border-bottom: 1px solid #eee;
    }

    html.dark #chatbotHeader {
      border-bottom-color: #4a5568;
    }

    #chatbotMessages {
      overflow-y: auto;
      height: 330px;
      margin-bottom: 10px;
      padding: 5px;
    }

    .bot-message, .user-message {
      margin-bottom: 10px;
      padding: 8px 12px;
      border-radius: 10px;
      max-width: 80%;
    }

    .bot-message {
      background-color: #f0f0f0;
      align-self: flex-start;
    }

    html.dark .bot-message {
      background-color: #2d3748;
    }

    .user-message {
      background-color: #1e88e5;
      color: white;
      align-self: flex-end;
      margin-left: auto;
    }

    #chatInput {
      display: flex;
      gap: 5px;
    }

    #userInput {
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ddd;
      width: 100%;
    }

    html.dark #userInput {
      background-color: #2d3748;
      border-color: #4a5568;
      color: #e0e0e0;
    }

    #sendMessage {
      padding: 10px 15px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    #sendMessage:hover {
      background-color: #0056b3;
    }

    /* Feature Panels */
    .feature-panel {
      position: fixed;
      top: 80px;
      right: 20px;
      width: 320px;
      max-height: 500px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 15px;
      z-index: 900;
      overflow-y: auto;
    }

    html.dark .feature-panel {
      background-color: #1e1e1e;
      color: #e0e0e0;
    }

    .feature-toggle {
      position: fixed;
      top: 80px;
      left: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      z-index: 998;
    }

    .feature-btn {
      padding: 10px 15px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .feature-btn:hover {
      background-color: #218838;
    }

    .feature-btn.music {
      background-color: #6f42c1;
    }

    .feature-btn.music:hover {
      background-color: #5a359a;
    }

    .feature-btn.planner {
      background-color: #fd7e14;
    }

    .feature-btn.planner:hover {
      background-color: #e8690e;
    }

    /* Todo List Styles */
    .todo-item {
      display: flex;
      align-items: center;
      padding: 8px;
      border-bottom: 1px solid #eee;
    }

    html.dark .todo-item {
      border-bottom-color: #4a5568;
    }

    .todo-item.completed {
      opacity: 0.6;
      text-decoration: line-through;
    }

    .todo-checkbox {
      margin-right: 10px;
    }

    .todo-text {
      flex: 1;
    }

    .todo-delete {
      background-color: #dc3545;
      color: white;
      border: none;
      border-radius: 3px;
      padding: 2px 6px;
      cursor: pointer;
      font-size: 12px;
    }

    /* Music Player Styles */
    .music-option {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-bottom: 10px;
      cursor: pointer;
    }

    html.dark .music-option {
      border-color: #4a5568;
    }

    .music-option:hover {
      background-color: #f8f9fa;
    }

    html.dark .music-option:hover {
      background-color: #2d3748;
    }

    .music-option.active {
      background-color: #e3f2fd;
      border-color: #2196f3;
    }

    html.dark .music-option.active {
      background-color: #1a365d;
      border-color: #63b3ed;
    }

    .volume-control {
      margin-top: 15px;
    }

    /* Study Plan Styles */
    .plan-section {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    html.dark .plan-section {
      border-color: #4a5568;
    }

    .plan-header {
      font-weight: bold;
      margin-bottom: 5px;
    }

    /* Typing indicator */
    .typing-indicator {
      display: flex;
      padding: 8px 12px;
      background-color: #f0f0f0;
      border-radius: 10px;
      width: fit-content;
    }

    html.dark .typing-indicator {
      background-color: #2d3748;
    }

    .typing-indicator span {
      height: 8px;
      width: 8px;
      background-color: #666;
      border-radius: 50%;
      display: inline-block;
      margin: 0 2px;
      animation: bounce 1.3s linear infinite;
    }

    .typing-indicator span:nth-child(2) {
      animation-delay: 0.15s;
    }

    .typing-indicator span:nth-child(3) {
      animation-delay: 0.3s;
    }

    @keyframes bounce {
      0%, 60%, 100% {
        transform: translateY(0);
      }
      30% {
        transform: translateY(-5px);
      }
    }

    /* Toggle chatbot visibility */
    #toggleChatbot {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 50px;
      height: 50px;
      background-color: #007bff;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 24px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      z-index: 999;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .feature-panel {
        width: 280px;
        right: 10px;
      }
      
      .feature-toggle {
        left: 10px;
      }
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 flex flex-col items-center justify-center min-h-screen">
  <div class="w-full max-w-md p-6 bg-white rounded-xl shadow-lg text-center">
    <h1 class="text-2xl font-bold text-blue-700 mb-4">Focus Session - Welcome <?php echo htmlspecialchars($name); ?></h1>
    <p class="mb-4 text-gray-600">Stay focused! This session is being tracked.</p>

    <button id="darkModeToggle" class="dark-theme-btn">Dark Theme</button>

    <!-- Motivational Quote Section -->
    <div id="motivationalQuote" class="bg-yellow-50 p-4 rounded shadow mb-4 text-xl font-semibold text-gray-700">
      <!-- Quote will be displayed here -->
    </div>

    <div class="bg-blue-50 p-4 rounded shadow mb-4">
      <p>Status: <span id="statusText" class="text-green-600 font-bold">Not Started</span></p>
      <p>Session Time: <span id="sessionTime" class="font-mono text-lg">00:00</span></p>
    </div>

    <div class="flex justify-center gap-4">
      <button id="startSession" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Start</button>
      <button id="stopSession" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Stop</button>
    </div>
  </div>

  <!-- Feature Toggle Buttons -->
  <div class="feature-toggle">
    <button id="toggleTodo" class="feature-btn">📝 To-Do</button>
    <button id="toggleMusic" class="feature-btn music">🎵 Music</button>
    <button id="togglePlanner" class="feature-btn planner">📅 Planner</button>
  </div>

  <!-- To-Do List Panel -->
  <div id="todoPanel" class="feature-panel" style="display: none;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
      <h3 class="font-bold text-lg">To-Do List</h3>
      <button id="closeTodo" class="text-gray-500 hover:text-gray-700 text-xl">×</button>
    </div>
    
    <div style="display: flex; gap: 5px; margin-bottom: 15px;">
      <input id="todoInput" type="text" placeholder="Add a task..." class="flex-1 p-2 border border-gray-300 rounded">
      <button id="addTodo" class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700">Add</button>
    </div>
    
    <div id="todoList" class="max-h-300 overflow-y-auto">
      <!-- Todo items will be added here -->
    </div>
    
    <div class="mt-4 text-sm text-gray-600">
      <p>Completed: <span id="completedCount">0</span> | Total: <span id="totalCount">0</span></p>
    </div>
  </div>

  <!-- Music Panel -->
  <div id="musicPanel" class="feature-panel" style="display: none;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
      <h3 class="font-bold text-lg">Ambient Music</h3>
      <button id="closeMusic" class="text-gray-500 hover:text-gray-700 text-xl">×</button>
    </div>
    
    <div id="musicOptions">
      <div class="music-option" data-type="lofi">
        <span>🎧 Lo-fi Hip Hop</span>
        <button class="play-btn bg-blue-500 text-white px-2 py-1 rounded text-sm">Play</button>
      </div>
      <div class="music-option" data-type="nature">
        <span>🌿 Nature Sounds</span>
        <button class="play-btn bg-blue-500 text-white px-2 py-1 rounded text-sm">Play</button>
      </div>
      <div class="music-option" data-type="rain">
        <span>🌧️ Rain Sounds</span>
        <button class="play-btn bg-blue-500 text-white px-2 py-1 rounded text-sm">Play</button>
      </div>
      <div class="music-option" data-type="whitenoise">
        <span>📻 White Noise</span>
        <button class="play-btn bg-blue-500 text-white px-2 py-1 rounded text-sm">Play</button>
      </div>
      <div class="music-option" data-type="ocean">
        <span>🌊 Ocean Waves</span>
        <button class="play-btn bg-blue-500 text-white px-2 py-1 rounded text-sm">Play</button>
      </div>
    </div>
    
    <div class="volume-control">
      <label class="block text-sm font-medium mb-2">Volume</label>
      <input id="volumeSlider" type="range" min="0" max="100" value="50" class="w-full">
    </div>
    
    <div class="mt-4 text-center">
      <button id="stopMusic" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Stop All</button>
    </div>
  </div>

  <!-- Study Plan Panel -->
  <div id="plannerPanel" class="feature-panel" style="display: none;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
      <h3 class="font-bold text-lg">Study Plan Generator</h3>
      <button id="closePlanner" class="text-gray-500 hover:text-gray-700 text-xl">×</button>
    </div>
    
    <div class="mb-4">
      <label class="block text-sm font-medium mb-2">Subject</label>
      <input id="planSubject" type="text" placeholder="e.g., Mathematics" class="w-full p-2 border border-gray-300 rounded">
    </div>
    
    <div class="mb-4">
      <label class="block text-sm font-medium mb-2">Study Duration (minutes)</label>
      <select id="planDuration" class="w-full p-2 border border-gray-300 rounded">
        <option value="25">25 minutes (Pomodoro)</option>
        <option value="45">45 minutes</option>
        <option value="60">1 hour</option>
        <option value="90">1.5 hours</option>
        <option value="120">2 hours</option>
      </select>
    </div>
    
    <div class="mb-4">
      <label class="block text-sm font-medium mb-2">Difficulty Level</label>
      <select id="planDifficulty" class="w-full p-2 border border-gray-300 rounded">
        <option value="beginner">Beginner</option>
        <option value="intermediate">Intermediate</option>
        <option value="advanced">Advanced</option>
      </select>
    </div>
    
    <button id="generatePlan" class="w-full bg-orange-500 text-white p-2 rounded hover:bg-orange-600 mb-4">Generate Plan</button>
    
    <div id="generatedPlan" class="max-h-250 overflow-y-auto">
      <!-- Generated plan will appear here -->
    </div>
  </div>

  <!-- Chatbot toggle button -->
  <div id="toggleChatbot">💬</div>

  <!-- Chatbot Section -->
  <div id="chatbot" style="display: none;">
    <div id="chatbotHeader">
      <h3 class="font-bold">StudyMate AI Assistant</h3>
      <button id="minimizeChatbot" class="text-gray-500 hover:text-gray-700">−</button>
    </div>
    <div id="chatbotMessages" class="flex flex-col gap-2">
      <!-- Messages will appear here -->
    </div>
    <div id="loading">AI is thinking...</div>
    <div id="chatInput">
      <input id="userInput" type="text" placeholder="Ask me anything about your studies..." />
      <button id="sendMessage">Send</button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    // Motivational quotes array
    const quotes = [
      "The harder you work for something, the greater you'll feel when you achieve it.",
      "Believe in yourself and all that you are. Know that there is something inside you that is greater than any obstacle.",
      "Don't watch the clock; do what it does. Keep going.",
      "It always seems impossible until it's done.",
      "The only way to do great work is to love what you do."
    ];

    let sessionStarted = false;
    let seconds = 0;
    let distractionTime = 0;
    let idleTime = 0;
    let timerInterval, idleInterval;
    let blockExit = false;
    let chatVisible = false;

    // New feature variables
    let todos = [];
    let currentAudio = null;
    let todoIdCounter = 1;

    // Audio context for generating sounds
    let audioContext = null;

    // Format time as MM:SS
    function formatTime(secs) {
      const mins = Math.floor(secs / 60).toString().padStart(2, '0');
      const secsLeft = (secs % 60).toString().padStart(2, '0');
      return `${mins}:${secsLeft}`;
    }

    // Request fullscreen
    function openFullscreen() {
      const elem = document.documentElement;
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      }
    }

    // Exit fullscreen
    function closeFullscreen() {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      }
    }

    // Prevent tab/window exit
    function preventExit(e) {
      if (blockExit) {
        e.preventDefault();
        e.returnValue = '';
        return '';
      }
    }

    // Request notification permission
    if (Notification.permission !== "granted") {
      Notification.requestPermission();
    }

    // Show a random motivational quote
    function showMotivationalQuote() {
      const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
      document.getElementById('motivationalQuote').innerText = randomQuote;
    }

    // Initialize audio context
    function initAudioContext() {
      if (!audioContext) {
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
      }
    }

    // Generate procedural audio for different ambient sounds
    function generateAmbientSound(type) {
      initAudioContext();
      
      if (currentAudio) {
        currentAudio.stop();
      }

      const volumeSlider = document.getElementById('volumeSlider');
      const volume = volumeSlider.value / 100;

      switch(type) {
        case 'whitenoise':
          currentAudio = generateWhiteNoise(volume);
          break;
        case 'rain':
          currentAudio = generateRainSound(volume);
          break;
        case 'ocean':
          currentAudio = generateOceanWaves(volume);
          break;
        case 'nature':
          currentAudio = generateNatureSounds(volume);
          break;
        case 'lofi':
          // For lo-fi, we'll create a simple ambient tone
          currentAudio = generateLoFiAmbient(volume);
          break;
      }
    }

    function generateWhiteNoise(volume) {
      const bufferSize = audioContext.sampleRate * 2;
      const buffer = audioContext.createBuffer(1, bufferSize, audioContext.sampleRate);
      const data = buffer.getChannelData(0);
      
      for (let i = 0; i < bufferSize; i++) {
        data[i] = Math.random() * 2 - 1;
      }
      
      const source = audioContext.createBufferSource();
      const gainNode = audioContext.createGain();
      
      source.buffer = buffer;
      source.loop = true;
      gainNode.gain.value = volume * 0.3;
      
      source.connect(gainNode);
      gainNode.connect(audioContext.destination);
      source.start();
      
      return source;
    }

    function generateRainSound(volume) {
      // Simple rain simulation using filtered noise
      const bufferSize = audioContext.sampleRate * 4;
      const buffer = audioContext.createBuffer(1, bufferSize, audioContext.sampleRate);
      const data = buffer.getChannelData(0);
      
      for (let i = 0; i < bufferSize; i++) {
        data[i] = (Math.random() * 2 - 1) * Math.sin(i * 0.01);
      }
      
      const source = audioContext.createBufferSource();
      const filter = audioContext.createBiquadFilter();
      const gainNode = audioContext.createGain();
      
      source.buffer = buffer;
      source.loop = true;
      filter.type = 'lowpass';
      filter.frequency.value = 1000;
      gainNode.gain.value = volume * 0.4;
      
      source.connect(filter);
      filter.connect(gainNode);
      gainNode.connect(audioContext.destination);
      source.start();
      
      return source;
    }

    function generateOceanWaves(volume) {
      const oscillator = audioContext.createOscillator();
      const gainNode = audioContext.createGain();
      const filter = audioContext.createBiquadFilter();
      
      oscillator.type = 'sine';
      oscillator.frequency.value = 0.5;
      filter.type = 'lowpass';
      filter.frequency.value = 800;
      gainNode.gain.value = volume * 0.3;
      
      oscillator.connect(filter);
      filter.connect(gainNode);
      gainNode.connect(audioContext.destination);
      oscillator.start();
      
      return oscillator;
    }

    function generateNatureSounds(volume) {
      // Combination of multiple tones for nature ambience
      const oscillator1 = audioContext.createOscillator();
      const oscillator2 = audioContext.createOscillator();
      const gainNode = audioContext.createGain();
      
      oscillator1.type = 'sine';
      oscillator1.frequency.value = 200;
      oscillator2.type = 'triangle';
      oscillator2.frequency.value = 300;
      gainNode.gain.value = volume * 0.2;
      
      oscillator1.connect(gainNode);
      oscillator2.connect(gainNode);
      gainNode.connect(audioContext.destination);
      oscillator1.start();
      oscillator2.start();
      
      return { stop: () => { oscillator1.stop(); oscillator2.stop(); } };
    }

    function generateLoFiAmbient(volume) {
      const oscillator = audioContext.createOscillator();
      const gainNode = audioContext.createGain();
      const filter = audioContext.createBiquadFilter();
      
      oscillator.type = 'sawtooth';
      oscillator.frequency.value = 110;
      filter.type = 'lowpass';
      filter.frequency.value = 400;
      gainNode.gain.value = volume * 0.25;
      
      oscillator.connect(filter);
      filter.connect(gainNode);
      gainNode.connect(audioContext.destination);
      oscillator.start();
      
      return oscillator;
    }

    // To-Do List Functions
    function addTodo(text) {
      const todo = {
        id: todoIdCounter++,
        text: text,
        completed: false
      };
      todos.push(todo);
      renderTodos();
      updateTodoStats();
    }

    function toggleTodo(id) {
      const todo = todos.find(t => t.id === id);
      if (todo) {
        todo.completed = !todo.completed;
        renderTodos();
        updateTodoStats();
      }
    }

    function deleteTodo(id) {
      todos = todos.filter(t => t.id !== id);
      renderTodos();
      updateTodoStats();
    }

    function renderTodos() {
      const todoList = document.getElementById('todoList');
      todoList.innerHTML = '';
      
      todos.forEach(todo => {
        const todoDiv = document.createElement('div');
        todoDiv.className = `todo-item ${todo.completed ? 'completed' : ''}`;
        todoDiv.innerHTML = `
          <input type="checkbox" class="todo-checkbox" ${todo.completed ? 'checked' : ''} 
                 onchange="toggleTodo(${todo.id})">
          <span class="todo-text">${todo.text}</span>
          <button class="todo-delete" onclick="deleteTodo(${todo.id})">×</button>
        `;
        todoList.appendChild(todoDiv);
      });
    }

    function updateTodoStats() {
      const completed = todos.filter(t => t.completed).length;
      const total = todos.length;
      document.getElementById('completedCount').textContent = completed;
      document.getElementById('totalCount').textContent = total;
    }

    // Study Plan Generator
    function generateStudyPlan() {
      const subject = document.getElementById('planSubject').value;
      const duration = parseInt(document.getElementById('planDuration').value);
      const difficulty = document.getElementById('planDifficulty').value;
      
      if (!subject) {
        alert('Please enter a subject');
        return;
      }

      const plan = createStudyPlan(subject, duration, difficulty);
      displayStudyPlan(plan);
    }

    function createStudyPlan(subject, duration, difficulty) {
      const plans = {
        beginner: {
          warmup: Math.floor(duration * 0.1),
          study: Math.floor(duration * 0.7),
          practice: Math.floor(duration * 0.15),
          review: Math.floor(duration * 0.05)
        },
        intermediate: {
          warmup: Math.floor(duration * 0.05),
          study: Math.floor(duration * 0.5),
          practice: Math.floor(duration * 0.35),
          review: Math.floor(duration * 0.1)
        },
        advanced: {
          warmup: Math.floor(duration * 0.05),
          study: Math.floor(duration * 0.3),
          practice: Math.floor(duration * 0.5),
          review: Math.floor(duration * 0.15)
        }
      };

      const planStructure = plans[difficulty];
      
              return {
        subject,
        duration,
        difficulty,
        sections: [
          {
            title: 'Warm-up & Review',
            duration: planStructure.warmup,
            activities: [
              'Review previous session notes',
              'Quick concept refresh',
              'Set session goals'
            ]
          },
          {
            title: 'Core Study',
            duration: planStructure.study,
            activities: [
              `Deep dive into ${subject} concepts`,
              'Take detailed notes',
              'Understand key principles'
            ]
          },
          {
            title: 'Practice & Application',
            duration: planStructure.practice,
            activities: [
              'Work on practice problems',
              'Apply learned concepts',
              'Test understanding'
            ]
          },
          {
            title: 'Review & Summary',
            duration: planStructure.review,
            activities: [
              'Summarize key learnings',
              'Identify areas for improvement',
              'Plan next session'
            ]
          }
        ]
      };
    }

    function displayStudyPlan(plan) {
      const planContainer = document.getElementById('generatedPlan');
      planContainer.innerHTML = `
        <div class="mb-4 p-3 bg-blue-50 rounded">
          <h4 class="font-bold">${plan.subject} Study Plan</h4>
          <p class="text-sm">Duration: ${plan.duration} minutes | Level: ${plan.difficulty}</p>
        </div>
      `;

      plan.sections.forEach((section, index) => {
        const sectionDiv = document.createElement('div');
        sectionDiv.className = 'plan-section';
        sectionDiv.innerHTML = `
          <div class="plan-header">${index + 1}. ${section.title} (${section.duration} min)</div>
          <ul class="text-sm text-gray-600">
            ${section.activities.map(activity => `<li>• ${activity}</li>`).join('')}
          </ul>
        `;
        planContainer.appendChild(sectionDiv);
      });
    }

    // Initialize chatbot with welcome message
    function initChatbot() {
      const chatbotMessages = document.getElementById('chatbotMessages');
      addBotMessage("Hello! I'm your StudyMate AI assistant. How can I help you with your studies today?");
    }

    // Add user message to chat
    function addUserMessage(message) {
      const chatbotMessages = document.getElementById('chatbotMessages');
      const userMessageDiv = document.createElement('div');
      userMessageDiv.className = 'user-message';
      userMessageDiv.textContent = message;
      chatbotMessages.appendChild(userMessageDiv);
      chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    // Add bot message to chat
    function addBotMessage(message) {
      const chatbotMessages = document.getElementById('chatbotMessages');
      const botMessageDiv = document.createElement('div');
      botMessageDiv.className = 'bot-message';

      // Convert Markdown to HTML
      const markdownHTML = marked.parse(message);
      botMessageDiv.innerHTML = markdownHTML;

      chatbotMessages.appendChild(botMessageDiv);
      chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    // Show typing indicator
    function showTypingIndicator() {
      const chatbotMessages = document.getElementById('chatbotMessages');
      const typingDiv = document.createElement('div');
      typingDiv.className = 'typing-indicator';
      typingDiv.id = 'typingIndicator';
      typingDiv.innerHTML = '<span></span><span></span><span></span>';
      chatbotMessages.appendChild(typingDiv);
      chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    // Remove typing indicator
    function removeTypingIndicator() {
      const typingIndicator = document.getElementById('typingIndicator');
      if (typingIndicator) {
        typingIndicator.remove();
      }
    }

    // Process user input and get AI response
    const conversationHistory = [];

    async function processUserMessage(userMessage) {
      addUserMessage(userMessage);

      // Add user message to history
      conversationHistory.push({ role: "user", content: userMessage });

      showTypingIndicator();

      try {
        // Send the full conversation history to backend for context
        const response = await axios.post('gemini_proxy.php', {
          messages: conversationHistory
        });

        removeTypingIndicator();

        // Adjust this according to your actual API response structure
        let botResponse = response.data.reply;

        if (!botResponse && response.data.choices && response.data.choices[0]) {
          // Example fallback if you use OpenAI API style response
          botResponse = response.data.choices[0].message.content;
        }

        botResponse = botResponse || "Sorry, I couldn't get a response from the AI.";

        // Replace branding
        botResponse = botResponse.replace(/DeepSeek AI/gi, "StudyMate AI");

        addBotMessage(botResponse);

        // Add bot response to history
        conversationHistory.push({ role: "assistant", content: botResponse });

      } catch (error) {
        console.error('Error getting response:', error);
        removeTypingIndicator();

        // Use local fallback response
        const fallbackResponse = getLocalBotResponse(userMessage).replace(/DeepSeek AI/gi, "StudyMate AI");

        addBotMessage(fallbackResponse);

        // Add fallback to history
        conversationHistory.push({ role: "assistant", content: fallbackResponse });
      }
    }

    // Fallback local responses for when API is unavailable
    function getLocalBotResponse(userInput) {
      const input = userInput.toLowerCase();
      
      // Study-related responses
      if (input.includes('math') || input.includes('calculus') || input.includes('algebra')) {
        return "I can help with math problems! What specific concept or question are you struggling with?";
      }
      
      if (input.includes('history') || input.includes('historical')) {
        return "History is fascinating! I can help with historical events, figures, and periods. What specific aspect are you studying?";
      }
      
      if (input.includes('science') || input.includes('biology') || input.includes('chemistry') || input.includes('physics')) {
        return "I'm happy to help with science topics! Whether it's biology, chemistry, physics, or another branch, let me know what you're working on.";
      }
      
      if (input.includes('english') || input.includes('literature') || input.includes('essay') || input.includes('writing')) {
        return "I can assist with literature analysis, writing techniques, grammar, and essay structure. What are you working on?";
      }
      
      if (input.includes('computer') || input.includes('programming') || input.includes('coding')) {
        return "Programming concepts can be challenging! I can help explain algorithms, syntax, and programming logic. What language or concept are you working with?";
      }
      
      // Focus session related responses
      if (input.includes('focus') || input.includes('concentrate') || input.includes('distracted')) {
        return "Try the Pomodoro technique: 25 minutes of focused study followed by a 5-minute break. Our timer can help you track these sessions!";
      }
      
      if (input.includes('tired') || input.includes('sleep') || input.includes('exhausted')) {
        return "Proper rest is crucial for effective studying. Make sure you're getting 7-9 hours of sleep. Short power naps (15-20 minutes) can also help refresh your mind.";
      }
      
      if (input.includes('remember') || input.includes('memorize') || input.includes('memory')) {
        return "Active recall is one of the most effective memory techniques. Try testing yourself on the material rather than just re-reading it. Spaced repetition also helps solidify memories.";
      }
      
      if (input.includes('exam') || input.includes('test') || input.includes('quiz')) {
        return "When preparing for exams, create a study schedule, use practice tests, and focus on understanding concepts rather than memorizing. Would you like specific study strategies for your upcoming test?";
      }
      
      if (input.includes('stress') || input.includes('anxiety') || input.includes('worried')) {
        return "Learning to manage study-related stress is important. Try deep breathing exercises, taking regular breaks, and maintaining perspective. Remember that one test doesn't define your abilities.";
      }
      
      // Generic responses for other queries
      if (input.includes('hello') || input.includes('hi') || input.includes('hey')) {
        return "Hello! I'm your StudyMate AI assistant. How can I help with your studies today?";
      }
      
      if (input.includes('thank')) {
        return "You're welcome! Let me know if you need help with anything else.";
      }
      
      if (input.includes('bye') || input.includes('goodbye')) {
        return "Goodbye! Good luck with your studies. I'll be here when you need help again.";
      }
      
      // Default response
      return "I'm here to help with your academic questions! Could you provide more details about what you're studying or what specific help you need?";
    }

    // Handle session functions
    document.getElementById('startSession').addEventListener('click', () => {
      if (!sessionStarted) {
        sessionStarted = true;
        document.getElementById('statusText').innerText = "Focused";

        // Show a motivational quote when session starts
        showMotivationalQuote();

        // Start timer
        timerInterval = setInterval(() => {
          seconds++;
          document.getElementById('sessionTime').innerText = formatTime(seconds);
        }, 1000);

        // List of motivational/distracted messages
        const idleMessages = [
          "You've been idle for too long! Stay focused.",
          "Don't let distractions win. Get back on track!",
          "Success starts with showing up. Time to refocus!",
          "Every minute counts. Make it matter!",
          "Push a little harder—you're almost there!",
          "Breaks are good, but now it's time to grind!",
          "Your goals need your attention. Let's go!",
          "Distractions are temporary. Stay committed!"
        ];

        // Track idle time (1 min intervals)
        idleInterval = setInterval(() => {
          idleTime++;
          if (idleTime > 2) { // If idle for over 2 minutes, mark as distracted
            distractionTime++;
            document.getElementById('statusText').innerText = "Distracted";

            // Show random notification
            if (Notification.permission === "granted") {
              const randomMessage = idleMessages[Math.floor(Math.random() * idleMessages.length)];
              new Notification(randomMessage);
            }
          }
        }, 60000);

        // Reset idle time on user activity
        document.addEventListener('mousemove', () => {
          idleTime = 0;
          if (sessionStarted) {
            document.getElementById('statusText').innerText = "Focused";
          }
        });

        // Track tab visibility changes (user switches tabs)
        document.addEventListener('visibilitychange', () => {
          if (document.hidden) {
            distractionTime++;
            document.getElementById('statusText').innerText = "Distracted";
            if (Notification.permission === "granted") {
              new Notification("You've switched tabs! Stay focused.");
            }
          } else {
            document.getElementById('statusText').innerText = "Focused";
          }
        });

        // Enable fullscreen when session starts
        openFullscreen();
        blockExit = true;
        window.addEventListener('beforeunload', preventExit);
      }
    });

    document.getElementById('stopSession').addEventListener('click', async () => {
      if (sessionStarted) {
        clearInterval(timerInterval);
        clearInterval(idleInterval);
        closeFullscreen();
        blockExit = false;
        window.removeEventListener('beforeunload', preventExit);

        // Stop any playing music
        if (currentAudio) {
          currentAudio.stop();
          currentAudio = null;
        }

        const sessionData = {
          duration: seconds,
          distractions: distractionTime,
          points: Math.floor(seconds / 60) - distractionTime, // Simple points calculation
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
            alert('Error saving session: ' + (result.message || 'Unknown error.'));
          }
        } catch (err) {
          alert('Network error: ' + err.message);
        }
      }
    });

    // Event Listeners for New Features

    // To-Do List Events
    document.getElementById('toggleTodo').addEventListener('click', () => {
      const panel = document.getElementById('todoPanel');
      panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
      
      // Hide other panels
      document.getElementById('musicPanel').style.display = 'none';
      document.getElementById('plannerPanel').style.display = 'none';
    });

    document.getElementById('closeTodo').addEventListener('click', () => {
      document.getElementById('todoPanel').style.display = 'none';
    });

    document.getElementById('addTodo').addEventListener('click', () => {
      const input = document.getElementById('todoInput');
      const text = input.value.trim();
      if (text) {
        addTodo(text);
        input.value = '';
      }
    });

    document.getElementById('todoInput').addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        const input = document.getElementById('todoInput');
        const text = input.value.trim();
        if (text) {
          addTodo(text);
          input.value = '';
        }
      }
    });

    // Music Events
    document.getElementById('toggleMusic').addEventListener('click', () => {
      const panel = document.getElementById('musicPanel');
      panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
      
      // Hide other panels
      document.getElementById('todoPanel').style.display = 'none';
      document.getElementById('plannerPanel').style.display = 'none';
    });

    document.getElementById('closeMusic').addEventListener('click', () => {
      document.getElementById('musicPanel').style.display = 'none';
    });

    document.getElementById('stopMusic').addEventListener('click', () => {
      if (currentAudio) {
        currentAudio.stop();
        currentAudio = null;
      }
      
      // Remove active class from all music options
      document.querySelectorAll('.music-option').forEach(option => {
        option.classList.remove('active');
        option.querySelector('.play-btn').textContent = 'Play';
      });
    });

    // Music option events
    document.querySelectorAll('.music-option').forEach(option => {
      const playBtn = option.querySelector('.play-btn');
      const type = option.dataset.type;
      
      playBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        
        // Stop current audio if playing
        if (currentAudio) {
          currentAudio.stop();
          currentAudio = null;
        }
        
        // Remove active class from all options
        document.querySelectorAll('.music-option').forEach(opt => {
          opt.classList.remove('active');
          opt.querySelector('.play-btn').textContent = 'Play';
        });
        
        // If this option wasn't active, start playing
        if (!option.classList.contains('active')) {
          generateAmbientSound(type);
          option.classList.add('active');
          playBtn.textContent = 'Stop';
        }
      });
    });

    // Volume control
    document.getElementById('volumeSlider').addEventListener('input', (e) => {
      if (currentAudio && currentAudio.gainNode) {
        const volume = e.target.value / 100;
        currentAudio.gainNode.gain.value = volume * 0.3;
      }
    });

    // Study Plan Events
    document.getElementById('togglePlanner').addEventListener('click', () => {
      const panel = document.getElementById('plannerPanel');
      panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
      
      // Hide other panels
      document.getElementById('todoPanel').style.display = 'none';
      document.getElementById('musicPanel').style.display = 'none';
    });

    document.getElementById('closePlanner').addEventListener('click', () => {
      document.getElementById('plannerPanel').style.display = 'none';
    });

    document.getElementById('generatePlan').addEventListener('click', generateStudyPlan);

    // Chatbot interaction
    document.getElementById('sendMessage').addEventListener('click', () => {
      const userInput = document.getElementById('userInput').value.trim();
      if (userInput) {
        processUserMessage(userInput);
        document.getElementById('userInput').value = '';
      }
    });

    // Allow sending messages with Enter key
    document.getElementById('userInput').addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        const userInput = document.getElementById('userInput').value.trim();
        if (userInput) {
          processUserMessage(userInput);
          document.getElementById('userInput').value = ''; // Clear input field
        }
      }
    });

    // Toggle chatbot visibility
    document.getElementById('toggleChatbot').addEventListener('click', () => {
      const chatbot = document.getElementById('chatbot');
      const toggleBtn = document.getElementById('toggleChatbot');
      
      if (chatVisible) {
        chatbot.style.display = 'none';
        toggleBtn.innerHTML = '💬';
      } else {
        chatbot.style.display = 'flex';
        toggleBtn.innerHTML = '×';
        // Initialize chat if this is first open
        if (document.getElementById('chatbotMessages').children.length === 0) {
          initChatbot();
        }
      }
      
      chatVisible = !chatVisible;
    });

    // Minimize chatbot
    document.getElementById('minimizeChatbot').addEventListener('click', () => {
      document.getElementById('chatbot').style.display = 'none';
      document.getElementById('toggleChatbot').innerHTML = '💬';
      chatVisible = false;
    });

    // Dark mode toggle
    const toggleBtn = document.getElementById('darkModeToggle');

    toggleBtn.addEventListener('click', () => {
      document.documentElement.classList.toggle('dark');

      // Change button text dynamically
      if (document.documentElement.classList.contains('dark')) {
        toggleBtn.textContent = 'Light Theme';
      } else {
        toggleBtn.textContent = 'Dark Theme';
      }
    });

    // Global functions for todo operations (called from HTML)
    window.toggleTodo = toggleTodo;
    window.deleteTodo = deleteTodo;

    // Initialize StudyMate
    showMotivationalQuote();
  </script>
</body>
</html>