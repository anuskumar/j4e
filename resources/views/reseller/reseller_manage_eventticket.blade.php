<?php $page = 'events/list';
$val = $data[0];
?>
@extends('layouts.reseller_app')
@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-3">
                <h6>Listing ID: {{ $val['unique_id'] }}</h6>

            </div>
            <div class="col-md-3">
                  @if ($val['is_admin_approved'] == 1)
                                               @if($val['ticket_status'] == 1)
                                                <span class="badge text-bg-success">Active</span>
                                                @else
                                                    <span class="badge text-bg-primary">Paused</span>
                                                @endif
                                            @else
                                            <span class="badge text-bg-primary">Waiting for Approval</span>
                                            @endif
            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-3">
                @if($val['is_admin_approved'] <> 1)
                <button class="btn btn-danger" onclick="confirmDelete({{ $val['id'] }})">Delete Listing</button>
                <form id="delete-form-{{ $val['id'] }}" action="{{ route('ticket.listing.destroy', $val['id']) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex">
                <h3>{{ $val['ticket_type_name'] }}</h3>  &nbsp;<button type="button" class="btn btn-light" onclick="openTicketTypechangeModal()">
           <i class="fa fa-pencil"></i>
           </button>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-light" role="alert">
               <h5 class="text-danger"> Important Notification </h5>
               <div class="text-muted">
                <h6>There are some corrections needed on your profile that might effect your listing. Please Update your profile </h6>
               </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
               <div class="alert alert-light" role="alert">
                <b>Numbered Seats:</b> {{ $val['no_of_tickets'].' Ticket[s]' }}
               </div>
               <span><h3>
               <b class="text-primary"> {{ ucfirst($val['event_name']) }}</b>
            </h3></span>
            <h6><b>Tickets</b></h6>
            <p>
                All Seats need to be next to each other (adjesent). For unconfirmed seats, you need to create  a new listing.Breaking this rule can lead to charge becks of total sale price
            </p>
           <b>Section: <span class="text-muted">  {{ $val['seating_type_name'] }}</span></b>
           &nbsp;
           &nbsp;
           &nbsp;
           <b>Row: <span class="text-muted"> {{ $val['row']  }}</span></b>
           &nbsp;
           &nbsp;
           {{-- <button type="button" class="btn btn-light">
           <i class="fa fa-pencil"></i>
           </button> --}}
           <br>
           <div class="card border-dark mb-3 mt-3" style="max-width: 50rem;">
                <div class="card-body">
                    <h6 class="card-title">Listed Tickets</h6>
                    <table class="table table-borderd">
                        <tr>
                          <td>  <b>TYPE</b></td>
                            <td><b>SERIAL</b></td>
                            <td><b>SEAT NO.</b></td>
                            <td><b>ACTION</b></td>
                            <td><b>ON SALE</b></td></b>
                            <td><b>Ticket</b></td></b>
                        </tr>
                        @foreach ($data['tickets'] as $tickets)
                           <tr>
                            <td><b><span class="text-muted">{{ $tickets['seating_type_name'] }}</span></b></td>
                            <td><b><span class="text-muted">{{ $tickets['ticket_serial_number'] }}</span></b></td>
                            <td><b> <span class="text-muted">{{ $tickets['seat_number'] }}</span></b></td>
                            <td><button class="btn btn-primary btn-sm" onclick="editTicketData({{ $tickets['id'] }})"><b>Add Seat</b></button>
                            <button class="btn btn-danger btn-sm" onclick="deleteGeneratedTickets({{ $tickets['id'] }})"><b>Delete</b></button></td>
                            <td>
                                  <div class="form-check form-switch">
                                        <input class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="switchCheckChecked_{{ $tickets['id'] }}"
                                                data-id="{{ $tickets['id'] }}"
                                                data-status="{{ $tickets['on_sale']}}"
                                                onchange="confirmToggleStatus(this)"
                                                {{ $tickets['on_sale'] == 1 ? 'checked':'' }}

                                                value="{{ $tickets['on_sale'] }}">

                                            </div>
                            </td>
                            <td>
                    @if(@$tickets['file'])
                                <a href="{{asset('storage/'.@$tickets['file']) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2">
                                View
                            </a>
                    @endif
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>

                </div>

              <div class="card border-light mb-3" style="max-width: 50rem;">
                <div class="card-body">
                <div class="d-grid">
                    @if($val['ticket_type'] == 2 )
                <button class="btn btn-primary" type="button" onclick="uploadTicketImages()">Upload Tickets</button>
                    @endif
                </div>
                </div>
                </div>



                        <div class="card" style="width: 25rem;">
                        <div class="card-header">
                          <b> Price per Ticket </b>
                            <button type="button" class="btn btn-light float-right" onclick="ticketPriceChange({{ $val['id'] }})">
           <i class="fa fa-pencil"></i>
           </button>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Original Price : {{ $val['ticket_amount'].' '.$val['short_name'] }}</b>
           </li>
                            <li class="list-group-item"><b>Your Sale Price :  {{ $val['face_value'].' '.$val['short_name'] }}</b> </li>
                        </ul>
                        </div>

            </div>
            <div class="col-md-4">

                <div class="card border-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">Event Details</div>
                <div class="card-body">
                    <h6 class="card-title">Event Location</h6>
                    <p class="card-text"> {{ $val['venue_name'] }},{{ $val['city_name'] }},{{ $val['country_name'] }}</p>
                    @if ($val['google_map_link'])
                    <a class="text-success" href="{{ $val['google_map_link'] }}" target="_blank">View the venue Map</a>

                    @endif

                </div>
                <div class="card-body">
                    <h6 class="card-title">Event Starts at</h6>
                    <p class="card-text"> {{  date('d M Y',strtotime($val['event_from_date'])) }}  {{  $val['from_time'] }}</p>
                    <h6 class="card-title">Event Ends at</h6>
                    <p class="card-text"> {{  date('d M Y',strtotime($val['event_to_date'])) }}  {{  $val['to_time'] }}</p>

                </div>
                </div>
                    <div class="card border-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">Extra Details</div>
                    <div class="card-body">
                        <h6 class="card-title">Consessions</h6>
                        <p class="card-text">{{ $val['disclaimer_note'] }}</p>
                         <h6 class="card-title">Decription</h6>
                        <p class="card-text">{{ $val['description'] }}</p>

                        <h6 class="card-title">{{ $val['ticket_type_name'] }}</h6>
                    </div>
                    </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <a type="button" href="{{ route('reseller.mylistings') }}" class="btn btn-primary">Back To Listing</a>
            </div>
        </div>

    </div>

<div class="modal fade" id="tickcet-type-change-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('update.ticket.type') }}" method="POST" >
        <input type="hidden" name="ticket_id" value="{{ $val['id'] }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ticket Type</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <select class="form-select" aria-label="Default select example" name="ticket_type">
            <option>Select Ticket Type</option>
            @foreach ($ticket_type as $type)
            <option {{ $type['id'] == $val['ticket_type'] ? 'selected':'' }} value="{{ $type['id'] }}">{{ $type['ticket_type_name'] }}</option>
            @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>


<div class="modal fade" id="tickcet-data-change-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('update.ticket.seating') }}" method="POST" >
        <input type="hidden" name="generated_ticket_id" id="generated-ticket-id" >
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

         <span>Seat Number</span>
         <input type="number" class="form-control" name="seat_number" id="seat-number">
        <span>Serial Number</span>
         <input type="text" class="form-control" name="seat_serial_number" id="seat-serial-number">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>

<div class="modal fade" id="ticket-image-upload-type" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Tickets</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <div class="modal-body">
            <div class="row">
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upload Individual Tickets</h5>
                    <p class="card-text">There you can upload individual files on each tickets</p>
                   <button type="button" onclick="uploadTicketImagesIndividual()"  class="btn btn-primary">Upload Individually</button>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upload a Group of Tickets</h5>
                    <p class="card-text">There you can upload a single file having multiple ticket</p>
                    <button type="button" onclick="uploadTicketImagesgroup()" class="btn btn-primary">Upload Group of files</button>
                </div>
                </div>
            </div>
            </div>
</div>

    </div>

  </div>
</div>

<div class="modal fade" id="ticket-image-upload-individually" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Tickets</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" action="{{ route('tickets.uploadIndividual') }}" method="POST">
        @csrf
            <div class="modal-body">
                    <div class="row">
                <table class="table table-bordered">
            @foreach ($data['tickets'] as $tickets)
            <tr>
                <td><b><span class="text-muted">{{ $tickets['seating_type_name'] }}</span></b></td>
                <td><b><span class="text-muted">{{ $tickets['ticket_serial_number'] }}</span></b></td>
                <td><input type="hidden" name="seat_id[]" value="{{ $tickets['id'] }}">
                     <input type="file" name="files[{{ $tickets['id'] }}][]"  class="form-control mb-3">
                </td>


            </tr>
            @endforeach
            <tr>
      <td colspan="4">
        <div class="container">
          <button type="submit" style="float: right" class="btn btn-primary btn-sm mt-3">Upload Selected</button>
        </div>
      </td>
    </tr>
            <tr>

            </tr>
        </table>
            </div>
</div>
</form>
    </div>

  </div>
</div>


<div class="modal fade" id="ticket-image-upload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">

        <input type="hidden" name="ticket_id" value="{{ $val['id'] }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Tickets</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <div class="modal-body">
  <table class="table table-bordered">
    @foreach ($data['tickets'] as $tickets)
      <tr>
        <td><b><span class="text-muted">{{ $tickets['seating_type_name'] }}</span></b></td>
        <td><b><span class="text-muted">{{ $tickets['ticket_serial_number'] }}</span></b></td>
      </tr>
    @endforeach
    <tr>
      <td colspan="2">
        <div class="container">
          <h4>Upload PDF & Split Pages</h4>
          <input type="file" id="pdfInput" accept="application/pdf" class="form-control mb-3">
          <div class="page-links" id="output"></div>
          <button id="uploadBtn" class="btn btn-primary btn-sm mt-3">Upload Selected</button>
        </div>
      </td>
    </tr>
  </table>
</div>

    </div>

  </div>
</div>

<div class="modal fade" id="tickcet-price-change-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('update.ticket.pricechange') }}" method="POST" >
        <input type="hidden" name="ticket_id" value="{{ $val['id'] }}" >
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Ticket Pricing</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
         <div class="col-md-4">
         <span>Original Price</span>
         </div>
         <div class="col-md-4">

         <input type="text" class="form-control" value="{{ $val['ticket_amount']}}" name="original_price" id="original-price">
         </div>
         <div class="col-md-4">
            USD
         </div>
         </div>
        {{-- <span>Your Sale Price</span>
         <input type="text" class="form-control" value="{{ $val['face_value']}}" name="sale_price" id="sale-price"> --}}

           <div class="row">
         <div class="col-md-4">
         <span>Your Sale Price</span>
         </div>
         <div class="col-md-4">

         <input type="text" class="form-control" value="{{ $val['face_value']}}" name="face_value" id="face_value">
         </div>
         <div class="col-md-4">
            USD
         </div>
         </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Required for Laravel
        }
    });

    function openTicketTypechangeModal(){

        $('#tickcet-type-change-modal').modal('show');

    }

    function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}


function confirmToggleStatus(el) {
    const ticketId = el.getAttribute('data-id');
    const currentStatus = el.getAttribute('data-status');
    const newStatus = el.checked ? 1 : 0;

    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to ${newStatus ? 'activate' : 'deactivate'} this ticket.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed to update status
            updateTicketStatus(newStatus, ticketId);
        } else {
            // Revert the toggle switch to previous state
            el.checked = !el.checked;
        }
    });
}

function updateTicketStatus(newStatus, ticketId) {
    // Example AJAX
    fetch(`/tickets/update-ticket-sale-status/${ticketId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Updated!', data.message, 'success').then(function(){
            window.location.reload();

            });
            // Optionally refresh or update the badge
        } else {
            Swal.fire('Failed!', data.message, 'error').then(function(){
            window.location.reload();

            });

        }
    })
    .catch(error => {
        Swal.fire('Error!', 'Something went wrong.', 'error');
    });
}

function editTicketData(id){

     $.ajax({
            url: '/tickets/get-ticket-data',
            type: 'GET',
            data: {
               id:id,
            },
            success: function(response) {
            console.log(response);

                 $('#seat-number').val(response.data.seat_number);
                 $('#seat-serial-number').val(response.data.ticket_serial_number);
                 $('#generated-ticket-id').val(response.data.id);

                $('#tickcet-data-change-modal').modal('show');
                // console.log('Success:', response);
                // alert(response.message);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });


}

function uploadTicketImages(){

                $('#ticket-image-upload-type').modal('show');
}

function uploadTicketImagesgroup(){
                $('#ticket-image-upload-type').modal('hide');
                $('#ticket-image-upload').modal('show');
}

function uploadTicketImagesIndividual(){
                $('#ticket-image-upload-type').modal('hide');
                $('#ticket-image-upload-individually').modal('show');
}


</script>

<script>
  let splitPages = []; // store pages in memory

  document.getElementById("pdfInput").addEventListener("change", async function(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.type !== "application/pdf") {
      alert("Please upload a valid PDF file.");
      return;
    }

    const arrayBuffer = await file.arrayBuffer();
    const pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);

    const outputDiv = document.getElementById("output");
    outputDiv.innerHTML = "";
    splitPages = [];

    for (let i = 0; i < pdfDoc.getPageCount(); i++) {
      const newPdf = await PDFLib.PDFDocument.create();
      const [copiedPage] = await newPdf.copyPages(pdfDoc, [i]);
      newPdf.addPage(copiedPage);

      const pdfBytes = await newPdf.save();
      const blob = new Blob([pdfBytes], { type: "application/pdf" });
      const url = URL.createObjectURL(blob);

      // Save in memory
      splitPages.push({ blob, page: i+1, ticket: null });

      // Create wrapper
      const pageItem = document.createElement("div");
      pageItem.classList.add("page-item");
      pageItem.style.display = "flex";
      pageItem.style.alignItems = "center";
      pageItem.style.marginBottom = "8px";

      // Link
      const link = document.createElement("a");
      link.href = url;
      link.target = "_blank";
      link.textContent = `Preview Page ${i+1}`;
      link.style.marginRight = "10px";

      // Ticket selector
      const select = document.createElement("select");
      select.classList.add("form-select", "form-select-sm");
      select.style.width = "200px";
      select.innerHTML = `<option value="">Assign Ticket</option>
        @foreach ($data['tickets'] as $tickets)
          <option value="{{ $tickets['id'] }}">{{ $tickets['ticket_serial_number'] }}</option>
        @endforeach
      `;
      select.addEventListener("change", function() {
        splitPages[i].ticket = this.value;
      });

      // Delete button
      const deleteBtn = document.createElement("button");
      deleteBtn.classList.add("btn", "btn-danger", "btn-sm", "ms-2");
      deleteBtn.textContent = "Delete";
      deleteBtn.addEventListener("click", function() {
        pageItem.remove();
        splitPages[i] = null; // mark deleted
      });

      pageItem.appendChild(link);
      pageItem.appendChild(select);
      pageItem.appendChild(deleteBtn);
      outputDiv.appendChild(pageItem);
    }
  });

  // Upload assigned pages to backend
  document.getElementById("uploadBtn").addEventListener("click", async function() {
    const formData = new FormData();

    splitPages.forEach((page, idx) => {
      if (page && page.ticket) {
        formData.append("files[]", page.blob, `page_${page.page}.pdf`);
        formData.append("tickets[]", page.ticket);
      }
    });

    if (!formData.has("files[]")) {
      alert("Please assign at least one page to a ticket.");
      return;
    }

    // Send to Laravel route
    let response = await fetch("{{ route('tickets.uploadSplit') }}", {
      method: "POST",
      headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
      body: formData
    });

    let result = await response.json();
    // alert("Upload finished!");
    // console.log(result);

     Swal.fire('Updated Tickets!','', 'success').then(function(){
            window.location.reload();

            });
  });

  function ticketPriceChange(val){

     $('#tickcet-price-change-modal').modal('show');
  }

  function deleteGeneratedTickets(val){

    Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                  $.ajax({
            url: '{{ route("delete.generated.ticket") }}',
            type: 'GET',
            data: {
               id:val,
            },
            success: function(response) {
            console.log(response);
window.location.reload();

            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });

            }
        });

  }
</script>

<script>
$(document).ready(function() {
    // Attach validation on form submit
    $("#tickcet-price-change-modal form").on("submit", function(e) {
        let originalPrice = $("#original-price").val().trim();
        let faceValue = $("#face_value").val().trim();

        // Regex: integers or floats
        let numberPattern = /^[0-9]+(\.[0-9]+)?$/;

        if (!numberPattern.test(originalPrice)) {
            alert("Please enter a valid number for Original Price.");
            $("#original-price").focus();
            e.preventDefault();
            return false;
        }

        if (!numberPattern.test(faceValue)) {
            alert("Please enter a valid number for Sale Price.");
            $("#face_value").focus();
            e.preventDefault();
            return false;
        }

        return true; // allow submit
    });

    // Optional: live restriction (only numbers + dot allowed)
    $("#original-price, #face_value").on("keypress", function(e) {
        let charCode = e.which ? e.which : e.keyCode;
        // Allow: numbers (48–57), dot (46), backspace (8), delete (0)
        if ((charCode < 48 || charCode > 57) && charCode !== 46 && charCode !== 8 && charCode !== 0) {
            e.preventDefault();
        }
    });
});
</script>

@endsection
