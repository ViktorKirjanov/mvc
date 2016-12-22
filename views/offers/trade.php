<div class="container">

    <h1>Trade</h1>

    <?php if (isset($this->errors)) {
        foreach ($this->errors as $error) { ?>
            <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
        <?php } ?>
    <?php } else { ?>
        <div class="alert alert-success" role="alert">Well Done!</div>
    <?php } ?>
</div>

