<div class=''>
    <div style='margin-right: 300px;margin-left: 300px;margin-top: 20px;'>
    <h2><?=$title ?></h2>
        <table class="table table-bordered text-center">
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
                <?php foreach($user_list as $users):?>
                <tr>
                    <td><?=$users['user_id']?></td>
                    <td><?=$users['name']?></td>
                    <td><?=$users['email']?></td>
                    <td><?=$users['password']?></td>
                </tr>
                <?php endforeach;?>
                
        </table>  
    </div>  
</div> 
    
 
    

