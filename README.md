# Weather Tracking and Attendance Notification System

A cloud-integrated, full-stack PHP web application providing secure user authentication, personalized weather tracking, and real-time attendance notifications. This project synergizes modern web development practices with cloud services, delivering a scalable and efficient solution for weather information and user activity tracking. Users can securely register, log in, track weather conditions, and receive notifications for their login and logout activities.

## Cloud Computing Overview

This project showcases the integration of cloud-based technologies to create an attendance tracking system and weather data platform, enhanced with real-time email notifications. The key architectural elements are outlined below:

### Key Workflow Overview:

**User Authentication System (Core Component)**

- Upon visiting the site, users are prompted to either log in or sign up.
- **Sign Up:** Users input a username, email address, and password. This information is securely stored in the Azure-hosted SQL database, employing best practices for data security.
- **Log In:** Registered users can log in using their credentials, with secure session management implemented.

**Database Integration (Azure SQL Database)**

- **Service Type:** DBaaS (Database as a Service)
- The Azure SQL Database securely stores:
    - User credentials (passwords are securely hashed).
    - Login and logout history with timestamps.
    - Weather search history (cities searched by the user).
- All data interactions are dynamic, ensuring persistence and security across user sessions.

**Landing Page (Main Dashboard)**

- Upon successful authentication, users are directed to the Landing Page, which features:
    - **Weather Data:** Comprehensive weather conditions including temperature, humidity, pressure, wind speed, sunrise/sunset times, moon phases, and other astronomy data for any specified city.
    - **Weather Search History:** A dynamically updated list of the user's past weather searches, retrieved from the cloud database.
    - **Login History:** A detailed log of the user's login and logout activities, including exact timestamps for auditing and tracking.
    - **About Us Section:** General information about the project and the development team.

**Email Notifications (Serverless Architecture)**

- An email notification is triggered each time a user logs in or logs out, providing a summary of their login status.
- This functionality is powered by Google Apps Script, acting as a serverless function for sending email notifications.
- **Service Type:** FaaS (Function as a Service)
- Google Apps Script processes incoming triggers and sends notifications via SMTP or a chosen email service.

**Containerization with Docker**

- The project is containerized using Docker, ensuring seamless execution across diverse systems by eliminating configuration issues and enhancing portability.
- **Cloud Compatibility:** The Docker container can be deployed on IaaS platforms like Azure Virtual Machines or AWS EC2, facilitating scalability and management.
- The Docker container encapsulates the complete application environment, including the web server, PHP, and necessary libraries, guaranteeing consistency across all environments.

**Cloud Hosting on Azure (PaaS)**

- The application is hosted on Microsoft Azure, leveraging PaaS (Platform as a Service) for simplified management and enhanced scalability.
- Azure's PaaS services handle application deployment, scaling, and load balancing, ensuring high availability and optimal performance for users.
- Azure SQL Database is utilized for persistent and secure storage of user data with robust access control.

## Key Features

**1. User Authentication and Account Management**

- **Signup Process:** New users register by providing their username, email, and password. Passwords are securely hashed using PHP's `password_hash()` before storage in the database.
- **Login Process:** Registered users log in with their credentials. Successful logins initiate secure session creation, allowing users to remain logged in until they explicitly log out.
- **Login and Logout History:** The system meticulously records the exact timestamp of every login and logout action, visible to the user on the landing page for tracking purposes.
- **Secure Password Storage:** Passwords are stored using PHP's `password_hash()` to ensure robust security even in the event of a database breach.

**2. Weather Information**

- **Real-time Weather Data:** Users can search for weather information for any city. The application retrieves current weather details, including temperature, humidity, pressure, wind speed, and other pertinent data from a weather API.
- **3-Day Forecast:** Beyond real-time data, the system provides a 3-day weather forecast and hourly breakdowns to assist users in planning their activities effectively.
- **Astronomy Data:** The application also presents astronomy data such as sunrise and sunset times, moon phases, and other celestial events for the searched city.
- **Personalized Weather History:** The system maintains a record of the cities each user has searched for, displaying this history for easy access.

**3. Email Notifications (Serverless Functionality)**

- **Login/Logout Notifications:** Upon each login or logout action, an automated email notification is sent to the user, summarizing their activity.
- **Serverless Email Handler:** This notification service is powered by Google Apps Script, a serverless function that processes requests from the website and dispatches the appropriate notification email.

**4. User Interface**

- **Responsive Design:** The application's UI is fully responsive, ensuring an optimal viewing and interaction experience across various devices, including desktops, tablets, and smartphones.
- **Light/Dark Theme Support:** Users can switch between light and dark themes according to their personal preference.
- **Interactive History Table:** Weather and login history are presented in interactive tables, facilitating easy review of past activities and searches.
- **FontAwesome Icons:** The UI incorporates FontAwesome icons to enhance user experience and provide intuitive navigation.

## Technology Stack

**Backend**

- **PHP:** Handles server-side logic, user authentication, and database interactions.
- **Docker:** Containerizes the application for consistent deployment across different environments.

**Frontend**

- **HTML5/CSS3:** Creates a responsive and clean user interface.
- **JavaScript:** Implements dynamic features such as theme switching and interactive tables.

**Cloud Services**

- **Azure SQL Database (DBaaS):** Stores user information, login history, and weather search history.
- **Google Apps Script (FaaS):** Manages email notifications triggered by user login/logout actions.

**APIs**

- **Weather API:** Fetches real-time weather data and forecasts.

**Containerization & Deployment**

- **Docker:** Ensures consistent deployment across various environments.
- **Azure:** Hosts the application, providing scalability and high availability.

## Project Structure


php_login_system/
├── get_weather_history.php   # Retrieves weather data and user history
├── index.php                 # Entry point (Login page)
├── landing.html              # Main dashboard UI with weather and history
├── landing.php               # Handles weather data and history retrieval
├── login.php                 # Handles user login functionality
├── process_landing.php       # Processes user requests on the dashboard
├── process_logout.php        # Handles user logout and triggers email
├── save_weather.php          # Saves user weather search data
├── signup.php                # New user registration and validation
└── styles.css                # Styling for the UI

## Setup Instructions

**Prerequisites**

- PHP 7.x or higher
- Web server (Apache or Nginx)
- Docker (for containerization)
- Configured and accessible Azure SQL Database
- Linked Google Apps Script for email functionality

**Installation**

1. Clone or download the repository to your local machine.
2. Configure the Azure SQL Database connection strings in the PHP files.
3. Set up Google Apps Script to handle email notifications.
4. Use Docker to build the container and deploy on local environments or cloud platforms.
5. Deploy the project on Microsoft Azure for scalable hosting.

**Configuration**

- Add the Weather API key in the appropriate section of `landing.html`.
- Ensure your Google Apps Script endpoint is correctly configured to trigger email notifications.

## How to Use

- **Register:** Navigate to `signup.php`, enter your details, and create an account.
- **Log In:** Use your registered credentials to log in to the application.
- **Weather Search:** Enter the name of any city to retrieve live weather information and forecasts.
- **View History:** Access your past weather searches and login/logout history.
- **Toggle Themes:** Switch between light and dark themes based on your preference.
- **Logout:** Log out of the application to end your session and receive an email notification about your logout activity.

## Contributors

- Harsh Amrute
- Ayush Bhosale
- Peter Bose
- Bryson D'Souza

## Security Features

- **Password Security:** Passwords are securely hashed using `password_hash()` to prevent unauthorized access.
- **Session Management:** User sessions are securely maintained, ensuring only authenticated users can access the platform.
- **Data Validation:** Input data is rigorously validated and sanitized to prevent injection and other security vulnerabilities.
- **Email Notifications:** Login and logout events are securely handled, with notifications sent via Google Apps Script to ensure real-time tracking and communication of user activity.

## Future Enhancements

- Password Reset Functionality: Implement a feature for users to reset forgotten passwords.
- Email Verification: Add email verification during signup to ensure legitimate registrations.
- Advanced Forecasts: Provide extended weather forecasts and additional city-specific data.
- Location-Based Weather: Automatically detect the user's location and display weather data for their current city.
- Weather History Export: Allow users to download their weather search history in a CSV format.

