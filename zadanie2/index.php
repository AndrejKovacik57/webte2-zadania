<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="css.css">

    <title>Zadanie 2</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Slovník</h1>
    </div>
    <div class="container mt-5">
        <form id="search-form" class="row g-3">

            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" class="form-control form-control-lg" name="search" id="search"  placeholder="placeholder" autocomplete="off">
                    <label for="search" class="form-label">Zadajte slovo:</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <select class="form-select" name="language_code" id="language">
                        <option value="sk">Slovenčina</option>
                        <option value="en">English</option>
                    </select>
                    <label for="language" class="form-label">Vyberte jazyk:</label>
                </div>
            </div>

            <div class="col-md-3">
                <label for="popis" class="form-check-label  mt-3" >Význam slov</label>
                <input type="checkbox" class="form-check-input mt-4" id="popis" name="popis">
            </div>

            <div class="col-md-12">
                <div class="mb">
                    <button type="button" class="btn btn-outline-dark btn-lg" id="search-button">Vyhľadaj</button>
                </div>
            </div>


        </form>

        <div class="row" >
            <table id="result-table" class="table table-striped">
                <thead>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js" integrity="sha256-6XMVI0zB8cRzfZjqKcD01PBsAy3FlDASrlC8SxCpInY=" crossorigin="anonymous"></script>
    <script src="javascript.js"></script>



</body>
</html>
