<?php session_start(); ?>

<!DOCTYPE html>
<html lang = 'en'>
  <head>
    <meta charset="UTF-8">
    <title>Calendar</title>
    <!-- <script src = "provided_API.mjs" type="module"></script> -->
    <link rel="stylesheet" type = "text/css" href="calendar_stylesheet.css"/>
    <script src = "calendar_functions.js" type ="text/javascript"></script>
    <script type = 'text/javascript' src = 'ajax_scripts.js'></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

  </head>

  <body>
  <div id = 'login'>
      <input type = 'text' id = "username" placeholder = 'Username'/>
      <input type = 'password' id = "password" placeholder = 'Password'/>
      <button id = 'login_button'>Log In</button>
      <div id = 'login_error'></div>
    </div>
    <div id = 'logout' style = "display:none">
      <button id = 'logout_button'>Log Out</button>
    </div>
    <button id = 'signup_button'>Sign Up</button>
    <div id = 'signup' style = "display:none">
      <input type = 'text' id = 'first_name' placeholder = 'First Name'/>
      <input type = 'text' id = 'last_name' placeholder = 'Last Name'/>
      <input type = 'text' id = 'new_username' placeholder = 'Username'/>
      <input type = 'password' id = 'new_password' placeholder = 'Password'/>
      <input type = 'password' id = 'confirm_password' placeholder = 'Confirm Password'/>
      <button id = 'register_user'>Register</button><br>
      <div id = 'su_error'> </div>
      <button id = 'return_to_login'> Return to Login</button>
    </div>
    <div id = 'tags' style = "display:none">
    <br>
      <input type = 'checkbox' name = 'school_tag' value = 'School'>School Events<br>
      <input type = 'checkbox' name = 'extracurriculars_tag' value = 'Extracurriculars'>Extracurricular Events<br>
      <input type = 'checkbox' name = 'social_tag' value = 'Social'>Social Events<br>
    </div>
  <div class = "calendar">
    <h1 id = "month-label"></h1>
    <table>
        <tr id = "label">
        <th>Sunday</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
        </tr>

        <tr id = "week0"></tr>
        <tr id = "week1"></tr>
        <tr id = "week2"></tr>
        <tr id = "week3"></tr>
        <tr id = "week4"></tr>
        <tr id = "week5"></tr>


    </table>
    <button id="prev-month">Previous Month </button>
    <button id="next-month">Next Month</button>
  </div>


  <button class = "open-button" id="add-event" >Add Event</button>

  <div class="form-popup" id="myForm">
    <form class="form-container">
      <h1>Create Event</h1>
      <table class = "no-border">
          <tbody>
          <tr>
          <td>
          <label for="eventName"><b>Event Name</b></label>
          </td>

          <td>
          <input id = 'event_name' type="text" placeholder="Enter Event Name" name="event" required>
          </td>
        </tr>

          <tr>
              <td>
          <label for="date"><b>Date</b></label>
        </td>
        <td>
          <input id = 'event_date' type="date" name="date" required>
        </td>
        </tr>

          <tr>
              <td>
          <label for="timeBegin"><b>Time Beginning</b></label>
        </td>
        <td>
          <input id = 'event_start_time' type="time" name="timeBegin">
        </td>
        </tr>

          <tr>
              <td>
          <label for="time"><b>Time Ending</b></label>
        </td>
        <td>
          <input id = 'event_end_time' type="time" name="timeEnd">
        </td>
        </tr>
        <tr>
            <td>
            <label for="eventLocation"><b>Event Location (optional)</b></label>
            </td>

            <td>
            <input id = 'event_location' type="text" placeholder="Enter Event Location" name="location" value = "">
            </td>
          </tr>

          <tr>
              <td>
              <label for="userToShare"><b>Usernames to Share Event With (Optional)</b></label>
              </td>

              <td>
                  <input id = 'usersToShare' type="text" placeholder="Enter User Name" name="location" value = "">
              </td>
            </tr>
            <tr>
              <td>
              <label for="eventTag"><b>Event Tag (optional)</b></label>
              </td>

              <td>
              <input type="radio" name="tag_type" value = "School">School<br>
              <input type="radio" name="tag_type" value = "Extracurriculars">Extracurriculars<br>
              <input type="radio" name="tag_type" value = "Social">Social
              </td>
            </tr>
       </tbody>

    </table>
    <button id = 'add_event_submit' type="submit" class="btn">Submit</button>
    <button id = "button-close"class="btn cancel" >Close</button>
    <div id="hidden_field"><input type="text" name="token" id = "token" value= <?php echo($_SESSION['token']); ?>/> </div>

    </form>
  </div>



</body>
</html>
