<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>Dashboard Template · Bootstrap v5.1</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">



  <!-- Bootstrap core CSS -->
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>userLogin
  <!-- Custom styles for this template -->
  <link href="./assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

<?php include 'header.php'; ?>

  <div class="container-fluid">
    <div class="row">
    <?php include 'sidebar.php'; ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <?php
        if ($_SESSION['userData']['role'] == 'admin') {
        ?>
          <div class="d-flex justify-content-between flex-wrap 
          flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
              </div>
              <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
              </button>
            </div>
          </div>

          <h2>Users</h2>
          <form action="searchUser" method="POST" class="row row-cols-lg-auto g-3 align-items-center">
            <div class="col-12">
                <label class="visually-hidden" for="inlineFormInputGroupUsername">Search</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inlineFormInputGroupUsername" 
                    name="searchField" placeholder="Enter id,name...">
                </div>
            </div>

            <div class="col-12">
                <button type="submit" name="searchUser" class="btn btn-primary">Search</button>
            </div>
        </form>

            <div class="col-12">
              <a class="btn btn-success" href="signup">Add User</a>
            </div>
          <div class="table-responsive">
            <form action="userAction" method="POST">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Full Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Role</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($data as $value) {
                    echo "<tr>
                  <td>" . $value->id . "</td>
                  <td>" . $value->name . "</td>
                  <td>" . $value->email . "</td>
                  <td>" . $value->role . "</td>
                  <td>" . $value->status . "</td>";

                  if ($value->status == "Not Approved") {
                        echo "<td><button class='btn btn-success' 
                      type='submit' name = 'approve' value = " . $value->id . ">
                      Approve</button>

  ";
                    } else {
                      echo "<td><button class='btn btn-danger' 
                      type='submit' name = 'restrict' value = " . $value->id . ">
                      Restrict</button>
  ";
                    }
                    echo "<button class='btn btn-danger' type='submit' 
                  name = 'deleteUser' value = " . $value->id . ">Delete</button></td>
  </td></tr> ";
                  }
                
                ?>
              </tbody>
            </table>
            </form>
          </div>
          
        <?php } elseif ($_SESSION['userData']['role'] == 'user') {
        ?>

          <h1 class="h3 mb-3 fw-normal">Hello&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['userData']['name']; ?></h1>
          <hr>
          <form action="" method="post">
            <h1 class="h3 mb-3 fw-normal">My Profile</h1>

            <div class="form-floating">
              <input type="text" class="form-control" id="floatingInput" name="full_name" placeholder="Full Name" value="<?php echo $_SESSION['userData']['name']; ?>" disabled>
              <label for="floatingInput">Full Name</label>
            </div>

            <div class="form-floating">
              <input type="text" class="form-control" id="floatingInput" name="email" placeholder="Full Name" value="<?php echo $_SESSION['userData']['email']; ?>" disabled>
              <label for="floatingInput">Email</label>
            </div>

            <div class="form-floating">
              <input type="text" class="form-control" id="floatingInput" name="role" placeholder="Role" value="<?php echo $_SESSION['userData']['role']; ?>" disabled>
              <label for="floatingInput">Role</label>
            </div>


            <!-- <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit" value="update">Update</button> -->
            <p class="mt-5 mb-3 text-muted">&copy; CEDCOSS Technologies</p>
          </form>

        <?php } ?>
      </main>
    </div>
  </div>


  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" 
  integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
  crossorigin="anonymous"></script>
</body>

</html>