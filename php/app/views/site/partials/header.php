<header class="main-header">
    <div class="menu-container content">
        <div class="logo-container">
            <img src="<?= assets('/images/leo.png'); ?>" alt="leo">
        </div>
        <form action="#" class="search-form" >
            <input type="text" name="search" placeholder="Faça sua busca"><button type="submit" ><span class="icon-search"></span></button>
        </form>
        <ul class="menu">
            <li>
                <span class="profile"></span>
                <span class="welcome_user">
                    <span class="welcome">Seja bem-vindo</span>
                    <?php if(!session()->user) { ?>
                        <a style="text-decoration: none;" href="/login" class="user">Faça login</a>
                    <?php }else { ?> 
                        <span class="user"><?= session()->user->first_name. ' '. session()->user->last_name; ?></span>
                    <?php } ?>
                </span>
                <?php if(session()->user): ?>
                    <span class="drop-down icon-down" title="Exibir Menu"></span>
                <?php endif; ?>
                <?php if(session()->user): ?>
                    <ul class="sub-menu">
                        <li><a href="/logout">Sair</a></li>
                    </ul>
                <? endif; ?>
            </li>
        </ul>
    </div>
</header>