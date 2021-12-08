const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const RegisterSchema = new Schema({
    mobile: {
        type: String,
        required: true
    },
    createdOn: {
        type: Date,
        default: Date.now()
    },
    lastActivity: {
        type: Date,
        default: Date.now()
    }
});

module.exports = Register = mongoose.model('Register', RegisterSchema);