<div class="container mt-5">
    <h2>Login</h2>
    <form action="login.php" method="post">
        <div class="mt-4">
            <label for="username">
                Username:
            </label>
            <input type="text" name="username" id="username" value="<?php echo isset( $_POST[ 'username' ] ) ? $_POST[ 'username' ]: ''; ?>" placeholder="Enter Username" class="form-control <?php echo empty( $errors[ 'username' ] ) ? '' : 'is-invalid'; ?>" required>
            <span class="invalid-feedback"><?php echo empty( $errors[ 'username' ] ) ? '' : $errors[ 'username' ]; ?></span>
        </div>

        <div class="mt-4">
            <label for="password">
                Password:
            </label>
            <input type="password" name="password" id="password" value="" placeholder="Enter password" class="form-control <?php echo empty( $errors[ 'password' ] ) ? '' : 'is-invalid'; ?>" required>
            <span class="invalid-feedback"><?php echo empty( $errors[ 'password' ] ) ? '' : $errors[ 'password' ]; ?></span>
        </div>

        <button type="submit" name="submit" value="login" class="btn btn-primary form-control mt-4">Login</button>
    </form>
</div>
