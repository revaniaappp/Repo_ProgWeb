<!-- 2373028 - Revania Amelia Putri -->
<?php
$error_message = '';
$success = false;
$name = '';
$position = 'Senior Programmer';
$password = '';
$confirm_password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['reset'])) {
        $name = '';
        $position = 'Senior Programmer';
        $password = '';
        $confirm_password = '';
        $error_message = '';
    } elseif (isset($_POST['save'])) {
        $name = trim($_POST['name']);
        $position = $_POST['position'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        if (empty($name)) {
            $error_message = 'Input Nama belum di isi!';
        } elseif (empty($password)) {
            $error_message = 'Input Password belum di isi!';
        } elseif (empty($confirm_password)) {
            $error_message = 'Input Confirm Password belum di isi!';
        } elseif ($password !== $confirm_password) {
            $error_message = 'Password dan Confirm Password belum sama!';
        } else {
            $success = true;
        }
    }
} elseif (isset($_GET['back'])) {
    $success = false;
    $name = '';
    $position = 'Senior Programmer';
    $password = '';
    $confirm_password = '';
    $error_message = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2373028 - Revania Amelia Putri</title>
    <style>
        table {
            border-collapse: collapse;
            width: 400px;
            border: 1.5px solid black;
            margin: 20px auto;
        }
        
        th, td {
            border: 1.5px solid black;
            padding: 8px;
        }
        
        th {
            background-color: #ccc;
            font-size: 24px;
            text-align: center;
            font-weight: lighter;
        }

        select {
            padding: 4px;
        }
        
        .buttons {
            text-align: right;
        }
        

        .buttons button {
            margin-left: 5px;
            padding: 5px 10px;
        }
        
        .error {
            color: #ff0000;
            padding: 10px;
            margin: 10px auto;
            border-radius: 3px;
            width: 400px;
            text-align: center;
        }
        
        .berhasil {
            background-color: #d0d0d0;
            padding: 10px 15px;
            font-size: 16px;
             max-width: 200px;

        }


    </style>
</head>
<body>
    <?php if (!$success): ?>
    <form method="POST">
        <table>
            <tr>
                <th colspan="2">Add profile</th>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></td>
            </tr>
            <tr>
                <td>Position</td>
                <td>
                    <select name="position">
                        <optgroup label="Programmer">
                            <option value="Senior Programmer" <?php echo ($position == 'Senior Programmer') ? 'selected' : ''; ?>>Senior Programmer</option>
                            <option value="Programmer" <?php echo ($position == 'Programmer') ? 'selected' : ''; ?>>Programmer</option>
                            <option value="Junior Programmer" <?php echo ($position == 'Junior Programmer') ? 'selected' : ''; ?>>Junior Programmer</option>
                        </optgroup>
                        <optgroup label="System Analyst">
                            <option value="System Analyst" <?php echo ($position == 'System Analyst') ? 'selected' : ''; ?>>System Analyst</option>
                            <option value="Senior Analyst" <?php echo ($position == 'Senior Analyst') ? 'selected' : ''; ?>>Senior Analyst</option>
                            <option value="Junior Analyst" <?php echo ($position == 'Junior Analyst') ? 'selected' : ''; ?>>Junior Analyst</option>
                        </optgroup>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>"></td>
            </tr>
            <tr>
                <td>Confirm Password</td>
                <td><input type="password" name="confirm_password" value="<?php echo htmlspecialchars($confirm_password); ?>"></td>
            </tr>
            <tr>
                <td colspan="2" class="buttons">
                    <button type="submit" name="reset">Reset</button>
                    <button type="submit" name="save">Save</button>
                </td>
            </tr>
        </table>
    </form>
    
    <?php if (!empty($error_message)): ?>
    <div class="error">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
    <?php endif; ?>
    
    <?php else: ?>
    <div>
        <div>
            <div class="berhasil">Data yang Anda Masukkan!</div>
            <div>
                <div class="success-row">
                    <span class="success-label">Name</span>
                    <span>:&nbsp;</span>
                    <span class="success-value"><?php echo htmlspecialchars($name); ?></span>
                </div>
                <div class="success-row">
                    <span class="success-label">Position</span>
                    <span>:&nbsp;</span>
                    <span class="success-value"><?php echo htmlspecialchars($position); ?></span>
                </div>
                <a href="?back=1" >back</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>