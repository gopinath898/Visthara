@extends('layout.mainlayout',['active_page' => 'about us'])

@section('title',__('About Us'))

@section('content')

<style type="text/css">
    label{
        padding: 5px;
    }
</style>

<style>
* {
  box-sizing: border-box;
}

/*.container {
  background-color: #f1f1f1;
}*/
.question{
    width: 95%;
}
.options{
    position: relative;
    padding-left: 40px;
}
#options label{
    display: block;
    margin-bottom: 15px;
    font-size: 14px;
    cursor: pointer;
}
.options input{
    opacity: 0;
}
.checkmark {
    position: absolute;
    top: -1px;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #555;
    border: 1px solid #ddd;
    border-radius: 50%;
}
.options input:checked ~ .checkmark:after {
    display: block;
}
.options .checkmark:after{
    content: "";
    width: 10px;
    height: 10px;
    display: block;
    background: white;
    position: absolute;
    top: 50%;
    left: 50%;
    border-radius: 50%;
    transform: translate(-50%,-50%) scale(0);
    transition: 300ms ease-in-out 0s;
}
.options input[type="radio"]:checked ~ .checkmark{
    background: #21bf73;
    transition: 300ms ease-in-out 0s;
}
.options input[type="radio"]:checked ~ .checkmark:after{
    transform: translate(-50%,-50%) scale(1);
}
.btn-primary{
    background-color: #555;
    color: #ddd;
    border: 1px solid #ddd;
}
.btn-primary:hover{
    background-color: #21bf73;
    border: 1px solid #21bf73;
}
.btn-success{
    padding: 5px 25px;
    background-color: #21bf73;
}
@media(max-width:576px){
    .question{
        width: 100%;
        word-spacing: 2px;
    } 
}

#regForm {
  /*background-color: #ffffff;*/
  margin: 100px auto;
  font-family: Raleway;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}

h1 {
  text-align: center;  
}

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #04AA6D;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #04AA6D;
}
</style>

<!-- <div class="page-banner-with-full-image item-bg3">
    <div class="container">
        <div class="page-banner-content-two">
            <h2>MMD - FAQ</h2>
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>FAQ</li>
            </ul>
        </div>
    </div>
</div> -->



<div class="full-content" style="background: #fbfbfbcc;">
   <div class="content px-lg-0 px-2 py-3 mx-auto">
        

<input type="hidden" id="nextval" value="0">

@php               
    $j=0;
    @endphp

  <form id="regForm" action="{{ url('finalsubmit')}}" method="post" style="padding: 50px;" onsubmit="return nextPrev(1)">

    <p class="showerorr hide" style="color: red;"> Please Select an option to proceed</p>
    @csrf
    <input type="hidden" name="category" value="{{$blog->id}}">
    @foreach($questions as $faq)


    

  <div class="tab">

    
        <div class="" style="padding-left: 25px;padding-top: 20px;">
            
            
        <div class="question ml-sm-5 pl-sm-5 pt-2">
        <div class="py-2 h5" style="font-size: 26px;"><b>Q. {{$faq->min_value}}</b></div>
        <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">

            <input type="hidden" name="questions[]" value="{{$faq->min_value}}">

                
                   
              <div style="margin: 10px;padding:15px;">      
                    @php 
                    $aswrs = explode(',',$faq->max_value);

                    $charges = explode(',',$faq->charges);
                    $i=0;
                    @endphp

            @foreach($aswrs as $aswr)
                                        

            <div class="form-check form-check-inline">
              <input class="form-check-input" id="val{{$j}}" type="radio" name="answers[{{$j}}]" required="true" value="{{$aswr.'++'.$charges[$i]}}" />
              <label class="form-check-label" for="inlineRadio1">{{$aswr}}</label>
            </div>

                    @php               
                    $i++;
                    @endphp

                    @endforeach
                  
                </div>
       </div>
   </div>
</div>
    
  </div>


    @php               
    $j++;
    @endphp

   @endforeach
  
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" class="btn default-btn" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" class="btn default-btn" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">

    @foreach($questions as $faq)
    <span class="step"></span>
    @endforeach
  </div>
</form>
</div>
</div>

<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function validate(){
    alert('ddd')
    return false;
}

function nextPrev(n) {

  idname = $('#nextval').val();
  valtab= $('#val'+idname+':checked').val();

  if(!valtab){
      $('.showerorr').show();
      return false;

  }else{
     $('.showerorr').hide();
  }

  idname = $('#nextval').val(+idname+1);
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>
    </div>
</div>
@endsection

