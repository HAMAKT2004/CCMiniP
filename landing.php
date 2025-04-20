<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    $logout_time = date('Y-m-d H:i:s');
    $database = json_decode(file_get_contents('database.json'), true);
    
    // Update user's last logout time
    foreach ($database['users'] as &$user) {
        if ($user['username'] === $_SESSION['username']) {
            $user['last_logout'] = $logout_time;
            break;
        }
    }
    
    file_put_contents('database.json', json_encode($database, JSON_PRETTY_PRINT));
    
    session_destroy();
    header("Location: login.php");
    exit();
}

// Get user's login history
$database = json_decode(file_get_contents('database.json'), true);
$login_history = [];

foreach ($database['users'] as $user) {
    if ($user['username'] === $_SESSION['username']) {
        if (isset($user['login_history'])) {
            $login_history = $user['login_history'];
        }
        break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            padding: 40px;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 600;
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes slideInDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .login-history {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            animation: fadeIn 0.5s ease-out 0.2s backwards;
        }

        .login-history th, .login-history td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .login-history th {
            font-weight: 600;
        }

        .login-history tr:hover {
            transition: background-color 0.3s ease;
        }

        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--danger-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px var(--shadow-color);
        }

        .logout-btn:hover {
            background-color: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px var(--shadow-color);
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
            
            .login-history {
                font-size: 0.9em;
            }
            
            .login-history th, .login-history td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-moon"></i>
    </button>
    
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        
        <h3>Login History</h3>
        <table class="login-history">
            <thead>
                <tr>
                    <th>Login Time</th>
                    <th>Logout Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($login_history as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['login_time']); ?></td>
                        <td><?php echo htmlspecialchars($entry['logout_time'] ?? 'Still logged in'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="process_logout.php" class="logout-btn">Logout</a>
    </div>

    <script>
        // Theme toggle functionality
        function toggleTheme() {
            const body = document.body;
            const themeToggle = document.querySelector('.theme-toggle i');
            
            if (body.getAttribute('data-theme') === 'dark') {
                body.removeAttribute('data-theme');
                themeToggle.classList.remove('fa-sun');
                themeToggle.classList.add('fa-moon');
                localStorage.setItem('theme', 'light');
            } else {
                body.setAttribute('data-theme', 'dark');
                themeToggle.classList.remove('fa-moon');
                themeToggle.classList.add('fa-sun');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Check for saved theme preference
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            const themeToggle = document.querySelector('.theme-toggle i');
            
            if (savedTheme === 'dark') {
                document.body.setAttribute('data-theme', 'dark');
                themeToggle.classList.remove('fa-moon');
                themeToggle.classList.add('fa-sun');
            }
        });
    </script>
</body>
</html>