<?php $this->layout('site/base', ['title' => $title]); ?>

<article class="course-container">
    <header class="course-header">
        <picture class="image-container">
            <source media="(max-width: 768px)" srcset="<?= image("{$course->slug}-slide-320.webp"); ?>">
            <source media="(max-width: 1440px)" srcset="<?= image("{$course->slug}-slide-720.webp"); ?>">
            <img src="<?= image("{$course->slug}-slide.webp"); ?>" alt="<?= $course->slug; ?>" style="width:100%;">
        </picture>
        <h1 class="course-title">Curso <?= $course->name?></h1>
    </header>
    <p class="course-description">
        <?= $course->description; ?>
    </p>
</article>