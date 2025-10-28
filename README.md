# 🎟️ Ticket Management Web App (Twig + PHP)

A simple but powerful **Ticket Management Web Application** built with **Twig (PHP)**, **Tailwind CSS**, and plain **vanilla JavaScript** for client-side logic.  
This is the PHP/Twig implementation of the multi-framework challenge (React, Vue, Twig). It uses **localStorage** for authentication and persistent data to match the frontend-only behavior from the React version.

> **TL;DR:** This is a server-rendered app (Twig templates) with all interactive logic (auth, validation, CRUD) running in the browser using localStorage. This is purposely a client-side simulation — **not** secure for production. Good for demos and the multi-framework challenge.

---

## 🚀 Features

- ✅ Responsive landing page with SVG wave and decorative elements  
- ✅ Authentication (Login / Signup) simulated with **localStorage**  
- ✅ Client-side form validation (vanilla JS) — same rules as React (title required, status restricted)  
- ✅ Protected Dashboard (client-side guard) showing ticket statistics  
- ✅ Full CRUD ticket management using `localStorage` (Create, Read, Update, Delete)  
- ✅ Toast/inline feedback and confirmation modal for deletes  
- ✅ Clean layout using Twig template inheritance and Tailwind CSS

---

## 🧩 Tech Stack

| Category   | Technology           |
| ---------- | -------------------- |
| Server     | PHP (built-in server)|
| Templating | Twig                 |
| Styling    | Tailwind CSS (CDN)   |
| Logic      | Vanilla JavaScript (localStorage) |
| Storage    | Browser localStorage |

---

## 📁 Project Structure

project-root/
│
├── pages/ # Optional controllers (if used)
├── public/
│ └── index.php # Front controller (renders Twig templates)
│ └── wave.svg # public assets
│ └── style.css # optional
│
├── templates/
│ ├── base.twig
│ ├── navbar.twig
│ ├── footer.twig
│ ├── landing.twig
│ ├── login.twig
│ ├── signup.twig
│ ├── dashboard.twig
│ └── tickets.twig
│
├── vendor/ # Composer packages (Twig)
├── composer.json
└── README.md


---

## ⚙️ Installation & Local Development

### 1) Requirements
- PHP 8.x (CLI)
- Composer
- A modern browser

### 2) Install dependencies (Twig)
From project root:

```bash
composer install


If you don't have composer.lock, run:

composer require twig/twig

3) Create the public/, templates/ folders if missing

Make sure your folder layout matches the structure above. Put assets (wave.svg, favicon, css) inside public/.

4) Start the PHP built-in server

From the project root:

php -S localhost:8000 -t public


Open the app at:

http://localhost:8000

🔧 How the App Works — Key Differences vs React

Server: PHP + Twig only renders HTML templates. It does not handle authentication or database logic.

Client: All interactive behavior (signup/login, ticket CRUD, validation, stats) lives in vanilla JS embedded in Twig templates.

Auth: localStorage key ticketapp_session holds a simple user object. The app checks this in JS and redirects users client-side if missing.

Persistence: Tickets are stored in localStorage under the key tickets. Users are stored under users.

Security: This is not secure for production — localStorage can be modified by clients. This setup mirrors the React demo behavior for fair comparison across frameworks.

🔐 Authentication (how it works)


Signup


User fills form on / ?page=signup


JavaScript checks localStorage.users for duplicates, appends the new user, and redirects to / ?page=login




Login


JavaScript checks credentials against localStorage.users


On success it writes localStorage.ticketapp_session = { name, email } and redirects to / ?page=dashboard




Logout


Removes ticketapp_session and redirects to landing.





Note: Protected pages (dashboard/tickets) use a client-side guard placed at the top of the template:
const sessionUser = JSON.parse(localStorage.getItem("ticketapp_session"));
if (!sessionUser) window.location.href = "/?page=login";



🎫 Ticket CRUD (how it works)


Tickets stored under localStorage.tickets as an array of objects:


{
  "id": 169xxx,
  "title": "Example",
  "description": "Details",
  "priority": "low|medium|high",
  "status": "open|in_progress|closed",
  "createdAt": "2025-10-28T..."
}



Create — form in tickets.twig pushes a new object to tickets and persists it.


Read — tickets are rendered from localStorage.tickets.


Update — editing fills the form and replaces the matching ticket by id.


Delete — a confirm modal appears; on confirm JS filters out the ticket and saves.


Validation rules (client-side):


title — required


status — must be open, in_progress, or closed


Optional fields validated for length/type where applicable



🧭 Pages & Templates


base.twig — global layout, includes <main class="flex-grow"> to push footer to bottom.


navbar.twig — shows Login/Signup or Dashboard/Tickets/Logout depending on localStorage.ticketapp_session. This is driven by JS inside the template.


landing.twig — hero section, buttons vary by auth state (JS).


login.twig — login form + JS to set session in localStorage.


signup.twig — signup form + JS to add user to localStorage.


dashboard.twig — stats read from localStorage.tickets using JS.


tickets.twig — ticket form, list, edit and delete logic implemented in JS.



✔️ Example localStorage usage (dev console)
Create user (simulate signup):
const users = JSON.parse(localStorage.getItem('users')||'[]');
users.push({ name: 'Test', email: 'test@example.com', password: 'pass123' });
localStorage.setItem('users', JSON.stringify(users));

Login:
localStorage.setItem('ticketapp_session', JSON.stringify({ name: 'Test', email: 'test@example.com' }));

Add ticket:
const tickets = JSON.parse(localStorage.getItem('tickets')||'[]');
tickets.push({ id: Date.now(), title: 'Bug', description: 'Fix it', status: 'open', priority: 'low', createdAt: new Date().toISOString() });
localStorage.setItem('tickets', JSON.stringify(tickets));


✅ Developer Notes & Tips


Use the browser console to inspect localStorage while testing.


Tailwind is included via CDN in base.twig for fast development — if you prefer full build tooling, set up a Node/Tailwind pipeline.


Ensure the public/ folder contains all images and your index.php file. Twig templates live in templates/.


For sticky footer: body should be min-h-screen flex flex-col and the content wrapper should use flex-grow. (This is already set in base.twig.)



⚠️ Security Warning (read this)
This implementation stores credentials and session tokens in plain localStorage. That means:


Data is readable & modifiable by the user (devtools)


Susceptible to XSS data theft


Not suitable for any production app with real users

