const express = require('express');
const router = express.Router();
// const bcryptjs = require('bcryptjs');
// const jwt = require('jsonwebtoken');
const config = require('config');
const { check, validationResult } = require('express-validator');
const loginAuth = require('../../middleware/loginAuth')

router.get(
    '/', 
    loginAuth,
    async (req, res) => {
    try {
        res.send(req.register.mobile);
    } catch (err) {
        console.log(err.message);
        res.status(500).send('Server Error');
    }
})

module.exports = router;