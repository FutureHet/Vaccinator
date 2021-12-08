import React from 'react'
import Header from '../components/Header';
import Footer from '../components/Footer';


const Home = () => {
    return (
        <>
            <Header />
            <div className="container">
                <div className="row">
                    <div className="col-6">
                        <a href='/Login' rel="noreferrer">
                            <img className='rectangle' src='assets/svg/Mobile-login-pana.svg' alt='User Login'></img>
                            <h1 className='text-center' style={{color: '#001f60'}}>Click here for Vaccine</h1>
                        </a>
                    </div>
                    <div className="col-6">
                        <a href='http://localhost:8000/user/signin/' target='_BLANK' rel="noreferrer">
                            <img className='rectangle' src='assets/svg/Secure-login-amico.svg' alt='Vaccinator Login'></img>
                            <h1 className='text-center' style={{color: '#001f60'}}>Vaccinator SignIn</h1>
                        </a>
                    </div>
                </div>
            </div>
            <Footer />
        </>
    )
}

export default Home
