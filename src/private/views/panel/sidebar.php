<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
<?php if ($_SESSION['userData']['role']=='admin') {
?>
        <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="home">
              <span data-feather="home"></span>
              Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="posts">
              <span data-feather="file"></span>
              Blogs
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="users">
              <span data-feather="users"></span>
              Users
            </a>
          </li>
        </ul>
        
<?php } elseif ($_SESSION['userData']['role']=='user') {
?>      
          <ul>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="home">
              <span data-feather="home"></span>
              Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard">
              <span data-feather="home"></span>
              My Profile
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="posts">
              <span data-feather="home"></span>
              My Blogs
            </a>
          </li>          
        </ul>

<?php } ?>

      </div>
    </nav>