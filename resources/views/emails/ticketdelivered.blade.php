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
    <img src="https://www.w3schools.com/html/pic_trulli.jpg" alt="Trulli" width="200" height="100">
    <h1>Your Ticket were delivered for order</h1>
    <p>Dear [Customer Name],</p>
    <p>Thank you for Delivering the  tickets for the [Event Name] on [Event Date]. Your order details are as follows:</p>

    <ul>
      <li>Order Number: [Order Number]</li>
      <li>Event: [Event Name]</li>
      <li>Date: [Event Date]</li>
      <li>Quantity: [Number of Tickets]</li>
      <li>Total Amount: $[Total Amount]</li>
    </ul>

    <p>We look forward to seeing you at the event. If you have any questions or concerns, feel free to contact us.</p>

    <p>Best regards,<br> [Your Company Name]</p>

    <a href="[Link to Additional Information]" class="button">View Event Details</a>
  </div>

</body>
</html>
