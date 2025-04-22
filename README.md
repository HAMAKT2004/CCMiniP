# 🌦️ WeatherWise: Your Personal Weather Tracking Dashboard

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.4-8892BF?style=flat-square&logo=php)](https://www.php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](https://opensource.org/licenses/MIT)
[![Made With](https://img.shields.io/badge/Made%20with-Love%20%26%20PHP-red?style=flat-square)]()

WeatherWise is a dynamic web application designed to provide users with comprehensive weather information, coupled with a secure authentication system and personalized tracking features. Sign up, log in, explore real-time weather, forecasts, detailed insights, and even interact with an AI weather assistant, all while keeping track of your activity.

---

## ✨ Key Features

*   🔐 **Secure User Authentication:** Robust signup/login with password hashing and session management.
*   📧 **Email Notifications:** Get notified via email on successful login/logout events (powered by Google Apps Script).
*   ☀️ **Real-Time Weather:** Access current weather conditions for any city worldwide using the WeatherAPI.
*   📊 **Detailed Weather Insights:** View comprehensive data including temperature, feels-like, wind, pressure, humidity, visibility, UV index, wind chill, heat index, and dew point.
*   📅 **Forecast Data:** Get a 3-day weather forecast including daily summaries and hourly breakdowns.
*   🌙 **Astronomy Info:** Check sunrise, sunset, moonrise, moonset, moon phase, and illumination.
*   🔎 **Search History:** Keep track of your recent weather searches for quick access.
*   🤖 **AI Weather Assistant:** Interact with a Gemini-powered chatbot for weather-related questions.
*   📜 **Login History:** Review your past login and logout times.
*   🎨 **Theme Toggle:** Switch between slick Light and Dark modes.
*   📱 **Responsive Design:** Works seamlessly on desktop and mobile devices.

---

## 🖼️ Screenshots (Placeholder)

*Add screenshots here to showcase the application's interface.*

<!--
<p align="center">
  <img src="path/to/screenshot1.png" width="45%" alt="Login Screen">
     
  <img src="path/to/screenshot2.png" width="45%" alt="Dashboard">
</p>
<p align="center">
  <img src="path/to/screenshot3.png" width="45%" alt="Detailed Weather">
     
  <img src="path/to/screenshot4.png" width="45%" alt="Chatbot">
</p>
-->

---

## 🛠️ Tech Stack

*   **Backend:** PHP (>= 7.4)
*   **Frontend:** HTML5, CSS3, JavaScript (ES6+)
*   **Data Storage:** JSON (Flat-file database)
*   **APIs:**
    *   [WeatherAPI.com](https://www.weatherapi.com/) (Weather Data)
    *   [Google Apps Script](https://developers.google.com/apps-script) (Email Notifications)
    *   [Google Gemini API](https://ai.google.dev/) (Chatbot)
*   **Styling:** Custom CSS, Google Fonts (Poppins)
*   **Icons:** FontAwesome

---

## 📂 Project Structure
/
├── database.json # User, login history, and weather history storage
├── email_notifications.js # Google Apps Script for email (deploy separately)
├── get_weather_history.php # API endpoint to retrieve user's weather history
├── index.php # Login page / Entry point
├── landing.html # Main dashboard template (rendered by landing.php)
├── landing.php # Dashboard logic and rendering
├── login.php # Handles login form submission
├── process_logout.php # Handles user logout
├── save_weather.php # API endpoint to save weather search data
├── signup.php # Handles user registration form submission
├── styles.css # Main stylesheet
└── README.md # This file
.
└── .gitignore # Git ignore configuration

---

## 🚀 Setup & Installation

1.  **Prerequisites:**
    *   Web Server (Apache, Nginx, etc.) with PHP >= 7.4 installed.
    *   PHP JSON extension enabled (usually enabled by default).
    *   Composer (recommended for potential future dependencies, though none currently required by `vendor`).

2.  **Clone the Repository:**
    ```bash
    git clone https://github.com/your-username/WeatherWise.git # Replace with your repo URL
    cd WeatherWise
    ```

3.  **Permissions:**
    *   Ensure your web server has **write permissions** for the `database.json` file. This is crucial for registration, login tracking, and saving weather history.
    ```bash
    # Example (adjust user/group as needed, e.g., www-data, apache)
    sudo chown www-data:www-data database.json
    sudo chmod 664 database.json
    ```

4.  **API Keys & Configuration:**
    *   **WeatherAPI:** Sign up at [WeatherAPI.com](https://www.weatherapi.com/) to get a free API key. Replace the placeholder `'f878330c730d40abafd183919250704'` in `landing.html` with your actual key.
    *   **Google Gemini API:** Get an API key from [Google AI Studio](https://aistudio.google.com/app/apikey). Replace the placeholder `'AIzaSyBAIUB5w8Bn9llRVCq9NKgyXsej0KQUtbQ'` in `landing.html` with your key.
    *   **Google Apps Script (Email):**
        *   Copy the code from `email_notifications.js` into a new Google Apps Script project ([script.google.com](https://script.google.com)).
        *   Deploy the script as a Web App. **Important:** Set "Who has access" to "Anyone" (or "Anyone, even anonymous" depending on the GAS version) to allow your PHP script to call it.
        *   Authorize the script to send emails on your behalf.
        *   **Copy the deployed Web App URL.** You will need to modify the PHP code (likely in `login.php` and `process_logout.php`, although the calling part isn't shown in the provided files) to send POST requests to this URL when login/logout occurs.

    *   **(Security Note):** Storing API keys directly in client-side HTML/JS (`landing.html`) is **highly insecure** for production environments. Ideally, these keys should be stored securely on the server (e.g., environment variables, `.env` file - which *is* in your `.gitignore`) and accessed via PHP. The PHP backend should then make the API calls.

5.  **Access the Application:**
    *   Navigate to the project directory in your web browser (e.g., `http://localhost/WeatherWise/`).

---

## 💡 Usage

1.  Navigate to the application URL. You'll be directed to the login page (`index.php`).
2.  If you don't have an account, click the "Sign Up" link.
3.  Register using a username, email, and password.
4.  Log in with your newly created credentials.
5.  You'll land on the dashboard (`landing.php`).
6.  Use the **Weather** tab to search for cities and view current conditions and search history.
7.  Explore the **Detailed Weather** tab for forecasts, astronomy, and hourly breakdowns.
8.  Check your **Login History** in the corresponding tab.
9.  Learn about the project and developers in the **About** tab.
10. Use the floating **Chatbot** button to ask the AI assistant weather-related questions.
11. Toggle the **Dark/Light Theme** using the moon/sun icon.
12. **Logout** using the button in the header.

---

## 🔒 Security Considerations

*   **Password Hashing:** User passwords are securely hashed using PHP's `password_hash()` (likely BCRYPT algorithm, based on the hash format in `database.json`).
*   **Session Management:** PHP sessions are used to maintain user login state.
*   **API Key Security:** As noted in Setup, API keys in the provided `landing.html` are exposed client-side. **This is a security risk.** Implement server-side handling for API keys in a real-world application.
*   **Data Storage:** Using a JSON file for data is simple but less secure and performant than a traditional database for larger applications or sensitive data. File permissions are critical.
*   **Input Sanitization:** (Assumption) Ensure all user inputs (signup, login, city search) are properly validated and sanitized server-side to prevent XSS and other injection attacks.

---

## 💾 Data Storage

This application uses a simple flat-file approach for data persistence, storing all user information, login history, and weather search history within the `database.json` file.

*   **Pros:** Simplicity, no database server required.
*   **Cons:** Not suitable for high concurrency, potential performance issues with large amounts of data, requires careful file permission management for security.

---

## 🤝 Contributing

Contributions are welcome! If you'd like to improve WeatherWise:

1.  Fork the repository.
2.  Create a new branch (`git checkout -b feature/YourFeatureName`).
3.  Make your changes.
4.  Commit your changes (`git commit -m 'Add some feature'`).
5.  Push to the branch (`git push origin feature/YourFeatureName`).
6.  Open a Pull Request.

Please ensure your code adheres to basic PHP best practices and includes comments where necessary.

---

## 🧑‍💻 Developers

*   Harsh Amrute
*   Ayush Bhosale
*   Peter Bose
*   Bryson D'Souza

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file (or the badge link) for details.

---

## #️⃣ Tags

`php` `weather-app` `user-authentication` `weather-api` `json-database` `javascript` `css` `html` `dark-theme` `light-theme` `chatbot` `google-gemini` `google-apps-script` `forecast` `login-history` `php-sessions` `password-hashing`
