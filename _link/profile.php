<form method="post" action="_action/adminHandler.php" id="formProfile"  data-on-finish="reload">
    <input type="hidden" name="action" value="profile-update">
    <input type="hidden" name="old-id" value="<?= $admin->adminId ?>">
    <div class="default bg-white">
        <label ><b>Username</b></label>
        <br/>
        <input type="text" name="id"  class="form-control" value="<?= $admin->adminId; ?>">
        <p></p>
        <label><b>Complete Name</b></label>
        <br/>
        <input type="text"  name="name" class="form-control" value="<?= $admin->name ?>">
        <p></p>
        <label><b>Email</b></label>
        <br/>
        <input type="email"  name="email" class="form-control" value="<?= $admin->email ?>">
        <p></p>
        <label><b>Password</b></label>
        <br/>
        <div class="collapse" id="collapsePass">
            <input type="password" name="old-pass" class="form-control" placeholder="Recent password">
            <br/>
            <input type="password" name="new-pass" class="form-control" placeholder="New password">
            <br/>
        </div>
        <button id="pPass" data-toggle="collapse" data-target="#collapsePass" type="button" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Change Password</button>
        <hr/>
        <button type="button" data-plugin="submit" data-target="#formProfile" class="btn btn-primary"><i class="icon-check2"></i> Save Changed</button>
    </div>
</form>