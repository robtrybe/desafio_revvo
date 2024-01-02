<?php $this->layout('site/base', ['title'=> $title]); ?>

<?php $this->insert('site/partials/modal', []); ?>

<?php $this->insert('site/partials/slideshow', ['courseSlides' => $courseSlides]); ?>


<section class="my-course-section content">
    <header>
        <?php if(session()->user): ?>
            <h1>MEUS CURSOS</h1>
        <?php else: ?>
            <h1>CONFIRA NOSSOS CURSOS</h1>
        <?php endif; ?>
    </header>
    <?php
        foreach($courses as $course) {
            $this->insert('site/partials/course-card', ['course' => $course]);
        }
    ?>
    <?= $this->insert('site/partials/course-card-plus', []); ?>
</section>
