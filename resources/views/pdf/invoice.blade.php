<!DOCTYPE html>
<html>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;   
    }
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:200px;
        height:60px;        
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
    .invoice-footer {
        border-top: 1px solid #ddd;
        padding-top: 10px;
        font-size: 10px;
    }
    
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-0 p-0"><u>Tax Invoice</u></h1>
</div>
<div class="body">
    <div class="add-detail mt-10">
        <div class="w-50 float-left mt-10">
            <h3 class="m-0 pt-5"><u>Customer Details</u></h3>
            <p class="m-0 pt-5 text-bold w-100">Name - <span class="gray-color">{{ $appointment->user['name'] }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">Phone - <span class="gray-color">{{ $appointment->user['phone'] }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">Email - <span class="gray-color">{{ $appointment->user['email'] }}</span></p>
        </div>
        <div class="w-50 float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">Invoice Number - <span class="gray-color">{{ $appointment->invoice_id ?? '' }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">Date - <span class="gray-color">{{ date("d F, Y") }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">Payment Method - <span class="gray-color">{{ $appointment->payment_type }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">Transaction Id - <span class="gray-color">{{ $appointment->payment_id ?? '' }}</span></p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">S. No.</th>
                <th class="w-50">Package Name</th>
                <th class="w-50">Price</th>
                <th class="w-50">Discount</th>
                <th class="w-50">Taxable Value</th>
                <th class="w-50">IGST</th>
                <th class="w-50">CGST</th>
                <th class="w-50">SGST</th>
                <th class="w-50">Total</th>
            </tr>
            <tr align="center">
                <td>1</td>
                <td>{{$appointment->package->name}}</td>
                <td>{{$appointment->amount}}</td>
                <td>{{$appointment->discount_price ?? 0}}</td>
                <td>{{$appointment->amount}}</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>{{$appointment->amount}}</td>
            </tr>
        </table>
    </div>
    <div class="add-detail mt-10">
        <div class="w-50 float-left mt-10"></div>
        <div class="w-50 float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">Total Taxable Value : <span class="gray-color">{{ $appointment->amount }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">Total Tax : <span class="gray-color">0</span></p>
            <p class="m-0 pt-5 text-bold w-100">Total Payable : <span class="gray-color">{{ $appointment->amount }}</span></p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="add-detail mt-10">
        <div class="w-50 float-right mt-10">
            <p class="mb-2 pt-5 text-bold w-100">Email : <span class="gray-color">{{ $setting->email }}</span></p>
            <p class="mb-2 pt-5 text-bold w-100">Website : <span class="gray-color">{{ $setting->website }}</span></p>
            <p class="mb-2 pt-5 text-bold w-100">Contact : <span class="gray-color">{{ $setting->phone }}</span></p>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>
<div class="invoice-footer">
   <ul>
    <li>All figures in INR</li>
    <li>This is a computer generated invoice, does not require signature.</li>
   </ul>
</div>
</html>
