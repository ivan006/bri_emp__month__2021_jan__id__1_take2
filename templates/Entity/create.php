<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="container">
    <h2>Stacked form</h2>
    {# templates/task/new.html.twig #}
    {{ form(form) }}
    <!-- <form action="/action_page.php">
      <div class="form-group">
        <label for="email">Name:</label>
        <input type="email" class="form-control" name="email">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email">
      </div>
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" name="pswd">
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form> -->
  </div>

</body>
</html>
