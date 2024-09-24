<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css_admin/dash.css">
</head>
<body>
    <header class="header">
        <a href="#">Archive Dashboard</a>
        <div class="logout">
            <form action="logouts.php" method="post">
                <button type="submit" name='logouts' class="logout-button">Logout</button>
        </div>
    </header>
    <aside class="sidebar">
    <ul class="nav-list">

    <a class="nav-link1">
        <img src="../photos/logo.png" alt="Logo" class="logo1">
        <h1 class="text">ACADEMY OF SAINT ANDREW CALOOCAN (ASAC), INC. </h1>
        </a>
        

    
        <li class="nav-item" style="--li-index: 1;">
            <a href="archive.php" class="nav-link">
                <img src="../photos/dashboard.png" alt="Dashboard Icon" class="nav-icon">
                Dashboard
            </a>
        </li>
        <li class="nav-item" style="--li-index: 2;">
            <a href="accountsarchive.php" class="nav-link">
                <img src="../photos/account.png" alt="Accounts Icon" class="nav-icon">
                Accounts
            </a>
        </li>
        <li class="nav-item" style="--li-index: 3;">
            <a href="archivecourses.php" class="nav-link">
                <img src="../photos/courses.png" alt="Courses Icon" class="nav-icon">
                Courses
            </a>
        </li>
        <li class="nav-item" style="--li-index: 4;">
            <a href="archiveclass.php" class="nav-link">
                <img src="../photos/class.png" alt="Classes Icon" class="nav-icon">
               Classes
            </a>
        </li>
        <li class="nav-item" style="--li-index: 5;">
            <a href="archivesubject.php" class="nav-link">
                <img src="../photos/book.png" alt="Group Chat Icon" class="nav-icon">
               Subjects
            </a>
        </li>
   
        <li class="nav-item" style="--li-index: 7;">
            <a href="archiveannounce.php" class="nav-link">
                <img src="../photos/announcement.png" alt="Announcements Icon" class="nav-icon">
                Announcements
            </a>
        </li>
        <li class="nav-item" style="--li-index: 8;">
            <a href="../Admin/dashboard.php" class="nav-link">
                <img src="../photos/return.png" alt="Announcements Icon" class="nav-icon">
                Return
            </a>
        </li>
  
    </ul>
</aside>


    </body>
</html>