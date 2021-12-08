import '../css/VerifyOTPForm.css'
import axios from 'axios';
import Alert from 'react-bootstrap/Alert';
import { useState, useEffect } from 'react';
import { useSelector } from 'react-redux';
import { useHistory } from 'react-router-dom';
import { useDispatch } from 'react-redux';
import { changeHash } from '../actions/index';

const VerifyOTPForm = () => {

    const history = useHistory();

    if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
        // console.log('Shubh');
        // history.push('/Login');
        window.location.replace("http://localhost:3000/Login");
    }
    
    const mystate = useSelector((state)=>state);
    const dispach = useDispatch();
    
    const maxTime = 30;
    const [ Timer, setTimer ] = useState(maxTime);
    const [ OTP, setOTP ] = useState("");
    const [ OTPValidation, setOTPValidation ] = useState("");
    const [ Show, setShow ] = useState(false);
    const [ Error, setError ] = useState("");
    const [ ErrorCode, setErrorCode ] = useState("");

    useEffect( () => {
        let countDown = setInterval( () => {
            setTimer(Timer - 1);
            if(Timer === 1) { 
                document.getElementsByClassName('otp-time')[0].classList.add('d-none');
                document.getElementsByClassName('otp-resend')[0].classList.remove('d-none');
                clearInterval(countDown);
            }
        }, 1000);
        return ()=> {
            clearInterval(countDown);
        };

    });

    function validateOTP(event) {
        const otpPattern = /^[0-9]*$/;
        if(otpPattern.test(event.target.value)){
            setOTP(event.target.value);
        }

        let otp = event.target.value;

        if(otp.length !== 6 && otp.length > 0) {
            setOTPValidation('Must be 6 digits');
            document.getElementById('OTP').style.borderBottomColor = '#ff0000';
            document.getElementById('OTP').style.caretColor = '#ff0000';
        }
        else if(otp.length === 6) {
            if(parseInt(otp[0]) === 0) {
                setOTPValidation('OTP can not start with 0');
                document.getElementById('OTP').style.borderBottomColor = '#ff0000';
                document.getElementById('OTP').style.caretColor = '#ff0000';
            }
            else {
                setOTPValidation('');
                document.getElementById('OTP').style.borderBottomColor = '#002060';
                document.getElementById('OTP').style.caretColor = '#002060';
            }
        }
        else {
            setOTPValidation('');
            document.getElementById('OTP').style.borderBottomColor = '#002060';
            document.getElementById('OTP').style.caretColor = '#002060';
        }
    }

    const verifyOTP = async event => {

        event.preventDefault();
        const userOTP = {
            mobile: mystate.Login.mobile,
            otp: OTP,
            fullHash: mystate.Login.fullHash
        }

        try {
            const configVerifyOTP = {
                headers: {
                    'Content-Type': 'application/json'
                }
            }
            const body = JSON.stringify(userOTP);
            const resVerifyOTP = await axios.post('/api/login/verifyotp', body, configVerifyOTP);
            console.log(resVerifyOTP.data);
            if(resVerifyOTP){
                // history.push('/Members')
                // console.log(sessionStorage.getItem("token"))
                // console.log(localStorage.getItem("token"))
                // console.log(document.cookie)
                window.location.replace("http://localhost:8080/PHP_MySQL")
            }
        } catch(err) {
            console.error(err);
            setShow(true);
            setError(err.response.data.msg);
            setErrorCode(err.response.status);
        }
    }

    const getOTP = async event => {

        event.preventDefault();
        const userMobile = {
            mobile: mystate.Login.mobile
        }

        try {
            const configLogin = {
                headers: {
                    'Content-Type': 'application/json'
                }
            }
            const body = JSON.stringify(userMobile);
            const resLogin = await axios.post('/api/login', body, configLogin);
            // console.log(resLogin.data);
            const configSendOTP = {
                headers: {
                    'Content-Type': 'application/json',
                    'x-loginAuth-token': resLogin.data.token
                }
            }
            const resSendOTP = await axios.post('/api/login/sendotp', '',configSendOTP);
            console.log(resSendOTP.data);
            dispach(changeHash({
                fullHash:resSendOTP.data.fullHash,
                mobile:userMobile.mobile
            }))
            document.getElementsByClassName('otp-time')[0].classList.remove('d-none');
            document.getElementsByClassName('otp-resend')[0].classList.add('d-none');
            setTimer(maxTime);
        } catch(err) {
            console.error(err);
        }
    }

    return (
        <>
            <div className='container'>
                <div className='row justify-content-center'>
                    <div className='col-lg-4 col-md-6 col-sm-8 col-10 px-5 pb-5 rounded otp'>
                        <div className='row'>
                            <div className='col-12'>
                                <div className='bg-white p-3 rounded-circle rounded-outer-circle mx-auto'>
                                    <img src='assets/svg/login-screen.svg' alt='Heart-SVG'></img>
                                </div>
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-12 text-center h3 otp-style-1'>
                                OTP Verification
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-12 text-center h6 otp-style-2'>
                                An OTP will be sent to
                                <br />
                                XXX XXX {mystate.Login.mobile.substr(-4)}
                            </div>
                        </div>
                        <div className='row'>
                            <form onSubmit={(event) => {verifyOTP(event)}} method='POST'>
                                <div className='col-12'>
                                    <input type='text' value={OTP} id='OTP' className='w-100' placeholder='Enter OTP' maxLength='6' required onChange={(event) => {validateOTP(event)}}></input>
                                </div>
                                <div className='col-12 otp-validation-1 py-1 mb-3'>
                                    {OTPValidation}
                                    {/* Must be 6 digits */}
                                </div>
                                <div className='col-12 otp-time text-success text-center h5 py-1 my-3'>
                                    {Timer + " sec"}
                                </div>
                                <div className='col-12 otp-resend text-center d-none py-1 my-3'>
                                    <a className='h5' href='/' onClick={(event) => {getOTP(event)}}>
                                        Resend OTP
                                    </a>
                                </div>
                                <div className='col-12 text-center py-1 mb-3 otp-style-3'>
                                    There might be some delay in receiving the OTP due to heavy traffic
                                </div>
                                <div className='col-12'>
                                    <input className="btn btn-primary w-100" type="submit" value="Verify & Proceed"></input>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div className='container-fluid fixed-bottom mb-5 ml-2'>
                <div className='row'>
                    <div className='col-3'>
                        <Alert variant="danger" show={Show} onClose={() => setShow(false)} dismissible>
                            <Alert.Heading>
                                { Error }
                            </Alert.Heading>
                            <p>
                                { "Error : " + ErrorCode }
                            </p>
                        </Alert>
                    </div>
                </div>
            </div>
        </>
    )
}

export default VerifyOTPForm