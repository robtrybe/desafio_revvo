<div class="slideshow-container content">

  <!-- Full-width images with number and caption text -->

    <?php foreach($courseSlides as $slide) { ?> 
        <div class="mySlides fade">
          <div class="numbertext">1 / 3</div>
          <picture>
            <source media="(min-width:1440px)" srcset="<?= image($slide->slug.'-slide.webp'); ?>" >
            <source media="(min-width:768px)" srcset="<?= image($slide->slug.'-slide-720.webp'); ?>" >
            <img src="<?= image($slide->slug.'-slide-320.webp' ?? null); ?>" style="width:100%">
          </picture>
          <div class="text"><?= $slide->name; ?></div>
        </div>
    <?php } ?>

  <!-- Next and previous buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>

  <!-- The dots/circles -->
    <div style="text-align:center" class="dot-container">
    <div class="dot-wrapper">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
    </div>
</div>


