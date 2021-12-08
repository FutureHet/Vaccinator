import React from 'react'
import Header from '../components/Header';
import Footer from '../components/Footer';
import '../css/Members.css'
import {InfoLg} from 'react-bootstrap-icons'

const Members = () => {
return (
<div>
    <Header />
    <div className='container'>
        <div className="main_member mt-5 mb-5">
            <div className="row w-md-75 w-lg-75 w-xl-75 w-sm-100 back_color mb-5">
                <div className="col-12">
                    <div className="row w-100 jutify-centent-center">
                        <div className="col-12">
                            <div className="welcome_svg mt-5">
                                <img src="assets/svg/welcome-screen.svg" alt="welcome" /><br />
                                <h1 className="pt-3 text-center">Welcome</h1>
                                <label className="pt-3 ">You can register 4 members with one mobile number</label>
                            </div>
                        </div>
                    </div>
                    <div className="row mt-4">
                        <div className="col-12 ">
                            <button className="add_member_btn pt-3 pb-3">Register Member</button>
                        </div>
                    </div>
                    <div className="row note mt-5">
                        <div className="col-12 mt-4">
                            <label className='note_title ms-4 my-auto'>
                                <span className='rounded-circle p-2 me-2'>
                                    <InfoLg className='info_icon infolg'/>
                                </span>
                                Note
                            </label>
                            <ul>
                                <li>
                                    One registration per person is sufficient. Please do not register with multiple mobile
                                    numbers or different Photo ID Proofs for same individual.
                                </li>
                                <li>Scheduling of Second dose should be done from the same account (same mobile number) from
                                    which the first dose has been taken, for generation of final certificate. Separate
                                    registration for second dose is not necessary.
                                </li>
                                <li>Please carry the registered mobile phone and the requisite documents, including
                                    appointment slip, the Photo ID card used for registration, Employment Certificate
                                    (HCW/FLW) etc., while visiting the vaccination center, for verification at the time of
                                    vaccination.
                                </li>
                                <li>Please check for additional eligibility conditions, if any, prescribed by the respective
                                    State/UT Government for vaccination at Government Vaccination Centers, for 18-44 age
                                    group, and carry the other prescribed documents (e.g. Comorbidity Certificate etc.) as
                                    suggested by respective State/UT (on their website).
                                </li>
                                <li>The slots availability is displayed in the search (on district, pincode or map) based on
                                    the schedule populated by the DIOs (for Government Vaccination Centers) and private
                                    hospitals for their vaccination centers.
                                </li>
                                <li>The vaccination schedule published by DIOs and private hospitals displays the list of
                                    vaccination centers with the following information<br />
                                    <ol type='I'>
                                        <li>
                                            The vaccine type.
                                        </li>
                                        <li>
                                            The age group (18-44/45+ etc.).
                                        </li>
                                        <li>
                                            The number of slots available for dose 1 and dose 2.
                                        </li>
                                        <li>
                                            Whether the service is Free or Paid (Vaccination is free of cost at all the Government Vaccination Centers).
                                        </li>
                                        <li>
                                            Per dose price charged by a private hospital.
                                        </li>
                                    </ol>
                                </li>
                                <li>
                                    If you are seeking 1st dose vaccination, the system will show you only the available slots for dose 1. Similarly, if you are due for 2nd dose, the system will show you the available slots for dose 2 after the minimum period from the date of 1st dose vaccination has elapsed.
                                </li>
                                <li>
                                    Once a session has been published by the DIO/ private hospital, the session now can not be cancelled. However, the session may be rescheduled. In case you have booked an appointment in any such vaccination session that is rescheduled for any reason, your appointment will also be automatically rescheduled accordingly. You will receive a confirmation SMS in this regard. On such rescheduling, you would still have the option of cancelling or further rescheduling such appointment.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</div>
)
}

export default Members