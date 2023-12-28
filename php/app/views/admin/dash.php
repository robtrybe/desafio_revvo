<?php $this->layout('admin/base', ['title' => $title]); ?>

<section class="courses-section content">
    <?php
        for($i = 0; $i < 8; $i++) {
            $this->insert('admin/partials/course-card', []);
        }
    ?>
</section>