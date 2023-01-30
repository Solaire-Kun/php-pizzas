<?php

// connect to DB
include('./config/db_connection.php');

$email = $name = $ingredients = '';
$price = 0;
$errors = array('email' => '', 'name' => '', 'ingredients' => '', 'price' => '');

if (isset($_POST['submit'])) {

    // check email
    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required <br />';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        }
    }

    // check pizza name
    if (empty($_POST['name'])) {
        $errors['name'] = 'A pizza name is required <br />';
    } else {
        $name = $_POST['name'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            $errors['name'] = 'Pizza name must be letters and spaces only';
        }
    }

    // check ingredients
    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] = 'At least one ingredient is required <br />';
    } else {
        $ingredients = $_POST['ingredients'];
        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
            $errors['ingredients'] = 'Ingredients must be a comma separated list';
        }
    }

    // check price
    if (empty($_POST['price'])) {
        $errors['price'] = 'Please insert price <br />';
    } else {
        $price = $_POST['price'];
        if (!preg_match("/^\\d+$/", $price)) {
            $errors['price'] = 'Price must be a number';
        }
    }

    // redirect if no errors
    if (array_filter($errors)) {

    } else {
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $ingredients = mysqli_real_escape_string($connection, $_POST['ingredients']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);

        $sql = "INSERT INTO pizzas(email, name, ingredients, price) VALUES('$email', '$name', '$ingredients', '$price')";

        if (mysqli_query($connection, $sql)) {
            header('Location: index.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<form action="add-pizza.php" method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" name="email" class="form-control" placeholder="Email"
            value="<?php echo htmlspecialchars($email) ?>">
        <div class="text-danger">
            <?php echo $errors['email']; ?>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Pizza Name</label>
        <input type="name" name="name" class="form-control" placeholder="Pizza Name"
            value="<?php echo htmlspecialchars($name) ?>">
        <div class="text-danger">
            <?php echo $errors['name']; ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="ingredients" class="form-label">Ingredients:</label>
        <input type="ingredients" name="ingredients" class="form-control" placeholder="Pizza Ingredients"
            value="<?php echo htmlspecialchars($ingredients) ?>">
        <div class="form-text text-info">Separete ingredients using "," comma</div>
        <div class="text-danger">
            <?php echo $errors['ingredients']; ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price:</label>
        <input type="number" name="price" class="form-control" placeholder="0"
            value="<?php echo htmlspecialchars($price) ?>">
        <div class="text-danger">
            <?php echo $errors['price']; ?>
        </div>
    </div>
    <input type="submit" name="submit" value="Submit" class="btn btn-success">
</form>

<?php include('templates/footer.php'); ?>

</html>