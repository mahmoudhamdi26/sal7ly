<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 2/12/17
 * Time: 4:20 PM
 */
?>

<script id="create-account-template" type="text/x-handlebars-template">
    <form class="form-horizontal">
        <div class="form-group row">
            <label class="col-lg-2 form-control-label">Name:</label>

            <div class="col-lg-8">
                <input type="text" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 form-control-label">Title:</label>

            <div class="col-lg-8">
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-8 offset-lg-2">
                <button class="btn primary btn-sm p-x-md">Save</button>
            </div>
        </div>
    </form>
</script>