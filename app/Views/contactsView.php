<div class="float-end">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" ><i class='bx bxs-user-circle' ></i> <?=session()->get('name')?></a>
        <ul class="dropdown-menu font-size" style="min-width: 100px !important;">
            <li><a class="dropdown-item text-center" href="/signout" style="padding: 0px 5px !important; font-size: 12px !important;">Sign Out</a></li>
        </ul>
        
</div>


<div class=''>
    <div class='' style='margin-right: 300px;margin-left: 300px;margin-top: 20px;'>
        <div>
            <br>    
                <h2><?=$title ?></h2>
            <br>
            <a  class=" float-end" data-bs-toggle="modal" data-bs-target="#modal" id="add-modal-button" href="#">
                Add Contacts
            </a>
            <br>
                <div>
                    <input type="text" name="search" placeholder="Search contact" id="search"><button id="search-button"class=""><i class='bx bx-search'></i></button>
                </div>
               
            <br>
            <div class="" id="">
                <table class="table table-responsive table-striped table-hover table-sm " id="">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" style='display: none'>Contact Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php $i=0;
                        $startNumber = ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1;
                        foreach($data as $index => $contact):
                        $itemNumber = $startNumber + $index;
                        ?>
                            <tr>
                                <td><?=$itemNumber?></td>
                                <td style='display: none'><?=$contact['contact_id']?></td>
                                <td><?=$contact['name']?></td>
                                <td><?=$contact['company']?></td>
                                <td><?=$contact['phone']?></td>
                                <td><?=$contact['email']?></td>
                                <td><span><a href='#' class='text-warning  edit-modal-button' data-bs-toggle='modal' data-bs-target='#modal' contact-id="<?=$contact['contact_id']?>"> Edit </a></span>
                                    &nbsp;<span> | </span>&nbsp;
                                    <span><a href='#' class='text-danger del-contact'> Delete</a></span>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <p>Displaying <?= (($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1) ?> to <?= min($pager->getCurrentPage() * $pager->getPerPage(), $total_items) ?> of <?= $total_items ?> items</p>
                <?= $pager->links('default','default_mypager') ?>
            </div>
        </div>
    </div>
</div> 


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="modal-title"></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="form-inputs">
            
        </div>
        <div class="modal-footer">
        
        </div>
    </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
$(document).ready(function(){

    $("#add-modal-button").on('click', function() 
    {
        var link = "add_contacts";
        var contact_id = "";
        var name = "";
        var company = "";
        var phone = "";
        var email = "";
        var formInput =input_form(link,contact_id,name,company,phone,email);
        $("#modal-title").empty().append('Add Contact');
        
        $("#form-inputs").empty().append(formInput);

    });

    $("#search-button").on('click', function() 
    {
        var search = $('#search').val();
        console.log(search);
      

            $.ajax({
                url:"<?= site_url('search_contacts')?>",
                method: "POST",
				data: {
                    search:search
					},
				dataType: "JSON",
                success:function (data) {
                //$("#tbody").empty();
                $('#tbody').html(data);
            }
                       
			});	
            event.preventDefault();
    });

    $("#tbody").on('click', '.edit-modal-button', function() 
    {
        var link = "edit_contacts";
        var contact_id = $(this).attr("contact-id");
        var currentRow=$(this).closest("tr");
        var name = currentRow.find("td:eq(2)").text();
        var company = currentRow.find("td:eq(3)").text();
        var phone = currentRow.find("td:eq(4)").text();
        var email = currentRow.find("td:eq(5)").text();

        var formInput =input_form(link,contact_id,name,company,phone,email);

        $("#modal-title").empty().append("Edit Contacts");
        $("#form-inputs").empty().append(formInput);
        console.log(contact_id);

    });

    $("#tbody").on('click', '.del-contact', function() 
    {
        var currentRow=$(this).closest("tr");
        var contact_id = currentRow.find("td:eq(1)").text();
        console.log(contact_id);

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                width: 350,
                heightAuto: false,
                position: 'top',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '<?= site_url('delete_contact')?>',
                        type: 'post',
                        data: { contact_id: contact_id

                        },
                        success: function(response) { console.log(response); }
                    });

                    Swal.fire({
                    width: 350,
                    heightAuto: false,
                    position: 'top',
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                    }).then(function(){
                        location.reload();
                    });
                
                }
        
            });
    });

});

    function input_form(link,contact_id,name,company,phone,email) {

        var formInput = " <form action='/"+link+"' method='post' id=''>";
            formInput += "<label style='display: none'><h6>Contact ID</h6></label>";  
            formInput += "<input style='display: none'type='text' name='contact_id' class='form-control input-sm' value='"+contact_id+"'>";
            formInput += "<label><h6>Name</h6></label>";  
            formInput += "<input type='text' name='name' class='form-control input-sm' value='"+name+"'>";
            formInput += "<label><h6>Company</h6></label>";
            formInput += "<input type='text' name='company' class='form-control input-sm' value='"+company+"'>";
            formInput += "<label><h6>Phone</h6></label>";
            formInput += "<input type='text' name='phone' class='form-control input-sm' value='"+phone+"'>";
            formInput += "<label><h6>Email</h6></label>";
            formInput += "<input type='text' name='email' class='form-control input-sm' value='"+email+"'>";
            formInput += "<br>";
            formInput += "<button type='submit' class='btn btn-primary float-end' name='submit-button'>Save</button>";
            formInput += " </form>";
            
            return formInput;


    }
</script>