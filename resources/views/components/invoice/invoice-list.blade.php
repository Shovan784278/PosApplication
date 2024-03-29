<!-- Modal -->
<div class="modal animated zoomIn" id="details-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Invoice</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="invoice" class="modal-body p-3">
                    <div class="container-fluid">
                        <br/>
                        <div class="row">
                            <div class="col-8">
                                <span class="text-bold text-dark">BILLED TO </span>
                                <p class="text-xs mx-0 my-1">Name:  <span id="CName"></span> </p>
                                <p class="text-xs mx-0 my-1">Email:  <span id="CEmail"></span></p>
                                <p class="text-xs mx-0 my-1">User ID:  <span id="CId"></span> </p>
                            </div>
                            <div class="col-4">
                                <img class="w-40" src="{{"images/logo.png"}}">
                                <p class="text-bold mx-0 my-1 text-dark">Invoice  </p>
                                <p class="text-xs mx-0 my-1">Date: {{ date('Y-m-d') }} </p>
                            </div>
                        </div>
                        <hr class="mx-0 my-2 p-0 bg-secondary"/>
                        <div class="row">
                            <div class="col-12">
                                <table class="table w-100" id="invoiceTable">
                                    <thead class="w-100">
                                    <tr class="text-xs text-bold">
                                        <td>Name</td>
                                        <td>Qty</td>
                                        <td>Total</td>
                                    </tr>
                                    </thead>
                                    <tbody  class="w-100" id="invoiceList">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr class="mx-0 my-2 p-0 bg-secondary"/>
                        <div class="row">
                            <div class="col-12">
                                <p class="text-bold text-xs my-1 text-dark"> TOTAL: <i class="bi bi-currency-dollar"></i> <span id="total"></span></p>
                                <p class="text-bold text-xs my-2 text-dark"> PAYABLE: <i class="bi bi-currency-dollar"></i>  <span id="payable"></span></p>
                                <p class="text-bold text-xs my-1 text-dark"> VAT(5%): <i class="bi bi-currency-dollar"></i>  <span id="vat"></span></p>
                                <p class="text-bold text-xs my-1 text-dark"> Discount: <i class="bi bi-currency-dollar"></i>  <span id="discount"></span></p>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-primary" data-bs-dismiss="modal">Close</button>
                <button onclick="PrintPage()" class="btn bg-gradient-success">Print</button>
            </div>
        </div>
    </div>
</div>


<script>

    getList();
    
    
    async function getList() {
    
    
        showLoader();
        let res=await axios.get("/invoice-select");
        hideLoader();
    
        let tableList=$("#tableList");
        let tableData=$("#tableData");
    
        tableData.DataTable().destroy();
        tableList.empty();
    
        res.data.forEach(function (item,index) {
            let row=`<tr>
                        <td>${index+1}</td>
                        <td>${item['customer']['name']}</td>
                        <td>${item['customer']['mobile']}</td>
                        <td>${item['total']}</td>
                        <td>${item['vat']}</td>
                        <td>${item['discount']}</td>
                        <td>${item['payable']}</td>
                        <td>
                            <button data-id="${item['id']}" data-cus="${item['customer']['id']}" class="viewBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm fa-eye"></i></button>
                            <button data-id="${item['id']}" data-cus="${item['customer']['id']}" class="deleteBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm  fa-trash-alt"></i></button>
                        </td>
                     </tr>`
            tableList.append(row)
        })
    
        $('.viewBtn').on('click', async function () {
            let id= $(this).data('id');
            let cus= $(this).data('cus');
            await InvoiceDetails(cus,id)
            $("#update-modal").modal('show');
        })
    
        $('.deleteBtn').on('click',function () {
            let id= $(this).data('id');
            document.getElementById('deleteID').value=id;
            $("#delete-modal").modal('show');
        })
    
        new DataTable('#tableData',{
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
        });
    
    }
    
    
    </script>
    
    