<div>
    <p class="lead text-danger">
        Invalid confirmation code!
    </p>
</div>
<div>
    <form action="confirmation.php" method="post">
        <fieldset>
            <div>
                Please enter a valid confirmation code:
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
