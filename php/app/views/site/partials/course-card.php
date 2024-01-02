<article class="course-card">
    <picture class="cover-container">
        <img src="<?= image($course->slug).'-cover.webp'; ?>" alt="Course"  style="with:100%;">
    </picture>
    <div class="course-info">
        <h2 class="title"><?= mb_strtoupper($course->name); ?></h2>
        <p class="description"><?= str_limit_chars($course->description, 56);?></p>
        <a href="<?= url("/course/{$course->slug}/{$course->id}"); ?>" class="link-button">VER CURSO</a>
    </div>
</article>