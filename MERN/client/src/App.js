import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import './App.css';
import Home from './pages/Home';
import Login from './pages/Login';
import VerifyOTP from './pages/VerifyOTP';
import Members from './pages/Members';

function App() {
    return (
        <Router>
            <Switch>
                <Route exact path='/'>
                    <Home />
                </Route>
                <Route exact path='/Login'>
                    <Login />
                </Route>
                <Route exact path='/VerifyOTP'>
                    <VerifyOTP />
                </Route>
                <Route exact path='/Members'>
                    <Members/>
                </Route>
            </Switch>
        </Router>
    );
}

export default App;