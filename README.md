# Weather Tracking System with User Authentication

A PHP-based web application that combines user authentication with weather tracking functionality. Users can sign up, log in, and track weather information for different locations while maintaining their search history.

## Features

- **User Authentication System**
  - Secure signup and login
  - Password hashing for security
  - Login history tracking
  - Session management

- **Weather Functionality**
  - Real-time weather data
  - 3-day forecast and hourly predictions
  - Astronomy information
  - User-specific weather search history
  - Weather AI Assistant chatbot

- **UI Features**
  - Dark/Light theme support
  - Responsive design
  - Modern interface with FontAwesome icons
  - Interactive weather history table

## Technologies Used

- PHP
- HTML5
- CSS3
- JavaScript
- JSON (for data storage)
- Weather API Integration
- FontAwesome Icons
- Google Fonts (Poppins)

## Project Structure

```
php_login_system/
├── database.json           # User and weather data storage
├── get_weather_history.php # Retrieves user's weather history
├── index.php              # Entry point
├── landing.html           # Main dashboard template
├── landing.php           # Dashboard logic
├── login.php             # Login functionality
├── process_landing.php   # Processes dashboard actions
├── process_logout.php    # Handles logout
├── save_weather.php      # Saves weather data
├── signup.php            # User registration
└── styles.css           # Stylesheet
```

## Setup Instructions

1. **Server Requirements**
   - PHP 7.x or higher
   - Web server (Apache/Nginx)
   - JSON extension enabled

2. **Installation**
   - Clone or download the repository
   - Place the files in your web server's directory
   - Ensure write permissions for `database.json`

3. **Configuration**
   - No database setup required (uses JSON file storage)
   - Weather API key configuration in landing.html

## Usage

1. Register a new account via signup.php
2. Log in with your credentials
3. Search for weather information by city name
4. View your weather search history
5. Toggle between dark/light themes
6. Use the AI chatbot for weather-related queries
7. View your login history

## Developers

- Harsh Amrute
- Ayush Bhosale
- Peter Bose
- Bryson D'Souza

## Security Features

- Password hashing using PHP's password_hash()
- Session-based authentication
- Input validation and sanitization
- Secure logout handling

## Data Storage

The application uses a JSON file (`database.json`) to store:
- User credentials (hashed passwords)
- Login history
- Weather search history
- User preferences

## Notes

- The weather history is limited to the last 100 searches per user
- All times are stored in IST (Indian Standard Time)
- The application includes both dark and light themes for user preference

## Future Enhancements

- Email verification system
- Password reset functionality
- Extended weather forecasts
- Location-based automatic weather updates
- Export functionality for weather history