<template>
    <v-row class="px-5">
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
                    <v-col cols="12" sm="12" md="6" lg="6">
                        <v-text-field
                            v-model="form.name"
                            :counter="255"
                            label="Name"
                            required
                            :error-messages="errors.name"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="6" lg="6">
                        <v-text-field
                            v-model="form.email"
                            :counter="255"
                            label="Email"
                            required
                            :error-messages="errors.email"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="6" lg="6">
                        <v-text-field
                            v-model="form.cnic"
                            :counter="255"
                            label="CNIC"
                            required
                            :error-messages="errors.cnic"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="6" lg="6">
                        <v-text-field
                            v-model="form.address"
                            :counter="255"
                            label="Address"
                            required
                            :error-messages="errors.address"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="6" lg="6">
                        <v-text-field
                            v-model="form.dob"
                            label="DOB"
                            type="date"
                            required
                            :error-messages="errors.dob"
                        ></v-text-field>
                    </v-col>
                    <v-col  cols="12" sm="12" md="6" lg="6">
                        <v-text-field
                            v-model="form.password"
                            label="Password"
                            type="password"
                            :error-messages="errors.password"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="6" lg="6">
                        <v-text-field
                            v-model="form.phone"
                            label="Phone"
                            required
                            :error-messages="errors.phone"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="6" lg="6">
                        <v-select :error-messages="errors.city" item-title="text" item-value="keyt" label="City" :items="cities" v-model="form.city"></v-select>
                    </v-col>
                    <v-col  cols="12" sm="12" md="6" lg="6">
                        <v-file-input
                            v-model="form.image"
                            :counter="255"
                            label="Profile Picture"
                            required
                            :error-messages="errors.image"
                            @change="onFileChange"
                        ></v-file-input>
                        <div v-if="res && res.image">
                            <v-img height="25%" width="25%" alt="Avatar" :src="res.image_url"></v-img>
                        </div>
                    </v-col>
                    <v-col cols="12">
                        <v-btn class="update-record" @click="insertRecord" :disabled="loading" :loading="loading" :loading-text="(form.id>0?'Updating':'Inserting')" >{{ form.id>0?'Update':'Insert' }} Record</v-btn>
                    </v-col>
                </v-row>
            </form>
        </v-col>
    </v-row>
</template>
<script>
import service from "@services/auth/default";
const itemtypeservice = new service('profiles')
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
            ],
            form: {
                name: '',
                email: '',
                password: '',
                cnic:'',
                dob:'',
                address:'',
                image: [],
                city: '',
                phone: '',
                id: 0,
            },
            loading: false,
            errors: {
                name: [],
                email: [],
                password: [],
                image: [],
                cnic:[],
                dob:[],
                address:[],
                city: [],
                phone: [],
            }
        }
    },
    methods: {
        async insertRecord() {
            this.resetErrors();
            this.loading = true;
            var formData = new FormData();
            formData.append('name', this.form.name);
            formData.append('email', this.form.email);
            formData.append('dob', this.form.dob);
            formData.append('address', this.form.address);
            formData.append('cnic', this.form.cnic);
            formData.append('city', this.form.city);
            formData.append('phone', this.form.phone);
            if (this.form.id > 0) {
                formData.append('id', this.form.id);
            }
            const passwordValue = this.form.password !== undefined ? this.form.password : '';
            if (passwordValue !== '') {
                formData.append('password', passwordValue);
            }
            if (this.form.image && this.form.image.length > 0) {
                formData.append('image', this.form.image[0]);
            }

            try {
                var res = await itemtypeservice.update(formData, this.form.id);
                if (!res.status) {
                    if (res.data.name) {
                        this.errors.name = res.data.name;
                    }
                    if (res.data.email) {
                        this.errors.email = res.data.email;
                    }
                    if (res.data.image) {
                        this.errors.image = res.data.image;
                    }
                    if (res.data.password) {
                        this.errors.password = res.data.password;
                    }
                    if (res.data.cnic) {
                        this.errors.cnic = res.data.cnic;
                    }
                    if (res.data.address) {
                        this.errors.address = res.data.address;
                    }
                    if (res.data.dob) {
                        this.errors.dob = res.data.dob;
                    }
                    if (res.data.city) {
                        this.errors.city = res.data.city;
                    }
                    if (res.data.phone) {
                        this.errors.phone = res.data.phone;
                    }
                } else {
                    location.reload()
                }
            } catch (error) {
                console.error(error);
            }

            this.loading = false;
        },
        onFileChange(event) {
            this.form.thumbnail = event.target.files[0];
        },
        resetErrors() {
            this.errors = {
                name: [],
                email: [],
                password: [],
                image: [],
                cnic:[],
                address:[],
                dob:[],
                city: [],
                phone: [],
            };
        }
    },
    watch: {
        
    },
    async mounted() {
    try {
        const res = await itemtypeservice.get();
        this.res = res;
        this.form = {
            name: (res.name ? res.name : ''),
            phone: (res.phone ? res.phone : ''),
            city: (res.city ? res.city : ''),
            email: (res.email ? res.email : ''),
            cnic: (res.cnic ? res.cnic : ''),
            dob: (res.dob ? res.dob : ''),
            address: (res.address ? res.address : ''),
            role_id: (res.role_id ? res.role_id : ''),
            id: (res.id ? res.id : 0),
        };

        if (this.form.id > 0) {
            this.breadcrumbs.push({
                title: 'Profile',
                exact: true,
                disabled: true,
            });
        } 
    } catch (error) {
        console.error(error);
    }
    },
    computed:{
        cities(){
            return this.$store.getters.getCities
        }
    }
}
</script>