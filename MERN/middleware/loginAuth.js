const jwt = require('jsonwebtoken')
const config = require('config')

module.exports = function(req,res,next){

    // get token from header
    const token = req.header('x-loginAuth-token');

    // check if no token
    if(!token){
        return res.status(401).json({msg:'No token, Authorization denied'});
    }

    // verify token
    try{
        //decoding token and fetching id from token 
        const decoded = jwt.verify(token,config.get('jwtSecret'));
        req.register = decoded.register;
        next();
    } catch {
        res.status(401).json({msg:"Token is not valid"});
    }
}