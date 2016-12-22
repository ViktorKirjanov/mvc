
<div class="container">

    <form class="form-signin" action="/user/login" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>

        <label for="inputUsername" class="sr-only">Username</label>
        <input name="username" type="text" id="inputUsername" class="form-control" placeholder="Username" required="" autofocus="" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>">

        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="" value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>">

        <div class="checkbox">
            <label>
                <input name="remember" type="checkbox"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
    </form>

    <?php  if (isset($this->errors)) {
        foreach ($this->errors as $error) { ?>
            <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
        <?php } ?>
    <?php } ?>

</div>


