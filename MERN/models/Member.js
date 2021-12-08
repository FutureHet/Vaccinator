const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const MemberSchema = new Schema({
    name: {
        type: String,
        required: true
    },
    mobile: {
        type: String,
        required: true
    },
    idType: {
        type: String,
        required: true
    },
    idNumber: {
        type: String,
        required: true
    },
    gender: {
        type: String,
        required: true
    },
    yearOfBirth: {
        type: String,
        required: true
    },
    refID: {
        type: String,
        required: true
    },
    vaccineName: {
        type: String
    },
    dose1: {
        centerName: {
            type: String
        },
        date: {
            type: Date
        },
        slotTime: {
            type: String
        },
        vaccinatedBy: {
            type: String
        },
        certificateNumber: {
            type: String
        },
        batchNo: {
            type: String
        }
    },
    dose2: {
        centerName: {
            type: String
        },
        date: {
            type: Date
        },
        slotTime: {
            type: String
        },
        vaccinatedBy: {
            type: String
        },
        certificateNumber: {
            type: String
        },
        batchNo: {
            type: String
        }
    }

});

module.exports = Member = mongoose.model('Member', MemberSchema);