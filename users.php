<?php
$databaseFile = 'database.json';
$database = file_exists($databaseFile) ? json_decode(file_get_contents($databaseFile), true) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Registered Users</h1>
    <table class="table table-bordered table-striped">
        <thead class="table-dark" >
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($database)): ?>
                <tr>
                    <td colspan="3" class="text-center">No registered users found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($database as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($user['image']); ?>" alt="User Image" class="img-thumbnail" width="30">
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-primary">Back to Registration</a>
</div>
</body>
</html>
