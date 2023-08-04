<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-8 col-lg-6">
            <div class="card border rounded shadow-sm p-3">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('images/Taposhi.png') }}" style="max-height: 150px; width: auto;" class="logo-dark" alt="">
                    </div>
                    <h4 class="text-center mt-3">SIGN IN</h4>
                    <br/>
                    <input id="email" placeholder="User Email" class="form-control mt-2" type="email"/>
                    <br/>
                    <input id="password" placeholder="User Password" class="form-control mt-2" type="password"/>
                    <br/>
                    <button onclick="SubmitLogin()" class="btn w-100 btn-primary mt-3">Next</button>
                    <hr style="margin-top: 15px; margin-bottom: 15px;">
                    <div class="text-center mt-2">
                        <a class="h6" href="{{url('/userRegistration')}}">Sign Up</a>
                        <span class="ms-1">|</span>
                        <a class="h6" href="{{url('/sendOTP')}}" target="_blank">Forget Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script>

    async function SubmitLogin() {
              let email=document.getElementById('email').value;
              let password=document.getElementById('password').value;
  
              if(email.length===0){
                  errorToast("Email is required");
              }
              else if(password.length===0){
                  errorToast("Password is required");
              }
              else{
                  showLoader();
                  let res = await axios.post("/user-login",{email:email, password:password});
                  hideLoader()
                  if(res.status===200 && res.data['status']==='success'){
                      window.location.href="/dashboard";
                  }
                  else{
                      errorToast(res.data['message']);
                  }
              }
    } 


</script>
