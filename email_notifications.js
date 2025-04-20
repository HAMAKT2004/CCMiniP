// Google Apps Script for handling email notifications
function sendLoginNotification(email, username) {
  try {
    const subject = "Login Notification";
    const body = `Hello ${username},\n\nThis email is to notify you that you have successfully logged into your account.\n\nIf this wasn't you, please contact support immediately.\n\nBest regards,\nYour Application Team`;
    
    MailApp.sendEmail(email, subject, body);
    return { status: 'success', message: 'Login notification sent' };
  } catch(error) {
    console.error('Error sending login notification:', error);
    return { status: 'error', message: error.toString() };
  }
}

function sendLogoutNotification(email, username) {
  try {
    const subject = "Logout Notification";
    const body = `Hello ${username},\n\nThis email is to notify you that you have successfully logged out of your account.\n\nBest regards,\nYour Application Team`;
    
    MailApp.sendEmail(email, subject, body);
    return { status: 'success', message: 'Logout notification sent' };
  } catch(error) {
    console.error('Error sending logout notification:', error);
    return { status: 'error', message: error.toString() };
  }
}

// Web app endpoints
function doPost(e) {
  const headers = {
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Methods': 'POST',
    'Access-Control-Allow-Headers': 'Content-Type'
  };
  
  try {
    const data = JSON.parse(e.postData.contents);
    const action = data.action;
    const email = data.email;
    const username = data.username;
    
    let result;
    if (action === 'login') {
      result = sendLoginNotification(email, username);
    } else if (action === 'logout') {
      result = sendLogoutNotification(email, username);
    } else {
      result = { status: 'error', message: 'Invalid action' };
    }
    
    return ContentService.createTextOutput(JSON.stringify(result))
      .setMimeType(ContentService.MimeType.JSON);
      
  } catch(error) {
    const errorResponse = {
      status: 'error',
      message: error.toString()
    };
    return ContentService.createTextOutput(JSON.stringify(errorResponse))
      .setMimeType(ContentService.MimeType.JSON);
  }
}

function doGet(e) {
  return ContentService.createTextOutput(JSON.stringify({
    status: 'error',
    message: 'GET method not supported'
  }))
  .setMimeType(ContentService.MimeType.JSON);
}

// Handle CORS preflight requests
function doOptions(e) {
  const headers = {
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Methods': 'POST',
    'Access-Control-Allow-Headers': 'Content-Type',
    'Access-Control-Max-Age': '3600'
  };
  
  return ContentService.createTextOutput('')
    .setMimeType(ContentService.MimeType.JSON)
    .addHeaders(headers);
}