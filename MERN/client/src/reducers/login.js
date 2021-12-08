const initialState = {
    fullHash:'',
    mobile:''
}
const login = (state=initialState,action) =>{
    switch(action.type){
        case 'CHANGE_HASH':
            state = action.payload;
        case 'GET_HASH':
            return state;
        default:
            return state;
    }
}

export default login