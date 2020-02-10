# Lab 3A - PHP Part 1

## PHP – Part 1 Pass-off

#### Minimum Requirements (70 / 100 pts)

- [ ] Choose appropriate permissions for all your files (you must explain why – 777 is not appropriate).
- [ ] UML diagram, in digital from, showing functionality of entire lab.
- [ ] Backup all your code BEFORE pass-off
- [ ] Database is set up.
- [ ] Passwords are hashed in the database
- [ ] Created new database user with correct privileges.
- [ ] Using settings.php – the config file for connecting to the database.
- [ ] login.php authenticates, creates a session,  and changes database login entry to 1.
- [ ] User can log in and see protected php pages.
- [ ] User can log out and NOT see protected php pages
- [ ] User can register
- [ ] No duplicate usernames allowed in database
- [ ] Make site work on live server
- [ ] HTML5 Form validation on registration page (requires all fields before submitting)
- [ ] logout.php kills the session and changes the database login entry to 0
- [ ] form actions point to an EXTERNAL php page

#### Full Requirements

- [ ] 10 Points - Tell the user when login fails in your login.php
- [ ] 10 Points - Php code uses Object Oriented process and SQL prepared statements for accessing the Database
  - .php files use bound parameters when querying the database with user-supplied values

#### Extra Credit

- [ ] 10 Points - Escape user input before submitting to the database in order to prevent Javascript XSS attacks
