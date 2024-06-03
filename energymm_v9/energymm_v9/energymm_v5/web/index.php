<?php
require_once("../web/php/log_BD.php");

$sql_adherents = "SELECT COUNT(*) AS total_adherents FROM adherent";
$stmt_adherents = $pdo->prepare($sql_adherents);
$stmt_adherents->execute();

$totalAdherents = 0;
if ($stmt_adherents->rowCount() > 0) {
    $row = $stmt_adherents->fetch(PDO::FETCH_ASSOC);
    $totalAdherents = $row["total_adherents"];
}

$sql_coaches = "SELECT COUNT(*) AS total_coaches FROM coach";
$stmt_coaches = $pdo->prepare($sql_coaches);
$stmt_coaches->execute();

$totalCoaches = 0;
if ($stmt_coaches->rowCount() > 0) {
    $row = $stmt_coaches->fetch(PDO::FETCH_ASSOC);
    $totalCoaches = $row["total_coaches"];
}

$sql_nutritionists = "SELECT COUNT(*) AS total_nutritionists FROM nutritionniste";
$stmt_nutritionists = $pdo->prepare($sql_nutritionists);
$stmt_nutritionists->execute();

$totalNutritionists = 0;
if ($stmt_nutritionists->rowCount() > 0) {
    $row = $stmt_nutritionists->fetch(PDO::FETCH_ASSOC);
    $totalNutritionists = $row["total_nutritionists"];
}

$sql_visitors = "SELECT COUNT(*) AS total_visitors FROM visiteur";
$stmt_visitors = $pdo->prepare($sql_visitors);
$stmt_visitors->execute();

$totalVisitors = 0;
if ($stmt_visitors->rowCount() > 0) {
    $row = $stmt_visitors->fetch(PDO::FETCH_ASSOC);
    $totalVisitors = $row["total_visitors"];
}

$currentDay = strtolower(date("l")); 
$sql = "SELECT 
c.libele_cours AS class, c.description_cours, tc.libelletype_cours, s.date_seance, s.heure_debut, s.heure_fin, co.nom_coach, co.prenom_coach
FROM cours c 
JOIN seance s ON c.id_cours = s.id_cours 
JOIN coach co ON s.id_coach = co.id_coach 
JOIN type_cours tc ON c.id_type_cours = tc.id_type_cours
WHERE 
LOWER(DAYNAME(s.date_seance)) = :currentDay";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':currentDay', $currentDay, PDO::PARAM_STR);
$stmt->execute();

$scheduleData = array();

if ($stmt->rowCount() > 0) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $scheduleData[] = $row;
    }
} else {
}

$pdo = null; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ENERGYM</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>

  <nav class="navbar navbar-expand-md navbar-dark">
    <div class="container">
      <img src="images/energyme.png" alt="" id="logo">   
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="collapsibleNavbar">
        <ul class="navbar-nav" >
          <li class="nav-item" style="margin-right: 30px;">
            <a class="nav-link" href="#home">Home</a>
          </li>
          <li class="nav-item" style="margin-right: 30px;">
            <a class="nav-link" href="#about">About Us</a>
          </li>
          <li class="nav-item" style="margin-right: 30px;">
            <a class="nav-link" href="#classes">Classes</a>
          </li>
          <li class="nav-item"style="margin-right: 30px;">
            <a class="nav-link" href="#planning">Planning</a>
          </li>
          <li class="nav-item" style="margin-right: 30px;">
            <a class="nav-link" href="#nutrition">Nutrition</a>
          </li>
          <li class="nav-item" style="margin-right: 30px;">
            <a class="nav-link" href="#contact">Contact Us</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="php/login.php">Login &nbsp;  / &nbsp;  Sign up</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
<div class="jumbotron text-center" id="home">
  <h1>Welcome to EnerGym</h1>
  <p>We help you achieve your fitness goals!</p>
</div>

   <section id="facts" class="facts">
    <div class="container">

      <div class="row no-gutters">

      <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="300">
    <div class="count-box">
        <i class="bi bi-person"></i>
        <span data-purecounter-start="0"  data-purecounter-duration="1" class="purecounter"></span>
        <p><strong> Adherents:</strong> &nbsp; <?php echo $totalAdherents; ?></p>
    </div>
</div>


        <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="100">
          <div class="count-box">
          <i class="fas fa-dumbbell"></i>
            <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
            <p><strong>Coaches:</strong> &nbsp; <?php echo $totalCoaches; ?></p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="200">
          <div class="count-box">
            <i class="bi bi-apple"></i>
            <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1" class="purecounter"></span>
            <p><strong>Nutritionists:</strong> &nbsp; <?php echo $totalNutritionists; ?></p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="300">
          <div class="count-box">
            <i class="bi bi-people"></i>
            <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1" class="purecounter"></span>
            <p><strong> Visitors:</strong> &nbsp; <?php echo $totalVisitors; ?></p>
          </div>
        </div>

      </div>

    </div>
  </section>


<div class="container mb-5" id="about">
  
  <div class="row">
  <div class="col-md-6">
      <img src="images/gym.jpeg" class="img-fluid" alt="Gym Image"> 
    </div>
    <div class="col-md-6">
      <h2>About Us</h2>
        <p>Welcome to EnerGym! We're all about clean, sustainable energy solutions. Whether you're a homeowner, a business, or a community. Our mission is to provide reliable, affordable, and environmentally friendly energy solutions that benefit .</p>
<p>At EnerGym, we have the best team of certified trainers and state-of-the-art facilities are here to support you on your fitness journey.</p>
        <p>We offer personalized training programs, group classes, and nutritional guidance to help you achieve your goals.</p>
    </div>
    
  </div>
</div>
<div class="container mb-5" id="classes">
  <h2 class="text-center mb-4">Classes</h2>
  <div class="row">
    <div class="col-md-4">
    <div class="card card-with-background" style="background-image: url('images/box.jpg');">
        <div class="card-body">
          <h5 class="card-title">Box</h5>
          <p class="card-text">Join our box classes to improve flexibility and mental well-being.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
    <div class="card card-with-background" style="background-image: url('images/cardio.jpg');">
        <div class="card-body">
          <h5 class="card-title">Cardio</h5>
          <p class="card-text">Get your heart pumping with our cardio workout sessions.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
    <div class="card card-with-background" style="background-image: url('images/strengh.avif');">
        <div class="card-body">
          <h5 class="card-title">Strength Training</h5>
          <p class="card-text">Build muscle and strength with our strength training classes.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container mb-5" id="planning">
  <h2 class="text-center mb-5">Planning</h2>
  <div class="days-navigation mb-3">
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('monday')">Monday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('tuesday')">Tuesday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('wednesday')">Wednesday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('thursday')">Thursday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('friday')">Friday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('saturday')">Saturday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('sunday')">Sunday</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Classe</th>
          <th scope="col">Temps</th>
          <th scope="col">Coach</th>
          <th scope="col">Join us</th>
        </tr>
      </thead>
      <tbody id="schedule-body">
      </tbody>
    </table>
  </div>
</div>
 

<h2 class="text-center mb-5">Nutrition</h2>
<div class="container mb-5" id="nutrition">
  <div class="row">
    <div class="col-md-6">
      <img src="images/nutrition.avif" class="img-fluid rounded-top " alt="Image">
    </div>
    <div class="col-md-6">
      <div class="p-4">
      <h2>Fuel Your Body Right</h2>
        <p>Good nutrition is vital for providing our bodies with essential nutrients needed for proper functioning, supporting growth, boosting the immune system, preventing chronic diseases, maintaining a healthy weight, and improving mental health and overall quality of life.
At EnerGym, we understand the importance of balanced nutrition tailored to your individual needs. That's why we offer consultations with our specialized nutritionists. Our qualified experts can help you achieve your health and wellness goals by creating personalized meal plans.</p>
      </div>
    </div>
  </div>
</div>

<h2 class="text-center mb-5">Coaches</h2>

<div id="coachCarousel" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">

    <div class="carousel-item active">
      <img src="images/IMG-20240420-WA0023.jpg" class="d-block w-100" alt="Profile 1">
      <div class="carousel-caption d-none d-md-block">
        <h5><strong>Meryem sakhi</strong></h5>
        <p><strong>A professional kickboxer known for his powerful striking abilities and aggressive fighting style.
</strong></p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/IMG-20240420-WA0025.jpg" class="d-block w-100" alt="Profile 2">
      <div class="carousel-caption d-none d-md-block">
        <h5><strong>Badr hari</strong></h5>
        <p><strong>Specializes in strength training and has experience working with clients of all fitness levels, from beginners to advanced athletes.
</strong></p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/IMG-20240420-WA0026.jpg" class="d-block w-100" alt="Profile 3">
      <div class="carousel-caption d-none d-md-block">
        <h5><strong>tom abimo</strong></h5>
        <p><strong>A certified yoga instructor with expertise in various yoga styles, including Hatha, Vinyasa, and Yin yoga.
</strong></p>
      </div>
    </div>

  </div>

  <a class="carousel-control-prev" href="#coachCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#coachCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<footer class="text-white text-center py-3" id="contact">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
      <div class="gym-info" style="justify-content: center; padding-top: 100px;">
      <h2 style="text-decoration: underline orange;">Gym Information</h2> <br>
      <div class="contact-info">
    <p><i class="fas fa-envelope"></i> Email: info@energym.com</p>
    <p><i class="fas fa-phone"></i> Phone: +1 (555) 123-4567</p>
    <p><i class="fas fa-map-marker-alt"></i> Address: Lorem Ipsum Street, City, Country</p>
    </div>
          
    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>


        </div>
      </div>
            <div class="col-md-6">
        <div class="contact-section" style="border: 2px solid white; padding: 20px; border-radius: 10px;">
          <h2>Contact Us</h2>
          <form id="contactForm">
          <div class="form-group">
    <input type="text" id="name" name="name" class="form-control no-bg-color no-focus-outline" placeholder="Enter your name" required>
</div>
            <div class="form-group">
              <input type="text" id="subject" name="subject" class="form-control no-bg-color no-focus-outline" placeholder="Enter your suject" required>
            </div>
            <div class="form-group">
              <input type="email" id="email" name="email" class="form-control no-bg-color no-focus-outline" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
              <textarea id="message" name="message" rows="4" class="form-control no-bg-color no-focus-outline" placeholder="Enter your message" required></textarea>
            </div>
            <button type="submit" class="btn btn-orange">Send</button>
          </form>
        </div>
      </div>
    </div>
    <br>
    <p>&copy; 2024 EnerGym. All rights reserved.</p>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="js/plan.js"></script>
<script src="js/script.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
