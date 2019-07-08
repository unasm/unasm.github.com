<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title><?php echo $title ?></title>
        <link rel="stylesheet" href="./css/index.css" type="text/css" media="all" />
    </head>
<body>
    <section class = "self clearfix">
        <article>
            <section>
                <h1>hi,my name is <em>tianyi </em></h1>
                <p>here is my personal blog , It recordes some of my article ,which I write down when I am programing ,or studing ,or just make for fun。</p>
            </section>
        </article>
        <firgure>
            <figcaption style = "display:none">我年轻的时候的照片</figcaption>
            <img src = "image/self.jpg" title = "我年轻的时候的照片"/>
        </firgure>
    </section>
    <nav>
    <ol>
        <?php foreach($fileList as $data):?>
            <li>
                <a href = "<?php  echo $domain . $data?>">
                    <?php  echo substr($data  , 0 , strlen($data) - 5)?>
                </a>
            </li>
        <?php endforeach?>
    </ol>
    </nav>
</body>
<!--
<script type="text/javascript" charset="utf-8" src = "jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src = "head.js"></script>
-->
</html>
