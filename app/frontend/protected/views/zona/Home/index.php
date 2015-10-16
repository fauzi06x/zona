<div class="slider">
    <div class="content">
        <div class="demo-2">
            <div id="slider" class="sl-slider-wrapper">
                <div class="sl-slider">
                    <?php
                    $sliderItems = array(1, 2, 3, 4, 5);
                    $sb = array(6, 7);
					$sliderItems = $sb;
                    foreach ($sliderItems as $sL) {
                        ?>
                        <div class="sl-slide" 
                             data-orientation="<?php echo $sL % 2 == 1 ? 'vertical' : 'horizontal' ?>" 
                             data-slice1-rotation="<?php echo (float) (rand(-200, 200) / 10) ?>" 
                             data-slice2-rotation="<?php echo (float) (rand(-200, 200) / 10) ?>" 
                             data-slice1-scale="<?php echo (float) (rand(-20, 20) / 10) ?>" 
                             data-slice2-scale="<?php echo (float) (rand(-20, 20) / 10) ?>">
                            <div class="sl-slide-inner">
                                <div class="bg-img bg-img-<?php echo $sL; ?>"></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    foreach ($sb as $sbI) {
                        ?>

                        <div class="sl-slide" data-orientation="<?php echo $sbI % 2 == 0 ? 'horizontal' : 'vertical' ?>" 
                             data-slice1-rotation="<?php echo rand(-25, 25); ?>" 
                             data-slice2-rotation="<?php echo rand(-25, 25); ?>" 
                             data-slice1-scale="<?php echo rand(-25, 25); ?>" 
                             data-slice2-scale="<?php echo rand(-25, 25); ?>">
                            <div class="sl-slide-inner">
                                <div class="bg-img bg-img-<?php echo $sbI; ?>"></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>       
                </div><!-- /sl-slider -->
                <nav id="nav-dots" class="nav-dots">
                    <span class="nav-dot-current"></span>
                    <?php
                    for ($i = 0; $i < (count($sliderItems) - 1); $i++) {
                        echo '<span></span>';
                    }
                    ?>
                </nav>
            </div><!-- /slider-wrapper -->
        </div><!-- demo2-->
       
    </div>
</div><!--ok-->

<div class="zonaitu">
    <div class="content">
        <div class="zonaservice">
            
        </div>
        <div class="zonaservice">
            
        </div>
        <div class="zonaservice">
            
        </div>

        <div class="marquee">
            <div>

               
            </div>
        </div>

    </div>
</div>

<div class="zonainfo">
    <div class="content">
        <div class="zonainfoleft">
           
            <br><br>
            <div class="emailinput">
                <input type="email" placeholder="Email Address">
                <div class="button orange notify"><b>Notify</b></div>
            </div>
        </div>

        <div class="zonainforight">
            <video width="356" height="200" controls>
                <source src="<?php //echo assets_url('GarudaIndonesia-B.mp4');    ?>" type="video/mp4">
            </video>
        </div>
    </div>
</div>

<div class="zonates">
    <div class="content">
        <br><br>
        <label>Heriyanto</label><br>
        <p> keren. Daftarnya ga ribet, layanannya cepet, cuma modal koneksi internet sama komputer aja, udah bisa jualan tiket.</p>
        <br><br>
        <b>Say Hi & Get in Touch</b><br>
        <span>Kunjungi akun sosial media untuk terus update Informasi dan promo</span>
        <div class="medsos">
            <a class="smallbulat"><i class="fa fa-twitter"></i></a>
            <a class="smallbulat"><i class="fa fa-facebook"></i></a>
            <a class="smallbulat"><i class="fa fa-pinterest-p"></i></a>
            <a class="smallbulat"><i class="fa fa-google-plus"></i></a>
            <a class="smallbulat"><i class="fa fa-linkedin"></i></a>
            <a class="smallbulat"><i class="fa fa-youtube"></i></a>
        </div>
    </div>
</div> 
