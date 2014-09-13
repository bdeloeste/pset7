<div>
    <p class="lead text-success">
        Success!
    </p>
    <p class="text-success">
        A confirmation code has been sent to your e-mail.
    </p>
</div>
<div>
    <form action="confirmation.php" method="post">
        <fieldset>
            <div>
                Please enter the confirmation code:
            </div>
            <br />
                <div class="form-group">
                    <input class="form-control" name="reset" placeholder="Confirmation Code" type="text"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
        </fieldset>
    </form>
</div>

<a href="login.php">Home</a>
