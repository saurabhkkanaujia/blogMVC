<?php
// print_r($data);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        html {
            font-size: 62.5%;
        }

        .posts-listing {
            display: flex;
            flex-wrap: wrap;
            max-width: 1360px;
            margin: 0 auto;
        }

        .post-item {
            width: calc(33.33% - 40px);
            margin: 20px;
            flex: 0 0 auto;
            font-family: "Lato", sans-serif;
            font-size: 1.6rem;
        }

        .post-item__inner {
            display: flex;
            flex-direction: column;
            height: 100%;
            border-radius: 4px;
            background-color: #F7F8F8;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow .2s;
            color: black;
            text-decoration: none;
        }

        .post-item__thumbnail-wrapper {
            width: 100%;
            height: 0;
            padding-bottom: 60%;
            flex: 0 0 auto;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
            overflow: hidden;
            transition: clip-path .2s;
        }

        .post-item__thumbnail {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-size: cover;
            transition: transform .3s;
        }

        .post-item__thumbnail-wrapper:after {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            background-image: linear-gradient(to top, rgba(136, 27, 132, 0.2), rgba(162, 77, 211, 0.03));
        }

        .post-item__content-wrapper {
            padding: 2rem;
            position: relative;
            height: auto;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
        }

        .post-item__title {
            color: white;
            line-height: 1.6;
            margin-top: -4rem;
            font-size: 2.6rem;
            margin-bottom: 1rem;
        }

        .post-item__title span {
            display: inline;
            background-image: linear-gradient(to right, rgba(162, 77, 211), rgba(136, 27, 132));
            padding: .2rem .6rem;
            -webkit-box-decoration-break: clone;
            box-decoration-break: clone;
        }

        .post-item__metas {
            margin-bottom: 2rem;
        }

        .post-item__meta--date {
            color: #6d6d6d;
            letter-spacing: 0.01rem;
            font-size: 1.4rem;
        }

        .post-item__meta--category {
            display: inline-block;
            background-color: #a24dd3;
            color: white;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.01rem;
            font-weight: 700;
            padding: 2px;
        }

        .post-item__excerpt {
            margin-bottom: 2rem;
        }

        .post-item__read-more-wrapper {
            margin-top: auto;
        }

        .post-item__read-more {
            padding: 3px 0;
            display: inline;
            background-image: linear-gradient(#a24dd3, #a24dd3);
            background-repeat: no-repeat;
            background-size: 100% 2px;
            background-position: left bottom;
            transition: background-size .3s;
        }

        /* hover state */

        .post-item__inner:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .post-item__inner:hover .post-item__thumbnail-wrapper {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }

        .post-item__inner:hover .post-item__thumbnail {
            transform: scale(1.1);
        }

        .post-item__inner:hover .post-item__read-more {
            background-size: 30% 2px;
        }
    </style>
</head>

<body>
<?php include 'panel/header.php'; ?>

    <div class="container">
        
    
    <!-- Jumbotron -->
    <div id="intro" class="p-5 text-center bg-light">
      <h1 class="mb-0 h4 display-3 fw-bold">Blogs</h1>
      <div class="col-12 mt-5 text-start">
                <a class="btn btn-success fs-4" href="addPost">Add Post</a>
                <a class="btn btn-success fs-4" aria-current="page" href="dashboard">
              <span data-feather="home"></span>
              Dashboard
            </a>
    </div>
    </div>
    <!-- Jumbotron -->
        <section class="posts-listing">
            <?php
            foreach ($data as $key => $value) {
                echo ' <article class="post-item">
                <div class="post-item__inner">

                    <div class="post-item__thumbnail-wrapper">
                        <div class="post-item__thumbnail" style="background-image:url(image_url.jpg);"></div>
                    </div>

                    <div class="post-item__content-wrapper">
                        <h2 class="post-item__title heading-size-4"><span>' . $value->title . '</span></h2>


                        <div class="post-item__metas">
                            <time class="post-item__meta post-item__meta--date" datetime="">' . $value->time . '</time>
                            <p class="post-item__meta post-item__meta--category">' . $value->category . '</p>
                        </div>

                        <div class="post-item__excerpt">
                        ' . $value->description . ' </div>

                        <div class="post-item__read-more-wrapper">
                        <form action ="blog" method="POST">
                            <button class="btn fs-4 post-item__read-more" name = "singleBlog" value=' . $value->post_id . '>Read more</button>
                        </form>
                        </div>

                    </div>

                </div>
            </article>';
            }
            ?>
           


        </section>
    </div>

</body>

</html>