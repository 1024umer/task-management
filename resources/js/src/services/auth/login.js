import axios from 'axios';
class loginservice{
	dologin(email,pass){
		return axios.post(`/api/login`, {
			email: email,
			password: pass
		})
		.then(function (response) {
			return {status: 1, data: response.data};
		})
		.catch(function (error) {
			var data = error.response.data;
			var msg = '';
			if(data.message){
				msg = data.message;
			}
			if(data.errors){
				msg = data.errors.join(', ');
			}
			return {status: 0,data: msg};
		});
	}
	me(){
		return axios.get('/api/me').then(function(response){
			return response.data;
		})
	}
	async updateProfile(formData){
		formData.append('_method','put')
		var res = await  axios.post('/api/updateprofile',formData).then(function(e){
            return {status: 1, data: e.data.data}
        }).catch(function(e){
            return {status: 0, data: e.response.data.errors};
        });
        return res;
	}
}

export default new loginservice();