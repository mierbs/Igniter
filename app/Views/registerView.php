<div class=''>
    <div class='' style='margin-right: 600px;margin-left: 600px;margin-top: 20px;'>
        <div>
        <br>    
        <h2><?=$title ?></h2>
        <br>
            <?php if(isset($validation)):?>
                    <div class='alert alert-warning'>
                        <?=$validation->listErrors()?>
                    </div>
            <?php endif;?>
            <form action='/regcomplete' method='post'>
                <!-- <label>User Id</label>
                <input type='text' name='emp-no' class='form-control' value='<?=set_value('user_id')?>'> -->
                <label>Name</label>
                <input type='text' name='name' class='form-control' value='<?=set_value('name')?>'>
                <label>Email</label>
                <input type='text' name='email' class='form-control' value='<?=set_value('email')?>'>
                <div class="form-text">We'll never share your email with anyone else.</div>
                <label>Password</label>
                <input type='password' name='password' class='form-control' value='<?=set_value('password')?>'>
                <label>Confirm Password</label>
                <input type='password' name='confirmpassword' class='form-control'>
                <br>
                <button type='submit' class='btn btn-primary' name='submit-button'>Submit</button>
            </form>
        </div>
    </div>
</div>   