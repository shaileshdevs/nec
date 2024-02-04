<div class="container mt-5">
    <h2>Register</h2>
    <form action="registration.php" method="post" enctype="multipart/form-data">
        <div class="mt-4">
            <label for="username">
                Username:
            </label>
            <input type="text" name="username" id="username" value="<?php echo isset( $_POST[ 'username' ] ) ? $_POST[ 'username' ]: ''; ?>" placeholder="Enter Username" class="form-control <?php echo empty( $errors[ 'username' ] ) ? '' : 'is-invalid'; ?>" required>
            <span class="invalid-feedback"><?php echo empty( $errors[ 'username' ] ) ? '' : $errors[ 'username' ]; ?></span>
        </div>

        <div class="mt-4">
            <label for="email">
                Email:
            </label>
            <input type="email" name="email" id="email" value="<?php echo isset( $_POST[ 'email' ] ) ? $_POST[ 'email' ]: ''; ?>" placeholder="Enter email" class="form-control <?php echo empty( $errors[ 'email' ] ) ? '' : 'is-invalid'; ?>" required>
            <div class="invalid-feedback"><?php echo empty( $errors[ 'email' ] ) ? '' : $errors[ 'email' ]; ?></div>
        </div>

        <div class="mt-4">
            <label for="password">
                Password:
            </label>
            <input type="password" name="password" id="password" value="" placeholder="Enter password" class="form-control <?php echo empty( $errors[ 'password' ] ) ? '' : 'is-invalid'; ?>" required>
            <span class="invalid-feedback"><?php echo empty( $errors[ 'password' ] ) ? '' : $errors[ 'password' ]; ?></span>
        </div>

        <div class="mt-4">
            <input type="file" name="profile_image" class="" accept="image/*">
        </div>
        <button type="submit" name="submit" value="registration" class="btn btn-primary form-control mt-4">Register</button>
    </form>
</div>