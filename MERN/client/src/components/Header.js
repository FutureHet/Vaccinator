import '../css/Header.css'
import {TelephoneFill} from 'react-bootstrap-icons'

const MainHeader = () =>{
    return(
        <div className='main_header py-1 header'>
            <div className='container'>
                <div className='row my-2 px-sm-0 px-2'>
                    <div className='col-12'>
                        <img src='assets/img/covid19logo.jpg' alt='Covin-Logo'/>
                    </div>
                </div>
            </div>
        </div>
    )
}

const FunctionalHeader = () => {
    return(
        <div className='functional_header py-1 header'>
            <div className='container'>
                <div className='row pt-2 pb-2 px-sm-0 px-2 align-middle'>
                    <div className='col-sm-6 col-7 my-auto text-start d-flex'>
                        <div>
                            <img src='assets/img/emblem_white.png' alt='Ind Emblem'/>
                        </div>
                        <span className='ms-2 my-auto'>Ministry of Health and Family Welfare</span>
                    </div>
                    <div className='col-sm-6 col-5 my-auto'>
                        <div className='row'>
                            <div className='col-lg-9 col-sm-6 col-12 text-right pe-md-0 my-auto'>
                                FAQ | <TelephoneFill className='ms-1'/> 1075 | English
                            </div>
                            <div className='col-lg-3 col-sm-6 d-none d-sm-block pl-1 my-auto'>
                                 | 
                                {/* <button className='btn btn-warning ml-2 px-2 py-1 rounded-0'>A+</button>
                                <button className='btn btn-warning ml-2 px-2 py-1 rounded-0'>A</button>
                                <button className='btn btn-warning ml-2 px-2 py-1 rounded-0'>A-</button> */}
                                <button className='btn btn-warning ml-2 px-2 py-1'>A+</button>
                                <button className='btn btn-warning ml-2 px-2 py-1'>A</button>
                                <button className='btn btn-warning ml-2 px-2 py-1'>A-</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    )
}

const Header = () => {
    return (
        <>
            {FunctionalHeader()}
            {MainHeader()}
        </>
    )
}

export default Header
