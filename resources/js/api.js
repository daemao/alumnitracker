import axios from "axios";


export const get =  (_this,url,data,success,error)=>{
    console.log(data);
    let headers = _this.$auth.getToken() ? { 'Authorization': `Bearer ${_this.$auth.getToken()}` } : '';
    axios({method:"GET",url,params:data,headers})
        .then((res)=>success(res))
        .catch(err => error(err))
}


export const post =  (_this,url,data,success,error)=>{
    let headers = _this.$auth.getToken() ? { 'Authorization': `Bearer ${_this.$auth.getToken()}` } : '';
    axios({method:"POST",url,data,headers})
        .then((res)=>success(res))
        .catch(err => error(err))
}
