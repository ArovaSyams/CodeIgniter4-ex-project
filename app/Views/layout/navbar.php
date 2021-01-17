<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Stackware</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/home">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/contact">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/anime">Anime</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/teman">Teman</a>
            </li>
        </ul>
        <a href="/auth/logout" class="btn btn-danger mx-2" onclick="return confirm('Apakah anda yakin?')">Log Out</a>
        <form class="form-inline my-2 my-lg-0" action="" method="post">
            <input class="form-control mr-sm-2" type="text" placeholder="Cari Disini" aria-label="Search" name="keyword">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
        </form>
    </div>
</nav>