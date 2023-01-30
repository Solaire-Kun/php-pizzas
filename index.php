<?php

// connect to DB
include('./config/db_connection.php');

// get pizzas
$sql = 'SELECT name, ingredients, price, email, created_at, id FROM pizzas ORDER BY created_at';

// get results
$result = mysqli_query($connection, $sql);

// fetch as array
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free memory
mysqli_free_result($result);

// close connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<h1 class="text-center text-lead">Pizzas</h1>
<div class="container d-flex flex-row align-items-baseline">

    <?php foreach ($pizzas as $pizza): ?>
        <div class="card shadow-md mb-3 mx-2" style="width: 18rem;">
            <img src="./img/pizza.jpg" class="card-img-top" alt="">
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
                <a href="details.php?id=<?php echo $pizza['id'] ?>" class="btn btn-success">More Info</a>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<?php include('templates/footer.php'); ?>

</html>