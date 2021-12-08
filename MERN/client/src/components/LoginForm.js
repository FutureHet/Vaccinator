import '../css/LoginForm.css'
import { useState } from 'react';
import axios from 'axios';
import { useHistory } from 'react-router-dom'
import { useDispatch } from 'react-redux';
import { changeHash } from '../actions/index';

const LoginForm = () => {

    const [ MobileNumber, setMobileNumber ] = useState("");
    const [ LoginValidation, setLoginValidation ] = useState("");
    const history = useHistory();
    // const mystate = useSelector((state)=>state.Hash)
    const dispach = useDispatch();

    if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
        // console.log('Shubh');
        // history.push('/Login');
        window.location.replace("http://localhost:3000/Login");
    }

    function validateMobile(event) {
        const mobilePattern = /^[0-9]*$/;
        if(mobilePattern.test(event.target.value)){
            setMobileNumber(event.target.value);
        }

        let mobile = event.target.value;

        if(mobile.length !== 10 && mobile.length > 0) {
            setLoginValidation('Must be 10 digits');
            document.getElementById('mobileNumber').style.borderBottomColor = '#ff0000';
            document.getElementById('mobileNumber').style.caretColor = '#ff0000';
        }
        else if(mobile.length === 10) {
            if(mobile[0] < 6) {
                setLoginValidation('Mobile Number Must Starts with 6, 7, 8 or 9');
                document.getElementById('mobileNumber').style.borderBottomColor = '#ff0000';
                document.getElementById('mobileNumber').style.caretColor = '#ff0000';
            }
            else {
                setLoginValidation('');
                document.getElementById('mobileNumber').style.borderBottomColor = '#002060';
                document.getElementById('mobileNumber').style.caretColor = '#002060';
            }
        }
        else {
            setLoginValidation('');
            document.getElementById('mobileNumber').style.borderBottomColor = '#002060';
            document.getElementById('mobileNumber').style.caretColor = '#002060';
        }
    }

    const getOTP = async event => {

        event.preventDefault();
        const userMobile = {
            mobile: '+91' + MobileNumber
        }

        try {
            const configLogin = {
                headers: {
                    'Content-Type': 'application/json'
                }
            }
            const body = JSON.stringify(userMobile);
            const resLogin = await axios.post('/api/login', body, configLogin);
            console.log(resLogin.data);
            const configSendOTP = {
                headers: {
                    'Content-Type': 'application/json',
                    'x-loginAuth-token': resLogin.data.token
                }
            }
            const resSendOTP = await axios.post('/api/login/sendotp', '',configSendOTP);
            // console.log(resSendOTP.data);
            // sessionStorage.setItem("token", resLogin.data.token)
            // localStorage.setItem("token", resLogin.data.token)
            const expire = new Date()
            expire.setTime(expire.getTime() + (15*60*1000))
            document.cookie = "token" + "=" + resLogin.data.token + ";" + "expires" + "=" + expire.toUTCString();
            // console.log(document.cookie)
            dispach(changeHash({
                fullHash:resSendOTP.data.fullHash,
                mobile:userMobile.mobile
            }))
            if(resSendOTP){
                // history.push('/VerifyOTP')
                history.push({pathname: '/VerifyOTP'});
                // console.log(history)
            }
        } catch(err) {
            console.error(err);
        }
    }

    return (
        <>
            <div className='container'>
                <div className='row justify-content-center'>
                    <div className='col-lg-4 col-md-6 col-sm-8 col-10 px-5 pb-5 rounded login'>
                        <div className='row'>
                            <div className='col-12'>
                                <div className='bg-white p-3 rounded-circle rounded-outer-circle mx-auto'>
                                    <img src='assets/svg/login-screen.svg' alt='Heart-SVG'></img>
                                </div>
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-12 text-center h3 login-style-1'>
                                Register or SignIn for Vaccination
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-12 text-center h6 login-style-2'>
                                An OTP will be sent to your mobile number for verification
                            </div>
                        </div>
                        <div className='row'>
                            <form className='w-100' onSubmit={(event) => {getOTP(event)}} method='POST'>
                                <div className='col-12'>
                                    {/* <input type='text' className='w-100' placeholder='Enter your Mobile Number' pattern='[6-9][0-9]{9}' maxLength='10' required  onChange={validateMobile}></input> */}
                                    <input type='text' value={MobileNumber} id='mobileNumber' className='w-100' placeholder='Enter your Mobile Number' pattern='[6-9][0-9]{9}' maxLength='10' required onChange={(event) => {validateMobile(event)}}></input>
                                </div>
                                <div className='col-12 login-validation-1 py-1 mb-3'>
                                    {LoginValidation}
                                    {/* Must be 10 digits */}
                                </div>
                                <div className='col-12'>
                                    <input className="btn btn-primary w-100" type="submit" value="Get OTP"></input>
                                </div>
                            </form>
                        </div>
                        <div className='row'>
                            <div className='col-12 py-4 text-center dashline-left-right'>
                                <span className='fw-bold'>OR BOOK APPOINTMENT USING</span>
                            </div>
                        </div>
                        <div className='row justify-content-around other-login'>
                            <div className='col-5 py-3 text-center border rounded'>
                                <a href='https://www.aarogyasetu.gov.in' target='_BLANK' rel="noreferrer">
                                    <img className='square' src='assets/img/arogya.png' alt='Aarogya Setu Logo'></img>
                                    <br />
                                    <span className='other-login-name fw-bold'>Aarogya Setu</span>
                                </a>
                            </div>
                            <div className='col-5 py-3 text-center border rounded'>
                                <a href='https://web.umang.gov.in/web_new/login?redirect_to=department%3Furl%3Dcowin%2F%26dept_id%3D355%26dept_name%3DCo-WIN' target='_BLANK' rel="noreferrer">
                                    <img className='rectangle' src='assets/img/UMANG-Logo.png' alt='Umang Logo'></img>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default LoginForm