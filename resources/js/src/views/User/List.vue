<template>
    <v-row>
        <v-col>
            <v-breadcrumbs :items="breadcrumbs">
                <template v-slot:prepend>
                    <v-icon size="small" icon="mdi-home-city"></v-icon>
                </template>
                <template v-slot:divider>
                    <v-icon>mdi-forward</v-icon>
                </template>
            </v-breadcrumbs>
        </v-col>
        <v-col sm="6" lg="3" md="3">
            <div class="add-excel-btn">
                <v-btn  class="add-user" link :to="{ name: 'auth.users.add' }">Add User</v-btn>
                <v-btn @click="exportToXLSX" class="export-excel">Export to XLSX</v-btn>
            </div>
        </v-col>
        <v-col cols="12">
            <v-row>
                <v-col>
                    <v-text-field v-model="search" label="Search" single-line hide-details></v-text-field>
                </v-col>
                <v-col>
                    <v-select item-title="title" item-value="id" label="Roles" :items="roles" v-model="role_id"></v-select>
                </v-col>
                <v-col>
                    <v-select item-title="text" item-value="keyt" label="City" :items="cities" v-model="city"></v-select>
                </v-col>
            </v-row>
            <v-data-table-server :hover="true" class="table-list" v-model:items-per-page="itemsPerPage" :headers="headers" :items-length="totalItems"
                :items="serverItems" :loading="loading" item-value="id" loading-text="Loading"
                @update:options="loadItems">
                <template v-slot:item.role_id="{ item }">
                    {{ item.selectable.role.title }}
                </template>
                <template v-slot:item.city="{ item }">
                    <span class="text-capitalize">{{ item.selectable.city }}</span>
                </template>
                <template v-slot:item.video_time="{ item }">
                    <template v-if="item.selectable.video">{{ item.selectable.video.created_at_formatted }}</template>
                    <v-btn density="compact" v-else color="#FFE600"  size="small" class="text-black" >N/A</v-btn>
                </template>
                <template v-slot:item.own_mg="{ item }">
                    <div
                        :class="{ 'green-background': item.selectable.own_mg === 1, 'red-background': item.selectable.own_mg !== 1 }">
                        {{ item.selectable.own_mg === 1 ? 'Yes' : 'No' }}
                    </div>
                </template>
                <template v-slot:item.id="{ item }">
                    <v-avatar  density="compact" size="32" style="border:1px solid #00000024;">
                        <v-img class="user-img-avt" :src="item.selectable.image_url" alt="Avatar"></v-img>
                    </v-avatar>
                </template>
                <template v-slot:item.video_url="{ item }">
                    <v-btn  v-if="item.selectable.video_url" size="small" class="text-white" color="#AD025A" @click="gotoVideo(item.selectable.video_url)">Play Video</v-btn>
                    <v-btn density="compact" v-else color="#FFE600"  size="small" class="text-black" >N/A</v-btn>
                    <a  v-if="item.selectable.video" @click="download(item.selectable.video.full_url)" :href="item.selectable.video.full_url " download>
                        <v-icon color="#000">mdi-download</v-icon>
                    </a>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn variant="text" density="compact" class="mr-2" link :to="{ name: 'auth.users.edit', params: { id: item.selectable.id } }" color="info"  size="small"
                        icon="mdi-pencil-plus"></v-btn>
                    <v-btn variant="text" density="compact" @click="deleteItem(item.selectable.id)" color="error" size="small" icon="mdi-delete-outline"></v-btn>
                </template>
            </v-data-table-server>
        </v-col>
    </v-row>
</template>
<script>
import service from "@services/auth/default";
const itemtypeservice = new service('users')
const categoryservice = new service('roles')
import * as XLSX from 'xlsx';

import Swal from "sweetalert2";
export default {
    data() {
        return {
            roles: [],
            role_id: 0,
            city: '',
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
                    disabled: true,
                    to: { name: "auth.users.listing" },
                },
            ],
            serverItems: [],
            totalItems: 0,
            loading: false,
            itemsPerPage: 10,
            search: '',
            headers: [
                {
                    title: "",
                    align: "start",
                    sortable: true,
                    key: "id",
                },
                {
                    title: "Email",
                    align: "start",
                    sortable: true,
                    key: "email",
                },
                {
                    title: "Name",
                    align: "start",
                    sortable: true,
                    key: "name",
                },
                {
                    title: "Own MG HS",
                    align: "center",
                    sortable: true,
                    key: "own_mg",
                },
                {
                    title: "CNIC",
                    align: "start",
                    sortable: true,
                    key: "cnic",
                },
                {
                    title: "City",
                    align: "start",
                    sortable: true,
                    key: "city",
                },
                {
                    title: "Phone",
                    align: "start",
                    sortable: false,
                    key: "phone",
                },
                {
                    title: "Video",
                    align: "start",
                    sortable: false,
                    key: "video_url",
                },
                {
                    title: "Time of Upload",
                    align: "start",
                    sortable: false,
                    key: "video_time",
                },
                {
                    title: "Actions",
                    sortable: false,
                    key: "actions",
                },
            ]
        }
    },
    methods: {
            exportToXLSX() {
            const modifiedServerItems = [...this.serverItems];
            modifiedServerItems.forEach(item => {
                if (item.video === null) {
                    item.video_url = "No Video";
                }
            });
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.json_to_sheet(modifiedServerItems);
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

            const binaryData = XLSX.write(wb, {
                bookType: 'xlsx',
                bookSST: false,
                type: 'binary',
            });
            const blob = new Blob(
                [this.binaryConversion(binaryData)],
                { type: 'application/octet-stream' }
            );
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'list.xlsx';
            a.click();
        },
        binaryConversion(data) {
            const buf = new ArrayBuffer(data.length);
            const view = new Uint8Array(buf);
            for (let i = 0; i < data.length; i++) {
                view[i] = data.charCodeAt(i) & 0xFF;
            }
            return buf;
        },
        downlaod(url){
            window.location.href = url;
        },
        gotoVideo(url){
            window.open(url, "_blank");
        },
        async loadItems({ page, itemsPerPage, sortBy }) {
            this.loading = true;
            this.serverItems = []
            var query = "";
            query += "?page=" + page;
            try {
                if (sortBy.length > 0) {
                    query += "&sortCol=" + sortBy[0].key;
                    query += "&sortByDesc=" + sortBy[0].order;
                }
            } catch (ex) { }
            query += "&perpage=" + itemsPerPage;
            if (this.search != "") {
                query += "&search=" + this.search;
            }
            if(this.role_id>0){
                query += "&role_id=" + this.role_id;
            }
            if(this.city){
                query += "&city=" + this.city;
            }
            const data = await itemtypeservice.getlist(query);
            this.serverItems = data.data;
            try {
                this.totalItems = data.meta.total;
            } catch (ex) {
                this.totalItems = 0
            }
            this.loading = false;
        },
        async deleteItem(id) {
            const isConfirmed = await Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    return true;
                }
            });
            if (isConfirmed) {
                await itemtypeservice.delete({
                    id: id,
                });
                Swal.fire("Deleted!", "Your record has been deleted.", "success");
                this.loadItems({ page: 1, itemsPerPage: 10 });
            }
        },
        async downlaod(item){

        },
    },
    watch: {
        $route() {
            this.loadItems({ page: 1, itemsPerPage: 10 });
        },
        itemsPerPage() {
            this.loadItems({ page: 1, itemsPerPage: 10 });
        },
        search() {
            this.loadItems({ page: 1, itemsPerPage: 10 });
        },
        role_id(){
            this.loadItems({ page: 1, itemsPerPage: 10 });
        },
        city(){
            this.loadItems({ page: 1, itemsPerPage: 10 });
        }
    },
    async mounted() {
        const roles = await categoryservice.getlist('').then(e=>e.data)
        this.roles = [{id: 0, title: 'All'}, ...roles]
        this.loadItems({ page: 1, itemsPerPage: 10 });
    },
    computed:{
        cities(){
            return [
                {
                    keyt: '',
                    text: 'All'
                },
                ...this.$store.getters.getCities
            ];
        }
    }
}
</script>