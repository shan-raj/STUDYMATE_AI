<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyMate AI | Boost Your Focus & Productivity</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        
        .gradient-bg {
            background: linear-gradient(120deg, #4f46e5 0%, #7c3aed 100%);
        }
        
        .wave-shape {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave-shape svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 120px;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .testimonial-card {
            background-image: linear-gradient(45deg, #f0f9ff 0%, #e0f2fe 100%);
        }
        
        .hero-blob {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .cta-gradient {
            background-image: linear-gradient(120deg, #4f46e5 0%, #7c3aed 100%);
        }
    </style>
</head>
<body class="overflow-x-hidden bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 w-full bg-white bg-opacity-90 backdrop-filter backdrop-blur-lg z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="h-12 w-auto" src="logo.png" alt="StudyMate AI Logo">
                        <span class="ml-3 text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">StudyMate AI</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">Features</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">How It Works</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">Testimonials</a>
                    <a href="#pricing" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">Pricing</a>
                </div>
                <div class="flex items-center">
                    <a href="login.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        Log in
                    </a>
                    <a href="register.php" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        Sign up free
                    </a>
                </div>
            </div>
        </div>
        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center absolute right-4 top-4">
            <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-16 md:pb-32 px-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-32 mt-32 hero-blob">
            <svg width="400" height="400" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#8b5cf6" d="M41.6,-68.5C55.4,-60.9,69.1,-52.8,75.8,-40.5C82.5,-28.2,82.2,-11.7,79.8,3.8C77.4,19.4,72.8,33.9,64.4,46.4C56,58.9,43.7,69.4,29.7,74.8C15.7,80.2,-0.1,80.4,-14.5,76.6C-28.9,72.7,-41.9,64.8,-52.1,54.1C-62.2,43.4,-69.6,30,-72.9,15.6C-76.2,1.2,-75.4,-14.2,-70.1,-27.4C-64.8,-40.7,-54.9,-51.7,-42.9,-59.6C-30.9,-67.6,-16.7,-72.4,-1.9,-69.6C12.9,-66.9,27.8,-76.1,41.6,-68.5Z" transform="translate(100 100)" />
            </svg>
        </div>
        
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 left-0 w-72 h-72 bg-blue-300 rounded-full opacity-30 blur-2xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-300 rounded-full opacity-30 blur-2xl animate-pulse"></div>
        </div>
        <div class="relative z-10 flex flex-col items-center justify-center w-full max-w-lg p-8 bg-white bg-opacity-80 rounded-2xl shadow-2xl">
            <div class="mb-6">
            <i class="fa-brands fa-google-scholar"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-blue-700 mb-2 text-center">Welcome to StudyMate AI</h1>
            <p class="text-lg text-gray-700 mb-6 text-center">Your platform for staying focused and improving concentration.</p>
            <nav class="flex justify-center gap-6 mb-6">
                <a href="login.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition duration-200">Login</a>
                <a href="register.php" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition duration-200">Register</a>
            </nav>
            <section class="bg-blue-50 rounded-xl p-6 shadow-inner text-center mb-4">
                <h2 class="text-2xl font-bold text-blue-800 mb-2">Stay Focused with StudyMate AI</h2>
                <p class="text-gray-600">Boost your study sessions with personalized focus tracking. Let StudyMate AI help you stay on track and make the most out of your study time.</p>
            </section>
            <div class="w-full mt-4">
                <h3 class="text-xl font-semibold text-blue-700 mb-2">Features</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-1">
                    <li>Live session tracking and focus timer</li>
                    <li>Distraction monitoring and motivational nudges</li>
                    <li>Session history and progress analytics</li>
                    <li>Personalized badges and rewards</li>
                    <li>Modern, mobile-friendly interface</li>
                </ul>
            </div>
        </div>
        <footer class="relative z-10 mt-10 text-gray-500 text-sm text-center">
            &copy; 2025 StudyMate AI. All rights reserved.
        </footer>
    </section>

    

    <!-- Features Section -->
    <section id="features" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Features</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">Everything you need to excel</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Our platform combines cutting-edge AI technology with proven study methodologies to help you achieve your academic goals.
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <div class="feature-card bg-white rounded-xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="h-12 w-12 rounded-md flex items-center justify-center bg-indigo-100 text-indigo-600">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">Real-time Focus Tracking</h3>
                        <p class="mt-2 text-base text-gray-600">
                            Advanced AI algorithms monitor your attention levels and provide real-time feedback to keep you on track during study sessions.
                        </p>
                    </div>

                    <div class="feature-card bg-white rounded-xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="h-12 w-12 rounded-md flex items-center justify-center bg-purple-100 text-purple-600">
                            <i class="fas fa-brain text-xl"></i>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">Personalized Study Plans</h3>
                        <p class="mt-2 text-base text-gray-600">
                            Get customized study schedules tailored to your learning style, goals, and peak concentration hours.
                        </p>
                    </div>

                    <div class="feature-card bg-white rounded-xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="h-12 w-12 rounded-md flex items-center justify-center bg-blue-100 text-blue-600">
                            <i class="fas fa-bell-slash text-xl"></i>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">Distraction Blocking</h3>
                        <p class="mt-2 text-base text-gray-600">
                            Automatically detect and block digital distractions to maintain deep focus during your critical study times.
                        </p>
                    </div>

                    <div class="feature-card bg-white rounded-xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="h-12 w-12 rounded-md flex items-center justify-center bg-green-100 text-green-600">
                            <i class="fas fa-lightbulb text-xl"></i>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">Smart Break Reminders</h3>
                        <p class="mt-2 text-base text-gray-600">
                            Optimize your study sessions with scientifically-timed breaks to prevent burnout and maximize information retention.
                        </p>
                    </div>

                    <div class="feature-card bg-white rounded-xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="h-12 w-12 rounded-md flex items-center justify-center bg-red-100 text-red-600">
                            <i class="fas fa-chart-pie text-xl"></i>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">Detailed Analytics</h3>
                        <p class="mt-2 text-base text-gray-600">
                            Track your progress with comprehensive reports and insights to continuously improve your study habits.
                        </p>
                    </div>

                    <div class="feature-card bg-white rounded-xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="h-12 w-12 rounded-md flex items-center justify-center bg-yellow-100 text-yellow-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">Study Community</h3>
                        <p class="mt-2 text-base text-gray-600">
                            Connect with like-minded students, join study groups, and share tips and resources to boost motivation.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">How It Works</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">Start improving in three simple steps</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Getting started with StudyMate AI is quick and easy. Here's how you can begin your journey to better focus and productivity.
                </p>
            </div>

            <div class="mt-16">
                <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                    <div class="text-center">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-indigo-100 text-indigo-600 text-2xl font-bold mx-auto">
                            1
                        </div>
                        <h3 class="mt-6 text-xl font-medium text-gray-900">Create an account</h3>
                        <p class="mt-2 text-base text-gray-600">
                            Sign up for free and set up your profile with your study goals, subjects, and schedule preferences.
                        </p>
                    </div>

                    <div class="mt-10 lg:mt-0 text-center">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-indigo-100 text-indigo-600 text-2xl font-bold mx-auto">
                            2
                        </div>
                        <h3 class="mt-6 text-xl font-medium text-gray-900">Install our browser extension</h3>
                        <p class="mt-2 text-base text-gray-600">
                            Add our lightweight extension to enable focus tracking and distraction blocking during your study sessions.
                        </p>
                    </div>

                    <div class="mt-10 lg:mt-0 text-center">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-indigo-100 text-indigo-600 text-2xl font-bold mx-auto">
                            3
                        </div>
                        <h3 class="mt-6 text-xl font-medium text-gray-900">Start studying smarter</h3>
                        <p class="mt-2 text-base text-gray-600">
                            Begin your first AI-powered study session and watch your productivity and focus improve immediately.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="mt-16 bg-white rounded-xl overflow-hidden shadow-xl">
                <div class="px-6 py-8 sm:p-10">
                    <div class="aspect-w-16 aspect-h-9">
                        <img class="object-cover rounded-lg" src="/api/placeholder/1024/576" alt="StudyMate AI Demo">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button class="h-20 w-20 rounded-full bg-indigo-600 bg-opacity-75 flex items-center justify-center">
                                <i class="fas fa-play text-white text-2xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Pricing Section -->
    <section id="pricing" class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Pricing</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">Simple, transparent pricing</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Choose the plan that fits your needs. All plans include our core focus-enhancing features.
                </p>
            </div>
            <div class="mt-16 flex justify-center">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="p-8">
                            <h3 class="text-xl font-medium text-gray-900">Free</h3>
                            <p class="mt-4 text-gray-600">Perfect for casual students</p>
                            <p class="mt-8">
                                <span class="text-4xl font-extrabold text-gray-900">$0</span>
                                <span class="text-base font-medium text-gray-500">/month</span>
                            </p>
                            <div class="mt-8">
                                <ul class="space-y-4">
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">Basic focus tracking</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">5 study sessions per week</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">Community support</p>
                                    </li>
                                </ul>
                            </div>
                            <a href="register.php" class="mt-8 block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">Get Started</a>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-4 border-indigo-600">
                        <div class="p-8">
                            <h3 class="text-xl font-medium text-gray-900">Pro</h3>
                            <p class="mt-4 text-gray-600">For serious learners</p>
                            <p class="mt-8">
                                <span class="text-4xl font-extrabold text-gray-900">$9</span>
                                <span class="text-base font-medium text-gray-500">/month</span>
                            </p>
                            <div class="mt-8">
                                <ul class="space-y-4">
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">Unlimited sessions</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">Advanced analytics</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">Priority support</p>
                                    </li>
                                </ul>
                            </div>
                            <a href="register.php" class="mt-8 block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">Upgrade Now</a>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="p-8">
                            <h3 class="text-xl font-medium text-gray-900">Team</h3>
                            <p class="mt-4 text-gray-600">For study groups & schools</p>
                            <p class="mt-8">
                                <span class="text-4xl font-extrabold text-gray-900">$29</span>
                                <span class="text-base font-medium text-gray-500">/month</span>
                            </p>
                            <div class="mt-8">
                                <ul class="space-y-4">
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">All Pro features</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">Team analytics dashboard</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">Dedicated account manager</p>
                                    </li>
                                </ul>
                            </div>
                            <a href="register.php" class="mt-8 block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">Contact Sales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-white border-t border-gray-200 py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center space-x-2">
            <i class="fa-google-scholar"></i>
                <span class="text-gray-700 font-semibold">StudyMate AI</span>
            </div>
            <div class="mt-4 md:mt-0 text-gray-500 text-sm">
                &copy; 2025 StudyMate AI. All rights reserved.
            </div>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-indigo-600"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-gray-400 hover:text-indigo-600"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-gray-400 hover:text-indigo-600"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>