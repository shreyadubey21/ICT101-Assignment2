# Paws & Polish Pet Grooming (ICT101 Assessment 2)

A pet grooming website built with HTML5, CSS3, JavaScript, PHP and MySQL. No templates or frameworks.

## How to run it (XAMPP)

1. Copy the `paws-and-polish` folder into XAMPP's `htdocs` folder
   (Mac: Applications → XAMPP → xamppfiles → htdocs, Windows: C:\xampp\htdocs).
2. Open XAMPP and start **Apache** and **MySQL**.
3. Go to http://localhost/phpmyadmin, click **Import**, choose `database/paws_polish.sql` and click **Import**.
4. Open http://localhost/paws-and-polish/
5. Demo login: username `demo`, password `Demo@1234`

## Pages

| Page | File | What it does |
|---|---|---|
| Home | `index.php` | Welcome banner, service categories, reviews, about us |
| Services | `services.php` | Lists all services, filter by category |
| Search | `search.php` | Search services by keyword (search box is on every page) |
| Register | `register.php` | Create an account, checks if the username is taken |
| Log in | `login.php` | Checks the password; if it fails, asks you to register |
| Forgot password | `forgot-password.php` | Reset password using username and email |
| My Account | `account.php` | Update details, add pets, see and cancel bookings |
| Book | `booking.php` | Request a service and get a booking confirmation |
| Feedback | `feedback.php` | Leave feedback or a suggestion with a rating |
| Log out | `logout.php` | Ends the session |

Shared files: `db.php` (database connection), `header.php` (logo, menu, search), `footer.php`.

## Other files

- `css/style.css`: the only stylesheet. CSS3 features: gradients, rounded corners, box shadows, transitions and transforms, media query.
- `js/script.js`: JavaScript form validation (one function per form).
- `images/`: logo, illustrations and icons (7 images).
- `database/paws_polish.sql`: creates the 5 tables (users, services, pets, bookings, feedback) with sample data.

## Security basics

- Passwords are stored hashed with `password_hash()` and checked with `password_verify()`.
- User input is cleaned with `mysqli_real_escape_string()` before it goes into SQL queries.
- Text typed by users is shown with `htmlspecialchars()` so it can't run as code.
- Forms are checked by JavaScript in the browser and again by PHP on the server.
- My Account and Book only work when you are logged in.
