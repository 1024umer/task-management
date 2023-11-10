import axios from 'axios';
class otherrequestservice{
	get(uri){
		return axios.get(`/api/${uri}`)
		.then(function (response) {
			return response;
		})
		.catch(function (error) {
			return error;
		});
	}
	post(uri, formData){
		return axios.post(`/api/${uri}`, formData)
		.then(function (response) {
			return response;
		})
		.catch(function (error) {
			return error;
		});
	}
	delete(uri){
		return axios.delete(`/api/${uri}`).then(function (response) {
			return response;
		})
		.catch(function (error) {
			return error;
		});
	}
	async create(uri, formData){
        var res = await axios.post('/api/'+uri,formData).then(function(e){
            return {status: 1, data: e.data.data}
        }).catch(function(e){
            return {status: 0, data: e.response.data.errors};
        });
        return res;
    }
}
export default new otherrequestservice();