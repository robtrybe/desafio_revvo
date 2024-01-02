<article class="course-card">
    <div class="cover-container">
        <img src="<?= image("{$course->slug}-cover.webp"); ?>" alt="<?= $course->slug; ?>" style="width:100%;">
    </div>
    <div class="course-info">
        <h2 class="title"><?= str_title($course->name); ?></h2>
        <p class="description"><?= str_limit_chars($course->description, 56); ?></p>
        <a 
            href="<?= url("/course/{$course->slug}/{$course->id}"); ?>"
            class="link-button"
            target="_blank" 
        >VER CURSO</a>
        <a 
            href="<?= url('/admin/course/'.$course->id.'/edit'); ?>" 
            class="edit-link-button"
        >
            EDITAR CURSO
        </a>
    </div>
</article>