export const changeHash =(fullhash)=>{
    return{
        type:'CHANGE_HASH',
        payload:fullhash
    }
}
export const getHash =()=>{
    return{
        type:'GET_HASH'
    }
}