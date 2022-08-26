<pre>
<?php
$path = realpath($_GET['path'])."/";
?>
</pre>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>File upload</title>
</head>
<body>
<header>
    <h1>File upload</h1>
</header>
<div class="container">
    <div class="top">
        <table class="sortable">
            <thead>
            <tr>
                <th class="name">Názov</th>
                <th class="size">Veľkosť</th>
                <th class="time">Čas vytvorenia </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $files = scandir($path);
            $default_path = "/var/www/site101.webte.fei.stuba.sk/zadaniadsf/zadanie1/uploads/";
            if (substr($path, 0, strlen($default_path)) != $default_path){
                exit("Invalid path: ".$path);
            }
            foreach ($files as $file)
            {

                if (is_dir($path.$file)){

                    if ($path == $default_path && ($file == "." || $file == ".."))
                    {
                        ?>
                        <tr>
                            <td class="name"><?php echo "$file"?></td>
                            <td class="size"></td>
                            <td class="time"></td>
                        </tr>
                        <?php
                    }else
                    {
                        ?>
                        <tr>
                            <td class="name"><a href="?path=<?php echo $path.$file."/"?>"><?php echo $file?></a></td>
                            <td class="size"></td>
                            <td class="time"></td>
                        </tr>
                        <?php
                    }

                }else
                {
                    ?>
                    <tr>
                        <td class="name"><?php echo $file?></td>
                        <td class="size"><?php echo (filesize($path.$file)/1000)."KB"?></td>
                        <td class="time"><?php echo date("d.m.Y h:i:s", filemtime($path.$file))?></td>
                    </tr>
                    <?php
                }

            }
            ?>
            </tbody>
        </table>

    </div>
    <div class="bottom">
        <div class="title">
            <h2>Formulár pre upload</h2>
        </div>
        <div class="content">
            <form  action="upload.php" enctype="multipart/form-data" method="post">
                <div class="newname">
                    <label for="title">Názov súboru</label>
                    <input type="text" id="title" name="title">
                </div>
                <div class="filechoose">
                    <label for="file">Súbor:</label>
                    <input type="file" name="fileToUpload">
                </div>
                <button class="uploadfile" type="submit">Upload</button>
            </form>
        </div>


    </div>

</div>


</body>
<script src="javascript/sorttable.js"></script>
<script src="javascript/js.js"></script>
</html>