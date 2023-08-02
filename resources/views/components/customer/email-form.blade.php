<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>EMAIL CAMAIGN</h4>
                    <br/>
                    <label>Subject</label>
                    <input id="subject" placeholder="Subject" class="form-control" type="text"/>
                    <label>Content</label>
                    <textarea id="content" name="content"  placeholder="content" class="form-control" type="text"></textarea>
                    <br/>
                    <button onclick="SendEmail()"  class="btn w-100 float-end btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    async function SendEmail(){

        let subject = document.getElementById("subject").value;
        let content = document.getElementById("content").value;

        showLoader();
        let res = await axios.post("/emailCampaign",{subject:subject,content:content});
        hideLoader();

        if(res.status===200 && res.data['status']==='success'){
            successToast(res.data['message']);
        }else{
            errorToast(res.data['message']);
        }
    }


</script>