const express = require('express');
const nodemailer = require('nodemailer');
const bodyParser = require('body-parser');
const axios = require('axios'); // Add axios for making HTTP requests
const app = express();
const port = 3000;

app.use(bodyParser.json());

app.post('/send-comment', (req, res) => {
  const { comment } = req.body;
  console.log('Received comment:', comment); // Log received comment

  const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      user: 'yoururbanhome23@gmail.com',
      pass: 'chapelhill23' // Use the provided email password
    }
  });

  const mailOptions = {
    from: 'yoururbanhome23@gmail.com',
    to: 'yoururbanhome23@gmail.com', // Ensure this is the correct recipient email
    subject: 'New Comment on Your Urban Home Products',
    text: `You have received a new comment:\n\n${comment}`
  };

  transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
      console.error('Error sending email:', error); // Log error
      return res.status(500).send({ error: error.toString() });
    }
    console.log('Email sent:', info.response); // Log success
    res.status(200).send({ message: 'Comment sent successfully' });
  });
});

app.post('/process-payment', async (req, res) => {
  const { mobileNumber, amount } = req.body;
  const recipientNumber = '+233598323235'; // MTN account to receive payments
  console.log(`Processing payment of GH₵${amount} from mobile number ${mobileNumber} to ${recipientNumber}`); // Log payment details

  // Replace with actual API endpoint and credentials
  const apiEndpoint = 'https://api.paymentgateway.com/v1/payments';
  const apiKey = 'your-api-key';
  const apiSecret = 'your-api-secret';

  try {
    const response = await axios.post(apiEndpoint, {
      mobileNumber,
      amount,
      recipientNumber
    }, {
      headers: {
        'Authorization': `Bearer ${apiKey}:${apiSecret}`,
        'Content-Type': 'application/json'
      }
    });

    if (response.status === 200) {
      res.status(200).send({ message: 'Payment processed successfully' });
    } else {
      res.status(response.status).send({ error: 'Failed to process payment' });
    }
  } catch (error) {
    console.error('Error processing payment:', error); // Log error
    res.status(500).send({ error: 'Failed to process payment' });
  }
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
