<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css_admin/dash.css">
</head>
<body>
    <header class="header">
        <a href="#">Admin Dashboard</a>
        <div class="logout">
            <form action="logout.php" method="post">
                <button type="submit" name='logout' class="logout-button">Logout</button>
        </div>
    </header>
    
    <aside class="sidebar">
    <ul class="nav-list">

    <a class="nav-link1">
        <img src="../photos/logo.png" alt="Logo" class="logo1">
        <h1 class="text">ACADEMY OF SAINT ANDREW CALOOCAN (ASAC), INC. </h1>
        </a>
        

    
        <li class="nav-item" style="--li-index: 1;">
            <a href="dashboard.php" class="nav-link">
                <img src="../photos/dashboard.png" alt="Dashboard Icon" class="nav-icon">
                Dashboard
            </a>
        </li>
        <li class="nav-item" style="--li-index: 2;">
            <a href="manage_account.php" class="nav-link">
                <img src="../photos/account.png" alt="Accounts Icon" class="nav-icon">
                Accounts
            </a>
        </li>
        <li class="nav-item" style="--li-index: 3;">
            <a href="manage_courses.php" class="nav-link">
                <img src="../photos/courses.png" alt="Courses Icon" class="nav-icon">
                Courses
            </a>
        </li>
        <li class="nav-item" style="--li-index: 4;">
            <a href="manage_classes.php" class="nav-link">
                <img src="../photos/class.png" alt="Classes Icon" class="nav-icon">
               Classes
            </a>
        </li>
        <li class="nav-item" style="--li-index: 5;">
            <a href="manage_subject.php" class="nav-link">
                <img src="../photos/book.png" alt="Group Chat Icon" class="nav-icon">
               Subjects
            </a>
        </li>
        <li class="nav-item" style="--li-index: 6;">
            <a href="events.php" class="nav-link">
                <img src="../photos/event.png" alt="Events Icon" class="nav-icon">
                Events
            </a>
        </li>
        <li class="nav-item" style="--li-index: 7;">
            <a href="addannouncement.php" class="nav-link">
                <img src="../photos/announcement.png" alt="Announcements Icon" class="nav-icon">
                Announcements
            </a>
        </li>
        <li class="nav-item" style="--li-index: 8;">
            <a href="../Archive/archive.php" class="nav-link">
                <img src="../photos/archive.png" alt="Announcements Icon" class="nav-icon">
                Archive
            </a>
        </li>
        <br>
    </ul>
</aside>


    </body>
</html>