require('dotenv').config();

const express = require('express');
const router = express.Router();
const crypto = require('crypto');

const accountSID = process.env.ACCOUNT_SID;
const authToken = process.env.AUTH_TOKEN;
const client = require('twilio')(accountSID, authToken);

const jwt = require('jsonwebtoken');
const config = require('config');
const { check, validationResult } = require('express-validator');

const loginAuth = require('../../middleware/loginAuth');
const Register = require('../../models/Register');
const smsKey = process.env.SMS_SECRET_KEY;

router.post(
    '/',
    [
        check('mobile', 'Enter 10 Digit Mobile Number with prefix +91').isLength({ min:13, max:13 })
    ],
    async (req, res) => {
        const errors = validationResult(req);
        if(!errors.isEmpty()) {
            return res.status(400).json({ errors: errors.array() });
        }

        try {

            const { mobile } = req.body;
            var register = await Register.findOne({ mobile: mobile });
    
            if(register) {
                // Update
                register = await Register.findOneAndUpdate(
                    { mobile: mobile },
                    // { $set: { Name : name } },
                    { lastActivity: Date.now() },
                    { new: true }
                );
                // return res.send(register);
            }
            else {
                const newRegister = new Register({
                    mobile: mobile
                });
        
                var register = await newRegister.save();
                // return res.json(register);
            }

            // return jsonWebToken
            const payload = {
                register:{
                    mobile: register.mobile
                }
            };
            jwt.sign(
                payload,
                config.get('jwtSecret'),
                { expiresIn: '5 days' },
                (err, token) => {
                    if (err) throw err;
                    return res.json({ token });
                }
            );
        } catch(err) {
            console.log(err.message);
            res.status(500).send('Server Error');
        }
    }
);

router.post(
    '/sendotp',
    loginAuth,
    (req, res) => {
        const mobile = req.register.mobile;
        const otp = Math.floor(100000 + Math.random()*900000);
        const ttl = 30*1000;
        const expires = Date.now() + ttl;
        const data = `${mobile}.${otp}.${expires}`;
        // Print Mobile, OTP and Expire Time
        console.log(data);
        const hash = crypto.createHash('sha256', smsKey).update(data).digest('hex');
        const fullHash = `${hash}.${expires}`

        client.messages.create({
            body: `Your One Time Password (OTP) is ${otp}`,
            from: +19132701702,
            to: mobile
        }).then((messages) => console.log(messages)).catch((err) => console.error(err))

        res.status(200).send({ mobile, fullHash: fullHash, otp });
    }
);

router.post(
    '/verifyotp',
    (req, res) => {
        const mobile = req.body.mobile;
        const otp = req.body.otp;
        const fullHash = req.body.fullHash;
        
        let [hash, expires] = fullHash.split('.');
        let now = Date.now();

        if(now > parseInt(expires)) {
            return res.status(500).json({ msg: 'TimeOut OTP Expired ... Please try again' })
        }

        const newData = `${mobile}.${otp}.${expires}`;
        const newHash = crypto.createHash('sha256', smsKey).update(newData).digest('hex');

        if(newHash !== hash) {
            return res.status(400).json({ msg: 'Invalid OTP !!!' });
        }

        res.status(202).json({ msg: 'Device Verified' })
        // return res.status(202).json({ msg: 'OTP Verfied Successfully ....' });
    }
);

router.get(
    '/', 
    async (req, res) => {
    try {

        const register = await Register.find().select(['-_id','-__v'])
        res.send(register);

    } catch (err) {
        console.log(err.message)
        res.status(500).send('Server Error')
    }
})

module.exports = router;