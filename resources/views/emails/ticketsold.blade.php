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
    <img src="{{ \App\Models\CompanySettings::appLogoUrl() }}" alt="Logo" width="200" height="100">
    <h1>Confirmation of Ticket Sold</h1>
    <p>Dear {{$resellername}},</p>
    <p>Congratulations! Your {{$ticket_name}} tickets for the {{$eventname}} on {{$eventdate}}  have been sold.
    And If you have not uploaded the ticket, please upload it. Otherwise, please ignore this message.
    Your order details are as follows:</p>

    <ul>
      
      <li>Event: {{$eventname}}</li>
      <li>Date: {{$eventdate}}</li>
      @isset($ticket_count_data)
      <li>Ticket: {{$ticket_name}}({{$ticket_count_data}}tickets)]</li>
      @endisset
      <li>Price per Ticket: ${{$price}}</li>
    </ul>

   
    <p>Best regards,<br> Just4Entertainment</p>

  </div>

</body>
</html>
