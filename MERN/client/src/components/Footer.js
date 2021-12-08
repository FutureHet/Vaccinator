import '../css/Footer.css'
import {Envelope} from 'react-bootstrap-icons'

const MainFooter = () => {
    return(
        <div className='main_footer fixed-bottom footer'>
            <div className="container py-2">
                <div className="row">
                    <div className="col-lg-4 col-12 text-lg-start text-center">
                        For Grievances & Feedback : <Envelope className='ms-2 me-1'/> support@cowin.gov.in
                    </div>
                    <div className="col-lg-4 col-12 text-center ">
                        Privacy Policy | Terms of Service
                    </div>
                    <div className="col-lg-4 col-12 text-center text-lg-end">
                        Copyright &copy; 2021 COWIN. All Rights Reserved
                    </div>
                </div>
            </div>
        </div>
    )
}

const Footer = () => {
    return MainFooter()
}

export default Footer