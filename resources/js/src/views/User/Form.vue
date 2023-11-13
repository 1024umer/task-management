<template>
    <v-row>
        <v-col cols="12">
            <v-breadcrumbs :items="breadcrumbs">
                <template v-slot:prepend>
                    <v-icon size="small" icon="mdi-home-city"></v-icon>
                </template>
                <template v-slot:divider>
                    <v-icon>mdi-forward</v-icon>
                </template>
            </v-breadcrumbs>
        </v-col>
        <v-col cols="12">
            <form @submit.prevent="submit">
                <v-row>
                    <v-col class="text-center" cols="12">
                        <v-avatar size="200px" v-if="form.id>0">
                            <v-img alt="Avatar" :src="form.thumbnail_url"></v-img>
                        </v-avatar>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            v-model="form.name"
                            :counter="255"
                            label="First Name"
                            required
                            :error-messages="errors.name"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            v-model="form.cnic"
                            label="CNIC"
                            required
                            :error-messages="errors.cnic"
                            @input="formatCNIC"
                            maxlength="15"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            v-model="form.dob"
                            label="DOB"
                            type="date"
                            required
                            :error-messages="errors.dob"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            v-model="form.email"
                            :counter="255"
                            label="Email"
                            required
                            :error-messages="errors.email"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            v-model="form.password"
                            label="Password"
                            type="password"
                            :error-messages="errors.password"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            v-model="form.phone"
                            label="Phone"
                            required
                            :error-messages="errors.phone"
                            @input="formatPhone"
                            maxlength="14"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-select :error-messages="errors.city" item-title="text" item-value="keyt" label="City" :items="cities" v-model="form.city"></v-select>
                    </v-col>
                    <v-col cols="6">
                        <v-file-input
                            v-model="form.image"
                            :counter="255"
                            label="Profile Image"
                            required
                            :error-messages="errors.image"
                            @change="onFileChange"
                        ></v-file-input>
                    </v-col>
                    <v-col cols="6">
                        <v-select :error-messages="errors.role_id" item-title="title" item-value="id" label="Role" :items="roles" v-model="form.role_id"></v-select>
                    </v-col>
                    <v-col cols="3">
                        <v-checkbox v-model="form.own_mg" label="Do you Own an MG-HS"></v-checkbox>
                    </v-col>
                    <v-col cols="12">
                        <v-btn @click="insertRecord" :disabled="loading" :loading="loading" :loading-text="(form.id>0?'Updating':'Inserting')" class="insert-record-btn">{{ form.id>0?'Update':'Insert' }} Record</v-btn>
                    </v-col>
                </v-row>
            </form>
        </v-col>
    </v-row>
</template>
<script>
import service from "@services/auth/default";
const itemtypeservice = new service('users')
const rolesservice = new service('roles')
import Swal from "sweetalert2";
export default {
    data() {
        return {
            roles: [],
            breadcrumbs: [
                {
                    title: 'Dashboard',
                    to: { name: "auth.panel" },
                    disabled: false,
                    exact: true,
                },
                {
                    title: 'Users',
                    exact: true,
                    disabled: false,
                    to: { name: "auth.users.listing" },
                },
            ],
            form: {
                role_id: '',
                name: '',
                dob: '',
                cnic: '',
                email: '',
                password: '',
                thumbnail_url: '',
                image: '',
                city: '',
                phone: '',
                own_mg:true,
                id: 0,
            },
            loading: false,
            errors: {
                role_id: [],
                dob: [],
                cnic: [],
                name: [],
                email: [],
                password: [],
                thumbnail: [],
                city: [],
                phone: [],
                own_mg:[],
            }
        }
    },
    methods: {
        formatCNIC() {
            const cleanedValue = this.form.cnic.replace(/\D/g, '');
            this.form.cnic = cleanedValue.substring(0, 13).replace(/^(\d{5})(\d{7})(\d{1})$/, '$1-$2-$3'); 
        },
        formatPhone() {
            const cleanedValue = this.form.phone.replace(/\D/g, '');
            this.form.phone = cleanedValue.substring(0, 12) .replace(/(\d{2})(\d{3})(\d{7})/, '+$1 $2 $3');
        },
        async insertRecord(){
            this.resetErrors()
            this.loading = true
            var formData = new FormData();
            formData.append('name', this.form.name);
            formData.append('dob', this.form.dob);
            formData.append('cnic', this.form.cnic);
            formData.append('email', this.form.email);
            formData.append('role_id', this.form.role_id);
            formData.append('city', this.form.city);
            formData.append('phone', this.form.phone);
            formData.append('own_mg', (this.form.own_mg == true ? 1 : 0));
            if(this.form.thumbnail){
                formData.append('thumbnail', this.form.thumbnail);
            }
            if (this.form.id > 0) {
                formData.append('id', this.form.id);
                if(this.form.password!=''){
                    formData.append('password', this.form.password);
                }
                var res = await itemtypeservice.update(formData, this.form.id)
            } else {
                formData.append('password', this.form.password);
                var res = await itemtypeservice.create(formData)
            }
            if (!res.status) {
                if (res.data.name) {
                    this.errors.name = res.data.name
                }
                if (res.data.dob) {
                    this.errors.dob = res.data.dob
                }
                if (res.data.cnic) {
                    this.errors.cnic = res.data.cnic
                }
                if (res.data.email) {
                    this.errors.email = res.data.email
                }
                if (res.data.role_id) {
                    this.errors.role_id = res.data.role_id
                }
                if (res.data.thumbnail) {
                    this.errors.thumbnail = res.data.thumbnail
                }
                if (res.data.password) {
                    this.errors.password = res.data.password
                }
                if (res.data.city) {
                    this.errors.city = res.data.city
                }
                if (res.data.phone) {
                    this.errors.phone = res.data.phone
                }
            } else {
                Swal.fire("Inserted!", "Your record has been inserted.", "success");
                this.$router.push({ name: "auth.users.listing" });
            }
            this.loading = false
        },
        onFileChange(event) {
            this.form.thumbnail = event.target.files[0];
        },
        resetErrors(){
            this.errors = {
                role_id: [],
                name: [],
                email: [],
                password: [],
                thumbnail: [],
                dob:[],
                cnic:[],
                city: [],
                phone: [],
            }
        }
    },
    watch: {
        
    },
    async mounted() {
        this.roles = await rolesservice.getlist('').then(e=>e.data)
        if (this.$route.params.id) {
            this.form.id = this.$route.params.id
            this.breadcrumbs.push({
                title: 'Edit',
                exact: true,
                disabled: true,
                to: { name: "auth.users.add", params: { id: this.$route.params.id } },
            })
            var res = await itemtypeservice.get(this.$route.params.id)
            this.form = {
                name: (res.name ? res.name : ''),
                cnic: (res.cnic ? res.cnic : ''),
                dob: (res.dob ? res.dob : ''),
                email: (res.email ? res.email : ''),
                phone: (res.phone ? res.phone : ''),
                city: (res.city ? res.city : ''),
                role_id: (res.role_id ? res.role_id : ''),
                own_mg: (res.own_mg == 0 ? false : true),
                id: this.$route.params.id,
                thumbnail_url: res.image_url 
            }
        }else{
            this.breadcrumbs.push({
                title: 'Add',
                exact: true,
                disabled: true,
                to: { name: "auth.users.add" },
            })
        }
    },
    computed:{
        cities(){
            return this.$store.getters.getCities;
        }
    }
}
</script>