<?php
session_start();

// Use default user ID = 1 if not logged in
$user_id = $_SESSION['user_id'] ?? 6;

require_once 'db_config.php'; // Include your database configuration file
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Function to format badges with icons and colors
function formatBadges($badges) {
    if (empty($badges) || $badges === 'None') {
        return '<span class="text-gray-400 italic">No badges</span>';
    }
    
    $badgeArray = explode(',', $badges);
    $formattedBadges = '';
    
    foreach ($badgeArray as $badge) {
        $badge = trim($badge);
        $badgeHtml = getBadgeHtml($badge);
        $formattedBadges .= $badgeHtml . ' ';
    }
    
    return $formattedBadges;
}

// Function to get badge HTML with appropriate styling
function getBadgeHtml($badge) {
    $badgeData = [
        'Focus Master' => ['icon' => 'fas fa-bullseye', 'color' => 'bg-yellow-500', 'text' => 'text-white'],
        'Time Warrior' => ['icon' => 'fas fa-clock', 'color' => 'bg-blue-500', 'text' => 'text-white'],
        'Streak King' => ['icon' => 'fas fa-fire', 'color' => 'bg-red-500', 'text' => 'text-white'],
        'Productivity Pro' => ['icon' => 'fas fa-chart-line', 'color' => 'bg-green-500', 'text' => 'text-white'],
        'Consistency Champion' => ['icon' => 'fas fa-medal', 'color' => 'bg-purple-500', 'text' => 'text-white'],
        'Early Bird' => ['icon' => 'fas fa-sun', 'color' => 'bg-orange-500', 'text' => 'text-white'],
        'Night Owl' => ['icon' => 'fas fa-moon', 'color' => 'bg-indigo-500', 'text' => 'text-white'],
        'Milestone Maker' => ['icon' => 'fas fa-trophy', 'color' => 'bg-gold-500', 'text' => 'text-black'],
        'Distraction Destroyer' => ['icon' => 'fas fa-shield-alt', 'color' => 'bg-teal-500', 'text' => 'text-white'],
        'Session Starter' => ['icon' => 'fas fa-play', 'color' => 'bg-pink-500', 'text' => 'text-white']
    ];
    
    if (isset($badgeData[$badge])) {
        $data = $badgeData[$badge];
        return sprintf(
            '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium %s %s mr-1 mb-1" title="%s">
                <i class="%s mr-1"></i>%s
            </span>',
            $data['color'],
            $data['text'],
            $badge,
            $data['icon'],
            $badge
        );
    } else {
        // Default badge style for unknown badges
        return sprintf(
            '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-500 text-white mr-1 mb-1" title="%s">
                <i class="fas fa-star mr-1"></i>%s
            </span>',
            $badge,
            $badge
        );
    }
}

$result = $conn->query("SELECT * FROM session_logs WHERE user_id = $user_id ORDER BY session_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Session History | StudyMate AI</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; }
    .bg-gold-500 { background-color: #ffd700; }
    
    /* Custom scrollbar for badges */
    .badge-container::-webkit-scrollbar {
      height: 4px;
    }
    .badge-container::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    .badge-container::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 10px;
    }
    .badge-container::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
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
        <a href="dashboard.php" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">Dashboard</a>
        <a href="index.php" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">Home</a>
        <a href="login.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-200">Logout</a>
      </div>
    </div>
  </nav>
  
  <div class="relative z-10 flex flex-col items-center w-full max-w-5xl p-8 bg-white bg-opacity-90 rounded-2xl shadow-2xl mt-24 mb-10">
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">
      <i class="fas fa-history mr-2"></i>Your Focus Session History
    </h2>
    
    <!-- Badge Legend -->
    <div class="w-full mb-6 p-4 bg-blue-50 rounded-lg">
      <h3 class="text-lg font-semibold text-blue-800 mb-3">
        <i class="fas fa-info-circle mr-2"></i>Badge Legend
      </h3>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2 text-sm">
        <div class="flex items-center">
          <i class="fas fa-bullseye text-yellow-500 mr-2"></i>
          <span>Focus Master</span>
        </div>
        <div class="flex items-center">
          <i class="fas fa-clock text-blue-500 mr-2"></i>
          <span>Time Warrior</span>
        </div>
        <div class="flex items-center">
          <i class="fas fa-fire text-red-500 mr-2"></i>
          <span>Streak King</span>
        </div>
        <div class="flex items-center">
          <i class="fas fa-chart-line text-green-500 mr-2"></i>
          <span>Productivity Pro</span>
        </div>
        <div class="flex items-center">
          <i class="fas fa-medal text-purple-500 mr-2"></i>
          <span>Consistency Champion</span>
        </div>
      </div>
    </div>
    
    <div class="overflow-x-auto w-full">
      <table class="min-w-full bg-white rounded-xl overflow-hidden shadow text-center">
        <thead class="bg-gradient-to-r from-blue-100 to-purple-100">
          <tr>
            <th class="py-3 px-4 text-blue-800 font-semibold">
              <i class="fas fa-calendar-alt mr-2"></i>Date
            </th>
            <th class="py-3 px-4 text-blue-800 font-semibold">
              <i class="fas fa-clock mr-2"></i>Duration (mins)
            </th>
            <th class="py-3 px-4 text-blue-800 font-semibold">
              <i class="fas fa-exclamation-triangle mr-2"></i>Distraction Time (mins)
            </th>
            <th class="py-3 px-4 text-blue-800 font-semibold">
              <i class="fas fa-star mr-2"></i>Points
            </th>
            <th class="py-3 px-4 text-blue-800 font-semibold">
              <i class="fas fa-award mr-2"></i>Badges Earned
            </th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors border-b border-blue-100">
                <td class="py-3 px-4 font-medium text-gray-700">
                  <?= date('M j, Y', strtotime($row['session_date'])) ?>
                </td>
                <td class="py-3 px-4">
                  <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <?= floor($row['duration'] / 60) ?> min
                  </span>
                </td>
                <td class="py-3 px-4">
                  <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium 
                    <?= $row['distractions'] == 0 ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' ?>">
                    <?= $row['distractions'] ?> min
                  </span>
                </td>
                <td class="py-3 px-4">
                  <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                    <i class="fas fa-coins mr-1"></i><?= $row['points'] ?>
                  </span>
                </td>
                <td class="py-3 px-4">
                  <div class="flex flex-wrap justify-center max-w-xs mx-auto">
                    <?= formatBadges($row['badges']) ?>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="py-8 text-center">
                <div class="flex flex-col items-center text-gray-500">
                  <i class="fas fa-clipboard-list text-4xl mb-2 opacity-50"></i>
                  <p class="text-lg">No session history found.</p>
                  <p class="text-sm">Start your first focus session to see your progress here!</p>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    
    <!-- Summary Stats -->
    <?php if ($result && $result->num_rows > 0): ?>
      <?php
      // Reset result pointer and calculate stats
      $result->data_seek(0);
      $totalSessions = $result->num_rows;
      $totalPoints = 0;
      $totalDuration = 0;
      $totalDistractions = 0;
      $allBadges = [];
      
      while($row = $result->fetch_assoc()) {
        $totalPoints += $row['points'];
        $totalDuration += $row['duration'];
        $totalDistractions += $row['distractions'];
        if (!empty($row['badges']) && $row['badges'] !== 'None') {
          $badges = explode(',', $row['badges']);
          foreach ($badges as $badge) {
            $badge = trim($badge);
            if (!empty($badge)) {
              $allBadges[] = $badge;
            }
          }
        }
      }
      
      $uniqueBadges = array_unique($allBadges);
      $avgSessionTime = $totalSessions > 0 ? round($totalDuration / 60 / $totalSessions) : 0;
      ?>
      
      <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4 w-full">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 rounded-lg text-center">
          <i class="fas fa-list-ol text-2xl mb-2"></i>
          <div class="text-2xl font-bold"><?= $totalSessions ?></div>
          <div class="text-sm opacity-90">Total Sessions</div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-teal-600 text-white p-4 rounded-lg text-center">
          <i class="fas fa-coins text-2xl mb-2"></i>
          <div class="text-2xl font-bold"><?= number_format($totalPoints) ?></div>
          <div class="text-sm opacity-90">Total Points</div>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-red-600 text-white p-4 rounded-lg text-center">
          <i class="fas fa-clock text-2xl mb-2"></i>
          <div class="text-2xl font-bold"><?= $avgSessionTime ?></div>
          <div class="text-sm opacity-90">Avg Session (min)</div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-pink-600 text-white p-4 rounded-lg text-center">
          <i class="fas fa-award text-2xl mb-2"></i>
          <div class="text-2xl font-bold"><?= count($uniqueBadges) ?></div>
          <div class="text-sm opacity-90">Unique Badges</div>
        </div>
      </div>
    <?php endif; ?>
    
    <a href="dashboard.php" class="mt-8 inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-lg transform hover:scale-105">
      <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
    </a>
  </div>
  
  <footer class="relative z-10 mt-10 text-gray-500 text-sm text-center">
    &copy; 2025 StudyMate AI. All rights reserved.
  </footer>
</body>
</html>