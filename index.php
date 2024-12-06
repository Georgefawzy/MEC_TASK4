<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $image = $_FILES['image'];

    $error = '';

    if ($image['error'] === 0) {
        $imageSize = $image['size'];
        $imageType = mime_content_type($image['tmp_name']);

        if (!in_array($imageType, ['image/jpeg', 'image/png', 'image/gif'])) {
            $error = 'Only image files (JPG, PNG, GIF) are allowed.';
        } elseif ($imageSize > 1024 * 1024) {
            $error = 'Image size must not exceed 1MB.';
        } else {
            if (!is_dir('uploads')) {
                mkdir('uploads',0755);
            }

            $imagePath = 'uploads/' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], $imagePath);

            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'image' => $imagePath
            ];

            $databaseFile = 'database.json';
            $database = file_exists($databaseFile) ? json_decode(file_get_contents($databaseFile), true) : [];
            $database[] = $userData;
            file_put_contents($databaseFile, json_encode($database));

            header('Location: users.php');
            exit;
        }
    } else {
        $error = 'Failed to upload the image.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Registration Form</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
