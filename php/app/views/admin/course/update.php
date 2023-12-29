<?php $this->layout('admin/base', ['title' => $title]); ?>

<? $this->insert('admin/partials/course/form-edit', ['course' => $course]); ?>