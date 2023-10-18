<!-- Modal -->
<div class="modal fade" id="signupmodal" tabindex="-1" role="dialog" aria-labelledby="signupmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signupmodalLabel">Sign up</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="handlesignup.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control SignupEmail" id="SignupEmail" name="SignupEmail"
                            aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="SignupPassword" name="SignupPassword">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" class="form-control" id="SignupcPassword" name="SignupcPassword">
                    </div>
                    <!-- Add admin code input field -->
                    <div class="form-group">
                        <label for="admin_code">Admin Code</label>
                        <input type="text" class="form-control" id="admin_code" name="admin_code" placeholder="Admin Code">
                    </div>

                    <button type="submit" class="btn btn-primary asd">signup</button>
                </div>
                <div class="modal-footer">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(".asd").click(function(e){
  console.log(12);
  e.preventDefault();
  $.post("http://localhost/cmsproject/handlesignup.php",
  {
    SignupEmail: $("#SignupEmail").val(),
    SignupPassword: $("#SignupPassword").val(),
    SignupcPassword: $("#SignupcPassword").val(),
    admin_code: $("#admin_code").val(),
  },
  function(data, status){
    console.log(data);
    alert(data.msg);
    $(location).attr('href',  'index.php');
  });
});
</script>
