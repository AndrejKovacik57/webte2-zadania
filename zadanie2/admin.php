<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap.css">
    <title>Zadanie 2</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Slovník - admin</h1>
    </div>
    <div class="container mt-5">
        <form action="addCsv.php" method="POST" enctype="multipart/form-data" class="row g-3 mb-5">
            <h4>Csv upload</h4>
            <div class="col-md-4 mt-0">
                <label for="file" class="form-label "></label>
                <input type="file" name="file" class="form-control" id="file">
            </div>
            <div>
                <input type="submit" class="btn btn-outline-dark" value="Upload">
            </div>
        </form>

        <form action="addTerm.php" method="POST" class="row g-3 mb-5">
            <h4>Pridaj výraz</h4>
            <div class="col-md-6 form-floating">
                <input type="text" name="add_term" class="form-control form-control-lg" id="add_term" placeholder="placeholder" autocomplete="off">
                <label for="add_term" class="form-label">Výraz na pridanie:</label>
            </div>
            <div>
                <input type="submit" class="btn btn-outline-dark" value="Upload">
            </div>
        </form>

        <form id="delete-form" class="row g-3 mb-2">
            <h4>Vyhľadaj výraz (vymazanie/úprava)</h4>
            <div class="col-md-6 form-floating">
                <input type="text" name="delete-search" class="form-control form-control-lg" id="delete-search" placeholder="placeholder" autocomplete="off">
                <label for="delete-search" class="form-label">Zadajte slovo:</label>
            </div>
            <div>
                <button type="button" class="btn btn-outline-dark" id="search-button-admin">Vyhľadaj</button>
            </div>
        </form>
        <div id="admin-table" class="row g-3 mb-5">
            <table id="result-table-admin" class="table table-striped">
                <thead>

                </thead>
                <tbody>

                </tbody>
            </table>
            <div>

                <form id="update-form" action="update.php" method="POST" class="row g-3 mb-5">
                    <h4>Uprav výraz</h4>
                    <div class="col-md-6 form-floating">
                        <input type="number" name="word-id-update" class="form-control form-control-lg" id="word-id-update"   placeholder="placeholder" autocomplete="off">
                        <label for="word-id-update"  class="form-label">Id slova:</label>
                    </div>

                    <div class="col-md-12 form-floating">
                        <input type="text" name="term-update" class="form-control form-control-lg" id="term-update" placeholder="placeholder" autocomplete="off">
                        <label for="term-update"  class="form-label">Nový výraz:</label>
                    </div>

                    <div>
                        <input type="submit" class="btn btn-outline-dark" value="Update">
                    </div>

                </form>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js" integrity="sha256-6XMVI0zB8cRzfZjqKcD01PBsAy3FlDASrlC8SxCpInY=" crossorigin="anonymous"></script>
<script src="javascript_admin.js"></script>


</body>
</html>
