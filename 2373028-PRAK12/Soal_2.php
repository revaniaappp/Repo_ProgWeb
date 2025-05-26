<!-- 2373028 - Revania Amelia Putri -->
<?php
$page = 'login';
$username = '';
$password = '';
$error_username = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === 'admin' && $password === 'admin') {
        $page = 'success';
    } else {
        $page = 'error';
        $error_username = $username;
    }
}

if (isset($_GET['back']) && $_GET['back'] == '1') {
    $page = 'login';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>2373028-Revania Amelia Putri<?php echo $page == 'login' ? 'Login Form' : ($page == 'success' ? 'Login Berhasil' : 'Login Error'); ?></title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            background-color: navy;
            color: white;
            font-size: 4rem;
            text-align: center;
            width: 100%;
            max-width: 800px;
            padding: 20px 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
        }

        .inputan {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .inputan input {
            width: 65%;
            height: 30px;
            font-size: 1rem;
            border: 1px solid lightslategray;
            padding: 0 8px;
        }


        button {
            padding: 8px 20px;
            font-size: 1rem;
            cursor: pointer;
        }

        hr {
            width: 100%;
            max-width: 800px;
            margin: 30px 0 10px 0;
        }

        footer {
            font-size: 1rem;
            text-align: left;
            width: 100%;
            max-width: 800px;
            padding: 0 10px 20px 10px;
        }

        .hasil {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            text-align: left;
        }

        .judulberhasil {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: black;
        }

        .textAdmin {
            color: blue;
            font-weight: bold;
            font-size: 25px;
        }

        .error {
            font-size: 1rem;
            margin: 0 0 15px 0;
        }

        .unameEror {
            font-weight: normal;
        }

        .textEror {
            color: red;
            font-weight: bold;
        }

    </style>
</head>

<body>
    <?php if ($page == 'login'): ?>
        <div class="header">Login</div>

        <div class="container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="inputan">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required />
                </div>

                <div class="inputan">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>
                
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>

        <hr>
        <footer>
            @UKM2014<br />
            Revania Amelia Putri ~ 2373028 &copy;
        </footer>

    <?php elseif ($page == 'success'): ?>
        <div class="hasil">
            <div class="judulberhasil">Login berhasil!</div>
            <div class="success-message"><b>Selamat datang,</b> <span class="textAdmin">admin</span>.</div>
            <a href="?back=1">kembali ke halaman login</a>
        </div>

    <?php elseif ($page == 'error'): ?>
        <div class="hasil">
            <div class="error">
                <strong class="textEror">Username :</strong> 
                <span class="unameEror"><?php echo htmlspecialchars($error_username); ?></span> 
                <span class="textEror">Tidak Terdaftar!</span>
            </div>
            <a href="?back=1">kembali ke halaman login</a>
        </div>

    <?php endif; ?>

    <script>
    document.querySelector('button[type="submit"]').addEventListener('click', function () {
        this.closest('form').submit();
    });
    </script>
</body>
</html>