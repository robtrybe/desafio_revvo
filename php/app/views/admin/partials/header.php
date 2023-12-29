<header>
    <div class="menu-container" >
        <label for="menu-check" class="menu-button">
           <span class="line"></span>
           <span class="line"></span>
           <span class="line"></span>
        </label>
        <input type="checkbox" name="menu-check" id="menu-check" class="menu-check">
        <ul class="menu">
            <li><a href="<?= url('/admin'); ?>">Dashboard</a></li>
            <li><a href="<?= url('/admin/course/create'); ?>">Novo Curso</a></li>
        </ul>
    </div>
</header>