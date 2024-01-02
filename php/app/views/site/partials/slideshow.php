<div class="slideshow-container content">
    <?php foreach($courseSlides as $slide) { ?> 
        <div class="mySlides fade">
          <div class="course-info">
            <h2><?= mb_strtoupper($slide->name); ?></h2>
            <p>
                <?= str_limit_chars($slide->description, 56); ?>
            </p>
            <a href="<?= url("/course/{$slide->id}"); ?>">VER CURSO</a>
          </div>
          <picture>
            <source media="(min-width:1440px)" srcset="<?= image($slide->slug.'-slide.webp'); ?>" >
            <source media="(min-width:768px)" srcset="<?= image($slide->slug.'-slide-720.webp'); ?>" >
            <img src="<?= image($slide->slug.'-slide-320.webp' ?? null); ?>" style="width:100%">
          </picture>
          <div class="text"><?= mb_strtoupper($slide->name); ?></div>
        </div>
    <?php } ?>

  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>

  <div style="text-align:center" class="dot-container">
    <div class="dot-wrapper">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
  </div>
</div>


