<?php $this->layout('site/base', ['title'=> $title]); ?>

<section class="my-course-section content">
    <header>
        <h1>MEUS CURSOS</h1>
    </header>
    <?php
        for($i= 0; $i < 7; $i++) {
            $this->insert('site/partials/course-card', []);
        }
        $this->insert('site/partials/course-card-plus', []);
    ?>
</section>
