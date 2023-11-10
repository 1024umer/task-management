import { defineAsyncComponent } from 'vue'
export default [
    {
        path: '/dashboard',
        name: 'auth.panel',
        component: () => import('@/views/Panel.vue'),
    },
    {
        path: '/roles/',
        name: 'auth.roles',
        component: () => import('../views/Role/Main.vue'),
        children: [
            {
                path: '',
                component: () => import('../views/Role/List.vue'),
                name: 'auth.roles.listing'
            },
            {
                path: 'add',
                component: () => import('@/views/Role/Form.vue'),
                name: 'auth.roles.add'
            },
            {
                path: 'edit/:id',
                component: () => import('@/views/Role/Form.vue'),
                name: 'auth.roles.edit'
            }
        ],
    },
    
    {
        path: '/users/',
        name: 'auth.users',
        component: () => import('../views/User/Main.vue'),
        children: [
            {
                path: '',
                component: () => import('../views/User/List.vue'),
                name: 'auth.users.listing'
            },
            {
                path: 'add',
                component: () => import('@/views/User/Form.vue'),
                name: 'auth.users.add'
            },
            {
                path: 'edit/:id',
                component: () => import('@/views/User/Form.vue'),
                name: 'auth.users.edit'
            }
        ],
    },
    {
        path: '/profiles/',
        name: 'auth.profiles',
        component: () => import('../views/Profile/Form.vue'),
    },
    {
        path: '/upload-video/',
        name: 'auth.uploadvideo',
        component: () => import('../views/Profile/UploadVideo.vue'),
    },
]