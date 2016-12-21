<div class="container">
    <?php if ($this->signupResult) { ?>
        <div class="alert alert-success" role="alert">Well done! You have been successfully registered <a
                href="/user/login">You can Login now</a></div>
    <?php } else { ?>

        <form class="form-signup" action="/user/signup" method="post">
            <h2 class="form-signup-heading">Please sign up</h2>

            <label for="inputUsername" class="sr-only">Username</label>
            <input name="username" type="text" id="inputUsername" class="form-control" placeholder="Username"
                   required=""
                   autofocus="" value="<?php if (isset($username)) echo $username; ?>">

            <label for="inputFullName" class="sr-only">Full Name</label>
            <input name="fullname" type="fullname" id="inputFullName" class="form-control" placeholder="Full Name"
                   required="" value="<?php if (isset($username)) echo $username; ?>">

            <label for="inputPassword" class="sr-only">Password</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password"
                   required="" value="<?php if (isset($password)) echo $username; ?>">

            <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
        </form>

        <?php if (isset($this->errors)) {
            foreach ($this->errors as $error) { ?>
                <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
            <?php } ?>
        <?php }
    }
    ?>


</div>

