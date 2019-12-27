      <!-- footer -->
      <footer id="footer">
         <div id="footer-widgets" class="container style-1">
            <div class="row">
               <div class="col-md-4">
                  <div class="widget widget_text">
                     <h2 class="widget-title"><span>ABOUT US</span></h2>
                     <div class="textwidget">
                        <p>
                           Our mission is to create jobs for hard-working individuals looking for a way to work and earn money around their busy
                           school schedules. These students are motivated with the common financial goal of getting through college with minimal
                           or no debt.
                        </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="widget widget_links">
                     <h2 class="widget-title"><span>COMPANY LINKS</span></h2>
                     <ul class="wprt-links clearfix col2">
                        <li><a data-scroll="" href="#home">Home</a></li>
                        <li><a data-scroll="" href="#about">About Us</a></li>
                        <li><a data-scroll="" href="#services">Services</a></li>
                        <li><a data-scroll="" href="#contact">Contact Us</a></li>
                        <li><a data-scroll="" href="#testimonials">Reviews</a>
					 </ul>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="widget widget_information">
                     <h2 class="widget-title"><span>CONTACT INFO</span></h2>
                     <ul>
                        <li class="phone clearfix">
                           <span class="hl">Phone:</span> 
                           <span class="text">+1(602) 799-8605</span>
                        </li>
                        <li class="email clearfix">
                           <span class="hl">E-mail:</span>
                           <span class="text">rubendrotz@movingthroughcollege.com</span>
                        </li>
                     </ul>
                  </div>
                  <div class="widget widget_socials">
                     <div class="socials">
                        <a target="_blank" href="#"><i class="fab fa-yelp"></i></a>
                        <a target="_blank" href="#"><i class="fab fa-facebook-f"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div id="bottom" class="clearfix style-1">
            <div class="container">
               <div id="bottom-bar-inner" class="wprt-container">
                  <div class="bottom-bar-inner-wrap">
                     <div class="bottom-bar-content">
                        <div id="copyright">All Rights Reserved. Moving Through College © <?php echo date('Y'); ?></div>
                        <!-- /#copyright -->
                     </div>
                     <!-- /.bottom-bar-menu -->
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->
      <a href="#home" data-scroll class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>
      
      <script>
         const service = document.getElementById("service");
         const serviceDesc = document.getElementById("serviceDesc");
         const truckSize = document.getElementById("truckSize");
         function changeOption(value) {
            service.selectedIndex = value;
         }
         service.addEventListener('change', function() {
            if (service.value === 'Moving Labor') {
               serviceDesc.innerHTML = 'Is good for long distance moves where you want to do the driving yourself but don’t want to do the work of loading all the heavy furniture by yourself.';
               truckSize.style.display = 'none';
               truckSize.selectedIndex = 0;
            } else if (service.value === 'Labor and Truck') {
               serviceDesc.innerHTML = 'Is an affordable way to have all your belongs moved without having to deal with any of the heavy lifting or driving a giant truck.';
               truckSize.style.display = 'block';
               truckSize.selectedIndex = 1;
            } else if (service.value === 'Long Distance') {
               serviceDesc.innerHTML = 'Is for moves +100 miles. We will have moving truck, load, drive, and unload your belongings in a sufficient time.';
               truckSize.style.display = 'block';
               truckSize.selectedIndex = 1;
            } else {
               serviceDesc.innerHTML = '';
               truckSize.style.display = 'none';
               truckSize.selectedIndex = 0;
            }
         });
      </script>
      
      <!-- ALL JS FILES -->
      <script src="<?php bloginfo('template_url'); ?>/js/all.js"></script>
      <!-- ALL PLUGINS -->
      <script src="<?php bloginfo('template_url'); ?>/js/custom.js"></script>
      <script src="<?php bloginfo('template_url'); ?>/js/portfolio.js"></script>
      <script src="<?php bloginfo('template_url'); ?>/js/hoverdir.js"></script>
   </body>
</html>