<?php include 'config/page/styles.php'; ?>
  <body>
    <?php
        include 'config/db/connect.php';
    include 'config/functions.php';  
    include 'config/page/mainHeader.php';
    ?>
    <!-- END head -->

    <section class="site-hero overlay" style="background-image: url(images/hero_4.jpg)">
      <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
          <div class="col-md-10 text-center" data-aos="fade-up">
            <span class="custom-caption text-uppercase text-white d-block  mb-3">Welcome To<br><br><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span></span>
            <br><br><h1 id="book" class="heading">Casa Cuba</h1>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="section bg-light pb-0">
      <div class="container">
       
        <div class="row check-availabilty" id="next">
          <div class="block-32" data-aos="fade-up" data-aos-offset="-200">

            <form action="booking" method="post" onsubmit="return validateForm()">
              <div class="row">
                <div class="col-md-6 mb-3 mb-lg-0 col-lg-3">
                  <label for="datein" class="font-weight-bold text-black">Check In</label>
                  <div class="field-icon-wrap">
                    <div class="icon"><span class="icon-calendar"></span></div>
                    <input type="date" min=<?php echo date('Y-m-d'); ?> name="datein" id="datein" class="form-control" onchange="setCheckoutDate()">
                  </div>
                </div>
                <div class="col-md-6 mb-3 mb-lg-0 col-lg-3">
                  <label for="dateout" class="font-weight-bold text-black">Check Out</label>
                  <div class="field-icon-wrap">
                    <div class="icon"><span class="icon-calendar"></span></div>
                    <input type="date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" name="dateout" id="dateout" class="form-control">
                  </div> 
                </div>
                <div class="col-md-6 col-lg-3 align-self-end">
                  <input type="submit" value="Check Availability" class="btn btn-primary btn-block text-white">
                </div>
              </div>
            </form>
          </div>


        </div>
      </div>
    </section>

    <section class="py-5 bg-light">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-12 col-lg-7 ml-auto order-lg-2 position-relative mb-5" data-aos="fade-up">
            <figure class="img-absolute">
              <img src="images/food-1.jpg" alt="Image" class="img-fluid">
            </figure>
            <img src="images/img_1.jpg" alt="Image" class="img-fluid rounded">
          </div>
          <div class="col-md-12 col-lg-4 order-lg-1" data-aos="fade-up">
            <h2 class="heading">Welcome!</h2>
            <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <p><a href="#" class="btn btn-primary text-white py-2 mr-3">Learn More</a> <span class="mr-3 font-family-serif"><em>or</em></span> <a href="https://vimeo.com/channels/staffpicks/93951774"  data-fancybox class="text-uppercase letter-spacing-1">See video</a></p>
          </div>
          
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-7">
            <h2 class="heading" data-aos="fade-up">Rooms &amp; Suites</h2>
            <p data-aos="fade-up" data-aos-delay="100">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <a href="#" class="room">
              <figure class="img-wrap">
                <img src="images/img_1.jpg" alt="Free website template" class="img-fluid mb-3">
              </figure>
              <div class="p-3 text-center room-info">
                <h2>Single Room</h2>
                <span class="text-uppercase letter-spacing-1">90$ / per night</span>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <a href="#" class="room">
              <figure class="img-wrap">
                <img src="images/img_2.jpg" alt="Free website template" class="img-fluid mb-3">
              </figure>
              <div class="p-3 text-center room-info">
                <h2>Family Room</h2>
                <span class="text-uppercase letter-spacing-1">120$ / per night</span>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <a href="#" class="room">
              <figure class="img-wrap">
                <img src="images/img_3.jpg" alt="Free website template" class="img-fluid mb-3">
              </figure>
              <div class="p-3 text-center room-info">
                <h2>Presidential Room</h2>
                <span class="text-uppercase letter-spacing-1">250$ / per night</span>
              </div>
            </a>
          </div>


        </div>
      </div>
    </section>
    
    
    <section class="section slider-section bg-light">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-7">
            <h2 class="heading" data-aos="fade-up">Photos</h2>
            <p data-aos="fade-up" data-aos-delay="100">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="home-slider major-caousel owl-carousel mb-5" data-aos="fade-up" data-aos-delay="200">
              <div class="slider-item">
                <a href="images/slider-1.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="images/slider-1.jpg" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-2.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="images/slider-2.jpg" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-3.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="images/slider-3.jpg" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-4.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="images/slider-4.jpg" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-5.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="images/slider-5.jpg" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-6.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="images/slider-6.jpg" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-7.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="images/slider-7.jpg" alt="Image placeholder" class="img-fluid"></a>
              </div>
            </div>
            <!-- END slider -->
          </div>
        
        </div>
      </div>
    </section>
    <!-- END section -->
    

    
    <!-- END section -->
    <section class="section testimonial-section">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-7">
            <h2 class="heading" data-aos="fade-up">Reviews</h2>

          </div>
        </div>
        <div class="row">
          <div class="js-carousel-2 owl-carousel mb-5" data-aos="fade-up" data-aos-delay="200">
          <?php
            $sql = $sql = "SELECT * FROM reviews WHERE verified = 1 ORDER BY RAND() LIMIT 3";
            $result = $mysqli->query($sql);
            if($result->num_rows > 2){
              while($row = $result->fetch_assoc()){
                $stars = $row['rating'];
                $review = $row['text'];

                $sqlguest = "SELECT first_name,last_name FROM guest WHERE id = " . $row['guest_id'];
                $resultguest = $mysqli->query($sqlguest);
                $guest = $resultguest->fetch_assoc();
                $name = $guest['first_name'] . ' ' . $guest['last_name'];


                echo '<div style="padding-top: 70px;" class="testimonial text-center slider-item">';
                echo '<div class="stars">';
                for($i = 0; $i < $stars; $i++){
                  echo '<span class="fa fa-star text-warning">';
                }
                echo '</div>';
                echo '<blockquote>';
                echo "<p>&ldquo;$review&rdquo;</p>";
                echo '</blockquote>';
                echo "<p><em>-$name</em></p>";
                echo '</div>';
              }
            }else{
              // no reviews found

              echo '<div style="padding-top: 70px;" class="testimonial text-center slider-item">';
              echo '<div class="stars">';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '</div>';
              echo '<blockquote>';
              echo '<p>&ldquo;No reviews found&rdquo;</p>';
              echo '</blockquote>';
              echo '<p><em>-Anonymous</em></p>';
              echo '</div>';
              echo '<div style="padding-top: 70px;" class="testimonial text-center slider-item">';
              echo '<div class="stars">';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '</div>';
              echo '<blockquote>';
              echo '<p>&ldquo;No reviews found&rdquo;</p>';
              echo '</blockquote>';
              echo '<p><em>-Anonymous</em></p>';
              echo '</div>';
              echo '<div style="padding-top: 70px;" class="testimonial text-center slider-item">';
              echo '<div class="stars">';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '<span class="fa fa-star text-warning"></span>';
              echo '</div>';
              echo '<blockquote>';
              echo '<p>&ldquo;No reviews found&rdquo;</p>';
              echo '</blockquote>';
              echo '<p><em>-Anonymous</em></p>';
              echo '</div>';

            }
          
            ?>
            <!-- END slider -->
        </div>
        <a href="review" class="btn btn-primary">Place Review</a>

      </div>
    </section>
    



    <section class="section bg-image overlay" style="background-image: url('images/hero_4.jpg');">
        <div class="container" >
          <div class="row align-items-center">
            <div class="col-12 col-md-6 text-center mb-4 mb-md-0 text-md-left" data-aos="fade-up">
              <h2 class="text-white font-weight-bold">A Best Place To Stay. Reserve Now!</h2>
            </div>
            <div class="col-12 col-md-6 text-center text-md-right" data-aos="fade-up" data-aos-delay="200">
              <a href="home#book" class="btn btn-outline-white-primary py-3 text-white px-5">Reserve Now</a>
            </div>
          </div>
        </div>
      </section>

      <section class="section slider-section bg-light">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-7">
            <h2 class="heading" data-aos="fade-up">FAQ</h2>
            <p data-aos="fade-up" data-aos-delay="100">Frequently Asked Questions</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            
              <div class="slider-item">
                <a href="#" class="room">
                  <div class="p-3 text-center room-info">
                    <h2>What is the check-in and check-out time?</h2>
                    <span class="text-uppercase letter-spacing-1">Check-in: 3 PM, Check-out: 11 AM</span>
                  </div>
                </a>
              </div>
              <div class="slider-item">
                <a href="#" class="room">
                  <div class="p-3 text-center room-info">
                    <h2>Is breakfast included in the room rate?</h2>
                    <span class="text-uppercase letter-spacing-1">Yes, breakfast is included.</span>
                  </div>
                </a>
              </div>
              <div class="slider-item">
                <a href="#" class="room">
                  <div class="p-3 text-center room-info">
                    <h2>Do you have a cancellation policy?</h2>
                    <span class="text-uppercase letter-spacing-1">Yes, we have a 24-hour cancellation policy.</span>
                  </div>
                </a>
                </div>
            </div>
            <!-- END slider -->
          </div>
      </div>
    </section>

    <footer class="section footer-section">
      <div class="container">
        <div class="row mb-4">
          <div class="col-md-3 mb-5">
            <ul class="list-unstyled link">
              <li><a href="#">About Us</a></li>
              <li><a href="images/rules/Casa-Cuba-Rules.pdf">Hotel Rules</a></li>
              <li><a href="#">The Rooms </a></li>
              <li class="hiddenadminlink"><a href="admin/adminLogin">Admin</a></li>
            </ul>
          </div>
          <div class="col-md-3 mb-5 pr-md-5 contact-info">
            <p><span class="d-block"><span class="ion-ios-location h5 mr-3 text-primary"></span>Address:</span> <span> Korte Pennincstraat 17, <br> 2800 Mechelen Belgie</span></p>
            <p><span class="d-block"><span class="ion-ios-telephone h5 mr-3 text-primary"></span>Phone:</span> <span>+32 494 46 82 01</span></p>
            <p><span class="d-block"><span class="ion-ios-email h5 mr-3 text-primary"></span>Email:</span> <span> info@domain.com</span></p>
          </div>
          <div class="col-md-3 mb-5">
            <p>Sign up for our newsletter</p>
            <form action="#" class="footer-newsletter">
              <div class="form-group">
                <input type="email" class="form-control" placeholder="Email...">
                <button type="submit" class="btn"><span class="fa fa-paper-plane"></span></button>
              </div>
            </form>
          </div>
        </div>
        <div class="row pt-5">
          <p class="col-md-6 text-left">
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Powered by PayPal 
          </p>
            
          <p class="col-md-6 text-right social">
            <a href="#"><span class="fa fa-tripadvisor"></span></a>
            <a href="#"><span class="fa fa-facebook"></span></a>
            <a href="#"><span class="fa fa-twitter"></span></a>
            <a href="#"><span class="fa fa-linkedin"></span></a>
            <a href="#"><span class="fa fa-vimeo"></span></a>
          </p>
        </div>
      </div>
    </footer>
    
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    
    
    <script src="js/aos.js"></script>
    
    <script src="js/bootstrap-datepicker.js"></script> 
    <script src="js/jquery.timepicker.min.js"></script>
    <script>
        function validateForm() {
            var datein = new Date(document.getElementById("datein").value);
            var dateout = new Date(document.getElementById("dateout").value);
            console.log(datein);
            console.log(dateout);

            if (datein > dateout) {
                alert("Check-out date cannot be before check-in date.");
                return false;
            }
            return true;
        }
        document.getElementById('datein').addEventListener('change', setCheckoutDate);

function setCheckoutDate() {
    var datein = new Date(document.getElementById('datein').value);
    if (!isNaN(datein.getTime())) {
        datein.setDate(datein.getDate() + 1);
        var dateout = document.getElementById('dateout');
        dateout.value = datein.toISOString().split('T')[0];
    }
}

document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.altKey && e.key === 'A') {
                document.querySelector('.hiddenadminlink').style.display = 'block';
                setTimeout(function() {
                    document.querySelector('.hiddenadminlink').style.display = 'none';
                }, 5000);
            }
        });
    </script>

    

    <script src="js/main.js"></script>
  </body>
</html>