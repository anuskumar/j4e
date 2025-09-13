@extends('layout.mainlayout')
@section('content')
<link href="https://just4entertainment.com/public/assets/css/toastr.min.css" rel="stylesheet">
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


<style>
    .col-md-6::-webkit-scrollbar {
        width: 5px;
    }

    .col-md-6::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .col-md-6::-webkit-scrollbar-thumb {
        background: #b3b2b2;
        border-radius: 4px;
    }

    .col-md-6::-webkit-scrollbar-thumb:hover {
        background: #b3b2b2;
    }

    .image-container {
    position: relative;
    overflow: hidden;
    cursor: grab;
}

.zoomable-image {
    width: 100%;
    height: 500px;
    border-radius: 5px;
    transition: transform 0.3s ease, filter 0.3s ease;
    transform-origin: center center; /* Ensure zoom focuses on the image center */
    cursor: grab;
}

.zoom-controls {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.zoom-btn {
    background-color: rgb(255, 255, 255);
    color: rgb(152, 150, 150);
    border: 1px solid rgb(150, 150, 150);
    border-radius: 3px;
    padding: 5px;
    cursor: pointer;
    font-size: 18px;
    outline: none;
    transition: background-color 0.3s ease;
}



/* Zoom effect on hover */
.image-container:hover .zoomable-image {
    transform: scale(1.1);
}
</style>


<div class="container">
    <div class="row" style="margin-top: 25px;">
        <!-- Left Section -->
        <div class="col-md-6">
            <div class="card ">
                <div class="row align-items-center" style="padding: 10px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3); ">
                    <div class="col-md-3">
                        <img src="{{ Storage::disk('image')->url('uploads/events/' . @$event_datas->event_image) }}" alt="Event Image" class="img-fluid rounded" style="width: 100%; height: auto;">
                    </div>
                    <div class="col-md-9">
                        <h4 class="doc-name">{{ Str::ucfirst(@$event_datas->event_name) }}</h4>
                        {{ \Carbon\Carbon::parse($event_datas->event_from_date)->format('d M • D • Y•') ?? '' }}
                        <span>{{ $event_timing ->from_time ?? ''}}</span>
    {{-- To
    {{ \Carbon\Carbon::parse($event_datas->event_to_date)->format('d M • D • H:i • Y') ?? '' }} --}}
                        <p style="margin: 0; color: #555;">{{ @$event_datas->location_name }}, {{ @$event_datas->country_name }}</p>
                    </div>
                    <div class="col-md-12 text-center mt-3">
                        <div class="dropdown">
                            <button
                            class="btn btn-light dropdown-toggle"
                            type="button"
                            id="zoneDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            style="border-radius: 18px; padding: 0px 22px; color: #fff; background-color: #ff99cc; margin-top: 10px; margin-left: -80px;"
                            data-event-id="{{ $id }}">
                            Zone
                        </button>
                        <ul class="dropdown-menu" id="zoneOptions" aria-labelledby="zoneDropdown">
                            <li>
                                <a class="dropdown-item" href="#" data-value="all">Show All</a>
                            </li>
                            @foreach($venue_seating as $seating)
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        data-value="{{ $seating->seating_type_name }}">
                                        {{ $seating->seating_type_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>


                        <button class="btn btn-light dropdown-toggle dropdown" type="button" id="quantityDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false"
                        style="border-radius: 18px; padding: 0px 22px; color: #fff; background-color: #ff99cc; margin-top: 10px;">
                        Quantity
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="quantityDropdown">
                        <li><a class="dropdown-item quantity-option" href="#" data-value="1">1 Ticket</a></li>
                        <li><a class="dropdown-item quantity-option" href="#" data-value="2">2 Tickets</a></li>
                        <li><a class="dropdown-item quantity-option" href="#" data-value="3">3 Tickets</a></li>
                        <li><a class="dropdown-item quantity-option" href="#" data-value="4">4 Tickets</a></li>
                        <li><a class="dropdown-item quantity-option" href="#" data-value="5">5 Tickets</a></li>
                        <li><a class="dropdown-item quantity-option" href="#" data-value="6">6 Tickets</a></li>
                    </ul>
                        </div>

                    </div>

                </div>
            </div>
            <div class="card mt-3 shadow-sm">
                <div class="image-container">
                    <img src="{{ Storage::disk('image')->url('uploads/venue/' . @$event_datas->venue_image) }}" alt="Demo Image" class="zoomable-image">
                    <div class="zoom-controls">
                        <button id="zoom-in" class="zoom-btn">+</button>
                        <button id="zoom-out" class="zoom-btn">-</button>
                        <button id="reset" class="zoom-btn">
                            <i class="fas fa-sync-alt"></i> <!-- Font Awesome reset icon -->
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <input type="hidden" id="event-id" value="{{ $id }}">

 <!-- Right Section -->

 <div class="col-md-6" style="max-height: 90vh; overflow-y: auto; padding-right: 15px;">
    @php
        $lowestPrice = PHP_INT_MAX;
        // Precompute the lowest price
        foreach ($event_timings as $timing_date) {
            $event_timing = App\Models\EventTiming::get_events_with_date($timing_date->event, $timing_date->event_date);
            if ($event_timing) {
                foreach ($event_timing as $event_time) {
                    $event_ticket_list = App\Models\EventTiming::get_ticket_list($timing_date->event, $timing_date->id);
                    foreach ($event_ticket_list as $dat) {
                        if ($dat->web_price < $lowestPrice) {
                            $lowestPrice = $dat->web_price;
                        }
                    }
                }
            }
        }
    @endphp

    @foreach ($event_timings as $timing_date)
        @php
            $event_timing = App\Models\EventTiming::get_events_with_date($timing_date->event, $timing_date->event_date);
        @endphp

        @if ($event_timing)
            @foreach ($event_timing as $event_time)
                @php
                    $event_ticket_list = App\Models\EventTiming::get_ticket_list($timing_date->event, $timing_date->id);
                @endphp

                @foreach ($event_ticket_list as $dat)
                    {{-- {{ $dat }} --}}
                    @php
                        $ticket_availability = App\Models\EventTiming::get_available_tickets($dat->id);
                    @endphp

                    @if ($ticket_availability > 0)
                        <div class="card p-3 mb-3 ticket-container"
                             data-availability="{{ $ticket_availability }}"
                             data-zone="{{ $dat->seating_type_name }}"
                             data-split-type="{{ $dat->split_type }}"
                             style="border-radius: 10px; border: 1px solid #ddd; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);">
                            <div class="d-flex justify-content-between align-items-start">
                                <!-- Left Section -->
                                <div>
                                    <h5 style="font-weight: 500;">{{ $dat->seating_type_name }}</h5>
                                    <p>{{ $ticket_availability }} tickets</p>
                                    {{-- <p>Split Type: {{ $dat->split_type }}</p> --}}

                                    @if ($dat->web_price == $lowestPrice)
                                        <span class="badge lowest-price" style="background-color: #d4edda; color: #155724; border-radius: 5px; padding: 5px 10px;">
                                            Lowest price
                                        </span>
                                    @endif
                                    <span class="remaining-tickets" style="font-size: 14px; color: #d63384;">
                                        {{ $ticket_availability }} tickets remaining in this listing on our site
                                    </span>

                                </div>

                                <!-- Right Section -->
                                <div class="text-end">
                                    <h5 class="mb-1" style="font-weight: 600;">{{ $dat->face_value.' '.$dat->short_name }}</h5>
                                    <h6>each</h6>
                                    @if($ticket_availability > 0)
                                        <form action="{{ url('submit_ticket_selected') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{ $dat->id }}" name="event_ticket">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="hidden" style="width: 60px;" class="form-control"
                                                        max="{{ $ticket_availability }}" min="1" name="buy_count"
                                                        required />
                                                </div>
                                                <button class="apt-btn btn btn-primary" type="submit" style="margin-left:15px;">Book</button>
                                            </div>
                                        </form>
                                    @else
                                        <span class="badge" style="background-color: #f8d7da; color: #721c24; border-radius: 5px; padding: 5px 10px;">
                                            Sold Out
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        @endif
    @endforeach
</div>






        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://just4entertainment.com/public/assets/js/toastr.min.js"></script>


<script>

    document.querySelectorAll('.quantity-option').forEach(option => {
        option.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action of the anchor tag
            const selectedValue = this.getAttribute('data-value');
            const button = document.getElementById('quantityDropdown');
            button.textContent = `${selectedValue} Ticket${selectedValue > 1 ? 's' : ''}`; // Update button text
        });
    });
    document.addEventListener("DOMContentLoaded", () => {
    const image = document.querySelector(".zoomable-image");
    const zoomInBtn = document.getElementById("zoom-in");
    const zoomOutBtn = document.getElementById("zoom-out");
    const resetBtn = document.getElementById("reset");

    let scale = 1;
    const scaleStep = 0.1;
    let isDragging = false;
    let startX, startY;
    let translateX = 0, translateY = 0;

    // Zoom in and out using buttons
    zoomInBtn.addEventListener("click", () => {
        scale += scaleStep;
        updateTransform();
    });

    zoomOutBtn.addEventListener("click", () => {
        if (scale > scaleStep) {
            scale -= scaleStep;
            updateTransform();
        }
    });

    // Reset image scale and position
    resetBtn.addEventListener("click", () => {
        scale = 1;
        translateX = 0;
        translateY = 0;
        updateTransform();
    });

    // Click to zoom in/out
    image.addEventListener("click", () => {
        scale += scaleStep;
        updateTransform();
    });

    // Dragging functionality
    image.addEventListener("mousedown", (e) => {
        isDragging = true;
        startX = e.clientX - translateX;
        startY = e.clientY - translateY;
        image.style.cursor = "grabbing";
    });

    document.addEventListener("mouseup", () => {
        isDragging = false;
        image.style.cursor = "grab";
    });

    document.addEventListener("mousemove", (e) => {
        if (!isDragging) return;

        translateX = e.clientX - startX;
        translateY = e.clientY - startY;
        updateTransform();
    });

    // Update transform to apply zoom and drag
    function updateTransform() {
        image.style.transform = `scale(${scale}) translate(${translateX}px, ${translateY}px)`;
    }
});

    document.addEventListener('DOMContentLoaded', function () {
    const zoneDropdown = document.getElementById('zoneDropdown');
    const zoneOptions = document.getElementById('zoneOptions');

    zoneDropdown.addEventListener('click', function () {
        const eventId = this.getAttribute('data-event-id'); // Fetch event ID from the button

        // Make an AJAX call to fetch seating_type_name
        fetch(`/get-seating-types/${eventId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            // Clear existing options
            zoneOptions.innerHTML = '';

            // Populate dropdown with new options
            if (data.seating_types && data.seating_types.length > 0) {
                data.seating_types.forEach(type => {
                    const option = document.createElement('li');
                    option.innerHTML = `<a class="dropdown-item" href="#" data-value="${type.id}">${type.seating_type_name}</a>`;
                    zoneOptions.appendChild(option);
                });
            } else {
                zoneOptions.innerHTML = '<li><a class="dropdown-item" href="#">No Zones Available</a></li>';
            }
        })
        .catch(error => {
            console.error('Error fetching seating types:', error);
        });
    });
});




   $(document).ready(function () {
    $(document).on('click', '.editable .edit-icon', function () {
        var h5 = $(this).closest('.editable'); // Get the parent <h5>
        var originalContent = h5.text().trim().replace(/[^0-9.]/g, ''); // Extract and clean the numeric content

        var eventTicketId = h5.find('.event-ticket-id').val(); // Get the event ticket ID

        // Create the input field for editing
        var inputField = $('<input type="text" class="form-control" value="' + originalContent + '" style="width: 75px; font-size: 14px;">');

        h5.html(inputField);
        inputField.focus();

        inputField.on('blur', function () {
            var newContent = inputField.val(); // Get the updated content

            // Make an AJAX request to update the data
            $.ajax({
                url: '/update-facevalue-ticket',
                type: 'POST',
                data: {
                    web_price: newContent,
                    event_ticket_id: eventTicketId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log(response);

                    if (response.success) {
                        // Update the <h5> content on success
                        h5.html(newContent + ' USD <i class="fas fa-pencil-alt edit-icon"></i>' +
                            '<input type="hidden" class="event-ticket-id" value="' + eventTicketId + '">');

                        toastr.success('Web price updated successfully');
                        window.location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    const ticketContainers = document.querySelectorAll('.ticket-container');

    dropdownItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const selectedZone = this.getAttribute('data-value');

            ticketContainers.forEach(container => {
                const zone = container.getAttribute('data-zone');
                if (zone === selectedZone || selectedZone === 'all') {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.quantity-option').forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const quantity = parseInt(this.getAttribute('data-value'), 10);
            filterTicketsByQuantity(quantity);
            updateTicketDisplay(quantity);
            updateInputFields(quantity);
        });
    });
});

function filterTicketsByQuantity(quantity) {
    const tickets = document.querySelectorAll('.ticket-container');
    tickets.forEach(ticket => {
        const availability = parseInt(ticket.dataset.availability, 10);
        const splitType = parseInt(ticket.dataset.splitType, 10);

        let shouldShow = true;

        // Availability must always be >= quantity
        if (availability < quantity) {
            shouldShow = false;
        } else {
            // Additional split type rules
            switch (splitType) {
                case 1: // Any
                    shouldShow = true;
                    break;

                case 2: // None
                    shouldShow = availability === quantity;
                    break;

                case 3: // Avoid leaving one ticket
                    shouldShow = (availability - quantity) !== 1;
                    break;

                case 4: // Avoid leaving one or three tickets
                    shouldShow = (availability - quantity) !== 1 && (availability - quantity) !== 3;
                    break;

                case 5: // Avoid odd numbers
                    shouldShow = (availability - quantity) % 2 === 0;
                    break;

                default:
                    shouldShow = true; // Default behavior for unknown split type
            }
        }

        ticket.style.display = shouldShow ? 'block' : 'none';
    });
}

function updateTicketDisplay(quantity) {
    const tickets = document.querySelectorAll('.ticket-container');
    tickets.forEach(ticket => {
        const availabilityElement = ticket.querySelector('p'); // For selected tickets
        const remainingElement = ticket.querySelector('.remaining-tickets'); // For remaining tickets
        const totalAvailability = parseInt(ticket.dataset.availability, 10);

        if (totalAvailability >= quantity) {
            // Update the text content for selected tickets
            const ticketLabel = quantity === 1 ? 'ticket' : 'tickets'; // Use 'ticket' if quantity is 1, else 'tickets'
            availabilityElement.textContent = `${quantity} ${ticketLabel}`;

            // Update the text content for remaining tickets
            const remainingTickets = totalAvailability - quantity;
            if (remainingElement) {
                remainingElement.textContent = `${remainingTickets} tickets remaining in this listing on our site`;
            }
        }
    });
}

function updateInputFields(quantity) {
    const tickets = document.querySelectorAll('.ticket-container');
    tickets.forEach(ticket => {
        const inputField = ticket.querySelector('input[name="buy_count"]');
        const totalAvailability = parseInt(ticket.dataset.availability, 10);

        if (inputField && totalAvailability >= quantity) {
            inputField.value = quantity; // Set the input box value to the selected quantity
        }
    });
}

// function updateTicketList(tickets) {
//     alert(tickets);
//     const ticketContainer = document.getElementById('ticket-list');
//     ticketContainer.innerHTML = ''; // Clear existing tickets

//     tickets.forEach(ticket => {
//         // Rebuild ticket elements here based on returned data
//         const ticketElement = document.createElement('div');
//         ticketElement.className = 'ticket-container';
//         ticketElement.innerHTML = `
//             <h5>${ticket.name}</h5>
//             <p>${ticket.availability} tickets available</p>
//         `;
//         ticketContainer.appendChild(ticketElement);
//     });
// }


</script>


<script>
    document.getElementById('ticketFilter').addEventListener('input', function() {

        var filterValue = parseInt(this.value, 10);
        var rows = document.querySelectorAll('.ticket-row');

        rows.forEach(function(row) {
            var availability = parseInt(row.getAttribute('data-availability'), 10);

            if (isNaN(filterValue) || availability >= filterValue) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<script>
    function showFileUpload(icon) {
        // Hide the pencil icon
        icon.style.display = 'none';

        // Show the file input element
        var fileInput = document.getElementById('ticket_file');
        fileInput.style.display = 'inline-block'; // Display the file input inline

        // Optionally, you can focus on the file input after showing it
        fileInput.focus();
    }
</script>




@endsection
