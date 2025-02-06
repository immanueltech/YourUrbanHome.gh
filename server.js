const express = require('express');
const nodemailer = require('nodemailer');
const bodyParser = require('body-parser');
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
      pass: 'chapelhill23' // Use the generated app-specific password
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
      return res.status(500).send(error.toString());
    }
    console.log('Email sent:', info.response); // Log success
    res.status(200).send('Comment sent successfully');
  });
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
