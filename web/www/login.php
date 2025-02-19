<!-- Sources used: https://getbootstrap.com/docs/5.3/forms/overview/#overview -->

<!DOCTYPE html>
<html lang="en">
<?php $title = 'Login'; $description = ''; $keywords = ''; include '/opt/src/templates/base.html';?>
<body>
    <?php include '/opt/src/templates/navbar.html';?>

    <h1>D&D Encounter Generator and Monster Creator</h1>
    <h3>Login to create and save custom monsters!</h3>

    <form>
        <div class="mb-3">
            <label for="inputUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="inputUsername">
        </div>
        <div class="mb-3">
            <label for="inputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <?php include '/opt/src/templates/footer.html';?>
</body>
</html>