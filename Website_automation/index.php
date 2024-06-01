<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website Building Project</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="css/style.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    /* style.css */

/* Navigation Header */


.navbar-brand {
  color: #fff;
}

.navbar-brand:hover {
  color: #fff;
}

/* Banner Section */
.banner-section {
  position: relative;
}

.banner-section img {
  width: 100%;
}

.banner-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.banner-content h1 {
  font-size: 3rem;
  color: #333;
}

.banner-content p {
  font-size: 1.5rem;
  color: #555;
}

.production-solution {
  padding: 50px 0;
}

.production-solution h2 {
  font-size: 2rem;
  color: #333;
  font-weight: bold;
}

.production-solution p {
  font-size: 1rem;
  color: #666;
  margin-bottom: 1rem;
}

.production-solution ul {
  list-style: none;
  padding-left: 0;
}

.production-solution ul li {
  margin-bottom: 0.5rem;
}

.production-solution .btn {
  font-size: 1rem;
  border-radius: 0;
}

/* Animation Example */
.production-solution .btn {
  transition: all 0.3s ease;
}

.production-solution .btn:hover {
  background-color: #0069d9;
  color: #fff;
}

/* Enquiry Form */
.form-group {
  margin-bottom: 20px;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.form-control:focus {
  outline: none;
  border-color: #007bff;
}

textarea.form-control {
  resize: vertical;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  color: #fff;
  padding: 10px 20px;
  border-radius: 5px;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

.carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }


  </style>
</head>

<body>

<!-- Navigation Header -->
<?php include('include/header.php'); ?>

<div class="container mt-4">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/Banner.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Welcome to Our Website</h5>
                        <p>Elevate your brand with our web solutions.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/banner2.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Welcome to Our Website</h5>
                        <p>Building websites, building relationships</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/banner3.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Welcome to Our Website</h5>
                        <p>Empowering your online presence.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>



<!-- Production Solution Section -->
<section class="production-solution bg-white">
  <div class="container ">
    <div class="row">
      <div class="col-md-12">
        <h2>Our Product Solution</h2>
        <p>At Website Building, we specialize in creating custom websites tailored to meet the unique needs of each client. Our team of experienced developers and designers work closely with you to understand your business goals and objectives, ensuring that your website not only looks great but also delivers results.</p>
        <p>Whether you need a simple brochure website to establish your online presence or a complex e-commerce platform to sell your products worldwide, we have the expertise to bring your vision to life.</p>
        <p>Our production process involves:</p>
        <ul>
          <li>Initial consultation to discuss your requirements and goals</li>
          <li>Design phase where we create mockups and wireframes for your approval</li>
          <li>Development phase where our team builds your website using the latest technologies</li>
          <li>Testing and quality assurance to ensure everything works perfectly</li>
          <li>Launch and ongoing support to help you maintain and update your website</li>
        </ul>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="questionnaire_page1.php" class="btn btn-primary">Build Your Website</a>
        <?php endif; ?>
      </div>
      
</section>
<div class="container">
  <div class="row justify-content-center my-2">
    <div class="col-md-6">
      <!-- Enquiry Form -->
      <h3 class="text-center">Enquiry Form</h3>
      <form action="submit_enquiry.php" method="POST" onsubmit="return validateForm()">
    <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
    </div>
    <div class="form-group">
        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
    </div>
    <div class="form-group">
        <input type="text" name="subject" class="form-control" placeholder="Subject" required>
    </div>
    <div class="form-group">
        <textarea name="message" class="form-control" placeholder="Your Message" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

    </div>
  </div>
</div>

<!-- Footer -->
<?php include('include/footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function validateForm() {
        var name = document.forms["enquiryForm"]["name"].value;
        var email = document.forms["enquiryForm"]["email"].value;
        var subject = document.forms["enquiryForm"]["subject"].value;
        var message = document.forms["enquiryForm"]["message"].value;

        if (name == "") {
            alert("Please enter your name");
            return false;
        }
        if (email == "") {
            alert("Please enter your email");
            return false;
        }
        if (subject == "") {
            alert("Please enter the subject");
            return false;
        }
        if (message == "") {
            alert("Please enter your message");
            return false;
        }
    }


    <!-- jQuery, Bootstrap JS and Materialize JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</script>
</body>
</html>
