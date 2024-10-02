<?php
include "connect.php"; // Ensure this file is correctly included and contains the $conn variable

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("refresh:0; ../Index.php");
    exit;
} else if (isset($_SESSION['AID'])) {
    $userid = $_SESSION['AID'];
    $getrecord = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE AID ='$userid'");
    while ($rowedit = mysqli_fetch_assoc($getrecord)) {
        $type = $rowedit['Role'];
        $name = $rowedit['fname'] . " " . $rowedit['lname'];
    }
}

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    if (!empty($search)) {
        $sql = "SELECT * FROM tbl_announcements WHERE id LIKE '%$search%' OR ANNOUNCEMENT LIKE '%$search%'";
    } else {
        $sql = "SELECT * FROM tbl_announcements";
    }
} else {
    $sql = "SELECT * FROM tbl_announcements";
}


$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements Carousel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="icon" href="../images/logasac.png">
    <style>



.announcement-container {
    max-width: calc(100% - 250px); 
    margin-left: 250px; /* Add margin to push it past the sidebar */
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    padding: 10px;
    transition: margin 0.3s ease;
    margin-right:10px;
    margin-top:3%;
    margin-bottom:10px;
}

.carousel-item {
    min-width: 100%;
    box-sizing: border-box;
}

.announcement-card img {
    width: 100%;
    max-width: 100%; /* Prevent the image from exceeding the width */
    max-height: 500px;
    object-fit: contain;
    filter: brightness(70%);
    padding:10px;
}

.texts {
    font-size: 28px;
    font-family:'Arial', sans-serif;;
    color: #b40404;
    text-align: left;
    margin-left: 10px;
    margin-bottom: 20px;

}

.carousel {
    position: relative;
}

.carousel-inner {
    display: flex;
    transition: transform 0.5s ease;
    width: 100%;
}

.carousel-item {
    min-width: 100%;
    box-sizing: border-box;
}

.announcement-card {
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.announcement-content {
    padding: 20px;
    background-color: white;
    color: #333;
}

.announcement-title {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 10px;
}

.announcement-date {
    font-size: 14px;
    font-weight: lighter;
    color: #666;
}

.announcement-description {
    font-size: 15px;
    color: #555;
}

.radio-btns {
    text-align: center;
    margin: 10px 0;
}

.radio-btns input[type="radio"] {
    display: none;
}

.radio-btns label {
    cursor: pointer;
    background-color: #ddd;
    border-radius: 50%;
    width: 15px;
    height: 15px;
    display: inline-block;
    margin: 5px;
}

.radio-btns input[type="radio"]:checked + label {
    background-color: #333;
}

/* Media queries for responsiveness */
@media screen and (max-width: 768px) { /*768px */
    .announcement-container {
        max-width: 100%; 
        margin-left: 0; 
        margin-top: 15%;
        padding: 0;    
    }

    .announcement-card img {
        max-height: 70%; /* 300px */
    }
}

@media (max-width: 100%) {
    .texts {
        font-size: 30%px;
    }

    .announcement-title {
        font-size: 18px;
    }

    .announcement-description {
        font-size: 13px;
    }

    .announcement-card img {
        max-height: 60%;
    }

    .carousel-inner {
        flex-direction: column;
    }
}

    </style>
</head>
<body>

<form action="logout.php" method="post">
<?php include_once 'navs/nav.php'; ?>
    </form>

<div class="announcement-container">
    <h1 class="texts latest_announcements">Latest Announcements</h1>


    <div class="carousel">
        <div class="carousel-inner" id="carousel-inner">
            <?php
            if ($result->num_rows > 0) {
                $index = 0;
                while ($row = $result->fetch_assoc()) {
                    $source = "../uploads/" . $row['image'];
                    echo "<div class='carousel-item' id='item-$index'>";
                    echo "<div class='announcement-card'>";
                    echo "<img src='$source' alt='Announcement Image'>";
                    echo "</div>";
                    echo "<div class='announcement-content'>";
                    echo "<div class='announcement-title'>" . $row['title'] . "</div>";
                    echo "<div class='announcement-date'>" . $row['announcement_date'] . "</div>";
                    echo "<div class='announcement-description'>" . $row['description'] . "</div>";
                    echo "</div>";
                    echo "</div>";
                    $index++;
                }
            } else {
                echo "<p style='text-align:center;'>No announcements found.</p>";
            }
            ?>
        </div>
    </div>


    <div class="radio-btns" id="radio-btns">
        <?php
        for ($i = 0; $i < $result->num_rows; $i++) {
            echo "<input type='radio' name='slider' id='radio$i' " . ($i == 0 ? "checked" : "") . ">";
            echo "<label for='radio$i' onclick='showSlide($i)'></label>";
        }
        ?>
    </div>
</div>

<script>
    let currentIndex = 0;
    const slides = document.querySelectorAll('.carousel-item');
    const radios = document.querySelectorAll('.radio-btns input[type="radio"]');
    const totalSlides = slides.length;

    function showSlide(index) {
        const carouselInner = document.querySelector('.carousel-inner');
        const slideWidth = document.querySelector('.carousel-item').offsetWidth;
        carouselInner.style.transform = `translateX(-${index * slideWidth}px)`;
        currentIndex = index;
        radios[index].checked = true; // Sync radio buttons with slide
    }

    function autoSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        showSlide(currentIndex);
    }

    let slideInterval = setInterval(autoSlide, 5000);

    radios.forEach((radio, index) => {
        radio.addEventListener('click', () => {
            clearInterval(slideInterval); 
            showSlide(index); 
            slideInterval = setInterval(autoSlide, 5000); 
        });
    });
</script>

</body>
</html>

