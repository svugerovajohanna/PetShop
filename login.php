<?php require __DIR__ . '/header.php'; ?>
<main class="container">
    <br>
    <h1 class="text-center">Přihlášení</h1>

    <div class="row justify-content-center">

    <form class="form-signup">

        <div class="form-group">
            <label>Email</label>
            <input class="form-control">
            <small>Ve tvaru example@gmail.com</small>
        </div>
        <div class="form-group">
            <label>Heslo</label>
            <input class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Přihlaš mě!</button>

        <div>
            <p>Ještě zde nemáte účet? <a href="registration.php"><b>Registrujte se!</b></a></p>
        </div>
</form>

</div>
</main>
<?php require __DIR__ . '/footer.php'; ?>