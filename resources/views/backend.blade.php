<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Portal </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<style>
.main-bg{    
    /* background: #fff; */
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 100% 20%;
}
.main-bg img{
    width: 100%;
}
.card-main{

}
</style>
<body>
    <div id="app">
        <v-app v-if="loggedIn">
            <v-main>
                <headercomponent></headercomponent>
                <newbar></newbar>
                <v-row class="mt-5" no-gutters>
                    <v-col :cols="12">
                        <v-card :elevation="(isPanelFull === true ? '0' : '1')"
                            :class="(isPanelFull === true ? 'transparent ma-3 pa-2 ' : 'main-background ma-3 pa-2')">
                            <router-view />
                        </v-card>
                    </v-col>
                </v-row>
            </v-main>
        </v-app>
        <v-app v-else>
            <v-main class="main-bg">
                <v-container class="h-100">
                    <v-row class="h-100 align-center justify-center">
                        <v-col cols="6" class="login-container-main">
                            <div class="text-center text-white">
                                <img style="width: 150px;" src="{{url('images/logo.png')}}" />
                            </div>
                            <v-card class="height-100vh card-main">
                                <router-view />
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </v-app>
        <notifications :notificaitontext="notificaitontext" :notificaitonstatus="notificaitonstatus" />
    </div>
    @vite('resources/js/app.js')
</body>

</html>