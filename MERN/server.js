const express = require('express');

const connectDB = require('./config/db');

const app  = express();

// Connect DataBase
connectDB();

// Init Middleware
// Use Instead of Body-Parser
app.use(express.json({ extended: false }));

// To hide all errors and waring in Browser Console
const cors = require('cors');
app.use(cors({ origin: 'http://localhost:6000', credentials: true }));

app.get(
    '/',
    (req, res) => res.redirect('/home')
);

app.get(
    '/home',
    (req, res) => res.send('API Running')
);

// Define Routes
app.use('/api/login', require('./routes/api/login'));
app.use('/api/faq', require('./routes/api/faq'));

// process.env.PORT is useful when we deploy this on Heroku. It will automatically take PORT from it.
const PORT = process.env.PORT || 6000;

app.listen(PORT, () => console.log(`server Started on PORT ${PORT}`));