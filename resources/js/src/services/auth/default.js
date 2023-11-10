import axios from 'axios';
class defaultservice{
    constructor(baseuri) {  // Constructor
        this.baseuri = baseuri;
    }
	getlist(params){
		return axios.get(`/api/${this.baseuri}${params ?? ''}`)
		.then(function (response) {
			return response.data;
		})
		.catch(function (error) {
			return error;
		});
	}
    async create(formData){
        var res = await axios.post('/api/'+this.baseuri,formData).then(function(e){
            return {status: 1, data: e.data.data}
        }).catch(function(e){
            return {status: 0, data: e.response.data.errors};
        });
        return res;
    }
    delete({query,id}){
		return axios.delete(`/api/${this.baseuri}/${id}`);
	}
    get(id){
		return axios.get(`/api/${this.baseuri}/${id}`).then(e=>e.data.data);
	}
    getProductData(brand_id,item_type_id){
		return axios.get(`/api/${this.baseuri}/${brand_id}/${item_type_id}`)
        .then(function (response) {
			return response.data;
		})
		.catch(function (error) {
			return error;
		});
	}
    async update(formData, id){
		formData.append('_method','put')
		var res = await  axios.post('/api/'+this.baseuri+'/'+id,formData).then(function(e){
            return {status: 1, data: e.data.data}
        }).catch(function(e){
            return {status: 0, data: e.response.data.errors};
        });
        return res;
	}

	async getQrcode(params){
		return  await axios({
			url: '/api/'+this.baseuri,
			method: 'GET',
			responseType: 'text/plain',
		  }).then(function (response) {
			return response.data;
		})
	}
}
export default defaultservice;