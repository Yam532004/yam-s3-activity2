<?php

function validate_message($message)
{
    // function to check if message is correct (must have at least 10 characters (after trimming))
    if (strlen(trim($message)) >= 10) {
        return true;
    }
    return false;
}

function validate_username($username)
{
    // function to check if username is correct (must be alphanumeric => Use the function 'ctype_alnum()')
    if (ctype_alnum($username)) {
        return true;
    }
    return false;
}

function validate_email($email)
{
    // function to check if email is correct (must contain '@')
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

$user_error = "";
$email_error = "";
$terms_error = "";
$message_error = "";
$username = "";
$email = "";
$message = "";

$form_valid = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $terms = isset($_POST['terms']);

    if (empty($username)) {
        $user_error = "Please enter a username";
    } elseif (!validate_username($username)) {
        $user_error = "Username should contain only letters and numbers";
    }

    if (empty($email)) {
        $email_error = "Please enter an email";
    } elseif (!validate_email($email)) {
        $email_error = "Email must contain '@'";
    }

    if (empty($message)) {
        $message_error = "Please enter your message";
    } elseif (!validate_message($message)) {
        $message_error = "Message must be at least 10 characters long";
    }

    if (!$terms) {
        $terms_error = "You must accept the Terms of Service";
    }

    if (empty($user_error) && empty($email_error) && empty($message_error) && empty($terms_error)) {
        $form_valid = true;
    }
}

?>

<form action="index.php" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username" value="<?php             
            echo $username; ?>">
            <small class="form-text text-danger"> <?php echo $user_error; ?></small>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter email" name="email" value="<?php echo $email; ?>">
            <small class="form-text text-danger"> <?php echo $email_error; ?></small>
        </div>
    </div>
    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"><?php echo $message; ?></textarea>
        <small class="form-text text-danger"> <?php echo $message_error; ?></small>
    </div>
    <div class="mb-3">
        <input type="checkbox" class="form-control-check" name="terms" id="terms" value="1" <?php
            $terms = isset($_POST['terms']);
            if ($terms) {
                echo 'checked';
            } ?>>
        <label for="terms">I accept the Terms of Service</label>
        <small class="form-text text-danger"> <?php echo $terms_error; ?></small>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<hr>

<?php if ($form_valid) :
?>
    <div class="card">
        <div class="card-header">
            <p><?php echo $username; ?></p>
            <p><?php echo $email; ?></p>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $message; ?></p>
        </div>
    </div>
<?php
endif;
?>