<?php $this->layout('admin/base', ['title' => $title]); ?>

<section class="courses-section content">
    <div style="width: 100%;"><?= session()->flash(); ?></div>
    <?php
        foreach($courses as $course) {
            $this->insert('admin/partials/course-card', ['course' => $course]);
        }
    ?>
</section>