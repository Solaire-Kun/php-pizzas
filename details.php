<?php

include('./config/db_connection.php');

if (isset($_POST['order'])) {
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $sql = "DELETE FROM pizzas WHERE id = $id";
    if (mysqli_query($connection, $sql)) {
        header('Location: index.php');
    } else {
        echo 'query error: ' . mysqli_error($connection);
    }
}

// check GET request id param
if (isset($_GET['id'])) {

    // escape sql chars
    $id = mysqli_real_escape_string($connection, $_GET['id']);

    // make sql
    $sql = "SELECT * FROM pizzas WHERE id = $id";

    // get the query result
    $result = mysqli_query($connection, $sql);

    // fetch result in array format
    $pizza = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($connection);
}

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<div class="container">

    <?php if ($pizza): ?>
        <h1 class="flex-column d-flex text-center">Pizza Details</h1>
        <div class="card shadow-md m-auto w-50">
            <img src="./img/pizza.jpg" class="img-fluid" alt="">
            <div class="card-body">
                <h4 class="card-title text-center">
                    <?php echo htmlspecialchars($pizza['name']) ?>
                </h4>
                <h6>Ingredients:</h6>
                <ul>
                    <?php foreach (explode(',', $pizza['ingredients']) as $ing): ?>
                        <li class='card-text'>
                            <?php echo htmlspecialchars($ing) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <h6 class="card-text">
                    Created by: <br />
                    <?php echo htmlspecialchars($pizza['email']) ?>
                </h6>
                <h6 class="card-text">
                    Creation date: <br />
                    <?php echo htmlspecialchars($pizza['created_at']) ?>
                </h6>
                <h5 class="card-text">
                    Price: <br />
                    <?php echo htmlspecialchars($pizza['price']) ?> €
                </h5>
                <form class="p-auto m-auto" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <input type="hidden" name="id" value="<?php echo $pizza['id'] ?>">
                    <input type="submit" name="order" value="Order" class="btn w-100 btn-success">
                </form>
            </div>
        </div>

    <?php else: ?>
        <h5>No such pizza exists.</h5>
    <?php endif ?>
</div>

<?php include('templates/footer.php'); ?>

</html>