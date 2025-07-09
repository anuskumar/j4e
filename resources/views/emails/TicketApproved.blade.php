<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .container {
      max-width: 600px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      color: #333;
    }

    p {
      color: #666;
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007BFF;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <div class="container">
    <img src="{{ config('app.storage') }}/uploads/images/572552721.png" alt="Trulli" width="200" height="100">

    <h1>Confirmation of Ticket Approved</h1>
    <p>Dear {{$resellername}},</p>
     <p>We are pleased to inform you that your tickets for the event "{{ $eventname }}" scheduled on {{ $eventdate }} have been approved by the admin.</p>Your ticket details are as follows:</p>

    <ul>
      <!--<li>Order Number: [Order Number]</li>-->
      <li>Event:{{$eventname}}</li>
      <li>Date:{{$eventdate}}</li>
      <li>Quantity:{{$numberoftickets}}</li>
      <li>Total Amount:{{$totalamount}}</li>
    </ul>

    <p>Best regards,<br> Just4Entertainment</p>

  </div>

</body>
</html>
