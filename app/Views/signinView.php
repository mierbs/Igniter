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
            <form action='/signin_verify' method='post'>
                <label>Email</label>
                <input type='text' name='email' class='form-control' value='<?=set_value('email')?>'>
                <div class="form-text">We'll never share your email with anyone else.</div>
                <br>
                <label>Password</label>
                <input type='password' name='password' class='form-control' value='<?=set_value('password')?>'>
                <br>
                <button type='submit' class='btn btn-primary btn-sm' name='submit-button'>Submit</button> <span><a href='/register' class='float-end'>Don't have an account yet?</a></span>
            </form>
        </div>
    </div>
</div>  