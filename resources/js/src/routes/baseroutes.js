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
        path: '/skills/',
        name: 'auth.skills',
        component: () => import('../views/Skill/Main.vue'),
        children: [
            {
                path: '',
                component: () => import('../views/Skill/List.vue'),
                name: 'auth.skills.listing'
            },
            {
                path: 'add',
                component: () => import('@/views/Skill/Form.vue'),
                name: 'auth.skills.add'
            },
            {
                path: 'edit/:id',
                component: () => import('@/views/Skill/Form.vue'),
                name: 'auth.skills.edit'
            }
        ],
    },
    {
        path: '/education/',
        name: 'auth.education',
        component: () => import('../views/Education/Main.vue'),
        children: [
            {
                path: '',
                component: () => import('../views/Education/List.vue'),
                name: 'auth.education.listing'
            },
            {
                path: 'add',
                component: () => import('@/views/Education/Form.vue'),
                name: 'auth.education.add'
            },
            {
                path: 'edit/:id',
                component: () => import('@/views/Education/Form.vue'),
                name: 'auth.education.edit'
            }
        ],
    },
    {
        path: '/tasks/',
        name: 'auth.tasks',
        component: () => import('../views/Task/Main.vue'),
        children: [
            {
                path: '',
                component: () => import('../views/Task/List.vue'),
                name: 'auth.tasks.listing'
            },
            {
                path: 'add',
                component: () => import('@/views/Task/Form.vue'),
                name: 'auth.tasks.add'
            },
            {
                path: 'edit/:id',
                component: () => import('@/views/Task/Form.vue'),
                name: 'auth.tasks.edit'
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
        path: '/proposals/',
        name: 'auth.proposals',
        component: () => import('../views/Proposal/Main.vue'),
        children: [
            {
                path: '',
                component: () => import('../views/Proposal/List.vue'),
                name: 'auth.proposals.listing'
            },
            {
                path: 'add',
                component: () => import('@/views/Proposal/Form.vue'),
                name: 'auth.proposals.add'
            },
            {
                path: 'edit/:id',
                component: () => import('@/views/Proposal/Form.vue'),
                name: 'auth.proposals.edit'
            }
        ],
    },
    {
        path: '/profiles/',
        name: 'auth.profiles',
        component: () => import('../views/Profile/Form.vue'),
    },

]