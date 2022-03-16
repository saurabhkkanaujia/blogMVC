<?php
?>
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
    <link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">


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

        .prodImg {
            height: 100px;
            width: 100px;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

    <?php include 'header.php' ?>

    <?php include 'sidebar.php' ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap
         flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Blogs</h1>
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

        <form action="searchPost" method="POST" class="row row-cols-lg-auto g-3 align-items-center">
            <div class="col-12">
                <label class="visually-hidden" for="inlineFormInputGroupUsername">Search</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inlineFormInputGroupUsername" 
                    name="searchField" placeholder="Enter id,title...">
                </div>
            </div>

            <div class="col-12">
                <button type="submit" name="searchPost" class="btn btn-primary">Search</button>
            </div>
        </form>

            <div class="col-12">
                <a class="btn btn-success" href="addPost">Add Post</a>
               
            </div>
        <div class="table-responsive">
            <form action="alterPost" method="POST">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            <?php if ($_SESSION['userData']['role'] == 'admin') {
                            echo '
                            <th scope="col">Permission</th>';
                            }
                            ?>
                            <th scope="col">View</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($data as $key => $value) {
                                echo "<tr>
                  <td>" . $value->id . "</td>
                  <td>" . $value->title . "</td>
                  <td>" . $value->category . "</td>
                  <td>" . $value->description . "</td>
                  <td>" . $value->status . "</td>
                  <td>
                    <a class = 'btn btn-primary' href='editPost?id=" . $value->id . "'>Edit</a>
                    <button class = 'btn btn-danger' type='submit' name = 'deletePost' 
                    value = " . $value->id . ">Delete</button>
                  </td>";
                    if ($_SESSION['userData']['role'] == 'admin') {
                        if ($value->status == "Not Approved") {
                            echo "<td><button class='btn btn-success' 
                        type='submit' name = 'approve' value = " . $value->id . ">
                        Approve</button></td>

        ";
                        } else {
                        echo "<td><button class='btn btn-danger' 
                        type='submit' name = 'restrict' value = " . $value->id . ">
                        Restrict</button></td>
        ";
                        }
                            
                        }
                        
                        echo '</form><form action ="blog" method="POST">
                        <td> <button class="btn btn-warning"
                              type="submit" name = "singleBlog" value = ' . $value->id . '>
                              View
                        </button></td>
                        </form></tr>';
                    }

                        ?>
                    </tbody>
                </table>
            
            
        </div>
    </main>
    </div>
    </div>


    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
    crossorigin="anonymous"></script>
</body>

</html>