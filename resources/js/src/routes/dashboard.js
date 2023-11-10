export default [
	{
        path: '/',redirect: { name: 'auth.login' }
    },
    {
        path: '/login',
        name: 'auth.login',
        component: () => import('@/views/Auth/Login.vue'),
    }
];